import { reactive } from 'vue';
import axios from 'axios';

export default () => {
    const r = defineStore("app", () => {
        return reactive({
            ready: false,
            data: {},
            async init() {
                if (this.ready) return;
                const { data } = await axios.get('/api/app/load');
                this.data = data;
                this.ready = true;
            },
        });
    })();

    r.init();

    return r;
};