<template>
    <div>
        <nuxt-layout name="admin">
            <v-container>
                <v-row>
                    <v-col cols="2">
                        <v-list>
                            <template v-for="c in chat.chats">
                                <v-list-item @click="chat.chatConnect(c)">{{ c.id }}</v-list-item>
                            </template>
                        </v-list>
                    </v-col>
                    <v-col cols="10" v-if="chat.chat">
                        <v-textarea v-model="chat.chat.message" />
                        <v-btn @click="chat.chatMessageSend()">Send</v-btn>
                        <!-- <pre>{{ chat }}</pre> -->
                    </v-col>
                </v-row>
                <v-btn @click="socketEmitMessage('Aaa')">Aaa</v-btn>
                <v-btn @click="socketEmitMessage('Bbb')">Bbb</v-btn>
            </v-container>
        </nuxt-layout>
    </div>
</template>

<script setup>
import { io, Manager } from 'socket.io-client';
const socket = io("ws://localhost:8443");

socket.on('message', (ev) => {
    console.log(ev);
});

const socketEmitMessage = (message) => {
    socket.emit('message', { message });
    // socket.broadcast.emit('message', { message });
};

const socketEmitRoomMessage = (room, message) => {
    socket.emit('message', { message });
};

const manager = new Manager('ws://localhost:8443');

const chat = reactive({
    socket: false,
    chat: false,
    chats: [
        { id: 'chat1', message: '', messages: [] },
        { id: 'chat2', message: '', messages: [] },
    ],
    chatConnect(chat) {
        this.chat = chat;
        // this.socket = manager.socket(`/aaa`);
    },
    chatMessageSend() {
        // io.to(this.chat.id).emit({
        //     chat: this.chat,
        // });
    },
});
</script>