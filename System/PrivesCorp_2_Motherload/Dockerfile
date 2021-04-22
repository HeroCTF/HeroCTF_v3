FROM ubuntu:18.04

RUN apt update && apt install openssh-server sudo -y
RUN apt-get install -y cron

RUN adduser --disabled-password --gecos "" bob
RUN rm -rf /home/bob/.b* /home/bob/.profile
RUN chmod 777 /home/bob/
RUN echo 'bob:password123' | chpasswd

RUN adduser --no-create-home --disabled-password --gecos "" accountant

RUN mkdir -p /run/sshd

COPY exportSafePerms /root
COPY .financial.txt /root
COPY howto.txt /etc/motd
COPY warning.sh /bin/warning.sh
COPY clear.sh /root
COPY start.sh /root
RUN chmod 755 /bin/warning.sh
RUN mv /bin/ls /root/ls
RUN ln -s /bin/warning.sh /bin/ls
RUN chmod +x /root/clear.sh
RUN chmod +x /root/start.sh
RUN chmod 333 /home/bob
RUN chmod 333 /tmp

RUN (crontab -l 2>/dev/null; echo "* * * * * rm -rf /tmp/*") | crontab -

RUN chmod -x /etc/update-motd.d/*
EXPOSE 22

CMD ["/root/start.sh"]
