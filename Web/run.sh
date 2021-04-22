#!/usr/bin/env bash

docker-compose -f "docker-compose.$(hostname).yml" up -d --build