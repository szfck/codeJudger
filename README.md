# CodeJudger

### Makefile commands 
```
help                           This help.
run-prod                       run in prod
run-dev                        run in dev
stop                           stop running containers
start-db                       start db
container-db                   enter the bash of db container
create-db                      create database and tables using createDB.sql dump
start-app                      start app
stop-app                       stop app
container-app                  enter the bash of app container
start-judge-prod               start judge in prodd
start-judge-dev                start judge in dev
container-judge                enter the bash of judge container
lint                           run php linter using nodejs
test                           run unit tests
rm-images                      remove images
clean                          clear tmp dir and files
```

### Containers

#### 1. Web container [PHP]
CodeJudger web server is running in <strong>judger-app</strong>. 

local server [http://localhost:8888](http://localhost:8888). 

prod server [140.82.63.62](http://140.82.63.62).

#### 2. Database container [Mysql]
mysql is running in <strong>judger-db:3306</strong> inside docker container.

#### 3. Judge container [Flask]
judge server is running in <strong>judger-judge:3000</strong>.

### Continuous Deployment

1. Generate a dedicated SSH key
```
ssh-keygen -t rsa -b 4096 -C 'build@travis-ci.org' -f ./deploy_rsa
```

2. Encrypt the private key to make it readable only by Travis CI
```
travis encrypt-file deploy_rsa --add
```

3. Copy the public key onto the remote SSH host
```
ssh-copy-id -i deploy_rsa.pub <ssh-user>@<deploy-host>
```

4. Stage the modified files into Git
```
git add deploy_rsa.enc .travis.yml
```

5. add code below to .travis.yml
```
addons:
  ssh_known_hosts: 140.82.63.62

after_success:
  - ./deploy.sh
```

6. Install docker and clone github project on server

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
| 1     | 2019/02/24  | sum      |1      |   1.cpp| cpp  | Accepted           |
| 2     | 2019/02/25  | sum      |1      |  2.java| java | Wrong Answer       |
| 3     | 2019/02/25  | sum      |1      |   3.cpp| cpp  | Compile Error      |
| 4     | 2019/02/26  | sum      |1      |   4.py | py2  | Time Limit Exceed  |
| 5     | 2019/02/26  | sum      |1      |   5.py | py3  | Pending            |
| 6     | 2019/02/26  | sum      |1      |   6.py | py3  | Runtime Error      |

### Problems folder structure

- problems
  - sum
    - genData[optional]
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
