const fs = require('node:fs');

if (process.stdin.isTTY && process.stdin.setRawMode) process.stdin.setRawMode(true);
process.stdin.resume();
let input = '';
process.stdin.on('data', async chunk => {
  input += chunk.toString();
  if (!/[\r\n]/.test(input)) return;
  process.stdin.pause();
  try {
    const {url, auth_key, rest_auth_key, source, destination} = JSON.parse(input.trim());
    const data = fs.readFileSync(source);
    const endpoint = `${url.replace(/\/$/, '')}/${destination}?override=true`;
    const base = {'X-Auth':auth_key,'X-Auth-Rest':rest_auth_key,'Tus-Resumable':'1.0.0','Upload-Length':String(data.length),'Upload-Offset':'0'};
    const created = await fetch(endpoint,{method:'POST',headers:base});
    if(created.status!==201) throw new Error(`create ${created.status}`);
    const uploaded = await fetch(endpoint,{method:'PATCH',headers:{...base,'Content-Type':'application/offset+octet-stream'},body:data});
    if(uploaded.status!==204) throw new Error(`upload ${uploaded.status}`);
    process.stdout.write(JSON.stringify({ok:true,destination,bytes:data.length,offset:uploaded.headers.get('upload-offset')}));
  } catch(error) { process.stderr.write(String(error)); process.exitCode=1; }
  finally { if(process.stdin.isTTY&&process.stdin.setRawMode) process.stdin.setRawMode(false); process.exit(); }
});
