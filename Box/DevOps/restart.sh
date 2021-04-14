#!/usr/bin/env bash

docker-compose down

rm -r data/ db/ files/ jenkins_home/
unzip -q box_data.zip
chown -R heroctf:heroctf $PWD/

docker-compose up -d
