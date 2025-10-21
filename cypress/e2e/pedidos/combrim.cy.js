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
    cy.wait(5000);
    
    // Aguarda o menu estar completamente carregado
    cy.get('a').should('have.length.greaterThan', 5); // Espera pelo menos 5 links no menu
    
    cy.screenshot('04-depois-login');

    // 5️⃣ Navega para página de pedidos
    // Procura o link "Pedidos" com retry automático do Cypress
    cy.contains('a', 'Pedidos', { timeout: 10000, matchCase: false })
      .should('be.visible')
      .click();
    
    cy.wait(2000);
    cy.screenshot('05-pagina-pedidos');

    // 6️⃣ Clica no botão "Novo Pedido" dentro do box-header
    cy.get('.box-header > .btn', { timeout: 10000 })
      .should('be.visible')
      .click();
    cy.screenshot('06-botao-novo-pedido');

    // 7️⃣ Busca cliente por nome
    cy.get('.col-lg-6 > .form-control')
      .should('be.visible')
      .type('bb');
    cy.screenshot('07-busca-cliente');

    // 8️⃣ Clica no botão de pesquisa
    cy.get('.btn > :nth-child(1) > .fas').click({ force: true });
    cy.wait(1000);
    cy.screenshot('08-resultado-busca');

    // 9️⃣ Seleciona o cliente encontrado
    cy.get('tr > :nth-child(3) > .btn')
      .should('be.visible')
      .click();
    cy.screenshot('09-cliente-selecionado');

    // 🔟 Avança para próxima etapa
    cy.get('.d-flex > .btn-success')
      .should('be.visible')
      .click();
    cy.screenshot('10-proximo-passo');

    // 1️⃣1️⃣ Adiciona novo produto ao pedido
    cy.get('#new-pedido-customer')
      .should('be.visible')
      .click();
    cy.wait(1000);
    cy.screenshot('11-adicionar-produto');

    // 1️⃣2️⃣ Seleciona o primeiro produto
    cy.get('tbody > :nth-child(1) > :nth-child(1) > label')
      .should('be.visible')
      .click();
    cy.screenshot('12-produto-selecionado');

    // 1️⃣3️⃣ Define quantidade do produto
    cy.get(':nth-child(1) > .w-50 > .form-group > .form-control')
      .should('be.visible')
      .clear()
      .type('100')
      .blur();
    cy.wait(500);
    cy.screenshot('13-quantidade-definida');

    // 1️⃣4️⃣ Abre modal de finalização
    cy.get('#pedido-modal > span:first-child')
      .parent()
      .should('be.visible')
      .click();
    cy.screenshot('14-modal-finalizacao');

    // 1️⃣5️⃣ Seleciona forma de retirada (Balcão)
    cy.get('.col-lg-6.d-flex > :nth-child(1) > :nth-child(1) > label')
      .scrollIntoView()
      .wait(500)
      .click({ force: true });
    cy.screenshot('15-forma-retirada-selecionada');

    // 1️⃣6️⃣ Finaliza o pedido
    cy.get('.modal-footer > .btn-success > :nth-child(1)')
      .should('be.visible')
      .click();
    cy.wait(2000);
    cy.screenshot('16-pedido-finalizado');

    // 1️⃣7️⃣ Tela final - Confirmação
    cy.screenshot('17-tela-final');
    
    // ✅ Validação opcional: verifica mensagem de sucesso
    cy.contains('Pedido Gerado com sucesso', { timeout: 5000 })
      .should('be.visible');
  });
});