#!/usr/bin/env python3

dico = {
	'XipH+jukexCE': 'Wow wtf ?',
	'miObu7TkyJ4/y3==': 'So u think',
	'f0pF+JAP9xTxe0ck+JF4+GO=': 'you can beat me ?',
	'XiXN9wZ/Sb==': 'Well...',
	'uiPW+JWLuwCP': 'why not !',
	'lrXk+jn490XtlaXv+G5b': 'but remember :',
	'y7TP97TkyJmbQVTom3==': 'i am the B0SS',
	'9ilbe0WV1r43uJ4L9b==': 'of encryption',
	'eJp/nHQb1JBPf7THqI25+Jkz': "don't play w1th m3",
	'uiXN9wTW9Hmr1amb9apk+jAL+JeP1b==': "well you're not so far",
	'ei4ie7Tte7Tt9Hn4': 'give me more',
	'l0WLuJP41xTL9ambs3==': 'another one ?',
	'SxZ/+hWLuwTWeIYbRxY=': '... Not yey :)',
	'y7ut+jAL1rnW+JnFeJ2W': "i'm sorry buddy",
	'9JXknHqbeJXV1r43uwC=': "let's decrypt",
	'1ipte7Tvl0WY9ikbuipvejqbea4v1HQ=': 'some random words first',
	'yJcv+JBUeamN+hYbyiWLuvZ/Sb==': 'har life, I know...',
	'9ibb1ipv1rY6+wn5lInY+x3b9apk+wn5lI+x+GUh': 'oh sorry: "hard", not "har" :D',
	'licv': 'car',
	'yJpF1im=': 'house',
	'1iPLuiXv': 'shower',
	'licv1JXk': 'carpet',
	'1HX/': 'sun',
	'XJP4+jcFy0AM+Jnv9Hu/+JeLfwTgu0F31vTLuaXv+j25e7TNlIUW+J2Le3==': 'The quick brown fox jumps over the lazy dog',
	'7ap59xTh9im=': 'John Doe',
	'o0ck1a4ZfjPZfjb=': 'Matrixxxxxx',
	'eJObf0pF+Jt/9H1b20BL9xTAuIAM+GO=': 'do you know Elon Musk ?',
	'uipH+Jc/+hcNy0X/': 'wow an Alien',
	'KJcNy0X/+J4z+jcFyI24+JhbeipLewTay0BtSwTVyJc/eimb9IYb904/ewY=': '(alien is quite a good film, change my mind)',
	'1iPU1C==': 'ship',
	'lackuJB4': 'battle',
	'eIPVuIA4+JFW+JX/eiBU1ibblr2H': 'excuse my english btw',
	'liXvuJcU9aBW+JFPeJmb1ipt+JFU1H2PyiXz': 'certainly made som mistakes',
	'1ipte75b9ibbuipH+hYr97Tz9vTxl0Q=': "some* oh wow I'm so bad",
	'lrXk+ju49J3=': 'but well',
	'QaXVlIXze7TW9HmbeJ4Y9xuk+J2Ue7TU9xTa1ap/uwTLexTtf7T49auNyIA5+JFU1H2PyiXz': "Because you didn't die in front of my english mistakes",
	'77TkyJ4/yvTkyJck+j4Lu7TtlI4xeQ==': 'I think that you maybe',
	'omceQYm/SxZ/SxZ/Sb==': 'MAYBE........',
	'lic/+JPPuambuJP4+JeNl01=': 'can have the flag',
	'7JXve7TW9HmblIn4+wPrevTxuj1bRYQU': 'Here you are (gg btw :D)'
}

banner = """
██╗  ██╗███████╗██████╗  ██████╗  ██████╗████████╗███████╗
██║  ██║██╔════╝██╔══██╗██╔═══██╗██╔════╝╚══██╔══╝██╔════╝
███████║█████╗  ██████╔╝██║   ██║██║        ██║   █████╗  
██╔══██║██╔══╝  ██╔══██╗██║   ██║██║        ██║   ██╔══╝  
██║  ██║███████╗██║  ██║╚██████╔╝╚██████╗   ██║   ██║     
╚═╝  ╚═╝╚══════╝╚═╝  ╚═╝ ╚═════╝  ╚═════╝   ╚═╝   ╚═╝     

=================== ARMada (by SoEasY) ===================
"""

def main():
	print(banner)
	flagged = True

	for key in dico.keys():
		print("New cipher : " + key)
		try:
			answer = input("--> Your answer : ")
			if answer != dico[key]:
				flagged = False
				break
			else:
				print("Nice job !")
		except KeyboardInterrupt:
			print("Bye !")

	if flagged:
		print("Hero{0h_w0W_s0_y0u_not1c3d_1t_w4s_cust0m_b64_?}")
	else:
		print("Nope... Try again :)")


if __name__ == "__main__":
	main()
