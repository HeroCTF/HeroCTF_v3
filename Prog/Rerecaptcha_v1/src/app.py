from flask import Flask, session, redirect, request, render_template
from flask_session import Session
import redis
import urllib

from PIL import Image, ImageDraw, ImageFont
from random import randint as ri
from random import randrange as rr
from random import choice as rc

import base64, os
from io import BytesIO

app = Flask(__name__)

app.config['SECRET_KEY'] = os.urandom(64)
app.config['SEND_FILE_MAX_AGE_DEFAULT'] = 0
app.config['SESSION_TYPE'] = 'redis'
app.config['SESSION_PERMANENT'] = False
app.config['SESSION_USE_SIGNER'] = True
app.config['SESSION_REDIS'] = redis.from_url('redis://redis:6379')

Session(app)


# Challenge specific functions ======================================================================


def generatePincode():

	signs = ['+', '-', 'x', 'x', 'x']
	equa  = ' '.join([
					str(ri(1,199)), rc(signs),
					str(ri(1,199)), rc(signs),
					str(ri(1,199))
					])
	return equa, str(eval(equa.replace('x', '*')))


def generateCaptcha(pin):

	img = Image.new('RGB', (6*len(pin)+20, 30), color='white')
	h, w = img.size

	fnt = ImageFont.truetype('static/ressources/Arial.ttf', 12)

	d = ImageDraw.Draw(img)

	d.rectangle([(0,0), img.size], fill=rr(65535))
	d.fontmode = "1"
	d.text((7,7), pin, font=fnt, fill=0)
	d.line((0, rr(w), h*2, rr(w)), fill=rr(65535))

	c = rr(65535)
	for _ in range(h*w//32):
		d.point((rr(h),rr(w)), c)

	img.save("/tmp/image.png", format="PNG")
	buffered = open("/tmp/image.png","rb").read()

	return urllib.parse.quote_plus(base64.b64encode(buffered))


# Basic route and error handling =============================================================================


@app.errorhandler(404)
def http_404_handler(error):
	return redirect('/')

@app.errorhandler(500)
def http_500_handler(error):
	return redirect('/')


@app.route('/')
def index():
	return render_template('index.html')


# Login route handler  =======================================================================================


@app.route('/login', methods = ['GET'])
def login_get():
	if 'status' not in session:
		session['status'] = ''

	equa, session['pincode'] = generatePincode()
	captcha = generateCaptcha(equa)

	status = session['status']

	return render_template('login.html', status=status, captcha=captcha)


@app.route('/login', methods = ['POST'])
def login_post():

	if not ('pincode' in request.form and 'username' in request.form and 'password' in request.form):
		session['status'] = "Malformed request, missing parameter"
		return redirect(request.url)

	elif request.form['pincode'] == request.form['username'] == request.form['password'] == '':
		session['status'] = ''
		return redirect(request.url)

	if not request.form['pincode'] or request.form['pincode'] != session['pincode'] :
		session['status'] = "Invalid pincode"
		return redirect(request.url)

	elif ( request.form['username'] and request.form['password'] ) \
		and ( request.form['username'] == 'admin' and request.form['password'] == 'suckit' ) :

		session['status'] = r'victory !!'
		return render_template('flag.html')

	else:
		session['status'] = 'Invalid login or password'
		return redirect(request.url)

if __name__ == '__main__':
	app.run('0.0.0.0')
