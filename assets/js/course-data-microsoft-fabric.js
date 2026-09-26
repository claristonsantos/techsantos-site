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
  }
];
