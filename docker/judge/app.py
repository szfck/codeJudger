from multiprocessing import Process
from flask import Flask, request
from flaskext.mysql import MySQL
from flask_cors import CORS

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

COMPILE_PATH = '/tmp'

def get_code_str(code):
    if code == 0:
        return 'Accepted'
    elif code == 1:
        return 'Wrong Answer'
    elif code == 2:
        return 'Compile Error'
    elif code == 3:
        return 'Time Limit Exceed'
    else:
        return 'Unknown Error'

import subprocess
def judge_cpp(problem, file):
    process = subprocess.run('bash judge_cpp.sh {} {}'.format(problem, file), shell=True)
    return get_code_str(process.returncode)

def judge_py(problem, file):
    process = subprocess.run('bash judge_py.sh {} {}'.format(problem, file), shell=True)
    return get_code_str(process.returncode)

def judge_java(problem, file):
    process = subprocess.run('bash judge_java.sh {} {}'.format(problem, file), shell=True)
    code = process.returncode
    print ('code: {}' .format(code))
    return get_code_str(process.returncode)

def get_result(problem, file):
    '''
    TODO: finish judging process
    '''
    file_type = file.split('.')[1]
    if file_type == 'cpp':
        return judge_cpp(problem, file)
    elif file_type == 'python':
        num = file.split('.')[0]
        file = num+".py"
        return judge_py(problem, file)
    elif file_type == 'java':
        print ('file: {}'.format(file))
        return judge_java(problem, file)

    return "Unsupport file type"

def update(subid, problem, file, result):
    conn = mysql.connect()
    cursor =conn.cursor()
    result = get_result(problem, file)
    sql_update = 'UPDATE submission SET result=\'{}\' WHERE subid={}'.format(result, subid)
    print (sql_update)
    cursor.execute(sql_update)
    conn.commit();
    print ("sql: {} executed, result is: {}".format(sql_update, result))

@app.route('/judge', methods=['GET'])
def judge():
    conn = mysql.connect()
    cursor =conn.cursor()
    subid = request.args.get('submission_id')
    sql_query = 'SELECT * FROM submission WHERE subid={}'.format(subid)
    cursor.execute(sql_query)
    data = cursor.fetchone()
    if not data:
        return '[Fail] sql: {}'.format(sql_query)
    
    problem = data[2]
    file_type = data[4]
    file = '{}.{}'.format(subid, file_type)

    result = get_result(problem, file)
    update(subid, problem, file, result)

    print ('result: {}'.format(result))
    return result

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=3000)
