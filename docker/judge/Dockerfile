FROM ubuntu:18.04

RUN apt-get update
RUN apt-get install -y g++ vim python3.6 python3-pip
RUN ln -s /usr/bin/python3.6 /usr/bin/python
RUN ln -s /usr/bin/pip3 /usr/bin/pip

RUN apt-get install -y openjdk-8-jdk

COPY ./requirements.txt /tmp/r.txt
RUN pip install -r /tmp/r.txt

RUN mkdir -p judge
WORKDIR /judge
