/**
 * Install dependencies
 * yarn add -D axios
 */

import axios from "axios";
import { computed, watch } from "vue";

export default (options = {}) => {
  options = {
    autoSubmit: false,
    url: false,
    method: false,
    params: {},
    data: {},
    response: false,
    ...options,
  };

  ["url", "params", "method", "data"].map((attr) => {
    if (typeof options[attr] == "function") {
      options[attr] = computed(options[attr]);
    }
  });

  let _events = [];

  const r = reactive({
    ...options,
    ready: false,
    busy: false,
    error: false,
    success: false,
    changed: false,
    t: false,

    errorField(field) {
      if (!r.error) return [];
      if (!r.error.fields) return [];
      return r.error.fields[field] || [];
    },

    submit() {
      if (r.busy) return;
      return new Promise((resolve, reject) => {
        if (r.t) {
          clearTimeout(r.t);
          r.t = false;
        }

        r.success = false;
        r.error = false;
        r.busy = true;
        r.dispatch('submit:before');

        r.t = setTimeout(async () => {
          try {
            r.dispatch('submit');

            const resp = await (async () => {

              // If is upload
              if (Object.values(r.data).filter(value => value instanceof File).length > 0) {
                const formData = new FormData();
                for(let i in r.data) {
                  formData.append(i, r.data[i]);
                }

                return await axios.post(r.url, formData, {
                    headers: { 'Content-Type': 'multipart/form-data' },
                    params: r.params,
                });
              }

              return await axios({
                url: r.url,
                method: r.method,
                params: r.params,
                data: r.data,
              });
            })();

            r.dispatch('success', resp);
            r.dispatch('response');

            r.response = resp.data;
            r.success = true;
            r.changed = false;
            resolve(resp);
          } catch (err) {
            r.error = err.response ? err.response.data : { message: err.message };
            r.busy = false;
            r.dispatch('error', r.error);
            r.dispatch('response');
            reject(err);
          }
          r.t = false;
          r.busy = false;
          r.ready = true;
        }, 1000);
      });
    },

    on(events, callback) {
        (Array.isArray(events) ? events : [ events ]).map((event) => {
            _events.push({ event, callback });
        });
    },

    dispatch(eventsNames, arg1=null) {
        (Array.isArray(eventsNames) ? eventsNames : [ eventsNames ]).map((eventName) => {
            _events.map(({ event, callback }) => {
                if (eventName != event) return;
                callback(arg1);
            });
        });
    },
  });

  r.dispatch('init');

  if (r.autoSubmit) {
    r.submit();
  }

  watch(r.data, () => {
    r.changed = true;
  });

  return r;
};