from multiprocessing import Process
from flask import Flask, request
from flaskext.mysql import MySQL
from flask_cors import CORS
from flask_socketio import SocketIO, send, emit
import subprocess
import yaml
import json, time, os

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
    ''' Transform python dict to json object
    Args:
        dict_data: python dict object
    Return:
        json object
    '''
    return json.loads(dict_to_json_str(dict_data))

def dict_to_json_str(dict_data):
    ''' Transform python dict to json string
    Args:
        dict_data: python dict object
    Return:
        json string
    '''
    return json.dumps(dict_data, indent=4)

def write_data(path, data):
    with open(path, 'w') as f:
        f.write(data)

def is_diff(path1, path2):
    ''' Compare two files
    Args:
        path1: path for first file
        path2: path for second file
    Return:
        True if two files are different, False otherwise
    '''

    process = subprocess.run('diff {} {}'.format(path1, path2), shell=True)
    return True if process.returncode != 0 else False

def query_submission(sub_id):
    ''' Query submission using submission id
    Args:
        sub_id: submission id
    Return:
        Submission class
    '''

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
    ''' Fetch json result
    Args:
        sub: Submission class
    Return:
        Result json string
    '''

    user_path = '{}/submissions/{}'.format(ROOT_PATH, sub.user_id)
    result_path = '{}/{}.json'.format(user_path, sub.sub_id)
    json_data = read_file(result_path)
    return json_data

def update(sub_id, result):
    ''' Update result in database
    Args:
        sub_id: submission id
        result: judge status string
    '''

    conn = mysql.connect()
    cursor =conn.cursor()
    sql_update = 'UPDATE submission SET result=\'{}\' WHERE subid={}'.format(result, sub_id)
    print (sql_update)
    cursor.execute(sql_update)
    conn.commit();
    print ("sql: {} executed, result is: {}".format(sql_update, result))

def compile(sub, tmp_dir):
    ''' Compile submission
    Args:
        sub: Submission class
    Return:
        Compile Error Output, empty string if no error
    '''

    file_type = sub.file_type
    user_id = sub.user_id
    sub_id = sub.sub_id
    file_name = sub.file_name

    if file_type not in supported_file_types:
        return "Unsupport file type"

    user_path = '{}/submissions/{}'.format(ROOT_PATH, user_id)
    sub_path = '{}/{}'.format(user_path, file_name)
    ce_path = '{}/ce'.format(tmp_dir)
    if file_type == 'cpp':
        process = subprocess.run('g++ -std=c++11 -o {}/a.out {} 2> {}'.format(tmp_dir, sub_path, ce_path), shell=True) 
    elif file_type == 'java':
        process = subprocess.run('cp {} {}/Main.java && javac {}/Main.java 2> {}'.format(tmp_dir, tmp_dir, sub_path, ce_path), shell=True) 
    elif file_type == 'py2' or file_type == 'py3':
        return ''
    
    return read_file(ce_path)

def judge(sub, case_id, total_case, time_limit, tmp_dir):
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
    print (tmp_dir)
    # print('judging problem: {}, sub_id: {}, user_id: {}, file_tpye: {}, file_name: {}'.format(problem, sub_id, user_id, file_type, file_name))

    secret_case_path = '{}/problems/{}/secret'.format(ROOT_PATH, problem)
    user_path = '{}/submissions/{}'.format(ROOT_PATH, user_id)
    sub_path = '{}/{}'.format(user_path, file_name)
    error_path = '{}/error'.format(tmp_dir, sub_id)
    time_output_path = '{}/{}.time'.format(tmp_dir, case_id)

    input_path = '{}/{}.in'.format(secret_case_path, case_id)
    correct_output_path = '{}/{}.out'.format(secret_case_path, case_id)
    user_output_path = '{}/{}.out'.format(tmp_dir, case_id)

    if file_type == 'cpp':
        run_cmd = '{}/a.out'.format(tmp_dir)
    elif file_type == 'java':
        run_cmd = 'java -cp {} Main'.format(tmp_dir)
    elif file_type == 'py2':
        run_cmd = 'python2 {}'.format(sub_path)
    elif file_type == 'py3':
        run_cmd = 'python3 {}'.format(sub_path)

    status = JUDGING # initial status

    judge_time_bash_path = '{}/docker/judge/judge_time.sh'.format(ROOT_PATH)

    cmd = 'timeout {} bash {} {} {} {} {} {}'.format(time_limit, judge_time_bash_path, run_cmd, input_path, user_output_path, error_path, time_output_path)
    print (cmd)
    process = subprocess.run('timeout {} bash {} {} {} {} {} {}'.format(time_limit, judge_time_bash_path, run_cmd, input_path, user_output_path, error_path, time_output_path), shell=True)

    case_input = read_file(input_path)
    case_user_output = read_file(user_output_path)
    case_correct_output = read_file(correct_output_path)
    error = read_file(error_path)
    run_time = time_limit

    if process.returncode == TIMEOUT_CODE: # time limit exceed
        status = TIME_LIMIE_EXCEED
    elif error != '': # runtime error
        status = RUNTIME_ERROR
        error = read_file(error_path)
        run_time = read_file(time_output_path)
    elif is_diff(correct_output_path, user_output_path): # wrong answer
        status = WRONG_ANSWER
        run_time = read_file(time_output_path)
    else: # accepted
        run_time = read_file(time_output_path)
        if case_id == total_case: # all cases passed
            status = ACCEPTED
    
    result = {
        'status': str(status),
        'current_case': str(case_id),
        'total_case': str(total_case),
        'error': str(error),
        'input': str(case_input),
        'user_output': str(case_user_output),
        'correct_output': str(case_correct_output),
        'run_time': str(run_time)
    }
    
    return result

current_milli_time = lambda: int(round(time.time() * 1000))

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
        tmp_dir = '/tmp/{}'.format(sub_id) # temp output directory
        if not os.path.exists(tmp_dir):
            os.makedirs(tmp_dir)

        result_path = '{}/submissions/{}/{}.json'.format(ROOT_PATH, user_id, sub_id) # result json file
        config = read_problem_config(problem)

        time_limit = config['timelimit']
        case_num = config['testcase']

        # compiling
        emit('judge', dict_to_json({
            'status': COMPILING,
            'current_case': 0,
            'total_case': case_num
        }))

        ce = compile(sub, tmp_dir) # get compile info
        max_run_time = 0
        if ce != '': # compile error
            result = {
                'status': COMPILE_ERROR,
                'current_case': 1,
                'total_case': case_num,
                'error': ce,
                'time_time': max_run_time
            }
            write_data(result_path, dict_to_json_str(result)) # write to json file
            update(sub_id, COMPILE_ERROR) # update db
            emit('judge', dict_to_json(result)) # send result for {case_id}th case
        else:
            # start judging
            emit('judge', dict_to_json({
                'status': JUDGING,
                'current_case': 0,
                'total_case': case_num,
                'time_time': max_run_time
            }))

            previous_send_time = current_milli_time()
            HALF_SECOND_MILLI_UNIT = 500 # milli unit for half second

            for case_id in range(1, case_num + 1):
                result = judge(sub, case_id, case_num, time_limit, tmp_dir)
                case_run_time = float(result['run_time'])
                if case_run_time > max_run_time:
                    max_run_time = case_run_time
                result['run_time'] = max_run_time
                            
                if result['status'] != JUDGING: # judge finish
                    write_data(result_path, dict_to_json_str(result)) # write to json file
                    update(sub_id, result['status']) # update db
                    emit('judge', dict_to_json(result)) # send result for {case_id}th case 
                    break
                else: # still in judging
                    current_time = current_milli_time()
                    if current_time - previous_send_time >= HALF_SECOND_MILLI_UNIT:
                        emit('judge', dict_to_json(result)) # send result for {case_id}th case 
                        previous_send_time = current_time

@socketio.on('connect')
def socket_connect_client(): # connect to client
    print('connect to client')

if __name__ == '__main__':
    socketio.run(app, host='0.0.0.0', port=3000)
