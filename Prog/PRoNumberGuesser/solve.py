from randcrack import RandCrack
from pwn import*

HOST = "127.0.0.1"
PORT = 7003

s = remote(HOST, PORT)
rc = RandCrack()

print("[+] Gathering first 624 numbers")
for i in range(624):
    s.recvuntil("Guess me : ".encode())
    s.send("1\n".encode())
    data = s.recvuntil("try again\n".encode()).decode()
    number = int(data.split(" ")[3])
    rc.submit(number)

print("[+] Predicting next random number")
prediction = rc.predict_randrange(0, (2**32)-1)
print("|__ :", prediction)

print("[+] Sending back result")
s.recvuntil("Guess me : ".encode())
s.send((str(prediction)+"\n").encode())

print("\n"+s.recvline().decode())
s.close()