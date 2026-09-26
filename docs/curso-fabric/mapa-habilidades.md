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
| 04 | Data Factory: pipelines, orquestração e cargas | ⬜ |
| 05 | Dataflows Gen2 e editor de consultas visuais | ⬜ |
| 06 | Notebooks, Spark e streaming estruturado | ⬜ |
| 07 | Data Warehouse e T-SQL | ⬜ |
| 08 | Real-Time Intelligence (Eventstream, Eventhouse, KQL) | ⬜ |
| 09 | Modelos semânticos: design | ⬜ |
| 10 | DAX para a prova | ⬜ |
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
| Ingerir ou acessar dados conforme necessário | fab-atalhos, fab-espelhamento (+ M04/M05) | 🟡 |
| Implementar controle de acesso em nível de linha, coluna, objeto e arquivo | fab-onelake-seguranca (+ M12) | 🟡 |
| Implementar um esquema estrela para um lakehouse ou warehouse | fab-modelo-dimensional, fab-carga-dimensional | ✅ |
| Desnormalizar dados | fab-modelo-dimensional (+ M05/M06 prática) | 🟡 |
| Agregar dados / enriquecer com colunas ou tabelas | fab-modelo-dimensional (+ M05–M07 prática) | 🟡 |
| Demais habilidades | módulos 04–15 | ⬜ |

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
| Escolha entre tabelas nativas e atalhos do OneLake no RTI / aceleração de consulta | fab-atalhos (+ M08) | 🟡 |
| Identificar e resolver erros de atalho do OneLake | fab-atalhos (+ M14) | 🟡 |
| Preparar dados para carregar em um modelo dimensional | fab-carga-dimensional | ✅ |
| Otimizar uma tabela Lakehouse | fab-manutencao-delta (+ M14) | ✅ |
| Escolha entre Dataflow Gen2, pipeline e notebook | fab-carregar-lakehouse (+ M04–M06) | 🟡 |
| Projetar e implementar cargas completas e incrementais | fab-carga-dimensional (+ M04) | 🟡 |
| Demais habilidades | módulos 04–15 | ⬜ |
