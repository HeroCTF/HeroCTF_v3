FROM ubuntu:18.04

RUN apt-get update
RUN apt-get install -y python3 python3-pip

WORKDIR /opt/chall
COPY . .

RUN pip3 install --no-cache-dir -r requirements.txt
RUN rm requirements.txt

EXPOSE 8050
CMD ["python3", "app.py"]