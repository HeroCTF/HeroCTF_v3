FROM python:3.8-slim-buster

RUN apt-get update && apt upgrade -y
RUN apt-get install -y socat

RUN pip install numpy

WORKDIR app/

ADD net.sh app/net.sh
ADD Casino_pwn.py app/Casino_pwn.py

RUN chmod 777 app/net.sh

EXPOSE 9001

ENTRYPOINT ["app/net.sh"]

