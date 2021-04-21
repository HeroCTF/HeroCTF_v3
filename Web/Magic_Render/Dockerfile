FROM ubuntu:18.04
RUN apt update && apt upgrade -y
RUN apt install python3 python3-pip
RUN mkdir /opt/chall/
WORKDIR /opt/chall
COPY . .
RUN pip3 install -r requirements.txt
RUN rm requirements.txt
ENTRYPOINT ["python3"]
CMD ["app.py"]
