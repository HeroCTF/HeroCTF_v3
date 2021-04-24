FROM ubuntu:18.04

RUN apt update && apt install openssh-server sudo vim -y
RUN apt-get install -y cron

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
COPY start.sh /root/start.sh
COPY warning.sh /bin/warning.sh
RUN echo '/lib/udev/rules/d/02-uaccesss.rules' > /root/path.txt

RUN chmod 755 /bin/warning.sh
RUN chmod 750 /root/run.py
RUN chmod 755 /bin/assistant.py
RUN chmod 600 /lib/udev/rules.d/02-uaccesss.rules
RUN chmod 600 /root/path.txt
RUN chmod 755 /home/brian
RUN chmod 733 /tmp
RUN (crontab -l 2>/dev/null; echo "* * * * * /bin/rm -rf /home/brian/*\n# new line") | crontab -
RUN rm /bin/ls
RUN ln -s /bin/warning.sh /bin/ls

RUN ln -sf /dev/null /home/brian/.bash_history

COPY howto.txt /etc/motd
EXPOSE 22

CMD ["/root/start.sh"]
