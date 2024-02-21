<template>
    <div>
        <v-container>
            <v-btn :loading="app.busy" @click="app.refresh()">Refresh</v-btn>
            <pre>app: {{ app }}</pre>
            <pre>server: {{ server }}</pre>
        </v-container>
    </div>
</template>

<script setup>
import useApp from '@/composables/useApp';
import { onMounted, reactive } from 'vue';
const app = useApp();

const server = reactive({
    data: false,
});

app.on('init', () => {
    const stream = new EventSource("http://localhost:8000/api/app/stream");

    stream.addEventListener('progress', (ev) => {
        server.data = JSON.parse(ev.data);
    });
    
    stream.addEventListener('end', (ev) => {
        stream.close();
    });
});
</script>