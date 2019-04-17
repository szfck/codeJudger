# CodeJudger

### Makefile commands 
```
# Build and run docker containers in prod
make run

# Build and run docker containers in dev, showing debug info
make run-dev

# Stop docker containers
make stop

#Run linter
make lint

#Run unit test
make test

#Enter bash of judger-db container
make judger-db

#Enter bash of judger-app container
make judger-app

#Enter bash of judger-judge container
make judger-judge

# Rebuild images when Dockerfile change
make rebuild

# recreate database using docker/db/CreateDB.sql file
make create-db
```

### generate testcases
```
cd problems
./genTestcase.sh [problem] [case_number]
```

### Containers

#### 1. Web container [PHP]
CodeJudger web server is running in <strong>judger-app</strong>, link [http://localhost:8888](http://localhost:8888). 

#### 2. Database container [Mysql]
mysql is running in <strong>judger-db:3306</strong> inside docker container.

#### 3. Judge container [Flask]
judge server is running in <strong>judger-judge:3000</strong> inside docker container.

## Tables

### User
| userid    | useremail   | username  | password  |
| ----------| -----------:| ---------:| ---------:|
| 1         | kai@nyu.edu |    kai    |  123456   |
| 2         |             |           |           |
| 3         |             |           |           |

### Submission
| subid | time        | problem  |userid |filename|  type| result   |
| -----:|------------:| --------:| -----:| ------:| ----:|-------------------:|
| 1     | 2019/02/24  | sum      |1      |   1.cpp| cpp  | accepted           |
| 2     | 2019/02/25  | sum      |1      |  2.java| java | wrong answer       |
| 3     | 2019/02/25  | sum      |1      |   3.cpp| cpp  | compile error      |
| 4     | 2019/02/26  | sum      |1      |   4.py | py2  | time limit exceed  |
| 5     | 2019/02/26  | sum      |1      |   5.py | py3  | pending            |


### Problems folder structure

- problems
  - sum
    - genData
      - gen.py
      - answer.cpp
    - describe.txt
    - sample-input.txt
    - sample-output.txt
    - config.yml
    - secret
      - in1.txt
      - out1.txt
      - in2.txt
      - out2.txt
      - ...
      
### Submissions folder 
- submissions
  - 1
    - 1.cpp
    - 2.java
    - 3.cpp
  - [user_id]
    - [sub_id].[type]
