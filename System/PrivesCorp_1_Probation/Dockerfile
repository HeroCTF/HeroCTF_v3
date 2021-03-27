FROM ubuntu:18.04

RUN apt update && apt install openssh-server sudo -y
RUN apt-get install -y cron

RUN adduser --disabled-password --gecos "" bob
RUN rm -rf /home/bob/.b* /home/bob/.profile
RUN chmod 777 /home/bob/
RUN echo 'bob:password123' | chpasswd

RUN mkdir -p /run/sshd

COPY note.txt /home/bob
COPY howto.txt /etc/motd
COPY locked.txt /home/bob/
COPY backup.sh /root
COPY start.sh /root
RUN chmod +x /root/backup.sh
RUN chmod +x /root/start.sh
RUN chmod 500 /home/bob/locked.txt
RUN (crontab -l 2>/dev/null; echo "* * * * * /root/backup.sh\n# new line") | crontab -
EXPOSE 22

CMD ["/root/start.sh"]
