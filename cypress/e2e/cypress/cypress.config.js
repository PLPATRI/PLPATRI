const { defineConfig } = require('cypress');

module.exports = defineConfig({
  e2e: {
    defaultCommandTimeout: 10000,
    screenshotOnRunFailure: true,
    video: true,
    videoUploadOnPasses: true, // salva vídeo mesmo se o teste passar
    videosFolder: 'cypress/evidencias/videos',
    setupNodeEvents(on, config) {},
  },
});





/* const { defineConfig } = require('cypress');

module.exports = defineConfig({
  e2e: {
    screenshotOnRunFailure: true, // screenshots automáticos ao falhar
    video: true,                   // habilita gravação de vídeo
    defaultCommandTimeout: 10000,
  },
});


const { defineConfig } = require("cypress");

module.exports = defineConfig({
  e2e: {
    // tempo padrão de espera para comandos
    defaultCommandTimeout: 10000,

    // habilita screenshots automáticos ao falhar
    screenshotOnRunFailure: true,

    // habilita gravação de vídeos de todos os testes
    video: true,
    // se quiser, só mantém vídeo dos testes que falharem
    // videoUploadOnPasses: false,

    // pasta customizada para vídeos e screenshots (opcional)
    // videosFolder: 'cypress/evidencias/videos',
    // screenshotsFolder: 'cypress/evidencias/screenshots',

    setupNodeEvents(on, config) {
      // eventos do Cypress podem ser adicionados aqui
      // ex: on('after:screenshot', (details) => { console.log(details.path) })
    },
  },
});
 */