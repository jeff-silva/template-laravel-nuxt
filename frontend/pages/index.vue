<template>
    <div>
        <v-container>
            <v-btn :loading="app.busy" @click="app.refresh()">Refresh</v-btn>
            <v-btn :loading="login.busy" @click="login.submit()">Login</v-btn>
            <pre>app: {{ app }}</pre>
            <pre>login: {{ login }}</pre>
        </v-container>
    </div>
</template>

<script setup>
import useApp from '@/composables/useApp';
const app = useApp();

import useAxios from '@/composables/useAxios';

const server = reactive({
    data: false,
});

const login = useAxios({
    url: '/api/auth/login',
    method: 'post',
    data: { email: 'main@grr.la', password: 'main@grr.la' },
});
</script>