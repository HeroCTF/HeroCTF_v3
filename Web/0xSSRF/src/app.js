var createError = require('http-errors');
var express = require('express');
var path = require('path');

var indexRouter = require('./routes/routes');
var app = express();

app.use(express.json());
app.use(express.urlencoded({ extended: false }));
app.use(express.static(path.join(__dirname, 'public')));

app.use('/', indexRouter);

// catch 404 and forward to error handler
app.use(function(req, res, next) {
  next(createError(404));
});

app.listen(3000, () => console.log('App running'));

module.exports = app;