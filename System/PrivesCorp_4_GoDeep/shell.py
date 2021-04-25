#! /usr/bin/python3
from sys import modules, argv
import re

# Definition of needed vars and functions
_86924=open
vars = modules[__name__].__dict__
try:
    ssh_arg = argv[2]
except:
    pass
forbidden = ["TO_KEEP", "dir", "flag", "_86924", "secret/879.txt"]
TO_KEEP = {}
flag = "fake{NOP_LOL}"
def clear_vars(vars):
    global TO_KEEP
    to_empty = []
    for e in vars:
        if e not in TO_KEEP:
            to_empty.append(e)
    for e in to_empty:
        del vars[e]
TO_KEEP = vars.copy()

# clearing modules
modules.clear()
del modules
__builtins__.__dict__["open"] = ""
__builtins__.__dict__["open"] = ""

# Checking entry conditions
if (len(argv) < 3):
    print(" > That's a bit short, you have to ask nicely <\n")
    exit()
try:
    if(ssh_arg[3]+ssh_arg[4]+ssh_arg[5] != chr(97)+chr(109)+chr(101) or re.match(re.compile("^[^A-RT-Za-z0-9]e[s].$"), ssh_arg[0]+ssh_arg[1]+ssh_arg[2]+ssh_arg[3]) == None):
        print("That's better, but what's the magik word ?\n")
        exit()
except IndexError:
    # faking error for docker
    print("Traceback (most recent call last):")
    print(' File "/home/bob/shell.py", line 32, in <module>')
    print('  if(ssh_arg[3]+ssh_arg[4]+ssh_arg[5] != chr(97)+chr(109)+chr(101) or re.match(re.compile("^[^A-RT-Za-z0-9]e[s].$"), ssh_arg[0]+ssh_arg[1]+ssh_arg[2]+ssh_arg[3]) == None):')
    print('IndexError: string index out of range')
    exit()

del re

print("\nHmmm I should have bariccaded myself better then that... Now that you are here, you can't get out, so it doesn't matter ;). I made sure the document is well hidden.\n")
print()
print("/===================\\")
print("|| Welcome to jail ||")
print("=====================")
print("|| | | | |H| | | | ||")
print("=====================")
print()

# Main shell
while True:
    try:
        res = {'res': None}
        cmd = input("bob@godeep > ")[:39]
        if cmd == "exit":
            exit()
        for f in forbidden:
            cmd = cmd.replace(f, "")
        del f
        if "forbidden" in cmd or "vars" in cmd or "sys" in cmd or "__builtins__" in cmd or "__dict__" in cmd or "eval" in cmd or "import" in cmd or "globals" in cmd or "exec" in cmd or "locals" in cmd or "./" in cmd or "__file__" in cmd or "argv" in cmd or ("TO_KEEP" and "[") in cmd:
            print("I can't let you do that, sorry\n")
        else:
            print("--->", cmd)
            if cmd == "":
                cmd = "print('Command looks empty')"
            exec("res="+cmd, res["res"])
            print(res)
            print()

        clear_vars(vars) # Clearing the variables to avoid the forgery of payloads in multiple commands
    
    except FileNotFoundError:
        print("Can't open something that doesn't exist. Makes sense right ?")
    except NameError:
        print("I don't know this command. Are you sure you are allowed to run it ?")
    except:
        print("Oups, something went wrong. Wait ?? Did you break something ?")
        exit()