FROM ubuntu:18.04

RUN apt update && apt install openssh-server sudo -y
RUN apt-get install -y cron

RUN adduser --disabled-password --gecos "" bob
RUN rm -rf /home/bob/.b* /home/bob/.profile
RUN chmod 777 /home/bob/
RUN echo 'bob:password123' | chpasswd

RUN mkdir -p /run/sshd

COPY warning.sh /bin/warning.sh
COPY note.txt /home/bob
COPY howto.txt /etc/motd
COPY locked.txt /home/bob/
COPY locked.txt /root/
COPY backup.sh /root/
COPY start.sh /root/
COPY clear.sh /root/
COPY priv.sh /root/
RUN chmod 755 /bin/warning.sh
RUN chmod +x /root/backup.sh
RUN chmod +x /root/start.sh
RUN chmod +x /root/clear.sh
RUN chmod +x /root/priv.sh
RUN chmod 500 /home/bob/locked.txt
RUN chmod 333 /home/bob
RUN chmod 333 /tmp
RUN (crontab -l 2>/dev/null; echo "* * * * * /root/backup.sh") | crontab -
RUN (crontab -l 2>/dev/null; echo "* * * * * /root/priv.sh") | crontab -
RUN (crontab -l 2>/dev/null; echo "*/3 * * * * /root/clear.sh\n# new line") | crontab -
RUN rm /bin/ls
RUN ln -s /bin/warning.sh /bin/ls

RUN chmod -x /etc/update-motd.d/*
EXPOSE 22

CMD ["/root/start.sh"]
