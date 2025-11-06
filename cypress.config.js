const { defineConfig } = require('cypress');

module.exports = defineConfig({
  e2e: {
    baseUrl: 'http://127.0.0.1:8000',
    video: false, // ❌ DESABILITA VÍDEO (economiza MUITA memória)
    screenshotOnRunFailure: true,
    videoCompression: false, // Remove compressão (se vídeo habilitado)
    viewportWidth: 1280,
    viewportHeight: 720,
    defaultCommandTimeout: 15000,
    pageLoadTimeout: 60000,
    requestTimeout: 15000,
    responseTimeout: 15000,
    numTestsKeptInMemory: 0, // ✅ CRÍTICO: Libera memória de testes anteriores
    experimentalMemoryManagement: true, // ✅ Gerenciamento experimental de memória
    trashAssetsBeforeRuns: true, // ✅ Limpa arquivos antigos antes de executar
    setupNodeEvents(on, config) {
      // implement node event listeners here
    },
  },
});