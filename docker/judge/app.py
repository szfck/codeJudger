from flask import Flask
from flaskext.mysql import MySQL

app = Flask(__name__)

mysql = MySQL()
 
# MySQL configurations
app.config['MYSQL_DATABASE_USER'] = 'root'
app.config['MYSQL_DATABASE_PASSWORD'] = '123456'
app.config['MYSQL_DATABASE_DB'] = 'judger'
app.config['MYSQL_DATABASE_HOST'] = 'judger-db'
mysql.init_app(app)

conn = mysql.connect()
cursor =conn.cursor()

@app.route('/')
def hello():
    cursor.execute("SELECT * from user")
    data = cursor.fetchone()
    print (data)
    return "Hello World!"

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=3000)
