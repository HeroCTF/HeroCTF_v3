from random import randint
import time
import base64
import sys

flag = "Hero{u_4r3_b3tt3r_th4n_4_r0b0t_!!}"

def createChallenge():
    rand = []
    with open("market.txt","r") as lines:
        for line in lines:
            rand.append(line.strip("\n"))
    realChall = []
    nb = randint(50,128)
    for i in range(nb):
        index = randint(0,len(rand)-1)
        realChall.append(rand[index])
        del rand[index]
    totalPrice = 0
    for r in realChall:
        totalPrice += int(r.split(":")[2])
    return realChall,totalPrice

def challenge(chall,total):
    totalPriceComputeByUser = 0
    for c in chall:
        img = c.split(":")[0]+".png"
        food = c.split(":")[1]
        price = c.split(":")[2]
        toSend = open("barcodes/"+img,"rb").read()
        toSend = base64.b64encode(toSend)
        start_time = time.time()
        priceByUser = input("What's the price for this article: "+toSend.decode()+"\n")
        if(time.time() - start_time > 0.2):
            print(f"Beeeeeeeeeeep too late! Your total is {total}$ !")
            sys.exit(-1)
        else:
            if(priceByUser == price):
                totalPriceComputeByUser += int(priceByUser)
                print(f"Correct ! The price for {food} is {priceByUser}$ !")
            else:
                print(f"Beeeeeeeeeeep this price is incorrect! The price was {price}$")
                print(f"I will do it for you...\nYour total is {total}$ !")
                sys.exit(-1)
    print("Ooooh... It's a little embarrassing, you're done calculating before me.")
    print(f"WELL DONE ! You deserve a reward, take it: {flag}")
    return

def main():
    chall = createChallenge()
    price = chall[1]
    food = chall[0]
    print("""
            Welcome to Hero's Market !
            I know what you want because I'm a super AI !

            I will scan barcodes for you and give you the total.

            If you want you can test me, and try to calculate the finale price before me !
    """)
    choice = input("Do you want to try?(y/n)")
    while(choice != "y" and choice != "n"):
        choice = input("Do you want to try?(y/n)")
    if(choice == "n"):
        print(f"Oh okay no problem, your total is {price}$")
    else:
        challenge(food,price)
        return

if __name__ == "__main__":
    main()
    sys.exit(-1)
