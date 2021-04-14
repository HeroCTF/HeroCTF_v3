FROM ubuntu:18.04

RUN apt-get update 
RUN apt-get install -y socat
RUN apt-get install -y python3
RUN groupadd ctf

RUN mkdir /guessing
COPY ./chall.py /guessing/
COPY ./entry.sh /guessing/

RUN useradd -G ctf --home=/guessing player

RUN chown player:player /guessing/chall.py

RUN chmod 4755 /guessing/chall.py
RUN chmod 4755 /guessing/entry.sh

EXPOSE 7003
ENTRYPOINT ["/guessing/entry.sh"]
