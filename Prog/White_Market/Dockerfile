FROM ubuntu:18.04

RUN apt update
RUN apt install python3 socat unzip -y

RUN groupadd ctf

RUN useradd -G ctf -m -s /bin/bash robot

RUN echo 'export TERM=xterm' >> /home/robot/.bashrc 

WORKDIR /home/robot/
COPY . .
RUN chown robot:robot /home/robot/chall.py
RUN unzip barcodes.zip
RUN rm barcodes.zip
RUN chmod 4755 /home/robot/chall.py
RUN chmod 4755 /home/robot/entry.sh

EXPOSE 7005
ENTRYPOINT ["/home/robot/entry.sh"]
