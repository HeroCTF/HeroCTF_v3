from flask import Flask, session, redirect, request, render_template
from flask_session import Session
import base64, urllib, os
import redis

import random
import shutil

app = Flask(__name__)

app.config['SECRET_KEY'] = os.urandom(64)
app.config['SEND_FILE_MAX_AGE_DEFAULT'] = 0
app.config['SESSION_TYPE'] = 'redis'
app.config['SESSION_PERMANENT'] = False
app.config['SESSION_USE_SIGNER'] = True
app.config['SESSION_REDIS'] = redis.from_url('redis://redis:6379')

Session(app)


# Challenge specific variables/functions ======================================================================


def generatePincode():
	return str(random.randrange(1e5, 1e6))

def generateCaptcha(pin):
	dat = b''
	for c in pin:
		with open(f"static/ressources/{c}.mp3", 'rb') as f:
			dat += f.read()
	return urllib.parse.quote_plus(base64.b64encode(dat))


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

	session['pincode'] = generatePincode()
	captcha = generateCaptcha(session['pincode'])
	
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
		and ( request.form['username'] == 'admin' and request.form['password'] == 'tomcat' ) :
		
		session['status'] = r'victory !!'
		return render_template('flag.html')
	
	else:
		session['status'] = 'Invalid login or password'
		return redirect(request.url)

if __name__ == '__main__':
	app.run('0.0.0.0')
