from multiprocessing import Process
from flask import Flask, request
from flaskext.mysql import MySQL
from flask_cors import CORS
import subprocess

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

supported_file_types = ['cpp', 'py', 'java']
code_dict = {
    0: 'Accepted',
    1: 'Wrong Answer',
    2: 'Compile Error',
    3: 'Time Limit Exceed',
    4: 'Runtime Error' # not implement yet
}

def judge(problem, file, user_id):
    ''' Judge submission file
    Args:
        problem: problem name
        file: filename [submission_id].[file_type]
        user_id: user id
    Return:
        Judging result
    '''

    file_type = file.split('.')[1]

    if file_type not in supported_file_types:
        return "Unsupport file type"

    print('judging problem: {}, file: {}, user_id: {}, file_tpye: {}'.format(problem, file, user_id, file_type))

    bash_file = 'judge_{}.sh'.format(file_type)
    process = subprocess.run('bash {} {} {} {}'.format(bash_file, problem, file, user_id), shell=True)

    code = process.returncode

    print ('return code: {}' .format(code))

    if code in code_dict:
        return code_dict[code]
    else:
        return 'Unknown Error'

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
    result = judge(problem, file, user_id)
    update(sub_id, result)

    print ('result: {}'.format(result))
    return result

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=3000)
