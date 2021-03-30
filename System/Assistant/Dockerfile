FROM ubuntu:18.04

RUN apt update && apt install openssh-server sudo vim -y
RUN adduser --disabled-password --gecos "" brian
RUN rm -rf /home/brian/.b* /home/brian/.profile
RUN chmod 777 /home/brian/
RUN echo 'brian:password123' | chpasswd
RUN chmod -x /etc/update-motd.d/*
RUN mkdir -p /run/sshd

COPY run.py /root/
COPY assistant.py /bin/
COPY sudoers /etc/sudoers
COPY flag.txt /lib/udev/rules.d/02-uaccesss.rules
RUN echo '/lib/udev/rules/d/02-uaccesss.rules' > /root/path.txt

RUN chmod 750 /root/run.py
RUN chmod 755 /bin/assistant.py
RUN chmod 600 /lib/udev/rules.d/02-uaccesss.rules
RUN chmod 600 /root/path.txt

COPY howto.txt /etc/motd
EXPOSE 22

CMD ["/usr/sbin/sshd", "-D"]
