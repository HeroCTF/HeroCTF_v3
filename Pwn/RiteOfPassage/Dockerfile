FROM ubuntu:latest

# Upgrade the image
RUN apt-get update && apt upgrade -y
# Install Socat
RUN apt-get install -y socat strace
# So we can run x32 binaries
RUN dpkg --add-architecture i386
# Work in app
WORKDIR app/
# Make a directory
RUN mkdir flag
# Copy the flag in the dir
COPY flag/hello /app/flag/hello
# Compiling shit
COPY x /app/x
# copy the executable
COPY y /app/y
# Socat wrapper
COPY net.sh net.sh
# Set rights
RUN chmod 777 net.sh
RUN chmod 777 x
RUN chmod 777 y
# Lol no write
RUN chmod -R 444 flag
# Port
EXPOSE 9002
# Socat script
ENTRYPOINT ["./net.sh"]
