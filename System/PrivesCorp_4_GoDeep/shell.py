#! /usr/bin/python3
from sys import modules, argv
import re

# Definition of needed vars and functions
_86924=open
vars = modules[__name__].__dict__
args = argv
forbidden = ["TO_KEEP", "dir", "flag", "_86924", "secret/879.txt"]
TO_KEEP = {}
flag = "Hero{Th1s_w4s_t0O_e4sY}" # fake flag to find when typing dir()
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

# Checking entry conditions
if (len(args) < 3):
    print("That's a bit short, you have to ask nicely")
    exit()
try:
    if(re.match(re.compile("^[^A-RT-Za-z0-9]e[s].$"), args[2][0]+args[2][1]+args[2][2]+args[2][3]) == None or args[2][3]+args[2][4]+args[2][5] != chr(97)+chr(109)+chr(101)):
        print("That's better, but what's the magik word ?")
        exit()
except:
    # faking error for docker
    print("Traceback (most recent call last):")
    print(' File "/home/leo/Documents/HeroCTF/system/PrivesCorp_4_GoDeep/./shell.py", line 32, in <module>')
    print('  if(re.match(re.compile("^[^A-RT-Za-z0-9]e[s].$"), args[2][0]+args[2][1]+args[2][2]+args[2][3]) == None or args[2][3]+args[2][4]+args[2][5] != chr(97)+chr(109)+chr(101)):')
    print('IndexError: string index out of range')
    exit()

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
        if (cmd == "exit"):
            exit()
        for f in forbidden:
            cmd = cmd.replace(f, "")
        del f
        if "forbidden" in cmd or "vars" in cmd or "sys" in cmd or "__builtins__" in cmd or "__dict__" in cmd or "eval" in cmd or "import" in cmd or "globals" in cmd or ("TO_KEEP" and "[") in cmd:
            print("You can't touch that one sorry\n")
        else:
            print("---> ", cmd)
            if cmd == "":
                cmd = "print('Command looks empty')"
            exec("res="+cmd, res["res"])
            print(res)
            print()

        clear_vars(vars) # Clearing the variables to avoid the forgery of payloads in multiple commands
    except:
        print("Oups, something went wrong")
        exit()