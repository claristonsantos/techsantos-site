# Habilidades avaliadas — DP-600 e DP-700 (fonte oficial)

Extraído em 2026-09-26 dos guias de estudo oficiais (versão válida a partir de 19/10/2026):
- DP-600: https://learn.microsoft.com/pt-br/credentials/certifications/resources/study-guides/dp-600
- DP-700: https://learn.microsoft.com/pt-br/credentials/certifications/resources/study-guides/dp-700

Regra do curso: cada habilidade abaixo precisa estar coberta por texto (não só vídeo) em pelo menos uma aula — ver mapa-habilidades.md.

## DP-600 — Implementação de soluções de análise usando o Microsoft Fabric
- Preparar e enriquecer dados para análise
- Proteger e manter ativos de análise
- Implementar e gerenciar modelos semânticos
- Manter uma solução de análise de dados (25 a 30%)
- Preparar dados (45 a 50%)
- Implementar e gerenciar modelos semânticos (25 a 30%)
### Manter uma solução de análise de dados (25 a 30%)
### Implementar segurança e governança
- Implementar controles de acesso no nível do workspace
- Implementar controles de acesso no nível do item
- Implementar controle de acesso em nível de linha, nível de coluna, nível de objeto e nível de arquivo
- Aplicar rótulos de confidencialidade a itens
- Aprovar itens
### Manter o ciclo de vida de desenvolvimento de analítica
- Configurar o controle de versões para um workspace
- Criar e gerenciar um projeto do Power BI Desktop (.pbip)
- Criar e configurar pipelines de implantação
- Executar análise de impacto de dependências downstream de lakehouses, warehouses, fluxos de dados e modelos semânticos
- Implantar e gerenciar modelos semânticos usando o ponto de extremidade XMLA
- Criar e atualizar ativos reutilizáveis, incluindo arquivos de modelo do Power BI (.pbit), arquivos de fonte de dados do Power BI (.pbids) e modelos semânticos compartilhados
### Preparar dados (45 a 50%)
### Obter dados
- Criar uma conexão de dados
- Descobrir dados usando o catálogo do OneLake e o hub Real-Time
- Ingerir ou acessar dados conforme necessário
- Escolher entre armazenamentos de dados diferentes
- Implementar a integração do OneLake para Eventhouse e modelos semânticos
### Transformar dados
- Criar exibições, funções e procedimentos armazenados
- Enriquecer dados adicionando novas colunas ou tabelas
- Implementar um esquema de estrela para um lakehouse ou warehouse
- Desnormalizar dados
- Agregar dados
- Mesclar ou unir dados
- Identificar e resolver dados duplicados, dados ausentes ou valores nulos
- Converter tipos de dados de coluna
- Filtrar dados
### Consultar e analisar dados
- Selecionar, filtrar e agregar dados usando o editor de consultas visuais
- Selecionar, filtrar e agregar dados usando o SQL
- Selecionar, filtrar e agregar dados usando KQL
- Selecionar, filtrar e agregar dados usando DAX
### Implementar e gerenciar modelos semânticos (25 a 30%)
### Projetar e criar modelos semânticos
- Escolher um modo de armazenamento
- Implementar um esquema de estrela para um modelo semântico
- Implementar relações, como tabelas de ponte e relações muitos para muitos
- Escrever cálculos que usam variáveis e funções DAX, como iteradores, filtragem de tabela, janelas e funções de informações
- Implementar grupos de cálculo, cadeias de caracteres de formato dinâmico e parâmetros de campo
- Identificar casos de uso e configurar formato de armazenamento de modelo semântico grande
- Projetar e criar modelos compostos
### Otimizar modelos semânticos de escala empresarial
- Implementar melhorias de desempenho em consultas e visuais de relatório
- Melhorar o desempenho do DAX
- Configurar o Direct Lake, incluindo o comportamento padrão de fallback e atualização
- Escolher entre Direct Lake no OneLake e Direct Lake no ponto de extremidade de análise do SQL
- Implementar a atualização incremental para modelos semânticos

## DP-700 — Engenharia de dados usando o Microsoft Fabric
- Ingestão e transformação de dados.
- Proteger e gerenciar uma solução de análise.
- Monitorar e otimizar uma solução de análise.
- Implementar e gerenciar uma solução de análise (30 a 35%)
- Ingerir e transformar dados (30 a 35%)
- Monitorar e otimizar uma solução de análise (30 a 35%)
### Implementar e gerenciar uma solução de análise (30 a 35%)
### Definir as configurações do workspace do Microsoft Fabric
- Definir as configurações do workspace do Spark
- Definir as configurações do workspace de domínio
- Definir as configurações do workspace do OneLake
- Configurar as configurações do espaço de trabalho do Apache Airflow
### Implementar o gerenciamento do ciclo de vida no Fabric
- Configurar controle de versão
- Implementar projetos de banco de dados
- Criar e configurar pipelines de implantação
### Configurar a segurança e a governança
- Implementar controles de acesso no nível do workspace
- Implementar controles de acesso no nível do item
- Implementar controles de acesso no nível de linha, coluna, objeto e pasta/arquivo.
- Implementar máscara dinâmica de dados
- Aplicar rótulos de confidencialidade a itens
- Endossar itens
- Implementar e usar logs de auditoria do Microsoft Fabric
- Configurar e implementar a segurança do OneLake
### Orquestrar processos
- Escolha entre o Dataflow Gen 2, um pipeline e um notebook
- Projetar e implementar agendas e gatilhos baseados em eventos
- Implementar padrões de orquestração com notebooks e pipelines, incluindo parâmetros e expressões dinâmicas
### Ingerir e transformar dados (30 a 35%)
### Projetar e implementar padrões de carregamento
- Projetar e implementar cargas de dados completas e incrementais
- Preparar dados para carregar em um modelo dimensional
- Projetar e implementar um padrão de carregamento para dados de streaming
### Ingerir e transformar dados em lote
- Escolher um armazenamento de dados apropriado
- Escolha entre fluxos de dados Gen2, notebooks, KQL e T-SQL para transformação de dados
- Criar e gerenciar atalhos do OneLake
- Implementar espelhamento
- Ingerir dados usando pipelines
- Transformar dados usando PySpark, SQL e KQL
- Desnormalizar dados
- Agrupar e agregar dados
- Manipular dados duplicados, ausentes e de chegada tardia
### Ingerir e transformar dados de streaming
- Escolher um mecanismo de streaming apropriado
- Escolha entre tabelas nativas e atalhos do OneLake no Inteligência em Tempo Real
- Escolha entre a aceleração de consulta para os atalhos do OneLake e os atalhos padrão do OneLake no contexto de Inteligência em Tempo Real.
- Processar dados usando Eventstream
- Processar dados usando o streaming estruturado do Spark
- Processar dados usando KQL
- Criar funções de janela
### Monitorar e otimizar uma solução de análise (30 a 35%)
### Monitorar itens do Fabric
- Monitorar a ingestão de dados
- Monitorar a transformação de dados
- Monitorar a atualização semântica do modelo
- Configurar alertas
### Identificar e resolver erros
- Identificar e resolver erros de pipeline
- Identificar e resolver erros do Dataflow Gen2
- Identificar e resolver erros de notebook
- Identificar e resolver erros do Eventhouse
- Identificar e resolver erros do Eventstream
- Identificar e resolver erros de T-SQL
- Identificar e resolver erros de atalho do OneLake
### Otimizar desempenho
- Otimizar uma tabela Lakehouse
- Otimizar um pipeline
- Otimizar um data warehouse
- Otimizar Eventstream e Eventhouse
- Otimizar o desempenho do Spark
- Otimizar o desempenho de consultas
