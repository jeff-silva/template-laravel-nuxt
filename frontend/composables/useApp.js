import { reactive } from 'vue';
import axios from 'axios';

export default () => {
    const r = defineStore("app", () => {
        let appEvents = [];

        return reactive({
            ready: false,
            busy: false,
            data: {},
            async init() {
                if (this.ready) return;
                this.busy = true;
                const { data } = await axios.get('/api/app/load');
                this.data = data;
                this.busy = false;
                this.ready = true;
                this.dispatch('init');
            },
            async refresh() {
                this.busy = true;
                const { data } = await axios.get('/api/app/load');
                this.data = data;
                this.busy = false;
                this.ready = true;
                this.dispatch('refresh');
            },
            on(events, callback) {
                (Array.isArray(events) ? events : [ events ]).map((event) => {
                    appEvents.push({ event, callback });
                });
            },
            dispatch(eventsNames) {
                (Array.isArray(eventsNames) ? eventsNames : [ eventsNames ]).map((eventName) => {
                    appEvents.map(({ event, callback }) => {
                        if (eventName != event) return;
                        callback();
                    });
                });
            },
        });
    })();

    r.init();

    return r;
};