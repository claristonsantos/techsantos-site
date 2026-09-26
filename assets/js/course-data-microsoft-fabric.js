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
  }
];
