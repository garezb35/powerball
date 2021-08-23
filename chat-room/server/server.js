const express = require('express')
const {knex} = require('./config/config')
const colors = require('colors')
const path = require('path')
const socketIO = require('socket.io')
const https = require('https')
var fs = require('fs');
const app = express()
const port = process.env.PORT
var options = {
    key: fs.readFileSync('mstball_com.key'),
    cert: fs.readFileSync('mstball_com.crt'),
    ca: fs.readFileSync('mstball_com.ca')
};
const server = https.createServer(options,app)
module.exports.io = socketIO(server, {
    cors: {
        origin: ["mstball.com:8087","mstball.com"],
        credentials: true
    }
});
module.exports.knex = knex;
require('./sockets/socket')

server.listen(port, (error) =>{
    if(error) throw new Error(error)
    else console.log(`Server listening on port ${colors.yellow(port)}`)
})
