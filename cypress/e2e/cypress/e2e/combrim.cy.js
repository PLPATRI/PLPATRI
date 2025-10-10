describe('Realizar teste de login e pedidos', () => {
  it('executa fluxo completo com screenshots', () => {
    // 1️⃣ Acessa a página inicial
    cy.visit('http://127.0.0.1:8000/');
    cy.screenshot('01-homepage');

    // 2️⃣ Seleciona tipo de login
    cy.get('[name="tipo_login"]').select('Admin'); // ou o valor/texto da opção desejada
    cy.screenshot('02-seleciona-tipo-login');

    // 3️⃣ Preenche email e senha
    cy.get('[name="email"]').type('plpatri@gmail.com');
    cy.get('[name="senha"]').type('979899');
    cy.screenshot('03-preenche-credenciais');

    // 4️⃣ Clica no botão de login
    cy.get('.btn').click();
    cy.screenshot('04-depois-login');

    // 5️⃣ Navega para página de pedidos (exemplo de menu)
    cy.get(':nth-child(6) > a').click();
    cy.screenshot('05-pagina-pedidos');

    // 6️⃣ Clica no botão dentro do box-header
    cy.get('.box-header > .btn', { timeout: 10000 }).should('be.visible').click();
    cy.screenshot('06-box-header');

    // 7️⃣ Selecione um cliente para pesquisa
    cy.get('.col-lg-6 > .form-control').type('bb');
    cy.screenshot('07-preenche-campo');

    // 8 Busca um cliente
    cy.get('.btn > :nth-child(1) > .fas').click();


    // 9 selecionar o cliente
    cy.get('tr > :nth-child(3) > .btn').click();
    
    // 10 clicar Proximo
    cy.get('.d-flex > .btn-success').click();

    
    // 11 botão Novo Pedido
    cy.get('#new-pedido-customer').click();

    //selecionar o checkbox
    cy.get('tbody > :nth-child(1) > :nth-child(1) > label').click();

    //selecionar campo quantidade e inserir 
    cy.get(':nth-child(1) > .w-50 > .form-group > .form-control').type('100').blur();
   
  cy.get('#pedido-modal > span:first-child').parent()
  .should('be.visible')
  .click();

//selecionar balcao
  cy.get('.col-lg-6.d-flex > :nth-child(1) > :nth-child(1) > label').click();
  
  cy.get('.modal-footer > .btn-success > :nth-child(1)').click();

    
    // 1️⃣3️⃣ Pode adicionar mais ações e screenshots conforme necessário
  });
});
