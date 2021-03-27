FROM ubuntu:18.04

RUN apt update && apt install openssh-server sudo -y

RUN adduser --disabled-password --gecos "" bob
RUN rm -rf /home/bob/.b* /home/bob/.profile
RUN chmod 777 /home/bob/
RUN echo 'bob:password123' | chpasswd

RUN adduser --no-create-home --disabled-password --gecos "" accountant

RUN mkdir -p /run/sshd

COPY exportSafePerms /home/bob/
COPY .financial.txt /home/bob/
COPY howto.txt /etc/motd


RUN chown accountant:accountant /home/bob/.financial.txt
RUN chmod 700 /home/bob/.financial.txt
RUN chown accountant:accountant /home/bob/exportSafePerms
RUN chmod 755 /home/bob/exportSafePerms
RUN chmod u+s /home/bob/exportSafePerms

EXPOSE 22

CMD ["/usr/sbin/sshd", "-D"]
