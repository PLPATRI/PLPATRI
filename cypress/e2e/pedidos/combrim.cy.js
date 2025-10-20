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
    
    // Aguarda o carregamento completo
    cy.wait(5000);
    
    // 🔍 CAPTURA SCREENSHOT IMEDIATAMENTE APÓS LOGIN
    cy.screenshot('04-depois-login-ANALISE-ESTA-TELA');
    
    // 🔍 VERIFICA URL ATUAL
    cy.url().then((url) => {
      cy.log(`===== URL ATUAL: ${url} =====`);
    });

    // 🔍 LISTA TODOS OS LINKS DISPONÍVEIS
    cy.get('a').then(($links) => {
      cy.log(`===== TOTAL DE LINKS: ${$links.length} =====`);
      $links.each((index, link) => {
        const text = link.textContent.trim();
        const href = link.getAttribute('href');
        cy.log(`[${index}] Texto: "${text}" | href: "${href}"`);
      });
    });
    
    // Por enquanto, só captura mais um screenshot
    cy.screenshot('05-ANALISE-COMPLETA-COM-LOGS');
    
    // FIM DO TESTE DE DEBUG - Todo o resto está comentado
  });
});