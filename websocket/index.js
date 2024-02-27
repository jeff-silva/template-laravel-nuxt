const express = require('express');
const { createServer } = require('node:http');
const { Server } = require('socket.io');

const app = express();
const server = createServer(app);
const io = new Server(server, {
  cors: { origin: "*" },
});

const rooms = {};

io.on('connection', (socket) => {
  const _log = (a) => {
    console.log(a);
  };
  
  console.log('client in', socket.id);

  io.of("/").adapter.on("create-room", (room) => {
    _log(`room ${room} was created`);
  });
  
  io.of("/").adapter.on("delete-room", (room) => {
    _log(`room ${room} was deleted`);
  });

  io.of("/").adapter.on("join-room", (room, id) => {
    rooms[room] = {};
    _log(`socket ${id} has joined room ${room}`);
    // rooms.push(room);
  });
  
  io.of("/").adapter.on("leave-room", (room, id) => {
    delete rooms[room];
    // rooms.splice(rooms.indexOf(room), 1);
    _log(`socket ${id} has left room ${room}`);
  });

  socket.on('message', (message, room) => {
    console.log('Mensagem recebida:', { message, room });
    socket.broadcast.emit('message', message);
  });

  // setInterval(() => {
  //   let data = {};
  //   data.random = Math.round(Math.random() * 9999);
  //   data.rooms = rooms;
    
  //   // data.rooms = [...socket.rooms];
  //   // data.rooms = [...io.of('/').adapter.rooms];
  //   // data.sids = [...io.of('/').adapter.sids];

  //   console.log('interval', data);
  //   // socket.broadcast.emit('interval', data);
  // }, 3000);

  socket.on('disconnect', () => {
    console.log('client out');
  });
});

server.listen(80);