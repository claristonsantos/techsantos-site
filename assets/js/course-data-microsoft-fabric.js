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
  }
];
