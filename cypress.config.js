const { defineConfig } = require('cypress');

module.exports = defineConfig({
  e2e: {
    baseUrl: 'http://127.0.0.1:8000',
    testIsolation: false,
    video: true,
    screenshotOnRunFailure: true,
    videoCompression: 32,
    viewportWidth: 1280,
    viewportHeight: 720,
    defaultCommandTimeout: 15000, // Aumentado de 10000
    pageLoadTimeout: 60000,       // Aumentado de 30000
    requestTimeout: 15000,        // Adicionado
    responseTimeout: 15000,       // Adicionado
    setupNodeEvents(on, config) {
      // implement node event listeners here
    },
  },
});