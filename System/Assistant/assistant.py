#! /usr/bin/python3

from os import system, chmod
from time import sleep
import string, random

print("Welcome I am Snake, your personnal assistant")
print("Please select a command you want to run, and me free you of the burden of doing it yourself")
print()
print("Choose one action bellow :")
print("\t[1] Display a welcome message")
print("\t[2] Check your user informations")
print("\t[3] Display the flag's path")
print()

#Gathering the user's choice
choice = 0
while choice < 1 or choice > 3:
    try:
        choice = int(input(">> "))
    except ValueError:
        print("Enter a number please\n")
    if choice < 1 or choice > 3:
        print("The chosen number must be in the given range 1-3\n")

system("rm -f order.cmd") # Remove every previous 'order.cmd' file to avoid being hacked
# Creating the order file with the appropriate command
if choice == 1:
    open("/home/brian/order.cmd", "w").write("echo 'Welcome to this computer ! I am Snake, your personnal assistant ;) Let me know if I can do anything for you'")
elif choice == 2:
    open("/home/brian/order.cmd","w").write("id")
elif choice == 3:
    open("/home/brian/order.cmd", "w").write("cat /root/path.txt")

chmod("/home/brian/order.cmd", 0o777) #Make sure the runner can read it
#sleep(0.1) #Avoid overwelming the system

try:
    open("/root/run.py", "r")
    filename = ''.join(random.choice(string.ascii_lowercase + string.digits) for _ in range(10))+".txt"
    system("/usr/bin/python3 /root/run.py {}".format(filename))
    print("[+] The output will be saved to /tmp/"+filename)
    print("See you around !")
except:
    print("Run me as root !")
    system("rm -f order.cmd")

print()
print("\t\t\tThe advanced articficial intelligence used in this programm is proprietary")
