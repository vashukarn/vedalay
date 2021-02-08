//socket stuff //
// const http = require('http').Server();
const http = require("https");
const fs = require('fs');
// const cors = require('cors');
//const httpServer = http.createServer(app);
const app = require('express')();
// app.use(() => {
//     cors();
//     next();
// });
const httpsServer = http.createServer({
    key: fs.readFileSync('/etc/letsencrypt/live/shreevahan.com.np/privkey.pem'),
    cert: fs.readFileSync('/etc/letsencrypt/live/shreevahan.com.np/fullchain.pem'),
}, app);

// const io = require('socket.io')(http);
const io = require("socket.io")(httpsServer, {
    cors: {
        origin: [
            "http://localhost:8000",
            "http://127.0.0.1:8000",
            "http://192.168.1.43:8000",
            "https://shreevahan.com.np",
            "http://shreevahan.com.np",
            "https://www.shreevahan.com.np",
            "https://shreevahan.com.np",
            "http://www.shreevahan.com.np",
            "http://shreevahan.com.np"
        ],
        // origin: "*",
        methods: ["GET,POST"],
        allowedHeaders: "*",
        credentials: true
    }
});
// io.set("origins", "https://shreevahan.com.np");
const Redis = require('ioredis');

const port = 4000;
const redis = new Redis({
    port: 6379, // Redis port
    host: "127.0.0.1", // Redis host
    family: 4, // 4 (IPv4) or 6 (IPv6)
    password: "",
    //   db: ,
});
// var user_id = localStorage.getItem("c_id");
var user_id = 1;

redis.psubscribe('*', function(err, count) {});
//  io.on('connection', socket => {
//      socket.emit('message-service', )
//  })
// io.sockets.emit('subscribe', {
//     channel: 'message-service'
// })
redis.on('pmessage', function(subscribed, channel, eventData) {
    // console.log('Message recieved: ' + eventData);
    console.log('Channel: ' + channel);
    message = JSON.parse(eventData);
    console.log('event data are ', eventData);
    // io.emit(channel + ':' + message.event, message.data);
    // io.broadcast.to(message.data).emit(channel + ':' + message.event, message.data);
    // if (message.data.message_from == 'admin') {
    // } else {
    // }
    // io.emit(message.event, message.data);
    io.emit(message.event, message.data);
    // io.broadcast.to(eventData.data.message.).emit(channel + ':' + message.event, message.data);
});
httpsServer.listen(port, function() {
    console.log('Listening on Port: ', port);

});
var countAdmin = 0;
var users = [];
io.sockets.on('connection', function(socket) {
    console.log(socket.handshake.headers.host);
    console.log(socket.id);

    socket.on('new-user', function(data) {
        console.log(data);
        io.sockets.emit('hello', 'You are conneted to socket server');
    })
    console.log('New User connected to live chat server');
    socket.on('typingStarted', function(data) {
        console.log(data);
        // io.broadcast.to(message).emit(channel + ':' + message.event, message.data);
    })
    countAdmin++;
    io.sockets.emit('AdminOnline', { countAdmin: countAdmin });
    socket.on('disconnect', function() {
        countAdmin--;
        io.sockets.emit('countAdmin', { countAdmin: countAdmin });
    });
});