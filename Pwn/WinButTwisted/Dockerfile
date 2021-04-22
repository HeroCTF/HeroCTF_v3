FROM i386/ubuntu

RUN apt-get update && apt upgrade -y
RUN apt-get install -y socat strace

RUN mkdir /pwn
COPY x /pwn/x
COPY flag /pwn/flag
COPY net.sh /pwn/net.sh

RUN chmod 777 /pwn/net.sh
RUN chmod 777 /pwn/x

EXPOSE 9003
#ENTRYPOINT ["/bin/bash"]
ENTRYPOINT ["/pwn/net.sh"]