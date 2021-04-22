FROM ubuntu:18.04

RUN apt-get update 
RUN apt-get install -y socat
RUN groupadd ctf

RUN mkdir /santa
COPY ./integer_santa.bin /santa/
COPY ./entry.sh /santa/

RUN useradd -G ctf --home=/santa player

RUN chown player:player /santa/integer_santa.bin

RUN chmod 4755 /santa/integer_santa.bin
RUN chmod 4755 /santa/entry.sh

USER player

ENTRYPOINT ["/santa/entry.sh"]