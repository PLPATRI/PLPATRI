describe('Abrindo o sistema para testes', () => {
  it('passes', () => {
    cy.visit('http://127.0.0.1:8000/')
  })
})