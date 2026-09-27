// Curso Microsoft Fabric — preparatório DP-600 / DP-700 (TECH SANTOS BR).
// Texto original; imagens oficiais do Microsoft Learn com crédito na legenda
// (origem de cada arquivo em /assets/img/curso-fabric/FONTES.md).
// Regra do curso: o texto sozinho precisa bastar para a prova — o vídeo é
// complemento. Mapa habilidade → aula em docs/curso-fabric/.
// Ids de aula com prefixo "fab-" para não colidir com o progresso do Power BI.
const FAB_IMG = '/assets/img/curso-fabric';
const LEARN = 'https://learn.microsoft.com/pt-br/fabric';

const COURSE = [
  {
    id: 'fab-m01', title: 'Módulo 01 · Fundamentos do Microsoft Fabric e configuração do ambiente', kind: 'video',
    lessons: [
      {
        id: 'fab-o-que-e-fabric', title: 'O que é o Microsoft Fabric',
        desc: 'A plataforma de análise da Microsoft que reúne integração, engenharia, warehouse, tempo real, ciência de dados e Power BI num único serviço SaaS, com o OneLake como armazenamento comum.',
        objetivos: [
          'Explicar o que significa o Fabric ser uma plataforma SaaS e o que isso muda em relação a montar serviços separados no Azure',
          'Reconhecer as cargas de trabalho (workloads) do Fabric e para que serve cada uma',
          'Entender o papel da camada de plataforma: OneLake, Copilot e governança'
        ],
        body: 'Antes do Fabric, uma solução de dados completa na Microsoft era montada peça por peça: Data Factory para mover dados, Synapse ou Databricks para processar, um data lake no Azure Storage, Power BI para os relatórios — cada peça com seu próprio custo, sua própria segurança e sua própria cópia dos dados. O Fabric junta tudo isso num produto só, entregue como serviço (SaaS): você não cria servidor, não configura rede nem storage — abre o navegador, escolhe a experiência e começa a trabalhar em cima de um único lago de dados.',
        content: [
          { h: 'Uma plataforma, várias experiências',
            p: 'O Fabric é uma plataforma de análise de ponta a ponta: cobre desde a ingestão dos dados até o relatório final. Ele é organizado em cargas de trabalho (workloads), cada uma pensada para um perfil de profissional, mas todas rodando no mesmo ambiente e enxergando os mesmos dados. Um engenheiro de dados cria um lakehouse; o analista monta o modelo semântico em cima dele; o cientista de dados treina um modelo com os mesmos arquivos — sem exportar nem copiar nada entre ferramentas.',
            img: { src: `${FAB_IMG}/m01/arquitetura-fabric.png`, alt: 'Arquitetura do Microsoft Fabric: cargas de trabalho sobre a camada de plataforma', caption: 'As cargas de trabalho ficam em cima; embaixo, a camada de plataforma compartilhada (OneLake, Copilot e governança).', source: `${LEARN}/fundamentals/microsoft-fabric-overview` } },
          { h: 'As cargas de trabalho do Fabric',
            items: [
              '<strong>Data Factory</strong> — integração de dados: pipelines de orquestração e Dataflows Gen2 (Power Query), com mais de 200 conectores para fontes locais e na nuvem.',
              '<strong>Engenharia de Dados</strong> — Apache Spark para processar grandes volumes: lakehouses, notebooks e definições de trabalho Spark.',
              '<strong>Data Warehouse</strong> — warehouse relacional com T-SQL completo; separa computação de armazenamento e guarda os dados em formato Delta Lake aberto.',
              '<strong>Bancos de dados</strong> — banco SQL transacional no Fabric (mesmo motor do Banco de Dados SQL do Azure) e o espelhamento (mirroring), que replica continuamente bancos externos para o OneLake.',
              '<strong>Real-Time Intelligence</strong> — dados em movimento: Eventstream, Eventhouse (bancos KQL), dashboards em tempo real e alertas com o Activator.',
              '<strong>Ciência de Dados</strong> — criação e operacionalização de modelos de machine learning, com acompanhamento de experimentos e registro de modelos.',
              '<strong>Power BI</strong> — modelos semânticos, relatórios, dashboards e distribuição do conteúdo para o negócio.',
              '<strong>Fabric IQ (versão prévia)</strong> — camada de semântica de negócio: ontologias, agentes de dados e métricas reutilizáveis.'
            ] },
          { h: 'A camada de plataforma: o que todas as cargas compartilham',
            p: 'Por baixo das cargas de trabalho existe uma camada comum a todas. O <strong>OneLake</strong> é o armazenamento único de todo o tenant — todas as experiências gravam e leem nele, o que permite o acesso “cópia zero” (os dados ficam num lugar e são reutilizados por várias ferramentas). O <strong>Copilot</strong> é a assistência de IA embutida nas experiências, que ajuda a escrever consultas, código e pipelines respeitando as permissões do usuário. A <strong>governança</strong> centraliza permissões, rótulos de confidencialidade e auditoria, com integração ao Microsoft Purview.',
            img: { src: `${FAB_IMG}/m01/onelake-arquitetura.png`, alt: 'Diferentes experiências do Fabric acessando o mesmo armazenamento OneLake', caption: 'Todas as experiências de computação leem e gravam no mesmo OneLake — sem mover dados entre ferramentas.', source: `${LEARN}/fundamentals/microsoft-fabric-overview` } },
          { h: 'O que o “SaaS” muda na prática',
            items: [
              'Não há infraestrutura para provisionar: o OneLake já existe em todo tenant com o Fabric habilitado, sem configuração inicial.',
              'Você paga pela capacidade de computação (unidades de capacidade), não por serviço separado — o mesmo “saldo” atende pipelines, Spark, SQL e Power BI.',
              'Segurança e governança são configuradas uma vez e valem para todas as experiências.',
              'O OneLake é baseado no Azure Data Lake Storage Gen2, mas você não lida com grupos de recursos, contas de armazenamento ou redundância.'
            ] },
          { h: 'Malha de dados (data mesh)',
            p: 'O Fabric foi desenhado para suportar uma arquitetura de malha de dados: em vez de uma equipe central de TI controlando todos os dados, cada área de negócio pode ser dona dos seus dados, publicando-os para o resto da empresa com governança comum. Os <strong>domínios</strong> (que veremos em aula própria) são o recurso que organiza isso.' },
          { h: 'Como isso cai na prova',
            items: [
              'Saber qual carga de trabalho resolve cada necessidade (ex.: Spark e notebooks → Engenharia de Dados; streaming → Real-Time Intelligence; T-SQL relacional → Data Warehouse).',
              'Entender o OneLake como armazenamento único e o conceito de cópia zero — base de várias questões sobre atalhos, espelhamento e Direct Lake.',
              'Reconhecer que o Fabric é SaaS: questões que sugerem “provisionar storage” ou “criar cluster” costumam ter uma alternativa nativa mais simples.'
            ] }
        ],
        recursos: [
          { t: 'O que é o Microsoft Fabric?', u: `${LEARN}/fundamentals/microsoft-fabric-overview` },
          { t: 'Terminologia do Microsoft Fabric', u: `${LEARN}/fundamentals/fabric-terminology` }
        ]
      },
      {
        id: 'fab-licencas-capacidades', title: 'Licenças e capacidades',
        desc: 'Capacidade F, unidades de capacidade (CU), licenças por usuário (Free, Pro e PPU), a regra do F64 e a avaliação de 60 dias — o que é preciso para criar e para consumir cada tipo de item.',
        objetivos: [
          'Diferenciar capacidade (poder de computação) de licença por usuário',
          'Saber o que cada SKU F oferece e quando o F64 muda as regras de visualização',
          'Distinguir itens do Power BI de itens não Power BI e a licença que cada um exige'
        ],
        body: 'No Fabric existem duas coisas diferentes para licenciar, e confundir as duas é o erro mais comum em projetos e em questões de prova. A capacidade é o “motor”: um pool de computação comprado pela empresa, que executa tudo o que roda nos workspaces associados a ela. A licença por usuário diz o que cada pessoa pode fazer: criar, compartilhar ou apenas visualizar. Para colaborar no Fabric você precisa das duas: uma capacidade F (ou P) e pelo menos uma licença por usuário.',
        content: [
          { h: 'Capacidade e unidades de capacidade (CU)',
            p: 'Uma capacidade é um pool de recursos dedicado dentro do tenant. O tamanho é definido pelo SKU e medido em <strong>unidades de capacidade (CU)</strong>: um F2 tem 2 CUs, um F64 tem 64 CUs, e assim por diante até o F8192. Pipelines, Spark, SQL, Power BI — tudo consome CUs da mesma capacidade. Uma organização pode ter quantas capacidades quiser, por exemplo uma para produção e outra para desenvolvimento.',
            img: { src: `${FAB_IMG}/m01/tenants-capacidades.png`, alt: 'Exemplos de organização de tenants e capacidades do Fabric', caption: 'Uma empresa pode usar um único tenant com várias capacidades, ou tenants separados por divisão ou exigência de conformidade.', source: `${LEARN}/enterprise/licenses` } },
          { h: 'SKUs F (Azure) e SKUs P (Power BI Premium)',
            items: [
              '<strong>SKUs F</strong> são comprados pelo Azure e são a opção recomendada para o Fabric. A cobrança é por segundo (mínimo de um minuto), sem compromisso, e a capacidade pode ser pausada. Existe reserva anual para reduzir custo.',
              'Tamanhos: F2, F4, F8, F16, F32, F64, F128, F256, F512, F1024, F2048, F4096 e F8192 — o número é a quantidade de CUs.',
              'Referência de comparação com o Power BI: F64 tem o mesmo poder de computação de um P1; F128 de um P2; e assim por diante.',
              '<strong>SKUs P</strong> (Power BI Premium por capacidade) também suportam o Fabric quando o Fabric é habilitado, mas a Microsoft está descontinuando essa forma de compra — novos clientes devem usar SKUs F.',
              'SKUs A e EM (Power BI Embedded) suportam apenas itens do Power BI, não o Fabric.'
            ] },
          { h: 'Itens do Power BI x itens do Fabric',
            p: 'A licença exigida depende do tipo de item. <strong>Itens do Power BI</strong> são relatórios, modelos semânticos, dashboards, relatórios paginados, scorecards, fluxos de dados (Gen1), datamarts e aplicativos. <strong>Itens não Power BI</strong> são todo o resto: lakehouses, warehouses, notebooks, pipelines, eventhouses, bancos KQL e demais itens das cargas do Fabric.' },
          { h: 'Licenças por usuário',
            items: [
              '<strong>Free (Fabric gratuita)</strong> — atribuída automaticamente no primeiro acesso ao Fabric. Permite criar e compartilhar itens não Power BI em workspaces que estejam numa capacidade F ou de avaliação.',
              '<strong>Power BI Pro</strong> — necessária para criar itens do Power BI fora do “Meu workspace” e para compartilhá-los. Toda organização que usa Power BI no Fabric precisa de pelo menos um usuário Pro ou PPU.',
              '<strong>Premium por Usuário (PPU)</strong> — dá acesso à maioria dos recursos Premium do Power BI (mais atualizações por dia, modelos acima de 1 GB, ponto de extremidade XMLA) licenciando pessoa por pessoa. <strong>Atenção:</strong> PPU não é capacidade Fabric — com PPU você não cria lakehouse, warehouse nem notebook.'
            ] },
          { h: 'A regra do F64 (cai muito na prova)',
            p: 'Em capacidades <strong>F64 ou maiores</strong>, um usuário com licença gratuita consegue <strong>visualizar</strong> conteúdo do Power BI, desde que tenha a função de Visualizador no workspace. Em capacidades <strong>menores que F64</strong> (F2 a F32), todo usuário que for ver um relatório do Power BI precisa de licença Pro, PPU ou avaliação individual. Por isso o F64 é um divisor de águas no custo: para muitos leitores, pode sair mais barato do que licenciar cada um com Pro.' },
          { h: 'A avaliação (trial) do Fabric',
            items: [
              'Dura <strong>60 dias</strong> e dá acesso a quase todas as experiências.',
              'É configurada como uma capacidade F4 ou F64, e pode ser aumentada para 64 CUs quando começa com 4.',
              'Inclui uma avaliação individual do Power BI para quem ainda não tem licença PPU.',
              'Quando termina, o conteúdo fica guardado no OneLake por 7 dias e pode ser recuperado atribuindo o workspace a uma capacidade paga F ou P.'
            ] },
          { h: 'Cenários de licenciamento',
            items: [
              'Equipe pequena (menos de 250 pessoas) que só usa Power BI Premium → licenças PPU (não habilita as cargas do Fabric).',
              'Criar lakehouses, notebooks e warehouses → capacidade F + licença gratuita.',
              'Muitas pessoas só lendo relatórios → capacidade F64 ou maior + licença gratuita com função de Visualizador.',
              'Experimentar o Fabric → capacidade de avaliação de 60 dias.'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              'Questões de custo: “X pessoas precisam só visualizar relatórios” — a resposta passa pela regra do F64.',
              'Pegadinha clássica: PPU não permite criar itens do Fabric (lakehouse, notebook, warehouse).',
              'Saber que SKU F é cobrado por segundo e pode ser pausado; SKU P exige compromisso e está sendo descontinuado.'
            ] }
        ],
        recursos: [
          { t: 'Entenda as licenças e a capacidade do Microsoft Fabric', u: `${LEARN}/enterprise/licenses` },
          { t: 'Capacidade de avaliação do Fabric', u: `${LEARN}/fundamentals/fabric-trial` },
          { t: 'Comprar capacidade do Fabric', u: `${LEARN}/enterprise/buy-capacity` }
        ]
      },
      {
        id: 'fab-tenant-workspace-itens', title: 'Tenant, capacidade, workspace e itens',
        desc: 'A hierarquia que organiza tudo no Fabric: o tenant contém capacidades, as capacidades hospedam workspaces e os workspaces guardam os itens.',
        objetivos: [
          'Descrever a hierarquia tenant → capacidade → workspace → item',
          'Entender o “Meu workspace”, a capacidade compartilhada e os tipos de workspace',
          'Navegar pelo layout de um workspace do Fabric'
        ],
        body: 'Tudo no Fabric tem um lugar certo, e a prova cobra que você saiba em qual nível cada configuração acontece. Configurações de tenant valem para a empresa toda; configurações de capacidade afetam os workspaces que rodam nela; permissões de workspace valem para todos os itens dentro dele; e permissões de item são as mais específicas.',
        content: [
          { h: 'Tenant',
            p: 'O Fabric roda dentro de um tenant (locatário) do Microsoft Entra, associado ao domínio da empresa. É no nível do tenant que o administrador do Fabric liga ou desliga recursos para a organização inteira, pelo portal de administração. Cada tenant tem um único OneLake.' },
          { h: 'Capacidade',
            p: 'As capacidades ficam dentro do tenant e fornecem a computação. Todo tenant com Fabric também tem uma capacidade compartilhada, que hospeda os “Meu workspace” e os workspaces do tipo Pro ou PPU. Um workspace pode ser movido para outra capacidade a qualquer momento — por exemplo, de uma capacidade de avaliação para uma F paga.' },
          { h: 'Workspace e itens',
            p: 'O workspace é o contêiner onde a equipe colabora: dentro dele ficam os itens — lakehouses, warehouses, notebooks, pipelines, modelos semânticos, relatórios. Cada usuário tem um workspace pessoal (“Meu workspace”) e cria outros workspaces para trabalhar em equipe. Workspaces também podem ter pastas para organizar os itens.',
            img: { src: `${FAB_IMG}/m01/hierarquia-tenant-workspace.png`, alt: 'Hierarquia de itens dentro de um workspace no tenant', caption: 'Dentro do tenant ficam os workspaces, e dentro de cada workspace os itens (lakehouses, modelos semânticos etc.).', source: `${LEARN}/fundamentals/microsoft-fabric-overview` } },
          { h: 'Tipos de workspace',
            p: 'O antigo “modo de licença” hoje se chama <strong>tipo de workspace</strong> e define em qual capacidade o workspace roda e, portanto, o que ele suporta. Workspaces do tipo Power BI Pro, PPU ou Embedded suportam só o Power BI. Workspaces do tipo <strong>Fabric (SKU F)</strong>, <strong>Avaliação do Fabric</strong> ou <strong>Power BI Premium (SKU P)</strong> suportam todas as experiências do Fabric.',
            img: { src: `${FAB_IMG}/m01/workspace-tipo-licenca.png`, alt: 'Configuração de tipo de workspace nas configurações do workspace', caption: 'O tipo de workspace é escolhido nas configurações do workspace e define qual capacidade ele usa.', source: `${LEARN}/fundamentals/workspaces` } },
          { h: 'O layout de um workspace',
            p: 'Ao abrir um workspace você vê o cabeçalho (nome, configurações, acesso), a barra de ferramentas para criar novos itens e a área de conteúdo com a lista de itens, que pode ser filtrada por tipo. É também pelo workspace que você acessa as configurações de controle de versão (Git), as funções de acesso e as configurações das cargas de trabalho, que veremos nos próximos módulos.',
            img: { src: `${FAB_IMG}/m01/workspace-layout.png`, alt: 'Layout de um workspace do Fabric', caption: 'Cabeçalho, barra de ferramentas e área de conteúdo de um workspace.', source: `${LEARN}/fundamentals/workspaces` } },
          { h: 'Como isso cai na prova',
            items: [
              'Identificar em que nível uma configuração é feita (tenant, capacidade, domínio, workspace ou item).',
              'Saber que itens não Power BI exigem workspace em capacidade Fabric (F, P com Fabric habilitado ou avaliação).',
              'Lembrar que mover um workspace de capacidade é a forma de “reativar” conteúdo após o fim da avaliação.'
            ] }
        ],
        recursos: [
          { t: 'Workspaces no Microsoft Fabric', u: `${LEARN}/fundamentals/workspaces` },
          { t: 'Entenda as licenças e a capacidade do Microsoft Fabric', u: `${LEARN}/enterprise/licenses` }
        ]
      },
      {
        id: 'fab-dominios', title: 'Domínios e subdomínios',
        desc: 'Como agrupar os dados da empresa por área de negócio, delegar a gestão a cada área e facilitar a descoberta no catálogo do OneLake.',
        objetivos: [
          'Explicar o que é um domínio e como ele se relaciona com workspaces e itens',
          'Conhecer as três funções: administrador do Fabric, administrador de domínio e colaborador de domínio',
          'Configurar domínio padrão e configurações delegadas'
        ],
        body: 'Quando a empresa tem dezenas de workspaces, encontrar o dado certo vira um problema. Domínios resolvem isso agrupando logicamente os dados por área — Vendas, Financeiro, RH — e permitindo que cada área administre o seu pedaço com regras próprias, dentro da governança da empresa. É a peça que viabiliza a malha de dados (data mesh) no Fabric.',
        content: [
          { h: 'Domínio',
            p: 'Um domínio agrupa todos os dados relevantes para uma área ou assunto. A associação acontece pelo workspace: quando um workspace é atribuído a um domínio, <strong>todos os itens desse workspace</strong> passam a pertencer ao domínio, que vira um atributo nos metadados de cada item. Um workspace pertence a um domínio de cada vez.',
            img: { src: `${FAB_IMG}/m01/dominios-pagina.png`, alt: 'Página de domínios no portal de administração do Fabric', caption: 'A página de domínios no portal de administração.', source: `${LEARN}/governance/domains` } },
          { h: 'Subdomínios',
            p: 'Subdomínios refinam o agrupamento dentro de um domínio — por exemplo, o domínio Vendas com os subdomínios Varejo e Atacado. Workspaces podem ser atribuídos diretamente a um subdomínio. Para criar subdomínios é preciso ser administrador do Fabric ou administrador do domínio.' },
          { h: 'As três funções de domínio',
            items: [
              '<strong>Administrador do Fabric</strong> — cria e edita domínios, define administradores e colaboradores de domínio e associa workspaces a qualquer domínio. Vê todos os domínios.',
              '<strong>Administrador de domínio</strong> — definido pelo administrador do Fabric; altera as configurações do domínio (exceto o nome), cria subdomínios, atribui workspaces e define os colaboradores do domínio.',
              '<strong>Colaborador de domínio</strong> — pode atribuir os workspaces que administra ao domínio. Por padrão, todos na organização podem ser colaboradores; isso pode ser restrito a usuários ou grupos específicos.'
            ],
            img: { src: `${FAB_IMG}/m01/dominios-atribuir-workspaces.png`, alt: 'Painel para atribuir workspaces a um domínio', caption: 'Atribuindo workspaces a um domínio — todos os itens desses workspaces passam a pertencer a ele.', source: `${LEARN}/governance/domains` } },
          { h: 'Domínio padrão',
            p: 'Um domínio pode ser definido como padrão para determinados usuários ou grupos de segurança. A partir daí, os workspaces sem domínio que essas pessoas administram — e os novos workspaces que elas criarem — são atribuídos automaticamente a esse domínio. Útil para garantir que o conteúdo de uma área nasça já organizado.' },
          { h: 'Configurações delegadas',
            p: 'Algumas configurações que normalmente são definidas para o tenant inteiro podem ser <strong>delegadas</strong> ao nível do domínio, para cada área de negócio seguir suas próprias regras. Exemplos: o <strong>rótulo de confidencialidade padrão</strong> aplicado aos itens dos workspaces do domínio, e as <strong>configurações de certificação</strong> (quem pode certificar itens como confiáveis).' },
          { h: 'Domínios no catálogo do OneLake',
            p: 'No catálogo do OneLake, o usuário pode filtrar pelo seletor de domínio e ver apenas os itens daquela área. O domínio pode ter uma imagem ou cor própria, exibida no catálogo quando selecionado.',
            img: { src: `${FAB_IMG}/m01/dominio-no-catalogo.png`, alt: 'Catálogo do OneLake exibindo a imagem de um domínio', caption: 'O domínio selecionado no catálogo do OneLake, com sua imagem de identificação.', source: `${LEARN}/governance/domains` } },
          { h: 'Como isso cai na prova',
            items: [
              'DP-700 cobra “definir as configurações do workspace de domínio”: saber que a atribuição é por workspace e que os itens herdam o domínio.',
              'Saber quem pode fazer o quê: só o administrador do Fabric cria domínios e define administradores de domínio.',
              'Reconhecer o que pode ser delegado ao domínio (rótulo padrão, certificação).'
            ] }
        ],
        recursos: [
          { t: 'Domínios do Fabric', u: `${LEARN}/governance/domains` },
          { t: 'Práticas recomendadas para planejar e criar domínios', u: `${LEARN}/governance/domains-best-practices` }
        ]
      },
      {
        id: 'fab-config-workspace', title: 'Configurações do workspace: Spark, OneLake e Apache Airflow',
        desc: 'Pools, ambientes e runtime do Spark, controles de trabalhos, alta simultaneidade, cache de atalhos do OneLake e pools do Apache Airflow — o que o administrador do workspace ajusta.',
        objetivos: [
          'Configurar o pool padrão (inicial ou personalizado) e o ambiente do Spark no workspace',
          'Entender admissão de trabalhos, tempo máximo de execução e alta simultaneidade',
          'Configurar o cache de atalhos do OneLake e o pool do Apache Airflow'
        ],
        body: 'Cada workspace tem configurações próprias para as cargas de trabalho que rodam nele. Na prova DP-700 há uma habilidade inteira sobre isso: definir as configurações de Spark, de domínio, de OneLake e de Apache Airflow do workspace. Aqui o foco é saber o que cada opção faz e quando mudar o padrão.',
        content: [
          { h: 'Onde ficam as configurações',
            p: 'Nas configurações do workspace, cada carga de trabalho tem sua seção. As opções do Spark ficam em <strong>Engenharia de Dados/Ciência de Dados</strong>; as do Airflow em <strong>Data Factory</strong>; as do OneLake na aba <strong>OneLake</strong>.',
            img: { src: `${FAB_IMG}/m01/spark-menu-engenharia.png`, alt: 'Menu de Engenharia de Dados nas configurações do workspace', caption: 'Acesso às configurações de Spark do workspace (Engenharia de Dados).', source: `${LEARN}/data-engineering/workspace-admin-settings` } },
          { h: 'Pool do Spark: inicial ou personalizado',
            items: [
              '<strong>Pool inicial (starter pool)</strong> — criado automaticamente, com clusters de tamanho médio mantidos “pré-aquecidos”: a sessão do Spark começa em segundos. É o padrão, dimensionado conforme o SKU da capacidade.',
              '<strong>Pool personalizado</strong> — você define o tamanho dos nós, se há escala automática e quantidade de nós. Útil para cargas maiores ou para limitar o consumo. Sessões em pools personalizados demoram mais para iniciar do que no pool inicial.',
              'A opção de <strong>personalizar a computação para itens</strong> permite que notebooks e trabalhos usem configurações diferentes do padrão do workspace.'
            ],
            img: { src: `${FAB_IMG}/m01/spark-pool-personalizado.png`, alt: 'Opções de criação de pool personalizado do Spark', caption: 'Criação de um pool personalizado do Spark no workspace.', source: `${LEARN}/data-engineering/workspace-admin-settings` } },
          { h: 'Ambiente e versão do runtime',
            p: 'Um <strong>ambiente</strong> reúne as configurações para executar trabalhos Spark: propriedades de computação, versão do runtime, bibliotecas e dependências. O workspace pode ter um ambiente padrão, usado por notebooks e definições de trabalho Spark que não escolherem outro. A versão do runtime determina as versões do Spark, do Delta Lake e do Python disponíveis.',
            img: { src: `${FAB_IMG}/m01/spark-versao-runtime.png`, alt: 'Seleção da versão de runtime do Spark', caption: 'Escolha da versão do runtime do Spark para o workspace.', source: `${LEARN}/data-engineering/workspace-admin-settings` } },
          { h: 'Trabalhos e alta simultaneidade',
            items: [
              '<strong>Admissão de trabalhos</strong> — por padrão os workspaces usam admissão otimista: o trabalho é aceito com o mínimo de núcleos e cresce conforme a capacidade permite.',
              '<strong>Tempo máximo de vida do trabalho</strong> — limite que encerra automaticamente trabalhos Spark do usuário (notebooks interativos, agendados ou chamados por pipeline) que passem da duração definida. Evita que um processo travado consuma a capacidade indefinidamente.',
              '<strong>Alta simultaneidade</strong> — permite que vários notebooks compartilhem a mesma sessão do Spark, economizando tempo de início e computação. Pode ser habilitada para notebooks e para notebooks executados por pipelines.'
            ] },
          { h: 'Configurações do OneLake no workspace',
            p: 'Na aba OneLake do workspace você habilita o <strong>cache de atalhos</strong>: quando o OneLake lê arquivos por meio de um atalho para outra nuvem (Amazon S3, compatível com S3, Google Cloud Storage) ou por gateway local, ele guarda os arquivos num cache do workspace e passa a responder a partir dele — reduzindo custo de saída de dados (egress) da outra nuvem. Você escolhe o período de retenção e pode limpar o cache a qualquer momento com <strong>Redefinir cache</strong>. Já o acesso ao OneLake por aplicativos fora do Fabric e o aplicativo explorador de arquivos do OneLake são controlados nas configurações de tenant, pelo administrador.' },
          { h: 'Configurações do Apache Airflow',
            p: 'Os trabalhos do Apache Airflow no Fabric (orquestração com DAGs em Python) rodam num pool configurado em Data Factory → Configurações de Runtime do Apache Airflow.',
            items: [
              '<strong>Pool inicial</strong> — nós grandes, inicialização instantânea, desliga após 20 minutos sem atividade. Indicado para desenvolvimento.',
              '<strong>Pool personalizado</strong> — você define tamanho do nó (Small para DAGs simples, Large para DAGs complexos), escala automática e nós extras (cada nó extra permite mais três workers). Fica sempre ligado até ser pausado manualmente. Indicado para produção.'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              'Quando usar pool personalizado em vez do inicial (controle de tamanho/custo, requisitos específicos) e o impacto no tempo de início.',
              'Para que serve o ambiente (bibliotecas, runtime, propriedades) e onde defini-lo como padrão.',
              'Cache de atalhos: reduz egress de outras nuvens; configurado no workspace.',
              'Pool do Airflow: inicial para desenvolvimento, personalizado para produção.'
            ] }
        ],
        recursos: [
          { t: 'Configurações de administração do workspace de Engenharia de Dados', u: `${LEARN}/data-engineering/workspace-admin-settings` },
          { t: 'Configurações do workspace de trabalhos do Apache Airflow', u: `${LEARN}/data-factory/apache-airflow-jobs-workspace-settings` },
          { t: 'Atalhos do OneLake (inclui cache)', u: `${LEARN}/onelake/onelake-shortcuts` },
          { t: 'Configurações de tenant do OneLake', u: `${LEARN}/admin/service-admin-portal-onelake` }
        ]
      },
      {
        id: 'fab-descobrir-dados', title: 'Descobrir dados: catálogo do OneLake e hub Real-Time',
        desc: 'Os dois pontos de partida para encontrar dados no Fabric: o catálogo do OneLake para itens de dados e o hub Real-Time para dados em movimento.',
        objetivos: [
          'Usar o catálogo do OneLake para encontrar, explorar e governar itens',
          'Entender o hub Real-Time como ponto central de dados de streaming',
          'Saber quando procurar em cada um'
        ],
        body: 'A prova DP-600 pede que você saiba descobrir dados usando o catálogo do OneLake e o hub Real-Time. Os dois existem automaticamente em todo tenant com Fabric, sem nenhuma configuração, e cada um mostra apenas o que o usuário tem permissão de acessar.',
        content: [
          { h: 'Catálogo do OneLake',
            p: 'O catálogo do OneLake é o lugar centralizado para encontrar, explorar e usar os itens do Fabric — lakehouses, warehouses, modelos semânticos, relatórios — e para acompanhar a governança dos dados que você possui. É aberto pelo ícone do OneLake na navegação do Fabric. Você pode filtrar por tipo de item, por domínio e por endosso (itens promovidos ou certificados), e abrir os detalhes de cada item para ver descrição, dono, linhagem e onde ele é usado.',
            img: { src: `${FAB_IMG}/m01/onelake-catalogo.png`, alt: 'Catálogo do OneLake', caption: 'O catálogo do OneLake: busca, filtros por tipo e domínio, e detalhes de cada item.', source: `${LEARN}/governance/onelake-catalog-overview` } },
          { h: 'Hub Real-Time',
            p: 'O hub Real-Time é o ponto único de todo o tenant para dados em movimento. Ele lista automaticamente as saídas dos eventstreams em execução e as tabelas dos bancos KQL que você pode acessar, além de oferecer conectores prontos para trazer novos fluxos (por exemplo Azure Event Hubs, IoT Hub, bancos com captura de mudanças e eventos do próprio Fabric e do Azure). A partir dele você cria streams, processa com transformações do Eventstream e define alertas.',
            img: { src: `${FAB_IMG}/m01/hub-real-time.png`, alt: 'Hub Real-Time do Fabric', caption: 'O hub Real-Time: fontes de streaming, fluxos e tabelas KQL acessíveis ao usuário.', source: `${LEARN}/real-time-hub/real-time-hub-overview` } },
          { h: 'Quando usar cada um',
            items: [
              'Procurando uma tabela, um lakehouse, um modelo semântico ou um relatório → catálogo do OneLake.',
              'Procurando um fluxo de eventos, uma fonte de streaming ou uma tabela KQL alimentada em tempo real → hub Real-Time.',
              'Nos dois casos, o que aparece depende das permissões do usuário — ninguém descobre dados a que não tem acesso.'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              'Habilidade DP-600 “Descobrir dados usando o catálogo do OneLake e o hub Real-Time”.',
              'Saber que o hub Real-Time já existe em todo tenant, sem configuração, e mostra eventstreams e tabelas KQL.'
            ] }
        ],
        recursos: [
          { t: 'Visão geral do catálogo do OneLake', u: `${LEARN}/governance/onelake-catalog-overview` },
          { t: 'Introdução ao hub Real-Time', u: `${LEARN}/real-time-hub/real-time-hub-overview` }
        ]
      },
      {
        id: 'fab-escolher-armazenamento', title: 'Escolher o armazenamento certo',
        desc: 'Lakehouse, Warehouse, Eventhouse, banco SQL e Cosmos DB no Fabric: quem usa, com qual linguagem e para qual tipo de carga — o guia de decisão oficial explicado.',
        objetivos: [
          'Comparar os armazenamentos do Fabric por perfil, linguagem e tipo de dado',
          'Escolher o armazenamento adequado a partir de um cenário de negócio',
          'Lembrar que todos gravam no OneLake e podem ser combinados'
        ],
        body: 'Esta é uma das decisões mais cobradas nas duas provas: dado um cenário, qual armazenamento usar? A boa notícia é que a escolha segue uma lógica clara — o perfil da equipe, a linguagem que ela domina, o tipo de carga (analítica, transacional ou em tempo real) e o volume. E como todos guardam os dados no OneLake, a escolha não isola os dados: um warehouse pode ler um lakehouse e vice-versa.',
        content: [
          { h: 'O guia de decisão',
            img: { src: `${FAB_IMG}/m01/guia-decisao-armazenamento.svg`, alt: 'Guia de decisão para escolher o armazenamento de dados no Microsoft Fabric', caption: 'Guia de decisão oficial para escolher o armazenamento no Fabric.', source: `${LEARN}/fundamentals/decision-guide-data-store` } },
          { h: 'Os armazenamentos, lado a lado',
            items: [
              '<strong>Lakehouse</strong> — engenheiros e cientistas de dados; Spark (PySpark, Scala, Spark SQL, R) em notebooks; dados estruturados, semiestruturados e não estruturados (arquivos e tabelas Delta). Tem um ponto de extremidade de análise SQL só leitura para quem consulta em T-SQL.',
              '<strong>Warehouse</strong> — desenvolvedores de data warehouse e arquitetos; T-SQL completo com leitura e escrita, transações e modelagem em esquema estrela; dados estruturados.',
              '<strong>Eventhouse</strong> — dados em tempo real, séries temporais, logs e telemetria em grande volume; consultas em KQL (e T-SQL); ingestão contínua com latência baixa.',
              '<strong>Banco de dados SQL no Fabric</strong> — cargas transacionais (OLTP) de aplicações: alta simultaneidade, transações ACID e chaves estrangeiras; mesmo motor do Banco de Dados SQL do Azure; os dados são replicados automaticamente para o OneLake para análise.',
              '<strong>Cosmos DB no Fabric</strong> — dados NoSQL para aplicações e IA, acessados por APIs REST (JavaScript, Python, C#, Java).'
            ] },
          { h: 'Cenários típicos',
            items: [
              'Equipe com anos de SQL, consumidores que também consultam em SQL, precisa de escrita transacional em T-SQL → <strong>Warehouse</strong>.',
              'Vários terabytes, equipe mista de PySpark (engenharia) e T-SQL (consumo) → <strong>Lakehouse</strong>: engenheiros transformam com Spark e os consumidores leem pelo ponto de extremidade SQL.',
              'Bilhões de linhas, análise de séries temporais e resposta rápida para painéis → <strong>Eventhouse</strong>.',
              'Aplicação .NET operacional com alta simultaneidade e integridade referencial → <strong>banco de dados SQL no Fabric</strong>.'
            ] },
          { h: 'Uma regra prática',
            p: 'Pergunte primeiro <strong>como os dados chegam e como serão usados</strong>: arquivos e processamento em Spark apontam para lakehouse; modelagem relacional com escrita em SQL aponta para warehouse; eventos contínuos apontam para eventhouse; aplicação transacional aponta para banco SQL. Depois confira a <strong>habilidade da equipe</strong> — a ferramenta certa é a que o time consegue manter.' },
          { h: 'Como isso cai na prova',
            items: [
              'DP-600 “Escolher entre armazenamentos de dados diferentes” e DP-700 “Escolher um armazenamento de dados apropriado”.',
              'Palavras-chave: “PySpark/notebook” → lakehouse; “T-SQL com escrita/transações” → warehouse; “streaming/telemetria/KQL” → eventhouse; “aplicação OLTP” → banco SQL.',
              'Pegadinha: o ponto de extremidade SQL do lakehouse é somente leitura — escrita em T-SQL exige warehouse.'
            ] }
        ],
        recursos: [
          { t: 'Guia de decisão: escolha um armazenamento de dados', u: `${LEARN}/fundamentals/decision-guide-data-store` },
          { t: 'Guia de decisão: lakehouse ou warehouse', u: `${LEARN}/fundamentals/decision-guide-lakehouse-warehouse` }
        ]
      }
    ]
  },
  {
    id: 'fab-m02', title: 'Módulo 02 · OneLake: o data lake único do Fabric', kind: 'video',
    lessons: [
      {
        id: 'fab-onelake', title: 'OneLake: um lago para toda a empresa',
        desc: 'O armazenamento único de todo o tenant: como ele é organizado, em que formato guarda os dados e como ferramentas de fora do Fabric se conectam a ele.',
        objetivos: [
          'Explicar por que existe um único OneLake por tenant e o que isso resolve',
          'Descrever a hierarquia tenant → workspace → item e o endereço (URI) de um dado no OneLake',
          'Conhecer as formas de acesso: portal, explorador de arquivos e APIs/SDKs do ADLS Gen2'
        ],
        body: 'Antes do OneLake era comum cada departamento ter o seu data lake — contas de armazenamento separadas, cópias do mesmo dado em vários lugares e regras de acesso diferentes em cada um. O OneLake acaba com isso: cada tenant do Fabric tem exatamente um OneLake, criado automaticamente, que não pode ser excluído nem duplicado. É o “OneDrive dos dados”: todos os workspaces e itens guardam os dados ali, e todas as ferramentas do Fabric leem de lá.',
        content: [
          { h: 'Um lago por tenant, sem nada para provisionar',
            p: 'O OneLake é baseado no Azure Data Lake Storage (ADLS) Gen2, mas entregue como SaaS: não existe conta de armazenamento, grupo de recursos ou configuração de redundância para gerenciar. Ele vem com o tenant, é único e é o repositório central de todos os dados de análise da organização. A governança é centralizada (políticas do tenant valem para tudo que chega ao OneLake), enquanto a propriedade é distribuída: cada equipe cuida dos seus workspaces.',
            img: { src: `${FAB_IMG}/m02/onelake-fundacao.png`, alt: 'O OneLake como fundação do Fabric', caption: 'O OneLake é a fundação comum sobre a qual todas as cargas de trabalho do Fabric funcionam.', source: `${LEARN}/onelake/onelake-overview` } },
          { h: 'Hierarquia e endereço dos dados',
            p: 'Os dados seguem a hierarquia <strong>tenant → workspace → item → pastas e arquivos</strong>. Por isso qualquer dado do tenant tem um endereço previsível no formato <code>https://onelake.dfs.fabric.microsoft.com/&lt;workspace&gt;/&lt;item&gt;.&lt;tipo&gt;/&lt;caminho&gt;/&lt;arquivo&gt;</code> — por exemplo <code>.../Vendas/Bronze.Lakehouse/Files/pedidos.csv</code>. Para manter o tráfego dentro de uma região (residência de dados), existe o ponto de extremidade regional <code>https://&lt;região&gt;-onelake.dfs.fabric.microsoft.com</code>.' },
          { h: 'Formatos abertos: nada fica preso',
            p: 'O OneLake guarda tabelas em formatos abertos — Delta Lake (sobre arquivos Parquet) e Apache Iceberg. Por virtualização de metadados, tabelas Iceberg podem ser lidas como Delta pelas cargas do Fabric e vice-versa. Na prática, qualquer ferramenta que leia esses padrões consegue usar os dados, dentro ou fora do Fabric.' },
          { h: 'Como acessar o OneLake de fora do portal',
            items: [
              '<strong>APIs e SDKs do ADLS Gen2 e do Blob Storage</strong> — o OneLake é compatível: cada workspace aparece como um contêiner e cada item como uma pasta. Ferramentas como o Azure Storage Explorer, o Azure Databricks ou aplicativos próprios se conectam com autenticação do Microsoft Entra ID.',
              '<strong>Explorador de arquivos do OneLake para Windows</strong> — mostra os workspaces e itens dentro do Explorador de Arquivos do Windows, para abrir, copiar e enviar arquivos como no OneDrive.',
              'Operações de gestão (permissões, criar ou atualizar itens) continuam sendo feitas pelo Fabric, não pelas APIs do ADLS.',
              'O acesso por aplicativos fora do Fabric e o uso do explorador de arquivos podem ser liberados ou bloqueados pelo administrador nas configurações de tenant do OneLake.'
            ],
            img: { src: `${FAB_IMG}/m02/acesso-outras-ferramentas.png`, alt: 'Acesso aos dados do OneLake com APIs e SDKs', caption: 'O OneLake aceita as mesmas APIs e SDKs do ADLS Gen2, então ferramentas existentes se conectam sem mudanças.', source: `${LEARN}/onelake/onelake-overview` } },
          { h: 'O explorador de arquivos do OneLake',
            img: { src: `${FAB_IMG}/m02/explorador-arquivos.png`, alt: 'OneLake no Explorador de Arquivos do Windows', caption: 'Workspaces e itens do OneLake integrados ao Explorador de Arquivos do Windows.', source: `${LEARN}/onelake/onelake-file-explorer` } },
          { h: 'Proteção e monitoramento',
            items: [
              'Redundância automática: ZRS (zonas de disponibilidade) nas regiões que suportam, LRS nas demais.',
              '<strong>Diagnóstico do OneLake</strong>, habilitado por workspace, grava em um lakehouse os eventos de acesso aos dados — quem acessou o quê e quando.'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              'OneLake é um só por tenant, não se cria outro nem se exclui.',
              'Ferramentas compatíveis com ADLS Gen2 acessam o OneLake (workspace = contêiner, item = pasta).',
              'O acesso de aplicativos externos é controlado por configuração de tenant.'
            ] }
        ],
        recursos: [
          { t: 'O que é o OneLake?', u: `${LEARN}/onelake/onelake-overview` },
          { t: 'Conectar-se ao OneLake (APIs e URI)', u: `${LEARN}/onelake/onelake-access-api` },
          { t: 'Explorador de arquivos do OneLake', u: `${LEARN}/onelake/onelake-file-explorer` }
        ]
      },
      {
        id: 'fab-delta-parquet', title: 'Tabelas Delta, arquivos Parquet e a pasta Tables × Files',
        desc: 'Por que o Fabric padroniza tudo em Delta Lake, o que o Delta acrescenta ao Parquet e como o lakehouse separa tabelas de arquivos.',
        objetivos: [
          'Explicar a relação entre Parquet (formato de arquivo) e Delta Lake (formato de tabela)',
          'Listar o que o Delta acrescenta: transações, histórico de versões e controle de esquema',
          'Diferenciar a pasta Tables da pasta Files em um lakehouse'
        ],
        body: 'A mesma tabela no Fabric pode ser escrita pelo T-SQL de um warehouse, lida por um notebook Spark e servida ao Power BI em Direct Lake — sem cópia. Isso só funciona porque todos os mecanismos falam o mesmo formato: o Delta Lake. Entender o formato é essencial para entender atalhos, Direct Lake e otimização de tabelas, que vêm nos próximos módulos.',
        content: [
          { h: 'Parquet: o arquivo colunar',
            p: 'Parquet é um formato de arquivo aberto e colunar: em vez de gravar linha por linha, grava coluna por coluna, com compressão. Consultas analíticas que leem poucas colunas de muitas linhas ficam muito mais rápidas e os arquivos ficam menores que um CSV.' },
          { h: 'Delta Lake: a tabela sobre os arquivos Parquet',
            p: 'Uma tabela Delta é uma pasta com arquivos Parquet (os dados) mais uma pasta <code>_delta_log</code> com arquivos JSON que registram cada alteração (o log de transações). É esse log que transforma “um monte de arquivos” em uma tabela de verdade:',
            items: [
              '<strong>Transações ACID</strong> — uma gravação ou é aplicada inteira ou não é; leitores nunca veem dados pela metade.',
              '<strong>Histórico de versões (time travel)</strong> — cada alteração gera uma nova versão, e é possível consultar como a tabela estava antes.',
              '<strong>Controle de esquema</strong> — o Delta rejeita dados que não batem com o esquema da tabela, a menos que a evolução de esquema seja permitida.',
              '<strong>Atualizações, exclusões e MERGE</strong> — operações que o Parquet puro não suporta de forma eficiente.'
            ] },
          { h: 'Delta é o padrão de todo o Fabric',
            p: 'No lakehouse, o Delta Lake é o formato padrão de tabela; o warehouse também grava em Delta; o espelhamento e a disponibilidade do OneLake no Eventhouse produzem tabelas Delta. Por isso o mesmo dado serve a vários mecanismos: T-SQL, Spark, Analysis Services (Power BI) e outros.',
            img: { src: `${FAB_IMG}/m02/mesma-copia-dados.png`, alt: 'Mesma cópia de dados usada por vários mecanismos', caption: 'Um único conjunto de dados em Delta, carregado com Spark, consultado com T-SQL e usado pelo Power BI — sem cópias.', source: `${LEARN}/onelake/onelake-overview` } },
          { h: 'Tables × Files no lakehouse',
            p: 'Todo lakehouse tem duas pastas de nível superior. <strong>Tables</strong> é a área gerenciada para dados estruturados em Delta: o Fabric descobre automaticamente as tabelas que estão ali e as expõe ao ponto de extremidade SQL e ao modelo semântico. <strong>Files</strong> é a área não gerenciada para arquivos de qualquer tipo — CSV, JSON, imagens, Parquet solto — normalmente a zona de chegada (landing) dos dados brutos.',
            img: { src: `${FAB_IMG}/m02/atalho-tabelas-arquivos.png`, alt: 'Visões Arquivos e Tabelas de um lakehouse', caption: 'As áreas Files (arquivos) e Tables (tabelas Delta) de um lakehouse, lado a lado.', source: `${LEARN}/onelake/onelake-shortcuts` } },
          { h: 'Como isso cai na prova',
            items: [
              'Saber que Delta = Parquet + log de transações, e o que o log permite (ACID, versões, esquema).',
              'Arquivos em Files não aparecem como tabelas no SQL nem no modelo semântico até serem carregados em Tables como Delta.',
              'O formato comum é o que permite “uma cópia, vários mecanismos” — base do Direct Lake.'
            ] }
        ],
        recursos: [
          { t: 'Tabelas Lakehouse e Delta Lake', u: `${LEARN}/data-engineering/lakehouse-and-delta-tables` },
          { t: 'O que é o OneLake?', u: `${LEARN}/onelake/onelake-overview` }
        ]
      },
      {
        id: 'fab-atalhos', title: 'Atalhos (shortcuts) do OneLake',
        desc: 'Como referenciar dados de outros workspaces, outras nuvens ou do ambiente local sem copiá-los: tipos de atalho, onde criá-los, permissões, autenticação, cache e limites.',
        objetivos: [
          'Criar atalhos internos e externos em um lakehouse e em um banco KQL',
          'Entender as permissões para criar e acessar atalhos e os modelos de autenticação',
          'Saber o que acontece ao excluir um atalho e quais são os limites'
        ],
        body: 'O atalho é a ferramenta mais usada para aplicar a ideia de “uma cópia só”. Em vez de copiar a tabela de outro workspace ou os arquivos de um bucket S3, você cria um atalho: ele aparece como uma pasta comum, e qualquer mecanismo do Fabric lê os dados como se estivessem ali. A prova DP-700 tem a habilidade “Criar e gerenciar atalhos do OneLake” e cobra também erros de atalho.',
        content: [
          { h: 'O que é um atalho',
            p: 'Um atalho é um objeto do OneLake que aponta para outro local de armazenamento. O lugar para onde ele aponta é o <strong>caminho de destino</strong>; o lugar onde ele aparece é o <strong>caminho do atalho</strong>. Funciona como um link simbólico: é independente do destino, e os dados não são copiados.',
            img: { src: `${FAB_IMG}/m02/atalho-conecta-local.png`, alt: 'Atalho conectando a outro local de armazenamento', caption: 'O atalho aparece como pasta no lakehouse, mas os dados continuam no local de destino.', source: `${LEARN}/onelake/onelake-shortcuts` } },
          { h: 'Tipos de atalho',
            items: [
              '<strong>Internos (OneLake)</strong> — apontam para itens do Fabric: lakehouses, warehouses, bancos KQL e outros, no mesmo workspace ou em outro.',
              '<strong>Externos</strong> — Azure Data Lake Storage Gen2, Azure Blob Storage, Amazon S3, armazenamento compatível com S3, Google Cloud Storage, Dataverse, Iceberg, OneDrive e SharePoint.',
              '<strong>Locais ou com restrição de rede</strong> — por meio do gateway de dados local.'
            ],
            img: { src: `${FAB_IMG}/m02/novo-atalho-fontes.png`, alt: 'Janela Novo atalho com as fontes disponíveis', caption: 'A janela “Novo atalho” com as fontes internas e externas disponíveis.', source: `${LEARN}/onelake/shortcuts/create-onelake-shortcut` } },
          { h: 'Onde criar',
            items: [
              '<strong>Lakehouse, pasta Tables</strong> — só no nível superior (não em subpastas). Se o destino estiver em formato de tabela (Delta), o lakehouse reconhece a pasta como tabela automaticamente e ela aparece no ponto de extremidade SQL e no modelo semântico.',
              '<strong>Lakehouse, pasta Files</strong> — em qualquer nível, para arquivos e pastas de qualquer formato.',
              '<strong>Banco KQL (Eventhouse)</strong> — o atalho aparece na pasta Atalhos e é tratado como tabela externa, consultada com <code>external_table(\'NomeDoAtalho\')</code>.',
              'É possível criar pelo portal ou pela API REST.'
            ],
            img: { src: `${FAB_IMG}/m02/atalho-simbolo-pasta.png`, alt: 'Pastas de atalho com símbolo de link', caption: 'Atalhos aparecem como pastas com um símbolo de link no explorador do lakehouse.', source: `${LEARN}/onelake/shortcuts/create-onelake-shortcut` } },
          { h: 'Quem consegue usar um atalho',
            p: 'Qualquer mecanismo que lê o OneLake: Spark (<code>spark.read.format("delta").load("Tables/MeuAtalho")</code>), o ponto de extremidade SQL do lakehouse, o KQL, o Power BI em Direct Lake e até aplicativos externos pela API do OneLake.',
            img: { src: `${FAB_IMG}/m02/atalho-banco-kql.png`, alt: 'Atalhos em um banco de dados KQL', caption: 'Atalhos em um banco KQL aparecem como tabelas externas.', source: `${LEARN}/onelake/onelake-shortcuts` } },
          { h: 'Permissões e autenticação',
            items: [
              'Para <strong>criar</strong> um atalho: permissão de gravação no item onde ele é criado + acesso de leitura ao destino.',
              'Para <strong>acessar</strong>: vale a permissão <strong>mais restritiva</strong> entre o caminho do atalho e o caminho de destino.',
              '<strong>Autenticação de passagem (pass-through)</strong> — o atalho usa a identidade de quem está consultando; cada usuário só vê o que pode ver no destino. É o padrão dos atalhos OneLake no mesmo tenant.',
              '<strong>Autenticação delegada</strong> — o atalho usa uma credencial intermediária (conexão com entidade de serviço, chave, identidade fixa). Atalhos externos (S3, GCS, ADLS) <strong>sempre</strong> são delegados e usam uma conexão de nuvem; atalhos OneLake entre tenants também. Em atalhos delegados, o usuário vê a interseção entre o seu acesso e o da identidade da conexão.'
            ] },
          { h: 'Exclusão, cache e limites',
            items: [
              'Excluir o atalho remove só o atalho; o destino fica intacto (não há exclusão em cascata).',
              'Mas excluir um arquivo <strong>dentro</strong> do atalho apaga o arquivo no destino, se você tiver permissão de exclusão lá.',
              'O cache de atalhos (configuração do workspace) reduz o custo de saída de dados de S3, compatível com S3, GCS e gateway.',
              'Limites: até 100.000 atalhos por item, até 10 atalhos em um mesmo caminho e no máximo 5 atalhos encadeados.',
              'A exibição de linhagem do workspace mostra as relações de atalho entre itens.'
            ],
            img: { src: `${FAB_IMG}/m02/atalho-linhagem.png`, alt: 'Exibição de linhagem com atalhos', caption: 'A exibição de linhagem do workspace mostra quais itens usam atalhos para quais.', source: `${LEARN}/onelake/onelake-shortcuts` } },
          { h: 'Como isso cai na prova',
            items: [
              '“Usar dados de outro workspace/nuvem sem copiar” → atalho.',
              'Atalho na pasta Tables só no nível superior; em Files, em qualquer nível.',
              'Externos sempre delegados (conexão); internos no mesmo tenant, pass-through por padrão.',
              'Acesso = permissão mais restritiva entre atalho e destino.',
              'Apagar o atalho não apaga os dados; apagar arquivos dentro dele, sim.'
            ] }
        ],
        recursos: [
          { t: 'Atalhos do OneLake', u: `${LEARN}/onelake/onelake-shortcuts` },
          { t: 'Criar um atalho do OneLake', u: `${LEARN}/onelake/shortcuts/create-onelake-shortcut` },
          { t: 'Segurança de atalhos do OneLake', u: `${LEARN}/onelake/onelake-shortcut-security` }
        ]
      },
      {
        id: 'fab-espelhamento', title: 'Espelhamento (mirroring)',
        desc: 'Replicar continuamente bancos externos para o OneLake, sem pipeline: os três tipos de espelhamento, as fontes suportadas, o custo e quando escolher espelhamento, atalho ou cópia.',
        objetivos: [
          'Explicar como o espelhamento de banco de dados mantém uma réplica quase em tempo real no OneLake',
          'Diferenciar espelhamento de banco de dados, de metadados e aberto',
          'Escolher entre espelhamento, atalho e pipeline de cópia'
        ],
        body: 'Levar dados de um banco operacional para análise costumava exigir pipelines de ETL agendados, com atraso e manutenção. O espelhamento faz isso de forma contínua e gerenciada: você aponta o banco de origem, escolhe as tabelas e o Fabric mantém uma réplica em tabelas Delta no OneLake, atualizada quase em tempo real. Habilidade DP-700: “Implementar espelhamento”.',
        content: [
          { h: 'Como funciona',
            p: 'O espelhamento cria no workspace um <strong>banco de dados espelhado</strong>, com um processo que replica dados e metadados para o OneLake em formato Delta/Parquet, e um <strong>ponto de extremidade de análise SQL</strong> para consultar em T-SQL. As alterações chegam de forma incremental — cada fonte tem seu jeito de detectar mudanças (no SQL Server 2025, por exemplo, pela leitura do log de transações) — e o Fabric as mescla na tabela Delta de destino. Um mecanismo de recuo reduz a frequência quando há pouca atividade, para não sobrecarregar a origem.',
            img: { src: `${FAB_IMG}/m02/espelhamento-visao-geral.svg`, alt: 'Como funciona o espelhamento de banco de dados do Fabric', caption: 'Os dados da origem são replicados continuamente para tabelas Delta no OneLake, prontas para todas as cargas do Fabric.', source: `${LEARN}/mirroring/overview` } },
          { h: 'Os três tipos de espelhamento',
            items: [
              '<strong>Espelhamento de banco de dados</strong> — replica bancos e tabelas inteiros para o OneLake.',
              '<strong>Espelhamento de metadados</strong> — sincroniza só a estrutura (catálogos, esquemas, tabelas) e usa atalhos para os dados, que ficam na origem. Exemplo: o Unity Catalog do Azure Databricks.',
              '<strong>Espelhamento aberto</strong> — qualquer aplicação ou parceiro grava os dados de alteração numa zona de chegada do banco espelhado, via APIs públicas no formato Delta, e o Fabric faz o merge.'
            ] },
          { h: 'Fontes suportadas',
            p: 'Espelhamento de banco de dados: Banco de Dados SQL do Azure, Instância Gerenciada de SQL do Azure, SQL Server, Azure Cosmos DB, Banco de Dados do Azure para PostgreSQL, Banco de Dados do Azure para MySQL (versão prévia), Snowflake, Google BigQuery, Oracle, SAP e listas do SharePoint (versão prévia). Espelhamento de metadados: Azure Databricks e catálogo Dremio (versão prévia). O banco de dados SQL no Fabric é espelhado automaticamente.' },
          { h: 'Custo',
            items: [
              'A computação que replica os dados para o OneLake é gratuita e não consome a capacidade.',
              'Armazenamento das réplicas gratuito até <strong>1 TB por CU</strong> da capacidade (uma F64 dá direito a 64 TB).',
              'Consultar os dados espelhados (SQL, Spark, Power BI) consome capacidade normalmente.',
              'O espelhamento executa VACUUM automaticamente; a retenção padrão para bancos espelhados novos é de 1 dia e pode ser ajustada.'
            ] },
          { h: 'Depois de espelhado',
            items: [
              'Consultas entre bancos em T-SQL com nomes de três partes, juntando banco espelhado, warehouse e ponto de extremidade SQL de lakehouse.',
              'Modelos semânticos em Direct Lake sobre as tabelas espelhadas.',
              'Compartilhar o banco espelhado com alguém sem dar acesso ao workspace inteiro.'
            ] },
          { h: 'Espelhamento, atalho ou cópia?',
            items: [
              '<strong>Atalho</strong> — os dados já estão num armazenamento de arquivos/tabelas (ADLS, S3, outro lakehouse) e você quer ler sem copiar.',
              '<strong>Espelhamento</strong> — a origem é um <strong>banco de dados</strong> operacional e você quer uma réplica contínua, quase em tempo real, sem construir pipeline.',
              '<strong>Pipeline de cópia / Dataflow</strong> — você precisa transformar durante a carga, agendar em janelas específicas ou a fonte não é suportada pelo espelhamento.'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              '“Banco operacional + dados atualizados continuamente + sem ETL” → espelhamento.',
              'Espelhamento de metadados usa atalhos (dados ficam na origem).',
              'Replicação não consome capacidade; consultas consomem.'
            ] }
        ],
        recursos: [
          { t: 'O que é o espelhamento no Fabric?', u: `${LEARN}/mirroring/overview` }
        ]
      },
      {
        id: 'fab-onelake-seguranca', title: 'Segurança do OneLake',
        desc: 'Plano de controle e plano de dados: funções de workspace, permissões de item e as funções de segurança do OneLake, com acesso por pasta, tabela, linha e coluna.',
        objetivos: [
          'Diferenciar permissões do plano de controle (workspace e item) do plano de dados (funções do OneLake)',
          'Configurar funções de segurança do OneLake e entender a quem elas se aplicam',
          'Conhecer criptografia, links privados e auditoria do OneLake'
        ],
        body: 'O DP-700 cobra “Configurar e implementar a segurança do OneLake” e o DP-600 cobra controle de acesso até o nível de arquivo. O ponto central: a segurança do OneLake é definida uma vez, perto dos dados, e vale para todos os mecanismos — Spark, SQL, Power BI —, sem manter permissões separadas em cada um.',
        content: [
          { h: 'Dois planos de segurança',
            items: [
              '<strong>Plano de controle</strong> — o que você pode fazer com o item: criar, configurar, compartilhar, gerenciar. Definido pelas <strong>funções de workspace</strong> (Administrador, Membro, Colaborador, Visualizador) e pelas <strong>permissões de item</strong> concedidas no compartilhamento.',
              '<strong>Plano de dados</strong> — quais dados você pode ler ou gravar. Definido pelas <strong>funções de segurança do OneLake</strong>.'
            ],
            img: { src: `${FAB_IMG}/m02/seguranca-estrutura.png`, alt: 'Estrutura hierárquica do OneLake para segurança', caption: 'A segurança acompanha a hierarquia do OneLake: workspace, item, pastas e tabelas.', source: `${LEARN}/onelake/security/get-started-security` } },
          { h: 'Funções de segurança do OneLake',
            p: 'Usuários com função Administrador ou Membro no workspace criam funções de segurança do OneLake. Cada função tem quatro componentes:',
            items: [
              '<strong>Permissões</strong> — Leitura (Read) ou Leitura e gravação (ReadWrite).',
              '<strong>Tipo</strong> — apenas Concessão (Grant): as funções dão acesso, não negam.',
              '<strong>Dados</strong> — tabelas, pastas ou esquemas, com opção de segurança em nível de linha (RLS) e de coluna (CLS) nas tabelas.',
              '<strong>Membros</strong> — usuários, grupos ou identidades não humanas do Microsoft Entra.'
            ] },
          { h: 'A quem as funções se aplicam',
            items: [
              'As funções do OneLake controlam o acesso de quem tem função <strong>Visualizador</strong> no workspace ou apenas permissão de leitura no item.',
              'Administrador, Membro e Colaborador já têm leitura e gravação em todos os dados do workspace — as funções do OneLake não os restringem.',
              'Por padrão existe a função <strong>DefaultReader</strong>, que dá leitura aos visualizadores; para restringir, você ajusta ou remove essa função e cria funções específicas.',
              'Funções com ReadWrite não podem ter RLS nem CLS.'
            ] },
          { h: 'Atalhos e segurança',
            p: 'Não se define função de segurança diretamente num atalho OneLake → OneLake: as permissões da pasta que contém o atalho se combinam com as do destino. Em atalhos delegados, vale a interseção entre o acesso do usuário e o da identidade de conexão.' },
          { h: 'Criptografia, rede e auditoria',
            items: [
              'Dados criptografados em repouso por padrão com chaves gerenciadas pela Microsoft; opção de chaves gerenciadas pelo cliente por workspace.',
              'Dados em trânsito sempre com TLS 1.2 ou superior (negocia TLS 1.3 quando possível).',
              'Links privados restringem o acesso de rede ao Fabric.',
              'Auditoria: o diagnóstico do OneLake registra o acesso a dados pelas APIs; mudanças de funções, atalhos e compartilhamento aparecem no log de auditoria do Fabric.',
              'Entidades de serviço só acessam o OneLake se o administrador habilitar o uso de SPNs no tenant.'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              'Restringir um visualizador a certas tabelas/linhas/colunas → função de segurança do OneLake.',
              'Colaborador ou superior não é limitado por funções do OneLake.',
              'Funções só concedem (Grant); ReadWrite não combina com RLS/CLS.'
            ] }
        ],
        recursos: [
          { t: 'Segurança de dados no OneLake', u: `${LEARN}/onelake/security/get-started-security` },
          { t: 'Como a segurança do OneLake controla o acesso aos dados', u: `${LEARN}/onelake/security/data-access-control-model` }
        ]
      },
      {
        id: 'fab-onelake-integracoes', title: 'Integração do OneLake com Eventhouse e modelos semânticos',
        desc: 'Disponibilidade do OneLake para bancos KQL e integração do OneLake para modelos semânticos de importação: como expor esses dados em Delta para os outros mecanismos.',
        objetivos: [
          'Habilitar a disponibilidade do OneLake em um banco ou tabela KQL',
          'Habilitar a integração do OneLake em um modelo semântico de importação',
          'Consumir esses dados em Delta por atalhos, SQL e notebooks'
        ],
        body: 'Eventhouses e modelos semânticos de importação guardam dados em formatos próprios, otimizados para os seus mecanismos (KQL e VertiPaq). A habilidade DP-600 “Implementar a integração do OneLake para Eventhouse e modelos semânticos” trata de como publicar uma cópia lógica desses dados em Delta no OneLake, para que Spark, SQL e outros usem os mesmos dados.',
        content: [
          { h: 'Disponibilidade do OneLake no Eventhouse',
            p: 'Ao ativar a disponibilidade do OneLake em um <strong>banco KQL</strong> ou em uma <strong>tabela</strong>, o Eventhouse grava uma cópia lógica dos dados em formato Delta no OneLake. Ativado no banco, vale para as tabelas novas (e você pode estender às existentes). Com a sincronização de esquema ligada, a opção de ponto de extremidade de análise SQL fica disponível, e os dados podem ser lidos quase em tempo real por notebooks e SQL.',
            img: { src: `${FAB_IMG}/m02/eventhouse-habilitar-onelake.png`, alt: 'Janela para habilitar a disponibilidade do OneLake', caption: 'Ativando a disponibilidade do OneLake em um banco KQL.', source: `${LEARN}/real-time-intelligence/event-house-onelake-availability` } },
          { h: 'Detalhes que caem na prova (Eventhouse)',
            items: [
              'O Eventhouse agrupa dados em arquivos Parquet de tamanho ideal e pode <strong>atrasar a gravação</strong> no OneLake quando chega pouco dado — isso evita arquivos pequenos demais.',
              'Ao ativar, uma <strong>política de espelhamento</strong> é criada; ela permite acompanhar a latência e particionar as tabelas Delta. Ao desativar, a política fica com <code>IsEnabled=false</code>.',
              'Requer workspace em capacidade Fabric e permissão de edição no banco KQL.'
            ] },
          { h: 'Integração do OneLake para modelos semânticos',
            p: 'Em modelos semânticos de <strong>importação</strong>, a integração do OneLake grava automaticamente os dados importados em tabelas Delta no OneLake. Assim, cientistas e engenheiros de dados usam exatamente os mesmos dados que alimentam os relatórios.',
            img: { src: `${FAB_IMG}/m02/modelo-semantico-integracao.png`, alt: 'Integração do OneLake para modelos semânticos', caption: 'Os dados importados pelo modelo semântico são gravados também em Delta no OneLake.', source: `${LEARN}/enterprise/powerbi/onelake-integration-overview` } },
          { h: 'Como habilitar e usar',
            items: [
              'Suportado apenas em capacidades <strong>F</strong> e <strong>Premium P</strong> — não em Pro, PPU ou Embedded A/EM.',
              'Nas configurações do modelo semântico, expanda Integração do OneLake e ative.',
              'Os dados só são gravados após pelo menos uma <strong>atualização</strong> (manual ou agendada) do modelo.',
              'Com XMLA leitura/gravação, a exportação também pode ser feita por TMSL/TOM (ex.: no SSMS).',
              'No lakehouse, crie atalhos na pasta Tables apontando para as tabelas exportadas.',
              'Se o modelo tiver RLS/OLS, só quem tem acesso de gravação (Administrador, Membro, Colaborador) lê os dados exportados.'
            ],
            img: { src: `${FAB_IMG}/m02/modelo-semantico-habilitar.png`, alt: 'Habilitando a integração do OneLake nas configurações do modelo', caption: 'Ativando a integração do OneLake nas configurações do modelo semântico.', source: `${LEARN}/enterprise/powerbi/onelake-integration-overview` } },
          { h: 'Consumindo pelo lakehouse',
            img: { src: `${FAB_IMG}/m02/modelo-semantico-atalhos.png`, alt: 'Atalhos para as tabelas exportadas do modelo no explorador do lakehouse', caption: 'Atalhos no lakehouse apontando para as tabelas Delta exportadas pelo modelo semântico.', source: `${LEARN}/enterprise/powerbi/onelake-integration-overview` } },
          { h: 'Como isso cai na prova',
            items: [
              'Deixar dados de um banco KQL disponíveis para Spark/SQL → disponibilidade do OneLake (banco ou tabela).',
              'Reusar os dados de um modelo de importação fora do Power BI → integração do OneLake (só F/P, exige refresh).',
              'Consumo típico: atalho no lakehouse para a pasta exportada.'
            ] }
        ],
        recursos: [
          { t: 'Disponibilidade do OneLake para um eventhouse', u: `${LEARN}/real-time-intelligence/event-house-onelake-availability` },
          { t: 'Integração do OneLake para modelos semânticos', u: `${LEARN}/enterprise/powerbi/onelake-integration-overview` }
        ]
      }
    ]
  },
  {
    id: 'fab-m03', title: 'Módulo 03 · Lakehouse, arquitetura medalhão e modelagem dimensional', kind: 'video',
    lessons: [
      {
        id: 'fab-lakehouse', title: 'O lakehouse: criação, estrutura e esquemas',
        desc: 'O que é o lakehouse do Fabric, o que é criado junto com ele, como as pastas Tables e Files funcionam, como os esquemas organizam as tabelas e quando preferir lakehouse ou warehouse.',
        objetivos: [
          'Criar um lakehouse e reconhecer os itens que o acompanham',
          'Organizar tabelas em esquemas e referenciá-las com o nome de quatro partes',
          'Comparar lakehouse e warehouse por ferramenta, tipo de dado e transações'
        ],
        body: 'O lakehouse junta o melhor de dois mundos: a escala e a flexibilidade de um data lake (guardar qualquer arquivo) com a capacidade de consulta de um data warehouse (tabelas prontas para SQL). No Fabric ele é o ponto de partida da maioria das soluções de engenharia de dados e a peça central da arquitetura medalhão.',
        content: [
          { h: 'Criando um lakehouse',
            p: 'Para criar um lakehouse você precisa de um workspace numa capacidade Fabric (paga ou de avaliação) e da função Colaborador ou superior. Junto com ele, o Fabric cria automaticamente o <strong>ponto de extremidade de análise SQL</strong>, que permite consultar as tabelas em T-SQL. <strong>Atenção a uma mudança recente:</strong> desde 5 de setembro de 2025, o modelo semântico padrão do Power BI <strong>não é mais criado automaticamente</strong> junto com lakehouses, warehouses e itens espelhados — o modelo semântico é criado quando você precisa dele. Excluir um lakehouse apaga seus dados e o ponto de extremidade SQL associado.',
            img: { src: `${FAB_IMG}/m03/lakehouse-novo-esquemas.png`, alt: 'Diálogo de novo lakehouse com a opção de esquemas', caption: 'Criação de um lakehouse — a opção de esquemas vem marcada por padrão no portal.', source: `${LEARN}/data-engineering/lakehouse-schemas` } },
          { h: 'Tables e Files',
            p: 'Como vimos no módulo anterior, <strong>Tables</strong> guarda tabelas Delta gerenciadas e <strong>Files</strong> guarda arquivos de qualquer formato. Quando uma tabela Delta aparece em Tables, o Fabric a descobre e registra automaticamente — sem configuração manual — e ela passa a aparecer no ponto de extremidade SQL.' },
          { h: 'Esquemas no lakehouse',
            items: [
              'Esquemas agrupam tabelas em coleções com nome, como <code>vendas</code>, <code>marketing</code> ou <code>rh</code>. Tabelas sem esquema explícito vão para o esquema padrão <code>dbo</code>.',
              'Vêm habilitados por padrão ao criar pelo portal; ao criar pela API REST, é preciso informar <code>"enableSchemas": true</code>.',
              'No Spark, grave em um esquema com <code>saveAsTable("marketing.produtos")</code>.',
              'Referência completa com <strong>nome de quatro partes</strong>: <code>workspace.lakehouse.esquema.tabela</code> — o que permite consultas Spark SQL que juntam tabelas de workspaces diferentes.',
              'O <strong>atalho de esquema</strong> cria um esquema inteiro apontando para as tabelas Delta de outro lakehouse ou de um ADLS Gen2.'
            ],
            img: { src: `${FAB_IMG}/m03/atalho-de-esquema.png`, alt: 'Criando um atalho de esquema no lakehouse', caption: 'Atalho de esquema: traz várias tabelas de outro local de uma só vez.', source: `${LEARN}/data-engineering/lakehouse-schemas` } },
          { h: 'Analisar com o mecanismo de sua preferência',
            p: 'O menu <strong>Analisar dados com</strong> abre os dados do lakehouse direto no ponto de extremidade SQL, em um notebook ou em outras experiências — o mesmo dado, sem cópia.',
            img: { src: `${FAB_IMG}/m03/lakehouse-analisar-dados.png`, alt: 'Menu Analisar dados com no lakehouse', caption: 'O menu “Analisar dados com” abre o lakehouse em diferentes mecanismos.', source: `${LEARN}/data-engineering/lakehouse-overview` } },
          { h: 'Lakehouse ou warehouse?',
            items: [
              '<strong>Ferramenta principal:</strong> lakehouse → Apache Spark (Python, Scala, SQL, R); warehouse → T-SQL.',
              '<strong>Tipos de dados:</strong> lakehouse → estruturados e não estruturados; warehouse → estruturados.',
              '<strong>Transações em várias tabelas:</strong> lakehouse → não; warehouse → sim.',
              '<strong>Ingestão:</strong> lakehouse → notebooks, pipelines, dataflows, atalhos; warehouse → T-SQL (COPY INTO, INSERT, CTAS) e pipelines.',
              '<strong>Melhor para:</strong> lakehouse → engenharia e ciência de dados, arquitetura medalhão; warehouse → BI, modelagem dimensional, equipes de SQL.',
              'Os dois usam o mesmo mecanismo SQL, guardam em Delta no OneLake e podem ser combinados no mesmo workspace.'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              'Transações que atualizam várias tabelas juntas → warehouse (o lakehouse não tem transação multitabela).',
              'Não conte com modelo semântico padrão criado automaticamente (mudança de 2025).',
              'Nome de quatro partes e esquemas para consultas entre workspaces no Spark.'
            ] }
        ],
        recursos: [
          { t: 'O que é um lakehouse no Microsoft Fabric?', u: `${LEARN}/data-engineering/lakehouse-overview` },
          { t: 'Esquemas do lakehouse', u: `${LEARN}/data-engineering/lakehouse-schemas` },
          { t: 'Modelos semânticos do Power BI no Fabric (fim do modelo padrão)', u: `${LEARN}/data-warehouse/semantic-models` }
        ]
      },
      {
        id: 'fab-carregar-lakehouse', title: 'Formas de carregar dados no lakehouse',
        desc: 'Upload, atalho, Dataflow Gen2, pipeline, notebook e Eventstream: o que cada caminho faz de melhor e como escolher.',
        objetivos: [
          'Conhecer as seis formas de levar dados a um lakehouse',
          'Escolher o caminho pelo volume, pela necessidade de transformação e pela latência',
          'Evitar a armadilha das tabelas externas criadas em Spark'
        ],
        body: 'A habilidade DP-600 “Ingerir ou acessar dados conforme necessário” e a DP-700 “Escolher entre Dataflow Gen2, pipeline e notebook” começam aqui. Os próximos módulos detalham cada ferramenta; esta aula dá o mapa para você saber qual usar.',
        content: [
          { h: 'Os seis caminhos, do mais simples ao mais programático',
            items: [
              '<strong>Upload de arquivos</strong> — pelo explorador do lakehouse, para arquivos pequenos sem transformação.',
              '<strong>Atalhos</strong> — referenciam dados de outro lakehouse, ADLS, S3 etc. sem copiar.',
              '<strong>Dataflow Gen2</strong> — transformação de baixo código no Power Query, com mais de 200 conectores, gravando em tabela do lakehouse.',
              '<strong>Pipeline (atividade Copiar)</strong> — cópia escalável de grandes volumes, no formato original ou convertendo para tabela.',
              '<strong>Notebook</strong> — controle total com Spark: conectar, transformar e gravar via código.',
              '<strong>Eventstream</strong> — eventos em tempo real encaminhados diretamente para tabelas Delta do lakehouse.'
            ],
            img: { src: `${FAB_IMG}/m03/upload-arquivos.png`, alt: 'Diálogo de upload de arquivos no explorador do lakehouse', caption: 'O caminho mais simples: upload de arquivos direto no explorador do lakehouse.', source: `${LEARN}/data-engineering/load-data-lakehouse` } },
          { h: 'Como escolher',
            items: [
              'Só quer usar dados que já existem em outro armazenamento → atalho.',
              'Grande volume, pouca ou nenhuma transformação → pipeline com atividade Copiar.',
              'Transformação visual, equipe de Power Query → Dataflow Gen2.',
              'Transformação complexa, grandes volumes, equipe que programa → notebook Spark.',
              'Dados contínuos em tempo real → Eventstream.'
            ] },
          { h: 'A armadilha das tabelas externas',
            p: 'Tabelas Delta <strong>externas</strong> criadas por código Spark (apontando para um caminho fora da área gerenciada) <strong>não aparecem</strong> no ponto de extremidade de análise SQL. Para torná-las visíveis ao SQL, crie um atalho na pasta Tables apontando para elas.' },
          { h: 'Como isso cai na prova',
            items: [
              'Cenários do tipo “qual ferramenta usar” combinando volume, transformação e habilidade da equipe.',
              'Tabela criada no Spark não aparece no SQL → verifique se é externa; solução: atalho em Tables.'
            ] }
        ],
        recursos: [
          { t: 'Opções de ingestão de dados para um lakehouse', u: `${LEARN}/data-engineering/load-data-lakehouse` }
        ]
      },
      {
        id: 'fab-endpoint-sql', title: 'O ponto de extremidade de análise SQL',
        desc: 'A camada T-SQL somente leitura sobre as tabelas do lakehouse: o que dá para fazer, como a segurança funciona e como os metadados se mantêm sincronizados.',
        objetivos: [
          'Consultar tabelas do lakehouse em T-SQL pelo ponto de extremidade SQL',
          'Criar views, funções e procedimentos e aplicar segurança por linha e objeto',
          'Entender os limites: somente leitura e segurança válida só pelo endpoint'
        ],
        body: 'Engenheiros transformam os dados no lakehouse com Spark; analistas e ferramentas de BI preferem SQL. O ponto de extremidade de análise SQL é a ponte: provisionado automaticamente com cada lakehouse, ele expõe as tabelas Delta para consulta em T-SQL usando o mesmo mecanismo do Fabric Data Warehouse.',
        content: [
          { h: 'O que você pode fazer',
            items: [
              'Consultar com <code>SELECT</code> qualquer tabela Delta do lakehouse, inclusive as expostas por atalhos para ADLS ou S3.',
              'Criar <strong>views, funções e procedimentos armazenados</strong> para encapsular lógica de negócio.',
              'Aplicar <strong>segurança em nível de linha e de objeto</strong> com permissões SQL.',
              'Servir de fonte para modelos semânticos do Power BI.',
              'Consultar entre workspaces usando atalhos para tabelas de outros lakehouses e warehouses.'
            ],
            img: { src: `${FAB_IMG}/m03/endpoint-sql.png`, alt: 'Editor de consultas do ponto de extremidade de análise SQL', caption: 'O ponto de extremidade de análise SQL do lakehouse, com o editor de consultas.', source: `${LEARN}/data-engineering/lakehouse-sql-analytics-endpoint` } },
          { h: 'O que você não pode fazer',
            p: 'O ponto de extremidade é <strong>somente leitura para os dados</strong>: nada de <code>INSERT</code>, <code>UPDATE</code> ou <code>DELETE</code> nas tabelas. Para modificar dados, use Spark no lakehouse — ou use um warehouse, se a equipe precisa escrever em T-SQL.' },
          { h: 'Segurança: atenção ao escopo',
            p: 'Regras de segurança SQL definidas no ponto de extremidade (RLS, permissões por tabela ou coluna) valem <strong>apenas para quem acessa pelo ponto de extremidade</strong>. Quem lê os mesmos dados por Spark ou por outras ferramentas não é filtrado por elas. Para uma proteção que valha em todos os mecanismos, use as funções de segurança do OneLake (Módulo 2) e restrinja o acesso ao workspace.' },
          { h: 'Sincronização de metadados',
            p: 'Ao criar ou alterar uma tabela Delta no lakehouse, o ponto de extremidade detecta a mudança e atualiza definições, tipos e estatísticas automaticamente — não há etapa de importação. Só tabelas em formato Delta são descobertas. Warehouses, bancos espelhados, bancos SQL no Fabric e o Cosmos DB também têm seu próprio ponto de extremidade de análise SQL.' },
          { h: 'Como isso cai na prova',
            items: [
              '“Analistas precisam de T-SQL sobre o lakehouse, sem escrever” → ponto de extremidade SQL.',
              '“Precisam de INSERT/UPDATE em T-SQL” → warehouse, não o ponto de extremidade.',
              'RLS no endpoint não protege acesso via Spark.'
            ] }
        ],
        recursos: [
          { t: 'Ponto de extremidade de análise SQL do lakehouse', u: `${LEARN}/data-engineering/lakehouse-sql-analytics-endpoint` }
        ]
      },
      {
        id: 'fab-medalhao', title: 'Arquitetura medalhão: bronze, prata e ouro',
        desc: 'O padrão de design recomendado para o Fabric: três camadas de qualidade crescente, como implantá-las e as boas práticas de armazenamento em cada uma.',
        objetivos: [
          'Descrever o papel de cada camada: bronze, prata e ouro',
          'Escolher entre “três lakehouses” e “ouro em warehouse”',
          'Aplicar boas práticas de tamanho de arquivo, retenção e particionamento'
        ],
        body: 'A arquitetura medalhão organiza os dados em três etapas, e cada uma aumenta a qualidade e a confiabilidade. É a abordagem de design recomendada pela Microsoft para o Fabric e aparece em muitas questões de cenário das provas.',
        content: [
          { h: 'As três camadas',
            items: [
              '<strong>Bronze (bruto)</strong> — tudo exatamente como chegou da origem, sem alteração. Serve de histórico e permite reprocessar.',
              '<strong>Prata (enriquecido)</strong> — dados corrigidos, padronizados, sem duplicatas, com tipos certos e validações aplicadas.',
              '<strong>Ouro (curado)</strong> — dados organizados para consumo: modelos dimensionais (esquema estrela), agregações e tabelas prontas para relatórios.'
            ],
            img: { src: `${FAB_IMG}/m03/medalhao.png`, alt: 'Arquitetura medalhão no OneLake', caption: 'Fontes → bronze → prata → ouro → consumo, tudo sobre o OneLake.', source: `${LEARN}/onelake/onelake-medallion-lakehouse-architecture` } },
          { h: 'Exemplo: um e-commerce',
            items: [
              'Bronze: pedidos do site em JSON, cadastro de clientes em CSV, cliques do site — tudo como chegou.',
              'Prata: pedidos com datas no mesmo formato, clientes deduplicados, valores inválidos tratados.',
              'Ouro: fato de vendas e dimensões de cliente, produto e data, prontos para o Power BI.'
            ] },
          { h: 'Como implantar',
            items: [
              '<strong>Padrão 1</strong> — cada camada é um lakehouse; os usuários de negócio consomem a camada ouro pelo ponto de extremidade SQL.',
              '<strong>Padrão 2</strong> — bronze e prata em lakehouses, ouro em um <strong>warehouse</strong>; o consumo é pelo warehouse (útil quando a camada ouro precisa de T-SQL com escrita e transações).',
              'Recomendação: colocar <strong>cada camada em um workspace próprio</strong>, para ter mais controle e governança por camada.',
              '<strong>Visões materializadas de lago</strong> permitem definir as transformações entre camadas de forma declarativa, em SQL, em vez de montar pipelines manuais.'
            ] },
          { h: 'Boas práticas de armazenamento',
            items: [
              '<strong>Tamanho de arquivo</strong> — poucos arquivos grandes são melhores que muitos pequenos; na bronze arquivos menores são aceitáveis, nas camadas de consumo busque arquivos maiores.',
              '<strong>Retenção</strong> — o Delta guarda o histórico de alterações; use VACUUM para remover versões antigas (por padrão não se remove histórico dos últimos 7 dias).',
              '<strong>Particionamento</strong> — organize em pastas particionadas quando fizer sentido (ex.: por data) para acelerar consultas e manutenção.',
              '<strong>Atualização</strong> — normalmente anexar dados novos; quando for preciso atualizar registros existentes, use MERGE (upsert).'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              'Identificar a camada pelo estado do dado: bruto → bronze; limpo → prata; modelado para BI → ouro.',
              'Camada ouro em warehouse quando o consumo exige T-SQL com escrita/transações.',
              'Workspace separado por camada para governança.'
            ] }
        ],
        recursos: [
          { t: 'Arquitetura medalhão com o OneLake', u: `${LEARN}/onelake/onelake-medallion-lakehouse-architecture` }
        ]
      },
      {
        id: 'fab-modelo-dimensional', title: 'Modelagem dimensional: fatos, dimensões e SCD',
        desc: 'O esquema estrela na camada ouro: tabelas de fato e de dimensão, chaves substitutas, hierarquias, membros especiais, dimensões conformes e com papéis, e as dimensões de alteração lenta (SCD).',
        objetivos: [
          'Projetar um esquema estrela com fatos e dimensões',
          'Usar chaves substitutas, membros especiais e dimensões conformes e com papéis',
          'Escolher o tipo de SCD (1, 2 ou 3) para cada atributo'
        ],
        body: 'A prova DP-600 pede “implementar um esquema estrela para um lakehouse ou warehouse” e “desnormalizar dados”; a DP-700 pede “preparar dados para carregar em um modelo dimensional”. Os conceitos desta aula valem para lakehouse, warehouse e para o modelo semântico do Power BI.',
        content: [
          { h: 'Esquema estrela',
            p: 'No centro fica a <strong>tabela de fatos</strong>, com os eventos medidos (vendas, pedidos, estoques) e suas métricas numéricas. Em volta ficam as <strong>tabelas de dimensão</strong>, que descrevem o contexto: quem, o quê, onde, quando. Uma dica para descobrir dimensões: preste atenção na palavra “por” — “vendas por região, por produto, por mês”.',
            img: { src: `${FAB_IMG}/m03/esquema-estrela.svg`, alt: 'Esquema estrela para dados de vendas', caption: 'Esquema estrela: a tabela de fatos no centro e as dimensões ao redor.', source: `${LEARN}/data-warehouse/dimensional-modeling-overview` } },
          { h: 'As colunas de uma dimensão',
            items: [
              '<strong>Chave substituta (surrogate key)</strong> — inteiro gerado no data warehouse, usado nas relações com os fatos. Isola o modelo de mudanças na origem e permite o histórico de SCD tipo 2.',
              '<strong>Chave natural</strong> — o identificador vindo do sistema de origem (ex.: matrícula do funcionário), usado pelo ETL para casar os registros.',
              '<strong>Atributos</strong> — as colunas descritivas usadas para filtrar e agrupar.',
              '<strong>Atributos de controle histórico e de auditoria</strong> — quando e como a linha foi criada ou alterada.',
              'O Fabric Warehouse aceita chaves estrangeiras, mas <strong>não as impõe</strong> — o ETL precisa testar a integridade.'
            ] },
          { h: 'Desnormalizar as dimensões',
            p: 'Dimensões quase sempre devem ser <strong>desnormalizadas</strong>: produto, subcategoria e categoria numa tabela só. O custo de repetir texto é pequeno e a consulta fica mais simples e rápida. A exceção é a dimensão em <strong>floco de neve</strong> (snowflake), normalizada em várias tabelas — em geral evitada em modelos de BI.',
            img: { src: `${FAB_IMG}/m03/dimensao-floco-de-neve.svg`, alt: 'Dimensão em floco de neve', caption: 'Dimensão floco de neve: Produto, Subcategoria e Categoria em tabelas separadas — normalmente preferimos juntá-las.', source: `${LEARN}/data-warehouse/dimensional-modeling-dimension-tables` } },
          { h: 'Hierarquias e membros especiais',
            items: [
              '<strong>Hierarquia equilibrada</strong> — mesmo número de níveis (ano → trimestre → mês).',
              '<strong>Desbalanceada (pai-filho)</strong> — níveis variáveis, como funcionário → gerente.',
              '<strong>Irregular (ragged)</strong> — falta um nível para alguns membros (país sem estados); repete-se o valor do pai.',
              '<strong>Membros especiais</strong> — linhas para “Desconhecido”, “N/D” ou erro, usadas quando o fato chega sem a dimensão correspondente.'
            ] },
          { h: 'Tipos de dimensão que caem na prova',
            items: [
              '<strong>Data</strong> — uma linha por dia; chave no formato AAAAMMDD; não misture hora do dia (use uma dimensão de tempo separada).',
              '<strong>Conforme</strong> — compartilhada por várias tabelas de fatos (Data e Produto usadas por Vendas e Estoque).',
              '<strong>Com vários papéis (role-playing)</strong> — a mesma dimensão usada várias vezes pelo fato: data do pedido, de envio, de entrega.',
              '<strong>Lixo (junk)</strong> — junta vários sinalizadores de baixa cardinalidade (status, flags) numa só dimensão.',
              '<strong>Degenerada</strong> — atributo na granularidade do fato, como o número do pedido, guardado na própria tabela de fatos.'
            ],
            img: { src: `${FAB_IMG}/m03/dimensao-com-papeis.svg`, alt: 'Dimensão com vários papéis', caption: 'Uma única dimensão de data exercendo vários papéis em relação à tabela de fatos.', source: `${LEARN}/data-warehouse/dimensional-modeling-dimension-tables` } },
          { h: 'Dimensões de alteração lenta (SCD)',
            items: [
              '<strong>Tipo 1</strong> — sobrescreve o valor; não guarda histórico. Usado para a maioria dos atributos e para correções.',
              '<strong>Tipo 2</strong> — insere uma nova versão da linha, com validade (início e fim) e um indicador de versão atual (ex.: <code>RecIsCurrent</code>). Preserva o histórico: as vendas antigas continuam ligadas à região antiga.',
              '<strong>Tipo 3</strong> — guarda um histórico limitado em colunas (valor atual e anterior). Pouco usado, difícil de usar no modelo semântico.',
              'Uma mesma dimensão pode combinar atributos tipo 1 e tipo 2.'
            ],
            img: { src: `${FAB_IMG}/m03/scd-tipo-2.svg`, alt: 'SCD tipo 2', caption: 'SCD tipo 2: a versão antiga é encerrada e uma nova linha passa a ser a atual.', source: `${LEARN}/data-warehouse/dimensional-modeling-dimension-tables` } },
          { h: 'Como isso cai na prova',
            items: [
              '“Manter o histórico quando o vendedor muda de região” → SCD tipo 2.',
              '“Corrigir um erro de digitação” → SCD tipo 1.',
              'Várias datas no mesmo fato → dimensão com vários papéis.',
              'Chaves estrangeiras não são impostas no Fabric Warehouse.'
            ] }
        ],
        recursos: [
          { t: 'Modelagem dimensional: visão geral', u: `${LEARN}/data-warehouse/dimensional-modeling-overview` },
          { t: 'Modelagem dimensional: tabelas de dimensão', u: `${LEARN}/data-warehouse/dimensional-modeling-dimension-tables` },
          { t: 'Modelagem dimensional: tabelas de fatos', u: `${LEARN}/data-warehouse/dimensional-modeling-fact-tables` }
        ]
      },
      {
        id: 'fab-carga-dimensional', title: 'Preparar e carregar um modelo dimensional',
        desc: 'O processo de ETL que alimenta a camada ouro: preparo, transformação, carga e log; como processar dimensões (incluindo SCD) e fatos (busca de chaves, membro desconhecido, membros inferidos, carga incremental).',
        objetivos: [
          'Descrever as etapas de um processo de carga dimensional',
          'Processar dimensões sem quebrar as chaves substitutas',
          'Processar fatos incrementalmente, tratando chaves ausentes'
        ],
        body: 'Modelar é metade do trabalho; a outra metade é carregar o modelo todo dia sem corromper o histórico. A habilidade DP-700 “Preparar dados para carregar em um modelo dimensional” e a DP-600 “Implementar um esquema estrela” cobram exatamente essa lógica.',
        content: [
          { h: 'As etapas do processo',
            items: [
              '<strong>Preparo (staging)</strong> — extrair da origem para tabelas de preparo, reduzindo o impacto nos sistemas operacionais.',
              '<strong>Transformação</strong> — remodelar os dados para a estrutura das dimensões e fatos, com limpeza e padronização.',
              '<strong>Carga</strong> — primeiro as dimensões, depois os fatos (os fatos precisam das chaves das dimensões).',
              '<strong>Log</strong> — registrar início, fim, linhas processadas e erros de cada execução em tabelas próprias.'
            ],
            img: { src: `${FAB_IMG}/m03/etl-etapas.svg`, alt: 'Etapas do processo de ETL', caption: 'As etapas de um processo de carga de modelo dimensional.', source: `${LEARN}/data-warehouse/dimensional-modeling-load-tables` } },
          { h: 'Processar dimensões',
            items: [
              'Use chave substituta inteira, a menor possível. No Fabric Warehouse, colunas <code>IDENTITY</code> estão disponíveis (com algumas limitações).',
              'Com chaves geradas automaticamente, <strong>nunca</strong> faça truncar-e-recarregar da dimensão: as chaves mudariam e os fatos já carregados ficariam apontando para as linhas erradas.',
              'Linhas novas são inseridas; alterações seguem o tipo de SCD — tipo 1 atualiza, tipo 2 encerra a versão atual (data fim e indicador de atual = falso) e insere a nova.',
              'Não sincronize exclusões da origem apagando a linha da dimensão — prefira marcar o membro como excluído, porque fatos antigos ainda o referenciam.'
            ],
            img: { src: `${FAB_IMG}/m03/processar-dimensao.svg`, alt: 'Lógica de processamento de uma tabela de dimensão', caption: 'Como linhas novas e alteradas da origem são processadas numa dimensão.', source: `${LEARN}/data-warehouse/dimensional-modeling-load-tables` } },
          { h: 'Processar fatos',
            items: [
              'Para cada chave natural do fato, busca-se a chave substituta na dimensão (nas SCD tipo 2, a versão válida na data do fato). Chaves de data podem ser calculadas direto (AAAAMMDD).',
              'Se a busca falhar, <strong>insira o fato mesmo assim</strong>, apontando para o membro especial “Desconhecido”, e corrija depois com um processo periódico.',
              'Ou crie um <strong>membro inferido</strong>: uma linha de dimensão só com a chave natural, marcada como inferida; quando os atributos chegarem, atualize-a sem tratar como mudança de SCD.',
              'Prefira sempre <strong>carga incremental</strong> — detectar só os fatos novos por identificadores sequenciais, data/hora de alteração ou captura de dados de alteração (CDC) da origem. Truncar e recarregar uma tabela de fatos grande é o último recurso.',
              'Se houver atualizações ou exclusões de fatos, guarde na tabela de fatos os identificadores da origem (número e linha do pedido) para achar as linhas a modificar.'
            ],
            img: { src: `${FAB_IMG}/m03/processar-fato.svg`, alt: 'Lógica de processamento de uma tabela de fatos', caption: 'Processamento de fatos: busca de chaves de dimensão antes da inserção.', source: `${LEARN}/data-warehouse/dimensional-modeling-load-tables` } },
          { h: 'Como isso cai na prova',
            items: [
              'Ordem de carga: dimensões antes dos fatos.',
              'Fato chegou antes da dimensão → membro Desconhecido ou membro inferido (dado de chegada tardia).',
              'Carga incremental por marca d’água (ID/data) ou CDC em vez de recarga completa.'
            ] }
        ],
        recursos: [
          { t: 'Modelagem dimensional: carregar tabelas', u: `${LEARN}/data-warehouse/dimensional-modeling-load-tables` }
        ]
      },
      {
        id: 'fab-manutencao-delta', title: 'Manutenção e otimização de tabelas Delta',
        desc: 'Arquivos pequenos, OPTIMIZE, V-Order e VACUUM: como manter as tabelas do lakehouse rápidas, pelo portal, por notebook ou por pipeline.',
        objetivos: [
          'Explicar o problema dos arquivos pequenos e como o OPTIMIZE resolve',
          'Decidir quando habilitar o V-Order',
          'Executar VACUUM com segurança e agendar a manutenção'
        ],
        body: 'Tabelas Delta que recebem cargas frequentes acumulam muitos arquivos pequenos e versões antigas, e ficam lentas. A habilidade DP-700 “Otimizar uma tabela Lakehouse” cobra as ferramentas de manutenção e, principalmente, quando usar cada uma.',
        content: [
          { h: 'Por que as tabelas ficam lentas',
            p: 'Cada gravação cria novos arquivos Parquet. Muitas cargas pequenas geram milhares de arquivos pequenos, e o mecanismo gasta mais tempo abrindo arquivos e lendo metadados do que lendo dados. Além disso, alterações e exclusões deixam arquivos antigos que não fazem mais parte da versão atual.' },
          { h: 'OPTIMIZE: compactação',
            p: 'O <code>OPTIMIZE</code> junta arquivos Parquet pequenos em arquivos maiores (compactação), melhorando as leituras. Execute depois das cargas principais ou quando perceber muitos arquivos pequenos e leituras lentas.' },
          { h: 'V-Order',
            items: [
              'É uma otimização aplicada <strong>no momento da gravação</strong> dos arquivos Parquet (ordenação, codificação e compressão otimizadas) que acelera as leituras em todos os mecanismos do Fabric.',
              '<strong>Vem desativado por padrão nos workspaces novos</strong>, para favorecer cargas de engenharia com muita escrita.',
              'Custo e benefício: gravações cerca de 15% mais lentas; até 50% mais compressão e leituras bem mais rápidas.',
              'Use onde a leitura domina — camada ouro, painéis e análise interativa, Direct Lake. Na bronze, com muita escrita, costuma não compensar.',
              'Pode ser controlado na sessão Spark, nas propriedades da tabela ou na própria operação de gravação, e aplicado junto com o OPTIMIZE.'
            ] },
          { h: 'VACUUM: limpeza de arquivos antigos',
            items: [
              'Remove arquivos que o log Delta não referencia mais e que são mais antigos que o limite de retenção — <strong>7 dias por padrão</strong>.',
              'Reduzir a retenção diminui o time travel e pode afetar leitores e gravadores simultâneos; o portal e a API recusam retenção menor que 7 dias, a menos que a verificação seja desativada no ambiente Spark.'
            ] },
          { h: 'Como executar',
            items: [
              '<strong>No portal</strong> — clique com o botão direito na tabela → <strong>Manutenção</strong>: compactar (OPTIMIZE), com opção de aplicar V-Order; executar VACUUM; e limpar vetores de exclusão.',
              '<strong>Em pipeline</strong> — a atividade Manutenção do Lakehouse (versão prévia) agenda as mesmas operações e pode ser encadeada após a carga.',
              '<strong>Em notebook</strong> — com comandos Spark SQL, para manutenção orquestrada por código.',
              'As execuções aparecem no hub de Monitoramento (atividades com “TableMaintenance” no nome).'
            ],
            img: { src: `${FAB_IMG}/m03/manutencao-tabela.png`, alt: 'Diálogo de comandos de manutenção da tabela', caption: 'A janela de manutenção de tabela no lakehouse: OPTIMIZE (com V-Order opcional) e VACUUM.', source: `${LEARN}/data-engineering/lakehouse-table-maintenance` } },
          { h: 'Como isso cai na prova',
            items: [
              'Muitos arquivos pequenos e consultas lentas → OPTIMIZE.',
              'Consultas de leitura intensa (ouro, Direct Lake) → habilitar V-Order; lembrar que o padrão novo é desligado.',
              'Espaço ocupado por versões antigas → VACUUM, respeitando a retenção de 7 dias.'
            ] }
        ],
        recursos: [
          { t: 'Otimizar tabelas Delta com V-Order', u: `${LEARN}/data-engineering/delta-optimization-and-v-order` },
          { t: 'Manutenção de tabelas Delta no lakehouse', u: `${LEARN}/data-engineering/lakehouse-table-maintenance` }
        ]
      }
    ]
  },
  {
    id: 'fab-m04', title: 'Módulo 04 · Data Factory: pipelines, orquestração e cargas', kind: 'video',
    lessons: [
      {
        id: 'fab-data-factory-visao', title: 'Data Factory no Fabric: itens, conexões e gateways',
        desc: 'O que o Data Factory oferece dentro do Fabric, como criar e gerenciar conexões de dados e quando usar o gateway local ou o gateway de rede virtual.',
        objetivos: [
          'Reconhecer os itens do Data Factory e o papel de cada um',
          'Criar e gerenciar uma conexão de dados em “Gerenciar conexões e gateways”',
          'Escolher entre gateway de dados local e gateway de rede virtual (VNet)',
          'Apontar as diferenças principais em relação ao Azure Data Factory'
        ],
        body: 'O Data Factory é a carga de trabalho de integração de dados do Fabric: é com ele que você traz dados de fora para dentro do OneLake e orquestra as etapas de uma solução. Ele se conecta a mais de 170 fontes e reúne movimentação, orquestração e transformação num só lugar. Esta aula cobre a habilidade DP-600 “Criar uma conexão de dados” e prepara o terreno para o resto do módulo.',
        content: [
          { h: 'Os itens do Data Factory',
            items: [
              '<strong>Pipeline</strong> — o orquestrador: uma sequência de atividades (copiar, executar notebook, rodar procedimento, repetir, decidir) com agendas e gatilhos.',
              '<strong>Trabalho de cópia (Copy job)</strong> — movimentação de dados simplificada, de várias fontes para vários destinos, com cópia completa ou incremental e sem precisar montar pipeline.',
              '<strong>Dataflow Gen2</strong> — transformação com Power Query, sem código ou com pouco código (Módulo 05).',
              '<strong>Espelhamento</strong> — replicação contínua de bancos para o OneLake (visto no Módulo 02).',
              '<strong>Trabalho do Apache Airflow</strong> — orquestração escrita em Python, para quem já usa Airflow.',
              '<strong>Copilot para Data Factory</strong> — cria e explica pipelines e fluxos de dados por linguagem natural e ajuda a diagnosticar erros.'
            ],
            img: { src: `${FAB_IMG}/m04/pilha-integracao.png`, alt: 'Diagrama da pilha de integração de dados do Data Factory no Fabric', caption: 'Data Factory no Fabric: mais de 170 conectores, movimentação, orquestração e transformação, tudo gravando no OneLake.', source: `${LEARN}/data-factory/data-factory-overview` } },
          { h: 'ETL ou ELT',
            p: 'No <strong>ETL</strong> (extrair, transformar, carregar) você limpa e padroniza os dados no caminho, antes de gravar — por exemplo, num Dataflow Gen2. No <strong>ELT</strong> (extrair, carregar, transformar) você primeiro copia os dados brutos para o lakehouse ou warehouse e transforma depois, com Spark ou T-SQL, aproveitando a escala do destino. A arquitetura medalhão do Módulo 03 é um ELT: o dado entra bruto na bronze e é refinado nas camadas seguintes.' },
          { h: 'Conexões de dados',
            p: 'No Fabric não existem os “serviços vinculados” e “conjuntos de dados” do Azure Data Factory: a credencial e o endereço da fonte ficam num objeto <strong>conexão</strong>, guardado com segurança e reutilizado pelos itens. Você cria e administra as conexões em <strong>Configurações (engrenagem) → Gerenciar conexões e gateways</strong>, ou direto de dentro de uma atividade, pela opção de nova conexão.',
            items: [
              'Cada conexão tem um <strong>ID</strong> (GUID), visível nas configurações dela — é esse ID que você usa para parametrizar conexões em pipelines e nas APIs REST.',
              'Em <strong>Gerenciar usuários</strong> você define quem pode usar ou administrar a conexão, sem entregar a senha a ninguém.',
              'A opção “Esta conexão pode ser usada com gateways de dados locais e gateways de dados VNet” controla se a conexão de nuvem pode ser avaliada por um gateway.',
              'As conexões mostram quando foram vinculadas a um item e quando as credenciais foram usadas pela última vez — ajuda a achar conexões abandonadas antes de trocar senha ou excluir.'
            ],
            img: { src: `${FAB_IMG}/m04/gerenciar-conexoes.png`, alt: 'Menu Configurações com Gerenciar conexões e gateways destacado', caption: 'Configurações → Gerenciar conexões e gateways: o lugar central das conexões do Fabric.', source: `${LEARN}/data-factory/how-to-access-on-premises-data` } },
          { h: 'Gateway de dados local',
            p: 'Quando a fonte está dentro da rede da empresa (um SQL Server no servidor da matriz, uma pasta de rede), a nuvem não consegue alcançá-la sozinha. O <strong>gateway de dados local</strong> é um programa que você instala num computador dessa rede; ele faz a ponte segura com o Fabric. Depois de instalado, você cria a conexão escolhendo o tipo <strong>Local</strong> e informando o cluster de gateway. Para pipelines, o gateway precisa estar numa versão recente (3000.214.2 ou posterior). No Fabric, o gateway local substitui o runtime de integração auto-hospedado (SHIR) que existia no Azure Data Factory.',
            img: { src: `${FAB_IMG}/m04/nova-conexao-local.png`, alt: 'Diálogo Nova conexão com a opção Local selecionada', caption: 'Nova conexão do tipo Local: você escolhe o cluster de gateway e o tipo da fonte.', source: `${LEARN}/data-factory/how-to-access-on-premises-data` } },
          { h: 'Gateway de dados de rede virtual (VNet)',
            items: [
              'É um gateway <strong>gerenciado pela Microsoft</strong>, sem instalação em máquina: ele é injetado numa rede virtual do Azure da sua empresa.',
              'Serve para fontes do Azure protegidas por <strong>pontos de extremidade privados</strong> ou Private Link — o tráfego não passa por endpoint público.',
              'Funciona com Dataflow Gen2, pipelines, trabalho de cópia, espelhamento, modelos semânticos e relatórios paginados do Power BI.',
              'Disponível em SKUs F (recomendado F8 ou superior), P e A4 ou superior.'
            ] },
          { h: 'E se eu já uso Azure Data Factory?',
            p: 'O Data Factory do Fabric é a próxima geração do Azure Data Factory. Cerca de 90% das atividades do ADF existem no Fabric, e há novidades como as atividades do Outlook e do Teams para notificação. As diferenças que mais aparecem: conexões em vez de serviços vinculados e conjuntos de dados; gateway local em vez de SHIR; agendas e gatilhos do Activator em vez dos gatilhos do ADF; Git e pipelines de implantação por item em vez de modelos ARM; e o destino natural dos dados é o OneLake.' },
          { h: 'Como isso cai na prova',
            items: [
              'Fonte on-premises atrás do firewall → gateway de dados local + conexão do tipo Local.',
              'Fonte no Azure acessível só por ponto de extremidade privado, sem querer instalar nada → gateway de dados VNet.',
              'Precisa trocar a conexão dinamicamente num pipeline → use o ID (GUID) da conexão como parâmetro.',
              'Compartilhar acesso a uma fonte sem revelar a senha → dar permissão de uso na conexão.'
            ] }
        ],
        recursos: [
          { t: 'O que é o Data Factory no Microsoft Fabric', u: `${LEARN}/data-factory/data-factory-overview` },
          { t: 'Gerenciamento de fontes de dados (conexões)', u: `${LEARN}/data-factory/data-source-management` },
          { t: 'Acessar fontes de dados locais', u: `${LEARN}/data-factory/how-to-access-on-premises-data` },
          { t: 'Gateway de dados de rede virtual', u: 'https://learn.microsoft.com/pt-br/data-integration/vnet/overview' },
          { t: 'Diferenças entre Azure Data Factory e Fabric Data Factory', u: `${LEARN}/data-factory/compare-fabric-data-factory-and-azure-data-factory` }
        ]
      },
      {
        id: 'fab-pipeline-atividades', title: 'Pipelines: atividades, dependências e tratamento de erros',
        desc: 'Os três grupos de atividades, as configurações comuns (tempo limite, repetição), as condições de dependência entre atividades e os padrões de tratamento de erro que decidem se o pipeline termina com sucesso ou falha.',
        objetivos: [
          'Classificar as atividades em movimentação, transformação e fluxo de controle',
          'Configurar tempo limite, repetição e desativação de atividades',
          'Usar as quatro condições de dependência e prever o status final do pipeline',
          'Aplicar ForEach, Lookup, If, Invocar pipeline e variáveis em padrões de orquestração'
        ],
        body: 'Um pipeline é um conjunto de atividades ligadas por setas de dependência. Saber qual atividade usar e como elas se encadeiam é a base das habilidades DP-700 “Ingerir dados usando pipelines” e “Implementar padrões de orquestração com notebooks e pipelines”.',
        content: [
          { h: 'Os três grupos de atividades',
            items: [
              '<strong>Movimentação</strong>: Copiar dados e Trabalho de cópia.',
              '<strong>Transformação</strong>: Dataflow Gen2, Notebook, Definição de trabalho do Spark, Procedimento armazenado, Script SQL, Excluir dados, atividade KQL, entre outras.',
              '<strong>Fluxo de controle</strong>: ForEach, Se (condição), Switch, Até (Until), Espera, Pesquisa (Lookup), Obter metadados, Definir variável, Acrescentar variável, Filtro, Falha (Fail), Invocar pipeline, Web e Webhook, Teams e Outlook, e atividades do próprio Fabric como Manutenção do Lakehouse e Atualizar o ponto de extremidade de análise SQL.'
            ],
            img: { src: `${FAB_IMG}/m04/editor-atividades.png`, alt: 'Editor de pipeline com a guia Atividades', caption: 'O editor de pipeline: a guia Atividades lista tudo o que pode ser arrastado para a tela.', source: `${LEARN}/data-factory/activity-overview` } },
          { h: 'Configurações gerais de uma atividade',
            items: [
              '<strong>Tempo limite</strong>: padrão de 12 horas, máximo de 7 dias (formato dias.horas:minutos:segundos).',
              '<strong>Repetição</strong>: quantas novas tentativas fazer se a atividade falhar e o intervalo entre elas (padrão de 30 segundos) — ideal para erros transitórios, como queda de rede.',
              '<strong>Entrada segura / saída segura</strong>: escondem a entrada ou a saída da atividade nos logs de monitoramento (use quando houver senha ou dado sensível).',
              'Um pipeline aceita até <strong>120 atividades</strong>, contando as que ficam dentro de contêineres como ForEach e If.'
            ],
            img: { src: `${FAB_IMG}/m04/config-gerais.png`, alt: 'Guia Configurações gerais de uma atividade', caption: 'Guia Geral: nome, descrição, tempo limite, repetição e entrada/saída seguras.', source: `${LEARN}/data-factory/activity-overview` } },
          { h: 'Desativar uma atividade',
            p: 'Você pode desativar uma atividade (ou várias, com Ctrl + clique e botão direito) para que ela seja ignorada na validação e na execução, sem apagá-la da tela — é o “comentar código” do pipeline. Ao desativar, você escolhe como ela deve ser marcada: <strong>Com êxito, Com falha ou Ignorada</strong>, e isso decide o caminho que as atividades seguintes vão tomar. Útil para deixar um espaço reservado durante o desenvolvimento ou para pular uma etapa problemática enquanto a fonte está fora do ar.',
            img: { src: `${FAB_IMG}/m04/desativar-atividade.png`, alt: 'Atividade desativada no editor de pipeline', caption: 'Atividade desativada: aparece esmaecida e com o status escolhido para o fluxo seguir.', source: `${LEARN}/data-factory/activity-overview` } },
          { h: 'Condições de dependência',
            p: 'A seta que liga uma atividade à próxima tem uma condição. São quatro:',
            items: [
              '<strong>Ao ter êxito</strong> (On success, seta verde) — a próxima só roda se a anterior deu certo. É a padrão.',
              '<strong>Ao falhar</strong> (On fail, vermelha) — roda só se a anterior falhou; usada para tratamento de erro e alerta.',
              '<strong>Ao concluir</strong> (On completion, azul) — roda de qualquer jeito, com sucesso ou falha; usada para passos de “melhor esforço”, como gravar log.',
              '<strong>Ao ignorar</strong> (On skip, cinza) — roda quando a anterior não foi executada.',
              'Quando uma atividade recebe várias setas, todas as condições precisam ser atendidas (lógica “E”). Para lógica “OU”, use “Ao concluir” mais uma atividade Se (condição) testando o status das anteriores.'
            ] },
          { h: 'Quando o pipeline é considerado com falha',
            p: 'O status final do pipeline é calculado pelas <strong>atividades folha</strong> (as últimas de cada ramo); se uma folha foi ignorada, avalia-se a atividade anterior a ela. O pipeline só termina com êxito se todas as atividades avaliadas terminaram com êxito. Daí saem os padrões clássicos:',
            items: [
              '<strong>Try-catch</strong> — só o caminho “Ao falhar” é ligado ao tratamento de erro. Se o tratamento der certo, o pipeline termina <strong>com êxito</strong> (o erro foi “capturado”).',
              '<strong>Do-if-else</strong> — há um caminho “Ao ter êxito” e outro “Ao falhar”. Mesmo que o tratamento de erro dê certo, o pipeline termina <strong>com falha</strong>, porque o ramo de sucesso ficou ignorado e a atividade principal falhou.',
              '<strong>Do-if-skip-else</strong> — igual ao anterior, com uma atividade fictícia ligada por “Ao ignorar”; o pipeline volta a terminar com êxito quando o tratamento dá certo.',
              'Para <strong>forçar</strong> uma falha com mensagem e código próprios (por exemplo, arquivo vazio), use a atividade <strong>Falha (Fail)</strong>.'
            ] },
          { h: 'Atividades de orquestração que mais caem',
            items: [
              '<strong>Pesquisa (Lookup)</strong> — lê um valor ou uma lista de uma tabela, arquivo, consulta ou procedimento, para as próximas atividades usarem. Limites: até 5.000 linhas e 4 MB de saída.',
              '<strong>ForEach</strong> — repete as atividades internas para cada item de uma lista; o item atual é <code>@item()</code>. Pode ser <strong>sequencial</strong> ou em <strong>paralelo</strong>, com a <strong>contagem de lote</strong> limitando quantos itens rodam ao mesmo tempo.',
              '<strong>Se (condição)</strong> e <strong>Switch</strong> — ramificam por expressão; <strong>Até (Until)</strong> repete até a condição ficar verdadeira; <strong>Espera</strong> pausa.',
              '<strong>Obter metadados</strong> — lê propriedades de arquivos e pastas (existe? tamanho? lista de arquivos?) para decidir o que carregar.',
              '<strong>Invocar pipeline</strong> — um pipeline pai chama pipelines filhos (do Fabric, e também do ADF ou Synapse), podendo esperar a conclusão. Ajuda a modularizar e reutilizar.',
              '<strong>Definir variável</strong> e <strong>Acrescentar variável</strong> — gravam em variáveis do pipeline (Cadeia, Booliano ou Matriz); Definir variável também define o <strong>valor retornado</strong> do pipeline para quem o invocou.'
            ],
            img: { src: `${FAB_IMG}/m04/foreach-config.png`, alt: 'Configurações da atividade ForEach com a lista de itens', caption: 'ForEach: sequencial ou paralelo, contagem de lote e a lista de itens (fixa ou dinâmica).', source: `${LEARN}/data-factory/foreach-activity` } },
          { h: 'Como isso cai na prova',
            items: [
              'Enviar alerta só quando a cópia falhar → dependência “Ao falhar”.',
              'Gravar log independentemente do resultado → “Ao concluir”.',
              'Pipeline deve terminar com êxito depois de tratar o erro → padrão try-catch (só o caminho de falha ligado).',
              'Carregar uma lista de tabelas definida numa tabela de controle → Lookup + ForEach com <code>@item()</code>.',
              'Erro de rede intermitente → configurar repetição da atividade em vez de refazer o pipeline.'
            ] }
        ],
        recursos: [
          { t: 'Visão geral das atividades', u: `${LEARN}/data-factory/activity-overview` },
          { t: 'Erros e execução condicional (padrões de tratamento)', u: 'https://learn.microsoft.com/pt-br/azure/data-factory/tutorial-pipeline-failure-error-handling' },
          { t: 'Atividade ForEach', u: `${LEARN}/data-factory/foreach-activity` },
          { t: 'Atividade Pesquisa (Lookup)', u: `${LEARN}/data-factory/lookup-activity` },
          { t: 'Atividade Invocar pipeline', u: `${LEARN}/data-factory/invoke-pipeline-activity` },
          { t: 'Atividade Definir variável', u: `${LEARN}/data-factory/set-variable-activity` }
        ]
      },
      {
        id: 'fab-copy', title: 'Atividade Copiar e trabalho de cópia',
        desc: 'As duas formas de mover dados no Data Factory: a atividade Copiar dentro de um pipeline e o item trabalho de cópia, com cópia completa ou incremental, métodos de atualização e agendas próprias.',
        objetivos: [
          'Configurar origem, destino e mapeamento de uma atividade Copiar',
          'Explicar os modos de cópia e os métodos de atualização do trabalho de cópia',
          'Escolher entre atividade Copiar e trabalho de cópia'
        ],
        body: 'Copiar dados é a tarefa mais comum de qualquer engenheiro de dados. No Fabric há dois caminhos: a atividade Copiar, peça de um pipeline, e o trabalho de cópia, um item independente que já traz incremental e agendamento prontos.',
        content: [
          { h: 'A atividade Copiar',
            p: 'A atividade Copiar lê de uma fonte, converte os tipos e grava no destino. Você pode configurá-la pelo <strong>assistente de cópia</strong> (guia passo a passo: fonte, dados, destino, mapeamento, revisão) ou adicioná-la direto à tela e preencher as guias:',
            items: [
              '<strong>Origem</strong> — conexão e tabela, consulta ou caminho de arquivo.',
              '<strong>Destino</strong> — pode ser um item do próprio Fabric (lakehouse, warehouse, banco de dados KQL) ou um armazenamento externo. No lakehouse você escolhe gravar em <strong>Tables</strong> ou em <strong>Files</strong>.',
              '<strong>Mapeamento</strong> — “Importar esquemas” gera o mapeamento coluna a coluna; você pode renomear colunas ao criar uma tabela nova.',
              '<strong>Configurações</strong> — desempenho (paralelismo), preparo (staging), tolerância a falhas e verificação de consistência.',
              'Tipos de dados: o Data Factory converte o tipo nativo da origem num tipo provisório e depois no tipo do destino.'
            ],
            img: { src: `${FAB_IMG}/m04/assistente-copia.png`, alt: 'Opções para abrir o assistente de cópia', caption: 'Duas entradas: o assistente de cópia (guiado) ou adicionar a atividade Copiar à tela.', source: `${LEARN}/data-factory/copy-data-activity` } },
          { h: 'Parametrizando a cópia',
            p: 'Quase todos os campos aceitam <strong>conteúdo dinâmico</strong>: nome da tabela, pasta, até a própria conexão ou o lakehouse de destino. Assim um único pipeline, dentro de um ForEach, copia dezenas de tabelas lendo os nomes de uma tabela de controle. Na próxima aula você aprende a sintaxe das expressões.',
            img: { src: `${FAB_IMG}/m04/copia-no-canvas.png`, alt: 'Atividade de cópia na tela do pipeline', caption: 'A atividade Copiar na tela do pipeline, com as guias Geral, Origem, Destino, Mapeamento e Configurações.', source: `${LEARN}/data-factory/copy-data-activity` } },
          { h: 'O trabalho de cópia (Copy job)',
            p: 'É um item próprio do workspace para mover dados sem montar pipeline. Um mesmo trabalho copia várias tabelas de uma vez, com experiência guiada.',
            items: [
              '<strong>Cópia completa</strong> — toda execução copia tudo.',
              '<strong>Cópia incremental</strong> — a primeira execução copia tudo; as seguintes só o que é novo ou mudou. O próprio trabalho guarda o estado da última execução bem-sucedida; se uma execução falhar, a próxima retoma de onde a última boa parou, sem perda. Dá para redefinir e voltar a uma carga completa.',
              'Incremental por <strong>CDC</strong> (quando a fonte tem captura de dados de alteração: pega inserções, atualizações e exclusões) ou por <strong>marca d’água</strong> (uma coluna crescente, como data de alteração ou ID: pega inserções e atualizações).',
              '<strong>Métodos de atualização</strong> no destino: <strong>acréscimo</strong> (o padrão), <strong>mesclagem</strong> (upsert por coluna-chave), <strong>substituição</strong> e, em destinos com suporte, <strong>SCD Tipo 2</strong>.',
              'Cria as tabelas no destino se não existirem, pode truncar o destino antes da carga completa e acrescentar <strong>colunas de auditoria</strong> (hora da extração, arquivo de origem).',
              'Em destino lakehouse, pode habilitar o <strong>Change Data Feed</strong> da tabela Delta, para as camadas seguintes também processarem só as mudanças.',
              'Aceita <strong>vários agendamentos</strong> (por exemplo, diário às 6h e outro aos domingos), gateway local ou VNet, Git e biblioteca de variáveis para CI/CD.'
            ],
            img: { src: `${FAB_IMG}/m04/copy-job-monitor.png`, alt: 'Trabalho de cópia e seu painel de resultados', caption: 'Um trabalho de cópia com várias tabelas e o painel de resultados de cada execução.', source: `${LEARN}/data-factory/what-is-copy-job` } },
          { h: 'Atividade Copiar ou trabalho de cópia?',
            items: [
              '<strong>Trabalho de cópia</strong> — quer copiar muitas tabelas com incremental pronto, sem desenhar lógica de controle. É a escolha simples para ingestão e replicação.',
              '<strong>Atividade Copiar</strong> — a cópia é uma etapa dentro de um fluxo maior, com lógica própria (Lookup, ForEach, condições, notebook depois).',
              'Dá para juntar os dois: a atividade <strong>Trabalho de cópia</strong> executa um trabalho de cópia dentro de um pipeline, aproveitando gatilhos de evento e dependências.'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              'Copiar várias tabelas de um SQL com CDC habilitado, só as alterações, com pouco código → trabalho de cópia incremental baseado em CDC.',
              'Fonte sem CDC mas com coluna de data de alteração → incremental por marca d’água.',
              'Atualizar linhas existentes no destino pela chave → método de mesclagem.',
              'Cópia que precisa rodar só depois de validar um arquivo e antes de um notebook → atividade Copiar num pipeline.'
            ] }
        ],
        recursos: [
          { t: 'Como copiar dados usando a atividade Copiar', u: `${LEARN}/data-factory/copy-data-activity` },
          { t: 'O que é o trabalho de cópia', u: `${LEARN}/data-factory/what-is-copy-job` },
          { t: 'Atividade Trabalho de cópia em pipelines', u: `${LEARN}/data-factory/copy-job-activity` },
          { t: 'Visão geral dos conectores', u: `${LEARN}/data-factory/connector-overview` }
        ]
      },
      {
        id: 'fab-parametros-expressoes', title: 'Parâmetros, variáveis e expressões dinâmicas',
        desc: 'Como tornar um pipeline reutilizável: parâmetros, variáveis, variáveis de sistema, a linguagem de expressões e a passagem de parâmetros para notebooks e entre pipelines.',
        objetivos: [
          'Diferenciar parâmetro de variável de pipeline',
          'Escrever expressões com funções, saída de atividades e variáveis de sistema',
          'Passar parâmetros para um notebook e ler o valor que ele devolve'
        ],
        body: 'A habilidade DP-700 “Implementar padrões de orquestração com notebooks e pipelines, incluindo parâmetros e expressões dinâmicas” é uma das mais cobradas na parte prática da prova. O segredo é entender de onde vem cada valor e como referenciá-lo.',
        content: [
          { h: 'Parâmetros e variáveis',
            items: [
              '<strong>Parâmetro</strong> — valor que entra de fora no início da execução (manual, agenda, gatilho ou pipeline pai) e <strong>não muda</strong> durante a execução. Criado clicando no fundo da tela → guia Parâmetros → + Novo, com nome, tipo e valor padrão. Referência: <code>@pipeline().parameters.NomeTabela</code>.',
              '<strong>Variável</strong> — valor interno que <strong>pode mudar</strong> durante a execução, com as atividades Definir variável e Acrescentar variável. Referência: <code>@variables(\'contador\')</code>.',
              '<strong>Biblioteca de variáveis</strong> — item do workspace que guarda valores por ambiente (desenvolvimento, teste, produção); agendas e trabalhos de cópia podem ler dela, o que facilita o CI/CD (Módulo 13).'
            ],
            img: { src: `${FAB_IMG}/m04/parametro-novo.png`, alt: 'Editor de Parâmetros do pipeline', caption: 'Guia Parâmetros do pipeline: nome, tipo e valor padrão de cada parâmetro.', source: `${LEARN}/data-factory/parameters` } },
          { h: 'A linguagem de expressões',
            items: [
              'Um valor que começa com <strong>@</strong> é avaliado em tempo de execução; sem @, é texto literal.',
              'Para misturar texto e expressão use a interpolação <code>@{...}</code>: por exemplo, <code>vendas_@{pipeline().parameters.ano}.csv</code>.',
              'Funções de texto, coleção, lógica, conversão, matemática e data: <code>concat</code>, <code>formatDateTime</code>, <code>utcNow</code>, <code>addDays</code>, <code>equals</code>, <code>if</code>, <code>length</code>, <code>int</code>, entre outras. Exemplo de nome de arquivo com data: <code>@concat(\'vendas_\', formatDateTime(utcNow(), \'yyyyMMdd\'), \'.parquet\')</code>.',
              'Aspas simples delimitam texto; para um apóstrofo dentro do texto, use duas aspas simples.',
              'Para ler um subcampo cujo nome vem de parâmetro, use colchetes em vez do ponto.'
            ],
            img: { src: `${FAB_IMG}/m04/parametro-conteudo-dinamico.png`, alt: 'Janela Adicionar conteúdo dinâmico com um parâmetro', caption: 'A janela Adicionar conteúdo dinâmico: parâmetros, variáveis de sistema, funções e saídas de atividades a um clique.', source: `${LEARN}/data-factory/parameters` } },
          { h: 'De onde vêm os valores',
            items: [
              'Saída de outra atividade: <code>@activity(\'NomeDaAtividade\').output</code>. Do Lookup com “somente primeira linha”: <code>...output.firstRow.Coluna</code>; com várias linhas: <code>...output.value</code> (a lista que alimenta um ForEach).',
              'Item atual dentro de um ForEach: <code>@item()</code> (ou <code>@item().Coluna</code>).',
              'Variáveis de sistema: <code>@pipeline().RunId</code> (ID da execução), <code>@pipeline().PipelineName</code>, <code>@pipeline().TriggerTime</code> (hora em que o gatilho disparou, em UTC), <code>@pipeline().TriggerName</code> e o ID do workspace.',
              'Todas as datas de gatilho vêm em <strong>UTC</strong>, no formato ISO 8601 — converta para o fuso local quando for gravar ou comparar.'
            ],
            img: { src: `${FAB_IMG}/m04/lookup-saida-expressao.png`, alt: 'Uso da saída da atividade de pesquisa numa expressão', caption: 'A saída de uma atividade Pesquisa sendo usada numa expressão da atividade seguinte.', source: `${LEARN}/data-factory/lookup-activity` } },
          { h: 'Parâmetros em notebooks',
            p: 'Para receber valores do pipeline, o notebook precisa de uma <strong>célula de parâmetros</strong> (marcada com “Alternar célula de parâmetro”), onde ficam as variáveis com valores padrão. Na atividade Notebook, os <strong>parâmetros base</strong> sobrescrevem esses valores; o Fabric até preenche a lista automaticamente a partir da célula de parâmetros. No sentido contrário, o notebook devolve um valor ao pipeline encerrando com <code>notebookutils.notebook.exit(valor)</code>, lido no pipeline em <code>@activity(\'NomeDoNotebook\').output.result.exitValue</code>. Não coloque o <code>exit</code> dentro de um bloco try/except: a exceção interna que ele gera precisa se propagar para o pipeline receber o valor.',
            img: { src: `${FAB_IMG}/m04/notebook-parametros-base.png`, alt: 'Parâmetros base preenchidos automaticamente na atividade Notebook', caption: 'Atividade Notebook: os parâmetros base vêm da célula de parâmetros do notebook e podem receber conteúdo dinâmico.', source: `${LEARN}/data-factory/notebook-activity` } },
          { h: 'Outros detalhes da atividade Notebook',
            items: [
              '<strong>Marca de sessão</strong>: com o modo de alta simultaneidade para pipelines ligado nas configurações do Spark do workspace, notebooks do pipeline que usam a mesma marca reaproveitam a sessão Spark e começam mais rápido.',
              'A atividade pode autenticar com a <strong>identidade do workspace</strong>, útil para não depender da conta de uma pessoa.',
              'Não executa notebooks de outra região.'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              'Mesmo pipeline para várias tabelas ou ambientes → parâmetros, não cópias do pipeline.',
              'Valor que precisa mudar durante a execução (contador, lista acumulada) → variável.',
              'Nome de arquivo com a data da execução → <code>formatDateTime</code> com <code>utcNow</code> ou <code>pipeline().TriggerTime</code>.',
              'Notebook precisa receber a data de corte → célula de parâmetros + parâmetro base; devolver o total de linhas → <code>notebookutils.notebook.exit</code>.'
            ] }
        ],
        recursos: [
          { t: 'Parâmetros do Data Factory', u: `${LEARN}/data-factory/parameters` },
          { t: 'Expressões e funções', u: `${LEARN}/data-factory/expression-language` },
          { t: 'Atividade Notebook', u: `${LEARN}/data-factory/notebook-activity` }
        ]
      },
      {
        id: 'fab-agendas-gatilhos', title: 'Executar, agendar, disparar por evento e monitorar',
        desc: 'As três formas de iniciar um pipeline — sob demanda, por agenda e por evento — e como acompanhar as execuções, receber alertas de falha e reexecutar a partir da atividade que falhou.',
        objetivos: [
          'Configurar agendas fixas e baseadas em intervalo, com parâmetros',
          'Criar um gatilho de evento de armazenamento e usar o nome do arquivo no pipeline',
          'Monitorar execuções e reexecutar a partir da falha'
        ],
        body: 'Esta aula cobre a habilidade DP-700 “Projetar e implementar agendas e gatilhos baseados em eventos” e o início de “Monitorar a ingestão de dados”, que volta com mais profundidade no Módulo 14.',
        content: [
          { h: 'Sob demanda',
            p: 'O botão <strong>Executar</strong> da guia Página Inicial dispara uma execução imediata; o Fabric pede para salvar antes (Salvar e executar). O andamento aparece na guia <strong>Saída</strong>, embaixo da tela, atividade por atividade.' },
          { h: 'Agendas',
            items: [
              'Em <strong>Agendar → Adicionar agenda</strong>, você define frequência, data e hora de início e de término e fuso horário. Por padrão, o pipeline não tem agenda.',
              'Data de término é obrigatória: não existe agenda sem fim. Para rodar indefinidamente, use uma data bem distante.',
              'Até <strong>20 agendas</strong> por pipeline, cada uma com frequência e horários próprios.',
              'A agenda pode passar <strong>valores de parâmetros</strong> — valor direto ou lido de uma biblioteca de variáveis. Os nomes precisam bater com os parâmetros do pipeline.',
              '<strong>Agenda baseada em intervalo</strong> (versão prévia): janelas fixas e sem sobreposição, que entregam ao pipeline o início e o fim de cada janela — ótimo para cargas incrementais por período. Não dá para editar nem pausar: exclua e recrie.',
              '<strong>Notificações de falha</strong> por e-mail para usuários ou grupos — valem só para execuções agendadas, não para as sob demanda.'
            ],
            img: { src: `${FAB_IMG}/m04/agenda-fixa.png`, alt: 'Configuração de agendamento fixo', caption: 'Configuração de uma agenda fixa: frequência, início, término e fuso horário.', source: `${LEARN}/data-factory/pipeline-runs` } },
          { h: 'Agenda com parâmetros',
            p: 'Um mesmo pipeline pode ter uma agenda diária que passa <code>modo = incremental</code> e uma semanal que passa <code>modo = completo</code>. É assim que se combina carga incremental no dia a dia com uma reconciliação completa periódica, sem duplicar o pipeline.',
            img: { src: `${FAB_IMG}/m04/agenda-parametros.png`, alt: 'Agenda com a seção de parâmetros', caption: 'Agenda passando valores para os parâmetros do pipeline.', source: `${LEARN}/data-factory/pipeline-runs` } },
          { h: 'Gatilhos por evento',
            items: [
              'Iniciam o pipeline quando algo acontece: um arquivo chega ou é excluído (eventos de arquivo do OneLake ou de Blob do Azure), um trabalho termina, algo muda no workspace.',
              'Criados pelo botão <strong>Gatilho</strong> da guia Página Inicial. Por baixo, usam o <strong>Activator</strong> (Ativador de Dados) e os eventos do Real-Time hub; o gatilho vira um item do tipo <strong>Reflex</strong> no workspace.',
              'O pipeline recebe o nome do arquivo e o caminho da pasta do evento pela guia “Parâmetros de gatilho” do construtor de expressões — por exemplo <code>@pipeline()?.TriggerEvent?.FileName</code>. Assim a cópia processa exatamente o arquivo que chegou. O <strong>?</strong> evita erro quando o valor é nulo, como num teste manual, em que não existe evento.',
              'Use quando os dados chegam em horários imprevisíveis: em vez de agendar a cada 5 minutos “para ver se chegou”, o pipeline só roda quando há o que processar.'
            ],
            img: { src: `${FAB_IMG}/m04/gatilho-evento.png`, alt: 'Botão Gatilho na guia Página Inicial do pipeline', caption: 'O botão Gatilho: execuções baseadas em eventos, configuradas com o Activator.', source: `${LEARN}/data-factory/pipeline-runs` } },
          { h: 'Monitorar e reexecutar',
            items: [
              '<strong>Guia Saída</strong> — execução atual, com entrada, saída e erro de cada atividade.',
              '<strong>Exibir histórico de execuções</strong> (menu ... do pipeline) e o <strong>hub de Monitoramento</strong>, com filtros, colunas, exportação para CSV e a visão de <strong>Gantt</strong> (barras por duração).',
              'Na cópia, o ícone de detalhes mostra quanto tempo cada etapa levou (fila, leitura, gravação) — ponto de partida para otimizar.',
              '<strong>Reexecutar a partir da atividade com falha</strong>, sem repetir o que já deu certo.',
              'Para análise em nível de log, o <strong>monitoramento do workspace</strong> grava os eventos num eventhouse; o uso de capacidade aparece no aplicativo Capacity Metrics.'
            ],
            img: { src: `${FAB_IMG}/m04/rerun-falha.png`, alt: 'Reexecução da atividade com falha no hub de monitoramento', caption: 'Hub de Monitoramento: reexecutar o pipeline a partir da atividade que falhou.', source: `${LEARN}/data-factory/monitor-pipeline-runs` } },
          { h: 'Como isso cai na prova',
            items: [
              'Arquivos chegam a qualquer hora e devem ser processados assim que chegam → gatilho de evento de armazenamento, usando o nome do arquivo do evento.',
              'Carga diária incremental e completa aos domingos no mesmo pipeline → duas agendas com parâmetros diferentes.',
              'Equipe precisa ser avisada quando a carga agendada falhar → notificações de falha da agenda (ou atividade Outlook/Teams no caminho “Ao falhar”).',
              'Pipeline falhou na última de 10 etapas → reexecutar a partir da atividade com falha.'
            ] }
        ],
        recursos: [
          { t: 'Executar, agendar ou usar eventos para iniciar um pipeline', u: `${LEARN}/data-factory/pipeline-runs` },
          { t: 'Monitorar execuções de pipeline', u: `${LEARN}/data-factory/monitor-pipeline-runs` }
        ]
      },
      {
        id: 'fab-carga-incremental', title: 'Cargas completas e incrementais',
        desc: 'Quando recarregar tudo e quando carregar só o que mudou: marca d’água, CDC, Change Data Feed e o passo a passo do padrão Lookup + Copiar + procedimento armazenado.',
        objetivos: [
          'Decidir entre carga completa e incremental',
          'Montar a carga incremental por marca d’água num pipeline',
          'Reconhecer quando usar CDC, trabalho de cópia ou Change Data Feed'
        ],
        body: 'A habilidade DP-700 “Projetar e implementar cargas de dados completas e incrementais” aparece em quase todo estudo de caso da prova. Aqui você vê as opções e o padrão clássico construído atividade por atividade.',
        content: [
          { h: 'Completa ou incremental',
            items: [
              '<strong>Carga completa</strong> — apaga e recarrega (ou sobrescreve) tudo. Simples e sempre consistente, mas cara em tabelas grandes. Boa para tabelas pequenas, dimensões de baixo volume e reconciliações periódicas.',
              '<strong>Carga incremental</strong> — traz só o que é novo ou mudou desde a última carga. Mais rápida e barata, mas exige uma forma confiável de saber o que mudou e cuidado para não perder nem duplicar linhas.',
              'Na prática se combinam: incremental no dia a dia e completa de tempos em tempos para corrigir desvios.'
            ] },
          { h: 'Formas de detectar o que mudou',
            items: [
              '<strong>Marca d’água (watermark)</strong> — uma coluna que só cresce (data de alteração, ID sequencial). Guarda-se o maior valor já carregado e, na próxima vez, busca-se o que for maior que ele. Pega inserções e atualizações, mas <strong>não pega exclusões</strong>.',
              '<strong>CDC (captura de dados de alteração)</strong> — o banco de origem registra inserções, atualizações e exclusões. Mais completo; exige CDC habilitado na fonte.',
              '<strong>Change Data Feed</strong> das tabelas Delta — dentro do lakehouse, permite que a prata leia só as mudanças da bronze.',
              '<strong>Espelhamento</strong> e <strong>trabalho de cópia incremental</strong> — fazem o controle do estado por você.'
            ] },
          { h: 'O padrão de marca d’água no pipeline',
            p: 'O tutorial oficial monta a carga incremental do warehouse para o lakehouse com quatro atividades:',
            items: [
              '1. <strong>Pesquisa da marca antiga</strong> — lê, numa tabela de controle (por exemplo <code>watermarktable</code>), o último valor carregado.',
              '2. <strong>Pesquisa da marca nova</strong> — consulta o maior valor atual da coluna de controle na origem.',
              '3. <strong>Copiar</strong> — ligada às duas pesquisas por “Ao ter êxito”, copia só as linhas com valor maior que a marca antiga e menor ou igual à nova, usando uma consulta com as saídas das pesquisas.',
              '4. <strong>Procedimento armazenado</strong> — depois do sucesso da cópia, grava a marca nova na tabela de controle, para a próxima execução.',
              'Por que capturar a marca nova <strong>antes</strong> de copiar: linhas que chegarem durante a cópia ficam para a próxima janela, sem perda nem duplicação.'
            ],
            img: { src: `${FAB_IMG}/m04/logica-incremental.png`, alt: 'Diagrama da lógica de carga incremental com marca d’água', caption: 'A lógica oficial: marca antiga e marca nova (Pesquisa), cópia entre as duas (Copiar), atualização da marca (Procedimento armazenado).', source: `${LEARN}/data-factory/tutorial-incremental-copy-data-warehouse-lakehouse` } },
          { h: 'As atividades ligadas na tela',
            p: 'A ordem importa: a marca só é atualizada se a cópia deu certo. Se a cópia falhar, a marca antiga continua valendo e a próxima execução tenta a mesma janela de novo — a carga é <strong>reexecutável</strong> sem perder dados.',
            img: { src: `${FAB_IMG}/m04/lookup-copia-conectados.png`, alt: 'Atividades de pesquisa conectadas à atividade de cópia', caption: 'As duas atividades Pesquisa ligadas à cópia pela seta verde (Ao ter êxito).', source: `${LEARN}/data-factory/tutorial-incremental-copy-data-warehouse-lakehouse` } },
          { h: 'Gravando no destino sem duplicar',
            items: [
              'Só inserções (logs, eventos) → <strong>acréscimo</strong>.',
              'Inserções e atualizações → <strong>MERGE</strong> (upsert) pela chave de negócio: no lakehouse com Spark/Delta, no warehouse com T-SQL, ou com o método de mesclagem do trabalho de cópia.',
              'Precisa de histórico → SCD Tipo 2 (Módulo 03).',
              'Exclusões na origem → só aparecem com CDC ou com uma comparação periódica completa (carga de reconciliação).'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              'Tabela com coluna de última alteração, sem CDC → marca d’água.',
              'Precisa refletir exclusões da origem → CDC (ou espelhamento), não marca d’água.',
              'Pouco código, muitas tabelas, incremental gerenciado → trabalho de cópia.',
              'Onde atualizar a marca? → no fim, só após o sucesso da cópia.'
            ] }
        ],
        recursos: [
          { t: 'Tutorial: carga incremental do warehouse para o lakehouse', u: `${LEARN}/data-factory/tutorial-incremental-copy-data-warehouse-lakehouse` },
          { t: 'Trabalho de cópia: modos incrementais', u: `${LEARN}/data-factory/what-is-copy-job` }
        ]
      },
      {
        id: 'fab-escolher-ferramenta', title: 'Escolher entre pipeline, Dataflow Gen2, notebook e trabalho de cópia',
        desc: 'O guia de decisão oficial resumido: qual ferramenta usar para ingerir, transformar e orquestrar, por perfil da equipe, volume de dados e necessidade de código.',
        objetivos: [
          'Comparar atividade Copiar, trabalho de cópia, Dataflow Gen2, Eventstream e Spark',
          'Escolher a ferramenta de orquestração: pipeline, notebook ou Airflow',
          'Resolver cenários no estilo da prova'
        ],
        body: 'A prova DP-700 tem uma habilidade só para isso: “Escolha entre o Dataflow Gen 2, um pipeline e um notebook”. As questões descrevem uma equipe, um volume e uma restrição, e pedem a ferramenta. Esta aula fecha o módulo com o guia de decisão da Microsoft.',
        content: [
          { h: 'Uma frase para cada ferramenta',
            items: [
              '<strong>Atividade Copiar (pipeline)</strong> — mover dados em qualquer volume, sem código, como parte de um fluxo orquestrado. Migrações e ingestão em lote.',
              '<strong>Trabalho de cópia</strong> — mover dados sem código com incremental e replicação prontos, sem montar pipeline.',
              '<strong>Dataflow Gen2</strong> — ingerir e <strong>transformar</strong> com Power Query (linguagem M), sem código ou pouco código, com mais de 150 conectores. Perfil: analista de negócios e engenheiro que conhece Power Query; volume pequeno a médio.',
              '<strong>Eventstream</strong> — dados de eventos em tempo real (Kafka, CDC, mensageria), sem código (Módulo 08).',
              '<strong>Notebook / Spark</strong> — código (PySpark, Scala, Spark SQL, R), transformações complexas e grandes volumes, bibliotecas, testes. Perfil: engenheiro e cientista de dados.'
            ] },
          { h: 'Orquestrar: quem chama quem',
            items: [
              '<strong>Pipeline</strong> — o orquestrador padrão do Fabric: agenda, gatilho por evento, dependências, repetição e alertas, chamando cópias, dataflows, notebooks e procedimentos.',
              '<strong>Notebook orquestrando notebooks</strong> — com <code>notebookutils.notebook.run</code> ou <code>runMultiple</code>, para quem prefere controlar tudo em código dentro do Spark.',
              '<strong>Trabalho do Apache Airflow</strong> — orquestração em Python (DAGs), para equipes que já têm Airflow.',
              'O padrão mais comum na prova: <strong>pipeline</strong> orquestrando, <strong>cópia</strong> para a bronze e <strong>notebook</strong> ou <strong>Dataflow Gen2</strong> para prata e ouro.'
            ] },
          { h: 'Cenários do guia oficial',
            items: [
              '<strong>Grande volume de muitas fontes</strong> (bancos, arquivos, APIs, locais e nuvem), sem querer manter código de conector → <strong>atividade Copiar</strong> em pipeline para a bronze.',
              '<strong>Analista experiente em Power Query</strong>, volume baixo a médio, precisa limpar e juntar dados para relatórios → <strong>Dataflow Gen2</strong>.',
              '<strong>Eventos chegando continuamente</strong>, preferência por solução sem código → <strong>Eventstream</strong>.',
              '<strong>Transformações complexas em grande volume</strong> por um engenheiro que programa → <strong>Spark</strong> (notebook ou definição de trabalho do Spark).',
              '<strong>Várias tabelas com CDC</strong> no SQL Server local, solução guiada com carga inicial e depois incremental → <strong>trabalho de cópia</strong>.'
            ] },
          { h: 'Pistas nas perguntas',
            items: [
              '“Sem código”, “baixo código”, “Power Query”, “analista” → Dataflow Gen2 (transformar) ou cópia (só mover).',
              '“PySpark”, “bibliotecas”, “volume muito grande”, “lógica complexa” → notebook.',
              '“Agendar”, “encadear”, “depois que terminar”, “se falhar” → pipeline.',
              '“Só as alterações”, “CDC”, “várias tabelas” sem lógica extra → trabalho de cópia.',
              '“Tempo real”, “eventos”, “streaming” → Eventstream (ou streaming estruturado no Spark, Módulo 06).'
            ] },
          { h: 'Como isso cai na prova',
            p: 'Leia o cenário procurando três coisas: <strong>quem</strong> vai manter a solução (analista ou engenheiro que programa), <strong>quanto</strong> dado e com que frequência, e <strong>o que</strong> precisa ser feito (só mover, transformar ou orquestrar). A resposta certa quase sempre é a ferramenta mais simples que atende as três. Nos Módulos 05 e 06 você aprofunda Dataflow Gen2 e notebooks.' }
        ],
        recursos: [
          { t: 'Guia de decisão: cópia, trabalho de cópia, dataflow, Eventstream ou Spark', u: `${LEARN}/fundamentals/decision-guide-pipeline-dataflow-spark` },
          { t: 'Visão geral das atividades', u: `${LEARN}/data-factory/activity-overview` }
        ]
      }
    ]
  },
  {
    id: 'fab-m05', title: 'Módulo 05 · Dataflows Gen2 e o editor de consultas visuais', kind: 'video',
    lessons: [
      {
        id: 'fab-dataflow-gen2', title: 'Dataflow Gen2: o Power Query dentro do Fabric',
        desc: 'O que é o Dataflow Gen2, o que mudou em relação ao Gen1, como criar, salvar e publicar, e as formas de executar: sob demanda, por agenda ou por pipeline.',
        objetivos: [
          'Explicar o que o Dataflow Gen2 faz e para quem ele é indicado',
          'Diferenciar Dataflow Gen1 e Gen2',
          'Entender rascunho, publicação e atualização',
          'Executar um dataflow por agenda ou pela atividade Fluxo de dados de um pipeline'
        ],
        body: 'O Dataflow Gen2 é a ferramenta sem código (ou com pouco código) de ingestão e transformação do Fabric. Ele usa o mesmo Power Query do Power BI Desktop e do Excel — se você já fez o curso de Power BI, está em casa. Para a prova, ele aparece nas habilidades de transformação da DP-600 e em “Escolha entre fluxos de dados Gen2, notebooks, KQL e T-SQL” e “Identificar e resolver erros do Dataflow Gen2” da DP-700.',
        content: [
          { h: 'O que é',
            p: 'Um dataflow se conecta a centenas de fontes (bancos, arquivos, APIs, SharePoint, serviços de nuvem), aplica mais de 300 transformações pela interface visual do Power Query e grava o resultado num destino. Cada etapa que você clica vira uma linha de código na linguagem <strong>M</strong>, visível no Editor Avançado. Ele exige capacidade Fabric (paga ou de avaliação) ou Power BI Premium.',
            img: { src: `${FAB_IMG}/m05/editor-dataflow.png`, alt: 'Experiência de criação do Dataflow Gen2', caption: 'O editor do Dataflow Gen2: consultas à esquerda, faixa de opções do Power Query, visualização dos dados e etapas aplicadas.', source: `${LEARN}/data-factory/dataflows-gen2-overview` } },
          { h: 'Gen1 × Gen2',
            items: [
              '<strong>Destino</strong>: o Gen1 guarda o resultado num armazenamento interno, lido pelo conector Dataflows. O Gen2 grava em <strong>destinos de dados</strong> — lakehouse, warehouse, banco SQL, banco KQL, Azure SQL, ADLS Gen2, SharePoint, Snowflake, PostgreSQL e outros.',
              '<strong>Salvamento automático</strong>: cada alteração vira um <strong>rascunho</strong> salvo na nuvem; a <strong>publicação</strong> valida em segundo plano e gera a versão que será atualizada.',
              '<strong>Computação</strong>: usa itens de preparo (staging) com o mecanismo SQL do Fabric para processar volumes maiores.',
              '<strong>Monitoramento</strong>: histórico de atualizações detalhado e integração com o hub de Monitoramento.',
              '<strong>Pipelines</strong>: entra como atividade de pipeline, com parâmetros.',
              '<strong>CI/CD</strong>: desde abril de 2026 todo Dataflow Gen2 novo já nasce com integração Git e pipelines de implantação. Itens antigos podem ser convertidos com <strong>Salvar como</strong>.'
            ] },
          { h: 'Migrando do Gen1',
            items: [
              'Exportar as consultas num arquivo modelo <strong>PQT</strong> e importar no Gen2.',
              'Copiar e colar as consultas no editor.',
              'Usar <strong>Salvar como</strong>, que cria um Dataflow Gen2 novo a partir de qualquer dataflow existente.'
            ] },
          { h: 'Exibição de diagrama e consultas de referência',
            p: 'A <strong>exibição de diagrama</strong> mostra as consultas como caixas ligadas, deixando claro quem depende de quem. Um padrão comum é ter uma consulta que só busca os dados brutos e outras que a <strong>referenciam</strong> para aplicar transformações diferentes, sem ler a fonte duas vezes.',
            img: { src: `${FAB_IMG}/m05/diagrama-consultas.png`, alt: 'Exibição de diagrama do Power Query', caption: 'Exibição de diagrama: cada consulta com suas etapas, e as ligações entre consultas.', source: `${LEARN}/data-factory/create-first-dataflow-gen2` } },
          { h: 'Executando o dataflow',
            items: [
              '<strong>Sob demanda</strong> — botão Atualizar no workspace; toda publicação bem-sucedida também dispara uma atualização.',
              '<strong>Agendada</strong> — até <strong>48 vezes por dia</strong>.',
              '<strong>Por pipeline</strong> — atividade <strong>Fluxo de dados</strong>, que permite encadear com cópia, notebook e alertas e passar parâmetros.',
              'Quem dispara a atualização precisa ser <strong>Membro</strong> (ou superior) do workspace e ter acesso a todas as conexões do dataflow.',
              'Limite de <strong>300 atualizações</strong> por dataflow numa janela móvel de 24 horas. A atualização pode ser <strong>cancelada</strong> no workspace.'
            ] },
          { h: 'Copilot para Dataflow Gen2',
            p: 'O Copilot cria consultas e aplica transformações a partir de texto (“manter só clientes da Europa”, “contar pedidos por cliente”), explica consultas existentes e ajuda a corrigir erros. Ele gera as mesmas etapas que você geraria clicando — continue revisando o resultado.' },
          { h: 'Como isso cai na prova',
            items: [
              'Analista que já domina Power Query precisa limpar e juntar dados sem código → Dataflow Gen2.',
              'Resultado precisa ficar num lakehouse para um notebook usar depois → destino de dados do Gen2 (o Gen1 não faz isso).',
              'Dataflow precisa rodar depois da cópia terminar → atividade Fluxo de dados num pipeline.'
            ] }
        ],
        recursos: [
          { t: 'O que é o Dataflow Gen2', u: `${LEARN}/data-factory/dataflows-gen2-overview` },
          { t: 'Criar o primeiro Dataflow Gen2', u: `${LEARN}/data-factory/create-first-dataflow-gen2` },
          { t: 'Salvar rascunho e publicar', u: `${LEARN}/data-factory/dataflows-gen2-save-draft` },
          { t: 'Atualização do fluxo de dados', u: `${LEARN}/data-factory/dataflow-gen2-refresh` },
          { t: 'Atividade Fluxo de dados em pipelines', u: `${LEARN}/data-factory/dataflow-activity` }
        ]
      },
      {
        id: 'fab-dataflow-transformacoes', title: 'Transformações essenciais: filtrar, combinar, agrupar e remodelar',
        desc: 'As transformações do Power Query que a DP-600 cobra: filtrar, converter tipos, criar colunas, mesclar (joins), acrescentar, agrupar e agregar, dinamizar e despivotar, e desnormalizar.',
        objetivos: [
          'Filtrar linhas e converter tipos corretamente',
          'Enriquecer tabelas com colunas condicionais, personalizadas e de exemplos',
          'Escolher o tipo de junção certo ao mesclar consultas',
          'Agrupar, agregar e remodelar dados para o esquema estrela'
        ],
        body: 'A seção “Transformar dados” da DP-600 lista exatamente estas operações: enriquecer com colunas ou tabelas, desnormalizar, agregar, mesclar ou unir, converter tipos e filtrar. No Dataflow Gen2 todas são feitas pela faixa de opções do Power Query — e as mesmas ideias valem em SQL e PySpark nos próximos módulos.',
        content: [
          { h: 'Filtrar e converter tipos',
            items: [
              '<strong>Filtrar linhas</strong> pelo menu da coluna (valores, intervalos de data, texto contém). Filtre cedo: menos linhas em todas as etapas seguintes e mais chance de a consulta ser executada na própria fonte.',
              '<strong>Manter/remover linhas</strong>: primeiras, últimas, intervalo, linhas em branco, erros.',
              '<strong>Tipos de dados</strong>: defina o tipo de cada coluna (inteiro, decimal, data, texto, verdadeiro/falso). Tipo errado gera erro de conversão na célula ou soma que não fecha.',
              '<strong>Localidade</strong>: “Alterar tipo → Usando localidade” resolve datas e números em outro formato — por exemplo, um arquivo com data americana (mês/dia) ou decimal com ponto.'
            ] },
          { h: 'Enriquecer: novas colunas',
            items: [
              '<strong>Coluna condicional</strong> — regras se/então sem escrever código (faixa de valor, categoria).',
              '<strong>Coluna personalizada</strong> — fórmula M, por exemplo <code>[Quantidade] * [PrecoUnitario]</code>.',
              '<strong>Coluna de exemplos</strong> — você digita alguns resultados desejados e o Power Query deduz a fórmula (juntar nome e sobrenome, extrair parte de um código, criar faixas).',
              'Colunas de data (ano, mês, trimestre), extrair texto, dividir coluna por delimitador.',
              'Enriquecer também é trazer colunas de outra tabela — com a mesclagem, logo abaixo.'
            ],
            img: { src: `${FAB_IMG}/m05/coluna-de-exemplos.png`, alt: 'Coluna de exemplos no editor do Power Query', caption: 'Coluna de exemplos: você digita o resultado esperado em algumas linhas e o Power Query gera a transformação.', source: 'https://learn.microsoft.com/pt-br/power-query/column-from-example' } },
          { h: 'Mesclar consultas (joins)',
            p: 'Mesclar une duas tabelas pelos valores de uma ou mais colunas. O resultado é uma nova coluna do tipo tabela, que você <strong>expande</strong> para escolher os campos da tabela da direita. Os seis tipos de junção:',
            items: [
              '<strong>Externa esquerda</strong> — todas as linhas da esquerda e as correspondentes da direita (o padrão; é o “PROCV”).',
              '<strong>Externa direita</strong> — todas da direita e as correspondentes da esquerda.',
              '<strong>Externa completa</strong> — todas as linhas das duas tabelas.',
              '<strong>Interna</strong> — só as linhas que têm correspondência nas duas.',
              '<strong>Anti esquerda</strong> — só as linhas da esquerda <strong>sem</strong> correspondência (ótima para achar vendas com produto que não existe no cadastro).',
              '<strong>Anti direita</strong> — só as linhas da direita sem correspondência.',
              '<strong>Correspondência difusa</strong> (fuzzy) — para colunas de texto com grafias diferentes (“Sao Paulo” × “São Paulo”), com limite de similaridade.'
            ],
            img: { src: `${FAB_IMG}/m05/mesclar-janela.png`, alt: 'Caixa de diálogo de mesclagem com colunas selecionadas', caption: 'A janela Mesclar: tabela da esquerda, tabela da direita, colunas de junção e tipo de junção.', source: 'https://learn.microsoft.com/pt-br/power-query/merge-queries-overview' } },
          { h: 'Acrescentar consultas (união)',
            p: '<strong>Acrescentar</strong> empilha as linhas de duas ou mais tabelas numa só — vendas da loja + vendas online + atacado. Colunas com o mesmo nome se alinham; uma coluna que existe só numa tabela aparece com valores nulos nas outras. Mesclar junta colunas (lado a lado); acrescentar junta linhas (uma embaixo da outra).' },
          { h: 'Agrupar e agregar',
            p: '<strong>Agrupar por</strong> resume linhas pelas colunas escolhidas com operações como Soma, Média, Mínimo, Máximo, Contar linhas, Contar linhas distintas e <strong>Todas as linhas</strong> (que guarda as linhas de cada grupo numa tabela aninhada para cálculos mais elaborados). No modo Avançado você agrupa por várias colunas e cria várias agregações de uma vez. Existe ainda o <strong>agrupamento difuso</strong>, que junta textos parecidos.',
            img: { src: `${FAB_IMG}/m05/agrupar-por-janela.png`, alt: 'Caixa de diálogo Agrupar por com colunas agregadas', caption: 'Agrupar por (Avançado): várias colunas de agrupamento e várias agregações.', source: 'https://learn.microsoft.com/pt-br/power-query/group-by' } },
          { h: 'Remodelar: dinamizar e despivotar',
            items: [
              '<strong>Transformar colunas em linhas</strong> (despivotar) — converte uma planilha “larga” (um mês por coluna) em formato longo (colunas Atributo e Valor). É o formato certo para tabela fato.',
              'Prefira <strong>Transformar outras colunas em linhas</strong>: selecione as colunas fixas (por exemplo, País) e todo o resto é despivotado — inclusive meses novos que aparecerem na fonte.',
              '<strong>Dinamizar coluna</strong> — o inverso: valores de uma coluna viram colunas, com uma agregação.'
            ],
            img: { src: `${FAB_IMG}/m05/unpivot-diagrama.png`, alt: 'Diagrama de transformação de colunas em linhas', caption: 'Despivotar: os cabeçalhos A1, A2, A3 viram valores de uma coluna Atributo, ao lado de uma coluna Valor.', source: 'https://learn.microsoft.com/pt-br/power-query/unpivot-column' } },
          { h: 'Desnormalizar',
            p: '<strong>Desnormalizar</strong> é juntar tabelas normalizadas numa tabela mais larga, para simplificar o modelo e acelerar consultas. Exemplo: Produto, Subcategoria e Categoria do sistema de origem viram uma única <strong>dimensão Produto</strong> com as colunas de subcategoria e categoria — feito com mesclagens (externa esquerda) e expansão das colunas. É assim que se chega ao esquema estrela do Módulo 03.' },
          { h: 'Como isso cai na prova',
            items: [
              'Listar pedidos cujo cliente não existe no cadastro → mesclar com <strong>anti esquerda</strong>.',
              'Juntar arquivos mensais com as mesmas colunas → <strong>acrescentar</strong>.',
              'Planilha com um mês por coluna precisa virar fato → <strong>transformar outras colunas em linhas</strong>.',
              'Total de vendas por cliente e ano → <strong>agrupar por</strong> com Soma.',
              'Criar dimensão Produto com categoria → desnormalizar com mesclagem + expandir.'
            ] }
        ],
        recursos: [
          { t: 'Visão geral de mesclar consultas', u: 'https://learn.microsoft.com/pt-br/power-query/merge-queries-overview' },
          { t: 'Acrescentar consultas', u: 'https://learn.microsoft.com/pt-br/power-query/append-queries' },
          { t: 'Agrupar ou resumir linhas', u: 'https://learn.microsoft.com/pt-br/power-query/group-by' },
          { t: 'Transformar colunas em linhas', u: 'https://learn.microsoft.com/pt-br/power-query/unpivot-column' },
          { t: 'Adicionar coluna de exemplos', u: 'https://learn.microsoft.com/pt-br/power-query/column-from-example' },
          { t: 'Tipos de dados no Power Query', u: 'https://learn.microsoft.com/pt-br/power-query/data-types' }
        ]
      },
      {
        id: 'fab-dataflow-qualidade', title: 'Qualidade de dados: duplicados, ausentes, nulos e erros',
        desc: 'Ferramentas de perfil de dados, remoção de duplicados, tratamento de nulos e valores ausentes, e a diferença entre erro de etapa e erro de célula.',
        objetivos: [
          'Usar qualidade, distribuição e perfil de coluna para diagnosticar dados',
          'Remover ou isolar duplicados sem cair na armadilha de maiúsculas e minúsculas',
          'Tratar nulos e valores ausentes',
          'Resolver erros de etapa e erros de célula'
        ],
        body: 'A habilidade DP-600 “Identificar e resolver dados duplicados, dados ausentes ou valores nulos” e a DP-700 “Manipular dados duplicados, ausentes e de chegada tardia” caem em forma de cenário. Primeiro você diagnostica, depois decide o tratamento.',
        content: [
          { h: 'Perfil de dados',
            items: [
              '<strong>Qualidade da coluna</strong> — percentual de valores <strong>válidos</strong>, com <strong>erro</strong> e <strong>vazios</strong> em cada coluna.',
              '<strong>Distribuição da coluna</strong> — mini gráfico com contagem de valores <strong>distintos</strong> e <strong>únicos</strong>. Se distintos = total de linhas, a coluna pode ser chave; se não, há repetição.',
              '<strong>Perfil da coluna</strong> — estatísticas (mínimo, máximo, média, nulos, zeros) e distribuição de valores de uma coluna.',
              '<strong>Atenção</strong>: por padrão o perfil é calculado sobre as <strong>primeiras 1.000 linhas</strong>. Para avaliar a tabela inteira, clique no aviso da barra de status e mude para “com base em todo o conjunto de dados”.'
            ],
            img: { src: `${FAB_IMG}/m05/perfil-qualidade.png`, alt: 'Ferramentas de perfil de dados ativadas', caption: 'Qualidade e distribuição de coluna acima de cada cabeçalho, e o perfil da coluna selecionada embaixo.', source: 'https://learn.microsoft.com/pt-br/power-query/data-profiling-tools' } },
          { h: 'Duplicados',
            items: [
              '<strong>Remover duplicatas</strong> — sobre as colunas selecionadas; mantém a primeira ocorrência. Selecionando todas as colunas, remove linhas totalmente iguais; selecionando só a chave, garante uma linha por chave.',
              '<strong>Manter duplicatas</strong> — mostra só as linhas repetidas, para investigar antes de apagar.',
              '<strong>O Power Query diferencia maiúsculas de minúsculas</strong>: “ABC” e “abc” não são duplicados. Padronize antes (Maiúsculas/Minúsculas, Aparar, Limpar) e só então remova.',
              'Qual ocorrência manter? Ordene antes (por exemplo, data de alteração decrescente) para que a primeira linha seja a mais recente.'
            ] },
          { h: 'Nulos e valores ausentes',
            items: [
              '<strong>Substituir valores</strong> — trocar <code>null</code> por 0, por “Não informado” ou por um valor padrão.',
              '<strong>Preencher para baixo / para cima</strong> — copia o último valor conhecido para as células vazias abaixo (típico de relatórios exportados em que a categoria só aparece na primeira linha do grupo).',
              '<strong>Remover linhas em branco</strong> ou filtrar nulos quando a linha não tem valor para a análise.',
              'Em dimensões, em vez de deixar a chave nula, use um membro <strong>Desconhecido</strong> (Módulo 03) — os fatos continuam somando e o relatório mostra o problema.',
              'Nulo não é zero: numa média, trocar nulo por zero muda o resultado. Decida com a área de negócio.'
            ] },
          { h: 'Erros de etapa e erros de célula',
            items: [
              '<strong>Erro de etapa</strong> — impede a consulta de carregar. Aparece numa faixa amarela com o motivo e a mensagem. Exemplos: <strong>DataSource.NotFound</strong> (fonte inacessível, caminho mudou ou falta credencial) e “a coluna da tabela não foi encontrada” (uma etapa cita uma coluna que mudou de nome na fonte).',
              '<strong>Formula.Firewall</strong> — ao combinar fontes com níveis de privacidade diferentes ou referências mal estruturadas entre consultas.',
              '<strong>Erro de célula</strong> — a consulta carrega, mas algumas células mostram Erro, geralmente por conversão de tipo (“NA” numa coluna numérica).',
              'Tratamento de erro de célula: <strong>Remover erros</strong> (tira as linhas), <strong>Substituir erros</strong> (por um valor fixo) ou <strong>Manter erros</strong> (isolar para investigar). Corrigir a causa, como o tipo ou a localidade, é sempre melhor.'
            ],
            img: { src: `${FAB_IMG}/m05/substituir-erros.png`, alt: 'Caixa de diálogo Substituir erros', caption: 'Substituir erros: troca o valor de erro das células da coluna por um valor fixo.', source: 'https://learn.microsoft.com/pt-br/power-query/dealing-with-errors' } },
          { h: 'Dados de chegada tardia',
            p: 'Um fato pode chegar antes da dimensão (venda de um cliente ainda não cadastrado) ou com data antiga depois que o período já foi carregado. As respostas vistas no Módulo 03 continuam valendo: membro Desconhecido ou inferido na dimensão, e janelas de carga incremental que olham alguns dias para trás. No Dataflow Gen2, a atualização incremental (próxima aula) reprocessa os períodos cujos dados mudaram.' },
          { h: 'Como isso cai na prova',
            items: [
              'Remover duplicatas não removeu “Joao” e “JOAO” → padronizar maiúsculas/minúsculas antes.',
              'Perfil mostra 0% de erros, mas a carga falha em conversão → o perfil só olhou as 1.000 primeiras linhas.',
              'Coluna de categoria vazia abaixo do primeiro item de cada grupo → preencher para baixo.',
              'Consulta parou de carregar depois que a fonte renomeou uma coluna → erro de etapa “coluna não encontrada”; ajustar a etapa que cita o nome antigo.'
            ] }
        ],
        recursos: [
          { t: 'Ferramentas de criação de perfil de dados', u: 'https://learn.microsoft.com/pt-br/power-query/data-profiling-tools' },
          { t: 'Trabalhando com valores duplicados', u: 'https://learn.microsoft.com/pt-br/power-query/working-with-duplicates' },
          { t: 'Substituir valores', u: 'https://learn.microsoft.com/pt-br/power-query/replace-values' },
          { t: 'Preencher valores em uma coluna', u: 'https://learn.microsoft.com/pt-br/power-query/fill-values-column' },
          { t: 'Lidando com erros no Power Query', u: 'https://learn.microsoft.com/pt-br/power-query/dealing-with-errors' }
        ]
      },
      {
        id: 'fab-dataflow-destinos', title: 'Destinos de dados e preparo (staging)',
        desc: 'Para onde o Dataflow Gen2 grava: destinos suportados, configurações automáticas e manuais, substituir ou acrescentar, esquema dinâmico ou fixo, e quando habilitar o preparo.',
        objetivos: [
          'Configurar o destino de dados de uma consulta',
          'Escolher entre configurações automáticas e manuais, substituir e acrescentar',
          'Explicar o que o preparo faz e quando desligá-lo'
        ],
        body: 'O destino de dados é o que transforma o dataflow numa peça de engenharia: o resultado vai para uma tabela no lakehouse, no warehouse ou em outro banco, pronto para notebooks, SQL e modelos semânticos.',
        content: [
          { h: 'Destinos suportados',
            p: 'Tabelas ou arquivos do lakehouse, warehouse, banco de dados SQL do Fabric, banco de dados KQL, Azure SQL, Azure Data Explorer, ADLS Gen2, arquivos no SharePoint (CSV e Excel), Snowflake e PostgreSQL. Cada consulta tabular pode ter o seu destino — no mesmo dataflow, uma consulta vai para o lakehouse e outra para o warehouse. Funções e listas não têm destino.',
            img: { src: `${FAB_IMG}/m05/destinos-suportados.png`, alt: 'Destinos de dados suportados pelo Dataflow Gen2', caption: 'Lista de destinos de dados ao configurar uma consulta.', source: `${LEARN}/data-factory/dataflows-gen2-overview` } },
          { h: 'Onde configurar',
            p: 'Pela faixa de opções (Adicionar destino de dados), pelo painel Configurações da consulta ou pelo ícone na exibição de diagrama. Você escolhe a conexão, depois <strong>nova tabela</strong> ou <strong>tabela existente</strong>. Uma tabela nova é recriada se alguém a excluir; uma tabela existente escolhida nunca é recriada pelo dataflow. No lakehouse, um seletor permite gravar em Tables ou em Files.',
            img: { src: `${FAB_IMG}/m05/destino-faixa.png`, alt: 'Faixa de opções com o botão de destino de dados', caption: 'Adicionar destino de dados pela faixa de opções da guia Página Inicial.', source: `${LEARN}/data-factory/dataflow-gen2-data-destinations-and-managed-settings` } },
          { h: 'Configurações automáticas',
            p: 'Ao criar uma tabela nova, as configurações automáticas vêm ligadas:',
            items: [
              'Método de atualização <strong>substituir</strong> — a tabela é esvaziada e recarregada a cada atualização.',
              '<strong>Mapeamento gerenciado</strong> — se você adicionar uma coluna ou mudar um tipo, o mapeamento se ajusta sozinho na republicação.',
              '<strong>Descartar e recriar a tabela</strong> a cada atualização — por isso relacionamentos ou medidas criados sobre a tabela podem ser perdidos.'
            ],
            img: { src: `${FAB_IMG}/m05/config-automaticas.png`, alt: 'Janela de configurações de destino com a opção automática', caption: 'Configurações automáticas: substituir, mapeamento gerenciado e recriação da tabela.', source: `${LEARN}/data-factory/dataflow-gen2-data-destinations-and-managed-settings` } },
          { h: 'Configurações manuais',
            items: [
              'Mapeamento coluna a coluna: mudar tipo de destino, excluir colunas.',
              '<strong>Substituir</strong> × <strong>Acrescentar</strong>: acrescentar soma as linhas novas às existentes (a maioria dos destinos aceita os dois; banco KQL e Azure Data Explorer não aceitam substituir).',
              '<strong>Esquema dinâmico</strong> (só com substituir) — permite mudar o esquema ao republicar; a tabela pode ser recriada.',
              '<strong>Esquema fixo</strong> — o esquema não muda; na atualização só as linhas são trocadas, e relacionamentos e medidas ficam intactos.',
              'No <strong>warehouse</strong>, só existe esquema fixo.',
              'Campos do destino aceitam o editor de expressões dinâmicas (texto + data/hora + parâmetros + variáveis do workspace).'
            ],
            img: { src: `${FAB_IMG}/m05/config-manuais.png`, alt: 'Janela de configurações de destino manuais', caption: 'Configurações manuais: método de atualização, opções de esquema e mapeamento de colunas.', source: `${LEARN}/data-factory/dataflow-gen2-data-destinations-and-managed-settings` } },
          { h: 'Preparo (staging)',
            p: 'Com o preparo habilitado na consulta, o dataflow primeiro grava o resultado em itens internos — <strong>DataflowsStagingLakehouse</strong> e <strong>DataflowsStagingWarehouse</strong>, que aparecem no workspace e não devem ser usados diretamente. As consultas seguintes que referenciam essa consulta passam a rodar sobre uma cópia consultável, e filtros, junções e agregações são executados pelo mecanismo SQL do Fabric. É o padrão “preparar uma vez, referenciar muitas vezes”.',
            items: [
              'Vale a pena quando uma consulta de origem alimenta várias outras, quando há junções e agregações pesadas ou quando a fonte é lenta e não faz dobragem.',
              'Desligue quando a transformação inteira já é executada na fonte, quando há uma única saída sem ramificações, ou para economizar: o preparo cobra armazenamento do OneLake e uma gravação extra.',
              'Para os itens seguintes (modelos semânticos, outros dataflows), leia do <strong>destino</strong> (lakehouse ou warehouse) em vez do conector Dataflows — evita os tempos limite intermitentes da API interna de preparo, que aparecem como o erro “A chave não correspondeu a nenhuma linha na tabela”.',
              'Um dataflow aceita até <strong>50 consultas</strong> com preparo ou destino configurado.'
            ],
            img: { src: `${FAB_IMG}/m05/habilitar-preparo.png`, alt: 'Menu da consulta com a opção Habilitar preparo', caption: 'Clique com o botão direito na consulta para ligar ou desligar Habilitar preparo.', source: `${LEARN}/data-factory/dataflow-gen2-data-destinations-and-managed-settings` } },
          { h: 'Como isso cai na prova',
            items: [
              'Medidas e relacionamentos somem depois de cada atualização → a tabela está sendo recriada; usar configurações manuais com esquema fixo.',
              'Guardar o histórico carregando só os dados novos a cada execução → método acrescentar.',
              'Modelo semântico falha às vezes lendo pelo conector Dataflows → gravar num destino e ler do lakehouse/warehouse.',
              'Uma consulta de origem usada por cinco outras, com junções pesadas → habilitar preparo nela.'
            ] }
        ],
        recursos: [
          { t: 'Destinos de dados e configurações gerenciadas', u: `${LEARN}/data-factory/dataflow-gen2-data-destinations-and-managed-settings` },
          { t: 'Dados em itens de preparo', u: `${LEARN}/data-factory/data-in-staging-items` }
        ]
      },
      {
        id: 'fab-dataflow-desempenho', title: 'Desempenho: dobragem de consultas, cópia rápida, atualização incremental e parâmetros',
        desc: 'Como fazer o dataflow rodar rápido e barato: dobragem de consultas e seus indicadores, cópia rápida para grandes volumes, atualização incremental por janela de tempo e parâmetros públicos.',
        objetivos: [
          'Ler os indicadores de dobragem e manter a consulta dobrável',
          'Saber quando e como usar a cópia rápida',
          'Configurar a atualização incremental do Dataflow Gen2',
          'Passar parâmetros para um dataflow a partir de um pipeline'
        ],
        body: 'Um dataflow lento quase sempre tem uma de três causas: trabalho que poderia ser feito pela fonte sendo feito pelo mecanismo do Power Query, grandes volumes passando pelo caminho errado, ou recarga completa de dados que não mudaram. Esta aula ataca as três.',
        content: [
          { h: 'Dobragem de consultas (query folding)',
            p: 'A dobragem traduz as etapas do Power Query para a linguagem da fonte (por exemplo, SQL) e deixa a fonte executar. Filtros, seleção de colunas, junções e agrupamentos numa fonte relacional costumam dobrar; algumas funções, como “Colocar Cada Palavra em Maiúscula”, nunca dobram. A partir da primeira etapa que não dobra, tudo o que vem depois é processado pelo mecanismo do Power Query, trazendo mais dados pela rede.',
            items: [
              '<strong>Indicadores de dobragem</strong> (só no Power Query Online) ao lado de cada etapa: dobrando, não dobrando, pode dobrar, opaco (não dá para saber) e sem plano de consulta.',
              'O indicador vale para a consulta <strong>até aquela etapa</strong>. “Não dobrando” não quer dizer que nada dobra — quer dizer que a partir dali não dobra mais.',
              'Coloque as etapas que dobram (filtros, remover colunas) <strong>antes</strong> das que não dobram.',
              '“Exibir consulta nativa” e o plano de consulta mostram o que foi enviado à fonte.'
            ],
            img: { src: `${FAB_IMG}/m05/dobra-indicadores.png`, alt: 'Indicadores de dobragem após adicionar uma etapa que não dobra', caption: 'Indicadores de dobragem: a etapa que coloca as palavras em maiúscula quebra a dobragem da consulta.', source: 'https://learn.microsoft.com/pt-br/power-query/step-folding-indicators' } },
          { h: 'Cópia rápida (fast copy)',
            items: [
              'Liga um mecanismo de ingestão mais potente (o mesmo da atividade Copiar) quando o volume passa de um limite. Você habilita em <strong>Opções → Escala</strong>; há também a opção de <strong>exigir</strong> cópia rápida numa consulta.',
              'Funciona com conectores como ADLS Gen2, Blob, Azure SQL, banco SQL do Fabric, Lakehouse, Warehouse, SQL Server local, Oracle, PostgreSQL e Snowflake; para arquivos, CSV ou Parquet a partir de 100 MB.',
              'Em fontes de arquivo, suporta só combinar arquivos, selecionar, renomear e remover colunas e alterar tipos; em fontes SQL, vale tudo o que entra na consulta nativa. Indicadores por etapa mostram o que é compatível.',
              'Grava direto só em <strong>lakehouse</strong>. Para outro destino ou transformação pesada, divida em duas consultas: uma que ingere com cópia rápida (preparada) e outra que a referencia e transforma com a computação SQL.',
              'Não suporta esquema fixo. Com gateway, exige versão 3000.214.2 ou posterior.'
            ],
            img: { src: `${FAB_IMG}/m05/copia-rapida-indicadores.png`, alt: 'Indicadores de cópia rápida no painel de etapas', caption: 'Indicadores de cópia rápida por etapa: verde (compatível), amarelo (pode ser) e vermelho (impede a cópia rápida).', source: `${LEARN}/data-factory/dataflows-gen2-fast-copy` } },
          { h: 'Atualização incremental',
            p: 'Em vez de recarregar tudo, o dataflow divide os dados em <strong>buckets</strong> (intervalos) pela coluna de data e só busca de novo os buckets que mudaram.',
            items: [
              '<strong>Coluna de data/hora para filtrar</strong> (DateTime, Date ou DateTimeZone).',
              '<strong>Extrair dados do passado</strong> — o tamanho da janela (x dias, semanas, meses…); é a carga inicial.',
              '<strong>Tamanho do bucket</strong> — menores processam menos dados por vez, com mais iterações.',
              '<strong>Coluna de detecção de alteração</strong> — se o valor máximo dela mudou num bucket, o bucket inteiro é buscado e <strong>substituído</strong> no destino; se não mudou, é ignorado.',
              '<strong>Somente períodos concluídos</strong> (opcional) — não carrega o mês ou dia ainda em andamento.',
              '<strong>Exigir dobragem completa</strong> (avançado, recomendado ligado) — garante que o filtro de cada bucket rode na fonte.',
              'Destinos com suporte direto: lakehouse (com ressalvas extras), warehouse e Azure SQL. O destino precisa ser configurado explicitamente na consulta. Para outros destinos, prepare a consulta incremental e referencie-a numa segunda consulta. Fonte que faz dobragem é recomendada.'
            ],
            img: { src: `${FAB_IMG}/m05/incremental-config.png`, alt: 'Configurações de atualização incremental', caption: 'Configurações de atualização incremental: coluna de data, janela do passado, tamanho do bucket e coluna de alteração.', source: `${LEARN}/data-factory/dataflow-gen2-incremental-refresh` } },
          { h: 'Parâmetros públicos',
            items: [
              'Parâmetros definidos no Power Query (Gerenciar parâmetros) podem ser expostos: <strong>Opções → Parâmetros → “Habilitar parâmetros a serem descobertos e substituídos para execução”</strong>. Exige um Dataflow Gen2 com CI/CD.',
              'O pipeline passa os valores na atividade <strong>Fluxo de dados</strong>; também é possível pela API REST.',
              'Parâmetro <strong>obrigatório</strong> sem valor faz a execução falhar; <strong>opcional</strong> usa o valor atual.',
              'Dataflow com parâmetro obrigatório não pode ser agendado nem atualizado manualmente pelo Fabric — só por pipeline ou API.',
              'Parâmetros não mudam o caminho da fonte ou do destino: as conexões ficam fixas.'
            ],
            img: { src: `${FAB_IMG}/m05/atividade-dataflow-parametros.png`, alt: 'Atividade de fluxo de dados com parâmetros', caption: 'Atividade Fluxo de dados no pipeline passando valores para os parâmetros do dataflow.', source: `${LEARN}/data-factory/dataflow-parameters` } },
          { h: 'Como isso cai na prova',
            items: [
              'Filtro de data aplicado depois de uma coluna personalizada e a carga ficou lenta → mover o filtro para antes, mantendo a dobragem.',
              'Terabytes de Parquet no ADLS para o lakehouse via dataflow → cópia rápida.',
              'Tabela de vendas grande, só os últimos dias mudam → atualização incremental com bucket diário e “somente períodos concluídos”.',
              'Mesmo dataflow para várias filiais, escolhida pelo pipeline → parâmetro público passado pela atividade Fluxo de dados.'
            ] }
        ],
        recursos: [
          { t: 'Dobragem de consultas no Power Query', u: 'https://learn.microsoft.com/pt-br/power-query/query-folding-basics' },
          { t: 'Indicadores de dobragem', u: 'https://learn.microsoft.com/pt-br/power-query/step-folding-indicators' },
          { t: 'Cópia rápida no Dataflow Gen2', u: `${LEARN}/data-factory/dataflows-gen2-fast-copy` },
          { t: 'Atualização incremental no Dataflow Gen2', u: `${LEARN}/data-factory/dataflow-gen2-incremental-refresh` },
          { t: 'Parâmetros públicos no Dataflow Gen2', u: `${LEARN}/data-factory/dataflow-parameters` }
        ]
      },
      {
        id: 'fab-editor-consultas-visuais', title: 'Editor de consultas visuais no warehouse',
        desc: 'Selecionar, filtrar, agregar e juntar tabelas sem escrever SQL, no warehouse, no ponto de extremidade de análise SQL e em bancos espelhados — e transformar o resultado em exibição ou tabela.',
        objetivos: [
          'Criar uma consulta visual e ver o T-SQL gerado',
          'Salvar a consulta como exibição ou como tabela',
          'Conhecer as limitações do editor visual'
        ],
        body: 'A DP-600 tem uma habilidade com esse nome exato: “Selecionar, filtrar e agregar dados usando o editor de consultas visuais”. O editor usa a mesma interface do Power Query, mas em vez de rodar num dataflow ele gera T-SQL e roda no mecanismo SQL do Fabric.',
        content: [
          { h: 'Onde fica',
            p: 'No warehouse, no ponto de extremidade de análise SQL do lakehouse ou num banco espelhado, use <strong>Nova consulta visual</strong> na faixa de opções. Arraste tabelas do explorador para a tela e aplique etapas: escolher colunas, filtrar, classificar, agrupar por, mesclar consultas. A visualização dos resultados aparece embaixo.',
            img: { src: `${FAB_IMG}/m05/nova-consulta-visual.png`, alt: 'Menu Nova consulta visual', caption: 'Nova consulta visual, a partir da faixa de opções do warehouse.', source: `${LEARN}/data-warehouse/visual-query-editor` } },
          { h: 'Ver e editar o SQL',
            p: '<strong>Exibir SQL</strong> mostra o T-SQL equivalente às etapas; <strong>Editar script SQL</strong> abre esse código no editor de consultas SQL para continuar à mão. É uma ótima forma de aprender SQL a partir do que você já sabe fazer no Power Query. Quando há mesclagem, a consulta com <strong>Habilitar carregamento</strong> marcada é a que aparece no script.' },
          { h: 'Salvar o resultado',
            items: [
              '<strong>Salvar como exibição</strong> — cria uma view num esquema em que você tem permissão; a lógica fica guardada e é recalculada a cada consulta.',
              '<strong>Salvar como tabela</strong> — grava o resultado numa tabela de um warehouse (materializa os dados naquele momento).',
              'Nos resultados, também dá para baixar um arquivo do Excel ou usar Visualizar resultados para montar um relatório.'
            ],
            img: { src: `${FAB_IMG}/m05/salvar-como-exibicao.png`, alt: 'Menu Salvar como exibição no editor de consultas visuais', caption: 'Salvar como exibição: a consulta visual vira uma view no warehouse.', source: `${LEARN}/data-warehouse/visual-query-editor` } },
          { h: 'Consultas entre warehouses',
            p: 'Adicione outros warehouses ou pontos de extremidade SQL do mesmo workspace ao explorador e arraste tabelas de itens diferentes para a mesma consulta, juntando-as com mesclar.',
            img: { src: `${FAB_IMG}/m05/consulta-entre-warehouses.png`, alt: 'Consulta visual entre warehouses', caption: 'Consulta visual juntando uma tabela do warehouse de vendas com outra do warehouse de marketing.', source: `${LEARN}/data-warehouse/visual-query-editor` } },
          { h: 'Limitações',
            items: [
              'Só consultas de leitura (SELECT). Nada de DDL (CREATE, ALTER) ou DML (INSERT, UPDATE, DELETE) — para isso, use o editor SQL.',
              'Só um subconjunto das operações do Power Query — as que podem ser dobradas para SQL.',
              'A visualização de resultados não aceita consultas com ORDER BY.'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              'Analista sem SQL precisa filtrar e agregar dados do warehouse → editor de consultas visuais.',
              'Reaproveitar a lógica da consulta visual em relatórios → salvar como exibição.',
              'Precisa inserir ou atualizar linhas → não é o editor visual; é T-SQL (Módulo 07).'
            ] }
        ],
        recursos: [
          { t: 'Consultar usando o editor de consultas visuais', u: `${LEARN}/data-warehouse/visual-query-editor` }
        ]
      },
      {
        id: 'fab-dataflow-monitorar-erros', title: 'Monitorar e resolver erros do Dataflow Gen2',
        desc: 'Histórico de atualizações, detalhes por tabela e atividade, logs detalhados, hub de Monitoramento e os erros mais comuns do Dataflow Gen2 com suas soluções.',
        objetivos: [
          'Investigar uma atualização pelo histórico e pelos detalhes',
          'Diferenciar falha de atualização de falha de publicação',
          'Resolver os erros mais comuns do Dataflow Gen2'
        ],
        body: 'Cobre “Monitorar a transformação de dados” e “Identificar e resolver erros do Dataflow Gen2” da DP-700. O caminho é sempre o mesmo: descobrir onde falhou (qual consulta, qual etapa, fonte ou destino) e ler a mensagem com atenção.',
        content: [
          { h: 'Histórico de atualizações',
            items: [
              'No menu do dataflow, em <strong>Execuções recentes</strong>: lista com início, duração, tipo (sob demanda ou agendada) e status de cada atualização.',
              'Clique no horário de início para ver os <strong>detalhes</strong>: status geral e, por tabela, o que foi processado, as linhas gravadas e a mensagem de erro; e por atividade (leitura da fonte, gravação no destino).',
              'Dá para baixar um <strong>CSV</strong> com as execuções e os <strong>logs detalhados</strong> do mecanismo de mashup do Power Query (um ZIP com arquivos de log em JSON Lines), úteis para investigar lentidão ou mandar ao suporte — revise antes de compartilhar, pois podem conter expressões e endereços.'
            ],
            img: { src: `${FAB_IMG}/m05/detalhes-atualizacao.png`, alt: 'Detalhes de uma atualização do fluxo de dados', caption: 'Detalhes de uma atualização: status, duração e o resultado de cada tabela.', source: `${LEARN}/data-factory/dataflows-gen2-monitor` } },
          { h: 'Status no workspace e hub de Monitoramento',
            p: 'A coluna <strong>Status</strong> do workspace mostra a última atualização e se a última alteração foi salva e validada. Se a falha foi de <strong>atualização</strong>, investigue no histórico; se foi de <strong>publicação/validação</strong>, abra o dataflow no editor e valide de novo. O <strong>hub de Monitoramento</strong> reúne as execuções de dataflows, pipelines e notebooks de todos os workspaces, com filtros.',
            img: { src: `${FAB_IMG}/m05/historico-atualizacao.png`, alt: 'Menu do fluxo de dados com o histórico de atualização', caption: 'Abrindo o histórico de atualizações pelo menu do dataflow no workspace.', source: `${LEARN}/data-factory/dataflows-gen2-monitor` } },
          { h: 'Erros comuns e o que fazer',
            items: [
              '<strong>Credenciais ou conexão</strong> — senha expirada, gateway desligado, quem atualiza não tem acesso à conexão. Corrija em Gerenciar conexões e gateways e garanta que o usuário seja Membro do workspace.',
              '<strong>Coluna não encontrada / esquema mudou</strong> — a fonte mudou; ajuste a etapa. Se o destino tem esquema fixo, atualize o mapeamento.',
              '<strong>Erro de conversão de tipo</strong> — valores fora do padrão numa coluna tipada; trate com tipo e localidade corretos ou substitua os erros.',
              '<strong>Permissões insuficientes para artefatos de preparo</strong> — o usuário que criou o primeiro dataflow do workspace deixou a organização ou não entra no Fabric há mais de 90 dias; é preciso restabelecer o acesso aos itens de preparo (orientação na página de atualização do Learn).',
              '<strong>“A chave não correspondeu a nenhuma linha na tabela”</strong> ao consumir pelo conector Dataflows — tempo limite da API interna de preparo; grave num destino e leia do lakehouse/warehouse.',
              '<strong>Limites</strong> — mais de 300 atualizações em 24 horas ou mais de 50 consultas com preparo/destino.',
              '<strong>Atualização cancelada ou com falha</strong> — em consulta de preparo, continuam valendo os dados da última atualização bem-sucedida; em destino, pode ficar gravado o que foi escrito até o ponto do cancelamento. Planeje cargas reexecutáveis.'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              'Dataflow falha só quando roda agendado, mas funciona para o autor → credenciais/permissão de quem atualiza ou da conexão.',
              'Onde ver quantas linhas foram gravadas em cada tabela → detalhes da atualização no histórico.',
              'Status mostra falha de validação logo após salvar → abrir no editor e corrigir a consulta antes de publicar de novo.'
            ] }
        ],
        recursos: [
          { t: 'Histórico de atualização e monitoramento de fluxos de dados', u: `${LEARN}/data-factory/dataflows-gen2-monitor` },
          { t: 'Logs detalhados de atualização', u: `${LEARN}/data-factory/dataflow-gen2-detailed-refresh-logs` },
          { t: 'Atualização do fluxo de dados (limitações)', u: `${LEARN}/data-factory/dataflow-gen2-refresh` },
          { t: 'Limitações do Data Factory', u: `${LEARN}/data-factory/data-factory-limitations` }
        ]
      }
    ]
  },
  {
    id: 'fab-m06', title: 'Módulo 06 · Notebooks, Spark e streaming estruturado', kind: 'video',
    lessons: [
      {
        id: 'fab-spark-notebooks', title: 'Spark no Fabric e o notebook',
        desc: 'Como o Spark roda no Fabric (pools, nós, sessões, runtime), o que é um notebook, as linguagens e comandos mágicos, o lakehouse padrão e a diferença entre notebook Spark e notebook Python.',
        objetivos: [
          'Explicar driver, executores, pool inicial e pool personalizado',
          'Usar várias linguagens num notebook com comandos mágicos',
          'Anexar lakehouses e entender o lakehouse padrão',
          'Escolher entre notebook PySpark e notebook Python puro'
        ],
        body: 'O Apache Spark é o motor de processamento distribuído da engenharia de dados do Fabric: ele divide o trabalho entre várias máquinas e processa volumes que não caberiam num computador. O notebook é a forma mais comum de escrever código Spark. Esta aula dá a base para as habilidades DP-700 “Transformar dados usando PySpark, SQL e KQL” e “Otimizar o desempenho do Spark”.',
        content: [
          { h: 'Como o Spark roda no Fabric',
            items: [
              'Um cluster Spark tem um <strong>driver</strong> (coordena o trabalho) e <strong>executores</strong> (fazem o processamento). No Fabric, cada nó tem um executor; um nó fica com o driver e os demais com os executores. Um pool pode ter um único nó, com driver e executor juntos, para cargas pequenas.',
              '<strong>Pool inicial</strong> — clusters de nós médios mantidos prontos: a sessão começa em cerca de 5 a 10 segundos, sem configurar nada. Bibliotecas extras ou propriedades personalizadas aumentam esse tempo.',
              '<strong>Pool personalizado</strong> — você escolhe tamanho do nó (de Pequeno, 4 vCores/32 GB, a XX-Grande, 64 vCores/512 GB), escala automática e alocação dinâmica de executores. Criado pelo administrador do workspace, se o administrador da capacidade permitir.',
              '<strong>Sessão</strong> — expira após um tempo sem uso (padrão de 20 minutos, ajustável).',
              'A configuração dos pools, ambientes e alta simultaneidade no workspace foi vista no Módulo 01.'
            ],
            img: { src: `${FAB_IMG}/m06/computacao-spark.png`, alt: 'Plataforma de computação Spark com pools iniciais e personalizados', caption: 'A computação Spark do Fabric: pools iniciais (prontos, nós médios) e pools personalizados (dimensionados por você).', source: `${LEARN}/data-engineering/spark-compute` } },
          { h: 'Runtime',
            p: 'O <strong>Fabric Runtime</strong> reúne as versões de Apache Spark, Delta Lake, Python, Java/Scala e R, além de bibliotecas pré-instaladas e dezenas de otimizações próprias da Microsoft. Mais de um runtime fica disponível ao mesmo tempo; você escolhe o runtime no ambiente ou nas configurações do workspace. Ao trocar de runtime, confira se as bibliotecas e configurações continuam compatíveis.' },
          { h: 'O notebook',
            items: [
              'Células de <strong>código</strong> e de <strong>texto</strong> (Markdown), executadas uma a uma ou todas (Executar tudo). Salva automaticamente e pode ser editado por várias pessoas ao mesmo tempo.',
              'Quatro linguagens Spark: <strong>PySpark</strong> (Python), <strong>Spark</strong> (Scala), <strong>Spark SQL</strong> e <strong>SparkR</strong>. A linguagem principal vale para as células novas.',
              'Numa célula, um <strong>comando mágico</strong> muda a linguagem: <code>%%pyspark</code>, <code>%%spark</code>, <code>%%sql</code>, <code>%%sparkr</code>. Também existem <code>%run</code> (executar outro notebook), <code>%pip</code> (instalar biblioteca na sessão) e <code>%%configure</code> (configurar a sessão).',
              'Importa e exporta arquivos <strong>.ipynb</strong> (Jupyter) e .py.',
              'Gerenciador de variáveis, histórico de versões, comentários por célula e o <strong>Copilot</strong>, que gera, explica e corrige código.'
            ],
            img: { src: `${FAB_IMG}/m06/comando-magico.png`, alt: 'Comando mágico de linguagem numa célula', caption: 'Um comando mágico no início da célula define a linguagem daquela célula.', source: `${LEARN}/data-engineering/author-execute-notebook` } },
          { h: 'Lakehouse padrão',
            p: 'No explorador à esquerda do notebook você adiciona um ou mais lakehouses. Um deles é o <strong>padrão</strong>: é ele que o Spark usa quando você cita uma tabela só pelo nome (<code>spark.sql(\'SELECT * FROM vendas\')</code>) ou um caminho relativo como <code>Files/brutos/</code>. Clicando com o botão direito num arquivo ou tabela, o Fabric gera o código de leitura para você.',
            img: { src: `${FAB_IMG}/m06/lakehouse-padrao.png`, alt: 'Fixar um lakehouse como padrão no notebook', caption: 'Explorador do notebook: escolha qual lakehouse é o padrão.', source: `${LEARN}/data-engineering/how-to-use-notebook` } },
          { h: 'Notebook Spark ou notebook Python',
            p: 'Além do notebook Spark, existe o <strong>notebook Python</strong>: um kernel Python simples (sem cluster Spark), que inicia mais rápido e consome menos capacidade. Serve para volumes pequenos, bibliotecas como pandas e Polars, chamadas de API e automações. Para processar grandes volumes em paralelo, use o notebook Spark (PySpark).' },
          { h: 'Quem é o dono da execução',
            items: [
              '<strong>Execução interativa</strong> — roda com a identidade de quem clicou.',
              '<strong>Atividade de pipeline</strong> — roda com a identidade do <strong>último usuário que modificou o pipeline</strong>.',
              '<strong>Agendamento do notebook</strong> — roda com a identidade de quem criou ou atualizou o agendamento por último.',
              'Isso explica o clássico “funciona para mim, falha no agendamento”: a outra identidade não tem acesso ao dado.'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              'Sessões demoram a iniciar porque o ambiente instala muitas bibliotecas → é esperado; o início em segundos vale para o pool inicial sem personalizações.',
              'Célula SQL dentro de um notebook PySpark → <code>%%sql</code>.',
              'Tabela citada sem o nome do lakehouse não é encontrada → conferir o lakehouse padrão.',
              'Tarefa pequena de API/pandas que não precisa de cluster → notebook Python.'
            ] }
        ],
        recursos: [
          { t: 'Visão geral da computação Spark no Fabric', u: `${LEARN}/data-engineering/spark-compute` },
          { t: 'Runtimes do Apache Spark no Fabric', u: `${LEARN}/data-engineering/runtime` },
          { t: 'Como usar notebooks', u: `${LEARN}/data-engineering/how-to-use-notebook` },
          { t: 'Desenvolver, executar e gerenciar notebooks', u: `${LEARN}/data-engineering/author-execute-notebook` },
          { t: 'Notebooks Python', u: `${LEARN}/data-engineering/using-python-experience-on-notebook` }
        ]
      },
      {
        id: 'fab-pyspark-transformar', title: 'Transformar dados com PySpark e Spark SQL',
        desc: 'DataFrames na prática: ler arquivos e tabelas, selecionar, filtrar, criar colunas, juntar, agrupar e agregar, e gravar tabelas Delta — em PySpark e em Spark SQL.',
        objetivos: [
          'Ler CSV, Parquet e tabelas Delta num DataFrame',
          'Aplicar select, filter, withColumn, join e groupBy',
          'Gravar tabelas Delta com os modos corretos',
          'Fazer o mesmo em Spark SQL'
        ],
        body: 'Esta é a aula mais “mão na massa” do módulo e cobre as habilidades DP-700 “Transformar dados usando PySpark, SQL e KQL”, “Desnormalizar dados” e “Agrupar e agregar dados”. A prova mostra trechos de código e pergunta o que falta ou o que ele faz — entender a lógica vale mais do que decorar sintaxe.',
        content: [
          { h: 'DataFrame e avaliação preguiçosa',
            p: 'Um <strong>DataFrame</strong> é uma tabela distribuída entre os executores. As <strong>transformações</strong> (select, filter, join, groupBy) só montam um plano; nada é processado até uma <strong>ação</strong> — mostrar (<code>display</code>, <code>show</code>), contar (<code>count</code>) ou gravar (<code>write</code>). Isso permite ao Spark otimizar o plano inteiro antes de executar.' },
          { h: 'Ler dados',
            items: [
              'Arquivo CSV da área Files, com cabeçalho e inferência de tipos (ou, melhor, um esquema definido).',
              'Parquet e JSON: <code>spark.read.parquet</code>, <code>spark.read.json</code>.',
              'Tabela Delta do lakehouse: <code>spark.read.table</code> ou <code>spark.sql</code>.'
            ],
            code: `df = (spark.read
      .option("header", True)
      .option("inferSchema", True)
      .csv("Files/brutos/vendas/*.csv"))

clientes = spark.read.table("clientes")      # tabela Delta do lakehouse padrão
display(df.limit(10))` },
          { h: 'Transformar',
            items: [
              '<strong>select</strong> escolhe colunas; <strong>filter</strong> (ou where) filtra linhas; <strong>withColumn</strong> cria ou substitui coluna; <strong>withColumnRenamed</strong> renomeia; <strong>cast</strong> converte tipo; <strong>drop</strong> remove coluna.',
              '<strong>join</strong> com os tipos inner, left, right, full, left_semi e left_anti — os mesmos conceitos da mesclagem do Power Query.',
              '<strong>union</strong>/<strong>unionByName</strong> empilham DataFrames (acrescentar).',
              '<strong>groupBy</strong> + <strong>agg</strong> agrupam e agregam (sum, avg, count, countDistinct, min, max).'
            ],
            code: `from pyspark.sql import functions as F

vendas = (df
    .filter(F.col("Status") == "Faturado")
    .withColumn("Receita", F.col("Quantidade") * F.col("PrecoUnitario"))
    .withColumn("DataVenda", F.to_date("DataVenda", "dd/MM/yyyy"))
    .join(clientes.select("ClienteID", "Cidade", "UF"), on="ClienteID", how="left"))

resumo = (vendas
    .groupBy("UF", F.year("DataVenda").alias("Ano"))
    .agg(F.sum("Receita").alias("ReceitaTotal"),
         F.countDistinct("ClienteID").alias("Clientes")))` },
          { h: 'Gravar tabelas Delta',
            items: [
              '<code>saveAsTable</code> cria uma tabela <strong>gerenciada</strong> na área Tables do lakehouse — aparece no ponto de extremidade SQL e pode ser usada no Direct Lake.',
              'Modos: <strong>overwrite</strong> (substitui), <strong>append</strong> (acrescenta), <strong>error</strong>/errorifexists (padrão: falha se existir) e <strong>ignore</strong>.',
              '<code>partitionBy</code> particiona em pastas por coluna — só para tabelas grandes e colunas de cardinalidade baixa (ano, mês). Partições demais geram arquivos pequenos.',
              'Evite gravar com um caminho fora da área gerenciada: tabelas externas não aparecem no ponto de extremidade SQL (Módulo 03).'
            ],
            code: `(resumo.write
    .format("delta")
    .mode("overwrite")
    .saveAsTable("ouro_receita_uf_ano"))` },
          { h: 'O mesmo em Spark SQL',
            p: 'Tudo o que foi feito acima pode ser escrito em SQL numa célula <code>%%sql</code>, lendo e criando tabelas do lakehouse. Você também pode registrar um DataFrame como visão temporária com <code>createOrReplaceTempView</code> e consultá-lo em SQL.',
            code: `%%sql
CREATE OR REPLACE TABLE ouro_receita_uf_ano AS
SELECT c.UF, YEAR(v.DataVenda) AS Ano,
       SUM(v.Quantidade * v.PrecoUnitario) AS ReceitaTotal,
       COUNT(DISTINCT v.ClienteID) AS Clientes
FROM prata_vendas v
LEFT JOIN clientes c ON c.ClienteID = v.ClienteID
WHERE v.Status = 'Faturado'
GROUP BY c.UF, YEAR(v.DataVenda)` },
          { h: 'Desnormalizar e enriquecer',
            p: 'Para criar uma dimensão desnormalizada, junte as tabelas do sistema de origem (produto, subcategoria, categoria) com joins do tipo left e selecione as colunas descritivas. Para enriquecer, crie colunas derivadas (faixas, flags, partes de data) com <code>withColumn</code> e expressões condicionais <code>F.when</code>.' },
          { h: 'Como isso cai na prova',
            items: [
              'Código que termina sem ação (sem display, count ou write) → nada é processado.',
              'Tabela gravada não aparece no ponto de extremidade SQL → foi gravada como externa (caminho) em vez de saveAsTable.',
              'Encontrar pedidos sem cliente cadastrado → join left_anti.',
              'Acumular cargas diárias numa tabela → mode("append"); recriar a tabela ouro → mode("overwrite").'
            ] }
        ],
        recursos: [
          { t: 'Lakehouse e tabelas Delta', u: `${LEARN}/data-engineering/lakehouse-and-delta-tables` },
          { t: 'Carregar dados no lakehouse', u: `${LEARN}/data-engineering/load-data-lakehouse` },
          { t: 'Desenvolver, executar e gerenciar notebooks', u: `${LEARN}/data-engineering/author-execute-notebook` }
        ]
      },
      {
        id: 'fab-spark-qualidade-merge', title: 'Funções de janela, duplicados, nulos e MERGE no Spark',
        desc: 'Funções de janela para ranking e acumulados, remoção de duplicados, tratamento de nulos e a operação MERGE do Delta para cargas incrementais, SCD e dados de chegada tardia.',
        objetivos: [
          'Usar funções de janela (row_number, rank, lag, soma acumulada)',
          'Remover duplicados mantendo a versão mais recente',
          'Tratar valores nulos e ausentes em PySpark',
          'Fazer upsert com MERGE em tabelas Delta'
        ],
        body: 'Cobre “Criar funções de janela” (na parte de lote) e “Manipular dados duplicados, ausentes e de chegada tardia” da DP-700, agora em código. São padrões que aparecem em qualquer camada prata.',
        content: [
          { h: 'Funções de janela',
            p: 'Uma função de janela calcula um valor para cada linha olhando um grupo de linhas relacionadas, <strong>sem agrupar</strong> (as linhas continuam todas lá). A janela define a partição (<code>partitionBy</code>) e a ordem (<code>orderBy</code>).',
            items: [
              '<strong>row_number</strong> — numera as linhas da partição (1, 2, 3…) sem empate; base para deduplicar.',
              '<strong>rank</strong> e <strong>dense_rank</strong> — ranking com empates (rank pula posições, dense_rank não).',
              '<strong>lag</strong> e <strong>lead</strong> — valor da linha anterior ou seguinte (variação em relação ao mês anterior).',
              '<strong>sum/avg sobre a janela</strong> com <code>rowsBetween</code> — acumulados e médias móveis.'
            ],
            code: `from pyspark.sql import functions as F
from pyspark.sql.window import Window

w = Window.partitionBy("ClienteID").orderBy("DataVenda")
w_acum = w.rowsBetween(Window.unboundedPreceding, Window.currentRow)

vendas = (vendas
    .withColumn("NumeroCompra", F.row_number().over(w))
    .withColumn("ReceitaAnterior", F.lag("Receita").over(w))
    .withColumn("ReceitaAcumulada", F.sum("Receita").over(w_acum)))` },
          { h: 'Duplicados',
            items: [
              '<code>dropDuplicates()</code> sem argumentos remove linhas totalmente iguais; com uma lista de colunas, mantém uma linha por chave — mas <strong>qual</strong> linha fica não é garantido.',
              'Para manter a versão mais recente, numere com <strong>row_number</strong> ordenando pela data de alteração decrescente e fique com a linha 1.',
              'Como no Power Query, “abc” e “ABC” são valores diferentes: padronize (<code>F.upper</code>, <code>F.trim</code>) antes de comparar.'
            ],
            code: `w = Window.partitionBy("ClienteID").orderBy(F.col("AlteradoEm").desc())
clientes_unicos = (clientes
    .withColumn("rn", F.row_number().over(w))
    .filter("rn = 1")
    .drop("rn"))` },
          { h: 'Nulos e valores ausentes',
            items: [
              '<code>fillna</code> (ou <code>na.fill</code>) troca nulos por um valor padrão, por coluna.',
              '<code>dropna</code> remove linhas com nulos (em todas ou em colunas específicas).',
              '<code>F.coalesce</code> devolve o primeiro valor não nulo entre colunas (por exemplo, telefone celular ou fixo).',
              'Nulo em chave de dimensão → aponte para o membro Desconhecido (chave -1, por exemplo) em vez de descartar o fato.'
            ],
            code: `vendas = (vendas
    .fillna({"Desconto": 0, "Canal": "Não informado"})
    .withColumn("Contato", F.coalesce("Celular", "Telefone"))
    .dropna(subset=["DataVenda"]))` },
          { h: 'MERGE: upsert em tabelas Delta',
            p: 'O <strong>MERGE</strong> compara uma origem (as linhas novas ou alteradas) com a tabela de destino pela chave e, numa única transação, <strong>atualiza</strong> as que existem e <strong>insere</strong> as novas — pode também excluir. É a base da carga incremental na prata e do SCD tipo 1. Para SCD tipo 2, o MERGE encerra a versão atual (data fim, flag de atual) e as versões novas são inseridas.',
            code: `from delta.tables import DeltaTable

destino = DeltaTable.forName(spark, "prata_clientes")
(destino.alias("d")
    .merge(clientes_unicos.alias("o"), "d.ClienteID = o.ClienteID")
    .whenMatchedUpdateAll()
    .whenNotMatchedInsertAll()
    .execute())` },
          { h: 'O mesmo MERGE em Spark SQL',
            code: `%%sql
MERGE INTO prata_clientes AS d
USING novos_clientes AS o
  ON d.ClienteID = o.ClienteID
WHEN MATCHED THEN UPDATE SET *
WHEN NOT MATCHED THEN INSERT *` },
          { h: 'Dados de chegada tardia',
            items: [
              'Fato chegou antes da dimensão → gravar o fato com a chave do membro Desconhecido ou criar um <strong>membro inferido</strong> na dimensão (só a chave natural) e completá-lo depois com MERGE.',
              'Registro chegou com data antiga depois que o período foi carregado → a carga incremental precisa de uma janela que olhe alguns dias para trás, e o MERGE garante que reprocessar não duplica.',
              'Por isso o MERGE torna a carga <strong>idempotente</strong>: rodar de novo com os mesmos dados dá o mesmo resultado.'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              'Manter só o registro mais recente de cada cliente → row_number com orderBy decrescente, filtrar 1.',
              'Atualizar existentes e inserir novos numa só operação → MERGE (whenMatchedUpdate + whenNotMatchedInsert).',
              'Ranking de produtos por categoria sem perder as linhas → função de janela com partitionBy("Categoria").',
              'Carga reexecutada duplicou linhas → trocar append por MERGE pela chave.'
            ] }
        ],
        recursos: [
          { t: 'Lakehouse e tabelas Delta', u: `${LEARN}/data-engineering/lakehouse-and-delta-tables` },
          { t: 'Modelagem dimensional: carregar tabelas', u: `${LEARN}/data-warehouse/dimensional-modeling-load-tables` }
        ]
      },
      {
        id: 'fab-spark-orquestrar', title: 'Orquestrar notebooks: notebookutils, ambientes e definições de trabalho do Spark',
        desc: 'Encadear notebooks com %run, run e runMultiple, agendar, executar por pipeline, gerenciar bibliotecas no ambiente e quando usar uma definição de trabalho do Spark.',
        objetivos: [
          'Chamar notebooks de dentro de outro notebook',
          'Escolher entre agendar o notebook, usar pipeline ou runMultiple',
          'Gerenciar bibliotecas com ambientes e %pip',
          'Saber quando usar uma definição de trabalho do Spark'
        ],
        body: 'Continua a habilidade DP-700 “Implementar padrões de orquestração com notebooks e pipelines” do lado do código. O pipeline (Módulo 04) é o orquestrador padrão, mas muitos times preferem controlar a sequência dentro do próprio Spark.',
        content: [
          { h: 'NotebookUtils',
            p: 'O <strong>NotebookUtils</strong> (antigo MSSparkUtils) é o pacote embutido para tarefas comuns: sistema de arquivos (<code>notebookutils.fs</code>), segredos, variáveis de ambiente e encadeamento de notebooks. O nome antigo continua funcionando, mas o recomendado é <code>notebookutils</code>.',
            items: [
              '<code>%run NomeDoNotebook</code> — executa outro notebook <strong>na mesma sessão</strong>: funções e variáveis definidas lá ficam disponíveis aqui. Bom para bibliotecas de funções comuns.',
              '<code>notebookutils.notebook.run("Nome", timeout, parâmetros)</code> — executa outro notebook como filho, passando parâmetros, e recebe o valor devolvido por <code>notebookutils.notebook.exit</code>.',
              '<code>notebookutils.notebook.runMultiple</code> — executa vários notebooks em paralelo ou num DAG (grafo de dependências), com limite de simultaneidade e tempo limite; por padrão, o DAG inteiro tem limite de 12 horas.',
              'Célula de parâmetros + parâmetros base continuam valendo quando o notebook é chamado por pipeline (Módulo 04).'
            ],
            code: `# Dois notebooks em paralelo, depois o terceiro que depende deles
dag = {
  "activities": [
    {"name": "clientes", "path": "nb_prata_clientes"},
    {"name": "produtos", "path": "nb_prata_produtos"},
    {"name": "vendas",   "path": "nb_prata_vendas",
     "dependencies": ["clientes", "produtos"],
     "args": {"data_corte": "2026-09-01"}}
  ],
  "concurrency": 2
}
notebookutils.notebook.runMultiple(dag)` },
          { h: 'Formas de executar um notebook',
            items: [
              '<strong>Agendar o próprio notebook</strong> — simples, para uma execução periódica isolada.',
              '<strong>Pipeline</strong> — quando precisa de dependências com outras atividades (cópia, dataflow), gatilhos por evento, repetição e alertas.',
              '<strong>runMultiple</strong> — muitos notebooks em paralelo compartilhando a mesma sessão, com menos sobrecarga do que várias atividades de pipeline.',
              '<strong>API do Agendador de Trabalhos</strong> — execução por API, com parâmetros, entidade de serviço e escolha de ambiente, para CI/CD e automação.',
              'Trabalhos agendados ou disparados por pipeline entram numa <strong>fila</strong> quando a capacidade está no limite e são reprocessados automaticamente (a entrada expira em 24 horas). Execução interativa não entra na fila.'
            ] },
          { h: 'Ambientes e bibliotecas',
            items: [
              'O <strong>ambiente</strong> é o item que guarda runtime, propriedades Spark, pool e bibliotecas. Anexe-o ao notebook ou defina-o como padrão do workspace.',
              'Bibliotecas públicas (PyPI, Conda, Maven) e personalizadas (.whl, .py, .jar, .tar.gz).',
              'Modo de publicação <strong>Completo</strong>: resolve dependências e cria um instantâneo estável na publicação — para produção. Modo <strong>Rápido</strong>: instala na inicialização da sessão, só em notebooks — para iterar.',
              '<code>%pip install</code> numa célula instala só para aquela sessão: prático para testar, ruim para produção (repete a instalação a cada execução e pode falhar em pipeline).',
              'Depois de alterar um ambiente, é preciso <strong>publicar</strong> para as mudanças valerem.'
            ],
            img: { src: `${FAB_IMG}/m06/ambiente-no-notebook.png`, alt: 'Anexar um ambiente a um notebook', caption: 'Seletor de ambiente no notebook: runtime, bibliotecas e configurações vêm do ambiente anexado.', source: `${LEARN}/data-engineering/create-and-use-environment` } },
          { h: 'Definição de trabalho do Spark',
            p: 'A <strong>definição de trabalho do Spark</strong> (Spark Job Definition) executa um programa Spark não interativo a partir de um arquivo principal (.py, .jar ou .R) e de arquivos de referência, com um lakehouse padrão e argumentos de linha de comando. É indicada para código já empacotado, trabalhos em lote de produção e, principalmente, <strong>streaming contínuo</strong>, porque aceita uma <strong>política de repetição</strong> que reinicia o trabalho se ele parar.',
            img: { src: `${FAB_IMG}/m06/sjd-repeticao.png`, alt: 'Guia Otimização da definição de trabalho do Spark com a política de repetição', caption: 'Política de repetição da definição de trabalho do Spark, essencial para trabalhos de streaming.', source: `${LEARN}/data-engineering/get-started-streaming` } },
          { h: 'Como isso cai na prova',
            items: [
              'Reutilizar funções comuns em vários notebooks, na mesma sessão → <code>%run</code>.',
              'Executar dez notebooks de prata em paralelo, com dependências, a partir de um notebook mestre → <code>runMultiple</code> com DAG.',
              'Biblioteca estável para todos os notebooks de produção → ambiente com modo Completo, não <code>%pip</code>.',
              'Streaming que precisa rodar sem parar e se recuperar de falhas → definição de trabalho do Spark com política de repetição.'
            ] }
        ],
        recursos: [
          { t: 'NotebookUtils para o Fabric', u: `${LEARN}/data-engineering/notebook-utilities` },
          { t: 'Criar, configurar e usar um ambiente', u: `${LEARN}/data-engineering/create-and-use-environment` },
          { t: 'Gerenciar bibliotecas em ambientes', u: `${LEARN}/data-engineering/environment-manage-library` },
          { t: 'O que é uma definição de trabalho do Spark', u: `${LEARN}/data-engineering/spark-job-definition` },
          { t: 'Enfileiramento de trabalhos do Spark', u: `${LEARN}/data-engineering/job-queueing-for-fabric-spark` }
        ]
      },
      {
        id: 'fab-streaming-estruturado', title: 'Streaming estruturado do Spark',
        desc: 'Processar dados que chegam continuamente: readStream e writeStream, tabela Delta como destino, checkpoint, gatilhos, modos de saída, janelas de tempo e marca d’água.',
        objetivos: [
          'Explicar o modelo de tabela ilimitada do streaming estruturado',
          'Gravar um fluxo numa tabela Delta com checkpoint',
          'Escolher gatilho e modo de saída',
          'Agregar por janelas de tempo com marca d’água'
        ],
        body: 'Cobre “Processar dados usando o streaming estruturado do Spark”, “Criar funções de janela” (no streaming) e parte de “Projetar e implementar um padrão de carregamento para dados de streaming” da DP-700. O Eventstream e o KQL, a outra metade do streaming, vêm no Módulo 08.',
        content: [
          { h: 'O modelo',
            p: 'O streaming estruturado trata o fluxo como uma <strong>tabela que não para de crescer</strong>: cada evento novo é uma linha acrescentada. Você escreve a consulta quase como se fosse um DataFrame comum; o Spark a executa em <strong>microlotes</strong>, processando só o que chegou desde o lote anterior. Fontes comuns: arquivos que chegam numa pasta, Hubs de Eventos do Azure, Kafka e tabelas Delta.' },
          { h: 'Delta como destino e o checkpoint',
            items: [
              'Com <code>format("delta")</code> no writeStream, os eventos vão direto para uma tabela Delta do lakehouse, com transações ACID — consultável pelo SQL e pelo Power BI enquanto o fluxo roda.',
              'O <strong>checkpoint</strong> guarda até onde o fluxo já leu e o estado das agregações. É ele que permite reiniciar sem perder nem duplicar dados. Cada consulta de streaming precisa do seu próprio local de checkpoint.',
              'Uma tabela Delta também pode ser <strong>fonte</strong> de streaming: a prata lê a bronze de forma incremental.'
            ],
            code: `stream = (spark.readStream
    .format("delta")
    .table("bronze_eventos"))

(stream.filter("tipo = 'compra'")
    .writeStream
    .format("delta")
    .outputMode("append")
    .option("checkpointLocation", "Files/checkpoints/prata_compras")
    .trigger(processingTime="1 minute")
    .toTable("prata_compras"))` },
          { h: 'Gatilhos',
            items: [
              '<strong>Padrão</strong> — um microlote começa assim que o anterior termina.',
              '<strong>processingTime</strong> — um lote a cada intervalo (por exemplo, 1 minuto). Agrupar eventos em lotes maiores gera menos arquivos pequenos e melhora a gravação.',
              '<strong>availableNow</strong> — processa tudo o que está disponível agora e para. Permite rodar o streaming como carga incremental agendada, usando o checkpoint para saber de onde continuar.'
            ] },
          { h: 'Modos de saída',
            items: [
              '<strong>append</strong> — grava só as linhas novas; o padrão e o mais comum para Delta.',
              '<strong>update</strong> — grava as linhas cujo resultado mudou no lote.',
              '<strong>complete</strong> — regrava o resultado inteiro a cada lote; só para agregações pequenas.'
            ] },
          { h: 'Janelas de tempo e marca d’água',
            p: 'Para agregar eventos por período (vendas a cada 5 minutos), agrupe por <code>F.window</code> sobre a coluna de horário do <strong>evento</strong>. Janelas <strong>fixas</strong> (tumbling) não se sobrepõem; janelas <strong>deslizantes</strong> (sliding) se sobrepõem (janela de 10 minutos a cada 5). A <strong>marca d’água</strong> (<code>withWatermark</code>) diz quanto atraso o Spark vai tolerar: eventos que chegarem mais atrasados que o limite são descartados, e o estado das janelas antigas pode ser liberado. Sem marca d’água, o estado cresce indefinidamente.',
            code: `vendas_5min = (stream
    .withWatermark("horario_evento", "10 minutes")
    .groupBy(F.window("horario_evento", "5 minutes"), "loja")
    .agg(F.sum("valor").alias("total")))` },
          { h: 'Desempenho e produção',
            items: [
              '<strong>Gravação otimizada</strong> (optimize write) junta ou divide partições antes de gravar, evitando arquivos pequenos sem precisar de repartition manual.',
              '<code>partitionBy</code> só com colunas de cardinalidade adequada.',
              'Em produção, rode o streaming numa <strong>definição de trabalho do Spark</strong> com política de repetição, e não num notebook aberto.',
              'O hub de Monitoramento tem uma guia de Streaming Estruturado com taxa de entrada, taxa de processamento, linhas e duração dos lotes.',
              'O mecanismo de execução nativo ainda não acelera streaming estruturado — ele volta automaticamente ao motor padrão.'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              'Fluxo reiniciado reprocessou tudo ou perdeu eventos → checkpoint ausente, compartilhado ou apagado.',
              'Muitos arquivos pequenos na tabela de streaming → gatilho com intervalo maior e gravação otimizada; OPTIMIZE periódico.',
              'Processar só o que chegou desde a última execução, uma vez por hora → trigger availableNow agendado.',
              'Agregação por janela consumindo memória sem parar → falta withWatermark.',
              'Janelas de 5 minutos sem sobreposição → janela fixa (tumbling).'
            ] }
        ],
        recursos: [
          { t: 'Transmitir dados para o lakehouse com Spark', u: `${LEARN}/data-engineering/lakehouse-streaming-data` },
          { t: 'Início rápido: streaming no lakehouse com definição de trabalho do Spark', u: `${LEARN}/data-engineering/get-started-streaming` }
        ]
      },
      {
        id: 'fab-spark-monitorar-otimizar', title: 'Monitorar, depurar e otimizar o Spark',
        desc: 'Onde acompanhar os aplicativos Spark, como ler logs e o Spark Advisor, os erros mais comuns de notebook e as alavancas de desempenho: mecanismo de execução nativo, alta simultaneidade, autotune, particionamento e capacidade.',
        objetivos: [
          'Encontrar um aplicativo Spark e investigar seus trabalhos e logs',
          'Resolver erros comuns de notebook, incluindo o erro 430 de capacidade',
          'Aplicar as principais otimizações de desempenho do Spark'
        ],
        body: 'Cobre “Identificar e resolver erros de notebook”, “Monitorar a transformação de dados” e “Otimizar o desempenho do Spark” da DP-700.',
        content: [
          { h: 'Onde monitorar',
            items: [
              '<strong>No próprio notebook</strong> — abaixo de cada célula aparece o progresso dos trabalhos Spark, com estágios, tarefas e link para a interface do Spark.',
              '<strong>Hub de Monitoramento</strong> — todos os aplicativos Spark de notebooks, definições de trabalho e pipelines, com filtros.',
              '<strong>Execuções recentes</strong> do item e, nos pipelines, links diretos das atividades Notebook para o aplicativo Spark.',
              '<strong>Página de detalhes do aplicativo</strong> — guias Trabalhos (duração, dados lidos e gravados), Recursos (uso dos executores), Logs (driver, Livy), Dados (arquivos de entrada e saída) e Instantâneos do item (o código exatamente como rodou).',
              'A <strong>interface do Spark</strong> e o servidor de histórico mostram o plano de execução e os estágios em detalhe.'
            ],
            img: { src: `${FAB_IMG}/m06/progresso-spark.png`, alt: 'Detalhes do progresso dos trabalhos Spark no notebook', caption: 'Progresso dos trabalhos Spark logo abaixo da célula do notebook.', source: `${LEARN}/data-engineering/author-execute-notebook` } },
          { h: 'Spark Advisor e diagnóstico',
            p: 'O <strong>Spark Advisor</strong> analisa a execução e mostra recomendações e análise de erros no painel de Diagnóstico e na saída da célula — por exemplo, distorção de dados (skew), operação que caiu para o motor padrão ou configuração ineficiente. Nas falhas, “Corrigir com Copilot” resume o erro e sugere a correção.',
            img: { src: `${FAB_IMG}/m06/spark-diagnostico.png`, alt: 'Painel de diagnóstico do aplicativo Spark', caption: 'Painel de Diagnóstico: recomendações e análise de erros do Spark Advisor.', source: `${LEARN}/data-engineering/spark-detail-monitoring` } },
          { h: 'Erros comuns de notebook',
            items: [
              '<strong>Erro HTTP 430 (TooManyRequestsForCapacity)</strong> — a capacidade atingiu o limite de VCores Spark. Cancele sessões ativas no hub de Monitoramento, espere, use a fila (trabalhos em segundo plano) ou aumente a SKU.',
              '<strong>Tabela ou caminho não encontrado</strong> — lakehouse padrão errado ou ausente, ou nome de tabela sem o lakehouse correto.',
              '<strong>Falha só no agendamento/pipeline</strong> — a identidade da execução (dono do agendamento ou último editor do pipeline) não tem acesso.',
              '<strong>Falta de memória / executor perdido</strong> — <code>collect()</code> ou <code>toPandas()</code> de dados grandes no driver, junção explodindo linhas, partições distorcidas. Evite trazer tudo para o driver; aumente o nó ou corrija a lógica.',
              '<strong>Incompatibilidade de esquema ao gravar</strong> em tabela Delta existente — ajuste os tipos ou habilite a evolução de esquema de forma consciente.',
              '<strong>Biblioteca não encontrada</strong> — ambiente não publicado ou não anexado.'
            ],
            img: { src: `${FAB_IMG}/m06/spark-logs.png`, alt: 'Logs do aplicativo Spark', caption: 'Guia Logs do aplicativo Spark: driver, Livy e pré-lançamento.', source: `${LEARN}/data-engineering/spark-detail-monitoring` } },
          { h: 'Capacidade e simultaneidade',
            items: [
              'Cada CU da capacidade corresponde a 2 VCores Spark (F64 = 128 VCores), e o Fabric permite <strong>burst</strong> de até 3 vezes (F64 = até 384 VCores) para simultaneidade ou para um trabalho grande.',
              'A admissão é por VCores disponíveis; trabalhos em segundo plano entram em fila FIFO quando falta capacidade.',
              '<strong>Alta simultaneidade</strong> — vários notebooks do mesmo usuário compartilham uma sessão (padrão de até 5), e só o primeiro é cobrado. Nos pipelines, combine com a marca de sessão (Módulo 04).'
            ],
            img: { src: `${FAB_IMG}/m06/alta-simultaneidade.png`, alt: 'Modo de alta simultaneidade', caption: 'Alta simultaneidade: vários notebooks compartilham a mesma sessão Spark, dentro do limite de um usuário.', source: `${LEARN}/data-engineering/high-concurrency-overview` } },
          { h: 'Alavancas de desempenho',
            items: [
              '<strong>Mecanismo de execução nativo</strong> (Velox + Apache Gluten) — executa consultas em código nativo vetorizado, acelerando bastante leituras e agregações sobre Parquet e Delta. Habilitado no ambiente (Aceleração) ou por sessão com <code>%%configure</code>. Quando algo não é suportado (streaming, JSON, XML), cai automaticamente para o motor padrão.',
              '<strong>Autotune</strong> (versão prévia, desligado por padrão) — ajusta por consulta partições de shuffle, limite de broadcast join e tamanho máximo de partição de arquivo, aprendendo com execuções anteriores.',
              '<strong>Arquivos</strong> — tabela com arquivos pequenos demais ou partições demais é lenta: OPTIMIZE, gravação otimizada e V-Order onde a leitura domina (Módulo 03).',
              '<strong>Junções</strong> — tabela pequena? Broadcast join evita embaralhar a tabela grande. Filtre e selecione colunas antes de juntar.',
              '<strong>Cache</strong> (<code>df.cache()</code>) só para DataFrames reutilizados várias vezes na mesma sessão.',
              '<strong>Pool</strong> — nós maiores para trabalhos pesados em memória; pool inicial para iniciar rápido.'
            ],
            img: { src: `${FAB_IMG}/m06/nee-habilitar.png`, alt: 'Habilitar o mecanismo de execução nativo no ambiente', caption: 'Ambiente → Aceleração: ligar o mecanismo de execução nativo para todos os notebooks e trabalhos que usam o ambiente.', source: `${LEARN}/data-engineering/native-execution-engine-overview` } },
          { h: 'Como isso cai na prova',
            items: [
              'Notebooks agendados falham com 430 nos horários de pico → capacidade no limite: escalonar horários, cancelar sessões ociosas, usar alta simultaneidade ou aumentar a SKU.',
              'Consultas de agregação sobre Delta lentas, sem mudar código → habilitar o mecanismo de execução nativo no ambiente.',
              'Onde ver o código exato que rodou num trabalho que falhou ontem → Instantâneos do item nos detalhes do aplicativo.',
              'Junção de uma fato enorme com uma dimensão pequena lenta → broadcast da dimensão.'
            ] }
        ],
        recursos: [
          { t: 'Visão geral do monitoramento do Spark', u: `${LEARN}/data-engineering/spark-monitoring-overview` },
          { t: 'Monitoramento de detalhes do aplicativo Spark', u: `${LEARN}/data-engineering/spark-detail-monitoring` },
          { t: 'Limites de simultaneidade e enfileiramento', u: `${LEARN}/data-engineering/spark-job-concurrency-and-queueing` },
          { t: 'Modo de alta simultaneidade', u: `${LEARN}/data-engineering/high-concurrency-overview` },
          { t: 'Mecanismo de execução nativo', u: `${LEARN}/data-engineering/native-execution-engine-overview` },
          { t: 'Autotune', u: `${LEARN}/data-engineering/autotune` }
        ]
      }
    ]
  },
  {
    id: 'fab-m07', title: 'Módulo 07 · Data Warehouse e T-SQL', kind: 'video',
    lessons: [
      {
        id: 'fab-warehouse-visao', title: 'O warehouse do Fabric: tabelas, tipos e limitações',
        desc: 'O que é o Fabric Data Warehouse, como ele se diferencia do ponto de extremidade de análise SQL e do lakehouse, e as regras de tabelas, tipos de dados, chaves, IDENTITY e ordenação.',
        objetivos: [
          'Diferenciar warehouse, ponto de extremidade de análise SQL e lakehouse',
          'Criar esquemas e tabelas com tipos de dados suportados',
          'Usar chaves NOT ENFORCED e colunas IDENTITY corretamente',
          'Conhecer os recursos de T-SQL que não existem no warehouse'
        ],
        body: 'O warehouse é o armazenamento relacional do Fabric, programado em T-SQL, com suporte completo a transações. Ele grava os dados como tabelas Delta no OneLake — o mesmo formato aberto do lakehouse — e divide o mesmo mecanismo SQL com o ponto de extremidade de análise. Esta aula prepara o terreno para as habilidades DP-600 de SQL e para “Otimizar um data warehouse” da DP-700.',
        content: [
          { h: 'Warehouse × ponto de extremidade de análise SQL × lakehouse',
            items: [
              '<strong>Warehouse</strong> — leitura e escrita em T-SQL: DDL (CREATE, ALTER, DROP) e DML (INSERT, UPDATE, DELETE, MERGE), transações com várias tabelas. Ideal para esquemas estrela, data marts corporativos e equipes que dominam SQL.',
              '<strong>Ponto de extremidade de análise SQL</strong> — criado automaticamente com cada lakehouse (e com bancos espelhados). Consulta as tabelas Delta do lakehouse em T-SQL, <strong>só leitura</strong> de dados; mas aceita criar exibições, funções, procedimentos e segurança em nível de objeto, linha e coluna.',
              '<strong>Lakehouse</strong> — escrito principalmente com Spark; guarda qualquer arquivo (estruturado ou não) além de tabelas.',
              'Todos gravam Delta no OneLake: um warehouse pode ler tabelas do lakehouse com consultas entre bancos, sem copiar dados.'
            ],
            img: { src: `${FAB_IMG}/m07/lakehouse-ou-warehouse.png`, alt: 'Árvores de decisão para escolher lakehouse ou warehouse', caption: 'Guia de decisão oficial: desenvolvimento em Spark e dados variados apontam para lakehouse; T-SQL e transações com várias tabelas, para warehouse.', source: `${LEARN}/fundamentals/decision-guide-lakehouse-warehouse` } },
          { h: 'Esquemas e tabelas',
            items: [
              'Organize com esquemas (<code>CREATE SCHEMA vendas</code>) e prefixos que indiquem o papel da tabela: <strong>dim</strong>, <strong>fact</strong>, <strong>int</strong> (integração/preparo).',
              'Crie tabelas vazias com CREATE TABLE ou já com dados, com CREATE TABLE AS SELECT (próxima aula).',
              'Renomear coluna: <code>sp_rename</code>. ALTER TABLE aceita adicionar coluna anulável, remover coluna e adicionar/remover restrições; ALTER COLUMN está em versão prévia.',
              '<strong>TRUNCATE TABLE</strong> é suportado.',
              'Tabelas temporárias <strong>#temp</strong> com escopo de sessão existem; globais (##) não.'
            ] },
          { h: 'Tipos de dados',
            p: 'O warehouse aceita um subconjunto dos tipos do SQL Server, porque tudo vira Parquet. Suportados: bit, smallint, int, bigint, decimal/numeric, float, real, date, time e datetime2 (até 6 casas de fração de segundo), char, varchar (varchar(max) até 16 MB), varbinary e uniqueidentifier.',
            items: [
              '<strong>Sem suporte em tabelas</strong> e o que usar no lugar: money → decimal; datetime e smalldatetime → datetime2; nchar/nvarchar → char/varchar (com ordenação UTF-8, acentos são armazenados normalmente); text/ntext → varchar; tinyint → smallint; json → varchar; image → varbinary; geography/geometry → latitude e longitude ou varbinary. XML e tipos CLR não têm equivalente.',
              'Boas práticas: inteiros para identificadores, a menor precisão de decimal que atende, varchar com o menor tamanho possível (em vez de varchar(max)) e NOT NULL sempre que o modelo permitir.'
            ] },
          { h: 'Chaves e IDENTITY',
            items: [
              'PRIMARY KEY e UNIQUE só com <strong>NONCLUSTERED NOT ENFORCED</strong>; FOREIGN KEY só com <strong>NOT ENFORCED</strong>. O warehouse <strong>não valida</strong> essas restrições — elas servem de metadado para o otimizador e para as ferramentas. Garantir unicidade é trabalho da carga.',
              '<strong>IDENTITY</strong> gera chaves substitutas: só em colunas <strong>bigint</strong>, sem semente nem incremento personalizados. Os valores são únicos e positivos, mas <strong>não sequenciais</strong> e podem ter lacunas, porque são distribuídos entre nós.',
              'Para inserir um valor explícito (como -1 para o membro Desconhecido): <code>SET IDENTITY_INSERT dbo.DimCliente ON</code>, insira e desligue; depois, <code>DBCC CHECKIDENT</code> com RESEED ajusta a próxima faixa.'
            ],
            code: `CREATE TABLE dim.Cliente (
    ClienteSK     BIGINT IDENTITY,
    ClienteID     INT          NOT NULL,   -- chave natural
    Nome          VARCHAR(120) NOT NULL,
    Cidade        VARCHAR(60)  NULL,
    InicioVigencia DATE        NOT NULL,
    FimVigencia    DATE        NULL,
    Atual          BIT         NOT NULL
);
ALTER TABLE dim.Cliente
  ADD CONSTRAINT PK_DimCliente PRIMARY KEY NONCLUSTERED (ClienteSK) NOT ENFORCED;` },
          { h: 'Ordenação (collation)',
            p: 'O padrão é <strong>Latin1_General_100_BIN2_UTF8</strong>, que <strong>diferencia maiúsculas de minúsculas</strong>: <code>WHERE Cidade = \'itumbiara\'</code> não encontra “Itumbiara”. Também existe uma ordenação que não diferencia (Latin1_General_100_CI_AS_KS_WS_SC_UTF8), escolhida ao criar o warehouse (por API) ou nas configurações do workspace.' },
          { h: 'O que não existe no warehouse',
            items: [
              'Gatilhos (triggers), exibições materializadas e indexadas, sinônimos, sequências, colunas computadas, tabelas particionadas, estatísticas de várias colunas criadas manualmente, consultas recursivas, FOR XML e SET TRANSACTION ISOLATION LEVEL.',
              'Em compensação: MERGE, CTEs, TRUNCATE, #temp, exibições, funções embutidas com valor de tabela e procedimentos armazenados funcionam.'
            ],
            img: { src: `${FAB_IMG}/m07/warehouse-exemplo.png`, alt: 'Warehouse carregado com dados de exemplo', caption: 'Um warehouse com o conjunto de exemplo: explorador de esquemas e tabelas à esquerda.', source: `${LEARN}/data-warehouse/create-warehouse` } },
          { h: 'Como isso cai na prova',
            items: [
              'Precisa de UPDATE/DELETE em T-SQL sobre tabelas do lakehouse → não é possível pelo ponto de extremidade SQL; use warehouse (ou Spark).',
              'Coluna money ou datetime no script de migração falha → trocar por decimal e datetime2.',
              'Chave primária declarada, mas chegaram duplicados → é NOT ENFORCED; a carga precisa deduplicar.',
              'Chaves IDENTITY com lacunas e fora de ordem → comportamento esperado.',
              'Filtro de texto não encontra linhas por causa de maiúsculas → ordenação padrão é sensível a maiúsculas.'
            ] }
        ],
        recursos: [
          { t: 'O que é o Fabric Data Warehouse', u: `${LEARN}/data-warehouse/data-warehousing` },
          { t: 'Tabelas no Fabric Data Warehouse', u: `${LEARN}/data-warehouse/tables` },
          { t: 'Tipos de dados', u: `${LEARN}/data-warehouse/data-types` },
          { t: 'Colunas IDENTITY', u: `${LEARN}/data-warehouse/identity` },
          { t: 'Área de superfície do T-SQL', u: `${LEARN}/data-warehouse/tsql-surface-area` },
          { t: 'Guia de decisão: warehouse ou lakehouse', u: `${LEARN}/fundamentals/decision-guide-lakehouse-warehouse` }
        ]
      },
      {
        id: 'fab-warehouse-ingestao', title: 'Carregar dados no warehouse: COPY INTO, CTAS, INSERT e OPENROWSET',
        desc: 'As formas de colocar dados no warehouse — COPY INTO, CREATE TABLE AS SELECT, INSERT…SELECT, SELECT INTO, OPENROWSET, consultas entre bancos, pipelines e dataflows — e quando usar cada uma.',
        objetivos: [
          'Carregar arquivos com COPY INTO',
          'Criar e alimentar tabelas com CTAS e INSERT…SELECT, inclusive a partir do lakehouse',
          'Ler arquivos sem carregar com OPENROWSET',
          'Evitar os padrões de carga que degradam o warehouse'
        ],
        body: 'Cobre a parte de warehouse de “Ingerir ou acessar dados” (DP-600) e “Ingerir dados” (DP-700). Regra de ouro: cargas em lote grandes; nada de inserir linha a linha.',
        content: [
          { h: 'As opções',
            items: [
              '<strong>COPY INTO</strong> — a forma mais rápida de carregar arquivos (CSV, Parquet, JSONL) do ADLS Gen2, Blob ou OneLake. Ideal dentro de lógica T-SQL.',
              '<strong>CREATE TABLE AS SELECT (CTAS)</strong> — cria uma tabela nova já com o resultado de uma consulta.',
              '<strong>INSERT…SELECT</strong> — acrescenta o resultado de uma consulta a uma tabela existente.',
              '<strong>SELECT INTO</strong> — como o CTAS, na sintaxe clássica do T-SQL.',
              '<strong>OPENROWSET</strong> — lê arquivos diretamente (Parquet, CSV, JSONL) sem carregar; pode ser a fonte de um CTAS ou INSERT.',
              '<strong>Pipelines</strong> (atividade Copiar), <strong>Dataflows Gen2</strong> e <strong>trabalho de cópia</strong> — sem código, a partir de centenas de conectores.'
            ] },
          { h: 'COPY INTO',
            p: 'Por padrão o COPY usa a identidade Microsoft Entra de quem executa para ler a fonte; também aceita SAS, chave da conta ou a <strong>identidade do workspace</strong>, que separa o acesso à fonte da permissão de gravar na tabela. Arquivos com pelo menos 4 MB rendem melhor; divida arquivos CSV grandes quando forem poucos.',
            code: `COPY INTO dbo.Vendas
FROM 'https://minhaconta.dfs.core.windows.net/brutos/vendas/2026/*.parquet'
WITH (FILE_TYPE = 'PARQUET');

COPY INTO dbo.Clientes
FROM 'https://minhaconta.blob.core.windows.net/brutos/clientes.csv'
WITH (FILE_TYPE = 'CSV', FIRSTROW = 2, FIELDTERMINATOR = ';');` },
          { h: 'CTAS e INSERT a partir do lakehouse',
            p: 'Tabelas do lakehouse e de outros warehouses <strong>do mesmo workspace</strong> são lidas com o nome de três partes <code>item.esquema.tabela</code>. É o jeito mais eficiente de levar dados da prata do lakehouse para o ouro do warehouse — sem pipeline, sem cópia intermediária.',
            code: `-- nova tabela no warehouse a partir da prata do lakehouse
CREATE TABLE ouro.FatoVendas AS
SELECT v.PedidoID, v.DataVenda, c.ClienteSK, v.Quantidade * v.Preco AS Receita
FROM   LH_Prata.dbo.vendas AS v
JOIN   dim.Cliente        AS c ON c.ClienteID = v.ClienteID AND c.Atual = 1;

-- carga incremental numa tabela existente
INSERT INTO ouro.FatoVendas
SELECT ... FROM LH_Prata.dbo.vendas WHERE DataVenda > @UltimaCarga;` },
          { h: 'OPENROWSET: ler sem carregar',
            p: '<code>OPENROWSET(BULK \'caminho\')</code> lê CSV, Parquet ou JSONL do ADLS, do Blob ou do OneLake como se fosse uma tabela. Útil para explorar um arquivo antes de decidir como carregar e para alimentar um CTAS.' },
          { h: 'Padrões a evitar',
            items: [
              '<strong>Inserções, atualizações e exclusões pequenas e frequentes</strong> (“gota a gota”) criam muitos arquivos Parquet pequenos e pioram as leituras. Agrupe as mudanças e aplique em lote.',
              'Para cargas em várias etapas, carregue numa tabela de <strong>preparo</strong> (esquema int) e aplique a transformação final com INSERT…SELECT ou MERGE.',
              'O warehouse compacta arquivos pequenos automaticamente em segundo plano, mas isso não substitui cargas bem dimensionadas.'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              'Maior desempenho para carregar Parquet do ADLS em T-SQL → COPY INTO.',
              'Levar tabela da prata do lakehouse para o warehouse no mesmo workspace sem pipeline → CTAS/INSERT com nome de três partes.',
              'Olhar o conteúdo de um CSV no data lake sem criar tabela → OPENROWSET.',
              'Warehouse lento após milhares de INSERTs de uma linha → agrupar em cargas em lote.'
            ] }
        ],
        recursos: [
          { t: 'Inserir dados no warehouse', u: `${LEARN}/data-warehouse/ingest-data` },
          { t: 'Ingerir dados com a instrução COPY', u: `${LEARN}/data-warehouse/ingest-data-copy` },
          { t: 'Ingerir dados com Transact-SQL', u: `${LEARN}/data-warehouse/ingest-data-tsql` },
          { t: 'Procurar conteúdo de arquivos com OPENROWSET', u: `${LEARN}/data-warehouse/browse-file-content-with-openrowset` }
        ]
      },
      {
        id: 'fab-tsql-consultas', title: 'Selecionar, filtrar e agregar dados com T-SQL',
        desc: 'O SQL que a prova cobra: SELECT, WHERE, JOIN, GROUP BY e HAVING, CTEs e funções de janela — e o editor de consultas SQL do Fabric, com salvar como exibição ou tabela e consultas entre bancos.',
        objetivos: [
          'Escrever consultas com filtros, junções e agregações',
          'Usar CTEs e funções de janela (ROW_NUMBER, RANK, LAG, SUM OVER)',
          'Usar o editor SQL do Fabric e ferramentas externas',
          'Consultar vários warehouses e lakehouses na mesma consulta'
        ],
        body: 'Habilidade DP-600 “Selecionar, filtrar e agregar dados usando o SQL” e parte de “Transformar dados usando PySpark, SQL e KQL” da DP-700. Os mesmos conceitos que você viu em Power Query e PySpark, agora na linguagem mais usada em dados.',
        content: [
          { h: 'A consulta básica',
            items: [
              '<strong>SELECT</strong> colunas (evite SELECT * em tabelas largas), <strong>FROM</strong> tabela, <strong>WHERE</strong> filtra linhas antes de agrupar.',
              '<strong>JOIN</strong>: INNER, LEFT, RIGHT, FULL; o “anti join” em SQL é LEFT JOIN … WHERE direita IS NULL, ou NOT EXISTS.',
              '<strong>GROUP BY</strong> agrupa; <strong>HAVING</strong> filtra grupos depois da agregação; <strong>ORDER BY</strong> ordena; <strong>TOP</strong> limita.',
              'Funções úteis: CAST/CONVERT, COALESCE e ISNULL para nulos, CASE WHEN para regras, DATEPART/YEAR/EOMONTH para datas.'
            ],
            code: `SELECT c.UF,
       YEAR(v.DataVenda)          AS Ano,
       SUM(v.Receita)             AS ReceitaTotal,
       COUNT(DISTINCT v.ClienteSK) AS Clientes
FROM   ouro.FatoVendas v
JOIN   dim.Cliente     c ON c.ClienteSK = v.ClienteSK
WHERE  v.DataVenda >= '2025-01-01'
GROUP BY c.UF, YEAR(v.DataVenda)
HAVING SUM(v.Receita) > 100000
ORDER BY ReceitaTotal DESC;` },
          { h: 'CTEs e funções de janela',
            p: 'Uma <strong>CTE</strong> (WITH) dá nome a uma subconsulta e deixa a lógica legível. Funções de janela com <strong>OVER (PARTITION BY … ORDER BY …)</strong> calculam rankings, valores anteriores e acumulados sem agrupar as linhas — exatamente como no Spark.',
            code: `WITH ranking AS (
    SELECT ProdutoID, Categoria, SUM(Receita) AS Receita,
           RANK() OVER (PARTITION BY Categoria ORDER BY SUM(Receita) DESC) AS Posicao
    FROM   ouro.FatoVendas
    GROUP BY ProdutoID, Categoria
)
SELECT * FROM ranking WHERE Posicao <= 3;   -- top 3 por categoria

-- valor do mês anterior e acumulado no ano
SELECT Mes, Receita,
       LAG(Receita) OVER (ORDER BY Mes) AS MesAnterior,
       SUM(Receita) OVER (PARTITION BY YEAR(Mes) ORDER BY Mes
                          ROWS UNBOUNDED PRECEDING) AS AcumuladoAno
FROM   ouro.ReceitaMensal;` },
          { h: 'Duplicados e nulos em SQL',
            items: [
              'Remover duplicados mantendo o mais recente: ROW_NUMBER() OVER (PARTITION BY chave ORDER BY AlteradoEm DESC) e ficar com a linha 1.',
              'Achar duplicados: GROUP BY chave HAVING COUNT(*) > 1.',
              'Nulos: COALESCE(coluna, valor padrão); filtros com IS NULL / IS NOT NULL (nunca “= NULL”).'
            ] },
          { h: 'O editor de consultas SQL',
            items: [
              '<strong>Nova consulta SQL</strong> na faixa de opções, com modelos prontos (criar tabela, exibição, procedimento, estatística…).',
              'A visualização mostra até 10.000 linhas. Várias consultas na mesma aba geram vários conjuntos de resultados.',
              '<strong>Salvar como exibição</strong>, <strong>Salvar como tabela</strong>, <strong>Abrir no Excel</strong> e <strong>Visualizar resultados</strong> (cria um relatório).',
              'Ferramentas externas usam a <strong>cadeia de conexão SQL</strong> do warehouse: SSMS, VS Code com a extensão de SQL, Excel e o Power BI Desktop.'
            ],
            img: { src: `${FAB_IMG}/m07/editor-sql.png`, alt: 'Editor de consultas SQL com resultados', caption: 'O editor de consultas SQL do warehouse, com o resultado da consulta embaixo.', source: `${LEARN}/data-warehouse/sql-query-editor` } },
          { h: 'Consultas entre bancos',
            p: 'No explorador, <strong>+ Warehouses</strong> adiciona outros warehouses, pontos de extremidade SQL e bancos espelhados do mesmo workspace. A partir daí, junte tabelas de itens diferentes com o nome de três partes — inclusive em transações que gravam no warehouse.',
            img: { src: `${FAB_IMG}/m07/adicionar-warehouses.png`, alt: 'Adicionar warehouses no explorador', caption: 'Adicionar outros warehouses e pontos de extremidade ao explorador para consultas entre bancos.', source: `${LEARN}/data-warehouse/query-warehouse` } },
          { h: 'Como isso cai na prova',
            items: [
              'Filtrar pelo total agregado → HAVING, não WHERE.',
              'Top N por grupo → RANK/ROW_NUMBER com PARTITION BY numa CTE.',
              'Comparar com o período anterior → LAG.',
              'Juntar tabela do lakehouse com dimensão do warehouse → nome de três partes no mesmo workspace.'
            ] }
        ],
        recursos: [
          { t: 'Consultar o warehouse ou o ponto de extremidade SQL', u: `${LEARN}/data-warehouse/query-warehouse` },
          { t: 'Editor de consultas SQL', u: `${LEARN}/data-warehouse/sql-query-editor` },
          { t: 'Funções de janela: cláusula OVER (T-SQL)', u: 'https://learn.microsoft.com/pt-br/sql/t-sql/queries/select-over-clause-transact-sql?view=fabric' }
        ]
      },
      {
        id: 'fab-tsql-objetos', title: 'Exibições, funções, procedimentos, MERGE e transações',
        desc: 'Encapsular lógica em exibições, funções com valor de tabela e procedimentos armazenados; fazer upsert e SCD com MERGE; e entender transações, isolamento por instantâneo e conflitos de gravação.',
        objetivos: [
          'Criar exibições, funções embutidas e procedimentos armazenados',
          'Usar MERGE para upsert e SCD',
          'Explicar isolamento por instantâneo e bloqueio no nível da tabela',
          'Evitar e resolver conflitos de gravação'
        ],
        body: 'Cobre a habilidade DP-600 “Criar exibições, funções e procedimentos armazenados” e prepara “Identificar e resolver erros de T-SQL” da DP-700.',
        content: [
          { h: 'Exibições (views)',
            p: 'Uma exibição guarda uma consulta com nome. Não armazena dados — é recalculada a cada uso. Serve para esconder complexidade (joins já feitos), padronizar regras de negócio e controlar o que cada usuário enxerga. Funciona no warehouse e no ponto de extremidade SQL do lakehouse.',
            code: `CREATE OR ALTER VIEW ouro.vw_VendasPorCliente AS
SELECT c.Nome, c.Cidade, SUM(v.Receita) AS Receita
FROM   ouro.FatoVendas v
JOIN   dim.Cliente c ON c.ClienteSK = v.ClienteSK
GROUP BY c.Nome, c.Cidade;` },
          { h: 'Funções embutidas com valor de tabela',
            p: 'Uma função com valor de tabela embutida (inline TVF) é como uma exibição com parâmetros: recebe valores e devolve uma tabela que pode ser usada no FROM.',
            code: `CREATE OR ALTER FUNCTION ouro.fn_VendasDoPeriodo (@Inicio DATE, @Fim DATE)
RETURNS TABLE
AS RETURN
    SELECT * FROM ouro.FatoVendas
    WHERE DataVenda BETWEEN @Inicio AND @Fim;

SELECT * FROM ouro.fn_VendasDoPeriodo('2026-01-01', '2026-03-31');` },
          { h: 'Procedimentos armazenados',
            p: 'Um procedimento guarda um bloco de T-SQL com parâmetros — a lógica de carga fica versionada no próprio warehouse e é chamada por um pipeline (atividade Procedimento armazenado), como no padrão de marca d’água do Módulo 04.',
            code: `CREATE OR ALTER PROCEDURE int.usp_CarregarFatoVendas @DataCorte DATE
AS
BEGIN
    INSERT INTO ouro.FatoVendas (PedidoID, DataVenda, ClienteSK, Receita)
    SELECT v.PedidoID, v.DataVenda, ISNULL(c.ClienteSK, -1), v.Receita
    FROM   LH_Prata.dbo.vendas v
    LEFT JOIN dim.Cliente c ON c.ClienteID = v.ClienteID AND c.Atual = 1
    WHERE  v.DataVenda > @DataCorte;
END;

EXEC int.usp_CarregarFatoVendas @DataCorte = '2026-09-01';` },
          { h: 'MERGE',
            p: 'O MERGE (disponível em geral no warehouse) compara origem e destino pela chave e, numa única instrução, atualiza, insere e, se quiser, exclui. É o upsert do T-SQL e a base do SCD tipo 1. Para SCD tipo 2, um MERGE encerra a versão atual (FimVigencia, Atual = 0) e um INSERT grava as novas versões.',
            code: `MERGE dim.Produto AS d
USING int.ProdutoPreparo AS o
   ON d.ProdutoID = o.ProdutoID
WHEN MATCHED AND (d.Nome <> o.Nome OR d.Categoria <> o.Categoria) THEN
    UPDATE SET d.Nome = o.Nome, d.Categoria = o.Categoria
WHEN NOT MATCHED BY TARGET THEN
    INSERT (ProdutoID, Nome, Categoria) VALUES (o.ProdutoID, o.Nome, o.Categoria);` },
          { h: 'Transações e isolamento',
            items: [
              'Transações ACID com <strong>BEGIN TRAN / COMMIT / ROLLBACK</strong>, inclusive envolvendo várias tabelas e outros warehouses do mesmo workspace.',
              'O isolamento é sempre <strong>por instantâneo</strong> (snapshot): cada transação enxerga os dados como estavam quando começou; leitores não bloqueiam gravadores e vice-versa. Tentar mudar o nível de isolamento é ignorado.',
              'O bloqueio é <strong>no nível da tabela</strong>. DDL usa bloqueio de modificação de esquema, que bloqueia todo acesso à tabela; evite DDL dentro de transações em horário de carga.',
              'Sem suporte: transações distribuídas, pontos de salvamento e transações nomeadas.'
            ] },
          { h: 'Conflitos de gravação',
            p: 'Duas transações que fazem UPDATE, DELETE, MERGE ou TRUNCATE na <strong>mesma tabela</strong> ao mesmo tempo entram em conflito — mesmo mexendo em linhas diferentes. A primeira a confirmar vence; a outra é revertida com o <strong>erro 24556</strong> (“transação de isolamento por instantâneo anulada devido a conflito de atualização”). INSERT cria arquivos novos e raramente conflita.',
            items: [
              'Não rode atualizações simultâneas na mesma tabela; serialize as cargas no pipeline.',
              'Implemente nova tentativa para a transação que falhou.',
              'Mantenha transações curtas e sempre com COMMIT ou ROLLBACK.'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              'Lógica de carga reutilizável chamada pelo pipeline → procedimento armazenado.',
              'Consulta reutilizável com parâmetro de período → função embutida com valor de tabela.',
              'Atualizar existentes e inserir novos numa só instrução → MERGE.',
              'Dois pipelines atualizando a mesma tabela falham com 24556 → conflito de gravação; serializar e repetir.',
              'SET TRANSACTION ISOLATION LEVEL não tem efeito → o warehouse usa sempre isolamento por instantâneo.'
            ] }
        ],
        recursos: [
          { t: 'Transações no Fabric Data Warehouse', u: `${LEARN}/data-warehouse/transactions` },
          { t: 'Área de superfície do T-SQL (MERGE, exibições, funções)', u: `${LEARN}/data-warehouse/tsql-surface-area` },
          { t: 'Tabelas temporárias', u: `${LEARN}/data-warehouse/temp-tables` },
          { t: 'Modelagem dimensional: carregar tabelas', u: `${LEARN}/data-warehouse/dimensional-modeling-load-tables` }
        ]
      },
      {
        id: 'fab-warehouse-recuperacao', title: 'Viagem no tempo, clones e restauração',
        desc: 'Consultar dados como estavam no passado, criar cópias instantâneas de tabelas sem duplicar dados e restaurar o warehouse inteiro a partir de pontos de restauração.',
        objetivos: [
          'Consultar o passado com FOR TIMESTAMP AS OF',
          'Criar clones de tabela sem cópia',
          'Restaurar o warehouse a partir de um ponto de restauração'
        ],
        body: 'Recursos que dependem do formato Delta e do fato de o warehouse guardar versões dos dados por um período de retenção. Aparecem na prova em cenários de erro humano, auditoria e ambientes de teste.',
        content: [
          { h: 'Retenção',
            p: 'O warehouse mantém automaticamente as versões anteriores dos dados por um período de retenção <strong>configurável de 1 a 120 dias</strong> — o padrão é <strong>30 dias</strong>. Viagem no tempo, clones num ponto do passado e pontos de restauração só alcançam o que está dentro desse período. No ponto de extremidade SQL do lakehouse, o limite é dado pela retenção do VACUUM de cada tabela.' },
          { h: 'Viagem no tempo',
            p: 'A dica <code>OPTION (FOR TIMESTAMP AS OF \'...\')</code> no fim de um SELECT consulta todas as tabelas da instrução como estavam naquele instante (em UTC). O resultado é somente leitura. Usos: relatório estável enquanto o ETL roda, comparar antes e depois de uma carga, auditoria, investigar a causa de um erro.',
            code: `SELECT UF, SUM(Receita) AS Receita
FROM   ouro.FatoVendas
GROUP BY UF
OPTION (FOR TIMESTAMP AS OF '2026-09-20T08:00:00');` },
          { h: 'Clone de tabela sem cópia',
            p: '<code>CREATE TABLE ... AS CLONE OF</code> cria em segundos uma réplica da tabela copiando só os metadados — os arquivos Parquet são compartilhados. O clone pode ser do estado atual ou de um momento do passado dentro da retenção. Depois de criado, é <strong>independente</strong>: mudanças na origem não aparecem no clone, e vice-versa. Herda a segurança em nível de objeto da origem. Administrador, Membro e Colaborador podem clonar; Visualizador não.',
            code: `-- cópia de trabalho para testar uma alteração
CREATE TABLE teste.FatoVendas AS CLONE OF ouro.FatoVendas;

-- como estava antes da carga com problema
CREATE TABLE teste.FatoVendas_0920 AS CLONE OF ouro.FatoVendas
    AT '2026-09-20T08:00:00';` },
          { h: 'Pontos de restauração',
            items: [
              'O Fabric cria <strong>pontos de restauração do sistema a cada 8 horas</strong> enquanto o warehouse está ativo (objetivo de ponto de recuperação de 8 horas).',
              'Administradores do workspace criam <strong>pontos definidos pelo usuário</strong> antes e depois de mudanças grandes.',
              'Retenção padrão de 30 dias, com garantia mínima de 20 pontos mesmo se o warehouse ficar parado.',
              'A <strong>restauração no local</strong> volta o warehouse inteiro para o ponto escolhido (copiando só metadados). Tudo o que foi feito depois se perde — é o “desfazer geral”.'
            ] },
          { h: 'Qual recurso usar',
            items: [
              'Ver como os números estavam ontem, sem mexer em nada → viagem no tempo.',
              'Recuperar uma tabela apagada ou corrompida sem afetar as outras → clone da tabela num momento anterior e troca de nomes.',
              'Uma implantação estragou o warehouse inteiro → restauração no local a partir de um ponto de restauração.',
              'Ambiente de teste com dados reais, sem custo de cópia → clones.'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              'Alguém apagou linhas de uma tabela há 3 dias → clone AT antes do DELETE (dentro da retenção) e recarga.',
              'Relatório deve ler os dados do fechamento de ontem enquanto o ETL de hoje roda → FOR TIMESTAMP AS OF.',
              'Retenção padrão do warehouse → 30 dias.'
            ] }
        ],
        recursos: [
          { t: 'Viagem no tempo no warehouse', u: `${LEARN}/data-warehouse/time-travel` },
          { t: 'Clonar uma tabela', u: `${LEARN}/data-warehouse/clone-table` },
          { t: 'Restauração no local do warehouse', u: `${LEARN}/data-warehouse/restore-in-place` }
        ]
      },
      {
        id: 'fab-warehouse-desempenho', title: 'Desempenho, monitoramento e erros do warehouse',
        desc: 'Estatísticas, cache, cache de conjunto de resultados, agrupamento de dados e V-Order; como monitorar com Query Insights e DMVs; gerenciamento de carga de trabalho; e os erros de T-SQL mais comuns.',
        objetivos: [
          'Aplicar as otimizações do warehouse (estatísticas, tipos, clustering, cache)',
          'Encontrar consultas lentas com Query Insights e DMVs',
          'Entender isolamento de ingestão e consulta, sessões e burst',
          'Resolver erros comuns de T-SQL'
        ],
        body: 'Cobre “Otimizar um data warehouse”, “Otimizar o desempenho de consultas” e “Identificar e resolver erros de T-SQL” da DP-700. O warehouse é sem servidor e se ajusta sozinho em muita coisa — a prova quer que você saiba o que ainda depende de você.',
        content: [
          { h: 'Otimizações automáticas e o que você controla',
            items: [
              '<strong>Estatísticas</strong> — criadas automaticamente quando o otimizador precisa (colunas em JOIN, GROUP BY, WHERE, DISTINCT) e atualizadas de forma proativa e incremental. Você pode criar e atualizar manualmente (CREATE/UPDATE STATISTICS), só de coluna única — útil depois de cargas grandes.',
              '<strong>Cache em memória e em disco (SSD)</strong> — automático, sem opção de limpar. A primeira execução (cache frio) costuma ser mais lenta que as seguintes; meça desempenho a partir da segunda.',
              '<strong>Cache de conjunto de resultados</strong> — ligado por padrão no warehouse e no ponto de extremidade SQL: um SELECT repetido sobre dados que não mudaram devolve o resultado guardado. Pode ser desligado no item ou por consulta.',
              '<strong>Agrupamento de dados</strong> (<code>CLUSTER BY</code>, versão prévia) — guarda juntas as linhas com valores parecidos nas colunas escolhidas; acelera filtros frequentes em colunas de cardinalidade média a alta.',
              '<strong>V-Order</strong> — ligado por padrão no warehouse; pode ser desativado em warehouses de preparo com muita escrita (a desativação não tem volta).',
              '<strong>Compactação</strong> de arquivos pequenos — automática, em segundo plano.',
              '<strong>Tipos de dados</strong> enxutos, varchar curto, NOT NULL e cargas em lote continuam sendo as melhores alavancas manuais.'
            ] },
          { h: 'Query Insights',
            p: 'O esquema <strong>queryinsights</strong> (em cada warehouse e ponto de extremidade SQL) guarda o histórico das consultas: <code>exec_requests_history</code> (cada execução, com CPU, dados lidos da memória, do disco e do armazenamento remoto, e se usou o cache de resultados), <code>long_running_queries</code>, <code>frequently_run_queries</code> e <code>exec_sessions_history</code>. Consultas com o mesmo formato são agregadas pelo query hash.',
            img: { src: `${FAB_IMG}/m07/query-insights-views.png`, alt: 'Exibições de Query Insights no explorador', caption: 'As exibições do esquema queryinsights no explorador do warehouse.', source: `${LEARN}/data-warehouse/query-insights` } },
          { h: 'DMVs: o que está rodando agora',
            items: [
              '<code>sys.dm_exec_connections</code>, <code>sys.dm_exec_sessions</code> e <code>sys.dm_exec_requests</code> mostram conexões, sessões e consultas em andamento.',
              'O administrador do workspace vê tudo e pode encerrar uma consulta travada com <code>KILL</code> + id da sessão; Membro, Colaborador e Visualizador veem só as próprias sessões e solicitações.'
            ],
            code: `SELECT r.session_id, s.login_name, r.status, r.total_elapsed_time, r.command
FROM   sys.dm_exec_requests r
JOIN   sys.dm_exec_sessions s ON s.session_id = r.session_id
ORDER BY r.total_elapsed_time DESC;

KILL 71;   -- encerra a sessão 71 (somente administrador do workspace)` },
          { h: 'Gerenciamento de carga de trabalho',
            items: [
              'A computação é sem servidor e escala sozinha; o tamanho da SKU define o limite.',
              'No warehouse, a computação é dividida meio a meio em dois pools isolados — um para consultas <strong>SELECT</strong> e outro para o <strong>resto</strong> (ETL, ingestão) — para uma carga não travar os relatórios. O administrador pode personalizar com pools SQL personalizados.',
              '<strong>Capacidade de intermitência</strong> (burst): o warehouse pode usar temporariamente mais recursos que a linha de base da SKU, dentro de um limite de segurança.',
              'Limite de <strong>2.048 sessões de usuário</strong> por workspace.',
              'Para isolar cargas pesadas, use workspaces separados (réplicas somente leitura via atalhos).'
            ] },
          { h: 'Erros comuns de T-SQL',
            items: [
              '<strong>Tipo de dado sem suporte</strong> no CREATE TABLE (money, datetime, nvarchar) → trocar pelo equivalente suportado.',
              '<strong>Recurso sem suporte</strong> (trigger, sequência, exibição materializada, SET TRANSACTION ISOLATION LEVEL) → reescrever a lógica.',
              '<strong>Erro 24556</strong>, conflito de atualização → atualizações simultâneas na mesma tabela; serializar e repetir.',
              '<strong>DML no ponto de extremidade SQL</strong> do lakehouse → é somente leitura; gravar com Spark ou num warehouse.',
              '<strong>Falta de espaço no tempdb</strong> → consulta que gera resultados intermediários enormes; revise joins, filtre antes e confira as estatísticas.',
              '<strong>Erros transitórios de conexão</strong> → implemente nova tentativa no cliente; verifique se a capacidade não está pausada.',
              'Para o suporte: ID do workspace, ID da instrução e ID da solicitação distribuída (aparecem nas mensagens da consulta).'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              'Achar as consultas que mais consumiram CPU na última semana → queryinsights.exec_requests_history.',
              'Encerrar uma consulta travando o warehouse agora → sys.dm_exec_requests + KILL (administrador).',
              'Primeira execução lenta, as seguintes rápidas → cache frio; é esperado.',
              'Filtros frequentes por data e cliente numa fato enorme → CLUSTER BY nessas colunas.',
              'Estimativas ruins de plano depois de carga grande → UPDATE STATISTICS.'
            ] }
        ],
        recursos: [
          { t: 'Diretrizes de desempenho do warehouse', u: `${LEARN}/data-warehouse/guidelines-warehouse-performance` },
          { t: 'Estatísticas', u: `${LEARN}/data-warehouse/statistics` },
          { t: 'Cache de conjunto de resultados', u: `${LEARN}/data-warehouse/result-set-caching` },
          { t: 'Agrupamento de dados', u: `${LEARN}/data-warehouse/data-clustering` },
          { t: 'Query Insights', u: `${LEARN}/data-warehouse/query-insights` },
          { t: 'Monitorar com DMVs', u: `${LEARN}/data-warehouse/monitor-using-dmv` },
          { t: 'Gerenciamento de carga de trabalho', u: `${LEARN}/data-warehouse/workload-management` },
          { t: 'Solucionar problemas do warehouse', u: `${LEARN}/data-warehouse/troubleshoot-fabric-data-warehouse` }
        ]
      }
    ]
  },
  {
    id: 'fab-m08', title: 'Módulo 08 · Real-Time Intelligence: Eventstream, Eventhouse e KQL', kind: 'video',
    lessons: [
      {
        id: 'fab-rti-visao', title: 'Real-Time Intelligence: componentes e escolha do mecanismo de streaming',
        desc: 'As peças da Real-Time Intelligence — hub em tempo real, Eventstream, Eventhouse, KQL, painéis em tempo real e Activator — e como escolher entre Eventstream, streaming do Spark e KQL.',
        objetivos: [
          'Descrever o papel de cada componente da Real-Time Intelligence',
          'Montar o fluxo de ponta a ponta de uma solução em tempo real',
          'Escolher o mecanismo de streaming adequado a cada cenário'
        ],
        body: 'A Real-Time Intelligence é a carga de trabalho do Fabric para dados em movimento: telemetria, logs, cliques, sensores, transações. “Tempo real” aqui não exige volume gigante — significa reagir quando o evento acontece, e não num agendamento. Cobre a habilidade DP-700 “Escolher um mecanismo de streaming apropriado” e abre o módulo.',
        content: [
          { h: 'As peças',
            items: [
              '<strong>Hub em tempo real</strong> — catálogo de todos os dados em movimento da organização: fluxos de eventos, tabelas KQL, eventos do Fabric (itens do workspace, trabalhos, OneLake) e do Azure (Blob). Visto no Módulo 01 para descobrir dados.',
              '<strong>Eventstream</strong> — captura eventos de dezenas de fontes, transforma sem código e roteia para vários destinos.',
              '<strong>Eventhouse</strong> — o banco analítico para eventos: um ou mais <strong>bancos de dados KQL</strong>, indexados e particionados por tempo, que consultam bilhões de linhas em segundos.',
              '<strong>KQL</strong> (Kusto Query Language) — a linguagem de consulta dos bancos KQL; o <strong>conjunto de consultas KQL</strong> é o item onde você escreve e salva consultas.',
              '<strong>Painel em tempo real</strong> — visuais alimentados por consultas KQL, com atualização automática.',
              '<strong>Activator</strong> — detecta condições nos dados e dispara ações (e-mail, Teams, pipeline, notebook, Power Automate).'
            ],
            img: { src: `${FAB_IMG}/m08/arquitetura-rti.png`, alt: 'Arquitetura da Real-Time Intelligence', caption: 'Arquitetura da Real-Time Intelligence: fontes, Eventstream, Eventhouse, visualização e ações, com o OneLake por baixo.', source: `${LEARN}/real-time-intelligence/overview` } },
          { h: 'O fluxo típico',
            p: 'Fonte de eventos (Hubs de Eventos, IoT Hub, Kafka, CDC de um banco) → <strong>Eventstream</strong> (filtra, enriquece, agrega) → <strong>Eventhouse</strong> (armazena e consulta em KQL) → <strong>painel em tempo real</strong> ou Power BI → <strong>Activator</strong> para alertas e ações. Com a disponibilidade no OneLake ligada, os mesmos dados do eventhouse ficam acessíveis como tabelas Delta para Spark, SQL e Power BI.' },
          { h: 'Escolhendo o mecanismo de streaming',
            items: [
              '<strong>Eventstream</strong> — sem código, conectores prontos, transformações leves (filtro, campos, agregação em janelas, união, junção com dados de referência) e roteamento para vários destinos. Primeira escolha para trazer eventos ao Fabric.',
              '<strong>Streaming estruturado do Spark</strong> (Módulo 06) — código PySpark, lógica complexa, bibliotecas, gravação em tabelas Delta do lakehouse. Para engenheiros que programam e cenários de lakehouse.',
              '<strong>KQL no eventhouse</strong> — políticas de atualização e exibições materializadas transformam os dados logo após a ingestão, e o KQL analisa séries temporais com latência de segundos. Para telemetria, logs e análise interativa sobre dados recentes.',
              'Na prática eles se combinam: Eventstream para ingerir, eventhouse para armazenar e analisar, Spark para processamentos pesados sobre o histórico.'
            ] },
          { h: 'Padrões de carga para streaming',
            items: [
              '<strong>Ingestão direta</strong> no eventhouse — os eventos brutos entram numa tabela; a transformação acontece depois, com políticas de atualização (padrão medalhão dentro do eventhouse).',
              '<strong>Processar antes de ingerir</strong> — o Eventstream filtra e agrega no caminho e grava o resultado.',
              '<strong>Lakehouse como destino</strong> — os eventos viram tabelas Delta; bom quando o consumo principal é Spark ou SQL, não a análise de segundos.',
              '<strong>Vários destinos</strong> ao mesmo tempo: bruto no eventhouse, agregado no lakehouse e alertas no Activator, a partir do mesmo fluxo.'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              'Trazer eventos de um Hub de Eventos para o Fabric sem código → Eventstream.',
              'Telemetria de milhões de dispositivos com consultas interativas sobre os últimos minutos → eventhouse com KQL.',
              'Lógica de streaming complexa em Python gravando no lakehouse → streaming estruturado do Spark.',
              'Avisar a equipe no Teams quando um sensor passar do limite → Activator.'
            ] }
        ],
        recursos: [
          { t: 'O que é a Real-Time Intelligence', u: `${LEARN}/real-time-intelligence/overview` },
          { t: 'Visão geral do hub em tempo real', u: `${LEARN}/real-time-hub/real-time-hub-overview` }
        ]
      },
      {
        id: 'fab-eventstream', title: 'Eventstream: fontes, transformações e destinos',
        desc: 'Criar um Eventstream, conectar fontes, transformar eventos com o editor sem código ou com SQL, agregar em janelas de tempo e rotear para eventhouse, lakehouse, fluxo derivado e Activator.',
        objetivos: [
          'Conectar fontes e destinos a um Eventstream',
          'Usar os operadores de transformação do editor',
          'Agregar eventos em janelas fixas e de salto',
          'Conhecer os limites e garantias do Eventstream'
        ],
        body: 'Cobre “Processar dados usando Eventstream” e parte de “Criar funções de janela” e “Projetar e implementar um padrão de carregamento para dados de streaming” da DP-700.',
        content: [
          { h: 'Fontes',
            items: [
              'Azure: Hubs de Eventos, IoT Hub, Service Bus, Event Grid, Blob Storage.',
              'CDC de bancos: Azure SQL, SQL Server, SQL Managed Instance, PostgreSQL, MySQL, Cosmos DB, Oracle, MongoDB e o feed de alterações de bancos espelhados.',
              'Mensageria de terceiros: Apache Kafka, Confluent, Amazon Kinesis e MSK, Google Pub/Sub, MQTT, Solace.',
              'Eventos do Fabric (itens do workspace, trabalhos, OneLake, capacidade), aplicativo personalizado e dados de exemplo.',
              'Cada Eventstream expõe também um <strong>ponto de extremidade compatível com Kafka</strong>: aplicativos que já falam Kafka enviam e consomem sem mudar código.'
            ] },
          { h: 'Destinos',
            items: [
              '<strong>Eventhouse</strong> — com <strong>ingestão direta</strong> (sem processamento) ou <strong>processamento antes da ingestão</strong>.',
              '<strong>Lakehouse</strong> — converte os eventos em tabela Delta.',
              '<strong>Fluxo derivado</strong> — o fluxo já transformado vira um novo fluxo, publicado no hub em tempo real para outros consumirem.',
              '<strong>Activator</strong> — para regras e alertas.',
              '<strong>Ponto de extremidade personalizado</strong> e <strong>notebook Spark</strong> (versão prévia).',
              'Um mesmo Eventstream alimenta vários destinos ao mesmo tempo, sem que um interfira no outro.'
            ],
            img: { src: `${FAB_IMG}/m08/eventstream-destinos.png`, alt: 'Eventstream com várias fontes e destinos', caption: 'Um Eventstream com fonte, operadores de transformação e vários destinos.', source: `${LEARN}/real-time-intelligence/event-streams/overview` } },
          { h: 'Transformar sem código',
            p: 'No modo Editar, você insere operadores entre o fluxo e o destino:',
            items: [
              '<strong>Filtro</strong> — mantém só os eventos que atendem a uma condição.',
              '<strong>Gerenciar campos</strong> — adiciona, remove, renomeia ou muda o tipo de campos, com funções de texto, data e matemática.',
              '<strong>Agregação</strong> — soma, mínimo, máximo ou média num período, a cada novo evento.',
              '<strong>Agrupar por</strong> — agrega todos os eventos de uma janela de tempo, agrupando por um ou mais campos.',
              '<strong>União</strong> — junta fluxos com campos de mesmo nome e tipo (os demais são descartados).',
              '<strong>Expandir</strong> — transforma uma matriz em várias linhas.',
              '<strong>Junção</strong> com outro fluxo ou com <strong>dados de referência</strong> (enriquecimento com uma tabela de cadastro, atualizada por agendamento).',
              'Também há um operador de <strong>código SQL</strong> para escrever a transformação numa linguagem de consulta de streaming.'
            ],
            img: { src: `${FAB_IMG}/m08/editor-eventos.png`, alt: 'Editor de processamento de eventos no modo Editar', caption: 'Editor de processamento de eventos: operadores arrastados entre a fonte e os destinos.', source: `${LEARN}/real-time-intelligence/event-streams/process-events-using-event-processor-editor` } },
          { h: 'Janelas de tempo no Eventstream',
            items: [
              '<strong>Fixa</strong> (tumbling) — intervalos consecutivos, sem sobreposição: total de vendas a cada 1 minuto.',
              '<strong>De salto</strong> (hopping) — janelas de tamanho fixo que avançam em passos menores e se sobrepõem: média dos últimos 5 minutos, recalculada a cada minuto. Ótima para detectar picos e anomalias.',
              'A linguagem de streaming também oferece janelas deslizantes, de sessão (agrupa eventos próximos, fechando após um período sem eventos) e de instantâneo.',
              'O horário do fim da janela sai em <code>System.Timestamp</code>.'
            ],
            code: `SELECT Cidade,
       System.Timestamp AS FimJanela,
       SUM(Valor) AS Vendas
INTO   saida
FROM   entrada
GROUP BY Cidade, TumblingWindow(minute, 1)

-- média móvel de 5 minutos, recalculada a cada minuto
GROUP BY DispositivoID, HoppingWindow(minute, 5, 1)` },
          { h: 'Limites e operação',
            items: [
              'Mensagem de até <strong>1 MB</strong>; retenção dos eventos no Eventstream de até <strong>90 dias</strong>; entrega <strong>pelo menos uma vez</strong> — o destino pode receber duplicados e deve estar preparado para isso.',
              'Por baixo, cada Eventstream usa um namespace de Hubs de Eventos gerenciado.',
              'Fluxos e destinos podem ser <strong>pausados e retomados</strong> sem apagar a configuração.',
              'Um Eventstream precisa ser <strong>publicado</strong> depois de editado; erros de criação aparecem na guia de erros de autoria.'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              'Total por loja a cada 5 minutos, sem sobreposição → janela fixa (tumbling) no Agrupar por.',
              'Média dos últimos 10 minutos atualizada a cada minuto → janela de salto (hopping).',
              'Enriquecer eventos com o nome do produto de uma tabela → junção com dados de referência.',
              'Aplicativo existente usa Kafka → ponto de extremidade Kafka do Eventstream.',
              'Duplicados no destino → entrega “pelo menos uma vez”; deduplicar no eventhouse.'
            ] }
        ],
        recursos: [
          { t: 'Visão geral dos Eventstreams', u: `${LEARN}/real-time-intelligence/event-streams/overview` },
          { t: 'Processar eventos com o editor', u: `${LEARN}/real-time-intelligence/event-streams/process-events-using-event-processor-editor` },
          { t: 'Processar eventos com o editor de código SQL', u: `${LEARN}/real-time-intelligence/event-streams/process-events-using-sql-code-editor` },
          { t: 'Enriquecer eventos com dados de referência', u: `${LEARN}/real-time-intelligence/event-streams/enrich-events-with-reference-data` },
          { t: 'Adicionar um eventhouse como destino', u: `${LEARN}/real-time-intelligence/event-streams/add-destination-kql-database` }
        ]
      },
      {
        id: 'fab-eventhouse', title: 'Eventhouse e banco de dados KQL: políticas, OneLake e atalhos',
        desc: 'Eventhouse e bancos KQL, políticas de retenção e cache, disponibilidade no OneLake, atalhos do OneLake com e sem aceleração de consulta, e atalhos de banco de dados.',
        objetivos: [
          'Criar eventhouse e banco KQL e ingerir dados',
          'Configurar retenção e cache',
          'Expor os dados do eventhouse no OneLake',
          'Escolher entre tabela nativa, atalho e atalho acelerado'
        ],
        body: 'Cobre as habilidades DP-700 “Escolha entre tabelas nativas e atalhos do OneLake na Inteligência em Tempo Real” e “Escolha entre a aceleração de consulta para os atalhos do OneLake e os atalhos padrão”, além da parte de eventhouse de “Implementar a integração do OneLake” (DP-600, vista no Módulo 02).',
        content: [
          { h: 'Eventhouse e bancos KQL',
            items: [
              'O <strong>eventhouse</strong> agrupa um ou mais bancos KQL e compartilha a computação entre eles. Serve para logs, telemetria, IoT, séries temporais e registros de segurança — dados estruturados, semiestruturados (JSON) e texto livre.',
              'Os dados são <strong>indexados e particionados por tempo de ingestão</strong> automaticamente.',
              'O eventhouse <strong>suspende</strong> quando está ocioso para economizar e volta em alguns segundos. Para sistemas que não toleram essa latência, defina uma <strong>capacidade mínima</strong> (sempre ativa), inclusive por horário com o Planejador de Capacidade.',
              'Formas de ingerir: Eventstream, Obter dados (arquivos, OneLake, Hubs de Eventos), pipelines, dataflows e comandos KQL.'
            ],
            img: { src: `${FAB_IMG}/m08/eventhouse-pagina.png`, alt: 'Página principal do eventhouse', caption: 'Página do eventhouse: visão geral do sistema, armazenamento, ingestão e bancos KQL.', source: `${LEARN}/real-time-intelligence/manage-monitor-eventhouse` } },
          { h: 'Retenção e cache',
            items: [
              '<strong>Política de retenção</strong> — por quanto tempo os dados ficam no banco ou na tabela antes de serem apagados automaticamente. Padrão: <strong>3.650 dias</strong> (ou ilimitado).',
              '<strong>Política de cache</strong> — quanto dos dados recentes fica no <strong>cache quente</strong> (SSD local), com consultas muito mais rápidas. O restante fica no armazenamento frio, mais barato. Padrão também de 3.650 dias.',
              'Ajuste as duas ao uso real: por exemplo, reter 1 ano e manter 30 dias em cache se as consultas olham quase sempre o último mês.'
            ],
            img: { src: `${FAB_IMG}/m08/politica-retencao.png`, alt: 'Painel da política de retenção de dados', caption: 'Política de retenção de um banco KQL: período em dias ou ilimitado.', source: `${LEARN}/real-time-intelligence/data-policies` } },
          { h: 'Disponibilidade no OneLake',
            p: 'Ligando a <strong>disponibilidade no OneLake</strong> num banco ou numa tabela, o eventhouse mantém uma cópia lógica dos dados em formato Delta no OneLake. Assim, lakehouse (por atalho), ponto de extremidade SQL, notebooks e o Direct Lake do Power BI usam os mesmos dados, sem pipeline de cópia. O eventhouse agrupa os eventos para gravar arquivos Parquet de bom tamanho — por isso a cópia Delta pode atrasar alguns minutos quando o volume é baixo.',
            img: { src: `${FAB_IMG}/m08/onelake-disponibilidade.png`, alt: 'Habilitar a disponibilidade do OneLake', caption: 'Habilitar a disponibilidade do OneLake num banco KQL.', source: `${LEARN}/real-time-intelligence/event-house-onelake-availability` } },
          { h: 'Tabela nativa, atalho ou atalho acelerado',
            items: [
              '<strong>Tabela nativa</strong> (dados ingeridos no eventhouse) — o melhor desempenho de consulta e acesso a todos os recursos: políticas de atualização, exibições materializadas, retenção e cache. Custa a ingestão e o armazenamento.',
              '<strong>Atalho do OneLake</strong> (tabela externa) — consulta dados Delta que já estão no OneLake ou em outra nuvem, sem copiar, com <code>external_table()</code>. Bom para dados consultados de vez em quando; mais lento que a tabela nativa.',
              '<strong>Atalho com aceleração de consulta</strong> — o eventhouse indexa e guarda em cache os dados do atalho por um número de dias que você define, chegando a um desempenho próximo ao da tabela nativa sem ingerir. Bom para dados que já chegam ao OneLake e são consultados com frequência. Continua sendo tabela externa: sem políticas de atualização e exibições materializadas; limite de 900 colunas.',
              '<strong>Atalho de banco de dados</strong> — expõe, somente leitura, um banco inteiro de outro eventhouse ou do Azure Data Explorer, com computação separada.'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              'Menor latência de consulta e uso de exibições materializadas → tabela nativa.',
              'Dados Delta já no OneLake, consultados raramente → atalho padrão.',
              'Dados Delta no OneLake consultados o tempo todo, sem querer duplicar a ingestão → atalho com aceleração de consulta.',
              'Consultas lentas sobre o último mês com cache de 7 dias → aumentar a política de cache.',
              'Spark e Power BI precisam dos dados do eventhouse sem cópia → disponibilidade no OneLake.'
            ] }
        ],
        recursos: [
          { t: 'Visão geral do Eventhouse', u: `${LEARN}/real-time-intelligence/eventhouse` },
          { t: 'Alterar políticas de dados (retenção e cache)', u: `${LEARN}/real-time-intelligence/data-policies` },
          { t: 'Disponibilidade no OneLake para eventhouse', u: `${LEARN}/real-time-intelligence/event-house-onelake-availability` },
          { t: 'Aceleração de consulta para atalhos do OneLake', u: `${LEARN}/real-time-intelligence/query-acceleration-overview` },
          { t: 'Atalho de banco de dados', u: `${LEARN}/real-time-intelligence/database-shortcut` }
        ]
      },
      {
        id: 'fab-kql-consultas', title: 'KQL: selecionar, filtrar, agregar e janelas',
        desc: 'A linguagem KQL do zero: o operador de pipe, where, project, extend, summarize com bin, top, join, render, e funções de janela com o operador serialize, prev e row_cumsum.',
        objetivos: [
          'Ler e escrever consultas KQL com o operador de pipe',
          'Filtrar por tempo com ago e agregar por intervalos com bin',
          'Juntar tabelas e visualizar resultados',
          'Usar funções de janela do KQL'
        ],
        body: 'Cobre a habilidade DP-600 “Selecionar, filtrar e agregar dados usando KQL” e as DP-700 “Processar dados usando KQL” e “Criar funções de janela”. Quem sabe SQL aprende KQL rápido: a lógica é a mesma, só que a consulta é escrita de cima para baixo, como uma sequência de etapas — muito parecido com o Power Query.',
        content: [
          { h: 'Estrutura de uma consulta',
            p: 'Uma consulta começa pelo nome da tabela e segue por etapas separadas por <strong>|</strong> (pipe). Cada operador recebe a tabela da etapa anterior e devolve uma nova tabela.',
            code: `Vendas
| where Timestamp > ago(1d)            // últimas 24 horas
| where Loja == "Itumbiara"
| project Timestamp, Produto, Quantidade, Valor
| extend Receita = Quantidade * Valor
| summarize ReceitaTotal = sum(Receita), Pedidos = count() by Produto
| top 10 by ReceitaTotal desc` },
          { h: 'Os operadores essenciais',
            items: [
              '<strong>where</strong> — filtra linhas. Filtre primeiro pelo tempo (<code>ago(1h)</code>, <code>between</code>): é o que mais reduz dados. Texto: <code>==</code> diferencia maiúsculas, <code>=~</code> não; <code>has</code> é mais rápido que <code>contains</code>.',
              '<strong>project</strong> escolhe (e renomeia) colunas; <strong>project-away</strong> remove; <strong>extend</strong> cria colunas calculadas.',
              '<strong>summarize</strong> agrega (count, sum, avg, min, max, dcount) <strong>by</strong> colunas de agrupamento.',
              '<strong>bin(Timestamp, 5m)</strong> arredonda o tempo para intervalos — a base de toda série temporal.',
              '<strong>sort by</strong>/<strong>order by</strong>, <strong>top</strong> N <strong>by</strong>, <strong>take</strong> (amostra rápida), <strong>distinct</strong>, <strong>count</strong>.',
              '<strong>join</strong> (kind=inner, leftouter, leftanti…) e <strong>lookup</strong> para enriquecer com tabelas de dimensão; <strong>union</strong> empilha tabelas.',
              '<strong>render</strong> desenha o resultado como gráfico (timechart, columnchart, piechart).'
            ],
            code: `Telemetria
| where Timestamp > ago(6h)
| summarize TempMedia = avg(Temperatura), TempMax = max(Temperatura)
            by DispositivoID, bin(Timestamp, 5m)
| join kind=inner (Dispositivos | project DispositivoID, Local) on DispositivoID
| render timechart` },
          { h: 'Duplicados e o registro mais recente',
            items: [
              '<code>summarize arg_max(Timestamp, *) by DispositivoID</code> devolve a linha mais recente de cada dispositivo — o jeito KQL de deduplicar mantendo a última versão.',
              '<code>distinct</code> remove linhas repetidas nas colunas escolhidas.',
              'Nulos e vazios: <code>isnull()</code>, <code>isempty()</code>, <code>coalesce()</code>.'
            ] },
          { h: 'Funções de janela',
            p: 'No KQL, funções de janela operam sobre um conjunto de linhas <strong>serializado</strong> (em ordem). Ele fica serializado depois de <code>sort</code>/<code>order by</code>, <code>top</code> ou do operador <code>serialize</code>.',
            items: [
              '<code>prev(coluna)</code> e <code>next(coluna)</code> — valor da linha anterior ou seguinte (variação entre leituras).',
              '<code>row_number()</code> — numeração das linhas.',
              '<code>row_cumsum(coluna)</code> — soma acumulada.',
              'Para janelas de tempo, <code>bin()</code> com summarize faz o papel da janela fixa; funções de série temporal (make-series) cobrem médias móveis e detecção de anomalias.'
            ],
            code: `Leituras
| where DispositivoID == "sensor-07"
| order by Timestamp asc
| extend Variacao = Valor - prev(Valor),
         Acumulado = row_cumsum(Valor)` },
          { h: 'Conjunto de consultas KQL',
            p: 'O <strong>conjunto de consultas KQL</strong> é o item para escrever, salvar e compartilhar consultas, com várias abas, cada uma ligada a um banco (do eventhouse, do Azure Data Explorer ou do Azure Monitor). Todo banco KQL também tem um ambiente de consulta próprio. Os bancos KQL aceitam ainda consultas em <strong>T-SQL</strong> (um subconjunto), úteis para quem está começando, e o Copilot gera KQL a partir de perguntas em linguagem natural.' },
          { h: 'Como isso cai na prova',
            items: [
              'Contagem de eventos por intervalo de 15 minutos na última hora → <code>where Timestamp > ago(1h) | summarize count() by bin(Timestamp, 15m)</code>.',
              'Estado mais recente de cada dispositivo → <code>arg_max</code>.',
              'Diferença entre leituras consecutivas → <code>order by</code> + <code>prev()</code>.',
              'Consulta lenta → filtrar primeiro pelo tempo e usar <code>has</code> em vez de <code>contains</code>.',
              'Completar a sintaxe: summarize… <strong>by</strong>, top… <strong>by</strong>, join… <strong>on</strong>.'
            ] }
        ],
        recursos: [
          { t: 'Visão geral da linguagem KQL', u: 'https://learn.microsoft.com/pt-br/kusto/query/?view=microsoft-fabric' },
          { t: 'Tutorial: operadores comuns do KQL', u: 'https://learn.microsoft.com/pt-br/kusto/query/tutorials/learn-common-operators?view=microsoft-fabric' },
          { t: 'Operador summarize', u: 'https://learn.microsoft.com/pt-br/kusto/query/summarize-operator?view=microsoft-fabric' },
          { t: 'Funções de janela do KQL', u: 'https://learn.microsoft.com/pt-br/kusto/query/window-functions?view=microsoft-fabric' },
          { t: 'Práticas recomendadas de consultas KQL', u: 'https://learn.microsoft.com/pt-br/kusto/query/best-practices?view=microsoft-fabric' },
          { t: 'Consultar dados num conjunto de consultas KQL', u: `${LEARN}/real-time-intelligence/kusto-query-set` }
        ]
      },
      {
        id: 'fab-kql-transformar', title: 'Transformar dados no eventhouse: funções, políticas de atualização e exibições materializadas',
        desc: 'Montar um medalhão dentro do eventhouse: funções armazenadas, políticas de atualização que transformam na ingestão e exibições materializadas que mantêm agregações e deduplicação prontas.',
        objetivos: [
          'Criar funções armazenadas em KQL',
          'Transformar dados na ingestão com políticas de atualização',
          'Usar exibições materializadas para agregar e deduplicar'
        ],
        body: 'Completa “Processar dados usando KQL” e “Transformar dados usando PySpark, SQL e KQL” da DP-700. A ideia é transformar os eventos assim que chegam, sem agendador.',
        content: [
          { h: 'Funções armazenadas',
            p: 'Uma função guarda uma consulta KQL com nome (e, se quiser, parâmetros) no banco. Serve para reaproveitar lógica — e é o que a política de atualização executa.',
            code: `.create-or-alter function ParseTelemetria() {
    TelemetriaBruta
    | extend d = parse_json(Payload)
    | project Timestamp,
              DispositivoID = tostring(d.deviceId),
              Temperatura   = todouble(d.temp),
              Umidade       = todouble(d.humidity)
    | where isnotnull(Temperatura)
}` },
          { h: 'Políticas de atualização',
            p: 'Uma <strong>política de atualização</strong> é definida na tabela de destino: sempre que chegam dados na tabela de origem, a função roda sobre as linhas novas e o resultado é acrescentado ao destino. É o jeito de montar bronze → prata dentro do eventhouse. Pode ser <strong>transacional</strong>: se a transformação falhar, a ingestão na origem também é desfeita. A origem pode até ser uma tabela Delta externa (versão prévia), com processamento periódico.',
            code: `.alter table Telemetria policy update
@'[{"IsEnabled": true, "Source": "TelemetriaBruta",
    "Query": "ParseTelemetria()", "IsTransactional": true}]'`,
            img: { src: `${FAB_IMG}/m08/politica-atualizacao.png`, alt: 'Comando de política de atualização de tabela', caption: 'Criação de uma política de atualização de tabela a partir do banco KQL.', source: `${LEARN}/real-time-intelligence/table-update-policy` } },
          { h: 'Exibições materializadas',
            items: [
              'Uma <strong>exibição materializada</strong> é uma agregação (um único summarize) sobre uma tabela, mantida automaticamente em segundo plano. A consulta à exibição combina a parte já materializada com os registros que ainda não foram processados — o resultado está sempre atualizado.',
              'Usos clássicos: <strong>agregados</strong> (totais por hora e dispositivo) e <strong>deduplicação</strong> com <code>take_any(*)</code> ou <strong>último estado</strong> com <code>arg_max(Timestamp, *)</code>.',
              'Pode ser criada vazia (só dados novos) ou com <strong>backfill</strong> (processa o histórico).',
              '<code>materialized_view("nome")</code> consulta só a parte materializada: mais rápido, um pouco menos atual.',
              'Consomem recursos em segundo plano; filtre pelas chaves do group by ao consultar.'
            ],
            code: `.create materialized-view with (backfill=true) TelemetriaPorHora on table Telemetria
{
    Telemetria
    | summarize TempMedia = avg(Temperatura), TempMax = max(Temperatura)
                by DispositivoID, bin(Timestamp, 1h)
}

.create materialized-view UltimaLeitura on table Telemetria
{
    Telemetria | summarize arg_max(Timestamp, *) by DispositivoID
}`,
            img: { src: `${FAB_IMG}/m08/exibicao-materializada.png`, alt: 'Janela de criação de exibição materializada', caption: 'Criação de uma exibição materializada a partir do banco KQL.', source: `${LEARN}/real-time-intelligence/materialized-view` } },
          { h: 'Medalhão no eventhouse',
            items: [
              '<strong>Bronze</strong> — tabela com os eventos brutos (ingestão direta do Eventstream), retenção curta.',
              '<strong>Prata</strong> — política de atualização com a função que interpreta, tipa e limpa.',
              '<strong>Ouro</strong> — exibições materializadas com agregados e último estado, prontas para painéis e Power BI.'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              'Converter JSON bruto em colunas tipadas no momento da ingestão → política de atualização com função.',
              'Painel lento consultando médias por hora sobre bilhões de linhas → exibição materializada.',
              'Eventos duplicados vindos do Eventstream → exibição materializada com take_any ou arg_max.',
              'Falha na transformação não pode deixar dado bruto sem processar → política transacional.'
            ] }
        ],
        recursos: [
          { t: 'Visão geral da política de atualização', u: 'https://learn.microsoft.com/pt-br/kusto/management/update-policy?view=microsoft-fabric' },
          { t: 'Criar política de atualização de tabela', u: `${LEARN}/real-time-intelligence/table-update-policy` },
          { t: 'Visão geral das exibições materializadas', u: 'https://learn.microsoft.com/pt-br/kusto/management/materialized-views/materialized-view-overview?view=microsoft-fabric' },
          { t: 'Criar e editar exibições materializadas', u: `${LEARN}/real-time-intelligence/materialized-view` }
        ]
      },
      {
        id: 'fab-rti-acoes-monitorar', title: 'Painéis em tempo real, Activator, monitoramento e otimização',
        desc: 'Visualizar com painéis em tempo real, automatizar respostas com o Activator, monitorar eventhouse e Eventstream, resolver erros e otimizar.',
        objetivos: [
          'Criar um painel em tempo real a partir de consultas KQL',
          'Criar regras e ações no Activator',
          'Monitorar e resolver erros de Eventstream e eventhouse',
          'Otimizar Eventstream e eventhouse'
        ],
        body: 'Cobre “Configurar alertas”, “Identificar e resolver erros do Eventhouse”, “Identificar e resolver erros do Eventstream” e “Otimizar Eventstream e Eventhouse” da DP-700.',
        content: [
          { h: 'Painel em tempo real',
            p: 'Um <strong>painel em tempo real</strong> é um conjunto de blocos, cada um alimentado por uma consulta KQL, com atualização automática, parâmetros (filtros de tempo e de valores) e detalhamento. Você cria do zero ou fixa uma consulta do conjunto de consultas. É a visualização de menor latência do Fabric; relatórios Power BI também podem ler o eventhouse (DirectQuery) ou a cópia no OneLake (Direct Lake).',
            img: { src: `${FAB_IMG}/m08/painel-tempo-real.png`, alt: 'Painel em tempo real com fonte de dados', caption: 'Um painel em tempo real: blocos com consultas KQL e parâmetros no topo.', source: `${LEARN}/real-time-intelligence/dashboard-real-time-create` } },
          { h: 'Activator',
            items: [
              'Detecta condições nos dados e dispara <strong>ações</strong> — sem código.',
              'Fontes: Eventstream, eventos do Fabric e do Azure, painéis em tempo real, consultas KQL, relatórios Power BI e consultas SQL no warehouse (versão prévia).',
              '<strong>Objetos</strong> — as entidades monitoradas (um freezer, um caminhão, um cliente), identificados por uma coluna de ID; <strong>propriedades</strong> — os campos observados (temperatura, velocidade).',
              '<strong>Regras</strong> sem estado (cada evento isolado: valor &gt; 50) ou com estado (compara com o passado do objeto: “aumenta”, “torna-se”, “fica sem dados por 10 minutos”).',
              '<strong>Ações</strong>: e-mail, Teams, fluxo do Power Automate, pipeline, notebook, trabalho Spark, dataflow, trabalho de cópia e funções de dados do usuário.',
              'Os gatilhos de evento dos pipelines (Módulo 04) usam o próprio Activator por baixo.'
            ] },
          { h: 'Monitorar',
            items: [
              '<strong>Eventhouse</strong> — a visão geral do sistema mostra estado, armazenamento, computação, ingestão, bancos mais consultados e recomendações. O <strong>monitoramento do workspace</strong> grava logs detalhados num eventhouse para consultar em KQL.',
              '<strong>Eventstream</strong> — cada nó mostra <strong>insights de dados</strong> (eventos de entrada e saída, bytes) e <strong>logs de runtime</strong> com avisos e erros; a guia de erros de autoria aponta problemas de configuração.',
              'O hub de Monitoramento e o aplicativo Capacity Metrics mostram consumo e falhas.'
            ] },
          { h: 'Erros comuns',
            items: [
              '<strong>Eventstream não publica</strong> → erro de autoria (operador sem esquema, campo inexistente); corrija e publique de novo.',
              '<strong>Destino não recebe dados</strong> → fluxo ou destino pausado, esquema do evento diferente do mapeamento da tabela, permissão no destino, ou mensagem acima de 1 MB.',
              '<strong>Ingestão no eventhouse falha</strong> → formato ou mapeamento errado; investigue com <code>.show ingestion failures</code>.',
              '<strong>Política de atualização falhando</strong> → a função quebra com os dados novos; teste a função sozinha. Transacional: a ingestão inteira falha.',
              '<strong>Primeira consulta lenta depois de horas parado</strong> → o eventhouse estava suspenso; defina capacidade mínima se isso não for aceitável.'
            ] },
          { h: 'Otimizar',
            items: [
              '<strong>Eventstream</strong> — filtre e remova campos cedo, agregue antes de gravar quando o detalhe não é necessário, use fluxos derivados para não repetir transformações e ajuste a configuração de taxa de transferência ao volume de eventos.',
              '<strong>Eventhouse</strong> — política de cache cobrindo o período consultado, retenção enxuta, exibições materializadas para agregações frequentes, políticas de atualização em vez de transformar na consulta.',
              '<strong>Consultas KQL</strong> — filtro de tempo primeiro, <code>has</code> em vez de <code>contains</code>, project cedo, summarize antes de join.'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              'Mandar mensagem no Teams quando a temperatura de um freezer subir por 10 minutos seguidos → regra com estado no Activator.',
              'Painel operacional atualizado a cada 30 segundos sobre o eventhouse → painel em tempo real.',
              'Descobrir por que linhas não entraram na tabela KQL → .show ingestion failures.',
              'Consultas sobre os últimos 60 dias lentas com cache de 7 dias → aumentar a política de cache.'
            ] }
        ],
        recursos: [
          { t: 'Criar um painel em tempo real', u: `${LEARN}/real-time-intelligence/dashboard-real-time-create` },
          { t: 'O que é o Fabric Activator', u: `${LEARN}/real-time-intelligence/data-activator/activator-introduction` },
          { t: 'Gerenciar e monitorar um eventhouse', u: `${LEARN}/real-time-intelligence/manage-monitor-eventhouse` },
          { t: 'Adicionar o Activator como destino do Eventstream', u: `${LEARN}/real-time-intelligence/event-streams/add-destination-activator` }
        ]
      }
    ]
  },
  {
    id: 'fab-m09', title: 'Módulo 09 · Modelos semânticos: design', kind: 'video',
    lessons: [
      {
        id: 'fab-modelo-semantico-visao', title: 'Modelos semânticos no Fabric e modos de armazenamento',
        desc: 'O que é um modelo semântico, onde ele nasce no Fabric e os modos de armazenamento de tabela: Importação, DirectQuery, Dual, Direct Lake, híbrido e DirectQuery para modelos do Power BI.',
        objetivos: [
          'Explicar o papel do modelo semântico entre os dados e os relatórios',
          'Criar um modelo semântico a partir de um lakehouse ou warehouse',
          'Escolher o modo de armazenamento de cada tabela'
        ],
        body: 'O modelo semântico (antigo “conjunto de dados” do Power BI) é a camada que traduz tabelas técnicas para a linguagem do negócio: relacionamentos, medidas, hierarquias, formatos e segurança. A seção “Implementar e gerenciar modelos semânticos” vale 25 a 30% da DP-600. Esta aula cobre a habilidade “Escolher um modo de armazenamento”.',
        content: [
          { h: 'Modelo semântico no Fabric',
            items: [
              'Um modelo semântico descreve um domínio analítico: tabelas, relacionamentos, medidas DAX, hierarquias, formatações e regras de segurança. Relatórios, painéis, Excel e o Copilot consomem o modelo, e não as tabelas cruas.',
              'No Fabric, você cria um modelo a partir de um lakehouse, warehouse ou banco espelhado (<strong>Novo modelo semântico</strong>) escolhendo as tabelas, e edita no navegador (modelagem na Web) ou no Power BI Desktop.',
              'Lembre-se da mudança de 2025: o modelo semântico <strong>padrão</strong> não é mais criado automaticamente com lakehouses e warehouses; você cria os modelos que precisa, com as tabelas que precisa.',
              'Um bom modelo é reutilizado por muitos relatórios (<strong>modelo compartilhado</strong>): uma única versão das métricas para toda a empresa.'
            ] },
          { h: 'Os modos de armazenamento',
            items: [
              '<strong>Importação</strong> — os dados são copiados e comprimidos na memória do modelo (VertiPaq). Consultas mais rápidas e DAX completo; os dados só mudam quando o modelo é atualizado. Funciona com quase qualquer fonte.',
              '<strong>DirectQuery</strong> — nada é copiado; cada visual gera uma consulta na fonte (SQL, por exemplo). Dados sempre atuais, mas o desempenho depende da fonte e há restrições de DAX e de Power Query.',
              '<strong>Dual</strong> — a tabela funciona como Importação ou DirectQuery conforme a consulta. Usado em dimensões de modelos compostos para manter relacionamentos regulares com tabelas de Importação e DirectQuery.',
              '<strong>Direct Lake</strong> — exclusivo do Fabric: lê os arquivos Delta (Parquet) do OneLake direto para a memória, sem cópia agendada e sem traduzir consulta para SQL. Desempenho próximo ao da Importação com dados atualizados quase em tempo real. Existe em duas variantes — no OneLake e no ponto de extremidade SQL — detalhadas no Módulo 11.',
              '<strong>Híbrido</strong> — tabela de Importação com atualização incremental cuja partição mais recente fica em DirectQuery, para ter os dados de hoje sem atualizar o modelo.',
              '<strong>DirectQuery para modelos do Power BI</strong> — o seu modelo usa tabelas e medidas de outro modelo publicado e adiciona o que precisa (modelo composto sobre um modelo compartilhado).'
            ],
            img: { src: `${FAB_IMG}/m09/modo-armazenamento.png`, alt: 'Propriedade modo de armazenamento de uma tabela no Power BI Desktop', caption: 'Cada tabela tem a propriedade Modo de armazenamento, no painel de propriedades do modo de exibição Modelo.', source: 'https://learn.microsoft.com/pt-br/power-bi/transform-model/desktop-storage-mode' } },
          { h: 'Conexão dinâmica não é modo de armazenamento',
            p: 'Um relatório conectado em <strong>conexão dinâmica</strong> (live connection) a um modelo publicado não tem modelo próprio — é o “relatório fino”. Todas as medidas e tabelas vêm do modelo remoto. Se precisar acrescentar tabelas, use “Fazer alterações neste modelo”, que transforma a conexão em DirectQuery para modelos do Power BI.' },
          { h: 'Como escolher',
            items: [
              'Dados no Fabric (lakehouse/warehouse), volume grande, precisa de desempenho e dados recentes → <strong>Direct Lake</strong>.',
              'Fonte fora do Fabric, volume que cabe na memória, atualização algumas vezes por dia basta → <strong>Importação</strong>.',
              'Os dados precisam estar atualizados a cada consulta e a fonte aguenta a carga, ou os dados não podem sair da fonte → <strong>DirectQuery</strong>.',
              'Fato gigante em DirectQuery e dimensões pequenas → dimensões em <strong>Dual</strong>.',
              'Histórico grande em Importação mais os dados do dia → <strong>híbrido</strong> (atualização incremental com a opção de dados em tempo real).'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              'Relatório sobre tabelas Delta do lakehouse, com bilhões de linhas e sem janelas de atualização → Direct Lake.',
              'Relacionamento entre tabela de Importação e tabela DirectQuery aparece como limitado → mudar a dimensão para Dual.',
              'Analista quer acrescentar uma planilha a um modelo corporativo publicado → DirectQuery para modelos do Power BI (modelo composto).',
              'Medida com função DAX não suportada numa coluna calculada em DirectQuery → restrição do modo; usar Importação ou mover a lógica para a fonte.'
            ] }
        ],
        recursos: [
          { t: 'Modo de armazenamento de tabela', u: 'https://learn.microsoft.com/pt-br/power-bi/transform-model/desktop-storage-mode' },
          { t: 'Modelos semânticos do Power BI no Fabric', u: `${LEARN}/data-warehouse/semantic-models` },
          { t: 'Sobre o DirectQuery', u: 'https://learn.microsoft.com/pt-br/power-bi/connect-data/desktop-directquery-about' }
        ]
      },
      {
        id: 'fab-modelo-estrela', title: 'Esquema estrela no modelo semântico',
        desc: 'Fatos e dimensões no Power BI: por que o esquema estrela é o formato certo, floco de neve, tabela de datas, dimensões com papéis múltiplos, dimensões degeneradas e redução de dados.',
        objetivos: [
          'Montar um modelo em esquema estrela',
          'Criar e marcar uma tabela de datas',
          'Resolver dimensões com vários papéis e dimensões degeneradas',
          'Reduzir o tamanho do modelo'
        ],
        body: 'Cobre “Implementar um esquema de estrela para um modelo semântico” (DP-600). O Módulo 03 mostrou o esquema estrela no lakehouse e no warehouse; aqui o foco é o modelo semântico, onde o formato das tabelas afeta diretamente o desempenho e a correção do DAX.',
        content: [
          { h: 'Por que estrela',
            p: 'O mecanismo do Power BI é otimizado para <strong>tabelas de fatos</strong> (eventos, números, chaves) cercadas de <strong>tabelas de dimensão</strong> (atributos para filtrar e agrupar), ligadas por relacionamentos <strong>um-para-muitos</strong> com filtro da dimensão para o fato. Esse formato deixa as medidas simples, os filtros previsíveis e a compressão eficiente. Uma tabela única gigante (“flat”) ou um modelo copiado do sistema transacional funcionam mal.',
            img: { src: `${FAB_IMG}/m09/esquema-estrela.svg`, alt: 'Ilustração de um esquema em estrela', caption: 'Esquema estrela: a tabela de fatos no centro e as dimensões ao redor.', source: 'https://learn.microsoft.com/pt-br/power-bi/guidance/star-schema' } },
          { h: 'Floco de neve',
            p: 'No <strong>floco de neve</strong>, uma dimensão é dividida em várias tabelas (Produto → Subcategoria → Categoria). Funciona, mas cada tabela extra é mais um relacionamento a percorrer e mais colunas espalhadas para o usuário. No modelo semântico, prefira <strong>desnormalizar</strong> numa só dimensão Produto (Módulo 05/06) e criar uma <strong>hierarquia</strong> Categoria → Subcategoria → Produto.',
            img: { src: `${FAB_IMG}/m09/floco-de-neve.svg`, alt: 'Exemplo de design em floco de neve', caption: 'Design em floco de neve: a dimensão Produto normalizada em três tabelas.', source: 'https://learn.microsoft.com/pt-br/power-bi/guidance/star-schema' } },
          { h: 'Tabela de datas',
            items: [
              'Crie uma dimensão <strong>Data</strong> com um dia por linha, sem lacunas, cobrindo todos os anos dos fatos — no lakehouse/warehouse ou com DAX (CALENDAR/CALENDARAUTO).',
              '<strong>Marque como tabela de datas</strong> para as funções de inteligência de tempo funcionarem de forma confiável.',
              'Desligue a <strong>data/hora automática</strong> em modelos corporativos: ela cria uma tabela oculta por coluna de data e aumenta o modelo.'
            ] },
          { h: 'Dimensões com vários papéis',
            p: 'Um fato de pedidos tem data do pedido, de envio e de entrega — três relacionamentos com a mesma dimensão Data. Só <strong>um</strong> pode ficar ativo; os outros ficam <strong>inativos</strong> e são usados em medidas com <code>USERELATIONSHIP</code>. A alternativa é duplicar a dimensão (Data do Pedido, Data de Envio) quando o usuário precisa filtrar pelas duas ao mesmo tempo.',
            img: { src: `${FAB_IMG}/m09/relacao-inativa.svg`, alt: 'Modelo com relacionamentos ativos e inativos', caption: 'Dimensão com vários papéis: relacionamentos inativos (tracejados) acionados por medida, ou dimensões duplicadas.', source: 'https://learn.microsoft.com/pt-br/power-bi/guidance/relationships-active-inactive' } },
          { h: 'Outros tipos de dimensão',
            items: [
              '<strong>Degenerada</strong> — atributo que fica no próprio fato (número do pedido); não precisa de tabela.',
              '<strong>Lixo (junk)</strong> — junta flags e indicadores de baixa cardinalidade numa dimensão só.',
              '<strong>SCD tipo 2</strong> — várias versões do mesmo cliente; o fato aponta para a chave substituta da versão válida (Módulo 03).',
              '<strong>Tabela de fatos sem fatos</strong> — só chaves (presença, cobertura), contada com COUNTROWS.'
            ] },
          { h: 'Reduzir o modelo',
            items: [
              'Remova colunas e linhas que ninguém usa (histórico antigo, colunas técnicas).',
              'Menos cardinalidade comprime mais: separe data e hora, arredonde decimais, evite colunas de texto únicas como GUIDs.',
              'Prefira colunas criadas na fonte ou no Power Query a colunas calculadas em DAX.',
              'Resuma o fato quando o detalhe não é necessário (por dia em vez de por transação), ou use agregações.'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              'Filtrar por data de pedido e data de entrega na mesma medida → relacionamento inativo + USERELATIONSHIP.',
              'Inteligência de tempo dando resultados errados → faltou marcar a tabela de datas ou ela tem lacunas.',
              'Categoria e Subcategoria em tabelas separadas deixando o modelo lento e confuso → desnormalizar na dimensão Produto.',
              'Modelo grande demais → remover colunas, reduzir cardinalidade e desligar data/hora automática.'
            ] }
        ],
        recursos: [
          { t: 'Entender o esquema estrela no Power BI', u: 'https://learn.microsoft.com/pt-br/power-bi/guidance/star-schema' },
          { t: 'Tabelas de datas', u: 'https://learn.microsoft.com/pt-br/power-bi/guidance/model-date-tables' },
          { t: 'Relacionamentos ativos e inativos', u: 'https://learn.microsoft.com/pt-br/power-bi/guidance/relationships-active-inactive' },
          { t: 'Técnicas de redução de dados para modelos de importação', u: 'https://learn.microsoft.com/pt-br/power-bi/guidance/import-modeling-data-reduction' }
        ]
      },
      {
        id: 'fab-modelo-relacoes', title: 'Relacionamentos: cardinalidade, direção, ponte e muitos-para-muitos',
        desc: 'Cardinalidade e direção de filtro, filtro bidirecional com cuidado, tabelas de ponte para dimensões muitos-para-muitos, fatos em granularidade diferente e relacionamentos limitados.',
        objetivos: [
          'Configurar cardinalidade e direção de filtro corretamente',
          'Modelar muitos-para-muitos com tabela de ponte',
          'Relacionar fatos com granularidade maior (metas)',
          'Reconhecer relacionamentos regulares e limitados'
        ],
        body: 'Cobre “Implementar relações, como tabelas de ponte e relações muitos para muitos” (DP-600) — um dos temas com mais pegadinhas da prova.',
        content: [
          { h: 'Cardinalidade e direção',
            items: [
              '<strong>Um-para-muitos</strong> (1:*) — o padrão do esquema estrela: dimensão (lado um, valores únicos) filtra o fato (lado muitos).',
              '<strong>Um-para-um</strong> (1:1) — geralmente sinal de que as duas tabelas deveriam ser uma só.',
              '<strong>Muitos-para-muitos</strong> (*:*) — os dois lados têm valores repetidos; use com consciência (abaixo).',
              '<strong>Direção do filtro</strong>: única (da dimensão para o fato) é o padrão e o recomendado. <strong>Bidirecional</strong> faz o fato filtrar a dimensão também — útil em casos específicos, mas pode criar ambiguidade, resultados inesperados e lentidão. Prefira resolver na medida com <code>CROSSFILTER</code> ou filtrando a segmentação com uma medida.'
            ],
            img: { src: `${FAB_IMG}/m09/filtro-bidirecional.svg`, alt: 'Modelo com filtro bidirecional entre produto e vendas', caption: 'Filtro bidirecional: o fato passa a filtrar a dimensão — use só quando necessário.', source: 'https://learn.microsoft.com/pt-br/power-bi/guidance/relationships-bidirectional-filtering' } },
          { h: 'Dimensões muitos-para-muitos: tabela de ponte',
            p: 'Clientes podem ter várias contas e contas podem ter vários clientes. O modelo tem a dimensão <strong>Cliente</strong>, a dimensão <strong>Conta</strong> e uma tabela de <strong>ponte</strong> (ContaCliente) com uma linha por par. Relacionamentos um-para-muitos ligam cada dimensão à ponte; o relacionamento entre a ponte e a dimensão do outro lado precisa filtrar <strong>nos dois sentidos</strong> para que o filtro de Cliente chegue ao fato de transações. Lembre-se: os totais não se somam — uma transação de conta conjunta aparece para cada titular.',
            img: { src: `${FAB_IMG}/m09/ponte-muitos-muitos.svg`, alt: 'Modelo com tabela de ponte entre cliente e conta', caption: 'Tabela de ponte (ContaCliente) resolvendo o muitos-para-muitos entre Cliente e Conta.', source: 'https://learn.microsoft.com/pt-br/power-bi/guidance/relationships-many-to-many' } },
          { h: 'Fatos com granularidade maior',
            p: 'Metas definidas por <strong>ano e categoria</strong> não se relacionam diretamente com a dimensão Data (dia) nem com Produto (produto). Para datas, guarde o primeiro dia do período na tabela de metas e crie um relacionamento um-para-muitos com Data. Para categoria, crie um relacionamento <strong>muitos-para-muitos</strong> Produto → Meta pela coluna Categoria, com filtro em direção única (de Produto para Meta). E proteja a medida: se o usuário filtrar por um nível abaixo da meta (um produto, um dia), a medida deve retornar em branco — com <code>ISFILTERED</code> ou comparando contagens de linhas.',
            img: { src: `${FAB_IMG}/m09/granularidade-meta.svg`, alt: 'Modelo com tabela de metas em granularidade maior', caption: 'Metas (Target) em granularidade maior que Vendas: relacionamento com Data pelo primeiro dia e com Produto pela categoria.', source: 'https://learn.microsoft.com/pt-br/power-bi/guidance/relationships-many-to-many' } },
          { h: 'Não relacione fatos diretamente',
            p: 'Ligar duas tabelas de fatos (Pedidos e Entregas) com muitos-para-muitos parece prático, mas limita os filtros e gera totais confusos. O certo é criar as <strong>dimensões compartilhadas</strong> (Produto, Data, Pedido) e ligar os dois fatos a elas — cada fato conversa com o outro através das dimensões.' },
          { h: 'Relacionamentos regulares e limitados',
            items: [
              'Um relacionamento é <strong>regular</strong> quando as duas tabelas estão no mesmo grupo de fontes e o lado “um” é garantido. É o caso normal.',
              'Ele vira <strong>limitado</strong> quando é muitos-para-muitos ou liga tabelas de <strong>grupos de fontes diferentes</strong> num modelo composto (Importação × DirectQuery de outra fonte). Relacionamentos limitados não expandem a tabela, não tratam linhas sem correspondência como membro em branco e custam mais nas consultas.',
              'Em modelos compostos, trocar a dimensão para <strong>Dual</strong> ajuda a manter os relacionamentos regulares.'
            ],
            img: { src: `${FAB_IMG}/m09/relacao-limitada.png`, alt: 'Aviso sobre relacionamentos limitados ao mudar modo de armazenamento', caption: 'Aviso do Power BI Desktop: ao misturar modos, relacionamentos podem se tornar limitados — a sugestão é usar Dual.', source: 'https://learn.microsoft.com/pt-br/power-bi/transform-model/desktop-storage-mode' } },
          { h: 'Como isso cai na prova',
            items: [
              'Clientes com várias contas e contas com vários clientes → tabela de ponte com filtro bidirecional entre ponte e dimensão.',
              'Metas mensais por categoria junto com vendas diárias por produto → relacionamento pelo primeiro dia do mês e muitos-para-muitos por categoria.',
              'Segmentação deve mostrar só produtos com venda → medida de filtro na segmentação, em vez de bidirecional no modelo.',
              'Totais estranhos entre dois fatos ligados diretamente → dimensões compartilhadas.'
            ] }
        ],
        recursos: [
          { t: 'Diretrizes de relação muitos para muitos', u: 'https://learn.microsoft.com/pt-br/power-bi/guidance/relationships-many-to-many' },
          { t: 'Filtragem bidirecional', u: 'https://learn.microsoft.com/pt-br/power-bi/guidance/relationships-bidirectional-filtering' },
          { t: 'Relacionamentos um-para-um', u: 'https://learn.microsoft.com/pt-br/power-bi/guidance/relationships-one-to-one' },
          { t: 'Entender relacionamentos de modelo', u: 'https://learn.microsoft.com/pt-br/power-bi/transform-model/desktop-relationships-understand' }
        ]
      },
      {
        id: 'fab-modelo-grupos-calculo', title: 'Grupos de cálculo, formato dinâmico e parâmetros de campo',
        desc: 'Menos medidas repetidas com grupos de cálculo, formato que muda conforme o valor ou o contexto, e parâmetros de campo para o leitor trocar medidas e dimensões dos visuais.',
        objetivos: [
          'Criar um grupo de cálculo com itens de inteligência de tempo',
          'Aplicar cadeias de formato dinâmico em medidas e itens de cálculo',
          'Criar parâmetros de campo para medidas e dimensões'
        ],
        body: 'Cobre “Implementar grupos de cálculo, cadeias de caracteres de formato dinâmico e parâmetros de campo” (DP-600). Os três recursos resolvem o mesmo problema: evitar dezenas de medidas e visuais quase iguais.',
        content: [
          { h: 'Grupos de cálculo',
            p: 'Sem grupo de cálculo, cada medida precisa de versões AA, AC, YoY… (Vendas AC, Custo AC, Margem AC…). Um <strong>grupo de cálculo</strong> define essas variações uma vez como <strong>itens de cálculo</strong>, que se aplicam a qualquer medida por meio de <code>SELECTEDMEASURE()</code>. O grupo aparece como uma tabela com uma coluna, usada em segmentações ou nas linhas/colunas de uma matriz.',
            items: [
              'Criado no modo de exibição <strong>Modelo</strong> (botão Grupo de cálculo) ou via TMDL / editores externos.',
              'Exige ligar <strong>Desencorajar medidas implícitas</strong>: o usuário não arrasta mais colunas numéricas somando sozinhas; tudo passa a ser medida explícita.',
              '<strong>Precedência</strong> define a ordem quando há mais de um grupo (por exemplo, tempo e moeda).',
              'As medidas passam a ter tipo <strong>variante</strong> quando um grupo de cálculo existe no modelo.',
              'Um item pode ser usado dentro de uma medida com CALCULATE: <code>CALCULATE([Pedidos], \'Inteligência de Tempo\'[Item] = "YoY%")</code>.'
            ],
            code: `-- itens do grupo "Inteligência de Tempo"
Atual  = SELECTEDMEASURE()
AC     = CALCULATE(SELECTEDMEASURE(), DATESYTD('Data'[Data]))
AA     = CALCULATE(SELECTEDMEASURE(), SAMEPERIODLASTYEAR('Data'[Data]))
YoY%   = DIVIDE(SELECTEDMEASURE()
               - CALCULATE(SELECTEDMEASURE(), SAMEPERIODLASTYEAR('Data'[Data])),
               CALCULATE(SELECTEDMEASURE(), SAMEPERIODLASTYEAR('Data'[Data])))`,
            img: { src: `${FAB_IMG}/m09/grupo-calculo-itens.png`, alt: 'Grupo de cálculo com os itens de inteligência de tempo', caption: 'Um grupo de cálculo com seus itens de inteligência de tempo no painel Dados.', source: 'https://learn.microsoft.com/pt-br/power-bi/transform-model/calculation-groups' } },
          { h: 'Cadeias de formato dinâmico',
            items: [
              'Numa medida, escolha <strong>Formato → Dinâmico</strong> e escreva uma expressão DAX que <strong>retorna o texto do formato</strong>. O valor continua numérico (ordena e soma certo); só a exibição muda.',
              'Exemplos: símbolo da moeda conforme o país selecionado; “K”, “M” ou “Bi” conforme a grandeza; duração em ms mostrada como horas.',
              'Itens de cálculo também têm formato dinâmico — o item YoY% mostra percentual enquanto os outros mantêm o formato da medida.',
              'É a alternativa correta a FORMAT(), que transforma o número em texto e quebra ordenação e gráficos.'
            ],
            code: `-- expressão de formato dinâmico da medida [Receita]
VAR v = ABS([Receita])
RETURN
    SWITCH(TRUE(),
        v >= 1E9, "R$ #,0.0,,,""Bi""",
        v >= 1E6, "R$ #,0.0,,""M""",
        v >= 1E3, "R$ #,0.0,""K""",
        "R$ #,0")`,
            img: { src: `${FAB_IMG}/m09/formato-dinamico.png`, alt: 'Expressão de formato dinâmico de uma medida', caption: 'Formato dinâmico: a lista suspensa à esquerda da barra de fórmulas alterna entre a medida e sua expressão de formato.', source: 'https://learn.microsoft.com/pt-br/power-bi/create-reports/desktop-dynamic-format-strings' } },
          { h: 'Parâmetros de campo',
            items: [
              '<strong>Modelagem → Novo parâmetro → Campos</strong>: escolha medidas ou colunas; o Power BI cria uma tabela calculada e uma segmentação.',
              'Coloque o parâmetro no eixo (colunas) ou nos valores (medidas) de um visual: o leitor troca o que o visual mostra pela segmentação.',
              'Por baixo é uma tabela DAX com tuplas (nome exibido, <code>NAMEOF</code>(campo), ordem) — edite a expressão para acrescentar campos.',
              'Não funcionam com visuais de IA e com o Q&A.'
            ],
            img: { src: `${FAB_IMG}/m09/parametro-campo.png`, alt: 'Relatório com parâmetros de campo em segmentações', caption: 'Parâmetros de campo: o leitor escolhe na segmentação quais dimensões e medidas o visual mostra.', source: 'https://learn.microsoft.com/pt-br/power-bi/create-reports/power-bi-field-parameters' } },
          { h: 'Como isso cai na prova',
            items: [
              'Evitar criar AC, AA e YoY para 30 medidas → grupo de cálculo com SELECTEDMEASURE.',
              'Criar o grupo de cálculo exige qual configuração → desencorajar medidas implícitas.',
              'Mostrar valores em milhões sem transformar em texto → cadeia de formato dinâmico, não FORMAT().',
              'Leitor quer escolher entre ver por Região, Produto ou Canal no mesmo gráfico → parâmetro de campo.',
              'Dois grupos de cálculo aplicados na ordem errada → ajustar a precedência.'
            ] }
        ],
        recursos: [
          { t: 'Criar grupos de cálculo', u: 'https://learn.microsoft.com/pt-br/power-bi/transform-model/calculation-groups' },
          { t: 'Cadeias de caracteres de formato dinâmico para medidas', u: 'https://learn.microsoft.com/pt-br/power-bi/create-reports/desktop-dynamic-format-strings' },
          { t: 'Parâmetros de campo', u: 'https://learn.microsoft.com/pt-br/power-bi/create-reports/power-bi-field-parameters' }
        ]
      },
      {
        id: 'fab-modelo-composto-grande', title: 'Modelos compostos, agregações e formato de modelo grande',
        desc: 'Misturar modos de armazenamento e fontes num modelo composto, usar agregações para acelerar DirectQuery e habilitar o formato de modelo semântico grande.',
        objetivos: [
          'Projetar um modelo composto e entender grupos de fontes',
          'Usar agregações definidas pelo usuário',
          'Identificar quando habilitar o formato de modelo grande'
        ],
        body: 'Cobre “Projetar e criar modelos compostos” e “Identificar casos de uso e configurar formato de armazenamento de modelo semântico grande” (DP-600).',
        content: [
          { h: 'Modelo composto',
            items: [
              'Um <strong>modelo composto</strong> tem tabelas em mais de um modo de armazenamento ou de mais de uma fonte DirectQuery: por exemplo, fato de vendas em DirectQuery no SQL, metas em Importação de uma planilha e dimensões em Dual.',
              'Cada fonte DirectQuery e a parte importada formam <strong>grupos de fontes</strong>. Relacionamentos entre grupos diferentes são limitados.',
              'O caso mais comum hoje: <strong>DirectQuery para um modelo do Power BI</strong> — o analista estende o modelo corporativo com suas próprias tabelas e medidas, sem duplicar o modelo. As medidas dos dois modelos ficam disponíveis.',
              'Cuidados: segurança — dados de um grupo podem ser enviados em consultas para outro; desempenho — junções entre fontes custam caro.'
            ] },
          { h: 'Agregações definidas pelo usuário',
            p: 'Com um fato gigante em DirectQuery, crie uma tabela <strong>agregada</strong> (por dia, produto e loja) em Importação e configure <strong>Gerenciar agregações</strong>, mapeando colunas e funções (Soma, Contagem, Agrupar por). As consultas que cabem na agregação são respondidas da memória; só as que pedem detalhe vão à fonte. A tabela agregada fica oculta, e o usuário continua vendo só o fato original. É a técnica clássica para “big data” em DirectQuery — no Fabric, o Direct Lake muitas vezes resolve o mesmo problema sem esse trabalho.' },
          { h: 'Formato de modelo semântico grande',
            items: [
              'Sem ele, um modelo em Importação fica limitado a <strong>1 GB</strong> compactado ao publicar/atualizar. Com o formato grande, o limite passa a ser a memória da capacidade (SKU).',
              'Disponível em capacidades F, P, A e PPU. Habilite nas configurações do modelo ou como padrão do workspace.',
              'Traz também <strong>carga sob demanda</strong>: depois que o modelo sai da memória, só as partes consultadas voltam, e o tamanho de segmento padrão sobe para 8 milhões de linhas.',
              'Use sempre junto com <strong>atualização incremental</strong> quando o modelo cresce com o tempo (Módulo 11).',
              'Tamanho estimado do modelo: pelo ponto de extremidade XMLA no SSMS ou com consultas às DMVs do modelo.'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              'Modelo de 15 GB não publica numa capacidade F64 → habilitar o formato de modelo grande.',
              'Fato em DirectQuery lento em visuais resumidos → agregações em Importação.',
              'Departamento precisa acrescentar dados próprios ao modelo corporativo → DirectQuery para o modelo do Power BI.',
              'Relacionamento entre tabela importada e tabela DirectQuery de outra fonte → relacionamento limitado.'
            ] }
        ],
        recursos: [
          { t: 'Usar modelos compostos no Power BI Desktop', u: 'https://learn.microsoft.com/pt-br/power-bi/transform-model/desktop-composite-models' },
          { t: 'Diretrizes de modelos compostos', u: 'https://learn.microsoft.com/pt-br/power-bi/guidance/composite-model-guidance' },
          { t: 'Agregações definidas pelo usuário', u: 'https://learn.microsoft.com/pt-br/power-bi/transform-model/aggregations-advanced' },
          { t: 'Modelos semânticos grandes', u: 'https://learn.microsoft.com/pt-br/fabric/enterprise/powerbi/service-premium-large-models' }
        ]
      }
    ]
  },
  {
    id: 'fab-m10', title: 'Módulo 10 · DAX para a prova', kind: 'video',
    lessons: [
      {
        id: 'fab-dax-contextos', title: 'Fundamentos: medidas, contextos, CALCULATE e variáveis',
        desc: 'Medida, coluna calculada e tabela calculada; contexto de linha e contexto de filtro; como o CALCULATE modifica filtros e faz a transição de contexto; e por que usar variáveis.',
        objetivos: [
          'Escolher entre medida, coluna calculada e tabela calculada',
          'Explicar contexto de linha, contexto de filtro e transição de contexto',
          'Escrever medidas com CALCULATE e variáveis'
        ],
        body: 'A DP-600 cobra “Escrever cálculos que usam variáveis e funções DAX, como iteradores, filtragem de tabela, janelas e funções de informações”. Tudo em DAX gira em torno de dois conceitos: contexto e CALCULATE. Se você fez o curso de Power BI, esta aula é uma revisão focada na prova.',
        content: [
          { h: 'Onde o DAX vive',
            items: [
              '<strong>Medida</strong> — calculada na hora da consulta, respeitando os filtros do visual. É onde deve ficar quase toda a lógica de negócio (totais, percentuais, comparações).',
              '<strong>Coluna calculada</strong> — calculada linha a linha na atualização e armazenada no modelo (ocupa memória). Use para atributos que viram filtro ou eixo, e só quando não der para criar na fonte ou no Power Query.',
              '<strong>Tabela calculada</strong> — tabela inteira criada por DAX (tabela de datas com CALENDAR, parâmetros de campo).',
              'No Direct Lake, colunas e tabelas calculadas sobre tabelas do lago têm restrições — mais um motivo para criar colunas na fonte (Módulo 11).'
            ] },
          { h: 'Os dois contextos',
            items: [
              '<strong>Contexto de filtro</strong> — o conjunto de filtros ativos quando a medida é avaliada: segmentações, linhas e colunas do visual, filtros da página e do relatório, segurança em nível de linha. Uma medida <code>SUM(Vendas[Valor])</code> dá um número diferente em cada célula porque o contexto de filtro muda.',
              '<strong>Contexto de linha</strong> — “a linha atual”, que existe numa coluna calculada e dentro de iteradores (SUMX, FILTER…). O contexto de linha <strong>não filtra</strong> nada por si só.',
              '<strong>Transição de contexto</strong> — quando CALCULATE (ou uma medida, que tem CALCULATE implícito) é chamado dentro de um contexto de linha, a linha atual vira filtro. É por isso que <code>SUMX(Cliente, [Vendas])</code> calcula as vendas de cada cliente.'
            ] },
          { h: 'CALCULATE',
            p: '<code>CALCULATE(expressão, filtro1, filtro2…)</code> avalia a expressão num contexto de filtro modificado. Cada argumento de filtro, se a coluna já estiver filtrada, <strong>substitui</strong> o filtro existente; se não estiver, <strong>adiciona</strong>. Filtros podem ser booleanos simples (uma coluna de uma tabela, sem medidas), tabelas (FILTER, VALUES) ou modificadores (ALL, REMOVEFILTERS, KEEPFILTERS, USERELATIONSHIP, CROSSFILTER).',
            code: `Vendas Azul =
CALCULATE ( [Vendas], Produto[Cor] = "Azul" )          -- substitui o filtro de Cor

Vendas Azul Mantendo Filtro =
CALCULATE ( [Vendas], KEEPFILTERS ( Produto[Cor] = "Azul" ) )  -- intersecta

% do Total =
DIVIDE ( [Vendas], CALCULATE ( [Vendas], REMOVEFILTERS ( Produto ) ) )` },
          { h: 'Variáveis',
            items: [
              '<strong>VAR … RETURN</strong> guarda um resultado intermediário: a expressão é avaliada <strong>uma vez</strong> (melhor desempenho), a fórmula fica legível e a depuração fica fácil (retorne a variável temporariamente).',
              'Uma variável é avaliada no contexto em que é <strong>definida</strong>, não onde é usada: se você usar a variável dentro de um CALCULATE, o filtro do CALCULATE não muda o valor dela. Isso substitui o antigo EARLIER.'
            ],
            code: `Crescimento AA % =
VAR VendasAtual = [Vendas]
VAR VendasAA    = CALCULATE ( [Vendas], SAMEPERIODLASTYEAR ( 'Data'[Data] ) )
RETURN
    DIVIDE ( VendasAtual - VendasAA, VendasAA )` },
          { h: 'Como isso cai na prova',
            items: [
              'Cálculo que muda com a segmentação → medida, não coluna calculada.',
              'Percentual sobre o total geral → DIVIDE com CALCULATE e REMOVEFILTERS/ALL.',
              'Filtro de CALCULATE ignora a seleção do usuário na mesma coluna → usar KEEPFILTERS.',
              'Mesma subexpressão repetida duas vezes na medida → variável.',
              'Divisão por zero → DIVIDE em vez do operador “/”.'
            ] }
        ],
        recursos: [
          { t: 'Visão geral do DAX', u: 'https://learn.microsoft.com/pt-br/dax/dax-overview' },
          { t: 'CALCULATE', u: 'https://learn.microsoft.com/pt-br/dax/calculate-function-dax' },
          { t: 'KEEPFILTERS', u: 'https://learn.microsoft.com/pt-br/dax/keepfilters-function-dax' },
          { t: 'Use variáveis para melhorar suas fórmulas', u: 'https://learn.microsoft.com/pt-br/dax/best-practices/dax-variables' },
          { t: 'DIVIDE × operador de divisão', u: 'https://learn.microsoft.com/pt-br/dax/best-practices/dax-divide-function-operator' }
        ]
      },
      {
        id: 'fab-dax-filtros', title: 'Funções de filtragem de tabela',
        desc: 'FILTER, ALL, ALLEXCEPT, ALLSELECTED, REMOVEFILTERS, VALUES, KEEPFILTERS, TREATAS, USERELATIONSHIP e CROSSFILTER — o que cada uma faz e quando usar.',
        objetivos: [
          'Remover, manter e substituir filtros com as funções certas',
          'Usar FILTER sem prejudicar o desempenho',
          'Aplicar relacionamentos virtuais e inativos em medidas'
        ],
        body: 'Filtragem de tabela é o assunto que mais aparece nas questões de DAX: a prova mostra uma medida e pergunta o resultado, ou pede para completar a função que falta.',
        content: [
          { h: 'Remover filtros',
            items: [
              '<strong>REMOVEFILTERS(tabela ou colunas)</strong> — remove filtros; só funciona como modificador dentro do CALCULATE. É o nome mais claro para o uso mais comum.',
              '<strong>ALL(tabela ou colunas)</strong> — faz o mesmo como modificador e também retorna uma tabela sem filtros (pode ser usada como tabela).',
              '<strong>ALLEXCEPT(tabela, colunas)</strong> — remove todos os filtros da tabela, menos os das colunas indicadas.',
              '<strong>ALLSELECTED</strong> — remove os filtros do visual, mas mantém os de fora (segmentações): base do “% do total visível”.'
            ],
            code: `% da Categoria =
DIVIDE ( [Vendas],
         CALCULATE ( [Vendas], ALLEXCEPT ( Produto, Produto[Categoria] ) ) )

% do Total Visível =
DIVIDE ( [Vendas], CALCULATE ( [Vendas], ALLSELECTED ( Produto ) ) )` },
          { h: 'FILTER',
            p: '<code>FILTER(tabela, condição)</code> é um iterador: percorre a tabela linha a linha e devolve as linhas que atendem à condição. É necessário quando a condição usa uma <strong>medida</strong> ou compara colunas de forma complexa. Para condições simples numa coluna, prefira o filtro booleano direto no CALCULATE — ele é traduzido para um filtro sobre uma coluna, que é muito mais eficiente do que iterar uma tabela inteira. <strong>Nunca</strong> filtre uma tabela de fatos inteira com FILTER quando dá para filtrar uma coluna.',
            code: `-- ruim: itera a tabela de fatos inteira
CALCULATE ( [Vendas], FILTER ( Vendas, Vendas[Canal] = "Online" ) )

-- bom: filtro booleano sobre a coluna
CALCULATE ( [Vendas], Vendas[Canal] = "Online" )

-- FILTER é necessário: condição com medida
Clientes VIP =
COUNTROWS ( FILTER ( VALUES ( Cliente[ClienteID] ), [Vendas] > 100000 ) )` },
          { h: 'Outras funções que a prova usa',
            items: [
              '<strong>VALUES(coluna)</strong> — valores distintos visíveis no contexto atual (inclui o “em branco” de linhas sem correspondência); <strong>DISTINCT</strong> não inclui esse em branco.',
              '<strong>KEEPFILTERS</strong> — faz o filtro do CALCULATE intersectar com o existente em vez de substituí-lo.',
              '<strong>USERELATIONSHIP(col1, col2)</strong> — ativa um relacionamento inativo durante o cálculo (data de envio, data de entrega).',
              '<strong>CROSSFILTER(col1, col2, direção)</strong> — muda a direção do filtro de um relacionamento só nessa medida (Both, None…), em vez de deixar o modelo bidirecional.',
              '<strong>TREATAS(tabela, colunas)</strong> — aplica os valores de uma tabela como filtro em colunas de outra, criando um <strong>relacionamento virtual</strong> quando não existe relacionamento físico.',
              '<strong>CALCULATETABLE</strong> — o CALCULATE que devolve tabela.'
            ],
            code: `Vendas por Data de Envio =
CALCULATE ( [Vendas], USERELATIONSHIP ( Vendas[DataEnvio], 'Data'[Data] ) )

Meta Filtrada =   -- relacionamento virtual entre Metas e Produto pela categoria
CALCULATE ( SUM ( Metas[Valor] ),
            TREATAS ( VALUES ( Produto[Categoria] ), Metas[Categoria] ) )` },
          { h: 'Como isso cai na prova',
            items: [
              'Percentual dentro da categoria → ALLEXCEPT(Produto, Produto[Categoria]).',
              'Percentual que respeita a segmentação mas ignora o eixo do visual → ALLSELECTED.',
              'Medida pela data de entrega com relacionamento inativo → USERELATIONSHIP.',
              'Duas tabelas sem relacionamento físico → TREATAS.',
              'Medida lenta com FILTER(Vendas, …) sobre coluna simples → trocar por filtro booleano.'
            ] }
        ],
        recursos: [
          { t: 'REMOVEFILTERS', u: 'https://learn.microsoft.com/pt-br/dax/removefilters-function-dax' },
          { t: 'KEEPFILTERS', u: 'https://learn.microsoft.com/pt-br/dax/keepfilters-function-dax' },
          { t: 'TREATAS', u: 'https://learn.microsoft.com/pt-br/dax/treatas-function-dax' },
          { t: 'CALCULATE (funções modificadoras de filtro)', u: 'https://learn.microsoft.com/pt-br/dax/calculate-function-dax' }
        ]
      },
      {
        id: 'fab-dax-iteradores-janelas', title: 'Iteradores, inteligência de tempo e funções de janela',
        desc: 'SUMX, AVERAGEX, RANKX e companhia; inteligência de tempo; e as funções de janela WINDOW, OFFSET, INDEX, RANK e ROWNUMBER, inclusive em cálculos visuais.',
        objetivos: [
          'Usar iteradores X e RANKX corretamente',
          'Aplicar funções de inteligência de tempo',
          'Calcular acumulados, médias móveis e comparação com o anterior com funções de janela',
          'Conhecer os cálculos visuais'
        ],
        body: 'Cobre as partes “iteradores” e “janelas” da habilidade de cálculos DAX da DP-600.',
        content: [
          { h: 'Iteradores',
            items: [
              'Funções X (<strong>SUMX, AVERAGEX, MINX, MAXX, COUNTX, CONCATENATEX</strong>) percorrem uma tabela, avaliam uma expressão em cada linha (contexto de linha) e agregam.',
              'Use quando o cálculo precisa acontecer <strong>antes</strong> da agregação: <code>SUMX(Vendas, Vendas[Qtd] * Vendas[Preço])</code> — em vez de criar uma coluna calculada.',
              'Iterar sobre uma dimensão chamando uma medida provoca transição de contexto: <code>AVERAGEX(VALUES(Cliente[ClienteID]), [Vendas])</code> é a venda média por cliente.',
              '<strong>RANKX(tabela, expressão, , ordem, empates)</strong> classifica; lembre-se de usar ALL/ALLSELECTED na tabela para comparar com todos, e não só com a linha atual.'
            ],
            code: `Receita = SUMX ( Vendas, Vendas[Quantidade] * Vendas[PrecoUnitario] )

Ranking Produto =
RANKX ( ALLSELECTED ( Produto[Nome] ), [Receita], , DESC, DENSE )` },
          { h: 'Inteligência de tempo',
            items: [
              'Exige uma tabela de datas marcada e contínua.',
              '<strong>TOTALYTD / DATESYTD</strong> (acumulado no ano), <strong>SAMEPERIODLASTYEAR</strong> e <strong>DATEADD</strong> (mesmo período anterior), <strong>PARALLELPERIOD</strong>, <strong>DATESINPERIOD</strong> (últimos N dias/meses, base de médias móveis), <strong>PREVIOUSMONTH</strong>.',
              'Grupos de cálculo (Módulo 09) evitam repetir essas variações para cada medida.'
            ] },
          { h: 'Funções de janela',
            p: 'As funções de janela trabalham com posições de linhas numa tabela ordenada — sem os malabarismos de antes com FILTER e datas. Todas aceitam <strong>ORDERBY</strong> (ordem) e <strong>PARTITIONBY</strong> (reinicia por grupo):',
            items: [
              '<strong>OFFSET(delta, …)</strong> — a linha deslocada: −1 é a anterior (mês anterior, produto anterior no ranking).',
              '<strong>WINDOW(de, tipo, até, tipo, …)</strong> — um intervalo de linhas, absoluto ou relativo: acumulado (do início até a linha atual) ou média móvel (das 2 anteriores até a atual).',
              '<strong>INDEX(posição, …)</strong> — a linha numa posição absoluta (a primeira, a última).',
              '<strong>RANK</strong> e <strong>ROWNUMBER</strong> — posição da linha atual na ordenação (com e sem empates).'
            ],
            code: `Vendas Mês Anterior =
CALCULATE ( [Vendas],
    OFFSET ( -1, ALLSELECTED ( 'Data'[Ano], 'Data'[Mês] ),
             ORDERBY ( 'Data'[Ano], ASC, 'Data'[Mês], ASC ) ) )

Média Móvel 3 Meses =
AVERAGEX (
    WINDOW ( -2, REL, 0, REL,
             ALLSELECTED ( 'Data'[Ano], 'Data'[Mês] ),
             ORDERBY ( 'Data'[Ano], ASC, 'Data'[Mês], ASC ) ),
    [Vendas] )` },
          { h: 'Cálculos visuais',
            p: 'Os <strong>cálculos visuais</strong> são expressões DAX escritas no próprio visual, sobre a matriz de dados que ele mostra — não entram no modelo. São perfeitos para acumulados, percentuais do total e comparação com a linha anterior, com funções simplificadas como <code>RUNNINGSUM</code>, <code>MOVINGAVERAGE</code>, <code>PREVIOUS</code> e as mesmas WINDOW/OFFSET usando eixos (ROWS, COLUMNS) e referências como HIGHESTPARENT.',
            img: { src: `${FAB_IMG}/m10/calculo-visual.png`, alt: 'Tela de edição de cálculos visuais', caption: 'Edição de cálculos visuais: a matriz do visual, a barra de fórmulas e a pré-visualização.', source: 'https://learn.microsoft.com/pt-br/power-bi/transform-model/desktop-visual-calculations-overview' } },
          { h: 'Como isso cai na prova',
            items: [
              'Receita = quantidade × preço sem criar coluna → SUMX.',
              'Ranking que ignora o filtro da linha atual → RANKX com ALL/ALLSELECTED na tabela.',
              'Comparar com o mês anterior dentro de cada ano → OFFSET(-1) com PARTITIONBY ou ORDERBY adequados.',
              'Média móvel dos últimos 3 meses → WINDOW(-2, REL, 0, REL) ou DATESINPERIOD.',
              'Cálculo só para um visual, sem poluir o modelo → cálculo visual.'
            ] }
        ],
        recursos: [
          { t: 'SUMX', u: 'https://learn.microsoft.com/pt-br/dax/sumx-function-dax' },
          { t: 'RANKX', u: 'https://learn.microsoft.com/pt-br/dax/rankx-function-dax' },
          { t: 'WINDOW', u: 'https://learn.microsoft.com/pt-br/dax/window-function-dax' },
          { t: 'OFFSET', u: 'https://learn.microsoft.com/pt-br/dax/offset-function-dax' },
          { t: 'INDEX', u: 'https://learn.microsoft.com/pt-br/dax/index-function-dax' },
          { t: 'RANK', u: 'https://learn.microsoft.com/pt-br/dax/rank-function-dax' },
          { t: 'Cálculos visuais', u: 'https://learn.microsoft.com/pt-br/power-bi/transform-model/desktop-visual-calculations-overview' }
        ]
      },
      {
        id: 'fab-dax-informacao', title: 'Funções de informação e tratamento de brancos',
        desc: 'ISBLANK, HASONEVALUE, SELECTEDVALUE, ISFILTERED, ISCROSSFILTERED, ISINSCOPE, USERPRINCIPALNAME e as funções INFO — para medidas que se comportam bem em totais, subtotais e seleções.',
        objetivos: [
          'Controlar o resultado de medidas em totais e subtotais',
          'Ler a seleção do usuário com SELECTEDVALUE e HASONEVALUE',
          'Tratar valores em branco corretamente',
          'Conhecer as funções INFO para documentar o modelo'
        ],
        body: 'Cobre a parte “funções de informações” da habilidade de cálculos DAX da DP-600. São as funções que respondem perguntas sobre o contexto: há um valor só? Esta coluna está filtrada? Estou no nível do produto ou da categoria?',
        content: [
          { h: 'Perguntas sobre o contexto',
            items: [
              '<strong>HASONEVALUE(coluna)</strong> — verdadeiro se o contexto tem exatamente um valor naquela coluna. Uso típico: mostrar algo só na linha de detalhe e deixar o total em branco.',
              '<strong>SELECTEDVALUE(coluna, alternativo)</strong> — devolve o valor se houver exatamente um; senão, o alternativo. Substitui o padrão IF(HASONEVALUE(...), VALUES(...)).',
              '<strong>ISFILTERED(coluna)</strong> — a coluna está filtrada diretamente. <strong>ISCROSSFILTERED</strong> — está filtrada direta ou indiretamente (por outra coluna ou tabela relacionada).',
              '<strong>ISINSCOPE(coluna)</strong> — a coluna é o nível atual da hierarquia no visual. Ideal para cálculos diferentes em cada nível de uma matriz (percentual do pai).',
              '<strong>USERPRINCIPALNAME()</strong> — o e-mail/UPN de quem está vendo: base da segurança dinâmica em nível de linha (Módulo 12).'
            ],
            code: `Título Dinâmico =
"Vendas de " & SELECTEDVALUE ( Loja[Cidade], "todas as cidades" )

% do Pai =
SWITCH ( TRUE (),
    ISINSCOPE ( Produto[Produto] ),
        DIVIDE ( [Vendas], CALCULATE ( [Vendas], REMOVEFILTERS ( Produto[Produto] ) ) ),
    ISINSCOPE ( Produto[Categoria] ),
        DIVIDE ( [Vendas], CALCULATE ( [Vendas], REMOVEFILTERS ( Produto[Categoria] ) ) ),
    1 )` },
          { h: 'Brancos',
            items: [
              'Em DAX, <strong>BLANK</strong> é o “nulo”. Linhas e colunas sem valor são escondidas dos visuais — por isso uma medida que devolve 0 em vez de branco pode encher uma tabela de linhas inúteis.',
              '<strong>ISBLANK</strong> testa; <strong>COALESCE(expr, 0)</strong> devolve o primeiro valor não branco.',
              '<strong>DIVIDE(a, b, alternativo)</strong> devolve branco (ou o alternativo) quando b é zero ou branco.',
              'Somar branco com número dá o número; compará-lo com zero dá verdadeiro (BLANK = 0 é TRUE), use <code>==</code> para comparação estrita.',
              'Metas em granularidade maior (Módulo 09): retorne BLANK quando o usuário desce abaixo do nível da meta, testando ISFILTERED na coluna de detalhe.'
            ] },
          { h: 'Funções INFO',
            p: 'As funções <strong>INFO.</strong> (como <code>INFO.VIEW.TABLES()</code>, <code>INFO.VIEW.MEASURES()</code>, <code>INFO.TABLES()</code>) devolvem os metadados do próprio modelo — tabelas, colunas, medidas com suas expressões, relacionamentos. Numa consulta DAX (próxima aula), servem para documentar e auditar o modelo sem ferramenta externa. <code>COLUMNSTATISTICS()</code> devolve estatísticas de todas as colunas (mínimo, máximo, cardinalidade).' },
          { h: 'Como isso cai na prova',
            items: [
              'Mostrar o nome do produto selecionado ou “Vários” → SELECTEDVALUE com alternativo.',
              'Medida deve ficar em branco no total geral → IF(HASONEVALUE(...)) ou ISINSCOPE.',
              'Cálculo diferente por nível da hierarquia na matriz → ISINSCOPE, do nível mais baixo para o mais alto.',
              'Divisão com zero no denominador sem erro → DIVIDE.',
              'Listar todas as medidas do modelo com a expressão → INFO.VIEW.MEASURES numa consulta DAX.'
            ] }
        ],
        recursos: [
          { t: 'Funções de informações DAX', u: 'https://learn.microsoft.com/pt-br/dax/information-functions-dax' },
          { t: 'SELECTEDVALUE', u: 'https://learn.microsoft.com/pt-br/dax/selectedvalue-function-dax' },
          { t: 'INFO.VIEW.TABLES', u: 'https://learn.microsoft.com/pt-br/dax/info-view-tables-function-dax' }
        ]
      },
      {
        id: 'fab-dax-consultas', title: 'Consultas DAX: selecionar, filtrar e agregar',
        desc: 'Escrever consultas DAX com EVALUATE, DEFINE, ORDER BY, SUMMARIZECOLUMNS, TOPN e CALCULATETABLE, na exibição de consulta DAX do Desktop e do serviço.',
        objetivos: [
          'Escrever consultas DAX que retornam tabelas',
          'Agregar com SUMMARIZECOLUMNS e filtrar com CALCULATETABLE',
          'Testar medidas com DEFINE MEASURE e atualizar o modelo',
          'Usar a exibição de consulta DAX e o analisador de desempenho'
        ],
        body: 'Habilidade DP-600 “Selecionar, filtrar e agregar dados usando DAX”. Uma consulta DAX é para o modelo semântico o que um SELECT é para o warehouse: devolve uma tabela e não cria nada no modelo.',
        content: [
          { h: 'Estrutura',
            items: [
              '<strong>EVALUATE</strong> (obrigatório) seguido de uma expressão de tabela. Pode haver vários EVALUATE na mesma consulta.',
              '<strong>ORDER BY</strong> ordena o resultado (a propriedade “classificar por coluna” do modelo não vale na consulta).',
              '<strong>START AT</strong> define o ponto de partida da ordenação.',
              '<strong>DEFINE</strong> declara, só para a consulta, <strong>MEASURE</strong>, <strong>VAR</strong>, <strong>TABLE</strong>, <strong>COLUMN</strong> e funções.'
            ],
            code: `DEFINE
    MEASURE Vendas[Receita] = SUMX ( Vendas, Vendas[Qtd] * Vendas[Preco] )
    VAR AnoAlvo = 2026

EVALUATE
    SUMMARIZECOLUMNS (
        Produto[Categoria],
        'Data'[Mês],
        TREATAS ( { AnoAlvo }, 'Data'[Ano] ),        -- filtro
        "Receita", [Receita],
        "Pedidos", COUNTROWS ( Vendas )
    )
ORDER BY [Receita] DESC` },
          { h: 'Funções de tabela mais usadas',
            items: [
              '<strong>SUMMARIZECOLUMNS</strong> — agrupa por colunas (de várias tabelas), aplica filtros e calcula medidas; é o que os visuais do Power BI geram. Linhas em que todas as medidas são branco são removidas.',
              '<strong>CALCULATETABLE(tabela, filtros)</strong> — devolve a tabela filtrada.',
              '<strong>FILTER</strong>, <strong>TOPN(n, tabela, ordem)</strong> para os N primeiros, <strong>ADDCOLUMNS</strong> para acrescentar colunas calculadas, <strong>SELECTCOLUMNS</strong> para escolher e renomear.',
              'Uma tabela sozinha também é consulta: <code>EVALUATE \'Pedidos\'</code>.'
            ],
            code: `EVALUATE
    TOPN ( 10,
           ADDCOLUMNS ( VALUES ( Cliente[Nome] ), "Receita", [Receita] ),
           [Receita], DESC )

EVALUATE
    CALCULATETABLE ( Vendas, 'Data'[Ano] = 2026, Loja[UF] = "GO" )` },
          { h: 'Exibição de consulta DAX',
            items: [
              'No Power BI Desktop (ícone na lateral) e no serviço/portal do Fabric (<strong>Gravar consultas DAX</strong> no menu do modelo semântico).',
              'Formatar (Shift+Alt+F), comentar (Ctrl+/), várias abas de consulta, e o <strong>Copilot</strong> para escrever e explicar consultas.',
              'Consultas rápidas pelo painel Dados: mostrar as primeiras 100 linhas, estatísticas de coluna, avaliar uma medida.',
              'Medidas definidas no DEFINE podem ser enviadas ao modelo com <strong>Atualizar modelo com alterações</strong> — um ótimo jeito de testar antes de publicar.',
              'Do <strong>Analisador de desempenho</strong>, “Copiar consulta” leva a consulta gerada por um visual para a exibição de consulta DAX, onde você a analisa e otimiza (Módulo 11).'
            ],
            img: { src: `${FAB_IMG}/m10/consulta-dax-layout.png`, alt: 'Layout da exibição de consulta DAX', caption: 'Exibição de consulta DAX: faixa de opções, editor, resultados e painel Dados com consultas rápidas.', source: 'https://learn.microsoft.com/pt-br/power-bi/transform-model/dax-query-view' } },
          { h: 'Como isso cai na prova',
            items: [
              'Palavra-chave obrigatória de uma consulta DAX → EVALUATE.',
              'Total por categoria e mês filtrado por ano → SUMMARIZECOLUMNS com filtro (TREATAS ou CALCULATETABLE).',
              'Os 10 maiores clientes → TOPN.',
              'Testar uma medida nova sem alterar o modelo → DEFINE MEASURE na consulta; depois “Atualizar modelo com alterações”.',
              'Descobrir que consulta um visual lento envia → Analisador de desempenho → Copiar consulta.'
            ] }
        ],
        recursos: [
          { t: 'Consultas DAX', u: 'https://learn.microsoft.com/pt-br/dax/dax-queries' },
          { t: 'Exibição de consulta DAX', u: 'https://learn.microsoft.com/pt-br/power-bi/transform-model/dax-query-view' },
          { t: 'SUMMARIZECOLUMNS', u: 'https://learn.microsoft.com/pt-br/dax/summarizecolumns-function-dax' }
        ]
      }
    ]
  }
];
