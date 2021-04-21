
BALANCE = 0
CURRENT_BETS = dict([])

import random
import numpy as np

def menu(first):
    global BALANCE


    if BALANCE < 0:
        print('Are you @Huriken ? BECAUSE YOU OWE US MONEY RIGHT NOW.\nAYE, GET THE FUCK OUTTA HERE !')
        exit(0)

    if first:
        print('Welcome to the CASIIIIIIINOOOOO.\nTo begin with, we\'ll give you 100$\nAfter that, you\'ll need to top up your account ..\n')
        BALANCE += 100

    print('\n1 : Place a bet')
    print('2 : See your current balance')
    print('3 : See your current bets')
    print('4 : Run the roulette (BOOSTED x72 !) [totally not rigged btw]')
    print('5 : Shop')
    print('6 : Top-up your account')
    print('7 : Exit')

    while True:
        try:
            choice = int(input('>>> '))
            if choice < 0 or choice > 7:
                raise ValueError
        except ValueError:
            taunts = ['You can\'t', 'Are you high ?', 'Did you smoke ?', 'Ehhh, nope.', 'Your input isn\'t valid', 'WTF ?', 'Stop that.', 'You\'ll lose anyway', 'Sad boi.']
            print(random.choice(taunts))
            menu(False)
        else:
            if choice == 1:
                bet()
            elif choice == 2:
                balance()
            elif choice == 3:
                see_bets()
            elif choice == 4:
                roulette()
            elif choice == 5:
                shop()
            elif choice == 6:
                print('\nUh-oh, we have a pay-2-win type of person here !')
                print('Shame on you.')
            elif choice == 7:
                print('Aight, bye. Come back whenever !')
                exit(0)
            #### DBG !!!!
            #elif choice == 8:
            #    for i in range(37):
            #        CURRENT_BETS[i] = 200
            menu(False)


def balance():
    global BALANCE
    print('\nYour current balance is {}$ !'.format(BALANCE))

def shop():
    global BALANCE

    print('\n Welcome to the shop ! What do you want to buy ?')
    print('1 : Lucky charm (100$)\n >>> Could it unrig the game ? I doubt it.')
    print('2 : Alcohol (3$)\n >>> Will it do something ? (spoiler : nope)')
    print('3 : The FLAG ! (3600$)\n >>> That\'s what you want, right ? ;)')

    while True:
        try:
            choice = int(input('>>> '))
            if choice < 0 or choice > 3:
                raise ValueError
        except ValueError:
            taunts = ['You can\'t', 'Are you high ?', 'Did you smoke ?', 'Ehhh, nope.', 'Your input isn\'t valid', 'WTF ?', 'Stop that.', 'You\'ll lose anyway', 'Sad boi.']
            print(random.choice(taunts))
            menu(False)
        else:
            if choice == 1:
                if BALANCE < 100:
                    print('You don\'t have enough money to buy this.')
                    return
                BALANCE -= 100
                print('Fine, you bought a lucky charm. What now ? Out of money ?')

            elif choice == 2:
                if BALANCE < 3:
                    print('You don\'t have enough money to buy this.')
                    return
                BALANCE -= 3
                print('Annnnnd now you\'re drunk. Feeling better ?')
            elif choice == 3:
                if BALANCE < 3600:
                    print('You don\'t have enough money to buy this.')
                    return
                BALANCE -= 3600
                print('There is your flag king ! Hero{g4MBl1nG_f0R_dA_fL4G}')
        return

def see_bets():
    global CURRENT_BETS

    if not CURRENT_BETS:
        print('You don\'t have any ongoing bet')
        return

    print('\n#### CURRENT BETS ####\n')
    for keys, values in CURRENT_BETS.items():
        print('You have a {}$ bet on #{}, you could win {}$'.format(values, keys, values*72))

    print('\n######################')

def bet():
    
    global CURRENT_BETS
    global BALANCE

    message = '\nWhat number do you want to bet on ? (0-36)\n>>> '
    while True:
        try:
            bet = int(input(message))
            if bet < 0 or bet > 36:
                raise ValueError
        except ValueError:
            taunts = ['Are you high ?', 'Did you smoke ?', 'Ehhh, nope.', 'Your input isn\'t valid', 'WTF ?', 'Stop that.', 'You\'ll lose anyway', 'Sad boi.']
            print(random.choice(taunts))
            continue
        else:
            break

    message = 'How much do you wanna bet ? (max : {}$)\n>>> '.format(BALANCE)
    while True:
        try:
            amount = int(input(message))
            if amount < 0 or amount > BALANCE:
                raise ValueError
        except ValueError:
            taunts = ['You can\'t', 'Are you high ?', 'Did you smoke ?', 'Ehhh, nope.', 'Your input isn\'t valid', 'WTF ?', 'Stop that.', 'You\'ll lose anyway', 'Sad boi.']
            print(random.choice(taunts))
            continue
        else:
            break
    
    CURRENT_BETS[bet] = amount
    print('Okayyyy, your {}$ bet on #{} has been placed. You could potentially win {}$'.format(amount, bet, amount*72))

def roulette():
    global BALANCE
    global CURRENT_BETS

    results = range(37)


    bets_list = CURRENT_BETS.keys()

    if not bets_list:
        print('You have to place bets before you run the roulette.')
        return

    if list(sorted(bets_list)) != list(results):
        possibilities = np.setdiff1d(results, bets_list)
        result = random.choice(possibilities)
        for keys, values in CURRENT_BETS.items():
            print('Oooh, too bad, you chose {} but the number is {}. You lose {}$. Totally not rigged btw.'.format(keys, result, values))
            BALANCE -= values
    else:
        result = random.choice(results)
        for keys, values in CURRENT_BETS.items():
            print("k,v :", keys, values)
            if keys == result:
                print('Ahah, you .. WHAT ? How did you manage to win ? It\'s imposs.. \nCongrats man !')
                print('You won {}$. Use them well !'.format(values * 72))
                BALANCE += values * 72
            else:
                print('Oooh, too bad, you chose {} but the number is {}. You lose {}$. Totally not rigged btw.'.format(keys, result, values))
                BALANCE -= values

    print('Current balance : {}$'.format(BALANCE))
        
menu(True)
