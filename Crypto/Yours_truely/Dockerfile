FROM alpine:3.13.1 

WORKDIR /app
COPY ./src /app


WORKDIR /app
RUN apk update \
	&& apk add --no-cache python3 python3-dev py3-pip socat gcc g++ make libffi-dev openssl-dev \
	&& adduser -D app

RUN chown -R app:app /app

USER app

RUN python3 -m pip install --no-cache-dir pycryptodome sympy

ENTRYPOINT ["/app/entry.sh"]
