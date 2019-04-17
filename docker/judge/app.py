from multiprocessing import Process
from flask import Flask, request
from flaskext.mysql import MySQL
from flask_cors import CORS
from flask_socketio import SocketIO, send, emit
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

app.config['SECRET_KEY'] = 'secret!'
socketio = SocketIO(app)

ROOT_PATH = '/judge'
PROBLEM_ROOT = ROOT_PATH + '/problems'

supported_file_types = ['cpp', 'py3', 'py2', 'java']

# status
PENDING = 'Pending'
COMPILING = 'Compiling'
JUDGING = 'Judging'
ACCEPTED = 'Accepted'
WRONG_ANSWER = 'Wrong Answer'
COMPILE_ERROR = 'Compile Error'
TIME_LIMIE_EXCEED = 'Time Limit Exceed'
RUNTIME_ERROR = 'Runtime Error'
UNKNOWN_ERROR = 'Unknown Error'

TIMEOUT_CODE=124

class Submission:

    def __init__(self, sub_id = 0, time = 0, problem = '', user_id = 0, file_name = '', file_type = '', result = ''):
        self.sub_id = sub_id
        self.time = time 
        self.problem = problem 
        self.user_id = user_id 
        self.file_name = file_name 
        self.file_type = file_type 
        self.result = result 
    
    def __str__(self):
        return ', '.join([
            'sub_id : {}'.format(self.sub_id),
            'time : {}'.format(self.time),
            'problem : {}'.format(self.problem),
            'user_id : {}'.format(self.user_id),
            'file_name : {}'.format(self.file_name),
            'file_type : {}'.format(self.file_type),
            'result : {}'.format(self.result),
        ])

def read_file(path):
    return open(path, 'r').read()

def read_problem_config(problem):
    config_path = '{}/{}/config.yml'.format(PROBLEM_ROOT, problem)
    with open(config_path, 'r') as stream:
        try:
            config = yaml.safe_load(stream)
            return config
        except yaml.YAMLError as exc:
            print(exc)

def dict_to_json(dict_data):
    return json.loads(dict_to_json_str(dict_data))

def dict_to_json_str(dict_data):
    return json.dumps(dict_data, indent=4)

def write_data(path, data):
    with open(path, 'w') as f:
        f.write(data)

def is_diff(path1, path2):
    process = subprocess.run('diff {} {}'.format(path1, path2), shell=True)
    return True if process.returncode != 0 else False

def query_submission(sub_id):
    print (sub_id);
    conn = mysql.connect()
    cursor =conn.cursor()
    sql_query = 'SELECT * FROM submission WHERE subid={}'.format(sub_id)
    cursor.execute(sql_query)
    data = cursor.fetchone()
    if not data:
        print ('[Fail] sql: {}'.format(sql_query))
        return None

    sub = Submission(data[0], data[1], data[2], data[3], data[4], data[5], data[6])
    print (sub)
    return sub

def query_submission_result(sub):
    user_path = '{}/submissions/{}'.format(ROOT_PATH, sub.user_id)
    result_path = '{}/{}.json'.format(user_path, sub.sub_id)
    json_data = read_file(result_path)
    return json_data
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

def compile(sub):

    file_type = sub.file_type
    user_id = sub.user_id
    sub_id = sub.sub_id
    file_name = sub.file_name

    if file_type not in supported_file_types:
        return "Unsupport file type"

    user_path = '{}/submissions/{}'.format(ROOT_PATH, user_id)
    sub_path = '{}/{}'.format(user_path, file_name)
    ce_path = '{}/{}.ce'.format(user_path, sub_id)
    if file_type == 'cpp':
        process = subprocess.run('g++ -std=c++11 -o /tmp/a.out {} 2> {}'.format(sub_path, ce_path), shell=True) 
    elif file_type == 'java':
        process = subprocess.run('cp {} /tmp/Main.java && javac /tmp/Main.java 2> {}'.format(sub_path, ce_path), shell=True) 
    elif file_type == 'py2' or file_type == 'py3':
        return ''
    
    return read_file(ce_path)

def judge(sub, case_id, total_case, time_limit):
    ''' Judge submission file
    Args:
        sub: submission class
        case_id: current case id to be judged
        total_case: total case number
        time_limit: time limit to run
    Return:
        Judging result
    '''
    sub_id = sub.sub_id
    user_id = sub.user_id
    file_type = sub.file_type
    file_name = sub.file_name
    problem = sub.problem

    print ('juding case : {}'.format(case_id))
    # print('judging problem: {}, sub_id: {}, user_id: {}, file_tpye: {}, file_name: {}'.format(problem, sub_id, user_id, file_type, file_name))

    secret_case_path = '{}/problems/{}/secret'.format(ROOT_PATH, problem)
    user_path = '{}/submissions/{}'.format(ROOT_PATH, user_id)
    sub_path = '{}/{}'.format(user_path, file_name)
    error_path = '{}/{}.error'.format(user_path, sub_id)

    input_path = '{}/{}.in'.format(secret_case_path, case_id)
    correct_output_path = '{}/{}.out'.format(secret_case_path, case_id)
    user_output_path = '/tmp/{}.out'.format(case_id)

    if file_type == 'cpp':
        run_cmd = '/tmp/a.out'
    elif file_type == 'java':
        run_cmd = 'java -cp /tmp Main'
    elif file_type == 'py2':
        run_cmd = 'python2 {}'.format(sub_path)
    elif file_type == 'py3':
        run_cmd = 'python3 {}'.format(sub_path)

    status = JUDGING

    process = subprocess.run('timeout {} {} < {} 1> {} 2> {}'.format(time_limit, run_cmd, input_path, user_output_path, error_path), shell=True)

    case_input = read_file(input_path)
    case_user_output = read_file(user_output_path)
    case_correct_output = read_file(correct_output_path)
    error = read_file(error_path)

    if process.returncode == TIMEOUT_CODE: # time limit exceed
        status = TIME_LIMIE_EXCEED
    elif process.returncode != 0: # runtime error
        status = RUNTIME_ERROR
        error = read_file(error_path)
    elif is_diff(correct_output_path, user_output_path): # wrong answer
        status = WRONG_ANSWER
    else: # accepted
        if case_id == total_case:
            status = ACCEPTED
    
    result = {
        'status': str(status),
        'current_case': str(case_id),
        'total_case': str(total_case),
        'error': str(error),
        'input': str(case_input),
        'user_output': str(case_user_output),
        'correct_output': str(case_correct_output)
    }
    
    return result

@socketio.on('judge')
def judge_socket(sub_id):
    print ('start judge, sub id: {}'.format(sub_id))
    sub = query_submission(sub_id)

    sub_id = sub.sub_id
    user_id = sub.user_id
    problem = sub.problem

    FINISH_STATES = [COMPILE_ERROR, ACCEPTED, WRONG_ANSWER, RUNTIME_ERROR, TIME_LIMIE_EXCEED, UNKNOWN_ERROR]

    if sub.result in FINISH_STATES:
        result_json = query_submission_result(sub)
        emit('judge', json.loads(result_json))
    else:
        result_path = '{}/submissions/{}/{}.json'.format(ROOT_PATH, user_id, sub_id)
        config = read_problem_config(problem)

        time_limit = config['timelimit']
        case_num = config['testcase']

        emit('judge', dict_to_json({
            'status': COMPILING,
            'current_case': 0,
            'total_case': case_num,
        }))


        ce = compile(sub)
        if ce != '': # compile error
            result = {
                'status': COMPILE_ERROR,
                'current_case': 1,
                'total_case': case_num,
                'error': ce,
            }
            write_data(result_path, dict_to_json_str(result))
            update(sub_id, COMPILE_ERROR)
            emit('judge', dict_to_json(result))
        else:

            for case_id in range(1, case_num + 1):
                result = judge(sub, case_id, case_num, time_limit)
                emit('judge', dict_to_json(result))    
                            
                if result['status'] != JUDGING: # judge finish
                    write_data(result_path, dict_to_json_str(result))
                    update(sub_id, result['status'])
                    break

@socketio.on('connect')
def socket_connect_client():
    print('connect to client')

if __name__ == '__main__':
    socketio.run(app, host='0.0.0.0', port=3000)
