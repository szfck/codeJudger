# CodeJudger-

## Build and run docker container
```
docker build -t judger:lastet .
docker run -it -v $PWD:/var/www/html -p 8888:80 --name judger-container judger:lastet
```

This site is shown in [http://localhost:8888](http://localhost:8888). 

## Tables

### User
| userid    | username  | password  |
| ----------|:---------:| ---------:|
| 1         | kai       |  123456   |
| 2         |           |           |
| 3         |           |           |

### Submission
| subid     | time          | problemname | userid  | filename    | result             |
| ----------|:-------------:| -----------:| -------:| -----------:| ------------------:|
| 1         | 2019/02/24    | sum         |1        | kai01.cpp   | accepted           |
| 2         | 2019/02/25    | sum         |1        | kai02.java  | wrong answer       |
| 3         | 2019/02/25    | sum         |1        | kai03.cpp   | compile error      |
| 4         | 2019/02/26    | sum         |1        | kai04.cpp   | time limit exceed  |
| 5         | 2019/02/26    | sum         |1        | kai05.java  | pending            |


## Problems folder structure

- Problems
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
      
    - users
      - 1
        - kai01.cpp
        - kai02.java
        - ...
      - 2
        - ...
