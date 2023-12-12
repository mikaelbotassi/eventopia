// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  devtools: { enabled: true },
  modules: [
    '@element-plus/nuxt',
    '@nuxtjs/tailwindcss',
    '@pinia/nuxt'
  ],
  css: [
    '@/assets/css/main.css',
  ],
  runtimeConfig: {
    public: {
      baseFrontUrl: 'http://localhost:3000',
      baseApiUrl: 'http://localhost:80',
    }
  }
})
