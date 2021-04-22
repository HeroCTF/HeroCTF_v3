# Use python base
FROM python:3.8-slim-buster
# Upgrade the image
RUN apt-get update && apt upgrade -y
# Install Socat
RUN apt-get install -y socat
# Install numpy (dependency)
RUN pip install numpy
# Work in app/
WORKDIR app/
# Add socat wrapper
ADD net.sh app/net.sh
# Add py executable
ADD Casino_pwn.py app/Casino_pwn.py
# Make wrapper executable
RUN chmod 777 app/net.sh
# Port
EXPOSE 9001
# Socat script
ENTRYPOINT ["app/net.sh"]

