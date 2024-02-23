<template>
    <div>
        <nuxt-layout name="admin">
            <v-container>
                <div class="d-flex" style="gap:10px;">
                    <v-btn :loading="app.busy" href="?">Refresh</v-btn>
                    <v-btn :loading="login.busy" @click="login.submit()">Login</v-btn>
                    <v-btn @click="logout()">Logout</v-btn>
                    <div v-if="app.data.user" class="py-2">{{ app.data.user.name }}</div>
                </div>
                <!-- <pre>app: {{ app }}</pre> -->
                <!-- <pre>login: {{ login }}</pre> -->
                <pre>user: {{ user }}</pre>
            </v-container>
        </nuxt-layout>
    </div>
</template>

<script setup>
import useApp from '@/composables/useApp';
const app = useApp();

import useAxios from '@/composables/useAxios';

const login = useAxios({
    url: '/api/auth/login',
    method: 'post',
    data: { email: 'main@grr.la', password: 'main@grr.la' },
    events: [
        { event: 'success', callback: (resp) => {
            localStorage.setItem('access_token', resp.data.access_token);
            app.refresh();
        } },
    ],
});

const logout = async () => {
    localStorage.setItem('access_token', '');
    app.refresh();
};

const user = useAxios({
    method: 'get',
    url: '/api/app_user',
    autoSubmit: true,
});
</script>