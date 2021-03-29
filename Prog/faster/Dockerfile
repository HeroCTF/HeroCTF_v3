FROM ubuntu:18.04

RUN apt-get update 
RUN apt-get install -y socat
RUN apt-get install -y python3
RUN apt-get install -y python3-pip
RUN python3 -m pip install qrcode pillow
RUN groupadd ctf

RUN mkdir /faster
COPY ./chall.py /faster/
COPY ./entry.sh /faster/

RUN useradd -G ctf --home=/faster player

RUN chown player:player /faster/chall.py

RUN chmod 4755 /faster/chall.py
RUN chmod 4755 /faster/entry.sh

EXPOSE 7002
ENTRYPOINT ["/faster/entry.sh"]
