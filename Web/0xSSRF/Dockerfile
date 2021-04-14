FROM node:15.9.0-alpine3.10

WORKDIR /usr/app/
COPY ./src/ .

RUN npm install

CMD ["node", "app.js"]
EXPOSE 3000