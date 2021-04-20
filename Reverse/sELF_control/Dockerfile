FROM alpine:3.13.1 

WORKDIR /usr/src
RUN apk add --no-cache python3 socat

COPY ./sELF_control /usr/src/sELF_control
COPY ./entry.sh /usr/src/entry.sh

RUN adduser --disabled-password --no-create-home heroctf
RUN chown heroctf:heroctf /usr/src/sELF_control
RUN chown heroctf:heroctf /usr/src/entry.sh
RUN chmod 540 /usr/src/sELF_control
RUN chmod 540 /usr/src/entry.sh

USER heroctf

ENTRYPOINT ["/usr/src/entry.sh"]
