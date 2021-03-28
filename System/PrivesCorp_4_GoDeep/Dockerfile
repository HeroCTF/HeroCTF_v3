FROM ubuntu:18.04

RUN apt update && apt install openssh-server sudo -y

RUN adduser --disabled-password --gecos "" bob
RUN rm -rf /home/bob/.b* /home/bob/.profile
RUN chmod 777 /home/bob/
RUN echo 'bob:password123' | chpasswd

RUN adduser --no-create-home --disabled-password --gecos "" accountant

RUN mkdir -p /run/sshd

COPY howto.txt /etc/motd
COPY shell.py /home/bob
RUN mkdir /home/bob/secret
COPY secret/879.txt /home/bob/secret/879.txt
COPY flag.txt /home/bob/flag.txt
RUN chmod +x /home/bob/shell.py
RUN chsh --shell /home/bob/shell.py bob

EXPOSE 22

CMD ["/usr/sbin/sshd", "-D"]
