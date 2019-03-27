from multiprocessing import Process
from flask import Flask, request
from flaskext.mysql import MySQL

app = Flask(__name__)

mysql = MySQL()
 
# MySQL configurations
app.config['MYSQL_DATABASE_USER'] = 'root'
app.config['MYSQL_DATABASE_PASSWORD'] = '123456'
app.config['MYSQL_DATABASE_DB'] = 'judger'
app.config['MYSQL_DATABASE_HOST'] = 'judger-db'
mysql.init_app(app)

ROOT_PATH = '/judge'

COMPILE_PATH = '/tmp'

def judge_cpp(problem, file):
    import subprocess
    process = subprocess.run('bash judge_cpp.sh {} {}'.format(problem, file), shell=True)
    code = process.returncode
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

def get_result(problem, file):
    '''
    TODO: finish judging process
    '''
    file_type = file.split('.')[1]
    if file_type == 'cpp':
        return judge_cpp(problem, file)

    return "Unsupport file type"

def worker(subid, problem, file):
    conn = mysql.connect()
    cursor =conn.cursor()
    result = get_result(problem, file)
    sql_update = 'UPDATE submission SET result=\'{}\' WHERE subid={}'.format(result, subid)
    print (sql_update)
    cursor.execute(sql_update)
    conn.commit();
    print ("sql: {} executed, result is: {}".format(sql_update, result))

@app.route('/judge', methods=['POST'])
def judge():
    conn = mysql.connect()
    cursor =conn.cursor()
    subid = request.form['submission_id']
    sql_query = 'SELECT * FROM submission WHERE subid={}'.format(subid)
    cursor.execute(sql_query)
    data = cursor.fetchone()
    if not data:
        return '[Fail] sql: {}'.format(sql_query)
    
    problem = data[2]
    file_type = data[4]
    file = '{}.{}'.format(subid, file_type)

    p = Process(target=worker, args=(subid, problem, file,))
    p.start()
    return '[OK] put in the judge queue'

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=3000)
