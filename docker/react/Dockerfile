FROM node:20

WORKDIR /usr/src/app

COPY ./frontend ./

CMD npm start

RUN npm run build

EXPOSE 3000
CMD npm run dev
