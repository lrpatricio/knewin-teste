FROM node:alpine

RUN mkdir -p /node-app
WORKDIR /node-app
COPY node-app/package.json /node-app
RUN npm install
COPY node-app/. /node-app
CMD node --trace-warnings index.js