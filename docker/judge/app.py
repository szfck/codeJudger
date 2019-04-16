from multiprocessing import Process
from flask import Flask, request
from flaskext.mysql import MySQL
from flask_cors import CORS
import subprocess
import yaml
import json

app = Flask(__name__)
CORS(app)

mysql = MySQL()
 
# MySQL configurations
app.config['MYSQL_DATABASE_USER'] = 'root'
app.config['MYSQL_DATABASE_PASSWORD'] = '123456'
app.config['MYSQL_DATABASE_DB'] = 'judger'
app.config['MYSQL_DATABASE_HOST'] = 'judger-db'
mysql.init_app(app)

ROOT_PATH = '/judge'
PROBLEM_ROOT = ROOT_PATH + '/problems'

def read_problem_config(problem):
    config_path = '{}/{}/config.yml'.format(PROBLEM_ROOT, problem)
    with open(config_path, 'r') as stream:
        try:
            config = yaml.safe_load(stream)
            return config
        except yaml.YAMLError as exc:
            print(exc)

supported_file_types = ['cpp', 'py', 'java']

PENDING = 'Pending'
ACCEPTED = 'Accepted'
WRONG_ANSWER = 'Wrong Answer'
COMPILE_ERROR = 'Compile Error'
TIME_LIMIE_EXCEED = 'Time Limit Exceed'
RUN_TIME_ERROR = 'Runtime Error'
UNKNOWN_ERROR = 'Unknown Error'

TIMEOUT_CODE=124

def read_file(path):
    return open(path, 'r').read()

def is_diff(path1, path2):
    process = subprocess.run('diff {} {}'.format(path1, path2), shell=True)
    return True if process.returncode != 0 else False

def judge(user_id, sub_id, file_type, problem):
    ''' Judge submission file
    Args:
        user_id: user id
        sub_id: submission id
        file_type: file type
        problem: problem name
    Return:
        Judging result
    '''
    config = read_problem_config(problem)

    time_limit = config['timelimit']
    case_num = config['testcase']

    print('judging problem: {}, sub_id: {}, user_id: {}, file_tpye: {}'.format(problem, sub_id, user_id, file_type))

    correct_num = 0
    secret_case_path = '{}/problems/{}/secret'.format(ROOT_PATH, problem)
    user_path = '{}/submissions/{}'.format(ROOT_PATH, user_id)
    sub_path = '{}/{}.{}'.format(user_path, sub_id, file_type)
    error_path = '{}/{}.error'.format(user_path, sub_id)

    status = PENDING
    error = ''
    case_input = ''
    case_user_output = ''
    case_correct_output = ''

    for case in range(1, case_num + 1):
        input_path = '{}/{}.in'.format(secret_case_path, case)
        correct_output_path = '{}/{}.out'.format(secret_case_path, case)
        user_output_path = '/tmp/{}.out'.format(case)

        if file_type == 'cpp':
            run_cmd = '/tmp/a.out'
        elif file_type == 'java':
            run_cmd = 'java -cp /tmp Main'
        elif file_type == 'py':
            run_cmd = 'python {}'.format(sub_path)

        process = subprocess.run('timeout {} {} < {} 1> {} 2> {}'.format(time_limit, run_cmd, input_path, user_output_path, error_path), shell=True)

        case_input = read_file(input_path)
        case_user_output = read_file(user_output_path)
        case_correct_output = read_file(correct_output_path)

        if process.returncode == TIMEOUT_CODE: # time limit exceed
            status = TIME_LIMIE_EXCEED
            break
        elif process.returncode != 0: # runtime error
            status = RUN_TIME_ERROR
            error = read_file(error_path)
            break

        if is_diff(correct_output_path, user_output_path): # wrong answer
            status = WRONG_ANSWER
            break
        
        correct_num += 1
    
    if correct_num == case_num:
        status = ACCEPTED

    result = {
        'status': str(status),
        'total_case': str(case_num),
        'correct_case': str(correct_num),
        'error': str(error),
        'input': str(case_input),
        'user_output': str(case_user_output),
        'correct_output': str(case_correct_output)
    }
    
    return result

def update(sub_id, result):
    ''' update result in database
    Args:
        sub_id: submission id
        result: judge result
    '''

    conn = mysql.connect()
    cursor =conn.cursor()
    sql_update = 'UPDATE submission SET result=\'{}\' WHERE subid={}'.format(result, sub_id)
    print (sql_update)
    cursor.execute(sql_update)
    conn.commit();
    print ("sql: {} executed, result is: {}".format(sql_update, result))

def compile(user_id, sub_id, file_type):

    if file_type not in supported_file_types:
        return "Unsupport file type"

    user_path = '{}/submissions/{}'.format(ROOT_PATH, user_id)
    sub_path = '{}/{}.{}'.format(user_path, sub_id, file_type)
    ce_path = '{}/{}.ce'.format(user_path, sub_id)
    if file_type == 'cpp':
        process = subprocess.run('g++ -std=c++11 -o /tmp/a.out {} 2> {}'.format(sub_path, ce_path), shell=True) 
    elif file_type == 'java':
        process = subprocess.run('cp {} /tmp/Main.java && javac /tmp/Main.java 2> {}'.format(sub_path, ce_path), shell=True) 
    elif file_type == 'py':
        return ''
    
    return read_file(ce_path)

@app.route('/judge', methods=['GET'])
def judge_api():
    ''' Judge API
    Args:
        submission_id
    Return:
        Judge result
    '''

    conn = mysql.connect()
    cursor =conn.cursor()
    sub_id = request.args.get('submission_id')
    sql_query = 'SELECT * FROM submission WHERE subid={}'.format(sub_id)
    cursor.execute(sql_query)
    data = cursor.fetchone()
    if not data:
        return '[Fail] sql: {}'.format(sql_query)
    
    problem = data[2]
    user_id = str(data[3])
    file_type = data[4]
    file = '{}.{}'.format(sub_id, file_type)

    ce = compile(user_id, sub_id, file_type)
    if ce != '': # compile error
        result = {
            'status': COMPILE_ERROR,
            'error': ce,
        }
    else:
        config = read_problem_config(problem)
        result = judge(user_id, sub_id, file_type, problem)

    update(sub_id, result['status'])

    print ('result: {}'.format(result))
    result_path = '{}/submissions/{}/{}.json'.format(ROOT_PATH, user_id, sub_id)
    json_result = json.dumps(result, indent=4)

    with open(result_path, 'w') as fp:
        json.dump(result, fp)

    return json_result

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=3000)
