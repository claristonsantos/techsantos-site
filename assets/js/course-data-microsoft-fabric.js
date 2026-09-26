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
  }
];
