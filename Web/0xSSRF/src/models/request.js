const http = require('http');

const request = function (host, callback, error) {
    http.get(host, (resp) => {
        let data = '';
        
        // A chunk of data has been received.
        resp.on('data', (chunk) => {
            data += chunk;
        });
        
        // The whole response has been received. Print out the result.
        resp.on('end', () => {
            callback(data);
        });
        
        resp.on("error", (err) => {
            error(err)
        });
    });
}

module.exports = request;