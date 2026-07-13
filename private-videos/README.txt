Coloque aqui os arquivos de vídeo das aulas, um .mp4 por aula.

O nome do arquivo precisa ser exatamente o "id" da aula, em minúsculas,
igual ao usado em aluno/index.php. Exemplos:

  introducao.mp4
  importancia-modelagem.mp4
  normalizacao-desnormalizacao.mp4
  esquema-estrela.mp4
  intro-power-query.mp4

Atualização (13/07/2026): os vídeos NÃO são mais hospedados no Hostinger.
Eles ficam num container privado no Azure Blob Storage (conta
"techsantosvideos", container "course-videos"), porque o volume de vídeo
(600+ MB) estava causando erro 429 (rate limit) no upload da Hostinger a
cada deploy — mesmo quando só uma linha de código mudava.

video.php continua exigindo aluno logado, mas agora gera uma URL SAS
(assinada, expira em 4h) e redireciona o navegador direto pro Azure, em
vez de ler o arquivo local. Esta pasta local serve só de backup/histórico
— o conteúdo dela NÃO entra mais no zip de deploy.

Pra adicionar um vídeo novo: subir o .mp4 direto pro container do Azure
com o nome "<id-da-aula>.mp4" (via Azure CLI, Storage Explorer, ou portal),
não precisa mais colocar aqui nem redeployar o site.

Exemplo de comando (Azure CLI):
  az storage blob upload --account-name techsantosvideos --container-name course-videos --name <id-da-aula>.mp4 --file <caminho-local> --auth-mode key --account-key "<AZURE_STORAGE_KEY em config.php>"
