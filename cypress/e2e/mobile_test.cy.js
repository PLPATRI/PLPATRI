describe('Teste em mobile', () => {
  it('Simula um Android', () => {
    // Exemplo: Pixel 2
    cy.viewport('iphone-x'); // ou 'ipad-2', 'macbook-15', 'samsung-note9', etc.

    // Para Android específico
    cy.viewport(411, 731); // largura x altura em pixels, ex: Pixel 2
    cy.visit('https://pinion.app/');
  });
});
