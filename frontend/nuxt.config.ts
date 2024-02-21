// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  ssr: false,
  devtools: { enabled: true },
  // app: { baseURL: '/xxx/' },

  modules: [
    ['@pinia/nuxt', {}],
  ],

  runtimeConfig: {
    public: {
      DEV_MODE: (process.env.NODE_ENV == 'development'),
      BACKEND_PORT: process.env.BACKEND_PORT,
    },
  },
});