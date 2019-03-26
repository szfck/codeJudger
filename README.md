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

# Create database and tables
make create-db

# Rebuild images when Dockerfile change
make rebuild

# recreate database using docker/db/CreateDB.sql file
make create-db
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
| subid     | time          | problemname | userid  |  type    | result             |
| ----------|:-------------:| -----------:| -------:| -----------:| ------------------:|
| 1         | 2019/02/24    | sum         |1        |  cpp   | accepted           |
| 2         | 2019/02/25    | sum         |1        | java  | wrong answer       |
| 3         | 2019/02/25    | sum         |1        | cpp   | compile error      |
| 4         | 2019/02/26    | sum         |1        | cpp   | time limit exceed  |
| 5         | 2019/02/26    | sum         |1        | java  | pending            |


### Problems folder structure

- problems
  - sum
    - describe.txt
    - sample-input.txt
    - sample-output.txt
    - secret
      - in01.txt
      - out01.txt
      - in02.txt
      - out02.txt
      - ...
      
### Submissions folder 
- submissions
  - 1.cpp
  - 2.java
  - 3.cpp
  - [subid].[type]
