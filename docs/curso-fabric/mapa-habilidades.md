# Mapa de cobertura — habilidades oficiais → aulas

Regra do curso: toda habilidade dos guias de estudo DP-600 e DP-700 (lista completa em
`habilidades-oficiais-dp600-dp700.md`) precisa estar coberta em **texto** em pelo menos uma aula.
Atualize este mapa a cada módulo publicado. Status: ✅ coberta · 🟡 parcial · ⬜ pendente.

## Currículo (15 módulos)

| Módulo | Tema | Status |
|---|---|---|
| 01 | Fundamentos do Fabric e configuração do ambiente | ✅ publicado |
| 02 | OneLake: atalhos, espelhamento, segurança, integrações | ✅ publicado |
| 03 | Lakehouse, medalhão e modelagem dimensional | ✅ publicado |
| 04 | Data Factory: pipelines, orquestração e cargas | ✅ publicado |
| 05 | Dataflows Gen2 e editor de consultas visuais | ✅ publicado |
| 06 | Notebooks, Spark e streaming estruturado | ✅ publicado |
| 07 | Data Warehouse e T-SQL | ✅ publicado |
| 08 | Real-Time Intelligence (Eventstream, Eventhouse, KQL) | ✅ publicado |
| 09 | Modelos semânticos: design | ✅ publicado |
| 10 | DAX para a prova | ✅ publicado |
| 11 | Direct Lake e otimização de modelos | ⬜ |
| 12 | Segurança e governança | ⬜ |
| 13 | Ciclo de vida: Git, .pbip, pipelines de implantação, XMLA | ⬜ |
| 14 | Monitoramento, erros e otimização | ⬜ |
| 15 | Projeto final e simulados | ⬜ |

## DP-600

| Habilidade | Aula(s) | Status |
|---|---|---|
| Descobrir dados usando o catálogo do OneLake e o hub Real-Time | fab-descobrir-dados | ✅ |
| Escolher entre armazenamentos de dados diferentes | fab-escolher-armazenamento | ✅ |
| Implementar a integração do OneLake para Eventhouse e modelos semânticos | fab-onelake-integracoes | ✅ |
| Ingerir ou acessar dados conforme necessário | fab-atalhos, fab-espelhamento, fab-copy, fab-dataflow-gen2 | ✅ |
| Criar uma conexão de dados | fab-data-factory-visao | ✅ |
| Implementar controle de acesso em nível de linha, coluna, objeto e arquivo | fab-onelake-seguranca (+ M12) | 🟡 |
| Implementar um esquema estrela para um lakehouse ou warehouse | fab-modelo-dimensional, fab-carga-dimensional | ✅ |
| Desnormalizar dados | fab-modelo-dimensional, fab-dataflow-transformacoes (+ M06/M07 código) | ✅ |
| Agregar dados / enriquecer com colunas ou tabelas | fab-dataflow-transformacoes, fab-modelo-dimensional (+ M06/M07 código) | ✅ |
| Mesclar ou unir dados | fab-dataflow-transformacoes | ✅ |
| Converter tipos de dados de coluna | fab-dataflow-transformacoes | ✅ |
| Filtrar dados | fab-dataflow-transformacoes | ✅ |
| Identificar e resolver dados duplicados, dados ausentes ou valores nulos | fab-dataflow-qualidade | ✅ |
| Selecionar, filtrar e agregar dados usando o editor de consultas visuais | fab-editor-consultas-visuais | ✅ |
| Criar exibições, funções e procedimentos armazenados | fab-tsql-objetos | ✅ |
| Selecionar, filtrar e agregar dados usando o SQL | fab-tsql-consultas | ✅ |
| Selecionar, filtrar e agregar dados usando KQL | fab-kql-consultas | ✅ |
| Escolher um modo de armazenamento | fab-modelo-semantico-visao (+ M11 Direct Lake) | ✅ |
| Implementar um esquema de estrela para um modelo semântico | fab-modelo-estrela | ✅ |
| Implementar relações, como tabelas de ponte e relações muitos para muitos | fab-modelo-relacoes | ✅ |
| Implementar grupos de cálculo, cadeias de formato dinâmico e parâmetros de campo | fab-modelo-grupos-calculo | ✅ |
| Identificar casos de uso e configurar formato de modelo semântico grande | fab-modelo-composto-grande | ✅ |
| Projetar e criar modelos compostos | fab-modelo-composto-grande, fab-modelo-relacoes | ✅ |
| Escrever cálculos que usam variáveis e funções DAX (iteradores, filtragem de tabela, janelas, informações) | fab-dax-contextos, fab-dax-filtros, fab-dax-iteradores-janelas, fab-dax-informacao | ✅ |
| Selecionar, filtrar e agregar dados usando DAX | fab-dax-consultas | ✅ |
| Demais habilidades | módulos 11–15 | ⬜ |

## DP-700

| Habilidade | Aula(s) | Status |
|---|---|---|
| Definir as configurações do workspace do Spark | fab-config-workspace | ✅ |
| Definir as configurações do workspace de domínio | fab-dominios | ✅ |
| Definir as configurações do workspace do OneLake | fab-config-workspace | ✅ |
| Configurar as configurações do workspace do Apache Airflow | fab-config-workspace | ✅ |
| Escolher um armazenamento de dados apropriado | fab-escolher-armazenamento | ✅ |
| Criar e gerenciar atalhos do OneLake | fab-atalhos | ✅ |
| Implementar espelhamento | fab-espelhamento | ✅ |
| Configurar e implementar a segurança do OneLake | fab-onelake-seguranca | ✅ |
| Escolha entre tabelas nativas e atalhos do OneLake no RTI / aceleração de consulta | fab-eventhouse, fab-atalhos | ✅ |
| Identificar e resolver erros de atalho do OneLake | fab-atalhos (+ M14) | 🟡 |
| Preparar dados para carregar em um modelo dimensional | fab-carga-dimensional | ✅ |
| Otimizar uma tabela Lakehouse | fab-manutencao-delta (+ M14) | ✅ |
| Escolha entre Dataflow Gen2, pipeline e notebook | fab-escolher-ferramenta, fab-carregar-lakehouse (+ M05–M06) | ✅ |
| Projetar e implementar agendas e gatilhos baseados em eventos | fab-agendas-gatilhos | ✅ |
| Implementar padrões de orquestração com notebooks e pipelines, incluindo parâmetros e expressões dinâmicas | fab-pipeline-atividades, fab-parametros-expressoes | ✅ |
| Ingerir dados usando pipelines | fab-copy, fab-pipeline-atividades | ✅ |
| Monitorar a ingestão de dados | fab-agendas-gatilhos (+ M14) | 🟡 |
| Monitorar a transformação de dados | fab-dataflow-monitorar-erros, fab-spark-monitorar-otimizar (+ M14) | ✅ |
| Transformar dados usando PySpark, SQL e KQL | fab-pyspark-transformar, fab-spark-qualidade-merge, fab-tsql-consultas, fab-tsql-objetos, fab-kql-transformar | ✅ |
| Otimizar um data warehouse | fab-warehouse-desempenho, fab-warehouse-ingestao | ✅ |
| Identificar e resolver erros de T-SQL | fab-warehouse-desempenho, fab-tsql-objetos | ✅ |
| Agrupar e agregar dados | fab-pyspark-transformar, fab-dataflow-transformacoes | ✅ |
| Processar dados usando o streaming estruturado do Spark | fab-streaming-estruturado | ✅ |
| Criar funções de janela | fab-spark-qualidade-merge, fab-streaming-estruturado, fab-eventstream, fab-kql-consultas | ✅ |
| Projetar e implementar um padrão de carregamento para dados de streaming | fab-rti-visao, fab-eventstream, fab-streaming-estruturado | ✅ |
| Identificar e resolver erros de notebook | fab-spark-monitorar-otimizar | ✅ |
| Otimizar o desempenho do Spark | fab-spark-monitorar-otimizar, fab-manutencao-delta | ✅ |
| Identificar e resolver erros do Dataflow Gen2 | fab-dataflow-monitorar-erros, fab-dataflow-qualidade | ✅ |
| Manipular dados duplicados, ausentes e de chegada tardia | fab-dataflow-qualidade, fab-spark-qualidade-merge, fab-carga-dimensional | ✅ |
| Escolha entre fluxos de dados Gen2, notebooks, KQL e T-SQL para transformação | fab-escolher-ferramenta, fab-dataflow-gen2 (+ M06–M08) | 🟡 |
| Identificar e resolver erros de pipeline | fab-pipeline-atividades, fab-agendas-gatilhos (+ M14) | 🟡 |
| Projetar e implementar cargas completas e incrementais | fab-carga-incremental, fab-copy, fab-carga-dimensional | ✅ |
| Escolher um mecanismo de streaming apropriado | fab-rti-visao | ✅ |
| Processar dados usando Eventstream | fab-eventstream | ✅ |
| Processar dados usando KQL | fab-kql-consultas, fab-kql-transformar | ✅ |
| Configurar alertas | fab-rti-acoes-monitorar (+ M14) | 🟡 |
| Identificar e resolver erros do Eventhouse | fab-rti-acoes-monitorar | ✅ |
| Identificar e resolver erros do Eventstream | fab-rti-acoes-monitorar | ✅ |
| Otimizar Eventstream e Eventhouse | fab-rti-acoes-monitorar, fab-eventhouse | ✅ |
| Demais habilidades | módulos 09–15 | ⬜ |
