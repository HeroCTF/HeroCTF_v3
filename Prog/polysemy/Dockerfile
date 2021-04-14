FROM ubuntu:18.04

RUN apt-get update 
RUN apt-get install -y socat
RUN apt-get install -y python3
RUN groupadd ctf

RUN mkdir /polysemy
COPY ./chall.py /polysemy/
COPY ./entry.sh /polysemy/

RUN useradd -G ctf --home=/polysemy player

RUN chown player:player /polysemy/chall.py

RUN chmod 4755 /polysemy/chall.py
RUN chmod 4755 /polysemy/entry.sh

EXPOSE 7004
ENTRYPOINT ["/polysemy/entry.sh"]
