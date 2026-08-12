// Complementos editoriais 2026-08.
// Fontes: documentação oficial Microsoft Learn.
(function () {
  const additions = {
    'relacionamentos-cardinalidade-filtros': [
      { h: 'Relações ativas, inativas e dimensões de função', p: 'Uma relação ativa propaga filtros automaticamente. Uma relação inativa só participa quando uma medida usa USERELATIONSHIP. Quando o relatório precisa filtrar simultaneamente Data do Pedido e Data da Entrega, a solução mais previsível é duplicar a dimensão de data e manter duas relações ativas. Relações inativas são adequadas quando os dois papéis não precisam aparecer ao mesmo tempo.', r: { t: 'Diretrizes para relações ativas e inativas', u: 'https://learn.microsoft.com/pt-br/power-bi/guidance/relationships-active-inactive' } },
      { h: 'Muitos para muitos exige decisão de modelagem', p: 'Não use cardinalidade muitos para muitos apenas para aceitar chaves duplicadas. Entre dimensões, prefira uma tabela ponte. Entre fatos, prefira dimensões conformadas. Relações diretas muitos para muitos são exceções e exigem validação explícita da granularidade e dos totais.', r: { t: 'Diretrizes de relação muitos para muitos', u: 'https://learn.microsoft.com/pt-br/power-bi/guidance/relationships-many-to-many' } }
    ],
    'boas-praticas-power-query': [
      { h: 'Privacidade ao combinar fontes', p: 'Os níveis Público, Organizacional e Privado determinam quanto uma fonte pode compartilhar dados com outra. Não marque “Ignorar níveis de privacidade” apenas para eliminar um erro: isso pode permitir que valores confidenciais sejam enviados para outra fonte durante a avaliação.', r: { t: 'Níveis de privacidade no Power Query', u: 'https://learn.microsoft.com/pt-br/power-query/privacy-levels' } },
      { h: 'Segurança de parâmetros e conectores', p: 'Evite montar consultas nativas concatenando texto recebido do usuário. Use parâmetros oferecidos pela fonte e conectores certificados. Scripts R ou Python executam com as permissões do usuário e só devem usar código confiável.', r: { t: 'Práticas de segurança do Power Query', u: 'https://learn.microsoft.com/en-us/power-query/security-best-practices-power-query' } }
    ],
    'modos-armazenamento': [
      { h: 'Direct Lake no Microsoft Fabric', p: 'Direct Lake permite que um modelo semântico leia dados no OneLake sem importar uma cópia para o modelo e sem enviar uma consulta SQL a cada interação como no DirectQuery. É uma opção do Fabric para grandes volumes, condicionada à capacidade, à origem compatível e às limitações documentadas. Import continua sendo a escolha padrão mais simples quando volume e atualização permitem.', r: { t: 'Visão geral do Direct Lake', u: 'https://learn.microsoft.com/pt-br/fabric/fundamentals/direct-lake-overview' } },
      { h: 'Quatro perguntas antes de escolher o modo', items: ['Qual latência o negócio realmente exige?', 'Quanto dado precisa estar disponível?', 'A fonte suporta consultas concorrentes?', 'A equipe consegue manter capacidade, gateway e credenciais?'] }
    ],
    'dax-contexto-modelo': [
      { h: 'Contexto de linha não é filtro automaticamente', p: 'Uma coluna calculada possui a linha atual, mas esse contexto não filtra automaticamente uma agregação. CALCULATE pode realizar a transição de contexto. Em medidas, o ponto de partida normalmente é o contexto de filtro criado pelo visual, pelas segmentações e pelas relações.', r: { t: 'Visão geral do DAX e contextos', u: 'https://learn.microsoft.com/pt-br/dax/dax-overview' } }
    ],
    'dax-calculate-filter': [
      { h: 'Prefira filtros booleanos quando possível', p: 'CALCULATE aceita filtros booleanos diretos, como Produto[Cor] = “Azul”. Use FILTER quando a condição realmente precisar avaliar uma tabela linha a linha. FILTER sem necessidade pode aumentar o trabalho do mecanismo e esconder a intenção da medida.', r: { t: 'Função FILTER', u: 'https://learn.microsoft.com/pt-br/dax/filter-function-dax' } }
    ],
    'enriquecendo-relatorios': [
      { h: 'Acessibilidade mensurável', p: 'Garanta contraste mínimo de 4,5:1 para textos, não use somente cor para comunicar estado, adicione texto alternativo e configure ordem de tabulação lógica. Mantenha filtros recorrentes na mesma posição e teste a navegação apenas com teclado.', r: { t: 'Criar relatórios acessíveis', u: 'https://learn.microsoft.com/pt-br/power-bi/create-reports/desktop-accessibility-creating-reports' } },
      { h: 'Layout móvel é uma entrega própria', p: 'Uma página de desktop pode ficar ilegível no telefone. Crie o layout móvel, priorize poucos indicadores, evite rolagem dentro de visuais e teste botões, segmentações e títulos no emulador.', r: { t: 'Relatórios móveis', u: 'https://learn.microsoft.com/pt-br/power-bi/create-reports/power-bi-create-mobile-optimized-report-about' } }
    ],
    'checklist-publicacao-profissional': [
      { h: 'Registrar desempenho antes da entrega', p: 'Use o Analisador de Desempenho para registrar a abertura da página e as interações principais. Ele separa tempo de consulta DAX, exibição visual e outras etapas. Investigue os visuais mais lentos antes da publicação.', r: { t: 'Analisador de Desempenho', u: 'https://learn.microsoft.com/pt-br/power-bi/create-reports/performance-analyzer' } }
    ],
    'implantar-manter': [
      { h: 'Ambientes e controle de versão', p: 'Para soluções de equipe, separe desenvolvimento, teste e produção. Projetos PBIP permitem versionar definições de relatório e modelo semântico; integração Git e pipelines do Fabric ajudam a revisar e promover mudanças. Recursos em versão prévia exigem avaliação antes de processos críticos.', r: { t: 'Projetos Power BI e CI/CD', u: 'https://learn.microsoft.com/en-us/power-bi/developer/projects/projects-deploy-fabric-cicd' } },
      { h: 'Segurança é maior que RLS', p: 'RLS restringe linhas, mas não substitui permissões do workspace, público do App, proteção da fonte, credenciais, gateway e políticas de exportação. Teste cada papel e confirme quem possui Build, compartilhamento e edição.' }
    ]
  };

  for (const module of COURSE) {
    for (const lesson of module.lessons) {
      const blocks = additions[lesson.id];
      if (!blocks) continue;
      lesson.content = lesson.content || [];
      lesson.content.push(...blocks.filter(block => !lesson.content.some(current => current.h === block.h)));
    }
  }
})();
