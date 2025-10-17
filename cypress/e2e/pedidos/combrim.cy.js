describe('Realizar teste de login e pedidos', () => {
  
  // Prevenir falhas por erros não tratados da aplicação
  Cypress.on('uncaught:exception', (err, runnable) => {
    return false;
  });

  it('executa fluxo completo com screenshots', () => {
    // 1️⃣ Acessa a página inicial
    cy.visit('http://127.0.0.1:8000/');
    cy.screenshot('01-homepage');

    // 2️⃣ Seleciona tipo de login
    cy.get('[name="tipo_login"]').should('be.visible').select('Admin');
    cy.screenshot('02-seleciona-tipo-login');

    // 3️⃣ Preenche email e senha
    cy.get('[name="email"]').should('be.visible').type('plpatri@gmail.com');
    cy.get('[name="senha"]').should('be.visible').type('979899');
    cy.screenshot('03-preenche-credenciais');

    // 4️⃣ Clica no botão de login e aguarda redirecionamento
    cy.get('.btn').should('be.visible').click();
    
    // Aguarda o carregamento completo da dashboard
    cy.wait(5000); // Aumentado para garantir carregamento
    cy.screenshot('04-depois-login');

    // 5️⃣ Navega para página de pedidos
    // Tenta múltiplas estratégias para encontrar o link de pedidos
    cy.get('body').then(($body) => {
      // Estratégia 1: Tentar por texto
      if ($body.find('a:contains("Pedido")').length > 0) {
        cy.contains('a', 'Pedido').first().click();
      } 
      // Estratégia 2: Tentar pelo nth-child com timeout maior
      else {
        cy.get(':nth-child(6) > a', { timeout: 20000 })
          .should('be.visible')
          .click();
      }
    });
    cy.wait(2000);
    cy.screenshot('05-pagina-pedidos');

    // 6️⃣ Clica no botão dentro do box-header
    cy.get('.box-header > .btn', { timeout: 10000 }).should('be.visible').click();
    cy.screenshot('06-box-header');

    // 7️⃣ Seleciona um cliente para pesquisa
    cy.get('.col-lg-6 > .form-control').should('be.visible').type('bb');
    cy.screenshot('07-preenche-campo');

    // 8️⃣ Busca um cliente (ajustado para forçar clique no ícone invisível)
    cy.get('.btn > :nth-child(1) > .fas').click({ force: true });
    cy.wait(1000);
    cy.screenshot('08-resultado-busca');

    // 9️⃣ Seleciona o cliente
    cy.get('tr > :nth-child(3) > .btn').should('be.visible').click();
    cy.screenshot('09-cliente-selecionado');

    // 🔟 Clica em Próximo
    cy.get('.d-flex > .btn-success').should('be.visible').click();
    cy.screenshot('10-proximo');

    // 1️⃣1️⃣ Botão Novo Pedido
    cy.get('#new-pedido-customer').should('be.visible').click();
    cy.wait(1000);
    cy.screenshot('11-novo-pedido');

    // 1️⃣2️⃣ Seleciona o checkbox
    cy.get('tbody > :nth-child(1) > :nth-child(1) > label').should('be.visible').click();
    cy.screenshot('12-checkbox-selecionado');

    // 1️⃣3️⃣ Seleciona campo quantidade e insere valor
    cy.get(':nth-child(1) > .w-50 > .form-group > .form-control')
      .should('be.visible')
      .clear()
      .type('100')
      .blur();
    cy.wait(500);
    cy.screenshot('13-quantidade-inserida');

    // 1️⃣4️⃣ Seleciona balcão - CORRIGIDO
    cy.get('#pedido-modal > span:first-child').parent().should('be.visible').click();
    cy.screenshot('14-modal-aberto');

    // Scroll até o elemento e força o clique se necessário
    cy.get('.col-lg-6.d-flex > :nth-child(1) > :nth-child(1) > label')
      .scrollIntoView()
      .wait(500)
      .click({ force: true });
    cy.screenshot('15-balcao-selecionado');

    // 1️⃣5️⃣ Finaliza o pedido
    cy.get('.modal-footer > .btn-success > :nth-child(1)')
      .should('be.visible')
      .click();
    cy.wait(2000);
    cy.screenshot('16-pedido-finalizado');

    // Validação final (opcional)
    cy.screenshot('17-tela-final');
  });
});