import axios from "axios";

export default defineNuxtPlugin(async (nuxtApp) => {
    const conf = useRuntimeConfig();
    console.log(conf);

    axios.interceptors.request.use((config) => {
        if (config.url.startsWith("/api")) {
            if (conf.public.DEV_MODE) {
                config.url = `http://localhost:${conf.public.BACKEND_PORT}${config.url}`;
            }

            if (typeof localStorage != 'undefined') {
                const access_token = localStorage.getItem('access_token');
                config.headers["Authorization"] = `Bearer ${access_token}`;
            }
        }
    });
});