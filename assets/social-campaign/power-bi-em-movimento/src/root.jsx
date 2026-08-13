import React from 'react';
import {
  AbsoluteFill,
  Audio,
  Composition,
  interpolate,
  spring,
  staticFile,
  useCurrentFrame,
  useVideoConfig,
} from 'remotion';

const C = {
  ink: '#071525',
  navy: '#0d213b',
  panel: '#132b49',
  line: '#294362',
  white: '#f7fbf8',
  muted: '#a9bdd3',
  green: '#78df55',
  greenDark: '#163a2d',
  blue: '#6aa9ff',
};

const FONT = 'Arial, Helvetica, sans-serif';
const MONO = 'Consolas, "Courier New", monospace';

const Grain = ({opacity = 0.05}) => (
  <AbsoluteFill
    style={{
      opacity,
      backgroundImage:
        'radial-gradient(circle at 20% 20%, #ffffff 0 1px, transparent 1px), radial-gradient(circle at 70% 60%, #ffffff 0 1px, transparent 1px)',
      backgroundSize: '37px 37px, 53px 53px',
      mixBlendMode: 'soft-light',
    }}
  />
);

const Brand = ({compact = false}) => (
  <div style={{display: 'flex', alignItems: 'center', gap: compact ? 14 : 18}}>
    <div style={{display: 'flex', gap: 3}}>
      {['T', 'S'].map((letter) => (
        <div
          key={letter}
          style={{
            width: compact ? 42 : 52,
            height: compact ? 48 : 58,
            border: `2px solid ${C.white}`,
            background: C.green,
            color: C.white,
            fontFamily: 'Georgia, serif',
            fontSize: compact ? 30 : 38,
            display: 'grid',
            placeItems: 'center',
          }}
        >
          {letter}
        </div>
      ))}
    </div>
    <div style={{fontFamily: FONT, fontWeight: 900, fontSize: compact ? 28 : 34, color: C.white}}>
      TECH <span style={{color: C.green}}>SANTOS BR</span>
    </div>
  </div>
);

const Progress = ({current, total}) => (
  <div style={{display: 'flex', gap: 10}}>
    {Array.from({length: total}, (_, i) => (
      <div
        key={i}
        style={{width: i === current ? 44 : 14, height: 8, borderRadius: 8, background: i === current ? C.green : C.line}}
      />
    ))}
  </div>
);

const Background = ({accent = C.green}) => {
  const frame = useCurrentFrame();
  const drift = Math.sin(frame / 42) * 5;
  return (
    <AbsoluteFill
      style={{
        background: `radial-gradient(circle at ${70 + drift}% ${28 - drift}%, ${accent}26 0%, transparent 34%), linear-gradient(155deg, ${C.ink}, ${C.navy} 62%, #091827)`,
      }}
    >
      <Grain />
    </AbsoluteFill>
  );
};

const Kicker = ({children}) => (
  <div style={{fontFamily: MONO, fontSize: 28, letterSpacing: 5, color: C.green, textTransform: 'uppercase'}}>{children}</div>
);

const Pop = ({children, delay = 0, y = 38}) => {
  const frame = useCurrentFrame();
  const {fps} = useVideoConfig();
  const p = spring({frame: frame - delay, fps, config: {damping: 200}});
  return <div style={{opacity: p, transform: `translateY(${(1 - p) * y}px)`}}>{children}</div>;
};

const VideoShell = ({children, accent = C.green}) => (
  <AbsoluteFill style={{fontFamily: FONT, color: C.white}}>
    <Background accent={accent} />
    <div style={{position: 'absolute', left: 80, right: 120, top: 330, bottom: 390, display: 'flex', flexDirection: 'column'}}>
      {children}
    </div>
  </AbsoluteFill>
);

const LoopingMusic = () => {
  const frame = useCurrentFrame();
  const {durationInFrames} = useVideoConfig();
  const volume = interpolate(frame, [0, 12, durationInFrames - 30, durationInFrames - 1], [0, 0.42, 0.34, 0], {
    extrapolateLeft: 'clamp',
    extrapolateRight: 'clamp',
  });
  return <Audio src={staticFile('impact-track.wav')} loop volume={volume} />;
};

const ReelMentoria = () => {
  const frame = useCurrentFrame();
  const scene = frame < 90 ? 0 : frame < 240 ? 1 : frame < 510 ? 2 : 3;
  const items = [
    {k: 'PROJETO PARA ENTREGAR', title: 'Travou na modelagem\nou no DAX?', sub: 'Não tente mais uma fórmula aleatória.'},
    {k: 'O PROBLEMA', title: 'Um ajuste rápido pode\ncriar outro erro.', sub: 'Modelo, filtros e medidas precisam trabalhar juntos.'},
    {k: 'MENTORIA INDIVIDUAL', title: 'Revisamos a decisão.\nTestamos a solução.', sub: 'Você entende como manter o projeto sozinho.'},
    {k: 'ONLINE · TODO O BRASIL', title: 'R$ 120 por hora', sub: 'Conte seu objetivo e solicite um horário.'},
  ];
  const starts = [0, 90, 240, 510];
  const local = frame - starts[scene];
  const item = items[scene];
  return (
    <VideoShell accent={scene === 3 ? C.green : C.blue}>
      <LoopingMusic />
      <div style={{display: 'flex', justifyContent: 'space-between', alignItems: 'center'}}>
        <Brand compact />
        <Progress current={scene} total={4} />
      </div>
      <div style={{flex: 1, display: 'flex', flexDirection: 'column', justifyContent: 'center'}}>
        <Pop delay={0}><Kicker>{item.k}</Kicker></Pop>
        <Pop delay={8}>
          <div style={{whiteSpace: 'pre-line', fontSize: scene === 3 ? 90 : 82, lineHeight: 1.03, fontWeight: 900, marginTop: 30, letterSpacing: -3}}>
            {item.title}
          </div>
        </Pop>
        <Pop delay={18}>
          <div style={{fontSize: 43, lineHeight: 1.28, color: C.muted, marginTop: 34, maxWidth: 850}}>{item.sub}</div>
        </Pop>
        {scene === 1 && (
          <div style={{display: 'flex', gap: 18, marginTop: 44}}>
            {['MODELO', 'FILTRO', 'MEDIDA'].map((x, i) => (
              <Pop key={x} delay={26 + i * 6}>
                <div style={{padding: '20px 25px', border: `2px solid ${C.line}`, borderRadius: 16, color: C.white, fontFamily: MONO, fontSize: 28}}>{x}</div>
              </Pop>
            ))}
          </div>
        )}
        {scene === 2 && (
          <div style={{marginTop: 46, display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 18}}>
            {['Modelagem', 'Power Query', 'DAX', 'Desempenho'].map((x, i) => (
              <Pop key={x} delay={30 + i * 7}>
                <div style={{background: C.panel, border: `1px solid ${C.line}`, borderRadius: 18, padding: '23px 26px', fontSize: 31}}>
                  <span style={{color: C.green, marginRight: 14}}>✓</span>{x}
                </div>
              </Pop>
            ))}
          </div>
        )}
        {scene === 3 && (
          <Pop delay={24}>
            <div style={{display: 'inline-flex', marginTop: 44, background: C.green, color: C.ink, borderRadius: 16, padding: '24px 34px', fontWeight: 900, fontSize: 36}}>
              SOLICITAR HORÁRIO →
            </div>
          </Pop>
        )}
      </div>
      <div style={{fontFamily: MONO, fontSize: 24, color: C.muted}}>techsantos.com.br/aulas</div>
      <div style={{position: 'absolute', opacity: 0}}>{local}</div>
    </VideoShell>
  );
};

const painPoints = [
  ['01', 'Relacionamentos', 'que duplicam números'],
  ['02', 'Power Query', 'que quebra na atualização'],
  ['03', 'Medida DAX', 'que ignora o filtro'],
  ['04', 'Dashboard', 'confuso ou lento'],
  ['05', 'Fabric', 'Dataflow Gen2 ou pipeline'],
];

const ReelProblemas = () => {
  const frame = useCurrentFrame();
  const itemIndex = Math.max(0, Math.min(4, Math.floor((frame - 90) / 60)));
  const intro = frame < 90;
  const outro = frame >= 390;
  const item = painPoints[itemIndex];
  return (
    <VideoShell accent={outro ? C.green : C.blue}>
      <LoopingMusic />
      <div style={{display: 'flex', justifyContent: 'space-between', alignItems: 'center'}}>
        <Brand compact />
        {!intro && !outro && <div style={{fontFamily: MONO, color: C.green, fontSize: 28}}>{itemIndex + 1}/5</div>}
      </div>
      <div style={{flex: 1, display: 'flex', flexDirection: 'column', justifyContent: 'center'}}>
        {intro && <>
          <Pop><Kicker>AULA PARTICULAR</Kicker></Pop>
          <Pop delay={8}><div style={{fontSize: 84, lineHeight: 1.04, fontWeight: 900, marginTop: 30}}>Qual destes pontos<br/><span style={{color: C.green}}>bloqueia você?</span></div></Pop>
        </>}
        {!intro && !outro && <>
          <Pop><div style={{fontFamily: MONO, fontSize: 122, fontWeight: 900, color: C.green}}>{item[0]}</div></Pop>
          <Pop delay={6}><div style={{fontSize: 84, lineHeight: 1.03, fontWeight: 900, marginTop: 20}}>{item[1]}</div></Pop>
          <Pop delay={12}><div style={{fontSize: 47, lineHeight: 1.25, color: C.muted, marginTop: 30}}>{item[2]}</div></Pop>
          <div style={{height: 9, background: C.line, borderRadius: 8, marginTop: 58, overflow: 'hidden'}}>
            <div style={{height: '100%', width: `${((itemIndex + 1) / 5) * 100}%`, background: C.green}} />
          </div>
        </>}
        {outro && <>
          <Pop><Kicker>DO SEU PROBLEMA PARA A SOLUÇÃO</Kicker></Pop>
          <Pop delay={8}><div style={{fontSize: 77, lineHeight: 1.04, fontWeight: 900, marginTop: 28}}>Traga sua dúvida<br/>para uma <span style={{color: C.green}}>aula individual.</span></div></Pop>
          <Pop delay={18}><div style={{fontSize: 42, color: C.muted, marginTop: 32}}>Escolha uma data e conte seu objetivo.</div></Pop>
          <Pop delay={28}><div style={{display: 'inline-flex', marginTop: 44, background: C.green, color: C.ink, borderRadius: 16, padding: '24px 34px', fontWeight: 900, fontSize: 36}}>SOLICITAR HORÁRIO →</div></Pop>
        </>}
      </div>
      <div style={{fontFamily: MONO, fontSize: 24, color: C.muted}}>Power BI · Excel · DAX · Microsoft Fabric</div>
    </VideoShell>
  );
};

const SlideShell = ({children, index, dark = true}) => (
  <AbsoluteFill style={{background: dark ? C.ink : C.white, color: dark ? C.white : C.ink, fontFamily: FONT}}>
    <AbsoluteFill style={{background: dark ? `radial-gradient(circle at 82% 12%, ${C.green}22, transparent 33%)` : `radial-gradient(circle at 80% 15%, ${C.green}35, transparent 32%)`}} />
    <Grain opacity={dark ? 0.05 : 0.025} />
    <div style={{position: 'absolute', inset: 80, display: 'flex', flexDirection: 'column'}}>
      <div style={{display: 'flex', justifyContent: 'space-between', alignItems: 'center'}}>
        <Brand compact />
        <div style={{fontFamily: MONO, fontSize: 25, color: dark ? C.muted : C.navy}}>{String(index).padStart(2, '0')}/04</div>
      </div>
      {children}
    </div>
  </AbsoluteFill>
);

const Quote = ({children}) => (
  <div style={{fontSize: 54, lineHeight: 1.28, fontWeight: 800, letterSpacing: -1.5}}>
    <span style={{display: 'block', color: C.green, fontFamily: 'Georgia, serif', fontSize: 120, height: 84}}>“</span>
    {children}
  </div>
);

const Carousel1 = () => <SlideShell index={1}>
  <div style={{flex: 1, display: 'flex', flexDirection: 'column', justifyContent: 'center'}}>
    <Kicker>AULAS PARTICULARES</Kicker>
    <div style={{fontSize: 88, lineHeight: 1.01, fontWeight: 900, letterSpacing: -4, marginTop: 34}}>Clareza para<br/>entender.</div>
    <div style={{fontSize: 88, lineHeight: 1.01, fontWeight: 900, letterSpacing: -4, color: C.green}}>Prática para fixar.</div>
    <div style={{fontSize: 35, lineHeight: 1.4, color: C.muted, marginTop: 46}}>O objetivo não é decorar uma resposta.<br/>É aprender o raciocínio para repetir sozinho.</div>
  </div>
  <div style={{display: 'flex', justifyContent: 'space-between', fontFamily: MONO, fontSize: 25, color: C.muted}}><span>ARRASTE PARA VER</span><span style={{color: C.green}}>→</span></div>
</SlideShell>;

const Carousel2 = () => <SlideShell index={2}>
  <div style={{flex: 1, display: 'flex', flexDirection: 'column', justifyContent: 'center'}}>
    <Quote>Ele me ensinou de forma clara e objetiva e demonstrou dominar o assunto, além de ser muito atencioso.</Quote>
    <div style={{marginTop: 58, borderTop: `2px solid ${C.line}`, paddingTop: 28, fontFamily: MONO, fontSize: 27, color: C.muted}}>AVALIAÇÃO PÚBLICA DE ALUNA · SUPERPROF</div>
  </div>
  <div style={{textAlign: 'right', color: C.green, fontSize: 38}}>→</div>
</SlideShell>;

const Carousel3 = () => <SlideShell index={3}>
  <div style={{flex: 1, display: 'flex', flexDirection: 'column', justifyContent: 'center'}}>
    <Quote>Aulas conceituais e práticas para a melhor fixação do conteúdo lecionado.</Quote>
    <div style={{marginTop: 58, borderTop: `2px solid ${C.line}`, paddingTop: 28, fontFamily: MONO, fontSize: 27, color: C.muted}}>AVALIAÇÃO PÚBLICA DE ALUNO · SUPERPROF</div>
  </div>
  <div style={{textAlign: 'right', color: C.green, fontSize: 38}}>→</div>
</SlideShell>;

const Carousel4 = () => <SlideShell index={4}>
  <div style={{flex: 1, display: 'flex', flexDirection: 'column', justifyContent: 'center'}}>
    <Kicker>ONLINE · TODO O BRASIL</Kicker>
    <div style={{fontSize: 80, lineHeight: 1.02, fontWeight: 900, letterSpacing: -3, marginTop: 34}}>A aula parte da<br/><span style={{color: C.green}}>sua dúvida.</span></div>
    <div style={{display: 'flex', flexWrap: 'wrap', gap: 14, marginTop: 48}}>
      {['Power BI', 'Excel', 'Power Query', 'DAX', 'Microsoft Fabric'].map((x) => <div key={x} style={{border: `2px solid ${C.line}`, borderRadius: 999, padding: '17px 24px', fontSize: 29}}>{x}</div>)}
    </div>
    <div style={{marginTop: 55, background: C.green, color: C.ink, borderRadius: 18, padding: '26px 32px', fontSize: 34, fontWeight: 900, textAlign: 'center'}}>SOLICITE SUA AULA INDIVIDUAL →</div>
  </div>
  <div style={{fontFamily: MONO, fontSize: 25, color: C.muted}}>techsantos.com.br/aulas</div>
</SlideShell>;

export const Root = () => (
  <>
    <Composition id="C03ProjetoParaEntregar" component={ReelMentoria} durationInFrames={690} fps={30} width={1080} height={1920} />
    <Composition id="C05QualSeuProblema" component={ReelProblemas} durationInFrames={600} fps={30} width={1080} height={1920} />
    <Composition id="C04ProvaAlunosSlide1" component={Carousel1} durationInFrames={1} fps={1} width={1080} height={1350} />
    <Composition id="C04ProvaAlunosSlide2" component={Carousel2} durationInFrames={1} fps={1} width={1080} height={1350} />
    <Composition id="C04ProvaAlunosSlide3" component={Carousel3} durationInFrames={1} fps={1} width={1080} height={1350} />
    <Composition id="C04ProvaAlunosSlide4" component={Carousel4} durationInFrames={1} fps={1} width={1080} height={1350} />
  </>
);
