FROM ubuntu:18.04

RUN apt update && apt install openssh-server sudo -y
RUN apt-get -y install openssh-client

RUN adduser --no-create-home --disabled-password --gecos "" gordon
RUN echo 'gordon:password123' | chpasswd
RUN mkdir -p /home/gordon/.ssh
RUN chown gordon:gordon /home/gordon/.ssh
USER gordon
RUN ssh-keygen -q -t rsa -N '' -f /home/gordon/.ssh/id_rsa
USER root

RUN adduser --no-create-home --disabled-password --gecos "" joker
RUN echo 'joker:ilovebatman' | chpasswd
RUN mkdir -p /home/joker
RUN adduser --no-create-home --disabled-password --gecos "" bradley_warner
RUN mkdir -p /home/bradley_warner/.ssh
RUN cp /home/gordon/.ssh/id_rsa.pub /home/bradley_warner/.ssh/authorized_keys
RUN adduser --no-create-home --disabled-password --gecos "" black_williams
RUN mkdir -p /home/black_williams/.ssh
RUN cp /home/gordon/.ssh/id_rsa.pub /home/black_williams/.ssh/authorized_keys
RUN adduser --no-create-home --disabled-password --gecos "" brett_willis
RUN mkdir -p /home/brett_willis/.ssh
RUN cp /home/gordon/.ssh/id_rsa.pub /home/brett_willis/.ssh/authorized_keys
RUN adduser --no-create-home --disabled-password --gecos "" bonnie_winter
RUN mkdir -p /home/bonnie_winter/.ssh
RUN cp /home/gordon/.ssh/id_rsa.pub /home/bonnie_winter/.ssh/authorized_keys

RUN usermod -g shadow bradley_warner


RUN mkdir -p /run/sshd
COPY howto.txt /etc/motd
RUN chmod -x /etc/update-motd.d/*

EXPOSE 22

CMD ["/usr/sbin/sshd", "-D"]
