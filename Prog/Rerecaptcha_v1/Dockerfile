FROM alpine:latest

WORKDIR /app
COPY ./src /app

RUN apk update \
    && apk add --virtual build-deps gcc python3-dev musl-dev \
    && apk add jpeg-dev zlib-dev libjpeg py-pip \
    && adduser -D app

RUN chown -R app:app /app

USER app

RUN pip install Pillow Flask flask-session redis

CMD ["python3", "-u", "app.py"]
EXPOSE 5000