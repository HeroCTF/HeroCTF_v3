const path = require('path');
var express = require('express');
var router = express.Router();
const request = require('../models/request');

router.get('/', (req, res, next) => {
    res.sendFile(path.join(__dirname + '/../views/index.html'));
});

router.post('/check', (req, res, next) => {
  const host = req.body.host;

  if (host) {
        if (host.includes("localhost") || host.includes("127") ||
            host.includes("::") || host.includes("0x")) {
            res.send("Are you trying to hack me ?");
        } else {
            if (host.length > 18) {
                res.send("Sorry, the host is too long.");
            } else {
                request(host,
                    function callback(data) {
                        res.send(data);
                    },
                    function error(err) {
                        res.send(err.message);
                }); 
            }
        }
  } else {
    res.send('You need to provide a host !');
  }
});

router.get('/flag', (req, res, next) => {
    if (req.socket.remoteAddress === "::ffff:127.0.0.1") {
        res.send("Well played ! There is your flag : " + process.env.FLAG_SSRF);
    } else {
        res.send("Your IP address is not 127.0.0.1 !");
    }
});


module.exports = router;