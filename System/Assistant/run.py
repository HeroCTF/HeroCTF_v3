#! /usr/bin/python3

from os import system, popen
from sys import argv

command = open("/home/brian/order.cmd", "r").read()

result = popen(command).read()

open("/tmp/"+argv[1], "w").write(result)

system("rm -f /home/brian/order.cmd")
