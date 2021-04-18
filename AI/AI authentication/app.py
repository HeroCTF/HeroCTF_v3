from flask import Flask, render_template, send_from_directory, session, url_for, redirect, request
from flask_socketio import SocketIO, emit
import base64
from datetime import datetime
import cv2
import numpy as np
import face_recognition
import time
import hashlib

print('[INFO] loading face detection algorithm...')
face_cascade = cv2.CascadeClassifier('./haarcascade_frontalface_default.xml')

USER_AUTH = False
NONCES = []


app = Flask(__name__, static_url_path='')
app.config['SECRET_KEY'] = 'Do you wanna be my lover ? You have the right to remain silent !'
socketio = SocketIO(app)

@app.route('/main_assets/<path:path>')
def send_main(path):
	return send_from_directory('main_assets', path)

@app.route('/team_assets/<path:path>')
def send_team(path):
        return send_from_directory('team_assets', path)

@app.route('/about_assets/<path:path>')
def send_about(path):
        return send_from_directory('about_assets', path)

@app.route('/login_assets/<path:path>')
def send_login(path):
        return send_from_directory('login_assets', path)

@app.route('/')
def index():
        """Home page."""
        return render_template('main.html')

@app.route('/about')
def about():
        """About company."""
        return render_template('about_us.html')

@app.route('/team')
def team():
        """About team."""
        return render_template('team.html')

@app.route('/login')
def login():
        """Login page."""
        if 'failure' in session:
                session.pop('failure', None)
                return render_template('login.html', failure='Login failed !')
        else:
                return render_template('login.html', failure='')

@app.route('/flagzz')
def flagzz():
        """flagzz page."""
        authenticated = False
        if request.args.get('nonce') is not None:
                for items in NONCES:
                        if str(hashlib.sha256(items).hexdigest()) == request.args.get('nonce'):
                                authenticated = True
                                NONCES.remove(items)
                if authenticated:
                        return render_template('flagz.html')
                else:
                        session['failure'] = True
                        return redirect(url_for('login'))
        else:
                session['failure'] = True
                return redirect(url_for('login'))

@socketio.on('message')
def handle_message(data):
        print('received {}'.format(data))

@socketio.on('authentication')
def authenticate(data):

	global USER_AUTH

	image = base64.b64decode(data['data'].split(',')[1])
	image = np.frombuffer(image, dtype=np.uint8)
	image = cv2.imdecode(image, flags=1)

	dim = (320, 240)
	print('Authenticating ...')
        # resize image
	image = cv2.resize(image, dim, interpolation = cv2.INTER_AREA)

        #gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
        #faces = face_cascade.detectMultiScale(gray, 1.1, 4)
        # Draw rectangle around the faces
        #for (x, y, w, h) in faces:
		#d_rect = dlib.rectangle(x, y, w, h)
		#shape = sp(image, d_rect)
	ceo_image = face_recognition.load_image_file("1.jpg")
	person_encoding = face_recognition.face_encodings(image)[0]
	ceo_encoding = face_recognition.face_encodings(ceo_image)[0]

	results = face_recognition.compare_faces([ceo_encoding], person_encoding)

	print(results)
	if results[0] == True:
		USER_AUTH = True
		user_nonce = str(datetime.now()).encode()
		NONCES.append(user_nonce)
		hash = str(hashlib.sha256(user_nonce).hexdigest())
		emit('authentication', {'data': 'yes', 'nonce': hash})
	else:
		session['failure'] = True
		emit('authentication', {'data': 'nope'})

@socketio.on('stream')
def handle_image(data):
#	print('received img data' + str(data))
	image = base64.b64decode(data['data'].split(',')[1])
	image = np.frombuffer(image, dtype=np.uint8)
	image = cv2.imdecode(image, flags=1)

	dim = (320, 240)

	# resize image
	image = cv2.resize(image, dim, interpolation = cv2.INTER_AREA)

	gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
	faces = face_cascade.detectMultiScale(gray, 1.1, 4)
	# Draw rectangle around the faces
	for (x, y, w, h) in faces:
	    cv2.rectangle(image, (x, y), (x+w, y+h), (255, 0, 0), 2)

	image = cv2.imencode('.png', image)
	image = base64.b64encode(image[1])

	emit('streamback', {'data' : image})
#	with open(str(datetime.now()) + '.jpg', 'wb') as f:
#		f.write(image)
#	print(data)
#	print('#'*50)

if __name__ == '__main__':
	socketio.run(app, '0.0.0.0', 5000, keyfile='key.pem', certfile='cert.pem')
	print('[INFO] app running ..')
