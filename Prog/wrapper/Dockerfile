FROM ubuntu:18.04

RUN apt-get update
RUN apt-get install -y socat
RUN apt-get install -y python3
RUN groupadd ctf

RUN mkdir /wrapped
COPY ./chall.py /wrapped/
COPY ./entry.sh /wrapped/

RUN useradd -G ctf --home=/wrapped player

RUN chown player:player /wrapped/chall.py

RUN chmod 4755 /wrapped/chall.py
RUN chmod 4755 /wrapped/entry.sh

EXPOSE 7002
ENTRYPOINT ["/wrapped/entry.sh"]