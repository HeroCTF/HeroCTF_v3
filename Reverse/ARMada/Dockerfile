FROM alpine:3.13.1 

WORKDIR /usr/src
RUN apk add --no-cache python3 socat

COPY ./challenge.py /usr/src/challenge.py
COPY ./entry.sh /usr/src/entry.sh

RUN adduser --disabled-password --no-create-home heroctf
RUN chown heroctf:heroctf /usr/src/challenge.py
RUN chown heroctf:heroctf /usr/src/entry.sh
RUN chmod 540 /usr/src/challenge.py
RUN chmod 540 /usr/src/entry.sh

USER heroctf

ENTRYPOINT ["/usr/src/entry.sh"]
