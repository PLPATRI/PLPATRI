const { defineConfig } = require("cypress");

module.exports = defineConfig({
  projectId: "fng82i", // seu ID no Cypress Cloud
  video: true, // grava vídeos das execuções
  screenshotOnRunFailure: true, // tira screenshot quando um teste falha

  e2e: {
    // Caminho onde o Cypress vai procurar seus testes
    specPattern: "cypress/e2e/**/*.cy.{js,jsx,ts,tsx}",

    // Pasta de suporte (onde ficam comandos customizados, hooks, etc)
    supportFile: "cypress/support/e2e.js",

    setupNodeEvents(on, config) {
      // você pode adicionar plugins ou listeners aqui no futuro
      return config;
    },
  },

  // Define onde salvar os vídeos e screenshots
  videosFolder: "cypress/videos",
  screenshotsFolder: "cypress/screenshots",
});



