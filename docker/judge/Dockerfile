FROM python:3.6-alpine

COPY ./requirements.txt /tmp/r.txt
RUN pip install -r /tmp/r.txt

RUN mkdir -p judge
WORKDIR /judge
