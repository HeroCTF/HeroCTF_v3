dicov1 = {
    'Wow wtf ?':'XipH+jukexCE',
    'So u think':'miObu7TkyJ4/y3==',
    'you can beat me ?':'f0pF+JAP9xTxe0ck+JF4+GO=',
    'Well...':'XiXN9wZ/Sb==',
    'why not !':'uiPW+JWLuwCP',
    'but remember :':'lrXk+jn490XtlaXv+G5b',
    'i am the B0SS':'y7TP97TkyJmbQVTom3==',
    'of encryption':'9ilbe0WV1r43uJ4L9b==',
    'don\'t play w1th m3':'eJp/nHQb1JBPf7THqI25+Jkz',
    'well you\'re not so far':'uiXN9wTW9Hmr1amb9apk+jAL+JeP1b==',
    'give me more':'ei4ie7Tte7Tt9Hn4',
    'another one ?':'l0WLuJP41xTL9ambs3==',
    '... Not yey :)':'SxZ/+hWLuwTWeIYbRxY=',
    'i\'m sorry buddy':'y7ut+jAL1rnW+JnFeJ2W',
    'let\'s decrypt':'9JXknHqbeJXV1r43uwC=',
    'some random words first':'1ipte7Tvl0WY9ikbuipvejqbea4v1HQ=',
    'har life, I know...':'yJcv+JBUeamN+hYbyiWLuvZ/Sb==',
    'oh sorry: "hard", not "har" :D':'9ibb1ipv1rY6+wn5lInY+x3b9apk+wn5lI+x+GUh',
    'car':'licv',
    'house':'yJpF1im=',
    'shower':'1iPLuiXv',
    'carpet':'licv1JXk',
    'sun':'1HX/',
    'The quick brown fox jumps over the lazy dog':'XJP4+jcFy0AM+Jnv9Hu/+JeLfwTgu0F31vTLuaXv+j25e7TNlIUW+J2Le3==',
    'John Doe':'7ap59xTh9im=',
    'Matrixxxxxx':'o0ck1a4ZfjPZfjb=',
    'do you know Elon Musk ?':'eJObf0pF+Jt/9H1b20BL9xTAuIAM+GO=',
    'wow an Alien':'uipH+Jc/+hcNy0X/',
    '(alien is quite a good film: change my mind)':'KJcNy0X/+J4z+jcFyI24+JhbeipLewTay0BtSwTVyJc/eimb9IYb904/ewY=',
    'ship':'1iPU1C==',
    'battle':'lackuJB4',
    'excuse my english btw':'eIPVuIA4+JFW+JX/eiBU1ibblr2H',
    'certainly made som mistakes':'liXvuJcU9aBW+JFPeJmb1ipt+JFU1H2PyiXz',
    'some* oh wow I\'m so bad':'1ipte75b9ibbuipH+hYr97Tz9vTxl0Q=',
    'but well':'lrXk+ju49J3=',
    'Because you didn\'t die in front of my english mistakes':'QaXVlIXze7TW9HmbeJ4Y9xuk+J2Ue7TU9xTa1ap/uwTLexTtf7T49auNyIA5+JFU1H2PyiXz',
    'I think that you maybe':'77TkyJ4/yvTkyJck+j4Lu7TtlI4xeQ==',
    'MAYBE........':'omceQYm/SxZ/SxZ/Sb==',
    'can have the flag':'lic/+JPPuambuJP4+JeNl01=',
    'Here you are (gg btw :D)':'7JXve7TW9HmblIn4+wPrevTxuj1bRYQU'
}

head = """
██╗  ██╗███████╗██████╗  ██████╗  ██████╗████████╗███████╗
██║  ██║██╔════╝██╔══██╗██╔═══██╗██╔════╝╚══██╔══╝██╔════╝
███████║█████╗  ██████╔╝██║   ██║██║        ██║   █████╗  
██╔══██║██╔══╝  ██╔══██╗██║   ██║██║        ██║   ██╔══╝  
██║  ██║███████╗██║  ██║╚██████╔╝╚██████╗   ██║   ██║     
╚═╝  ╚═╝╚══════╝╚═╝  ╚═╝ ╚═════╝  ╚═════╝   ╚═╝   ╚═╝     

=================== ARMada (by SoEasY) ===================
"""

def main():
    print(head)
    flagged = True
    dico = {v: k for k, v in dicov1.items()} # inversion du dico parce que jsuis teubé
    
    for key in dico.keys():
        print("New cipher : " + key)
        answer = str(input("--> Your answer : "))
        if(answer != dico[key]):
            flagged = False
            break
    
    if flagged:
        print("Hero{0h_w0W_s0_y0u_not1c3d_1t_w4s_cust0m_b64_?}")
    else:
        print("Nope... Try again :)")


if __name__ == "__main__":
    main()