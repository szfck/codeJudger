# CodeJudger-

### Build and run docker containers
```
make run
```

## Stop docker containers
```
make stop
```

### Create database and tables
```
make create-db
```

### Enter bash of judger-db container
```
make judger-db
```

### Enter bash of judger-app container
```
make judger-app
```

This site is shown in [http://localhost:8888](http://localhost:8888). 

## Tables

### User
| userid    | useremail   | username  | password  |
| ----------| -----------:| ---------:| ---------:|
| 1         | kai@nyu.edu |    kai    |  123456   |
| 2         |             |           |           |
| 3         |             |           |           |

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

### Follow these steps to remove index.php from the base URL [Everything included in dockerfile and lastest project, no need to do it manually]
source - https://stackoverflow.com/questions/19183311/codeigniter-removing-index-php-from-url
1. Add this in .htaccess file (outside the application folder if it doesn't exist create new)

```
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php/$1 [L]
```
2. Remove index.php in codeigniter config

```
$config['index_page'] = '';
```
3. Allow overriding htaccess in Apache Configuration (Command)
```
sudo nano /etc/apache2/apache2.conf
```
and edit the file & change to
```
AllowOverride All
```
for www folder

4. Enable apache mod rewrite (Command)
```
sudo a2enmod rewrite
```
5. Restart Apache (Command)
```
service apache2 restart
```