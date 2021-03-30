#! /usr/bin/python3

from os import system, popen

command = open("/home/brian/order.cmd", "r").read()

result = popen(command).read()

open("/home/brian/output.txt", "w").write(result)

system("rm -f /home/brian/order.cmd")
