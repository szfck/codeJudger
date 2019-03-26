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

from multiprocessing import Process

def get_result(problem, file):
    '''
    TODO: finish judging process
    '''
    return "success"

def worker(subid, problem, file):
    import time
    time.sleep(3)
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
