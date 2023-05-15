FROM node:14.20.1

WORKDIR /var/www/html/

COPY package.json ./

RUN npm install

COPY . .

CMD npm run dev