# CodeJudger-

## Build and run docker container
```
docker build -t judger:lastet .
docker run -it -v $PWD:/var/www/html -p 8888:80 --name judger-container judger:lastet
```

This site is shown in [http://localhost:8888](http://localhost:8888). 
