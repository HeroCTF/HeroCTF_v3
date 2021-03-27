FROM ubuntu:18.04 

RUN apt update && apt install openssh-server sudo -y
RUN apt-get -y install openssh-client

RUN groupadd boss

RUN adduser --no-create-home --disabled-password --gecos "" bob
RUN mkdir -p /home/bob/.ssh
RUN chown bob:bob /home/bob/.ssh
USER bob
RUN ssh-keygen -q -t rsa -N '' -f /home/bob/.ssh/id_rsa
USER root
RUN usermod -g users bob

RUN adduser --disabled-password --gecos "" dylan
RUN mkdir /home/dylan/.ssh
RUN cp /home/bob/.ssh/id_rsa.pub /home/dylan/.ssh/authorized_keys
RUN chown dylan:dylan /home/dylan/.ssh/authorized_keys
RUN usermod -g users dylan

RUN adduser --disabled-password --gecos "" hr
RUN usermod -g boss hr
RUN chmod 760 -R /home/hr/ 

RUN adduser --disabled-password --gecos "" util
RUN usermod -g boss util
RUN chmod 760 -R /home/util/

RUN echo 'bob:password123' | chpasswd
RUN echo 'dylan:I_h4t3_my_j0b' | chpasswd
RUN echo 'hr:$3cur3_l0l' | chpasswd

COPY note.txt /home/bob/note.txt
RUN chown dylan:dylan /home/bob/note.txt
COPY flag.txt /home/hr/flag.txt
RUN chown hr:hr /home/hr/flag.txt
COPY sudoers /etc/sudoers
COPY README.txt /etc/motd
COPY passManager /home/util/

RUN rm -rf /bin/su

EXPOSE 22

CMD ["/usr/sbin/sshd", "-D"]
