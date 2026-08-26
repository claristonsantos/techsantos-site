# Microsoft Fabric — rodada 2 de dicas

Roteiros inéditos para vídeos verticais de 30 a 50 segundos. Esta rodada evita os temas já usados no site e na primeira série: visão geral do Fabric, OneLake, Lakehouse x Warehouse, Dataflow Gen2, pipelines de dados e Direct Lake.

## 1. Git no Microsoft Fabric

**Gancho:** `Seu projeto no Fabric ainda depende de “não mexe nisso agora”?`

**Roteiro falado:**

> O Microsoft Fabric pode conectar um workspace ao GitHub ou Azure DevOps. Assim, alterações nos itens compatíveis ficam versionadas, você consegue trabalhar com branches, revisar mudanças e voltar a uma versão anterior. A integração acontece no nível do workspace, mas atenção: nem todo tipo de item tem o mesmo nível de suporte. Antes de adotar, confira a lista atual da Microsoft. Git não substitui governança — ele dá rastreabilidade para o desenvolvimento.

**Texto na tela:** `Versione · Compare · Reverta`

**Legenda:** Seu workspace não precisa ser uma caixa-preta. A integração com Git traz histórico e colaboração para os itens compatíveis do Fabric. Salve para consultar no próximo projeto. #MicrosoftFabric #GitHub #Dados #PowerBI

**CTA:** `Você já versiona seus projetos de dados?`

**Fonte oficial:** [Visão geral da integração do Fabric com Git](https://learn.microsoft.com/en-us/fabric/cicd/git-integration/intro-to-git-integration)

## 2. Pipeline de implantação não é pipeline de dados

**Gancho:** `Dois pipelines no Fabric — e eles não fazem a mesma coisa.`

**Roteiro falado:**

> Pipeline do Data Factory movimenta e orquestra dados. Pipeline de implantação promove conteúdo entre ambientes, como desenvolvimento, teste e produção. No segundo caso, o objetivo é controlar a entrega das mudanças, comparar conteúdo entre etapas e reduzir publicação manual. Guardou a diferença? Um executa o fluxo de dados. O outro organiza o ciclo de entrega da solução.

**Texto na tela:** `Dados ≠ Implantação`

**Legenda:** O nome é parecido, mas a função é diferente. Pipeline de dados executa atividades; pipeline de implantação controla a promoção de conteúdo entre ambientes. #MicrosoftFabric #DataFactory #DevOps #BusinessIntelligence

**CTA:** `Envie para quem sempre confunde os dois.`

**Fonte oficial:** [Introdução aos pipelines de implantação](https://learn.microsoft.com/en-us/fabric/cicd/deployment-pipelines/intro-to-deployment-pipelines)

## 3. Biblioteca de variáveis

**Gancho:** `Ainda troca IDs e conexões na mão entre dev, teste e produção?`

**Roteiro falado:**

> A biblioteca de variáveis do Fabric permite centralizar valores usados por diferentes itens do workspace. Você pode ter conjuntos de valores para cada etapa da implantação — por exemplo, um ID de Lakehouse em desenvolvimento e outro em produção. Em vez de espalhar configurações fixas pelo projeto, os itens referenciam a variável. Isso reduz ajuste manual e deixa a promoção entre ambientes mais previsível.

**Texto na tela:** `Dev → Teste → Produção`

**Legenda:** Configuração de ambiente não deveria ficar espalhada em vários itens. A biblioteca de variáveis ajuda a centralizar e reutilizar valores no Fabric. #MicrosoftFabric #CICD #DataEngineering #DevOps

**CTA:** `Salve para a próxima implantação.`

**Fonte oficial:** [Visão geral da biblioteca de variáveis](https://learn.microsoft.com/en-us/fabric/cicd/variable-library/variable-library-overview)

## 4. Mirroring sem montar um ETL completo

**Gancho:** `Quer analisar um banco operacional no Fabric sem começar por um ETL complexo?`

**Roteiro falado:**

> Com Mirroring, o Fabric pode replicar continuamente dados de origens compatíveis para o OneLake. No caso do Azure SQL Database, os dados chegam em formato pronto para análise e o Fabric cria também um endpoint SQL analítico somente leitura. Isso abre caminho para Power BI, engenharia e ciência de dados. Não significa copiar qualquer banco com um clique: origem, rede, permissões e limitações precisam ser verificadas.

**Texto na tela:** `Banco operacional → OneLake`

**Legenda:** Mirroring pode simplificar a chegada de dados operacionais ao Fabric e manter a réplica atualizada para análise. Confirme sempre a compatibilidade da origem. #MicrosoftFabric #Mirroring #AzureSQL #OneLake

**CTA:** `Qual banco você gostaria de espelhar?`

**Fonte oficial:** [Mirroring do Azure SQL Database no Fabric](https://learn.microsoft.com/en-us/fabric/mirroring/azure-sql-database)

## 5. Eventstream para dados em movimento

**Gancho:** `Seu dado não chega em lote. Ele acontece agora.`

**Roteiro falado:**

> Eventstream é a experiência do Fabric para capturar, transformar e encaminhar eventos em tempo real. Você pode conectar fontes de streaming, aplicar transformações no fluxo e enviar os eventos para destinos como Lakehouse ou Eventhouse. A dica prática é monitorar entrada, saída, atraso e erros no próprio fluxo. Tempo real não é só exibir rápido — é saber se o processamento está acompanhando a chegada dos eventos.

**Texto na tela:** `Entrada · Transformação · Destino`

**Legenda:** Quando os dados chegam continuamente, Eventstream ajuda a montar e observar o fluxo em tempo real dentro do Fabric. #MicrosoftFabric #Eventstream #RealTimeAnalytics #Dados

**CTA:** `Comente “tempo real” se quer um exemplo prático.`

**Fonte oficial:** [Monitoramento de Eventstreams](https://learn.microsoft.com/en-us/fabric/real-time-intelligence/event-streams/monitor)

## 6. Monitoramento do workspace com KQL ou SQL

**Gancho:** `Seu pipeline falhou. Você sabe onde procurar o histórico?`

**Roteiro falado:**

> O monitoramento do workspace cria um banco de monitoramento em um Eventhouse e reúne logs e métricas dos itens compatíveis. Esses dados podem ser consultados com KQL ou SQL e usados em dashboards. Em vez de investigar cada item isoladamente, você ganha uma camada central de observabilidade. Só considere retenção, consumo de capacidade e a lista de logs disponíveis antes de ativar.

**Texto na tela:** `Logs centralizados no workspace`

**Legenda:** Observabilidade também faz parte da arquitetura. O workspace monitoring centraliza logs e métricas de itens compatíveis para análise e diagnóstico. #MicrosoftFabric #KQL #Monitoramento #DataOps

**CTA:** `Salve antes do próximo erro difícil de rastrear.`

**Fonte oficial:** [Visão geral do monitoramento do workspace](https://learn.microsoft.com/en-us/fabric/fundamentals/workspace-monitoring-overview)

## 7. Descubra quem está consumindo sua capacidade

**Gancho:** `A capacidade ficou lenta — mas qual item causou o pico?`

**Roteiro falado:**

> O aplicativo Microsoft Fabric Capacity Metrics mostra o consumo por capacidade, workspace, item e operação. Você consegue investigar períodos de alta utilização, operações rejeitadas e quais itens mais consumiram CUs. A leitura correta não é apenas “passou de cem por cento”. Operações interativas e em segundo plano têm comportamentos de suavização diferentes. Use o detalhamento por ponto no tempo antes de decidir aumentar a capacidade.

**Texto na tela:** `Capacidade → Item → Operação`

**Legenda:** Antes de escalar a capacidade, identifique quando o consumo aconteceu e quais itens ou operações contribuíram. #MicrosoftFabric #CapacityMetrics #Performance #FinOps

**CTA:** `Marque quem administra a capacidade Fabric.`

**Fonte oficial:** [Página de computação do Capacity Metrics](https://learn.microsoft.com/en-us/fabric/enterprise/metrics-app-compute-page)

## 8. SQL Database dentro do Fabric

**Gancho:** `Fabric também pode hospedar um banco SQL transacional.`

**Roteiro falado:**

> SQL Database no Microsoft Fabric é um banco relacional transacional integrado à plataforma. Você trabalha com T-SQL e pode usar ferramentas conhecidas, enquanto o banco participa do ecossistema do Fabric. Não confunda com Warehouse: o SQL Database atende aplicações e cargas operacionais; o Warehouse é voltado à análise em escala. Escolha pela natureza da carga, não apenas pela familiaridade com SQL.

**Texto na tela:** `Transacional ≠ Analítico`

**Legenda:** Usar T-SQL não torna dois serviços equivalentes. SQL Database e Warehouse atendem necessidades diferentes dentro do Fabric. #MicrosoftFabric #SQLDatabase #DataWarehouse #TSQL

**CTA:** `Você usaria o Fabric também para a camada transacional?`

**Fonte oficial:** [Visão geral do SQL Database no Fabric](https://learn.microsoft.com/en-us/fabric/database/sql/overview)

## Ordem recomendada de publicação

1. Pipeline de implantação não é pipeline de dados.
2. Git no Microsoft Fabric.
3. Biblioteca de variáveis.
4. Descubra quem está consumindo sua capacidade.
5. Mirroring sem montar um ETL completo.
6. Monitoramento do workspace com KQL ou SQL.
7. Eventstream para dados em movimento.
8. SQL Database dentro do Fabric.

Essa ordem começa por uma dúvida simples e altamente compartilhável, avança para práticas profissionais de entrega e operação e termina apresentando recursos mais amplos da plataforma.

## Cuidados de produção

- Gravar a interface real e atual do Fabric.
- Conferir a lista de itens compatíveis antes de demonstrar Git ou implantação.
- Não apresentar Mirroring como compatível com qualquer origem.
- Não chamar Eventstream de processamento instantâneo; latência depende da arquitetura.
- Não recomendar aumento de capacidade sem analisar o detalhamento de consumo.
- Se uma funcionalidade aparecer como preview no momento da gravação, informar isso no vídeo e na legenda.
