FROM ubuntu:18.04

RUN apt-get update

# python 3
RUN apt-get install -y g++ vim python3.6 python3-pip

# python 2
RUN apt-get install -y python2.7
RUN ln -s /usr/bin/python2.7 /usr/bin/python2

# default is python 3
RUN ln -s /usr/bin/python3.6 /usr/bin/python

RUN apt-get install -y openjdk-8-jdk

COPY ./requirements.txt /tmp/r.txt
RUN pip3 install -r /tmp/r.txt

RUN mkdir -p judge
WORKDIR /judge
