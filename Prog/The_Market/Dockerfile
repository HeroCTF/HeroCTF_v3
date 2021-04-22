FROM ubuntu

RUN apt update && apt upgrade -y
RUN apt install python3 socat -y

RUN groupadd ctf

RUN useradd -G ctf -m -s /bin/bash robot

RUN echo 'export TERM=xterm' >> /home/robot/.bashrc 

WORKDIR /home/robot/
COPY . .
RUN chown robot:robot /home/robot/chall.py

RUN chmod 4755 /home/robot/chall.py
RUN chmod 4755 /home/robot/entry.sh

EXPOSE 3000
ENTRYPOINT ["/home/robot/entry.sh"]
