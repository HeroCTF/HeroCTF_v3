FROM node:14
WORKDIR /usr/src/app
COPY package*.json ./
RUN npm install
COPY . .
EXPOSE 3000
COPY ./flag.txt /our_real_names.txt
CMD ["node","index.js"]