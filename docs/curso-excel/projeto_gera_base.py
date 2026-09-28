import random, datetime as d, collections
random.seed(2026)
vend=["Ana Paula","Bruno Lima","Carla Reis","Diego Souza"]
cli=[("Colégio Aurora","Itumbiara","GO"),("Escritório Contábil Vale","Goiânia","GO"),("Livraria Cerrado","Uberlândia","MG"),("Colégio Aurora","Itumbiara","GO"),("Construtora Paranaíba","Caldas Novas","GO"),("Clínica Bem Viver","Uberlândia","MG"),("Prefeitura de Buriti Alegre","Buriti Alegre","GO"),("Escritório Contábil Vale","Goiânia","GO")]
prod=[("Papel","Resma A4 500 folhas",28.9),("Papel","Papel Kraft rolo",64.0),("Escrita","Caneta esferográfica cx 50",42.5),("Escrita","Marca-texto kit 6",19.9),("Organização","Pasta suspensa cx 10",37.0),("Organização","Arquivo morto 10 un",55.0),("Informática","Toner compatível",119.0),("Informática","Pen drive 64 GB",45.9)]
rows=[]; day=d.date(2026,9,1)
for i in range(1,31):
    day+=d.timedelta(days=random.choice([0,1,1,2]))
    if day.weekday()>4: day+=d.timedelta(days=7-day.weekday())
    c=random.choice(cli); p=random.choice(prod); q=random.choice([2,3,5,5,8,10,12,20])
    rows.append((f"P{1000+i}",day,c[0],c[1],c[2],random.choice(vend),p[0],p[1],q,p[2]))
print("Pedido;Data;Cliente;Cidade;UF;Vendedor;Categoria;Produto;Qtd;PrecoUnit")
for r in rows: print(f"{r[0]};{r[1].strftime('%d/%m/%Y')};{r[2]};{r[3]};{r[4]};{r[5]};{r[6]};{r[7]};{r[8]};{str(r[9]).replace('.',',')}")
tot=lambda r:round(r[8]*r[9],2)
import sys
print("---",file=sys.stderr)
print("linhas",len(rows),"total",round(sum(tot(r) for r in rows),2),file=sys.stderr)
for k,f in [("vend",5),("cat",6),("uf",4),("cli",2)]:
    agg=collections.defaultdict(float)
    for r in rows: agg[r[f]]+=tot(r)
    print(k,{a:round(b,2) for a,b in sorted(agg.items(),key=lambda x:-x[1])},file=sys.stderr)
print("pedidos GO>500",sum(1 for r in rows if r[4]=="GO" and tot(r)>500),file=sys.stderr)
print("maior pedido",max(rows,key=tot)[0],max(tot(r) for r in rows),file=sys.stderr)
print("clientes distintos",len(set(r[2] for r in rows)),file=sys.stderr)
print("ultima data",rows[-1][1],"primeira",rows[0][1],file=sys.stderr)
out=[r for r in rows if r[1].month==10]; print("pedidos outubro",len(out),file=sys.stderr)
