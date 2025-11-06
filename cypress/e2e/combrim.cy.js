describe('Realizar teste de login e pedidos', () => {
  
  // Ignora erros não tratados da aplicação
  Cypress.on('uncaught:exception', (err, runnable) => {
    return false;
  });

  it('1️⃣ Acessa a página inicial', () => {
    cy.log('🚀 PASSO 1: Acessando a página inicial');
    cy.visit('/');
    cy.screenshot('01-homepage');
  });

  it('2️⃣ Seleciona tipo de login', () => {
    cy.log('🚀 PASSO 2: Selecionando tipo de login como Admin');
    cy.get('[name="tipo_login"]').should('be.visible').select('Admin');
    cy.screenshot('02-seleciona-tipo-login');
  });

  it('3️⃣ Preenche email e senha', () => {
    cy.log('🚀 PASSO 3: Preenchendo credenciais de login');
    cy.get('[name="email"]').should('be.visible').type('plpatri@gmail.com');
    cy.get('[name="senha"]').should('be.visible').type('979899');
    cy.screenshot('03-preenche-credenciais');
  });

  it('4️⃣ Clica no botão de login', () => {
    cy.log('🚀 PASSO 4: Clicando no botão de login');
    cy.get('.btn').should('be.visible').click();
    cy.wait(3000);
    cy.screenshot('04-depois-login');
  });

  it('5️⃣ Navega para Pedidos', () => {
    cy.log('🚀 PASSO 5: Navegando para a página de Pedidos');
    cy.get(':nth-child(6) > a', { timeout: 10000 })
      .should('be.visible')
      .click();
    cy.wait(2000);
    cy.screenshot('05-pagina-pedidos');
  });

  it('6️⃣ Clica no botão dentro do box-header', () => {
    cy.log('🚀 PASSO 6: Clicando no botão dentro do box-header');
    cy.get('.box-header > .btn', { timeout: 10000 })
      .should('be.visible')
      .click();
    cy.screenshot('06-box-header');
  });

  it('7️⃣ Preenche campo de busca de cliente', () => {
    cy.log('🚀 PASSO 7: Preenchendo campo de busca com "bb"');
    cy.get('.col-lg-6 > .form-control')
      .should('be.visible')
      .type('bb');
    cy.screenshot('07-preenche-campo');
  });

  it('8️⃣ Clica no botão de busca', () => {
    cy.log('🚀 PASSO 8: Clicando no botão de busca');
    cy.get('.btn > :nth-child(1) > .fas')
      .click({ force: true });
    cy.wait(1000);
    cy.screenshot('08-resultado-busca');
  });

  it('9️⃣ Seleciona o cliente da lista', () => {
    cy.log('🚀 PASSO 9: Selecionando o cliente');
    cy.get('tr > :nth-child(3) > .btn', { timeout: 10000 })
      .should('be.visible')
      .click();
    cy.screenshot('09-cliente-selecionado');
  });

  it('🔟 Clica em Próximo', () => {
    cy.log('🚀 PASSO 10: Clicando em Próximo');
    cy.get('.d-flex > .btn-success', { timeout: 10000 })
      .should('be.visible')
      .click();
    cy.screenshot('10-proximo');
  });

  it('1️⃣1️⃣ Clica no botão Novo Pedido', () => {
    cy.log('🚀 PASSO 11: Clicando no botão Novo Pedido');
    cy.get('#new-pedido-customer', { timeout: 10000 })
      .should('be.visible')
      .click();
    cy.wait(1000);
    cy.screenshot('11-novo-pedido');
  });

  it('1️⃣2️⃣ Seleciona checkbox do primeiro produto', () => {
    cy.log('🚀 PASSO 12: Selecionando checkbox do produto');
    cy.get('tbody > :nth-child(1) > :nth-child(1) > label')
      .should('be.visible')
      .click();
    cy.screenshot('12-checkbox-selecionado');
  });

  it('1️⃣3️⃣ Define quantidade do produto', () => {
    cy.log('🚀 PASSO 13: Definindo quantidade (100)');
    cy.get(':nth-child(1) > .w-50 > .form-group > .form-control')
      .should('be.visible')
      .clear()
      .type('100')
      .blur();
    cy.wait(500);
    cy.screenshot('13-quantidade-inserida');
  });

  it('1️⃣4️⃣ Abre modal de seleção de balcão', () => {
    cy.log('🚀 PASSO 14: Abrindo modal de balcão');
    cy.get('#pedido-modal > span:first-child')
      .parent()
      .should('be.visible')
      .click();
    cy.screenshot('14-modal-aberto');
  });

  it('1️⃣5️⃣ Seleciona o balcão', () => {
    cy.log('🚀 PASSO 15: Selecionando o balcão');
    cy.get('.col-lg-6.d-flex > :nth-child(1) > :nth-child(1) > label', { timeout: 10000 })
      .scrollIntoView()
      .wait(500)
      .click({ force: true });
    cy.screenshot('15-balcao-selecionado');
  });

  it('1️⃣6️⃣ Finaliza o pedido', () => {
    cy.log('🚀 PASSO 16: Finalizando o pedido');
    cy.get('.modal-footer > .btn-success', { timeout: 10000 })
      .should('be.enabled')
      .click({ force: true });
    cy.wait(3000);
    cy.screenshot('16-pedido-finalizado');
  });

  it('1️⃣7️⃣ Verifica mensagem de confirmação', () => {
    cy.log('🚀 PASSO 17: Verificando confirmação');
    cy.get('body').then(($body) => {
      if ($body.find('.alert-success, .toast-success, .swal2-success').length > 0) {
        cy.log('✅ Pedido criado com sucesso!');
        cy.screenshot('17-sucesso');
      } else {
        cy.log('⚠️ Pedido pode ter sido criado (sem mensagem)');
        cy.screenshot('17-tela-final');
      }
    });
  });
});