// Curso de Python do zero até Python para dados (pandas, gráficos e automação de planilhas) — TECH SANTOS BR.
// Mesmo formato do curso de Inglês: teoria em português, prática interativa (assets/js/pratica.js,
// tipos escolha/lacuna com `codigo`, ordenar e pares) e o laboratório de Python
// (assets/js/python-lab.js): os blocos `code` da aula ganham "▶ Executar" e cada aula
// tem desafios de cenário (`desafios`) em que o aluno escreve o script e o site confere.
// O Python roda no navegador do aluno (Pyodide); nada é executado no servidor.
// Testes dos desafios: código Python executado depois do script do aluno, no mesmo
// escopo (enxerga as variáveis dele), mais `saida` (tudo o que ele imprimiu) e `linhas`.
// Ids de aula com prefixo "py-" para não colidir com o progresso dos outros cursos.
// Arquivos de exemplo dos desafios (dados sintéticos, gerados para o curso).
const PY_ARQ = {
  "vendas.csv": "data,vendedor,regiao,produto,quantidade,preco_unit\n2026-01-07,Diego,Sul,Webcam,5,219.0\n2026-01-09,Bruno,Sudeste,Teclado,1,89.9\n2026-01-09,Bruno,Sudeste,Webcam,5,219.0\n2026-01-16,Carla,Nordeste,Headset,2,159.0\n2026-01-17,Ana,Centro-Oeste,Mouse,3,49.9\n2026-01-17,Ana,Centro-Oeste,Webcam,1,219.0\n2026-01-17,Bruno,Sudeste,Webcam,2,219.0\n2026-01-19,Carla,Nordeste,Teclado,1,89.9\n2026-01-19,Diego,Sul,Teclado,2,89.9\n2026-01-20,Bruno,Sudeste,Headset,5,159.0\n2026-01-21,Carla,Nordeste,Headset,3,159.0\n2026-01-24,Ana,Centro-Oeste,Webcam,2,219.0\n2026-01-25,Bruno,Sudeste,Headset,2,159.0\n2026-01-26,Diego,Sul,Teclado,2,89.9\n2026-02-01,Ana,Centro-Oeste,Mouse,1,49.9\n2026-02-01,Carla,Nordeste,Webcam,5,219.0\n2026-02-01,Diego,Sul,Mouse,5,49.9\n2026-02-02,Bruno,Sudeste,Teclado,3,89.9\n2026-02-10,Ana,Centro-Oeste,Mouse,6,49.9\n2026-02-16,Carla,Nordeste,Headset,3,159.0\n2026-02-16,Diego,Sul,Webcam,1,219.0\n2026-02-19,Diego,Sul,Monitor,3,799.0\n2026-02-21,Diego,Sul,Monitor,6,799.0\n2026-02-24,Diego,Sul,Mouse,2,49.9\n2026-02-26,Carla,Nordeste,Headset,2,159.0\n2026-02-26,Carla,Nordeste,Mouse,5,49.9\n",
  "vendas_br.csv": "data;vendedor;regiao;produto;quantidade;preco_unit\n2026-03-01;Diego;Sul;Monitor;2;799,0\n2026-03-03;Diego;Sul;Monitor;5;799,0\n2026-03-04;Bruno;Sudeste;Webcam;5;219,0\n2026-03-09;Ana;Centro-Oeste;Webcam;4;219,0\n2026-03-10;Diego;Sul;Webcam;1;219,0\n2026-03-12;Carla;Nordeste;Teclado;5;89,9\n2026-03-16;Bruno;Sudeste;Mouse;2;49,9\n2026-03-20;Bruno;Sudeste;Teclado;1;89,9\n2026-03-20;Carla;Nordeste;Webcam;5;219,0\n2026-03-20;Diego;Sul;Mouse;5;49,9\n2026-03-21;Ana;Centro-Oeste;Webcam;5;219,0\n2026-03-22;Bruno;Sudeste;Headset;2;159,0\n2026-03-22;Carla;Nordeste;Mouse;2;49,9\n2026-03-26;Diego;Sul;Monitor;3;799,0\n2026-03-28;Ana;Centro-Oeste;Mouse;4;49,9\n",
  "mes_jan.csv": "data,vendedor,regiao,produto,quantidade,preco_unit\n2026-01-07,Diego,Sul,Webcam,5,219.0\n2026-01-09,Bruno,Sudeste,Teclado,1,89.9\n2026-01-09,Bruno,Sudeste,Webcam,5,219.0\n2026-01-16,Carla,Nordeste,Headset,2,159.0\n2026-01-17,Ana,Centro-Oeste,Mouse,3,49.9\n2026-01-17,Ana,Centro-Oeste,Webcam,1,219.0\n2026-01-17,Bruno,Sudeste,Webcam,2,219.0\n2026-01-19,Carla,Nordeste,Teclado,1,89.9\n2026-01-19,Diego,Sul,Teclado,2,89.9\n2026-01-20,Bruno,Sudeste,Headset,5,159.0\n2026-01-21,Carla,Nordeste,Headset,3,159.0\n2026-01-24,Ana,Centro-Oeste,Webcam,2,219.0\n2026-01-25,Bruno,Sudeste,Headset,2,159.0\n2026-01-26,Diego,Sul,Teclado,2,89.9\n",
  "mes_fev.csv": "data,vendedor,regiao,produto,quantidade,preco_unit\n2026-02-01,Ana,Centro-Oeste,Mouse,1,49.9\n2026-02-01,Carla,Nordeste,Webcam,5,219.0\n2026-02-01,Diego,Sul,Mouse,5,49.9\n2026-02-02,Bruno,Sudeste,Teclado,3,89.9\n2026-02-10,Ana,Centro-Oeste,Mouse,6,49.9\n2026-02-16,Carla,Nordeste,Headset,3,159.0\n2026-02-16,Diego,Sul,Webcam,1,219.0\n2026-02-19,Diego,Sul,Monitor,3,799.0\n2026-02-21,Diego,Sul,Monitor,6,799.0\n2026-02-24,Diego,Sul,Mouse,2,49.9\n2026-02-26,Carla,Nordeste,Headset,2,159.0\n2026-02-26,Carla,Nordeste,Mouse,5,49.9\n",
  "mes_mar.csv": "data,vendedor,regiao,produto,quantidade,preco_unit\n2026-03-01,Diego,Sul,Monitor,2,799.0\n2026-03-03,Diego,Sul,Monitor,5,799.0\n2026-03-04,Bruno,Sudeste,Webcam,5,219.0\n2026-03-09,Ana,Centro-Oeste,Webcam,4,219.0\n2026-03-10,Diego,Sul,Webcam,1,219.0\n2026-03-12,Carla,Nordeste,Teclado,5,89.9\n2026-03-16,Bruno,Sudeste,Mouse,2,49.9\n2026-03-20,Bruno,Sudeste,Teclado,1,89.9\n2026-03-20,Carla,Nordeste,Webcam,5,219.0\n2026-03-20,Diego,Sul,Mouse,5,49.9\n2026-03-21,Ana,Centro-Oeste,Webcam,5,219.0\n2026-03-22,Bruno,Sudeste,Headset,2,159.0\n2026-03-22,Carla,Nordeste,Mouse,2,49.9\n2026-03-26,Diego,Sul,Monitor,3,799.0\n2026-03-28,Ana,Centro-Oeste,Mouse,4,49.9\n",
  "sistema.log": "2026-03-10 08:29 ERRO Pedido 1000: pagamento recusado\n2026-03-10 10:23 ERRO Pedido 1001: estoque insuficiente\n2026-03-10 12:08 INFO Pedido 1002 faturado\n2026-03-10 14:55 INFO Pedido 1003 recebido\n2026-03-10 16:21 ERRO Pedido 1004: pagamento recusado\n2026-03-10 18:29 ERRO Pedido 1005: pagamento recusado\n2026-03-11 08:05 ERRO Pedido 1006: estoque insuficiente\n2026-03-11 10:35 ERRO Pedido 1007: pagamento recusado\n2026-03-11 12:44 INFO Pedido 1008 recebido\n2026-03-11 14:46 AVISO Pedido 1009: endereço incompleto\n2026-03-11 16:10 AVISO Pedido 1010: endereço incompleto\n2026-03-11 18:46 AVISO Pedido 1011: endereço incompleto\n2026-03-12 08:10 INFO Pedido 1012 faturado\n2026-03-12 10:15 INFO Pedido 1013 recebido\n2026-03-12 12:07 INFO Pedido 1014 faturado\n2026-03-12 14:32 ERRO Pedido 1015: pagamento recusado\n2026-03-12 16:04 AVISO Pedido 1016: endereço incompleto\n2026-03-12 18:50 INFO Pedido 1017 recebido\n2026-03-13 08:58 ERRO Pedido 1018: estoque insuficiente\n2026-03-13 10:13 INFO Pedido 1019 faturado\n2026-03-13 12:46 AVISO Pedido 1020: endereço incompleto\n2026-03-13 14:56 INFO Pedido 1021 recebido\n2026-03-13 16:49 ERRO Pedido 1022: estoque insuficiente\n2026-03-13 18:58 INFO Pedido 1023 faturado\n"
};

Object.assign(PY_ARQ, {
  "vendas_2026.csv": "pedido,data,cliente_id,vendedor,regiao,categoria,produto,quantidade,preco_unit\nP1001,2026-01-05,C007,Ana,Centro-Oeste,Periféricos,Teclado,10,89.9\nP1002,2026-01-05,C022,Ana,Centro-Oeste,Acessórios,Mousepad,2,39.9\nP1003,2026-01-05,C027,Ana,Centro-Oeste,Periféricos,Teclado,1,89.9\nP1004,2026-01-06,C002,Diego,Sul,Acessórios,Suporte,12,119.0\nP1005,2026-01-09,C020,Ana,Centro-Oeste,Periféricos,Mouse,8,49.9\nP1006,2026-01-10,C010,Bruno,Sudeste,Notebooks,Notebook i7,1,5490.0\nP1007,2026-01-11,C015,Ana,Centro-Oeste,Monitores,Monitor 24,3,799.0\nP1008,2026-01-12,C019,Diego,Sul,Periféricos,Teclado,6,89.9\nP1009,2026-01-14,C015,Ana,Centro-Oeste,Periféricos,Webcam,8,219.0\nP1010,2026-01-16,C004,Ana,Centro-Oeste,Periféricos,Headset,2,159.0\nP1011,2026-01-18,C001,Ana,Centro-Oeste,Periféricos,Headset,7,159.0\nP1012,2026-01-18,C009,Carla,Nordeste,Acessórios,Cabo HDMI,5,29.9\nP1013,2026-01-20,C005,Elisa,Sudeste,Monitores,Monitor 27,3,1290.0\nP1014,2026-01-21,C012,Carla,Nordeste,Periféricos,Teclado,1,89.9\nP1015,2026-01-21,C025,Fábio,Norte,Acessórios,Mousepad,9,39.9\nP1016,2026-01-22,C009,Diego,Sul,Periféricos,Headset,3,159.0\nP1017,2026-01-23,C001,Elisa,Sudeste,Periféricos,Mouse,2,49.9\nP1018,2026-01-23,C009,Bruno,Sudeste,Acessórios,Suporte,9,119.0\nP1019,2026-01-23,C014,Elisa,Sudeste,Acessórios,Suporte,6,119.0\nP1020,2026-01-23,C023,Carla,Nordeste,Periféricos,Headset,3,159.0\nP1021,2026-01-24,C019,Fábio,Norte,Monitores,Monitor 27,3,1290.0\nP1022,2026-01-25,C001,Bruno,Sudeste,Notebooks,Notebook i7,1,5490.0\nP1023,2026-01-25,C016,Elisa,Sudeste,Acessórios,Mousepad,6,39.9\nP1024,2026-01-25,C022,Diego,Sul,Notebooks,Notebook i7,3,5490.0\nP1025,2026-01-26,C015,Bruno,Sudeste,Periféricos,Headset,12,159.0\nP1026,2026-01-26,C024,Diego,Sul,Periféricos,Teclado,6,89.9\nP1027,2026-01-26,C027,Ana,Centro-Oeste,Acessórios,Mousepad,3,39.9\nP1028,2026-01-27,C002,Ana,Centro-Oeste,Monitores,Monitor 27,3,1290.0\nP1029,2026-01-27,C003,Ana,Centro-Oeste,Periféricos,Webcam,11,219.0\nP1030,2026-01-27,C018,Bruno,Sudeste,Periféricos,Headset,11,159.0\nP1031,2026-01-28,C002,Diego,Sul,Periféricos,Headset,1,159.0\nP1032,2026-01-29,C003,Diego,Sul,Periféricos,Teclado,2,89.9\nP1033,2026-01-30,C020,Elisa,Sudeste,Periféricos,Mouse,10,49.9\nP1034,2026-01-31,C028,Elisa,Sudeste,Monitores,Monitor 27,2,1290.0\nP1035,2026-02-01,C015,Elisa,Sudeste,Monitores,Monitor 27,3,1290.0\nP1036,2026-02-02,C013,Carla,Nordeste,Periféricos,Webcam,11,219.0\nP1037,2026-02-02,C021,Ana,Centro-Oeste,Periféricos,Headset,10,159.0\nP1038,2026-02-03,C005,Bruno,Sudeste,Monitores,Monitor 27,2,1290.0\nP1039,2026-02-04,C003,Ana,Centro-Oeste,Periféricos,Webcam,7,219.0\nP1040,2026-02-08,C010,Fábio,Norte,Acessórios,Mousepad,5,39.9\nP1041,2026-02-11,C014,Elisa,Sudeste,Acessórios,Suporte,12,119.0\nP1042,2026-02-13,C028,Ana,Centro-Oeste,Periféricos,Teclado,8,89.9\nP1043,2026-02-14,C005,Bruno,Sudeste,Notebooks,Notebook i5,3,3899.0\nP1044,2026-02-14,C009,Elisa,Sudeste,Periféricos,Headset,2,159.0\nP1045,2026-02-14,C014,Diego,Sul,Periféricos,Teclado,2,89.9\nP1046,2026-02-15,C013,Diego,Sul,Monitores,Monitor 24,1,799.0\nP1047,2026-02-15,C027,Carla,Nordeste,Acessórios,Mousepad,9,39.9\nP1048,2026-02-16,C015,Bruno,Sudeste,Periféricos,Headset,3,159.0\nP1049,2026-02-16,C017,Carla,Nordeste,Monitores,Monitor 27,1,1290.0\nP1050,2026-02-17,C018,Ana,Centro-Oeste,Periféricos,Mouse,6,49.9\nP1051,2026-02-18,C019,Fábio,Norte,Monitores,Monitor 27,2,1290.0\nP1052,2026-02-19,C001,Bruno,Sudeste,Monitores,Monitor 24,2,799.0\nP1053,2026-02-19,C004,Carla,Nordeste,Periféricos,Teclado,2,89.9\nP1054,2026-02-19,C006,Ana,Centro-Oeste,Periféricos,Webcam,4,219.0\nP1055,2026-02-19,C011,Elisa,Sudeste,Acessórios,Cabo HDMI,3,29.9\nP1056,2026-02-19,C012,Fábio,Norte,Monitores,Monitor 27,2,1290.0\nP1057,2026-02-21,C020,Elisa,Sudeste,Periféricos,Teclado,3,89.9\nP1058,2026-02-21,C022,Ana,Centro-Oeste,Acessórios,Suporte,12,119.0\nP1059,2026-02-26,C004,Elisa,Sudeste,Periféricos,Mouse,3,49.9\nP1060,2026-02-26,C017,Diego,Sul,Periféricos,Headset,11,159.0\nP1061,2026-02-26,C023,Ana,Centro-Oeste,Periféricos,Mouse,1,49.9\nP1062,2026-02-27,C010,Diego,Sul,Periféricos,Mouse,12,49.9\nP1063,2026-02-27,C020,Ana,Centro-Oeste,Periféricos,Webcam,7,219.0\nP1064,2026-02-28,C021,Carla,Nordeste,Acessórios,Cabo HDMI,7,29.9\nP1065,2026-03-01,C027,Ana,Centro-Oeste,Periféricos,Webcam,7,219.0\nP1066,2026-03-02,C007,Fábio,Norte,Notebooks,Notebook i7,1,5490.0\nP1067,2026-03-03,C014,Bruno,Sudeste,Periféricos,Teclado,9,89.9\nP1068,2026-03-04,C007,Bruno,Sudeste,Periféricos,Mouse,9,49.9\nP1069,2026-03-04,C012,Bruno,Sudeste,Notebooks,Notebook i7,1,5490.0\nP1070,2026-03-05,C003,Ana,Centro-Oeste,Periféricos,Webcam,9,219.0\nP1071,2026-03-05,C011,Diego,Sul,Acessórios,Cabo HDMI,11,29.9\nP1072,2026-03-05,C024,Carla,Nordeste,Monitores,Monitor 24,2,799.0\nP1073,2026-03-06,C025,Ana,Centro-Oeste,Monitores,Monitor 27,3,1290.0\nP1074,2026-03-07,C015,Ana,Centro-Oeste,Monitores,Monitor 27,3,1290.0\nP1075,2026-03-07,C021,Elisa,Sudeste,Periféricos,Headset,9,159.0\nP1076,2026-03-08,C003,Ana,Centro-Oeste,Periféricos,Teclado,9,89.9\nP1077,2026-03-08,C004,Fábio,Norte,Monitores,Monitor 24,2,799.0\nP1078,2026-03-08,C021,Diego,Sul,Acessórios,Suporte,1,119.0\nP1079,2026-03-09,C007,Diego,Sul,Periféricos,Headset,1,159.0\nP1080,2026-03-11,C017,Carla,Nordeste,Periféricos,Mouse,8,49.9\nP1081,2026-03-11,C019,Elisa,Sudeste,Notebooks,Notebook i5,2,3899.0\nP1082,2026-03-12,C021,Fábio,Norte,Monitores,Monitor 27,2,1290.0\nP1083,2026-03-12,C028,Diego,Sul,Periféricos,Mouse,8,49.9\nP1084,2026-03-13,C023,Elisa,Sudeste,Monitores,Monitor 24,3,799.0\nP1085,2026-03-14,C019,Elisa,Sudeste,Acessórios,Mousepad,4,39.9\nP1086,2026-03-16,C003,Elisa,Sudeste,Notebooks,Notebook i7,2,5490.0\nP1087,2026-03-17,C010,Carla,Nordeste,Periféricos,Webcam,1,219.0\nP1088,2026-03-17,C013,Carla,Nordeste,Monitores,Monitor 27,1,1290.0\nP1089,2026-03-17,C023,Diego,Sul,Acessórios,Suporte,4,119.0\nP1090,2026-03-18,C013,Ana,Centro-Oeste,Acessórios,Cabo HDMI,8,29.9\nP1091,2026-03-18,C020,Carla,Nordeste,Periféricos,Mouse,11,49.9\nP1092,2026-03-18,C027,Elisa,Sudeste,Periféricos,Mouse,2,49.9\nP1093,2026-03-21,C008,Diego,Sul,Periféricos,Webcam,12,219.0\nP1094,2026-03-21,C028,Carla,Nordeste,Acessórios,Suporte,2,119.0\nP1095,2026-03-22,C006,Ana,Centro-Oeste,Acessórios,Mousepad,4,39.9\nP1096,2026-03-22,C011,Carla,Nordeste,Acessórios,Cabo HDMI,3,29.9\nP1097,2026-03-23,C001,Carla,Nordeste,Acessórios,Mousepad,10,39.9\nP1098,2026-03-23,C006,Bruno,Sudeste,Acessórios,Mousepad,2,39.9\nP1099,2026-03-24,C018,Fábio,Norte,Periféricos,Mouse,2,49.9\nP1100,2026-03-26,C009,Diego,Sul,Periféricos,Teclado,7,89.9\nP1101,2026-03-26,C015,Diego,Sul,Acessórios,Suporte,5,119.0\nP1102,2026-03-27,C005,Ana,Centro-Oeste,Periféricos,Webcam,5,219.0\nP1103,2026-03-27,C026,Ana,Centro-Oeste,Acessórios,Mousepad,3,39.9\nP1104,2026-03-29,C011,Fábio,Norte,Periféricos,Teclado,11,89.9\nP1105,2026-03-29,C021,Ana,Centro-Oeste,Notebooks,Notebook i7,3,5490.0\nP1106,2026-03-29,C022,Elisa,Sudeste,Acessórios,Cabo HDMI,12,29.9\nP1107,2026-03-30,C015,Bruno,Sudeste,Periféricos,Webcam,11,219.0\nP1108,2026-04-01,C020,Bruno,Sudeste,Periféricos,Mouse,10,49.9\nP1109,2026-04-02,C004,Elisa,Sudeste,Acessórios,Cabo HDMI,9,29.9\nP1110,2026-04-02,C026,Elisa,Sudeste,Notebooks,Notebook i5,3,3899.0\nP1111,2026-04-03,C001,Diego,Sul,Acessórios,Suporte,8,119.0\nP1112,2026-04-03,C022,Diego,Sul,Periféricos,Teclado,12,89.9\nP1113,2026-04-04,C010,Diego,Sul,Monitores,Monitor 24,3,799.0\nP1114,2026-04-05,C012,Diego,Sul,Periféricos,Webcam,5,219.0\nP1115,2026-04-05,C020,Elisa,Sudeste,Monitores,Monitor 24,3,799.0\nP1116,2026-04-05,C024,Bruno,Sudeste,Monitores,Monitor 27,2,1290.0\nP1117,2026-04-08,C006,Fábio,Norte,Periféricos,Webcam,4,219.0\nP1118,2026-04-09,C009,Bruno,Sudeste,Periféricos,Mouse,7,49.9\nP1119,2026-04-10,C008,Diego,Sul,Periféricos,Webcam,11,219.0\nP1120,2026-04-12,C004,Diego,Sul,Monitores,Monitor 24,3,799.0\nP1121,2026-04-12,C017,Diego,Sul,Acessórios,Cabo HDMI,7,29.9\nP1122,2026-04-12,C020,Elisa,Sudeste,Monitores,Monitor 24,1,799.0\nP1123,2026-04-13,C018,Bruno,Sudeste,Monitores,Monitor 27,3,1290.0\nP1124,2026-04-14,C002,Bruno,Sudeste,Monitores,Monitor 27,2,1290.0\nP1125,2026-04-14,C009,Fábio,Norte,Acessórios,Cabo HDMI,9,29.9\nP1126,2026-04-14,C014,Ana,Centro-Oeste,Monitores,Monitor 27,3,1290.0\nP1127,2026-04-14,C025,Ana,Centro-Oeste,Periféricos,Teclado,5,89.9\nP1128,2026-04-15,C006,Bruno,Sudeste,Acessórios,Mousepad,6,39.9\nP1129,2026-04-15,C027,Fábio,Norte,Periféricos,Webcam,10,219.0\nP1130,2026-04-16,C017,Bruno,Sudeste,Acessórios,Cabo HDMI,12,29.9\nP1131,2026-04-17,C013,Diego,Sul,Acessórios,Mousepad,4,39.9\nP1132,2026-04-17,C026,Fábio,Norte,Monitores,Monitor 24,2,799.0\nP1133,2026-04-18,C011,Carla,Nordeste,Monitores,Monitor 24,3,799.0\nP1134,2026-04-18,C013,Carla,Nordeste,Periféricos,Mouse,10,49.9\nP1135,2026-04-20,C027,Fábio,Norte,Monitores,Monitor 24,3,799.0\nP1136,2026-04-22,C018,Bruno,Sudeste,Acessórios,Suporte,1,119.0\nP1137,2026-04-22,C021,Fábio,Norte,Monitores,Monitor 27,2,1290.0\nP1138,2026-04-22,C022,Elisa,Sudeste,Monitores,Monitor 27,3,1290.0\nP1139,2026-04-24,C006,Fábio,Norte,Monitores,Monitor 24,1,799.0\nP1140,2026-04-24,C006,Fábio,Norte,Notebooks,Notebook i7,2,5490.0\nP1141,2026-04-24,C028,Elisa,Sudeste,Monitores,Monitor 24,1,799.0\nP1142,2026-04-25,C015,Fábio,Norte,Acessórios,Suporte,5,119.0\nP1143,2026-04-25,C021,Elisa,Sudeste,Periféricos,Mouse,7,49.9\nP1144,2026-04-25,C024,Diego,Sul,Periféricos,Webcam,6,219.0\nP1145,2026-04-28,C011,Elisa,Sudeste,Monitores,Monitor 24,2,799.0\nP1146,2026-04-29,C009,Elisa,Sudeste,Acessórios,Suporte,4,119.0\nP1147,2026-04-29,C020,Elisa,Sudeste,Periféricos,Webcam,3,219.0\nP1148,2026-04-29,C024,Carla,Nordeste,Notebooks,Notebook i7,3,5490.0\nP1149,2026-04-30,C015,Diego,Sul,Acessórios,Suporte,5,119.0\nP1150,2026-05-01,C007,Bruno,Sudeste,Periféricos,Webcam,5,219.0\nP1151,2026-05-01,C027,Carla,Nordeste,Monitores,Monitor 24,2,799.0\nP1152,2026-05-02,C005,Ana,Centro-Oeste,Acessórios,Mousepad,9,39.9\nP1153,2026-05-03,C004,Carla,Nordeste,Notebooks,Notebook i7,2,5490.0\nP1154,2026-05-03,C014,Elisa,Sudeste,Periféricos,Headset,2,159.0\nP1155,2026-05-06,C008,Bruno,Sudeste,Periféricos,Mouse,9,49.9\nP1156,2026-05-06,C012,Carla,Nordeste,Monitores,Monitor 24,1,799.0\nP1157,2026-05-07,C025,Bruno,Sudeste,Monitores,Monitor 27,1,1290.0\nP1158,2026-05-07,C025,Bruno,Sudeste,Periféricos,Headset,5,159.0\nP1159,2026-05-08,C026,Diego,Sul,Periféricos,Mouse,8,49.9\nP1160,2026-05-09,C002,Fábio,Norte,Periféricos,Headset,12,159.0\nP1161,2026-05-09,C015,Carla,Nordeste,Periféricos,Webcam,3,219.0\nP1162,2026-05-09,C019,Diego,Sul,Monitores,Monitor 24,1,799.0\nP1163,2026-05-10,C001,Fábio,Norte,Monitores,Monitor 24,1,799.0\nP1164,2026-05-10,C007,Fábio,Norte,Monitores,Monitor 27,2,1290.0\nP1165,2026-05-12,C006,Carla,Nordeste,Periféricos,Mouse,5,49.9\nP1166,2026-05-13,C022,Carla,Nordeste,Acessórios,Cabo HDMI,8,29.9\nP1167,2026-05-15,C008,Fábio,Norte,Periféricos,Teclado,11,89.9\nP1168,2026-05-15,C020,Bruno,Sudeste,Periféricos,Headset,8,159.0\nP1169,2026-05-16,C001,Carla,Nordeste,Acessórios,Cabo HDMI,4,29.9\nP1170,2026-05-16,C028,Elisa,Sudeste,Periféricos,Headset,3,159.0\nP1171,2026-05-17,C006,Bruno,Sudeste,Acessórios,Mousepad,3,39.9\nP1172,2026-05-17,C017,Diego,Sul,Acessórios,Suporte,4,119.0\nP1173,2026-05-18,C026,Ana,Centro-Oeste,Acessórios,Suporte,12,119.0\nP1174,2026-05-19,C011,Bruno,Sudeste,Notebooks,Notebook i5,1,3899.0\nP1175,2026-05-19,C026,Elisa,Sudeste,Monitores,Monitor 24,2,799.0\nP1176,2026-05-20,C001,Ana,Centro-Oeste,Periféricos,Headset,3,159.0\nP1177,2026-05-20,C003,Carla,Nordeste,Periféricos,Webcam,8,219.0\nP1178,2026-05-20,C014,Elisa,Sudeste,Acessórios,Cabo HDMI,6,29.9\nP1179,2026-05-20,C028,Bruno,Sudeste,Periféricos,Teclado,9,89.9\nP1180,2026-05-21,C018,Fábio,Norte,Periféricos,Headset,3,159.0\nP1181,2026-05-22,C010,Diego,Sul,Acessórios,Mousepad,10,39.9\nP1182,2026-05-23,C005,Fábio,Norte,Acessórios,Mousepad,3,39.9\nP1183,2026-05-23,C021,Ana,Centro-Oeste,Notebooks,Notebook i7,2,5490.0\nP1184,2026-05-24,C002,Fábio,Norte,Acessórios,Suporte,4,119.0\nP1185,2026-05-25,C012,Fábio,Norte,Periféricos,Headset,7,159.0\nP1186,2026-05-25,C015,Carla,Nordeste,Acessórios,Mousepad,2,39.9\nP1187,2026-05-25,C027,Bruno,Sudeste,Monitores,Monitor 27,2,1290.0\nP1188,2026-05-26,C016,Ana,Centro-Oeste,Periféricos,Webcam,10,219.0\nP1189,2026-05-26,C018,Carla,Nordeste,Acessórios,Mousepad,2,39.9\nP1190,2026-05-29,C008,Diego,Sul,Notebooks,Notebook i5,3,3899.0\nP1191,2026-05-29,C011,Fábio,Norte,Periféricos,Mouse,4,49.9\nP1192,2026-05-30,C024,Ana,Centro-Oeste,Acessórios,Cabo HDMI,12,29.9\nP1193,2026-05-31,C025,Carla,Nordeste,Monitores,Monitor 27,1,1290.0\nP1194,2026-05-31,C025,Carla,Nordeste,Periféricos,Teclado,8,89.9\nP1195,2026-06-01,C015,Fábio,Norte,Notebooks,Notebook i5,1,3899.0\nP1196,2026-06-02,C010,Diego,Sul,Periféricos,Headset,5,159.0\nP1197,2026-06-02,C013,Ana,Centro-Oeste,Notebooks,Notebook i5,1,3899.0\nP1198,2026-06-03,C008,Elisa,Sudeste,Periféricos,Headset,7,159.0\nP1199,2026-06-06,C004,Bruno,Sudeste,Monitores,Monitor 27,3,1290.0\nP1200,2026-06-07,C001,Elisa,Sudeste,Periféricos,Webcam,5,219.0\nP1201,2026-06-07,C027,Elisa,Sudeste,Periféricos,Mouse,12,49.9\nP1202,2026-06-08,C014,Elisa,Sudeste,Periféricos,Mouse,9,49.9\nP1203,2026-06-08,C016,Carla,Nordeste,Notebooks,Notebook i7,2,5490.0\nP1204,2026-06-08,C017,Elisa,Sudeste,Periféricos,Headset,7,159.0\nP1205,2026-06-10,C004,Diego,Sul,Monitores,Monitor 27,1,1290.0\nP1206,2026-06-10,C021,Fábio,Norte,Periféricos,Mouse,4,49.9\nP1207,2026-06-10,C026,Diego,Sul,Monitores,Monitor 27,1,1290.0\nP1208,2026-06-11,C001,Ana,Centro-Oeste,Periféricos,Headset,5,159.0\nP1209,2026-06-11,C008,Ana,Centro-Oeste,Periféricos,Teclado,2,89.9\nP1210,2026-06-11,C018,Diego,Sul,Periféricos,Teclado,4,89.9\nP1211,2026-06-11,C018,Fábio,Norte,Monitores,Monitor 27,3,1290.0\nP1212,2026-06-12,C015,Ana,Centro-Oeste,Acessórios,Cabo HDMI,1,29.9\nP1213,2026-06-13,C019,Carla,Nordeste,Periféricos,Headset,11,159.0\nP1214,2026-06-13,C025,Fábio,Norte,Periféricos,Teclado,5,89.9\nP1215,2026-06-15,C010,Ana,Centro-Oeste,Acessórios,Cabo HDMI,6,29.9\nP1216,2026-06-15,C011,Elisa,Sudeste,Periféricos,Webcam,8,219.0\nP1217,2026-06-15,C021,Bruno,Sudeste,Monitores,Monitor 24,1,799.0\nP1218,2026-06-16,C012,Fábio,Norte,Periféricos,Teclado,1,89.9\nP1219,2026-06-16,C017,Carla,Nordeste,Acessórios,Cabo HDMI,1,29.9\nP1220,2026-06-16,C020,Fábio,Norte,Monitores,Monitor 27,2,1290.0\nP1221,2026-06-16,C025,Bruno,Sudeste,Periféricos,Teclado,8,89.9\nP1222,2026-06-18,C014,Carla,Nordeste,Periféricos,Mouse,6,49.9\nP1223,2026-06-19,C010,Elisa,Sudeste,Periféricos,Teclado,5,89.9\nP1224,2026-06-20,C004,Ana,Centro-Oeste,Acessórios,Suporte,8,119.0\nP1225,2026-06-20,C016,Carla,Nordeste,Periféricos,Headset,10,159.0\nP1226,2026-06-20,C027,Bruno,Sudeste,Periféricos,Webcam,9,219.0\nP1227,2026-06-21,C021,Ana,Centro-Oeste,Periféricos,Webcam,9,219.0\nP1228,2026-06-21,C021,Elisa,Sudeste,Monitores,Monitor 27,2,1290.0\nP1229,2026-06-22,C017,Bruno,Sudeste,Acessórios,Mousepad,5,39.9\nP1230,2026-06-23,C015,Ana,Centro-Oeste,Acessórios,Suporte,11,119.0\nP1231,2026-06-26,C020,Elisa,Sudeste,Acessórios,Cabo HDMI,2,29.9\nP1232,2026-06-26,C025,Elisa,Sudeste,Monitores,Monitor 27,2,1290.0\nP1233,2026-06-26,C027,Carla,Nordeste,Acessórios,Mousepad,5,39.9\nP1234,2026-06-27,C006,Bruno,Sudeste,Monitores,Monitor 27,1,1290.0\nP1235,2026-06-27,C019,Carla,Nordeste,Acessórios,Suporte,7,119.0\nP1236,2026-06-27,C028,Fábio,Norte,Acessórios,Mousepad,5,39.9\nP1237,2026-06-28,C018,Diego,Sul,Monitores,Monitor 27,2,1290.0\nP1238,2026-06-28,C025,Carla,Nordeste,Periféricos,Teclado,5,89.9\nP1239,2026-06-29,C017,Carla,Nordeste,Periféricos,Teclado,3,89.9\nP1240,2026-06-30,C002,Fábio,Norte,Monitores,Monitor 24,2,799.0\n",
  "clientes.csv": "cliente_id,nome,cidade,uf,segmento\nC001,Alfa Tech,Anápolis,GO,Varejo\nC002,Beta Comércio,Belo Horizonte,MG,Educação\nC003,Gama Distribuidora,Belém,PA,Educação\nC004,Delta Distribuidora,Belém,PA,Educação\nC005,Ômega Ltda,Campinas,SP,Varejo\nC006,Prisma Tech,Anápolis,GO,Varejo\nC007,Vértice Ltda,Salvador,BA,Educação\nC008,Horizonte Tech,Porto Alegre,RS,Indústria\nC009,Atlas Tech,Recife,PE,Serviços\nC010,Nexo Tech,Belo Horizonte,MG,Educação\nC011,Pilar Distribuidora,Florianópolis,SC,Varejo\nC012,Rota Tech,Florianópolis,SC,Varejo\nC013,Sigma Distribuidora,Fortaleza,CE,Serviços\nC014,Trevo Soluções,Santos,SP,Indústria\nC015,Zênite Distribuidora,Belo Horizonte,MG,Serviços\nC016,Lince Tech,Goiânia,GO,Serviços\nC017,Aurora Soluções,Salvador,BA,Varejo\nC018,Cobalto Distribuidora,Recife,PE,Educação\nC019,Duna Ltda,Manaus,AM,Educação\nC020,Faro Distribuidora,Fortaleza,CE,Educação\nC021,Íris Distribuidora,Recife,PE,Serviços\nC022,Jade Soluções,Manaus,AM,Educação\nC023,Kairo Distribuidora,Fortaleza,CE,Varejo\nC024,Luz Comércio,Curitiba,PR,Indústria\nC025,Marco Ltda,Manaus,AM,Varejo\n",
  "vendas_sujas.csv": "pedido,data,cliente_id,vendedor,regiao,categoria,produto,quantidade,preco_unit\nP1108,01/04/2026,C020,Bruno,Sudeste,Periféricos,Mouse,,49.9\nP1109,02/04/2026,C004,Elisa,Sudeste,Acessórios,Cabo HDMI,9,\"29,90\"\nP1110,02/04/2026,C026,Elisa,  SUDESTE ,Notebooks,Notebook i5,,\"3899,00\"\nP1111,03/04/2026,C001,Diego,Sul,Acessórios,Suporte,,\"119,00\"\nP1111,03/04/2026,C001,Diego,Sul,Acessórios,Suporte,,\"119,00\"\nP1112,03/04/2026,C022,Diego,Sul,Periféricos,Teclado,12,\"89,90\"\nP1113,04/04/2026,C010,Diego,Sul,Monitores,Monitor 24,3,\"R$ 799,00\"\nP1114,05/04/2026,C012,diego,Sul,Periféricos,Webcam,5,\"R$ 219,00\"\nP1115,05/04/2026,C020,elisa,Sudeste,Monitores,Monitor 24,3,\"R$ 799,00\"\nP1116,05/04/2026,C024,Bruno,  SUDESTE ,Monitores,Monitor 27,2,1290.0\nP1117,08/04/2026,C006,Fábio,Norte,Periféricos,Webcam,4,219.0\nP1118,09/04/2026,C009,Bruno,Sudeste,Periféricos,Mouse,7,\"49,90\"\nP1119,10/04/2026,C008,Diego,  SUL ,Periféricos,Webcam,11,\"219,00\"\nP1120,12/04/2026,C004,Diego,  SUL ,Monitores,Monitor 24,3,799.0\nP1121,12/04/2026,C017,Diego,Sul,Acessórios,Cabo HDMI,7,\"R$ 29,90\"\nP1122,12/04/2026,C020,Elisa,Sudeste,Monitores,Monitor 24,1,\"R$ 799,00\"\nP1123,13/04/2026,C018,bruno,Sudeste,Monitores,Monitor 27,3,\"R$ 1290,00\"\nP1124,14/04/2026,C002,Bruno,  SUDESTE ,Monitores,Monitor 27,2,\"1290,00\"\nP1125,14/04/2026,C009,fábio,Norte,Acessórios,Cabo HDMI,9,29.9\nP1125,14/04/2026,C009,fábio,Norte,Acessórios,Cabo HDMI,9,29.9\nP1126,14/04/2026,C014,Ana,  CENTRO-OESTE ,Monitores,Monitor 27,3,\"R$ 1290,00\"\nP1127,14/04/2026,C025,Ana,Centro-Oeste,Periféricos,Teclado,5,\"R$ 89,90\"\nP1128,15/04/2026,C006,Bruno,Sudeste,Acessórios,Mousepad,6,\"R$ 39,90\"\nP1129,15/04/2026,C027,Fábio,  NORTE ,Periféricos,Webcam,,\"R$ 219,00\"\nP1130,16/04/2026,C017,Bruno,Sudeste,Acessórios,Cabo HDMI,12,\"29,90\"\nP1131,17/04/2026,C013,Diego,Sul,Acessórios,Mousepad,4,39.9\nP1132,17/04/2026,C026,Fábio,Norte,Monitores,Monitor 24,2,799.0\nP1133,18/04/2026,C011,Carla,  NORDESTE ,Monitores,Monitor 24,3,\"799,00\"\nP1134,18/04/2026,C013,Carla,Nordeste,Periféricos,Mouse,10,\"49,90\"\nP1135,20/04/2026,C027,Fábio,  NORTE ,Monitores,Monitor 24,3,\"799,00\"\nP1136,22/04/2026,C018,Bruno,Sudeste,Acessórios,Suporte,,\"R$ 119,00\"\nP1137,22/04/2026,C021,fábio,  NORTE ,Monitores,Monitor 27,2,\"1290,00\"\nP1138,22/04/2026,C022,elisa,Sudeste,Monitores,Monitor 27,3,\"1290,00\"\nP1139,24/04/2026,C006,Fábio,Norte,Monitores,Monitor 24,1,\"799,00\"\nP1140,24/04/2026,C006,Fábio,Norte,Notebooks,Notebook i7,2,5490.0\nP1141,24/04/2026,C028,Elisa,Sudeste,Monitores,Monitor 24,1,\"799,00\"\nP1142,25/04/2026,C015,Fábio,Norte,Acessórios,Suporte,5,119.0\nP1143,25/04/2026,C021,elisa,Sudeste,Periféricos,Mouse,7,\"R$ 49,90\"\nP1144,25/04/2026,C024,Diego,Sul,Periféricos,Webcam,6,219.0\nP1145,28/04/2026,C011,Elisa,  SUDESTE ,Monitores,Monitor 24,2,799.0\nP1146,29/04/2026,C009,Elisa,Sudeste,Acessórios,Suporte,4,\"119,00\"\nP1147,29/04/2026,C020,Elisa,Sudeste,Periféricos,Webcam,3,\"219,00\"\nP1148,29/04/2026,C024,Carla,  NORDESTE ,Notebooks,Notebook i7,3,\"R$ 5490,00\"\nP1148,29/04/2026,C024,Carla,  NORDESTE ,Notebooks,Notebook i7,3,\"R$ 5490,00\"\nP1149,30/04/2026,C015,Diego,Sul,Acessórios,Suporte,5,119.0\n"
});

const COURSE = [
  {
    id: 'py-m01', title: 'Módulo 01 · Primeiros passos: print, variáveis, tipos e operações', kind: 'video',
    lessons: [
      {
        id: 'py-primeiro-codigo', title: 'O que é Python e o seu primeiro código',
        desc: 'Por que Python virou a linguagem dos dados, como funciona o laboratório do curso e os primeiros comandos: print e comentários.',
        objetivos: [
          'Entender por que Python é a linguagem mais usada em análise de dados',
          'Executar código no laboratório do curso, direto no navegador',
          'Usar print para mostrar resultados e # para comentar'
        ],
        body: 'Python é a linguagem de programação mais popular do mundo para dados: com ela você lê planilhas gigantes, limpa dados, faz contas que o Excel não aguenta, gera gráficos e automatiza relatórios. E é uma das mais fáceis de aprender, porque o código parece quase inglês. Neste curso você não precisa instalar nada: o Python roda aqui mesmo, no seu navegador.',
        content: [
          { h: 'Por que Python para dados?',
            items: [
              'É gratuito e roda em qualquer computador — e nas ferramentas que você já conhece: o Excel do Microsoft 365 e o Power BI aceitam scripts em Python.',
              'Tem bibliotecas prontas para tudo: <strong>pandas</strong> para tabelas, <strong>matplotlib</strong> para gráficos, <strong>openpyxl</strong> para planilhas Excel.',
              'Automatiza o trabalho repetitivo: juntar 50 planilhas, limpar uma base todo mês, gerar o mesmo relatório toda segunda.'
            ] },
          { h: 'O primeiro comando: print',
            p: 'O <code>print</code> mostra uma informação na tela. O texto vai entre aspas (simples ou duplas). Clique em <strong>▶ Executar</strong> embaixo de cada bloco de código para ver o resultado — e depois mude o texto e execute de novo: é assim que se aprende a programar.',
            code: 'print("Olá, mundo!")\nprint("Estou aprendendo Python")' },
          { h: 'Números não precisam de aspas',
            p: 'Com números o Python faz a conta antes de mostrar. Repare na diferença: com aspas é texto; sem aspas é número.',
            code: 'print(2 + 3)\nprint("2 + 3")' },
          { h: 'Comentários com #',
            p: 'Tudo o que vem depois de <code>#</code> numa linha é ignorado pelo Python. Use comentários para explicar o que o código faz — para os outros e para você daqui a um mês.',
            code: '# Este programa mostra o faturamento do dia\nprint(1500)  # valor em reais' },
          { h: 'Como funciona o laboratório',
            items: [
              'Os blocos de código da aula têm o botão <strong>▶ Executar</strong>: o resultado aparece logo abaixo.',
              'No fim de cada aula há <strong>desafios</strong>: um cenário real, um editor de código e o botão <strong>✓ Verificar</strong>, que confere se o seu script chegou no resultado certo.',
              'Na primeira execução o Python leva alguns segundos para carregar. Depois fica rápido.',
              'Errou? Leia a mensagem de erro: ela diz o tipo do problema e a linha. Errar faz parte — é o jeito mais rápido de aprender.'
            ] }
        ],
        pratica: [
          { t: 'escolha', q: 'Qual comando mostra o texto Olá na tela?', op: ['print("Olá")', 'show("Olá")', 'mostrar(Olá)'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print(10 + 5)', op: ['15', '10 + 5', '"15"'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print("10 + 5")', op: ['10 + 5', '15', 'Erro'], a: 0, exp: 'Entre aspas é texto: o Python mostra exatamente o que está escrito, sem fazer a conta.' },
          { t: 'escolha', q: 'Para que serve o # no Python?', op: ['Marcar um comentário, que o Python ignora', 'Fazer uma conta', 'Mostrar um número na tela'], a: 0 },
          { t: 'lacuna', codigo: true, frase: '___("Bom dia")', op: ['print', 'Print', 'echo'], a: 0, pt: 'Mostre "Bom dia" na tela.', exp: 'Python diferencia maiúsculas de minúsculas: é print, tudo minúsculo.' },
          { t: 'pares', pares: [['print', 'mostra na tela'], ['#', 'comentário'], ['"texto"', 'um texto (string)'], ['pandas', 'biblioteca de tabelas'], ['matplotlib', 'biblioteca de gráficos']] },
          { t: 'ordenar', q: 'Monte o programa que mostra o título e depois o valor.', linhas: ['# relatório do dia', 'print("Faturamento")', 'print(1500)'] },
          { t: 'escolha', q: 'O que este código mostra?', codigo: '# print("A")\nprint("B")', op: ['B', 'A e B', 'A'], a: 0 }
        ],
        desafios: [
          { titulo: 'Seu cartão de visita',
            cenario: 'Escreva um programa que mostre, em duas linhas separadas, o texto <code>Meu nome é</code> seguido do seu nome (ex.: <code>Meu nome é Ana</code>) e depois o texto <code>Estou aprendendo Python</code>.',
            inicial: '# Escreva seu código abaixo\n',
            testes: [
              { py: "assert len(linhas) >= 2", msg: 'O programa mostra pelo menos duas linhas' },
              { py: "assert linhas[0].startswith('Meu nome é')", msg: 'A primeira linha começa com "Meu nome é"' },
              { py: "assert 'Estou aprendendo Python' in linhas[1]", msg: 'A segunda linha diz "Estou aprendendo Python"' }
            ],
            dicas: ['Você vai precisar de dois comandos print, um em cada linha.', 'O texto vai entre aspas: print("Meu nome é Ana")'],
            solucao: 'print("Meu nome é Ana")\nprint("Estou aprendendo Python")' }
        ]
      },
      {
        id: 'py-variaveis-tipos', title: 'Variáveis e tipos de dados',
        desc: 'Como guardar valores com nomes (variáveis) e os quatro tipos básicos: int, float, str e bool.',
        objetivos: [
          'Criar variáveis e usá-las em contas',
          'Reconhecer os tipos int, float, str e bool com type()',
          'Dar bons nomes às variáveis'
        ],
        body: 'Uma variável é uma caixinha com nome onde você guarda um valor para usar depois. É o que permite escrever "preço vezes quantidade" em vez de repetir números soltos — e mudar um valor num lugar só. Cada valor tem um tipo, e o tipo decide o que dá para fazer com ele.',
        content: [
          { h: 'Criando variáveis',
            p: 'Use o sinal de <code>=</code> para guardar um valor num nome. O <code>=</code> aqui não é "igual" da matemática: é "guarde isto aqui".',
            code: 'preco = 25.90\nquantidade = 3\ntotal = preco * quantidade\nprint(total)' },
          { h: 'Os quatro tipos básicos',
            items: [
              '<code>int</code> — número inteiro: <code>3</code>, <code>-10</code>, <code>2026</code>.',
              '<code>float</code> — número com casas decimais, sempre com <strong>ponto</strong>: <code>25.90</code> (nunca vírgula).',
              '<code>str</code> — texto (string), entre aspas: <code>"Goiânia"</code>.',
              '<code>bool</code> — verdadeiro ou falso: <code>True</code> e <code>False</code>, com inicial maiúscula.'
            ],
            code: 'cidade = "Goiânia"\nano = 2026\nnota = 9.5\naprovado = True\nprint(type(cidade), type(ano), type(nota), type(aprovado))' },
          { h: 'Variáveis mudam de valor',
            p: 'Uma variável pode receber um novo valor a qualquer momento — inclusive calculado a partir dela mesma.',
            code: 'estoque = 100\nestoque = estoque - 30\nprint(estoque)' },
          { h: 'Boas práticas de nomes',
            items: [
              'Use letras minúsculas e <code>_</code> para separar palavras: <code>valor_total</code>, <code>data_venda</code>.',
              'Nada de espaço, acento é permitido mas evite, e não comece com número: <code>2ano</code> dá erro.',
              'Nomes que explicam: <code>faturamento_mensal</code> é melhor que <code>x</code>.'
            ] }
        ],
        pratica: [
          { t: 'escolha', q: 'Qual é o tipo de 25.90?', op: ['float', 'int', 'str'], a: 0 },
          { t: 'escolha', q: 'Qual é o tipo de "2026"?', op: ['str', 'int', 'float'], a: 0, exp: 'Entre aspas é sempre texto (str), mesmo que pareça número.' },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'preco = 10\nqtd = 3\nprint(preco * qtd)', op: ['30', 'preco * qtd', '103'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'estoque = 50\nestoque = estoque - 20\nprint(estoque)', op: ['30', '50', '20'], a: 0 },
          { t: 'escolha', q: 'Qual nome de variável é válido e bem escrito?', op: ['valor_total', 'valor total', '2valor'], a: 0 },
          { t: 'escolha', q: 'Como escrever dois e meio em Python?', op: ['2.5', '2,5', '"2,5"'], a: 0, exp: 'Em Python o separador decimal é o ponto, como no inglês.' },
          { t: 'lacuna', codigo: true, frase: 'aprovado = ___', op: ['True', 'true', '"Verdadeiro"'], a: 0, pt: 'Guarde o valor verdadeiro na variável.' },
          { t: 'pares', pares: [['int', 'número inteiro'], ['float', 'número decimal'], ['str', 'texto'], ['bool', 'verdadeiro ou falso'], ['type()', 'mostra o tipo']] },
          { t: 'ordenar', q: 'Monte o código que calcula e mostra o total.', linhas: ['preco = 25.90', 'quantidade = 3', 'total = preco * quantidade', 'print(total)'] }
        ],
        desafios: [
          { titulo: 'O pedido da papelaria',
            cenario: 'Um cliente comprou <strong>4 cadernos</strong> de <strong>R$ 18,50</strong> cada. Crie as variáveis <code>preco</code> e <code>quantidade</code>, calcule o valor na variável <code>total</code> e mostre o total com <code>print</code>.',
            inicial: 'preco = \nquantidade = \n',
            testes: [
              { py: 'assert preco == 18.5', msg: 'A variável preco vale 18.5 (com ponto!)' },
              { py: 'assert quantidade == 4', msg: 'A variável quantidade vale 4' },
              { py: 'assert abs(total - 74.0) < 0.001', msg: 'A variável total está correta' }
            ],
            dicas: ['Decimal em Python usa ponto: 18.5', 'O total é preco * quantidade, guardado em uma variável chamada total.'],
            solucao: 'preco = 18.5\nquantidade = 4\ntotal = preco * quantidade\nprint(total)' }
        ]
      },
      {
        id: 'py-operacoes', title: 'Operações e textos: contas, f-strings e arredondamento',
        desc: 'Os operadores matemáticos (incluindo //, % e **), arredondamento com round e como montar textos com f-strings.',
        objetivos: [
          'Usar os operadores + - * / // % **',
          'Arredondar com round',
          'Montar textos com variáveis usando f-strings e formatação de números'
        ],
        body: 'Python é uma calculadora poderosa — e o melhor: ele junta as contas com textos para montar mensagens e relatórios. As f-strings são a forma moderna e mais legível de colocar variáveis dentro de um texto.',
        content: [
          { h: 'Operadores',
            items: [
              '<code>+</code> soma, <code>-</code> subtração, <code>*</code> multiplicação, <code>/</code> divisão (sempre dá float).',
              '<code>//</code> divisão inteira: <code>17 // 5</code> é <code>3</code>.',
              '<code>%</code> resto da divisão: <code>17 % 5</code> é <code>2</code> — útil para saber se um número é par (<code>n % 2 == 0</code>).',
              '<code>**</code> potência: <code>2 ** 3</code> é <code>8</code>.'
            ],
            code: 'print(17 / 5)\nprint(17 // 5)\nprint(17 % 5)\nprint(2 ** 3)' },
          { h: 'Arredondando',
            p: 'Contas com decimais podem gerar muitas casas. Use <code>round(valor, casas)</code>.',
            code: 'media = 47 / 6\nprint(media)\nprint(round(media, 2))' },
          { h: 'f-strings: texto com variáveis',
            p: 'Coloque um <code>f</code> antes das aspas e as variáveis entre chaves <code>{ }</code>. Depois de <code>:</code> dá para formatar: <code>.2f</code> = duas casas decimais; <code>,.2f</code> = com separador de milhar.',
            code: 'cliente = "Ana"\ntotal = 1234.5\nprint(f"Cliente: {cliente}")\nprint(f"Total: R$ {total:.2f}")\nprint(f"Total: R$ {total:,.2f}")' },
          { h: 'Juntando textos',
            p: 'O <code>+</code> também junta textos, mas só texto com texto. Para misturar número e texto, use f-string (ou converta com <code>str()</code>).',
            code: 'nome = "Tech" + " " + "Santos"\nprint(nome)\nano = 2026\nprint("Ano: " + str(ano))' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print(17 // 5)', op: ['3', '3.4', '2'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print(17 % 5)', op: ['2', '3', '3.4'], a: 0, exp: '% é o resto da divisão: 17 dividido por 5 dá 3 e sobra 2.' },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print(2 ** 4)', op: ['16', '8', '6'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'x = 10\nprint(f"Valor: {x}")', op: ['Valor: 10', 'Valor: {x}', 'f"Valor: 10"'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'v = 3.14159\nprint(round(v, 2))', op: ['3.14', '3.1', '3'], a: 0 },
          { t: 'escolha', q: 'Qual linha dá erro?', op: ['print("Ano: " + 2026)', 'print(f"Ano: {2026}")', 'print("Ano: " + str(2026))'], a: 0, exp: 'O + não junta texto com número. Use f-string ou str().' },
          { t: 'lacuna', codigo: true, frase: 'print(f"Total: R$ {total:___}")', op: ['.2f', '2.f', '%2'], a: 0, pt: 'Mostre o total com duas casas decimais.' },
          { t: 'pares', pares: [['//', 'divisão inteira'], ['%', 'resto da divisão'], ['**', 'potência'], ['round()', 'arredondar'], ['f"{x}"', 'variável dentro do texto']] },
          { t: 'ordenar', q: 'Monte o código que calcula a média e mostra com duas casas.', linhas: ['soma = 47', 'media = soma / 6', 'print(f"Média: {media:.2f}")'] }
        ],
        desafios: [
          { titulo: 'O resumo do caixa',
            cenario: 'O caixa da loja vendeu <strong>R$ 2.345,60</strong> em <strong>37 vendas</strong>. Calcule o ticket médio (faturamento dividido pelo número de vendas) na variável <code>ticket</code> e mostre exatamente a linha <code>Ticket médio: R$ 63.39</code> usando uma f-string com duas casas decimais.',
            inicial: 'faturamento = 2345.60\nvendas = 37\n',
            testes: [
              { py: 'assert abs(ticket - 2345.60 / 37) < 0.001', msg: 'A variável ticket está correta' },
              { py: "assert 'Ticket médio: R$ 63.39' in saida", msg: 'O programa mostra "Ticket médio: R$ 63.39"' }
            ],
            dicas: ['ticket = faturamento / vendas', 'Para duas casas numa f-string: {ticket:.2f}'],
            solucao: 'faturamento = 2345.60\nvendas = 37\nticket = faturamento / vendas\nprint(f"Ticket médio: R$ {ticket:.2f}")' }
        ]
      },
      {
        id: 'py-primeiro-script', title: 'Seu primeiro script de dados: o fechamento do mês',
        desc: 'Juntando tudo num script de verdade: variáveis, contas, porcentagens e um relatório formatado.',
        objetivos: [
          'Escrever um script com entrada de dados, cálculo e saída organizada',
          'Calcular variação percentual e margem',
          'Formatar um mini-relatório com f-strings'
        ],
        body: 'Fechando o módulo, você vai escrever o primeiro script com cara de trabalho real: o fechamento do mês de uma empresa. É a mesma lógica de qualquer análise de dados — pegar números, calcular indicadores e apresentar o resultado de forma clara.',
        content: [
          { h: 'A estrutura de um script',
            items: [
              '<strong>Dados</strong>: as variáveis com os valores de entrada.',
              '<strong>Cálculos</strong>: os indicadores, cada um numa variável com nome claro.',
              '<strong>Saída</strong>: o relatório com <code>print</code> e f-strings.'
            ] },
          { h: 'Variação percentual e margem',
            p: 'Variação = (atual − anterior) / anterior × 100. Margem = lucro / receita × 100. Os parênteses garantem a ordem das contas — como na matemática.',
            code: 'receita_atual = 120000\nreceita_anterior = 100000\nvariacao = (receita_atual - receita_anterior) / receita_anterior * 100\nprint(f"Variação: {variacao:.1f}%")' },
          { h: 'O relatório',
            code: 'receita = 120000\ncusto = 84000\nlucro = receita - custo\nmargem = lucro / receita * 100\n\nprint("=== Fechamento de outubro ===")\nprint(f"Receita: R$ {receita:,.2f}")\nprint(f"Custo:   R$ {custo:,.2f}")\nprint(f"Lucro:   R$ {lucro:,.2f}")\nprint(f"Margem:  {margem:.1f}%")' },
          { h: 'E daqui pra frente',
            p: 'Por enquanto os números estão escritos no código. Nos próximos módulos você vai tomar decisões com <code>if</code>, repetir contas com laços, ler arquivos CSV e, a partir do módulo de pandas, trabalhar com milhares de linhas de uma vez — como numa planilha, só que muito mais rápido.' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'atual = 150\nanterior = 100\nprint((atual - anterior) / anterior * 100)', op: ['50.0', '0.5', '150.0'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'receita = 200\nlucro = 50\nprint(f"{lucro / receita * 100:.0f}%")', op: ['25%', '0.25%', '4%'], a: 0 },
          { t: 'escolha', q: 'Por que os parênteses em (atual - anterior) / anterior?', op: ['Para a subtração acontecer antes da divisão', 'Porque Python exige parênteses em toda conta', 'Para transformar o resultado em texto'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'valor = 1234567.891\nprint(f"{valor:,.2f}")', op: ['1,234,567.89', '1.234.567,89', '1234567.89'], a: 0, exp: 'A formatação ,.2f usa o padrão americano: vírgula no milhar e ponto no decimal.' },
          { t: 'ordenar', q: 'Monte o script na ordem lógica: dados, cálculo e saída.', linhas: ['receita = 120000', 'custo = 84000', 'lucro = receita - custo', 'print(f"Lucro: R$ {lucro:,.2f}")'] },
          { t: 'lacuna', codigo: true, frase: 'margem = lucro ___ receita * 100', op: ['/', '//', '%'], a: 0, pt: 'Calcule a margem percentual.' },
          { t: 'pares', pares: [['dados', 'variáveis de entrada'], ['cálculos', 'indicadores'], ['saída', 'print e f-strings'], [':.1f', 'uma casa decimal'], [':,.2f', 'milhar e duas casas']] }
        ],
        desafios: [
          { titulo: 'Fechamento do trimestre',
            cenario: 'A empresa faturou <strong>R$ 380.000</strong> neste trimestre e <strong>R$ 320.000</strong> no trimestre anterior. O custo deste trimestre foi <strong>R$ 247.000</strong>. Calcule nas variáveis <code>lucro</code>, <code>margem</code> (em %) e <code>crescimento</code> (variação % da receita) e mostre um relatório com as três informações.',
            inicial: 'receita = 380000\nreceita_anterior = 320000\ncusto = 247000\n\n# calcule lucro, margem e crescimento\n\n# mostre o relatório\n',
            testes: [
              { py: 'assert lucro == 133000', msg: 'A variável lucro está correta' },
              { py: 'assert abs(margem - 35.0) < 0.01', msg: 'A variável margem (em %) está correta' },
              { py: 'assert abs(crescimento - 18.75) < 0.01', msg: 'A variável crescimento (em %) está correta' },
              { py: "assert len(linhas) >= 3", msg: 'O relatório mostra pelo menos três linhas' }
            ],
            dicas: ['Lucro é receita menos custo.', 'Margem: lucro / receita * 100. Crescimento: (receita - receita_anterior) / receita_anterior * 100 — use parênteses!', 'Para o relatório, três print com f-strings, por exemplo print(f"Margem: {margem:.1f}%")'],
            solucao: 'receita = 380000\nreceita_anterior = 320000\ncusto = 247000\n\nlucro = receita - custo\nmargem = lucro / receita * 100\ncrescimento = (receita - receita_anterior) / receita_anterior * 100\n\nprint(f"Lucro: R$ {lucro:,.2f}")\nprint(f"Margem: {margem:.1f}%")\nprint(f"Crescimento: {crescimento:.2f}%")' }
        ]
      }
    ]
  }
  ,
  {
    id: 'py-m02', title: 'Módulo 02 · Textos: strings, métodos, fatias e limpeza', kind: 'video',
    lessons: [
      {
        id: 'py-strings-basico', title: 'Strings: o básico dos textos',
        desc: 'Como o Python trata textos: aspas, len, índices e fatias para pegar pedaços de um texto.',
        objetivos: [
          'Medir o tamanho de um texto com len',
          'Pegar caracteres por índice, inclusive índices negativos',
          'Recortar pedaços com fatias [inicio:fim]'
        ],
        body: 'Em dados, texto está em todo lugar: nomes de clientes, códigos de produto, e-mails, CPFs. Saber recortar e consultar um texto é o primeiro passo para limpar e organizar essas informações.',
        content: [
          { h: 'Tamanho com len',
            p: '<code>len()</code> conta quantos caracteres um texto tem, incluindo espaços.',
            code: 'produto = "Caderno 10 matérias"\nprint(len(produto))' },
          { h: 'Índices: cada caractere tem uma posição',
            items: [
              'A contagem começa em <strong>0</strong>: o primeiro caractere é <code>texto[0]</code>.',
              'Índices negativos contam do fim: <code>texto[-1]</code> é o último caractere.',
              'Pedir uma posição que não existe dá <code>IndexError</code>.'
            ],
            code: 'codigo = "SP-2026-0042"\nprint(codigo[0])\nprint(codigo[-1])' },
          { h: 'Fatias: [inicio:fim]',
            p: 'A fatia pega do <code>inicio</code> até <strong>antes</strong> do <code>fim</code>. Omitir o início começa do zero; omitir o fim vai até o final.',
            code: 'codigo = "SP-2026-0042"\nprint(codigo[0:2])   # estado\nprint(codigo[3:7])   # ano\nprint(codigo[-4:])   # número do pedido' },
          { h: 'Textos não mudam',
            p: 'Strings são imutáveis: você não altera um caractere, cria um texto novo. Por isso os métodos que você vai ver a seguir sempre <strong>devolvem</strong> um texto novo.' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print(len("Python"))', op: ['6', '5', '7'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'p = "Python"\nprint(p[0])', op: ['P', 'y', 'n'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'p = "Python"\nprint(p[-1])', op: ['n', 'P', 'o'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'c = "SP-2026"\nprint(c[3:7])', op: ['2026', '-202', '2026-'], a: 0, exp: 'A fatia vai do índice 3 até antes do 7: posições 3, 4, 5 e 6.' },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'c = "pedido-0042"\nprint(c[-4:])', op: ['0042', '042', 'pedido'], a: 0 },
          { t: 'lacuna', codigo: true, frase: 'print(nome[___])  # primeiro caractere', op: ['0', '1', '-0'], a: 0, pt: 'Mostre a primeira letra do nome.' },
          { t: 'pares', pares: [['len(t)', 'tamanho'], ['t[0]', 'primeiro caractere'], ['t[-1]', 'último caractere'], ['t[2:5]', 'fatia'], ['t[:3]', 'três primeiros']] },
          { t: 'ordenar', q: 'Monte o código que separa o ano do código do pedido.', linhas: ['codigo = "SP-2026-0042"', 'ano = codigo[3:7]', 'print(ano)'] }
        ],
        desafios: [
          { titulo: 'Decifrando o código do pedido',
            cenario: 'Os pedidos da loja têm códigos como <code>"GO-2026-10-0587"</code>: estado, ano, mês e número. Usando fatias, crie as variáveis <code>estado</code>, <code>ano</code>, <code>mes</code> e <code>numero</code> (todas como texto) e mostre as quatro.',
            inicial: 'codigo = "GO-2026-10-0587"\n',
            testes: [
              { py: "assert estado == 'GO'", msg: 'estado está correto' },
              { py: "assert ano == '2026'", msg: 'ano está correto' },
              { py: "assert mes == '10'", msg: 'mes está correto' },
              { py: "assert numero == '0587'", msg: 'numero está correto' }
            ],
            dicas: ['Conte as posições: G=0, O=1, -=2, o ano começa no 3.', 'Para o número, uma fatia com índice negativo resolve: codigo[-4:]'],
            solucao: 'codigo = "GO-2026-10-0587"\nestado = codigo[0:2]\nano = codigo[3:7]\nmes = codigo[8:10]\nnumero = codigo[-4:]\nprint(estado, ano, mes, numero)' }
        ]
      },
      {
        id: 'py-strings-metodos', title: 'Métodos de texto: upper, lower, strip, replace',
        desc: 'Os métodos que limpam e padronizam textos — a base da limpeza de dados.',
        objetivos: [
          'Padronizar maiúsculas e minúsculas com upper, lower e title',
          'Tirar espaços extras com strip',
          'Trocar trechos com replace e verificar conteúdo com in, startswith e endswith'
        ],
        body: 'Base de cliente nunca vem limpa: "  maria silva ", "MARIA SILVA", "Maria  Silva". Para o computador, são três clientes diferentes. Os métodos de texto padronizam tudo — e são exatamente o que o Power Query e o pandas fazem por baixo dos panos.',
        content: [
          { h: 'Maiúsculas e minúsculas',
            code: 'nome = "maria DA silva"\nprint(nome.upper())\nprint(nome.lower())\nprint(nome.title())' },
          { h: 'strip: tchau, espaços extras',
            p: '<code>strip()</code> remove espaços (e quebras de linha) do começo e do fim. <code>lstrip</code> e <code>rstrip</code> limpam só um lado.',
            code: 'cidade = "   Goiânia  "\nprint(f"[{cidade}]")\nprint(f"[{cidade.strip()}]")' },
          { h: 'replace: trocar trechos',
            code: 'valor = "R$ 1.234,56"\nlimpo = valor.replace("R$ ", "").replace(".", "").replace(",", ".")\nprint(limpo)\nprint(float(limpo) * 2)' },
          { h: 'Encadeando e verificando',
            items: [
              'Métodos podem ser encadeados: <code>texto.strip().lower()</code>.',
              '<code>"x" in texto</code> verifica se um trecho existe: <code>"@" in email</code>.',
              '<code>startswith</code> e <code>endswith</code> verificam começo e fim: <code>arquivo.endswith(".csv")</code>.',
              '<code>count</code> conta ocorrências: <code>texto.count("a")</code>.'
            ],
            code: 'email = "  Ana@Empresa.com "\nemail = email.strip().lower()\nprint(email)\nprint("@" in email, email.endswith(".com"))' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print("goiás".upper())', op: ['GOIÁS', 'Goiás', 'goiás'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print("maria silva".title())', op: ['Maria Silva', 'MARIA SILVA', 'Maria silva'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 't = "  oi  "\nprint(len(t.strip()))', op: ['2', '6', '4'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print("1,5".replace(",", "."))', op: ['1.5', '1,5', '15'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'arq = "vendas.csv"\nprint(arq.endswith(".csv"))', op: ['True', 'False', '.csv'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print("@" in "ana.empresa.com")', op: ['False', 'True', 'Erro'], a: 0 },
          { t: 'lacuna', codigo: true, frase: 'nome = nome.___().lower()', op: ['strip', 'trim', 'clean'], a: 0, pt: 'Tire os espaços e deixe minúsculo.', exp: 'Em Python o método é strip (no Excel é ARRUMAR/TRIM).' },
          { t: 'pares', pares: [['upper()', 'tudo maiúsculo'], ['lower()', 'tudo minúsculo'], ['title()', 'Primeira Maiúscula'], ['strip()', 'tira espaços das pontas'], ['replace(a, b)', 'troca a por b']] },
          { t: 'ordenar', q: 'Monte o código que limpa e padroniza o nome.', linhas: ['nome = "  MARIA silva "', 'nome = nome.strip().title()', 'print(nome)'] }
        ],
        desafios: [
          { titulo: 'Padronizando o cadastro',
            cenario: 'O cadastro veio bagunçado. Padronize: <code>nome</code> sem espaços nas pontas e com iniciais maiúsculas; <code>email</code> sem espaços e todo minúsculo; <code>telefone</code> só com números (tire parênteses, espaço e hífen).',
            inicial: 'nome = "   joão PEREIRA  "\nemail = " Joao.Pereira@Empresa.COM "\ntelefone = "(64) 99290-5785"\n\n# padronize as três variáveis\n',
            testes: [
              { py: "assert nome == 'João Pereira'", msg: 'nome padronizado' },
              { py: "assert email == 'joao.pereira@empresa.com'", msg: 'email padronizado' },
              { py: "assert telefone == '64992905785'", msg: 'telefone só com números' }
            ],
            dicas: ['Reatribua cada variável: nome = nome.strip().title()', 'Para o telefone, encadeie replace: .replace("(", "").replace(")", "") e assim por diante.'],
            solucao: 'nome = "   joão PEREIRA  "\nemail = " Joao.Pereira@Empresa.COM "\ntelefone = "(64) 99290-5785"\n\nnome = nome.strip().title()\nemail = email.strip().lower()\ntelefone = telefone.replace("(", "").replace(")", "").replace(" ", "").replace("-", "")\nprint(nome, email, telefone)' }
        ]
      },
      {
        id: 'py-split-join', title: 'split e join: quebrar e juntar textos',
        desc: 'Como transformar uma linha de texto em partes (split) e juntar partes num texto só (join) — a lógica dos arquivos CSV.',
        objetivos: [
          'Quebrar textos em listas com split',
          'Juntar listas de textos com join',
          'Converter texto em número com int e float'
        ],
        body: 'Uma linha de CSV é só um texto com vírgulas: "Ana;Goiânia;1500". O split quebra essa linha em pedaços, e o join faz o caminho inverso. Com eles você já entende como os dados ficam guardados em arquivos — antes mesmo de usar o pandas.',
        content: [
          { h: 'split: quebrar',
            p: '<code>texto.split(separador)</code> devolve uma lista de pedaços. Sem argumento, quebra nos espaços.',
            code: 'linha = "Ana;Goiânia;1500"\npartes = linha.split(";")\nprint(partes)\nprint(partes[0], partes[2])' },
          { h: 'Texto vira número com int e float',
            p: 'O que vem de um arquivo é sempre texto. Para fazer conta, converta: <code>int("1500")</code> e <code>float("12.5")</code>.',
            code: 'linha = "Ana;Goiânia;1500"\nnome, cidade, valor = linha.split(";")\nprint(int(valor) * 2)' },
          { h: 'join: juntar',
            p: 'O separador vem <strong>antes</strong>: <code>", ".join(lista)</code>.',
            code: 'cidades = ["Goiânia", "Itumbiara", "Rio Verde"]\nprint(", ".join(cidades))\nprint(" | ".join(cidades))' },
          { h: 'Desempacotar',
            p: 'Quando você sabe quantos pedaços vêm, pode guardar cada um numa variável de uma vez: <code>nome, cidade, valor = linha.split(";")</code>. Se o número de variáveis não bater com o de pedaços, dá <code>ValueError</code>.' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print("a;b;c".split(";"))', op: ["['a', 'b', 'c']", 'a b c', "['a;b;c']"], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'p = "Ana Maria Silva".split()\nprint(p[-1])', op: ['Silva', 'Ana', 'Maria'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print("-".join(["2026", "10", "28"]))', op: ['2026-10-28', '2026 10 28', "['2026-10-28']"], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print("10" + "5")', op: ['105', '15', 'Erro'], a: 0, exp: 'Os dois são texto: o + junta os textos. Para somar, converta com int().' },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print(int("10") + int("5"))', op: ['15', '105', 'Erro'], a: 0 },
          { t: 'lacuna', codigo: true, frase: 'partes = linha.___(";")', op: ['split', 'join', 'cut'], a: 0, pt: 'Quebre a linha nos pontos e vírgulas.' },
          { t: 'pares', pares: [['split', 'texto → lista'], ['join', 'lista → texto'], ['int("7")', '7 (inteiro)'], ['float("2.5")', '2.5 (decimal)'], ['str(10)', '"10" (texto)']] },
          { t: 'ordenar', q: 'Monte o código que lê a linha e dobra o valor.', linhas: ['linha = "Ana;Goiânia;1500"', 'nome, cidade, valor = linha.split(";")', 'print(int(valor) * 2)'] }
        ],
        desafios: [
          { titulo: 'Lendo uma linha do arquivo',
            cenario: 'A linha <code>"2026-10-15;Caneta azul;12;2.50"</code> veio de um arquivo de vendas: data, produto, quantidade e preço unitário. Quebre a linha, converta quantidade e preço para número e calcule o <code>total</code> da venda (quantidade × preço). Depois monte a variável <code>resumo</code> no formato <code>Caneta azul: 12 x R$ 2.50 = R$ 30.00</code>.',
            inicial: 'linha = "2026-10-15;Caneta azul;12;2.50"\n',
            testes: [
              { py: 'assert abs(total - 30.0) < 0.001', msg: 'total está correto (e é um número)' },
              { py: "assert resumo == 'Caneta azul: 12 x R$ 2.50 = R$ 30.00'", msg: 'resumo no formato pedido' }
            ],
            dicas: ['data, produto, qtd, preco = linha.split(";")', 'Converta: int(qtd) e float(preco). No resumo, use f-string com :.2f para os valores em reais.'],
            solucao: 'linha = "2026-10-15;Caneta azul;12;2.50"\ndata, produto, qtd, preco = linha.split(";")\nqtd = int(qtd)\npreco = float(preco)\ntotal = qtd * preco\nresumo = f"{produto}: {qtd} x R$ {preco:.2f} = R$ {total:.2f}"\nprint(resumo)' }
        ]
      },
      {
        id: 'py-texto-projeto', title: 'Projeto: limpando uma lista de clientes',
        desc: 'Aplicando tudo do módulo num caso real: padronizar nomes, validar e-mails e montar um relatório em texto.',
        objetivos: [
          'Combinar métodos de texto para limpar dados',
          'Validar informações simples (e-mail com @ e ponto)',
          'Gerar um relatório organizado com f-strings e alinhamento'
        ],
        body: 'Fechando o módulo, um caso de verdade: uma lista de clientes com nomes bagunçados e e-mails duvidosos. Você vai limpar, validar e montar um relatório — em poucas linhas de Python.',
        content: [
          { h: 'Validação simples de e-mail',
            p: 'Uma validação básica: tem <code>@</code>, tem ponto depois do <code>@</code> e não tem espaço. Não é perfeita, mas pega a maioria dos erros de digitação.',
            code: 'email = "ana@empresa.com"\nvalido = "@" in email and "." in email.split("@")[-1] and " " not in email\nprint(valido)' },
          { h: 'Alinhando colunas no relatório',
            p: 'Nas f-strings, <code>{texto:<20}</code> alinha à esquerda em 20 espaços e <code>{numero:>10}</code> à direita — dá para fazer uma tabela em texto.',
            code: 'print(f"{\'Cliente\':<15}{\'Cidade\':<12}")\nprint(f"{\'Ana Souza\':<15}{\'Goiânia\':<12}")\nprint(f"{\'Bruno Lima\':<15}{\'Itumbiara\':<12}")' },
          { h: 'O que vem a seguir',
            p: 'Aqui você tratou um cliente por vez. No módulo 4, com listas e laços, vai fazer a mesma limpeza em centenas de clientes de uma vez — e no pandas, em milhares, com uma linha só.' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'e = "ana@empresa"\nprint("." in e.split("@")[-1])', op: ['False', 'True', 'empresa'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print(f"[{\'Ana\':<6}]")', op: ['[Ana   ]', '[   Ana]', '[Ana]'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print(f"[{42:>5}]")', op: ['[   42]', '[42   ]', '[42]'], a: 0 },
          { t: 'escolha', q: 'O que faz este código?', codigo: 'nome = nome.strip().title()', op: ['Tira espaços das pontas e deixa iniciais maiúsculas', 'Apaga o nome', 'Deixa tudo maiúsculo'], a: 0 },
          { t: 'lacuna', codigo: true, frase: 'valido = "@" in email ___ " " not in email', op: ['and', 'or', '+'], a: 0, pt: 'Válido se tem @ E não tem espaço.' },
          { t: 'pares', pares: [[':<15', 'alinha à esquerda'], [':>10', 'alinha à direita'], ['in', 'contém'], ['not in', 'não contém'], ['and', 'as duas condições']] },
          { t: 'ordenar', q: 'Monte a validação do e-mail.', linhas: ['email = " Ana@Empresa.com ".strip().lower()', 'valido = "@" in email and " " not in email', 'print(email, valido)'] }
        ],
        desafios: [
          { titulo: 'O cliente da vez',
            cenario: 'Recebemos o cadastro <code>"  CARLOS eduardo ; carlos.edu@@mail.com ;rio verde"</code> (nome; e-mail; cidade). Quebre a linha, limpe cada parte (nome e cidade com iniciais maiúsculas, e-mail minúsculo) e crie as variáveis <code>nome</code>, <code>email</code>, <code>cidade</code> e <code>email_valido</code> (True ou False). Um e-mail é válido se tiver exatamente um <code>@</code> e um ponto depois dele.',
            inicial: 'cadastro = "  CARLOS eduardo ; carlos.edu@@mail.com ;rio verde"\n',
            testes: [
              { py: "assert nome == 'Carlos Eduardo'", msg: 'nome limpo' },
              { py: "assert cidade == 'Rio Verde'", msg: 'cidade limpa' },
              { py: "assert email == 'carlos.edu@@mail.com'", msg: 'email limpo (só espaços e minúsculas)' },
              { py: 'assert email_valido is False', msg: 'email_valido detecta o erro (dois @)' }
            ],
            dicas: ['nome, email, cidade = cadastro.split(";") — depois aplique strip em cada um.', 'Para contar os @: email.count("@") == 1'],
            solucao: 'cadastro = "  CARLOS eduardo ; carlos.edu@@mail.com ;rio verde"\nnome, email, cidade = cadastro.split(";")\nnome = nome.strip().title()\nemail = email.strip().lower()\ncidade = cidade.strip().title()\nemail_valido = email.count("@") == 1 and "." in email.split("@")[-1]\nprint(nome, email, cidade, email_valido)' }
        ]
      }
    ]
  }
  ,
  {
    id: 'py-m03', title: 'Módulo 03 · Decisões: comparações, if, elif, else e lógica', kind: 'video',
    lessons: [
      {
        id: 'py-comparacoes', title: 'Comparações e valores booleanos',
        desc: 'Os operadores que comparam valores (==, !=, >, <, >=, <=) e o resultado True ou False.',
        objetivos: [
          'Comparar números e textos com os operadores relacionais',
          'Diferenciar = (atribuição) de == (comparação)',
          'Entender que toda comparação resulta em True ou False'
        ],
        body: 'Antes de o programa tomar uma decisão, ele precisa fazer uma pergunta: a meta foi batida? O estoque acabou? O cliente é de Goiás? Toda pergunta dessas é uma comparação, e a resposta é sempre True ou False.',
        content: [
          { h: 'Os operadores',
            items: [
              '<code>==</code> igual · <code>!=</code> diferente',
              '<code>&gt;</code> maior · <code>&lt;</code> menor · <code>&gt;=</code> maior ou igual · <code>&lt;=</code> menor ou igual',
              'O resultado é sempre um <code>bool</code>: <code>True</code> ou <code>False</code>.'
            ],
            code: 'vendas = 120000\nmeta = 100000\nprint(vendas > meta)\nprint(vendas == meta)\nprint(vendas != meta)' },
          { h: '= não é ==',
            p: 'Um sinal guarda um valor (<code>x = 5</code>); dois sinais perguntam se é igual (<code>x == 5</code>). Trocar um pelo outro é o erro mais comum de quem começa.',
            code: 'estoque = 0\nprint(estoque == 0)' },
          { h: 'Comparando textos',
            p: 'Textos também se comparam, mas maiúsculas e minúsculas contam: <code>"Goiás" == "goiás"</code> é <code>False</code>. Padronize antes de comparar.',
            code: 'uf = " go "\nprint(uf == "GO")\nprint(uf.strip().upper() == "GO")' },
          { h: 'Guardando o resultado',
            p: 'O resultado de uma comparação pode ir para uma variável — e o nome deve parecer uma pergunta.',
            code: 'meta_batida = 120000 >= 100000\nprint(meta_batida)' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print(10 > 5)', op: ['True', 'False', '10'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print(5 >= 5)', op: ['True', 'False', 'Erro'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print("GO" == "go")', op: ['False', 'True', 'Erro'], a: 0, exp: 'Maiúsculas e minúsculas contam na comparação de textos.' },
          { t: 'escolha', q: 'Qual linha pergunta se x é igual a 10?', op: ['x == 10', 'x = 10', 'x === 10'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print(3 != 3)', op: ['False', 'True', '0'], a: 0 },
          { t: 'lacuna', codigo: true, frase: 'esgotado = estoque ___ 0', op: ['==', '=', '=>'], a: 0, pt: 'Verifique se o estoque é igual a zero.' },
          { t: 'pares', pares: [['==', 'igual'], ['!=', 'diferente'], ['>=', 'maior ou igual'], ['<', 'menor'], ['=', 'guardar valor']] },
          { t: 'ordenar', q: 'Monte o código que verifica a meta.', linhas: ['vendas = 120000', 'meta = 100000', 'print(vendas >= meta)'] }
        ],
        desafios: [
          { titulo: 'Checagem rápida',
            cenario: 'Crie três variáveis booleanas: <code>meta_batida</code> (vendas maior ou igual à meta), <code>estoque_baixo</code> (estoque menor que 10) e <code>cliente_goias</code> (a UF do cliente, depois de limpa e em maiúsculas, é igual a <code>"GO"</code>).',
            inicial: 'vendas = 87500\nmeta = 90000\nestoque = 7\nuf_cliente = " go"\n',
            testes: [
              { py: 'assert meta_batida is False', msg: 'meta_batida está correta' },
              { py: 'assert estoque_baixo is True', msg: 'estoque_baixo está correto' },
              { py: 'assert cliente_goias is True', msg: 'cliente_goias está correto' }
            ],
            dicas: ['Cada variável recebe o resultado de uma comparação: meta_batida = vendas >= meta', 'Para a UF: uf_cliente.strip().upper() == "GO"'],
            solucao: 'vendas = 87500\nmeta = 90000\nestoque = 7\nuf_cliente = " go"\n\nmeta_batida = vendas >= meta\nestoque_baixo = estoque < 10\ncliente_goias = uf_cliente.strip().upper() == "GO"\nprint(meta_batida, estoque_baixo, cliente_goias)' }
        ]
      },
      {
        id: 'py-if-else', title: 'if, elif e else: o programa toma decisões',
        desc: 'Como executar um código só quando uma condição é verdadeira, e como escolher entre vários caminhos.',
        objetivos: [
          'Usar if para executar código condicionalmente',
          'Usar else e elif para caminhos alternativos',
          'Entender a indentação como parte da linguagem'
        ],
        body: 'É aqui que o programa começa a pensar: "se a meta foi batida, parabenize; senão, mostre quanto falta". Em Python, o que pertence ao if é marcado pela indentação — os quatro espaços no começo da linha.',
        content: [
          { h: 'if e else',
            p: 'A linha do <code>if</code> termina com dois-pontos, e o bloco de dentro é indentado com 4 espaços.',
            code: 'vendas = 87500\nmeta = 90000\nif vendas >= meta:\n    print("Meta batida! 🎉")\nelse:\n    falta = meta - vendas\n    print(f"Faltam R$ {falta:,.2f}")' },
          { h: 'elif: várias faixas',
            p: 'O <code>elif</code> ("senão, se") testa outra condição. O Python para no primeiro caminho verdadeiro — por isso a ordem importa.',
            code: 'nota = 7.5\nif nota >= 9:\n    conceito = "A"\nelif nota >= 7:\n    conceito = "B"\nelif nota >= 5:\n    conceito = "C"\nelse:\n    conceito = "D"\nprint(conceito)' },
          { h: 'A indentação é obrigatória',
            items: [
              'Esquecer os dois-pontos dá <code>SyntaxError</code>.',
              'Esquecer a indentação dá <code>IndentationError</code>.',
              'No editor do curso, depois de uma linha com <code>:</code>, o Enter já indenta sozinho.'
            ] },
          { h: 'É o SE do Excel',
            p: 'Se você usa <code>SE</code> no Excel, já conhece a lógica: <code>=SE(B2&gt;=90000;"Batida";"Abaixo")</code> é o mesmo que um if/else. A diferença é que em Python cada caminho pode ter várias linhas de código, sem os SE aninhados ilegíveis.' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'x = 5\nif x > 3:\n    print("grande")\nelse:\n    print("pequeno")', op: ['grande', 'pequeno', 'grande pequeno'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'n = 8\nif n >= 9:\n    print("A")\nelif n >= 7:\n    print("B")\nelse:\n    print("C")', op: ['B', 'A', 'C'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'n = 10\nif n >= 5:\n    print("X")\nelif n >= 8:\n    print("Y")', op: ['X', 'Y', 'X Y'], a: 0, exp: 'O Python para no primeiro caminho verdadeiro: 10 >= 5 já é verdade, o elif nem é testado.' },
          { t: 'escolha', q: 'O que está faltando nesta linha?', codigo: 'if vendas > meta\n    print("ok")', op: ['Os dois-pontos no fim do if', 'Parênteses na condição', 'A palavra then'], a: 0 },
          { t: 'lacuna', codigo: true, frase: 'if estoque == 0:\n    print("Esgotado")\n___:\n    print("Disponível")', op: ['else', 'elif', 'then'], a: 0, pt: 'Complete o caminho alternativo.' },
          { t: 'ordenar', q: 'Monte o código com a indentação certa.', linhas: ['if vendas >= meta:', '    print("Meta batida")', 'else:', '    print("Abaixo da meta")'] },
          { t: 'pares', pares: [['if', 'se'], ['elif', 'senão, se'], ['else', 'senão'], [':', 'fim da condição'], ['4 espaços', 'indentação do bloco']] }
        ],
        desafios: [
          { titulo: 'A comissão do vendedor',
            cenario: 'A comissão segue faixas: vendas acima de <strong>R$ 100.000</strong> ganham <strong>5%</strong>; acima de <strong>R$ 50.000</strong> (até 100 mil), <strong>3%</strong>; o resto, <strong>1%</strong>. Calcule a variável <code>comissao</code> para o valor de <code>vendas</code> e mostre-a. Teste mudando o valor de vendas!',
            inicial: 'vendas = 78000\n',
            testes: [
              { py: 'assert abs(comissao - 2340.0) < 0.01', msg: 'comissão correta para vendas = 78000' },
              { py: "__ns2 = {}\nexec(compile(__codigo_aluno.replace('vendas = 78000', 'vendas = 150000'), 'x', 'exec'), __ns2)\nassert abs(__ns2['comissao'] - 7500.0) < 0.01", msg: 'funciona também para vendas acima de 100 mil' },
              { py: "__ns3 = {}\nexec(compile(__codigo_aluno.replace('vendas = 78000', 'vendas = 30000'), 'x', 'exec'), __ns3)\nassert abs(__ns3['comissao'] - 300.0) < 0.01", msg: 'funciona também para vendas baixas' }
            ],
            dicas: ['Comece pela faixa mais alta: if vendas > 100000: ... elif vendas > 50000: ... else: ...', 'Dentro de cada caminho: comissao = vendas * 0.05 (ou 0.03, ou 0.01)'],
            solucao: 'vendas = 78000\nif vendas > 100000:\n    comissao = vendas * 0.05\nelif vendas > 50000:\n    comissao = vendas * 0.03\nelse:\n    comissao = vendas * 0.01\nprint(f"Comissão: R$ {comissao:,.2f}")' }
        ]
      },
      {
        id: 'py-and-or-not', title: 'and, or e not: combinando condições',
        desc: 'Como juntar várias condições numa decisão só, e os atalhos que tornam o código mais legível.',
        objetivos: [
          'Combinar condições com and e or',
          'Negar condições com not',
          'Usar in para testar se um valor está numa lista de opções'
        ],
        body: 'Decisões reais quase sempre têm mais de um critério: "cliente de Goiás E com compra acima de R$ 500 ganha frete grátis". Os operadores lógicos juntam essas condições — os mesmos E e OU do Excel.',
        content: [
          { h: 'and e or',
            items: [
              '<code>and</code>: verdadeiro só se <strong>todas</strong> forem verdadeiras.',
              '<code>or</code>: verdadeiro se <strong>pelo menos uma</strong> for verdadeira.',
              'Use parênteses para deixar a intenção clara quando misturar os dois.'
            ],
            code: 'uf = "GO"\ncompra = 650\nfrete_gratis = uf == "GO" and compra > 500\nprint(frete_gratis)\nvip = compra > 1000 or uf == "DF"\nprint(vip)' },
          { h: 'not',
            code: 'cancelado = False\nif not cancelado:\n    print("Pedido segue para entrega")' },
          { h: 'in: está na lista?',
            p: 'Em vez de <code>uf == "GO" or uf == "DF" or uf == "MT"</code>, use <code>in</code> com uma lista de opções.',
            code: 'uf = "MT"\nif uf in ["GO", "DF", "MT", "MS"]:\n    print("Centro-Oeste")' },
          { h: 'Intervalos',
            p: 'Python aceita comparação encadeada: <code>18 &lt;= idade &lt; 60</code> é o mesmo que <code>idade &gt;= 18 and idade &lt; 60</code>.',
            code: 'idade = 35\nprint(18 <= idade < 60)' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print(True and False)', op: ['False', 'True', 'Erro'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print(True or False)', op: ['True', 'False', 'Erro'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print(not True)', op: ['False', 'True', 'not True'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'uf = "DF"\nprint(uf in ["GO", "DF"])', op: ['True', 'False', 'DF'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'x = 15\nprint(10 <= x < 20)', op: ['True', 'False', 'Erro'], a: 0 },
          { t: 'escolha', q: 'Frete grátis para GO E compra acima de 500. Qual condição?', op: ['uf == "GO" and compra > 500', 'uf == "GO" or compra > 500', 'uf == "GO" + compra > 500'], a: 0 },
          { t: 'lacuna', codigo: true, frase: 'if uf ___ ["GO", "DF", "MT", "MS"]:', op: ['in', '==', 'and'], a: 0, pt: 'Verifique se a UF é do Centro-Oeste.' },
          { t: 'pares', pares: [['and', 'todas verdadeiras (E)'], ['or', 'pelo menos uma (OU)'], ['not', 'inverte'], ['in', 'está na lista'], ['18 <= x < 60', 'intervalo']] }
        ],
        desafios: [
          { titulo: 'Regra de frete',
            cenario: 'O frete da loja segue as regras: é <strong>grátis</strong> (<code>frete = 0</code>) se o cliente for do Centro-Oeste (GO, DF, MT ou MS) <strong>e</strong> a compra passar de R$ 300, <strong>ou</strong> se a compra passar de R$ 1.000 em qualquer estado. Fora isso, o frete é <strong>R$ 29,90</strong>. Calcule a variável <code>frete</code>.',
            inicial: 'uf = "MT"\ncompra = 450\n',
            testes: [
              { py: 'assert frete == 0', msg: 'frete correto para MT com compra de 450' },
              { py: "__n = {}\nexec(compile(__codigo_aluno.replace('uf = \"MT\"', 'uf = \"SP\"'), 'x', 'exec'), __n)\nassert abs(__n['frete'] - 29.9) < 0.001", msg: 'frete correto para SP com compra de 450' },
              { py: "__n = {}\nexec(compile(__codigo_aluno.replace('uf = \"MT\"', 'uf = \"SP\"').replace('compra = 450', 'compra = 1200'), 'x', 'exec'), __n)\nassert __n['frete'] == 0", msg: 'frete correto para SP com compra de 1200' }
            ],
            dicas: ['Monte a condição em duas partes: (uf in [...] and compra > 300) or compra > 1000', 'Depois: if condição: frete = 0, else: frete = 29.90'],
            solucao: 'uf = "MT"\ncompra = 450\ncentro_oeste = uf in ["GO", "DF", "MT", "MS"]\nif (centro_oeste and compra > 300) or compra > 1000:\n    frete = 0\nelse:\n    frete = 29.90\nprint(f"Frete: R$ {frete:.2f}")' }
        ]
      },
      {
        id: 'py-decisoes-projeto', title: 'Projeto: classificando clientes',
        desc: 'Juntando comparações, if/elif e lógica para classificar clientes por faturamento e recência, como numa análise RFV.',
        objetivos: [
          'Escrever regras de negócio com if/elif/else',
          'Combinar critérios para classificar registros',
          'Testar o código com diferentes valores'
        ],
        body: 'Classificar clientes em faixas — ouro, prata, bronze; ativo ou inativo — é uma das tarefas mais comuns em análise de dados. Aqui você escreve as regras uma vez; no módulo de pandas, vai aplicá-las a milhares de clientes de uma só vez.',
        content: [
          { h: 'Regras de negócio viram código',
            items: [
              'Escreva primeiro as regras em português, como uma lista.',
              'Traduza cada regra para um <code>if</code>/<code>elif</code>, da mais exigente para a menos exigente.',
              'Termine com um <code>else</code> que cubra todo o resto — nenhum cliente fica sem categoria.'
            ],
            code: 'gasto_anual = 8500\ndias_sem_comprar = 40\n\nif dias_sem_comprar > 180:\n    categoria = "Inativo"\nelif gasto_anual >= 10000:\n    categoria = "Ouro"\nelif gasto_anual >= 5000:\n    categoria = "Prata"\nelse:\n    categoria = "Bronze"\nprint(categoria)' },
          { h: 'Teste os limites',
            p: 'Bons programadores testam os valores na fronteira: exatamente 5000, exatamente 180 dias. É ali que <code>&gt;</code> e <code>&gt;=</code> fazem diferença — e onde moram os erros.' },
          { h: 'Próximo passo',
            p: 'Agora o código classifica um cliente. No próximo módulo, com listas e laços, você vai percorrer uma lista inteira de clientes e contar quantos há em cada categoria.' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'g = 5000\nif g > 5000:\n    print("Prata")\nelse:\n    print("Bronze")', op: ['Bronze', 'Prata', 'Erro'], a: 0, exp: '5000 não é MAIOR que 5000. Para incluir o limite, use >=.' },
          { t: 'escolha', q: 'Por que testar "Inativo" antes de "Ouro"?', op: ['Porque um cliente parado há muito tempo deve ser Inativo mesmo tendo gasto muito', 'Porque o Python exige ordem alfabética', 'Não faz diferença'], a: 0, opPt: true },
          { t: 'escolha', q: 'Para que serve o else final na classificação?', op: ['Garantir que todo cliente receba uma categoria', 'Encerrar o programa', 'Repetir o if'], a: 0, opPt: true },
          { t: 'ordenar', q: 'Monte a classificação na ordem certa.', linhas: ['if gasto >= 10000:', '    categoria = "Ouro"', 'elif gasto >= 5000:', '    categoria = "Prata"', 'else:', '    categoria = "Bronze"'] },
          { t: 'lacuna', codigo: true, frase: 'if dias > 180:\n    categoria = "Inativo"\n___ gasto >= 10000:\n    categoria = "Ouro"', op: ['elif', 'else', 'if else'], a: 0, pt: 'Complete o segundo caminho.' },
          { t: 'pares', pares: [['regra de negócio', 'critério da empresa'], ['limite', 'valor de fronteira'], ['>=', 'inclui o limite'], ['>', 'exclui o limite'], ['else', 'todo o resto']] }
        ],
        desafios: [
          { titulo: 'Semáforo do estoque',
            cenario: 'Classifique cada produto na variável <code>status</code>: <code>"Ruptura"</code> se o estoque for 0; <code>"Crítico"</code> se o estoque cobrir menos de 7 dias de venda; <code>"Atenção"</code> se cobrir de 7 a 14 dias (inclusive); <code>"OK"</code> acima disso. Cobertura em dias = estoque ÷ venda média diária.',
            inicial: 'estoque = 120\nvenda_diaria = 10\n',
            testes: [
              { py: "assert status == 'Atenção'", msg: 'status correto para estoque 120 e venda 10/dia' },
              { py: "__n = {}\nexec(compile(__codigo_aluno.replace('estoque = 120', 'estoque = 0'), 'x', 'exec'), __n)\nassert __n['status'] == 'Ruptura'", msg: 'estoque zerado vira Ruptura' },
              { py: "__n = {}\nexec(compile(__codigo_aluno.replace('estoque = 120', 'estoque = 50'), 'x', 'exec'), __n)\nassert __n['status'] == 'Crítico'", msg: 'cobertura baixa vira Crítico' },
              { py: "__n = {}\nexec(compile(__codigo_aluno.replace('estoque = 120', 'estoque = 300'), 'x', 'exec'), __n)\nassert __n['status'] == 'OK'", msg: 'cobertura alta vira OK' },
              { py: "__n = {}\nexec(compile(__codigo_aluno.replace('estoque = 120', 'estoque = 140'), 'x', 'exec'), __n)\nassert __n['status'] == 'Atenção'", msg: 'exatamente 14 dias ainda é Atenção' }
            ],
            dicas: ['Calcule cobertura = estoque / venda_diaria (cuidado: teste a ruptura primeiro).', 'Ordem: estoque == 0, depois cobertura < 7, depois cobertura <= 14, senão OK.'],
            solucao: 'estoque = 120\nvenda_diaria = 10\nif estoque == 0:\n    status = "Ruptura"\nelse:\n    cobertura = estoque / venda_diaria\n    if cobertura < 7:\n        status = "Crítico"\n    elif cobertura <= 14:\n        status = "Atenção"\n    else:\n        status = "OK"\nprint(status)' }
        ]
      }
    ]
  }
  ,
  {
    id: 'py-m04', title: 'Módulo 04 · Listas e laços: for, while, range e acumuladores', kind: 'video',
    lessons: [
      {
        id: 'py-listas', title: 'Listas: guardando vários valores',
        desc: 'Como criar listas, acessar e alterar itens, adicionar e remover, e as funções len, sum, min, max e sorted.',
        objetivos: [
          'Criar listas e acessar itens por índice e fatia',
          'Adicionar, remover e alterar itens',
          'Calcular totais e extremos com sum, min, max e ordenar com sorted'
        ],
        body: 'Uma variável guarda um valor; uma lista guarda vários, em ordem: as vendas do mês, os produtos do pedido, as cidades atendidas. É a primeira estrutura de dados que você vai usar o tempo todo — e a ponte para as colunas do pandas.',
        content: [
          { h: 'Criando e acessando',
            p: 'Lista vai entre colchetes, com itens separados por vírgula. Índices e fatias funcionam como nos textos.',
            code: 'vendas = [1200, 850, 2300, 640]\nprint(vendas[0])\nprint(vendas[-1])\nprint(vendas[1:3])' },
          { h: 'Alterando a lista',
            items: [
              '<code>lista.append(x)</code> adiciona no fim · <code>lista.insert(i, x)</code> insere numa posição.',
              '<code>lista.remove(x)</code> remove pelo valor · <code>lista.pop()</code> remove o último.',
              '<code>lista[i] = novo</code> troca um item. Diferente dos textos, listas <strong>mudam</strong>.'
            ],
            code: 'produtos = ["caneta", "lápis"]\nprodutos.append("borracha")\nprodutos[0] = "caneta azul"\nprint(produtos)' },
          { h: 'Resumindo uma lista',
            code: 'vendas = [1200, 850, 2300, 640]\nprint(len(vendas), sum(vendas), min(vendas), max(vendas))\nprint(sum(vendas) / len(vendas))\nprint(sorted(vendas, reverse=True))' },
          { h: 'Está na lista?',
            p: 'O <code>in</code> funciona com listas também: <code>"GO" in ufs</code>. E <code>lista.count(x)</code> conta quantas vezes um valor aparece.' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'v = [10, 20, 30]\nprint(v[1])', op: ['20', '10', '30'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'v = [10, 20, 30]\nprint(sum(v))', op: ['60', '30', '[10, 20, 30]'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'v = [3, 1, 2]\nv.append(5)\nprint(len(v))', op: ['4', '3', '5'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print(sorted([3, 1, 2]))', op: ['[1, 2, 3]', '[3, 2, 1]', '[3, 1, 2]'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'v = [5, 8, 2]\nprint(max(v) - min(v))', op: ['6', '8', '2'], a: 0 },
          { t: 'lacuna', codigo: true, frase: 'produtos.___("borracha")', op: ['append', 'add', 'push'], a: 0, pt: 'Adicione "borracha" no fim da lista.' },
          { t: 'pares', pares: [['append', 'adiciona no fim'], ['remove', 'remove pelo valor'], ['len', 'quantidade de itens'], ['sum', 'soma'], ['sorted', 'ordenada']] },
          { t: 'ordenar', q: 'Monte o código que calcula a média das vendas.', linhas: ['vendas = [1200, 850, 2300]', 'media = sum(vendas) / len(vendas)', 'print(round(media, 2))'] }
        ],
        desafios: [
          { titulo: 'Resumo da semana',
            cenario: 'As vendas diárias da semana estão na lista <code>vendas</code>. Calcule <code>total</code>, <code>media</code> (arredondada em 2 casas), <code>melhor_dia</code> (o maior valor) e <code>top3</code> (lista com os três maiores valores, do maior para o menor).',
            inicial: 'vendas = [1850.0, 2310.5, 1640.0, 2980.0, 3410.75, 4120.0, 1975.25]\n',
            testes: [
              { py: 'assert abs(total - 18286.5) < 0.01', msg: 'total correto' },
              { py: 'assert abs(media - 2612.36) < 0.01', msg: 'média correta (2 casas)' },
              { py: 'assert melhor_dia == 4120.0', msg: 'melhor_dia correto' },
              { py: 'assert top3 == [4120.0, 3410.75, 2980.0]', msg: 'top3 correto' }
            ],
            dicas: ['total = sum(vendas); media = round(total / len(vendas), 2)', 'top3: ordene do maior para o menor com sorted(vendas, reverse=True) e pegue uma fatia [:3].'],
            solucao: 'vendas = [1850.0, 2310.5, 1640.0, 2980.0, 3410.75, 4120.0, 1975.25]\ntotal = sum(vendas)\nmedia = round(total / len(vendas), 2)\nmelhor_dia = max(vendas)\ntop3 = sorted(vendas, reverse=True)[:3]\nprint(total, media, melhor_dia, top3)' }
        ]
      },
      {
        id: 'py-for', title: 'O laço for: repetindo para cada item',
        desc: 'Como percorrer uma lista item por item com for, usar range e enumerate, e acumular resultados.',
        objetivos: [
          'Percorrer listas com for',
          'Gerar sequências com range e numerar com enumerate',
          'Usar acumuladores (somar, contar) dentro do laço'
        ],
        body: 'O laço for é o que faz o computador trabalhar por você: "para cada venda da lista, faça isso". Com ele, a limpeza que você fez num cliente no módulo 2 passa a valer para mil clientes.',
        content: [
          { h: 'for item in lista',
            p: 'A cada volta, a variável recebe o próximo item. O bloco indentado se repete para cada um.',
            code: 'cidades = ["Goiânia", "Itumbiara", "Rio Verde"]\nfor cidade in cidades:\n    print(f"Entregando em {cidade}")' },
          { h: 'Acumuladores',
            p: 'Crie a variável <strong>antes</strong> do laço e atualize dentro dele. É assim que se soma, conta ou monta uma nova lista.',
            code: 'vendas = [1200, 850, 2300, 640]\ntotal = 0\nacima_de_mil = 0\nfor v in vendas:\n    total = total + v\n    if v > 1000:\n        acima_de_mil += 1\nprint(total, acima_de_mil)' },
          { h: 'range: sequências de números',
            items: [
              '<code>range(5)</code> → 0, 1, 2, 3, 4 · <code>range(1, 6)</code> → 1 a 5 · <code>range(0, 10, 2)</code> → de 2 em 2.',
              'Útil para repetir algo N vezes ou gerar meses, anos, parcelas.'
            ],
            code: 'for mes in range(1, 13):\n    print(f"Mês {mes:02d}", end="  ")' },
          { h: 'enumerate: item e posição',
            code: 'produtos = ["caneta", "lápis", "borracha"]\nfor i, p in enumerate(produtos, start=1):\n    print(i, p)' }
        ],
        pratica: [
          { t: 'escolha', q: 'Quantas linhas este código imprime?', codigo: 'for x in [1, 2, 3]:\n    print(x)', op: ['3', '1', '6'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'total = 0\nfor v in [5, 10, 15]:\n    total += v\nprint(total)', op: ['30', '15', '5'], a: 0 },
          { t: 'escolha', q: 'Quais números range(1, 4) gera?', op: ['1, 2, 3', '1, 2, 3, 4', '0, 1, 2, 3'], a: 0, exp: 'O range para ANTES do fim, como a fatia.' },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'c = 0\nfor v in [800, 1200, 950, 3000]:\n    if v > 1000:\n        c += 1\nprint(c)', op: ['2', '4', '1'], a: 0 },
          { t: 'escolha', q: 'Onde deve ficar "total = 0"?', op: ['Antes do for', 'Dentro do for', 'Depois do for'], a: 0, exp: 'Se ficar dentro do for, o total volta a zero a cada volta.' },
          { t: 'lacuna', codigo: true, frase: 'for cidade ___ cidades:\n    print(cidade)', op: ['in', 'of', 'from'], a: 0, pt: 'Percorra a lista de cidades.' },
          { t: 'ordenar', q: 'Monte a soma das vendas com acumulador.', linhas: ['total = 0', 'for v in vendas:', '    total += v', 'print(total)'] },
          { t: 'pares', pares: [['for x in lista', 'para cada item'], ['range(5)', '0 a 4'], ['enumerate', 'posição e item'], ['+= 1', 'contar'], ['total = 0', 'acumulador']] }
        ],
        desafios: [
          { titulo: 'Limpando a lista de clientes',
            cenario: 'A lista <code>clientes</code> veio com espaços e maiúsculas bagunçadas. Usando um laço, crie a lista <code>limpos</code> com cada nome sem espaços nas pontas e com iniciais maiúsculas, e conte na variável <code>de_goias</code> quantos clientes têm <code>"- GO"</code> no fim.',
            inicial: 'clientes = ["  ana souza - GO", "BRUNO LIMA - DF ", "carla dias - GO", " diego alves - SP", "elisa rocha - GO "]\nlimpos = []\nde_goias = 0\n',
            testes: [
              { py: "assert limpos == ['Ana Souza - Go', 'Bruno Lima - Df', 'Carla Dias - Go', 'Diego Alves - Sp', 'Elisa Rocha - Go']", msg: 'limpos tem os 5 nomes padronizados' },
              { py: 'assert de_goias == 3', msg: 'de_goias está correto' }
            ],
            dicas: ['Dentro do for: limpo = c.strip().title() e depois limpos.append(limpo)', 'Para contar Goiás, verifique no texto limpo e original: c.strip().upper().endswith("- GO")'],
            solucao: 'clientes = ["  ana souza - GO", "BRUNO LIMA - DF ", "carla dias - GO", " diego alves - SP", "elisa rocha - GO "]\nlimpos = []\nde_goias = 0\nfor c in clientes:\n    limpos.append(c.strip().title())\n    if c.strip().upper().endswith("- GO"):\n        de_goias += 1\nprint(limpos)\nprint(de_goias)' }
        ]
      },
      {
        id: 'py-while-controle', title: 'while, break e continue',
        desc: 'O laço que repete enquanto uma condição for verdadeira, e como sair ou pular voltas com break e continue.',
        objetivos: [
          'Usar while quando não se sabe quantas voltas serão necessárias',
          'Interromper um laço com break e pular uma volta com continue',
          'Evitar laços infinitos'
        ],
        body: 'O for é para "cada item de uma lista". O while é para "enquanto algo for verdade": enquanto a dívida não for quitada, enquanto o estoque não acabar. Ele é poderoso — e é o único jeito de criar um laço infinito sem querer, então atenção.',
        content: [
          { h: 'while',
            p: 'Repete enquanto a condição for <code>True</code>. Algo dentro do laço precisa mudar a condição, senão ele nunca termina.',
            code: 'saldo = 1000\nmeses = 0\nwhile saldo > 0:\n    saldo -= 300\n    meses += 1\nprint(f"Quitado em {meses} meses")' },
          { h: 'break: sair do laço',
            code: 'pedidos = [120, 340, 0, 560]\nfor p in pedidos:\n    if p == 0:\n        print("Pedido inválido, parando")\n        break\n    print(f"Processando {p}")' },
          { h: 'continue: pular para a próxima volta',
            code: 'valores = [100, -50, 200, -10, 300]\ntotal = 0\nfor v in valores:\n    if v < 0:\n        continue  # ignora devoluções\n    total += v\nprint(total)' },
          { h: 'Cuidado com o laço infinito',
            p: '<code>while True:</code> só termina com um <code>break</code>. Se o seu código travar no laboratório, ele é interrompido em 20 segundos — revise a condição e o que muda a cada volta.' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'n = 0\nwhile n < 3:\n    n += 1\nprint(n)', op: ['3', '2', '0'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'for x in [1, 2, 3, 4]:\n    if x == 3:\n        break\n    print(x, end=" ")', op: ['1 2', '1 2 3', '1 2 4'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'for x in [1, 2, 3, 4]:\n    if x == 3:\n        continue\n    print(x, end=" ")', op: ['1 2 4', '1 2', '3'], a: 0 },
          { t: 'escolha', q: 'Por que este código nunca termina?', codigo: 'x = 10\nwhile x > 0:\n    print(x)', op: ['x nunca muda dentro do laço', 'Falta break no fim', 'print não funciona no while'], a: 0 },
          { t: 'escolha', q: 'Quando usar while em vez de for?', op: ['Quando não se sabe quantas voltas serão necessárias', 'Sempre que houver uma lista', 'Nunca'], a: 0, opPt: true },
          { t: 'lacuna', codigo: true, frase: 'if v < 0:\n    ___  # pula valores negativos', op: ['continue', 'break', 'pass'], a: 0, pt: 'Pule para a próxima volta.' },
          { t: 'pares', pares: [['while', 'enquanto'], ['break', 'sai do laço'], ['continue', 'pula a volta'], ['while True', 'só para com break'], ['saldo -= 300', 'muda a condição']] }
        ],
        desafios: [
          { titulo: 'Quanto tempo para juntar?',
            cenario: 'Você quer juntar <strong>R$ 10.000</strong>. Começa com R$ 0, guarda <strong>R$ 750</strong> por mês e o saldo rende <strong>1% ao mês</strong> (o rendimento entra antes do depósito). Com um <code>while</code>, calcule em quantos <code>meses</code> o saldo chega a pelo menos 10 mil e guarde o saldo final em <code>saldo</code>.',
            inicial: 'objetivo = 10000\ndeposito = 750\ntaxa = 0.01\nsaldo = 0\nmeses = 0\n',
            testes: [
              { py: 'assert meses == 13', msg: 'número de meses correto' },
              { py: 'assert 10000 <= saldo < 10800', msg: 'saldo final correto' }
            ],
            dicas: ['while saldo < objetivo: ... dentro, aplique o rendimento, some o depósito e conte o mês.', 'Rendimento: saldo = saldo * (1 + taxa); depois saldo += deposito; meses += 1'],
            solucao: 'objetivo = 10000\ndeposito = 750\ntaxa = 0.01\nsaldo = 0\nmeses = 0\nwhile saldo < objetivo:\n    saldo = saldo * (1 + taxa)\n    saldo += deposito\n    meses += 1\nprint(f"{meses} meses, saldo R$ {saldo:,.2f}")' }
        ]
      },
      {
        id: 'py-compreensao-projeto', title: 'List comprehension e o projeto do módulo',
        desc: 'A forma compacta de criar listas a partir de outras — e um projeto que junta listas, laços e decisões.',
        objetivos: [
          'Criar listas com list comprehension',
          'Filtrar listas com if dentro da comprehension',
          'Combinar listas e laços para analisar dados'
        ],
        body: 'Muitos laços servem só para criar uma lista nova a partir de outra: aplicar um desconto, filtrar valores. O Python tem uma forma curta e muito usada para isso — e entender essa forma ajuda a ler o código de qualquer projeto de dados.',
        content: [
          { h: 'List comprehension',
            p: '<code>[expressão for item in lista]</code> cria uma lista nova numa linha só.',
            code: 'precos = [10.0, 25.5, 8.9]\ncom_desconto = [p * 0.9 for p in precos]\nprint(com_desconto)' },
          { h: 'Com filtro',
            code: 'vendas = [1200, 850, 2300, 640, 1800]\ngrandes = [v for v in vendas if v > 1000]\nprint(grandes, len(grandes))' },
          { h: 'zip: duas listas lado a lado',
            p: '<code>zip</code> percorre duas listas ao mesmo tempo — como duas colunas de uma planilha.',
            code: 'produtos = ["caneta", "caderno", "mochila"]\nprecos = [2.5, 18.9, 129.0]\nfor produto, preco in zip(produtos, precos):\n    print(f"{produto:<10} R$ {preco:>7.2f}")' },
          { h: 'O caminho até o pandas',
            p: 'Você acabou de trabalhar com "colunas" em listas separadas. O pandas junta essas colunas numa tabela (DataFrame) e faz filtros, somas e médias sem você escrever o laço — mas por baixo é exatamente essa lógica.' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print([x * 2 for x in [1, 2, 3]])', op: ['[2, 4, 6]', '[1, 2, 3, 1, 2, 3]', '12'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print([x for x in [5, 12, 8, 20] if x > 10])', op: ['[12, 20]', '[5, 8]', '2'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'for a, b in zip(["x", "y"], [1, 2]):\n    print(a, b)', op: ['x 1\ny 2', 'x y\n1 2', "('x', 'y')"], a: 0 },
          { t: 'escolha', q: 'Qual comprehension pega só os nomes que começam com A?', op: ['[n for n in nomes if n.startswith("A")]', '[n if n.startswith("A") for n in nomes]', 'nomes.filter("A")'], a: 0 },
          { t: 'lacuna', codigo: true, frase: 'grandes = [v for v in vendas ___ v > 1000]', op: ['if', 'when', 'where'], a: 0, pt: 'Filtre só as vendas acima de mil.' },
          { t: 'ordenar', q: 'Monte o mesmo resultado com um laço comum.', linhas: ['grandes = []', 'for v in vendas:', '    if v > 1000:', '        grandes.append(v)'] },
          { t: 'pares', pares: [['[x for x in l]', 'nova lista'], ['if no fim', 'filtro'], ['zip', 'duas listas juntas'], ['append', 'adiciona item'], ['DataFrame', 'tabela do pandas']] }
        ],
        desafios: [
          { titulo: 'Relatório de produtos',
            cenario: 'Você tem três listas paralelas: <code>produtos</code>, <code>quantidades</code> vendidas e <code>precos</code>. Crie a lista <code>faturamentos</code> (quantidade × preço de cada produto), descubra o <code>campeao</code> (nome do produto com maior faturamento) e crie a lista <code>sem_venda</code> com os nomes dos produtos com quantidade 0.',
            inicial: 'produtos = ["Caneta", "Caderno", "Mochila", "Estojo", "Régua"]\nquantidades = [320, 85, 12, 0, 140]\nprecos = [2.5, 18.9, 129.0, 24.9, 3.2]\n',
            testes: [
              { py: 'assert [round(f, 2) for f in faturamentos] == [800.0, 1606.5, 1548.0, 0.0, 448.0]', msg: 'faturamentos corretos' },
              { py: "assert campeao == 'Caderno'", msg: 'campeao correto' },
              { py: "assert sem_venda == ['Estojo']", msg: 'sem_venda correto' }
            ],
            dicas: ['faturamentos = [q * p for q, p in zip(quantidades, precos)]', 'O campeão: ache o índice do maior faturamento com faturamentos.index(max(faturamentos)) e use em produtos[...].', 'sem_venda: comprehension com zip(produtos, quantidades) e if q == 0'],
            solucao: 'produtos = ["Caneta", "Caderno", "Mochila", "Estojo", "Régua"]\nquantidades = [320, 85, 12, 0, 140]\nprecos = [2.5, 18.9, 129.0, 24.9, 3.2]\nfaturamentos = [q * p for q, p in zip(quantidades, precos)]\ncampeao = produtos[faturamentos.index(max(faturamentos))]\nsem_venda = [n for n, q in zip(produtos, quantidades) if q == 0]\nprint(faturamentos, campeao, sem_venda)' }
        ]
      }
    ]
  }
  ,
  {
    id: 'py-m05', title: 'Módulo 05 · Dicionários, tuplas e conjuntos', kind: 'video',
    lessons: [
      {
        id: 'py-dicionarios', title: 'Dicionários: chave e valor',
        desc: 'A estrutura que guarda informações com nome — como um registro de planilha ou um objeto JSON.',
        objetivos: [
          'Criar dicionários e acessar valores pela chave',
          'Adicionar, alterar e remover chaves',
          'Usar get para evitar erro com chaves que não existem'
        ],
        body: 'Uma lista guarda itens por posição; um dicionário guarda por nome. Um cliente vira {"nome": "Ana", "cidade": "Goiânia", "gasto": 1500} — exatamente como uma linha de planilha com cabeçalhos. É também o formato dos dados que vêm de APIs e arquivos JSON.',
        content: [
          { h: 'Criando e acessando',
            p: 'Chaves entre aspas, dois-pontos, valor. Para ler, use a chave entre colchetes.',
            code: 'cliente = {"nome": "Ana", "cidade": "Goiânia", "gasto": 1500}\nprint(cliente["nome"])\nprint(cliente["gasto"] * 1.1)' },
          { h: 'Alterando',
            code: 'cliente = {"nome": "Ana", "gasto": 1500}\ncliente["gasto"] = 1800        # altera\ncliente["uf"] = "GO"             # cria chave nova\ndel cliente["nome"]              # remove\nprint(cliente)' },
          { h: 'get: sem erro se a chave não existir',
            p: '<code>dic["x"]</code> dá <code>KeyError</code> se a chave não existe. <code>dic.get("x", padrão)</code> devolve o padrão.',
            code: 'cliente = {"nome": "Ana"}\nprint(cliente.get("telefone", "não informado"))\nprint("nome" in cliente)' },
          { h: 'Percorrendo',
            code: 'estoque = {"caneta": 320, "caderno": 85, "mochila": 0}\nfor produto, qtd in estoque.items():\n    print(f"{produto}: {qtd}")\nprint(list(estoque.keys()))\nprint(sum(estoque.values()))' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'c = {"nome": "Ana", "uf": "GO"}\nprint(c["uf"])', op: ['GO', 'uf', 'Ana'], a: 0 },
          { t: 'escolha', q: 'O que acontece neste código?', codigo: 'c = {"nome": "Ana"}\nprint(c["idade"])', op: ['KeyError', 'Mostra None', 'Mostra 0'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'c = {"nome": "Ana"}\nprint(c.get("idade", 0))', op: ['0', 'KeyError', 'None'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'e = {"a": 10, "b": 5}\nprint(sum(e.values()))', op: ['15', 'ab', '2'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'c = {"gasto": 100}\nc["gasto"] += 50\nprint(c)', op: ["{'gasto': 150}", "{'gasto': 100}", '150'], a: 0 },
          { t: 'lacuna', codigo: true, frase: 'for chave, valor in estoque.___():', op: ['items', 'keys', 'pairs'], a: 0, pt: 'Percorra chave e valor ao mesmo tempo.' },
          { t: 'pares', pares: [['dic["k"]', 'valor da chave'], ['dic.get("k", 0)', 'valor ou padrão'], ['.keys()', 'as chaves'], ['.values()', 'os valores'], ['.items()', 'pares chave e valor']] },
          { t: 'ordenar', q: 'Monte o código que soma o estoque.', linhas: ['estoque = {"caneta": 320, "caderno": 85}', 'total = sum(estoque.values())', 'print(total)'] }
        ],
        desafios: [
          { titulo: 'Atualizando o estoque',
            cenario: 'O dicionário <code>estoque</code> tem a quantidade de cada produto e <code>vendas_do_dia</code> tem o que saiu hoje. Atualize o estoque descontando as vendas, crie a lista <code>repor</code> com os produtos que ficaram com menos de 20 unidades (em ordem alfabética) e o <code>total_itens</code> que sobraram.',
            inicial: 'estoque = {"caneta": 320, "caderno": 85, "mochila": 25, "estojo": 40, "régua": 18}\nvendas_do_dia = {"caneta": 45, "caderno": 70, "mochila": 10}\n',
            testes: [
              { py: "assert estoque == {'caneta': 275, 'caderno': 15, 'mochila': 15, 'estojo': 40, 'régua': 18}", msg: 'estoque atualizado corretamente' },
              { py: "assert repor == ['caderno', 'mochila', 'régua']", msg: 'repor correto (e em ordem alfabética)' },
              { py: 'assert total_itens == 363', msg: 'total_itens correto' }
            ],
            dicas: ['for produto, qtd in vendas_do_dia.items(): estoque[produto] -= qtd', 'repor = sorted([p for p, q in estoque.items() if q < 20])'],
            solucao: 'estoque = {"caneta": 320, "caderno": 85, "mochila": 25, "estojo": 40, "régua": 18}\nvendas_do_dia = {"caneta": 45, "caderno": 70, "mochila": 10}\nfor produto, qtd in vendas_do_dia.items():\n    estoque[produto] -= qtd\nrepor = sorted([p for p, q in estoque.items() if q < 20])\ntotal_itens = sum(estoque.values())\nprint(estoque, repor, total_itens)' }
        ]
      },
      {
        id: 'py-lista-de-dicionarios', title: 'Lista de dicionários: uma tabela em Python',
        desc: 'Como representar uma tabela inteira como lista de dicionários, filtrar, somar por grupo e ordenar.',
        objetivos: [
          'Representar linhas de uma tabela como lista de dicionários',
          'Filtrar e somar valores percorrendo os registros',
          'Agrupar valores por categoria usando um dicionário acumulador'
        ],
        body: 'Uma lista de dicionários é uma tabela: cada dicionário é uma linha, cada chave é uma coluna. É o formato de quase todo dado que vem de sistemas e APIs — e entender como somar por grupo aqui é entender o que o groupby do pandas faz por baixo.',
        content: [
          { h: 'A tabela',
            code: 'vendas = [\n    {"vendedor": "Ana", "regiao": "Sul", "valor": 1200},\n    {"vendedor": "Bruno", "regiao": "Norte", "valor": 850},\n    {"vendedor": "Ana", "regiao": "Sul", "valor": 640},\n    {"vendedor": "Carla", "regiao": "Norte", "valor": 2300},\n]\nprint(len(vendas), vendas[0]["vendedor"])' },
          { h: 'Filtrar e somar',
            code: 'vendas = [{"regiao": "Sul", "valor": 1200}, {"regiao": "Norte", "valor": 850}, {"regiao": "Sul", "valor": 640}]\ntotal_sul = sum(v["valor"] for v in vendas if v["regiao"] == "Sul")\nprint(total_sul)' },
          { h: 'Somar por grupo',
            p: 'Um dicionário vazio vira o acumulador: a chave é o grupo, o valor é a soma. Com <code>get(chave, 0)</code> não é preciso criar a chave antes.',
            code: 'vendas = [{"regiao": "Sul", "valor": 1200}, {"regiao": "Norte", "valor": 850}, {"regiao": "Sul", "valor": 640}]\npor_regiao = {}\nfor v in vendas:\n    por_regiao[v["regiao"]] = por_regiao.get(v["regiao"], 0) + v["valor"]\nprint(por_regiao)' },
          { h: 'Ordenar registros',
            p: '<code>sorted(lista, key=lambda r: r["valor"], reverse=True)</code> ordena pela coluna escolhida. O <code>lambda</code> é uma função curtinha que diz qual valor usar — você vai entender funções no próximo módulo.',
            code: 'vendas = [{"v": "Ana", "valor": 1200}, {"v": "Bruno", "valor": 850}, {"v": "Carla", "valor": 2300}]\nfor r in sorted(vendas, key=lambda r: r["valor"], reverse=True):\n    print(r["v"], r["valor"])' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que este código mostra?', codigo: 't = [{"n": "Ana"}, {"n": "Bia"}]\nprint(t[1]["n"])', op: ['Bia', 'Ana', 'n'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 't = [{"v": 10}, {"v": 20}, {"v": 5}]\nprint(sum(r["v"] for r in t))', op: ['35', '20', '3'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'g = {}\nfor x in ["a", "b", "a"]:\n    g[x] = g.get(x, 0) + 1\nprint(g)', op: ["{'a': 2, 'b': 1}", "{'a': 1, 'b': 1}", '3'], a: 0 },
          { t: 'escolha', q: 'Numa lista de dicionários representando uma tabela, cada dicionário é:', op: ['uma linha', 'uma coluna', 'uma planilha inteira'], a: 0, opPt: true },
          { t: 'lacuna', codigo: true, frase: 'por_regiao[r] = por_regiao.___(r, 0) + valor', op: ['get', 'find', 'sum'], a: 0, pt: 'Some no grupo, começando de zero se ele não existir.' },
          { t: 'ordenar', q: 'Monte a soma por região.', linhas: ['por_regiao = {}', 'for v in vendas:', '    r = v["regiao"]', '    por_regiao[r] = por_regiao.get(r, 0) + v["valor"]'] },
          { t: 'pares', pares: [['lista de dicionários', 'tabela'], ['dicionário', 'linha'], ['chave', 'coluna'], ['acumulador {}', 'soma por grupo'], ['key=lambda r: r["x"]', 'ordenar por coluna']] }
        ],
        desafios: [
          { titulo: 'Ranking de vendedores',
            cenario: 'Com a lista <code>vendas</code>, calcule o dicionário <code>por_vendedor</code> com o total vendido por cada um e a lista <code>ranking</code> com os nomes dos vendedores do maior para o menor total. Calcule também <code>ticket_medio</code>: o valor médio por venda (todas as vendas), arredondado em 2 casas.',
            inicial: 'vendas = [\n    {"vendedor": "Ana", "valor": 1200.0},\n    {"vendedor": "Bruno", "valor": 850.0},\n    {"vendedor": "Ana", "valor": 640.0},\n    {"vendedor": "Carla", "valor": 2300.0},\n    {"vendedor": "Bruno", "valor": 1990.0},\n    {"vendedor": "Carla", "valor": 410.0},\n    {"vendedor": "Ana", "valor": 980.0},\n]\n',
            testes: [
              { py: "assert por_vendedor == {'Ana': 2820.0, 'Bruno': 2840.0, 'Carla': 2710.0}", msg: 'por_vendedor correto' },
              { py: "assert ranking == ['Bruno', 'Ana', 'Carla']", msg: 'ranking correto' },
              { py: 'assert abs(ticket_medio - 1195.71) < 0.01', msg: 'ticket_medio correto' }
            ],
            dicas: ['Acumulador: por_vendedor[nome] = por_vendedor.get(nome, 0) + valor', 'ranking = sorted(por_vendedor, key=lambda n: por_vendedor[n], reverse=True)'],
            solucao: 'vendas = [\n    {"vendedor": "Ana", "valor": 1200.0},\n    {"vendedor": "Bruno", "valor": 850.0},\n    {"vendedor": "Ana", "valor": 640.0},\n    {"vendedor": "Carla", "valor": 2300.0},\n    {"vendedor": "Bruno", "valor": 1990.0},\n    {"vendedor": "Carla", "valor": 410.0},\n    {"vendedor": "Ana", "valor": 980.0},\n]\npor_vendedor = {}\nfor v in vendas:\n    por_vendedor[v["vendedor"]] = por_vendedor.get(v["vendedor"], 0) + v["valor"]\nranking = sorted(por_vendedor, key=lambda n: por_vendedor[n], reverse=True)\nticket_medio = round(sum(v["valor"] for v in vendas) / len(vendas), 2)\nprint(por_vendedor, ranking, ticket_medio)' }
        ]
      },
      {
        id: 'py-tuplas-sets', title: 'Tuplas e conjuntos (sets)',
        desc: 'Tuplas para dados que não mudam e conjuntos para valores únicos — removendo duplicatas e comparando listas.',
        objetivos: [
          'Usar tuplas e desempacotar valores',
          'Remover duplicatas com set',
          'Comparar grupos com união, interseção e diferença'
        ],
        body: 'Duas estruturas que resolvem problemas clássicos de dados: tuplas guardam valores fixos (como coordenadas ou um par data-valor), e conjuntos guardam valores sem repetição — a forma mais rápida de responder "quantos clientes únicos?" ou "quem comprou em janeiro mas não em fevereiro?".',
        content: [
          { h: 'Tuplas',
            p: 'Parecem listas, com parênteses, mas não mudam. Muito usadas para devolver vários valores e para desempacotar.',
            code: 'ponto = (-16.68, -49.25)\nlat, lon = ponto\nprint(lat, lon)\nmaior, menor = max([3, 9, 1]), min([3, 9, 1])\nprint(maior, menor)' },
          { h: 'Sets: valores únicos',
            code: 'cidades = ["Goiânia", "Itumbiara", "Goiânia", "Rio Verde", "Itumbiara"]\nunicas = set(cidades)\nprint(unicas, len(unicas))\nprint(sorted(unicas))' },
          { h: 'Comparando grupos',
            items: [
              '<code>a | b</code> união (está em qualquer um) · <code>a &amp; b</code> interseção (está nos dois).',
              '<code>a - b</code> diferença (está em a, mas não em b).',
              'Exemplo real: clientes de janeiro que não voltaram em fevereiro = <code>jan - fev</code>.'
            ],
            code: 'jan = {"Ana", "Bruno", "Carla", "Diego"}\nfev = {"Ana", "Carla", "Elisa"}\nprint("Voltaram:", jan & fev)\nprint("Não voltaram:", jan - fev)\nprint("Novos:", fev - jan)' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print(len(set([1, 2, 2, 3, 3, 3])))', op: ['3', '6', '1'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'a = {1, 2, 3}\nb = {2, 3, 4}\nprint(a & b)', op: ['{2, 3}', '{1, 2, 3, 4}', '{1}'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'a = {1, 2, 3}\nb = {2, 3, 4}\nprint(a - b)', op: ['{1}', '{4}', '{2, 3}'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'x, y = (10, 20)\nprint(y)', op: ['20', '10', '(10, 20)'], a: 0 },
          { t: 'escolha', q: 'Clientes que compraram em jan mas não em fev:', op: ['jan - fev', 'fev - jan', 'jan & fev'], a: 0 },
          { t: 'lacuna', codigo: true, frase: 'unicos = ___(clientes)', op: ['set', 'list', 'unique'], a: 0, pt: 'Remova os clientes repetidos.' },
          { t: 'pares', pares: [['(1, 2)', 'tupla'], ['{1, 2}', 'conjunto'], ['a | b', 'união'], ['a & b', 'interseção'], ['a - b', 'diferença']] }
        ],
        desafios: [
          { titulo: 'Retenção de clientes',
            cenario: 'As listas <code>compras_set</code> e <code>compras_out</code> têm o nome do cliente em cada compra de setembro e outubro (com repetições). Calcule <code>unicos_out</code> (quantos clientes diferentes compraram em outubro), <code>retidos</code> (lista em ordem alfabética de quem comprou nos dois meses), <code>perdidos</code> (comprou em setembro e não em outubro, em ordem alfabética) e <code>taxa_retencao</code> (retidos ÷ clientes únicos de setembro × 100, arredondada em 1 casa).',
            inicial: 'compras_set = ["Ana", "Bruno", "Ana", "Carla", "Diego", "Bruno", "Elisa"]\ncompras_out = ["Ana", "Carla", "Fábio", "Ana", "Gabi", "Carla", "Elisa"]\n',
            testes: [
              { py: 'assert unicos_out == 5', msg: 'unicos_out correto' },
              { py: "assert retidos == ['Ana', 'Carla', 'Elisa']", msg: 'retidos correto' },
              { py: "assert perdidos == ['Bruno', 'Diego']", msg: 'perdidos correto' },
              { py: 'assert taxa_retencao == 60.0', msg: 'taxa_retencao correta' }
            ],
            dicas: ['Transforme as duas listas em sets: s = set(compras_set), o = set(compras_out).', 'retidos = sorted(s & o); perdidos = sorted(s - o); taxa = len(s & o) / len(s) * 100'],
            solucao: 'compras_set = ["Ana", "Bruno", "Ana", "Carla", "Diego", "Bruno", "Elisa"]\ncompras_out = ["Ana", "Carla", "Fábio", "Ana", "Gabi", "Carla", "Elisa"]\ns = set(compras_set)\no = set(compras_out)\nunicos_out = len(o)\nretidos = sorted(s & o)\nperdidos = sorted(s - o)\ntaxa_retencao = round(len(s & o) / len(s) * 100, 1)\nprint(unicos_out, retidos, perdidos, taxa_retencao)' }
        ]
      },
      {
        id: 'py-json', title: 'JSON: dados de APIs e sistemas',
        desc: 'O formato de dados mais usado na internet, que é praticamente um dicionário do Python: ler, navegar e transformar.',
        objetivos: [
          'Converter texto JSON em dicionário com json.loads',
          'Navegar em estruturas aninhadas (dicionários dentro de listas)',
          'Gerar JSON a partir de dados Python com json.dumps'
        ],
        body: 'Quando um sistema conversa com outro — o site com o meio de pagamento, o Power BI com uma API — os dados viajam em JSON. A boa notícia: JSON é quase idêntico a um dicionário do Python, e o módulo json faz a conversão nos dois sentidos.',
        content: [
          { h: 'Texto JSON vira dicionário',
            code: 'import json\ntexto = \'{"pedido": 1042, "cliente": "Ana", "itens": [{"produto": "caneta", "qtd": 10}, {"produto": "caderno", "qtd": 2}]}\'\ndados = json.loads(texto)\nprint(dados["cliente"])\nprint(dados["itens"][1]["produto"])' },
          { h: 'Navegando em estruturas aninhadas',
            p: 'Leia de fora para dentro: <code>dados["itens"]</code> é uma lista; <code>[1]</code> pega o segundo item; <code>["produto"]</code> pega a chave dele.',
            code: 'import json\ndados = json.loads(\'{"itens": [{"produto": "caneta", "qtd": 10, "preco": 2.5}, {"produto": "caderno", "qtd": 2, "preco": 18.9}]}\')\ntotal = sum(i["qtd"] * i["preco"] for i in dados["itens"])\nprint(total)' },
          { h: 'Dicionário vira JSON',
            code: 'import json\nresumo = {"cliente": "Ana", "total": 62.8, "pago": True}\nprint(json.dumps(resumo, ensure_ascii=False, indent=2))' },
          { h: 'Diferenças pequenas',
            p: 'JSON usa <code>true</code>/<code>false</code>/<code>null</code> minúsculos; o Python, <code>True</code>/<code>False</code>/<code>None</code>. O módulo json converte isso sozinho.' }
        ],
        pratica: [
          { t: 'escolha', q: 'Qual função transforma texto JSON em dicionário?', op: ['json.loads', 'json.dumps', 'json.read'], a: 0 },
          { t: 'escolha', q: 'Em JSON, o equivalente ao None do Python é:', op: ['null', 'None', 'nil'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'd = {"itens": [{"p": "a"}, {"p": "b"}]}\nprint(d["itens"][0]["p"])', op: ['a', 'b', 'itens'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'd = {"itens": [{"q": 2}, {"q": 3}]}\nprint(sum(i["q"] for i in d["itens"]))', op: ['5', '2', '6'], a: 0 },
          { t: 'lacuna', codigo: true, frase: 'texto = json.___(resumo, indent=2)', op: ['dumps', 'loads', 'write'], a: 0, pt: 'Transforme o dicionário em texto JSON.' },
          { t: 'pares', pares: [['json.loads', 'texto → dicionário'], ['json.dumps', 'dicionário → texto'], ['true', 'True'], ['null', 'None'], ['[ ]', 'lista']] }
        ],
        desafios: [
          { titulo: 'O pedido da API',
            cenario: 'A API da loja devolveu o pedido no texto <code>resposta</code>. Converta para dicionário, calcule o <code>subtotal</code> (soma de quantidade × preço dos itens), aplique o cupom de desconto percentual do pedido para obter o <code>total</code> (arredondado em 2 casas) e crie a lista <code>produtos</code> com os nomes dos itens.',
            inicial: 'import json\nresposta = \'{"id": 1042, "cliente": {"nome": "Ana", "uf": "GO"}, "cupom_percentual": 10, "itens": [{"produto": "Caneta", "qtd": 10, "preco": 2.5}, {"produto": "Caderno", "qtd": 3, "preco": 18.9}, {"produto": "Mochila", "qtd": 1, "preco": 129.0}]}\'\n',
            testes: [
              { py: 'assert abs(subtotal - 210.7) < 0.001', msg: 'subtotal correto' },
              { py: 'assert total == 189.63', msg: 'total com desconto correto' },
              { py: "assert produtos == ['Caneta', 'Caderno', 'Mochila']", msg: 'produtos correto' }
            ],
            dicas: ['pedido = json.loads(resposta), depois navegue em pedido["itens"].', 'total = round(subtotal * (1 - pedido["cupom_percentual"] / 100), 2)'],
            solucao: 'import json\nresposta = \'{"id": 1042, "cliente": {"nome": "Ana", "uf": "GO"}, "cupom_percentual": 10, "itens": [{"produto": "Caneta", "qtd": 10, "preco": 2.5}, {"produto": "Caderno", "qtd": 3, "preco": 18.9}, {"produto": "Mochila", "qtd": 1, "preco": 129.0}]}\'\npedido = json.loads(resposta)\nsubtotal = sum(i["qtd"] * i["preco"] for i in pedido["itens"])\ntotal = round(subtotal * (1 - pedido["cupom_percentual"] / 100), 2)\nprodutos = [i["produto"] for i in pedido["itens"]]\nprint(subtotal, total, produtos)' }
        ]
      }
    ]
  }
  ,
  {
    id: 'py-m06', title: 'Módulo 06 · Funções: organizar e reaproveitar código', kind: 'video',
    lessons: [
      {
        id: 'py-funcoes-def', title: 'Criando funções com def',
        desc: 'Como empacotar um pedaço de código com nome, parâmetros e retorno para usar quantas vezes quiser.',
        objetivos: [
          'Criar funções com def, parâmetros e return',
          'Diferenciar print (mostrar) de return (devolver)',
          'Chamar a mesma função com valores diferentes'
        ],
        body: 'Se você copia e cola o mesmo trecho de código em vários lugares, está na hora de uma função. Ela dá nome a uma tarefa — "calcular a comissão", "limpar o nome" — e você chama sempre que precisar. Se a regra mudar, muda num lugar só.',
        content: [
          { h: 'def, parâmetros e return',
            code: 'def calcular_comissao(vendas):\n    if vendas > 100000:\n        return vendas * 0.05\n    return vendas * 0.03\n\nprint(calcular_comissao(150000))\nprint(calcular_comissao(80000))' },
          { h: 'print mostra, return devolve',
            items: [
              '<code>print</code> só mostra na tela; o valor não pode ser usado depois.',
              '<code>return</code> devolve o valor para quem chamou, que pode guardar, somar, comparar.',
              'Uma função sem <code>return</code> devolve <code>None</code>.'
            ],
            code: 'def dobro(x):\n    return x * 2\n\ntotal = dobro(10) + dobro(5)\nprint(total)' },
          { h: 'Vários parâmetros',
            code: 'def preco_final(preco, desconto, frete):\n    return preco * (1 - desconto / 100) + frete\n\nprint(preco_final(200, 10, 15))' },
          { h: 'Nomes de funções',
            p: 'Use verbos no infinitivo e letras minúsculas com <code>_</code>: <code>calcular_margem</code>, <code>limpar_nome</code>, <code>classificar_cliente</code>. A função deve fazer uma coisa só, e bem feita.' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'def triplo(x):\n    return x * 3\nprint(triplo(4))', op: ['12', '7', 'triplo(4)'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'def soma(a, b):\n    return a + b\nprint(soma(2, 3) * 2)', op: ['10', '7', '5'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'def f(x):\n    print(x * 2)\nr = f(5)\nprint(r)', op: ['10\nNone', '10\n10', 'None'], a: 0, exp: 'A função mostra 10 com print, mas não tem return: devolve None.' },
          { t: 'escolha', q: 'Qual palavra define uma função?', op: ['def', 'function', 'func'], a: 0 },
          { t: 'lacuna', codigo: true, frase: 'def margem(lucro, receita):\n    ___ lucro / receita * 100', op: ['return', 'print', 'give'], a: 0, pt: 'Devolva o resultado da conta.' },
          { t: 'ordenar', q: 'Monte a função e a chamada.', linhas: ['def calcular_imposto(valor):', '    return valor * 0.15', 'print(calcular_imposto(1000))'] },
          { t: 'pares', pares: [['def', 'cria função'], ['parâmetro', 'entrada da função'], ['return', 'devolve o resultado'], ['print', 'só mostra'], ['None', 'sem retorno']] }
        ],
        desafios: [
          { titulo: 'Funções de negócio',
            cenario: 'Crie duas funções: <code>margem(receita, custo)</code>, que devolve a margem percentual arredondada em 1 casa, e <code>status_margem(m)</code>, que devolve <code>"Saudável"</code> se a margem for 20% ou mais, <code>"Atenção"</code> se for de 10% a menos de 20%, e <code>"Crítica"</code> abaixo de 10%.',
            inicial: 'def margem(receita, custo):\n    pass\n\ndef status_margem(m):\n    pass\n',
            testes: [
              { py: 'assert margem(1000, 750) == 25.0', msg: 'margem(1000, 750) devolve 25.0' },
              { py: 'assert margem(300, 283) == 5.7', msg: 'margem arredonda em 1 casa' },
              { py: "assert status_margem(25.0) == 'Saudável' and status_margem(20) == 'Saudável'", msg: 'Saudável a partir de 20%' },
              { py: "assert status_margem(15) == 'Atenção' and status_margem(10) == 'Atenção'", msg: 'Atenção de 10% a menos de 20%' },
              { py: "assert status_margem(5.7) == 'Crítica'", msg: 'Crítica abaixo de 10%' }
            ],
            dicas: ['Troque o pass por return: return round((receita - custo) / receita * 100, 1)', 'Em status_margem, use if/elif/else com return em cada caminho.'],
            solucao: 'def margem(receita, custo):\n    return round((receita - custo) / receita * 100, 1)\n\ndef status_margem(m):\n    if m >= 20:\n        return "Saudável"\n    elif m >= 10:\n        return "Atenção"\n    return "Crítica"\n\nm = margem(1000, 750)\nprint(m, status_margem(m))' }
        ]
      },
      {
        id: 'py-funcoes-parametros', title: 'Parâmetros padrão, nomeados e vários retornos',
        desc: 'Recursos que tornam funções flexíveis: valores padrão, argumentos por nome, retorno de vários valores e docstrings.',
        objetivos: [
          'Definir parâmetros com valor padrão',
          'Chamar funções com argumentos nomeados',
          'Devolver vários valores com uma tupla e documentar com docstring'
        ],
        body: 'Funções de verdade costumam ter opções: um desconto que normalmente é zero, um separador que normalmente é vírgula. Parâmetros padrão e nomeados deixam a função fácil de usar no caso comum e configurável no caso especial — exatamente como as funções do pandas que você vai usar.',
        content: [
          { h: 'Valor padrão',
            code: 'def preco_final(preco, desconto=0, frete=0):\n    return preco * (1 - desconto / 100) + frete\n\nprint(preco_final(100))\nprint(preco_final(100, 10))\nprint(preco_final(100, frete=20))' },
          { h: 'Argumentos nomeados',
            p: 'Na chamada, dá para dizer o nome do parâmetro: fica mais legível e a ordem não importa. É o estilo do pandas: <code>pd.read_csv("arq.csv", sep=";", decimal=",")</code>.',
            code: 'def formatar(valor, moeda="R$", casas=2):\n    return f"{moeda} {valor:,.{casas}f}"\n\nprint(formatar(1234.5))\nprint(formatar(1234.5, casas=0, moeda="US$"))' },
          { h: 'Devolvendo vários valores',
            code: 'def resumo(valores):\n    return min(valores), max(valores), sum(valores) / len(valores)\n\nmenor, maior, media = resumo([10, 40, 25])\nprint(menor, maior, media)' },
          { h: 'Docstring',
            p: 'Um texto entre três aspas logo abaixo do <code>def</code> explica o que a função faz. Editores e o <code>help()</code> mostram esse texto.',
            code: 'def calcular_margem(receita, custo):\n    """Devolve a margem percentual (0 a 100) com uma casa decimal."""\n    return round((receita - custo) / receita * 100, 1)\n\nhelp(calcular_margem)' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'def f(x, y=10):\n    return x + y\nprint(f(5))', op: ['15', '5', 'Erro'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'def f(x, y=10):\n    return x + y\nprint(f(5, 1))', op: ['6', '15', '11'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'def f(a, b=2, c=3):\n    return a + b * c\nprint(f(1, c=10))', op: ['21', '31', '7'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'def mm(v):\n    return min(v), max(v)\na, b = mm([4, 9, 2])\nprint(b)', op: ['9', '2', '(2, 9)'], a: 0 },
          { t: 'escolha', q: 'Para que serve a docstring?', op: ['Documentar o que a função faz', 'Deixar a função mais rápida', 'Definir o valor padrão'], a: 0, opPt: true },
          { t: 'lacuna', codigo: true, frase: 'def juros(valor, taxa___0.01):', op: ['=', '==', ':'], a: 0, pt: 'Defina 0.01 como taxa padrão.' },
          { t: 'pares', pares: [['desconto=0', 'valor padrão'], ['frete=20 na chamada', 'argumento nomeado'], ['return a, b', 'dois valores'], ['"""texto"""', 'docstring'], ['help(f)', 'mostra a docstring']] }
        ],
        desafios: [
          { titulo: 'Simulador de parcelas',
            cenario: 'Crie a função <code>parcelas(valor, n=1, juros_mes=0)</code> que devolve <strong>dois valores</strong>: o valor de cada parcela e o total pago, ambos arredondados em 2 casas. Use juros compostos: total = valor × (1 + juros_mes/100) elevado a n. Sem juros, o total é o próprio valor.',
            inicial: 'def parcelas(valor, n=1, juros_mes=0):\n    pass\n',
            testes: [
              { py: 'assert parcelas(1200) == (1200.0, 1200.0)', msg: 'à vista (padrões)' },
              { py: 'assert parcelas(1200, 12) == (100.0, 1200.0)', msg: '12x sem juros' },
              { py: 'assert parcelas(1000, 3, juros_mes=2) == (353.74, 1061.21)', msg: '3x com 2% ao mês' }
            ],
            dicas: ['total = valor * (1 + juros_mes / 100) ** n', 'return round(total / n, 2), round(total, 2)'],
            solucao: 'def parcelas(valor, n=1, juros_mes=0):\n    total = valor * (1 + juros_mes / 100) ** n\n    return round(total / n, 2), round(total, 2)\n\nprint(parcelas(1000, 3, juros_mes=2))' }
        ]
      },
      {
        id: 'py-modulos', title: 'Módulos e bibliotecas: import',
        desc: 'Como usar código pronto: a biblioteca padrão (math, datetime, random, statistics) e a ideia das bibliotecas de terceiros como o pandas.',
        objetivos: [
          'Importar módulos com import e from ... import',
          'Usar math, statistics, random e datetime',
          'Entender o que são bibliotecas de terceiros'
        ],
        body: 'Ninguém escreve tudo do zero. O Python vem com centenas de módulos prontos — matemática, datas, estatística — e a comunidade criou milhares de outros, como o pandas. Para usar, basta um import.',
        content: [
          { h: 'import e from',
            code: 'import math\nprint(math.sqrt(144))\nprint(math.ceil(4.1))\n\nfrom statistics import mean, median\nprint(mean([10, 20, 60]), median([10, 20, 60]))' },
          { h: 'Datas com datetime',
            code: 'from datetime import date, timedelta\nhoje = date(2026, 10, 28)\nvencimento = hoje + timedelta(days=30)\nprint(vencimento)\nprint(vencimento.strftime("%d/%m/%Y"))\nprint((date(2026, 12, 25) - hoje).days)' },
          { h: 'random',
            code: 'import random\nrandom.seed(42)\nprint(random.randint(1, 100))\nprint(random.choice(["Ana", "Bruno", "Carla"]))' },
          { h: 'Apelidos e bibliotecas de terceiros',
            p: 'Bibliotecas grandes ganham apelido por convenção: <code>import pandas as pd</code>, <code>import matplotlib.pyplot as plt</code>. Fora do curso, elas são instaladas com <code>pip install pandas</code>; aqui no laboratório já estão disponíveis.' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'import math\nprint(math.sqrt(81))', op: ['9.0', '81', '3.0'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'from statistics import median\nprint(median([3, 1, 2]))', op: ['2', '3', '1'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'from datetime import date\nprint((date(2026, 1, 10) - date(2026, 1, 1)).days)', op: ['9', '10', '1'], a: 0 },
          { t: 'escolha', q: 'Qual é a forma convencional de importar o pandas?', op: ['import pandas as pd', 'import pd', 'from pandas import all'], a: 0 },
          { t: 'escolha', q: 'O que faz strftime("%d/%m/%Y")?', op: ['Formata a data como dia/mês/ano', 'Soma dias à data', 'Converte texto em data'], a: 0, opPt: true },
          { t: 'lacuna', codigo: true, frase: '___ datetime import date', op: ['from', 'import', 'use'], a: 0, pt: 'Importe só a classe date.' },
          { t: 'pares', pares: [['math', 'matemática'], ['statistics', 'estatística'], ['datetime', 'datas'], ['random', 'sorteios'], ['pandas', 'tabelas (terceiros)']] }
        ],
        desafios: [
          { titulo: 'Vencimentos e estatística',
            cenario: 'Para a lista de compras abaixo (datas e valores), calcule: <code>vencimentos</code> — lista com a data de cada compra + 30 dias, no formato texto <code>dd/mm/aaaa</code>; <code>media</code> e <code>mediana</code> dos valores (use o módulo statistics; média arredondada em 2 casas).',
            inicial: 'from datetime import date, timedelta\ncompras = [(date(2026, 10, 5), 1200.0), (date(2026, 10, 18), 340.0), (date(2026, 10, 30), 980.0), (date(2026, 11, 2), 4500.0)]\n',
            testes: [
              { py: "assert vencimentos == ['04/11/2026', '17/11/2026', '29/11/2026', '02/12/2026']", msg: 'vencimentos corretos' },
              { py: 'assert media == 1755.0', msg: 'média correta' },
              { py: 'assert mediana == 1090.0', msg: 'mediana correta' }
            ],
            dicas: ['Desempacote: for data_compra, valor in compras: ...', '(data_compra + timedelta(days=30)).strftime("%d/%m/%Y")', 'from statistics import mean, median'],
            solucao: 'from datetime import date, timedelta\nfrom statistics import mean, median\ncompras = [(date(2026, 10, 5), 1200.0), (date(2026, 10, 18), 340.0), (date(2026, 10, 30), 980.0), (date(2026, 11, 2), 4500.0)]\nvencimentos = [(d + timedelta(days=30)).strftime("%d/%m/%Y") for d, v in compras]\nvalores = [v for d, v in compras]\nmedia = round(mean(valores), 2)\nmediana = median(valores)\nprint(vencimentos, media, mediana)' }
        ]
      },
      {
        id: 'py-funcoes-projeto', title: 'Projeto: um mini-sistema de pedidos',
        desc: 'Organizando um programa inteiro em funções pequenas e testáveis — o jeito profissional de escrever scripts de dados.',
        objetivos: [
          'Quebrar um problema em funções pequenas',
          'Fazer funções trabalharem juntas',
          'Testar funções com assert'
        ],
        body: 'Programas de verdade são feitos de funções pequenas que conversam entre si: uma calcula o subtotal, outra aplica o desconto, outra formata o recibo. Cada uma é fácil de entender e de testar. É assim que você vai organizar seus scripts de dados daqui para frente.',
        content: [
          { h: 'Dividir para conquistar',
            code: 'def subtotal(itens):\n    return sum(i["qtd"] * i["preco"] for i in itens)\n\ndef aplicar_desconto(valor, cupom=0):\n    return valor * (1 - cupom / 100)\n\ndef recibo(cliente, total):\n    return f"{cliente}: R$ {total:,.2f}"\n\nitens = [{"qtd": 2, "preco": 50.0}, {"qtd": 1, "preco": 120.0}]\nprint(recibo("Ana", aplicar_desconto(subtotal(itens), 10)))' },
          { h: 'Testando com assert',
            p: '<code>assert condição</code> não faz nada se a condição for verdadeira e dá erro se for falsa. É o jeito mais simples de verificar que suas funções funcionam — e é exatamente o que o laboratório usa para conferir seus desafios.',
            code: 'def dobro(x):\n    return x * 2\n\nassert dobro(3) == 6\nassert dobro(0) == 0\nprint("Todos os testes passaram")' },
          { h: 'Boas práticas',
            items: [
              'Cada função faz uma coisa e tem nome que diz o quê.',
              'Funções recebem dados por parâmetro e devolvem com return — evite depender de variáveis de fora.',
              'Teste os casos de fronteira: lista vazia, valor zero, desconto de 100%.'
            ] }
        ],
        pratica: [
          { t: 'escolha', q: 'O que acontece neste código?', codigo: 'assert 2 + 2 == 5', op: ['AssertionError', 'Mostra False', 'Nada'], a: 0 },
          { t: 'escolha', q: 'O que acontece neste código?', codigo: 'assert 2 + 2 == 4\nprint("ok")', op: ['Mostra ok', 'AssertionError', 'Mostra True'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'def a(x):\n    return x + 1\ndef b(x):\n    return a(x) * 2\nprint(b(3))', op: ['8', '7', '6'], a: 0 },
          { t: 'escolha', q: 'Qual é a melhor prática para funções?', op: ['Cada função faz uma tarefa e devolve o resultado com return', 'Uma função gigante que faz tudo', 'Funções que só usam variáveis globais'], a: 0, opPt: true },
          { t: 'ordenar', q: 'Monte as funções na ordem certa de uso.', linhas: ['def subtotal(itens):', '    return sum(i["qtd"] * i["preco"] for i in itens)', 'total = subtotal(itens)', 'print(total)'] },
          { t: 'pares', pares: [['assert', 'verifica uma condição'], ['AssertionError', 'teste falhou'], ['função pequena', 'fácil de testar'], ['return', 'passa o resultado adiante'], ['caso de fronteira', 'zero, vazio, limite']] }
        ],
        desafios: [
          { titulo: 'O caixa da papelaria',
            cenario: 'Implemente três funções que trabalham juntas: <code>subtotal(itens)</code> (soma de qtd × preço), <code>desconto(valor)</code> (5% para compras a partir de R$ 200, 10% a partir de R$ 500, senão 0 — devolve o <strong>valor do desconto</strong>) e <code>fechar_pedido(itens)</code>, que devolve um dicionário com as chaves <code>subtotal</code>, <code>desconto</code> e <code>total</code>, todos arredondados em 2 casas.',
            inicial: 'def subtotal(itens):\n    pass\n\ndef desconto(valor):\n    pass\n\ndef fechar_pedido(itens):\n    pass\n\npedido = [{"qtd": 10, "preco": 2.5}, {"qtd": 4, "preco": 18.9}, {"qtd": 2, "preco": 64.9}]\nprint(fechar_pedido(pedido))\n',
            testes: [
              { py: 'assert abs(subtotal([{"qtd": 2, "preco": 10.0}]) - 20.0) < 0.001', msg: 'subtotal funciona' },
              { py: 'assert desconto(100) == 0 and abs(desconto(200) - 10) < 0.001 and abs(desconto(600) - 60) < 0.001', msg: 'desconto respeita as faixas' },
              { py: "r = fechar_pedido([{'qtd': 10, 'preco': 2.5}, {'qtd': 4, 'preco': 18.9}, {'qtd': 2, 'preco': 64.9}])\nassert r == {'subtotal': 230.4, 'desconto': 11.52, 'total': 218.88}", msg: 'fechar_pedido devolve o dicionário certo' },
              { py: "assert fechar_pedido([]) == {'subtotal': 0, 'desconto': 0, 'total': 0}", msg: 'funciona com pedido vazio' }
            ],
            dicas: ['desconto: if valor >= 500: return valor * 0.10; elif valor >= 200: return valor * 0.05; return 0', 'fechar_pedido: s = subtotal(itens); d = desconto(s); return {"subtotal": round(s, 2), "desconto": round(d, 2), "total": round(s - d, 2)}'],
            solucao: 'def subtotal(itens):\n    return sum(i["qtd"] * i["preco"] for i in itens)\n\ndef desconto(valor):\n    if valor >= 500:\n        return valor * 0.10\n    elif valor >= 200:\n        return valor * 0.05\n    return 0\n\ndef fechar_pedido(itens):\n    s = subtotal(itens)\n    d = desconto(s)\n    return {"subtotal": round(s, 2), "desconto": round(d, 2), "total": round(s - d, 2)}\n\npedido = [{"qtd": 10, "preco": 2.5}, {"qtd": 4, "preco": 18.9}, {"qtd": 2, "preco": 64.9}]\nprint(fechar_pedido(pedido))' }
        ]
      }
    ]
  }
  ,
  {
    id: 'py-m07', title: 'Módulo 07 · Erros e depuração: ler, prevenir e tratar', kind: 'video',
    lessons: [
      {
        id: 'py-lendo-erros', title: 'Lendo mensagens de erro',
        desc: 'Os erros mais comuns do Python — SyntaxError, NameError, TypeError, ValueError, KeyError, IndexError — e como a mensagem diz exatamente o que corrigir.',
        objetivos: [
          'Identificar o tipo do erro e a linha na mensagem',
          'Reconhecer os erros mais comuns e suas causas',
          'Corrigir erros lendo a mensagem em vez de adivinhar'
        ],
        body: 'Mensagem de erro não é bronca: é o Python dizendo exatamente onde e o que deu errado. Programadores experientes não erram menos — eles leem a mensagem e corrigem em segundos. Esta aula ensina a ler.',
        content: [
          { h: 'A anatomia da mensagem',
            items: [
              'O <strong>tipo</strong> do erro vem primeiro: <code>NameError</code>, <code>TypeError</code>...',
              'Depois a <strong>descrição</strong>: <code>name \'totl\' is not defined</code>.',
              'E a <strong>linha</strong> onde aconteceu. No laboratório, a mensagem mostra "(linha 3)", por exemplo.'
            ] },
          { h: 'Os erros mais comuns',
            items: [
              '<code>SyntaxError</code> — o código está "mal escrito": faltou dois-pontos, parêntese ou aspas.',
              '<code>IndentationError</code> — a indentação está errada depois de um <code>if</code>, <code>for</code> ou <code>def</code>.',
              '<code>NameError</code> — usou um nome que não existe (quase sempre erro de digitação).',
              '<code>TypeError</code> — operação com tipos incompatíveis: <code>"10" + 5</code>.',
              '<code>ValueError</code> — o tipo está certo, o valor não: <code>int("abc")</code>.',
              '<code>KeyError</code> / <code>IndexError</code> — chave de dicionário ou posição de lista que não existe.',
              '<code>ZeroDivisionError</code> — divisão por zero.'
            ] },
          { h: 'Experimente: provoque erros',
            p: 'Execute os blocos abaixo de propósito e leia cada mensagem. Depois corrija.',
            code: 'total = 100\nprint(totl)' },
          { h: 'Mais um',
            code: 'preco = "25"\nquantidade = 3\nprint(preco * quantidade + 1)' }
        ],
        pratica: [
          { t: 'escolha', q: 'Qual erro este código causa?', codigo: 'print(valor_total)', op: ['NameError', 'TypeError', 'SyntaxError'], a: 0 },
          { t: 'escolha', q: 'Qual erro este código causa?', codigo: 'print("Ano: " + 2026)', op: ['TypeError', 'NameError', 'ValueError'], a: 0 },
          { t: 'escolha', q: 'Qual erro este código causa?', codigo: 'int("12,5")', op: ['ValueError', 'TypeError', 'KeyError'], a: 0, exp: 'O tipo (texto) é aceito por int, mas o valor "12,5" não é um inteiro válido.' },
          { t: 'escolha', q: 'Qual erro este código causa?', codigo: 'c = {"nome": "Ana"}\nprint(c["idade"])', op: ['KeyError', 'IndexError', 'NameError'], a: 0 },
          { t: 'escolha', q: 'Qual erro este código causa?', codigo: 'v = [1, 2, 3]\nprint(v[3])', op: ['IndexError', 'KeyError', 'ValueError'], a: 0 },
          { t: 'escolha', q: 'Qual erro este código causa?', codigo: 'if x > 3\n    print(x)', op: ['SyntaxError', 'NameError', 'IndentationError'], a: 0 },
          { t: 'pares', pares: [['NameError', 'nome não existe'], ['TypeError', 'tipos incompatíveis'], ['ValueError', 'valor inválido'], ['IndexError', 'posição inexistente'], ['ZeroDivisionError', 'divisão por zero']] }
        ],
        desafios: [
          { titulo: 'Conserte o script',
            cenario: 'O script abaixo deveria calcular o total do pedido e o preço médio por item, mas tem <strong>três erros</strong>. Execute, leia cada mensagem, corrija um de cada vez e chegue em <code>total</code> = 235.0 e <code>preco_medio</code> = 19.58.',
            inicial: 'precos = [12.5, 30.0, 18.0, 45.0, 9.0]\nquantidades = [2, 1, "3", 2, 4]\n\ntotal = 0\nfor p, q in zip(precos, quantidades)\n    total += p * q\n\nitens = sum(quantidade)\npreco_medio = round(total / itens, 2)\nprint(total, preco_medio)\n',
            testes: [
              { py: 'assert abs(total - 235.0) < 0.001', msg: 'total correto' },
              { py: 'assert preco_medio == 19.58', msg: 'preco_medio correto' }
            ],
            dicas: ['Primeiro erro: SyntaxError na linha do for. O que toda linha de for precisa no final?', 'Depois: NameError — confira o nome da lista usada no sum.', 'Por fim: um TypeError ou um resultado estranho por causa de um item que é texto. Corrija o dado (ou converta com int).'],
            solucao: 'precos = [12.5, 30.0, 18.0, 45.0, 9.0]\nquantidades = [2, 1, 3, 2, 4]\n\ntotal = 0\nfor p, q in zip(precos, quantidades):\n    total += p * q\n\nitens = sum(quantidades)\npreco_medio = round(total / itens, 2)\nprint(total, preco_medio)' }
        ]
      },
      {
        id: 'py-try-except', title: 'try e except: tratando erros',
        desc: 'Como impedir que um dado ruim derrube o programa inteiro: capturar exceções, dar mensagens claras e seguir em frente.',
        objetivos: [
          'Capturar erros com try/except',
          'Tratar tipos específicos de erro',
          'Usar else e finally e decidir quando tratar e quando deixar o erro aparecer'
        ],
        body: 'Numa base com 10 mil linhas, uma linha com "R$ 1.2O0" (com a letra O) não pode derrubar todo o processamento. O try/except permite tentar algo arriscado e, se der errado, fazer outra coisa — registrar o problema e seguir para a próxima linha.',
        content: [
          { h: 'try / except',
            code: 'texto = "12,5"\ntry:\n    valor = float(texto)\nexcept ValueError:\n    print(f"Valor inválido: {texto!r}")\n    valor = 0.0\nprint(valor)' },
          { h: 'Num laço: pular as linhas ruins',
            code: 'entradas = ["100", "250", "abc", "75", ""]\nvalidos, invalidos = [], []\nfor e in entradas:\n    try:\n        validos.append(float(e))\n    except ValueError:\n        invalidos.append(e)\nprint(sum(validos), invalidos)' },
          { h: 'Vários tipos e else/finally',
            items: [
              'Capture tipos diferentes com <code>except (ValueError, TypeError):</code> ou vários blocos <code>except</code>.',
              '<code>else</code> roda se não houve erro; <code>finally</code> roda sempre (útil para fechar arquivos).',
              'Evite <code>except:</code> sem tipo: ele esconde até erros de digitação seus.'
            ],
            code: 'def dividir(a, b):\n    try:\n        r = a / b\n    except ZeroDivisionError:\n        return None\n    else:\n        return round(r, 2)\n\nprint(dividir(10, 4), dividir(10, 0))' },
          { h: 'Quando não tratar',
            p: 'Trate erros esperados (dado mal formatado, arquivo que pode não existir). Erros de lógica do seu próprio código não devem ser escondidos: deixe aparecer e corrija.' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'try:\n    x = int("abc")\nexcept ValueError:\n    x = -1\nprint(x)', op: ['-1', 'abc', 'ValueError'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'try:\n    x = int("7")\nexcept ValueError:\n    x = -1\nprint(x)', op: ['7', '-1', 'Erro'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'try:\n    print(1 / 0)\nexcept ZeroDivisionError:\n    print("divisão por zero")\nfinally:\n    print("fim")', op: ['divisão por zero\nfim', 'fim', 'divisão por zero'], a: 0 },
          { t: 'escolha', q: 'Por que evitar except sem tipo (except:)?', op: ['Ele esconde qualquer erro, inclusive os seus erros de digitação', 'Ele deixa o código mais lento', 'Ele não funciona em Python 3'], a: 0, opPt: true },
          { t: 'lacuna', codigo: true, frase: 'try:\n    valor = float(texto)\n___ ValueError:\n    valor = 0.0', op: ['except', 'catch', 'error'], a: 0, pt: 'Capture o erro de conversão.' },
          { t: 'ordenar', q: 'Monte o tratamento de erro.', linhas: ['try:', '    valor = float(texto)', 'except ValueError:', '    valor = 0.0'] },
          { t: 'pares', pares: [['try', 'tenta'], ['except', 'se der erro'], ['else', 'se não der erro'], ['finally', 'sempre'], ['raise', 'gera um erro']] }
        ],
        desafios: [
          { titulo: 'Valores sujos do sistema',
            cenario: 'A lista <code>valores_texto</code> veio do sistema antigo com formatos misturados. Crie a função <code>converter(texto)</code> que tira <code>"R$"</code> e espaços, troca a vírgula decimal por ponto (e remove o ponto de milhar quando houver vírgula) e devolve o <code>float</code> — ou <code>None</code> se não for possível converter. Depois calcule <code>total</code> (soma só dos válidos, arredondado em 2 casas) e <code>falhas</code> (quantos não converteram).',
            inicial: 'valores_texto = ["R$ 1.250,00", "980,50", "abc", "R$ 75", "", "2.000,10", "12O,00"]\n\ndef converter(texto):\n    pass\n',
            testes: [
              { py: 'assert converter("R$ 1.250,00") == 1250.0 and converter("980,50") == 980.5 and converter("R$ 75") == 75.0', msg: 'converter trata os formatos válidos' },
              { py: 'assert converter("abc") is None and converter("") is None and converter("12O,00") is None', msg: 'converter devolve None para os inválidos' },
              { py: 'assert total == 4305.6', msg: 'total correto' },
              { py: 'assert falhas == 3', msg: 'falhas correto' }
            ],
            dicas: ['Limpe primeiro: t = texto.replace("R$", "").strip(); se tiver vírgula, t = t.replace(".", "").replace(",", ".")', 'Envolva o float(t) num try/except ValueError e devolva None no except.', 'No laço, separe: if v is None: falhas += 1, senão some.'],
            solucao: 'valores_texto = ["R$ 1.250,00", "980,50", "abc", "R$ 75", "", "2.000,10", "12O,00"]\n\ndef converter(texto):\n    t = texto.replace("R$", "").strip()\n    if "," in t:\n        t = t.replace(".", "").replace(",", ".")\n    try:\n        return float(t)\n    except ValueError:\n        return None\n\ntotal = 0\nfalhas = 0\nfor texto in valores_texto:\n    v = converter(texto)\n    if v is None:\n        falhas += 1\n    else:\n        total += v\ntotal = round(total, 2)\nprint(total, falhas)' }
        ]
      },
      {
        id: 'py-depuracao', title: 'Depuração: encontrando erros de lógica',
        desc: 'Quando o código roda mas o resultado está errado: prints estratégicos, testar com dados pequenos e os erros de lógica mais comuns.',
        objetivos: [
          'Usar prints para inspecionar valores durante a execução',
          'Testar com dados pequenos e resultado conhecido',
          'Reconhecer erros de lógica comuns (limites, acumulador, indentação)'
        ],
        body: 'O pior erro não é o que aparece em vermelho: é o código que roda e dá o número errado. Depurar é investigar — olhar os valores no meio do caminho até achar onde a conta desvia do esperado.',
        content: [
          { h: 'print estratégico',
            p: 'Mostre o valor das variáveis dentro do laço para ver o que está acontecendo a cada volta. Depois de achar o problema, apague os prints.',
            code: 'vendas = [100, 200, 300]\ntotal = 0\nfor v in vendas:\n    total = v        # bug: deveria somar\n    print(f"v={v} total={total}")\nprint("Final:", total)' },
          { h: 'Teste com dados pequenos',
            p: 'Antes de rodar na base inteira, teste com 3 ou 4 linhas cujo resultado você calcula de cabeça. Se nesses casos não bater, o problema é do código, não do dado.' },
          { h: 'Os erros de lógica mais comuns',
            items: [
              'Acumulador zerado dentro do laço (ou usando <code>=</code> em vez de <code>+=</code>).',
              'Indentação: um comando que deveria estar dentro do laço ficou fora (ou vice-versa).',
              'Limites: <code>&gt;</code> no lugar de <code>&gt;=</code>; <code>range(1, 10)</code> que não inclui o 10.',
              'Ordem do if/elif: uma condição mais ampla antes da mais específica.',
              'Divisão inteira <code>//</code> onde deveria ser <code>/</code>.'
            ] },
          { h: 'assert como rede de segurança',
            code: 'def media(v):\n    return sum(v) / len(v)\n\nassert media([2, 4]) == 3\nassert media([10]) == 10\nprint("ok")' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'total = 0\nfor v in [1, 2, 3]:\n    total = v\nprint(total)', op: ['3', '6', '0'], a: 0, exp: 'O total é substituído a cada volta em vez de somado (faltou +=).' },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'for v in [1, 2, 3]:\n    total = 0\n    total += v\nprint(total)', op: ['3', '6', '0'], a: 0, exp: 'O acumulador volta a zero dentro do laço; só sobra o último valor.' },
          { t: 'escolha', q: 'Quantas vezes "x" é impresso?', codigo: 'for i in range(1, 5):\n    print("x")', op: ['4', '5', '3'], a: 0 },
          { t: 'escolha', q: 'Qual é o bug deste código?', codigo: 'nota = 95\nif nota >= 60:\n    c = "C"\nelif nota >= 90:\n    c = "A"', op: ['A condição mais ampla vem antes: nunca chega no A', 'Falta else', 'O >= deveria ser >'], a: 0, opPt: true },
          { t: 'escolha', q: 'Qual é a melhor primeira atitude quando o resultado está errado?', op: ['Testar com poucos dados e conferir os valores no meio do caminho', 'Reescrever tudo do zero', 'Rodar mais vezes até dar certo'], a: 0, opPt: true },
          { t: 'pares', pares: [['print no laço', 'ver valores a cada volta'], ['dados pequenos', 'resultado conhecido'], ['total = v', 'substitui em vez de somar'], ['range(1, 10)', 'não inclui o 10'], ['assert', 'teste automático']] }
        ],
        desafios: [
          { titulo: 'Bug na média ponderada',
            cenario: 'A função <code>media_ponderada(notas, pesos)</code> deveria devolver a soma de nota × peso dividida pela soma dos pesos, arredondada em 2 casas. Ela roda sem erro, mas dá o resultado errado. Encontre e corrija os <strong>dois</strong> erros de lógica (dica: use prints e teste com notas [10, 0] e pesos [1, 1], cujo resultado é 5.0).',
            inicial: 'def media_ponderada(notas, pesos):\n    soma = 0\n    for n, p in zip(notas, pesos):\n        soma = n * p\n    return round(soma / len(pesos), 2)\n\nprint(media_ponderada([8, 6, 9], [2, 1, 3]))\n',
            testes: [
              { py: 'assert media_ponderada([10, 0], [1, 1]) == 5.0', msg: 'caso simples correto' },
              { py: 'assert media_ponderada([8, 6, 9], [2, 1, 3]) == 8.17', msg: 'caso com pesos diferentes correto' },
              { py: 'assert media_ponderada([7], [4]) == 7.0', msg: 'caso com uma nota correto' }
            ],
            dicas: ['Coloque print(n, p, soma) dentro do laço: o acumulador está somando ou substituindo?', 'A divisão deve ser pela SOMA dos pesos, não pela quantidade.'],
            solucao: 'def media_ponderada(notas, pesos):\n    soma = 0\n    for n, p in zip(notas, pesos):\n        soma += n * p\n    return round(soma / sum(pesos), 2)\n\nprint(media_ponderada([8, 6, 9], [2, 1, 3]))' }
        ]
      },
      {
        id: 'py-erros-projeto', title: 'Projeto: validando uma base de cadastros',
        desc: 'Juntando try/except, funções e dicionários para validar registros e gerar um relatório de problemas.',
        objetivos: [
          'Escrever validações reutilizáveis em funções',
          'Separar registros válidos e inválidos com o motivo do erro',
          'Gerar um resumo da qualidade da base'
        ],
        body: 'Antes de qualquer análise, um bom analista verifica a qualidade da base: quantos registros têm problema, e quais. Neste projeto você constrói um validador que aponta, linha a linha, o que está errado — a mesma lógica das ferramentas de perfil de dados do Power Query.',
        content: [
          { h: 'Validações que devolvem o problema',
            p: 'Em vez de True/False, uma validação pode devolver a lista de problemas encontrados — vazia quando está tudo certo.',
            code: 'def validar(reg):\n    problemas = []\n    if not reg.get("nome", "").strip():\n        problemas.append("nome vazio")\n    if "@" not in reg.get("email", ""):\n        problemas.append("email inválido")\n    try:\n        if int(reg.get("idade", "")) < 0:\n            problemas.append("idade negativa")\n    except ValueError:\n        problemas.append("idade não numérica")\n    return problemas\n\nprint(validar({"nome": "Ana", "email": "ana@x.com", "idade": "30"}))\nprint(validar({"nome": " ", "email": "x", "idade": "trinta"}))' },
          { h: 'O resumo da qualidade',
            p: 'Com as validações prontas, percorra a base, conte os válidos e agrupe os problemas por tipo num dicionário — e você tem um relatório de qualidade.' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print(not " ".strip())', op: ['True', 'False', 'Erro'], a: 0, exp: '" ".strip() vira "", que é considerado falso; not "" é True.' },
          { t: 'escolha', q: 'Por que devolver a lista de problemas em vez de só True/False?', op: ['Para saber o motivo de cada registro ser inválido', 'Porque listas são mais rápidas', 'Porque o Python não aceita bool em funções'], a: 0, opPt: true },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'p = []\nprint(len(p) == 0)', op: ['True', 'False', '0'], a: 0 },
          { t: 'lacuna', codigo: true, frase: 'contagem[problema] = contagem.___(problema, 0) + 1', op: ['get', 'count', 'add'], a: 0, pt: 'Conte cada tipo de problema.' },
          { t: 'pares', pares: [['validar', 'verificar regras'], ['lista vazia', 'sem problemas'], ['try/except', 'conversão segura'], ['contagem por tipo', 'dicionário acumulador'], ['qualidade da base', 'quantos válidos']] }
        ],
        desafios: [
          { titulo: 'Relatório de qualidade',
            cenario: 'Valide a lista <code>cadastros</code>. Um registro é válido se: o nome não estiver vazio, o e-mail tiver exatamente um <code>@</code>, e o valor da compra puder virar <code>float</code> e for maior que zero. Crie <code>validos</code> (lista com os nomes válidos), <code>qualidade</code> (% de válidos, 1 casa) e <code>problemas</code> (dicionário contando cada tipo: <code>"nome"</code>, <code>"email"</code>, <code>"valor"</code> — um registro pode ter mais de um problema).',
            inicial: 'cadastros = [\n    {"nome": "Ana", "email": "ana@empresa.com", "valor": "150.0"},\n    {"nome": "", "email": "bruno@empresa.com", "valor": "80"},\n    {"nome": "Carla", "email": "carla.empresa.com", "valor": "abc"},\n    {"nome": "Diego", "email": "diego@@empresa.com", "valor": "-10"},\n    {"nome": "Elisa", "email": "elisa@empresa.com", "valor": "320.5"},\n]\n',
            testes: [
              { py: "assert validos == ['Ana', 'Elisa']", msg: 'validos correto' },
              { py: 'assert qualidade == 40.0', msg: 'qualidade correta' },
              { py: "assert problemas == {'nome': 1, 'email': 2, 'valor': 2}", msg: 'problemas contados por tipo' }
            ],
            dicas: ['Crie uma função que devolve a lista de problemas de um registro ("nome", "email", "valor").', 'Para o valor: try: v = float(reg["valor"]) ... except ValueError: problema. Se converter mas for <= 0, também é problema.'],
            solucao: 'cadastros = [\n    {"nome": "Ana", "email": "ana@empresa.com", "valor": "150.0"},\n    {"nome": "", "email": "bruno@empresa.com", "valor": "80"},\n    {"nome": "Carla", "email": "carla.empresa.com", "valor": "abc"},\n    {"nome": "Diego", "email": "diego@@empresa.com", "valor": "-10"},\n    {"nome": "Elisa", "email": "elisa@empresa.com", "valor": "320.5"},\n]\n\ndef checar(reg):\n    erros = []\n    if not reg["nome"].strip():\n        erros.append("nome")\n    if reg["email"].count("@") != 1:\n        erros.append("email")\n    try:\n        if float(reg["valor"]) <= 0:\n            erros.append("valor")\n    except ValueError:\n        erros.append("valor")\n    return erros\n\nvalidos = []\nproblemas = {}\nfor reg in cadastros:\n    erros = checar(reg)\n    if not erros:\n        validos.append(reg["nome"])\n    for e in erros:\n        problemas[e] = problemas.get(e, 0) + 1\nqualidade = round(len(validos) / len(cadastros) * 100, 1)\nprint(validos, qualidade, problemas)' }
        ]
      }
    ]
  }
  ,
  {
    id: 'py-m08', title: 'Módulo 08 · Arquivos: texto, CSV e JSON', kind: 'video',
    lessons: [
      {
        id: 'py-arquivos-texto', title: 'Lendo e gravando arquivos de texto',
        desc: 'Abrir, ler e gravar arquivos com open e with: o primeiro passo para o Python trabalhar com os dados que já existem no seu computador.',
        objetivos: [
          'Ler um arquivo inteiro ou linha por linha',
          'Gravar e acrescentar texto num arquivo (modos "w" e "a")',
          'Usar with para o arquivo ser fechado automaticamente'
        ],
        body: 'Até aqui os dados estavam escritos no próprio código. No dia a dia eles estão em arquivos: um log do sistema, uma exportação do ERP, uma lista de e-mails. Nesta aula o Python passa a ler esses arquivos e a gravar os resultados em arquivos novos — que você pode baixar e abrir.',
        content: [
          { h: 'open e with',
            items: [
              '<code>open("arquivo.txt", encoding="utf-8")</code> abre o arquivo para leitura.',
              'O <code>with</code> garante que o arquivo seja fechado no final do bloco, mesmo se der erro.',
              'Sempre informe <code>encoding="utf-8"</code>: assim acentos como "ã" e "ç" não viram símbolos estranhos.'
            ] },
          { h: 'Lendo o arquivo inteiro',
            p: 'Nesta aula o laboratório já tem o arquivo <code>sistema.log</code>, o registro de pedidos de uma loja. Execute:',
            code: 'with open("sistema.log", encoding="utf-8") as arq:\n    conteudo = arq.read()\n\nprint(conteudo[:200])\nprint("Caracteres:", len(conteudo))' },
          { h: 'Linha por linha',
            p: 'Percorrer o arquivo com <code>for</code> entrega uma linha de cada vez — o jeito certo para arquivos grandes. O <code>strip()</code> tira a quebra de linha do final.',
            code: 'with open("sistema.log", encoding="utf-8") as arq:\n    for linha in arq:\n        if "AVISO" in linha:\n            print(linha.strip())' },
          { h: 'Gravando: modos "w" e "a"',
            items: [
              '<code>"w"</code> (write) cria o arquivo do zero — se ele já existir, o conteúdo antigo é apagado.',
              '<code>"a"</code> (append) acrescenta no final, sem apagar o que já existe.',
              '<code>write</code> não pula linha sozinho: coloque <code>"\\n"</code> no final de cada linha.'
            ],
            code: 'with open("anotacoes.txt", "w", encoding="utf-8") as arq:\n    arq.write("Relatório de março\\n")\n    arq.write("Pedidos conferidos: 24\\n")\n\nwith open("anotacoes.txt", "a", encoding="utf-8") as arq:\n    arq.write("Revisado por: Ana\\n")\n\nwith open("anotacoes.txt", encoding="utf-8") as arq:\n    print(arq.read())' },
          { h: 'Baixe o que o seu código gerou',
            p: 'Quando o seu código grava um arquivo, o laboratório mostra um botão <strong>⬇ Baixar</strong> embaixo da saída. É o mesmo arquivo que o Python gravaria no seu computador.' }
        ],
        pratica: [
          { t: 'escolha', q: 'Qual modo apaga o conteúdo antigo e grava do zero?', op: ['"w"', '"a"', '"r"'], a: 0 },
          { t: 'escolha', q: 'Para que serve o with ao abrir um arquivo?', op: ['Fecha o arquivo automaticamente no fim do bloco', 'Deixa o arquivo mais rápido', 'Cria uma cópia do arquivo'], a: 0 },
          { t: 'lacuna', codigo: true, frase: 'with open("log.txt", "___", encoding="utf-8") as arq:', op: ['a', 'w', 'r'], a: 0, pt: 'Acrescente linhas no final do log sem apagar o que já existe.' },
          { t: 'escolha', q: 'O que este código mostra se o arquivo tem 3 linhas?', codigo: 'with open("nomes.txt", encoding="utf-8") as arq:\n    print(len(arq.read().splitlines()))', op: ['3', 'O texto das 3 linhas', 'Um erro'], a: 0 },
          { t: 'escolha', q: 'Por que usar strip() em cada linha lida?', op: ['Para tirar a quebra de linha (\\n) do final', 'Para deixar o texto em maiúsculas', 'Para pular linhas vazias'], a: 0 },
          { t: 'ordenar', q: 'Monte o código que grava uma linha num arquivo novo.', linhas: ['with open("saida.txt", "w", encoding="utf-8") as arq:', '    arq.write("Total: 1500\\n")', 'print("Arquivo gravado")'] }
        ],
        desafios: [
          { titulo: 'Separe os erros do log',
            cenario: 'O suporte pediu só as ocorrências de erro do arquivo <code>sistema.log</code>. Leia o arquivo, guarde em <code>qtd_erros</code> quantas linhas contêm <code>ERRO</code> e grave <strong>só essas linhas</strong>, na mesma ordem, num arquivo novo chamado <code>erros.txt</code> (uma por linha).',
            arquivos: { 'sistema.log': PY_ARQ['sistema.log'] },
            inicial: 'qtd_erros = 0\n\nwith open("sistema.log", encoding="utf-8") as arq:\n    linhas_log = arq.read().splitlines()\n\n# 1) conte as linhas que contêm ERRO\n# 2) grave essas linhas em erros.txt\n\nprint("Erros encontrados:", qtd_erros)\n',
            testes: [
              { py: 'assert qtd_erros == sum("ERRO" in l for l in open("sistema.log", encoding="utf-8").read().splitlines())', msg: 'qtd_erros correto' },
              { py: 'import os\nassert os.path.exists("erros.txt")', msg: 'arquivo erros.txt gravado' },
              { py: 'esperado = [l for l in open("sistema.log", encoding="utf-8").read().splitlines() if "ERRO" in l]\nassert open("erros.txt", encoding="utf-8").read().splitlines() == esperado', msg: 'erros.txt tem exatamente as linhas de erro, na ordem' }
            ],
            dicas: ['Percorra linhas_log com for e use if "ERRO" in linha.', 'Junte as linhas de erro numa lista; o tamanho dela (len) é o qtd_erros.', 'Para gravar: with open("erros.txt", "w", encoding="utf-8") as arq: e, dentro de um for, arq.write(linha + "\\n").'],
            solucao: 'with open("sistema.log", encoding="utf-8") as arq:\n    linhas_log = arq.read().splitlines()\n\nso_erros = [linha for linha in linhas_log if "ERRO" in linha]\nqtd_erros = len(so_erros)\n\nwith open("erros.txt", "w", encoding="utf-8") as arq:\n    for linha in so_erros:\n        arq.write(linha + "\\n")\n\nprint("Erros encontrados:", qtd_erros)' }
        ]
      },
      {
        id: 'py-csv-ler', title: 'Lendo CSV com o módulo csv',
        desc: 'Ler planilhas exportadas em CSV com csv.reader e csv.DictReader, converter os tipos e somar valores por categoria.',
        objetivos: [
          'Ler um CSV linha a linha com csv.reader e csv.DictReader',
          'Converter texto em número (int e float) antes de calcular',
          'Totalizar valores por categoria com um dicionário'
        ],
        body: 'CSV é o formato universal de exportação: ERP, banco, e-commerce, Google Planilhas — todos exportam CSV. O módulo csv do Python lê esse arquivo respeitando as regras do formato (aspas, vírgulas dentro do texto). Combinado com o dicionário do Módulo 05, você monta um resumo por região em poucas linhas.',
        content: [
          { h: 'O arquivo vendas.csv',
            p: 'Cada linha é uma venda: data, vendedor, região, produto, quantidade e preço unitário. A primeira linha é o cabeçalho. Abra a prévia do arquivo no desafio desta aula para ver o conteúdo.' },
          { h: 'csv.reader: cada linha vira uma lista',
            code: 'import csv\n\nwith open("vendas.csv", encoding="utf-8") as arq:\n    leitor = csv.reader(arq)\n    cabecalho = next(leitor)  # a primeira linha\n    print(cabecalho)\n    for linha in leitor:\n        print(linha)\n        break  # só a primeira venda' },
          { h: 'csv.DictReader: cada linha vira um dicionário',
            p: 'Com o DictReader você acessa as colunas pelo nome do cabeçalho — o código fica legível e não quebra se a ordem das colunas mudar.',
            code: 'import csv\n\nwith open("vendas.csv", encoding="utf-8") as arq:\n    for venda in csv.DictReader(arq):\n        print(venda["vendedor"], venda["produto"], venda["quantidade"])' },
          { h: 'Atenção: tudo chega como texto',
            items: [
              'O CSV não guarda tipos: <code>venda["quantidade"]</code> é <code>"3"</code>, não <code>3</code>.',
              'Converta antes de calcular: <code>int(venda["quantidade"])</code> e <code>float(venda["preco_unit"])</code>.',
              'Sem conversão, <code>"3" * "89.9"</code> dá TypeError — e <code>"3" + "2"</code> dá <code>"32"</code>, um erro silencioso.'
            ],
            code: 'import csv\n\nfaturamento = 0\nwith open("vendas.csv", encoding="utf-8") as arq:\n    for venda in csv.DictReader(arq):\n        faturamento += int(venda["quantidade"]) * float(venda["preco_unit"])\n\nprint(f"Faturamento: R$ {faturamento:,.2f}")' }
        ],
        pratica: [
          { t: 'escolha', q: 'Com csv.DictReader, cada linha do arquivo vira...', op: ['um dicionário com os nomes do cabeçalho', 'uma lista de números', 'um texto único'], a: 0 },
          { t: 'escolha', q: 'Qual o tipo de venda["quantidade"] lido de um CSV?', op: ['str (texto)', 'int', 'float'], a: 0, exp: 'O CSV é texto puro: toda coluna chega como str e precisa ser convertida.' },
          { t: 'lacuna', codigo: true, frase: 'total += ___(venda["quantidade"]) * float(venda["preco_unit"])', op: ['int', 'str', 'len'], a: 0, pt: 'Converta a quantidade para número inteiro.' },
          { t: 'escolha', q: 'O que next(leitor) faz logo depois de criar um csv.reader?', op: ['Lê a primeira linha (o cabeçalho)', 'Pula para o fim do arquivo', 'Fecha o arquivo'], a: 0 },
          { t: 'escolha', q: 'Qual o resultado?', codigo: 'print("3" + "2")', op: ['32', '5', 'TypeError'], a: 0, exp: 'Com textos, + junta os caracteres. É por isso que números lidos do CSV precisam de conversão.' },
          { t: 'ordenar', q: 'Monte o código que soma as quantidades vendidas (o módulo csv já foi importado).', linhas: ['total = 0', 'with open("vendas.csv", encoding="utf-8") as arq:', '    for venda in csv.DictReader(arq):', '        total += int(venda["quantidade"])', 'print(total)'] }
        ],
        desafios: [
          { titulo: 'Faturamento por região',
            cenario: 'A diretoria quer saber quanto cada região faturou em janeiro e fevereiro. Leia <code>vendas.csv</code> e monte o dicionário <code>por_regiao</code>: a chave é o nome da região e o valor é a soma de <code>quantidade × preco_unit</code>, arredondada com 2 casas. Depois guarde em <code>maior_regiao</code> o nome da região que mais faturou.',
            arquivos: { 'vendas.csv': PY_ARQ['vendas.csv'] },
            inicial: 'import csv\n\npor_regiao = {}\n\nwith open("vendas.csv", encoding="utf-8") as arq:\n    for venda in csv.DictReader(arq):\n        pass  # some quantidade * preco_unit na região da venda\n\nmaior_regiao = ""\nprint(por_regiao)\nprint("Maior:", maior_regiao)\n',
            testes: [
              { py: 'assert isinstance(por_regiao, dict) and len(por_regiao) == 4', msg: 'por_regiao tem uma chave para cada região' },
              { py: 'import csv\nesp = {}\nfor v in csv.DictReader(open("vendas.csv", encoding="utf-8")):\n    esp[v["regiao"]] = esp.get(v["regiao"], 0) + int(v["quantidade"]) * float(v["preco_unit"])\nassert all(abs(por_regiao[k] - round(esp[k], 2)) < 0.01 for k in esp)', msg: 'totais por região corretos' },
              { py: 'assert maior_regiao == max(por_regiao, key=por_regiao.get)', msg: 'maior_regiao correta' }
            ],
            dicas: ['Para cada venda: valor = int(venda["quantidade"]) * float(venda["preco_unit"]).', 'Acumule no dicionário: por_regiao[r] = por_regiao.get(r, 0) + valor.', 'Depois do laço, arredonde cada valor com round(..., 2). Para a maior: max(por_regiao, key=por_regiao.get).'],
            solucao: 'import csv\n\npor_regiao = {}\n\nwith open("vendas.csv", encoding="utf-8") as arq:\n    for venda in csv.DictReader(arq):\n        valor = int(venda["quantidade"]) * float(venda["preco_unit"])\n        r = venda["regiao"]\n        por_regiao[r] = por_regiao.get(r, 0) + valor\n\nfor r in por_regiao:\n    por_regiao[r] = round(por_regiao[r], 2)\n\nmaior_regiao = max(por_regiao, key=por_regiao.get)\nprint(por_regiao)\nprint("Maior:", maior_regiao)' }
        ]
      },
      {
        id: 'py-csv-brasil', title: 'CSV brasileiro e gravando CSV para o Excel',
        desc: 'Ponto e vírgula como separador e vírgula decimal: como ler o CSV que o Excel brasileiro exporta e gravar um CSV que abre certinho no Excel.',
        objetivos: [
          'Ler arquivos com delimiter=";" e números com vírgula decimal',
          'Gravar CSV com csv.writer e newline=""',
          'Gerar um arquivo que o Excel em português abre sem bagunçar as colunas'
        ],
        body: 'No Brasil a vírgula é o separador decimal, então o Excel em português exporta CSV com ponto e vírgula entre as colunas e "799,0" nos números. Se você ler esse arquivo do jeito padrão, vem tudo numa coluna só e o float() quebra. Nesta aula você aprende a ler e a gravar nesse formato.',
        content: [
          { h: 'Lendo com ponto e vírgula',
            p: 'O arquivo <code>vendas_br.csv</code> tem as vendas de março no formato do Excel brasileiro. Informe o separador com <code>delimiter=";"</code>:',
            code: 'import csv\n\nwith open("vendas_br.csv", encoding="utf-8") as arq:\n    for venda in csv.DictReader(arq, delimiter=";"):\n        print(venda["produto"], venda["preco_unit"])\n        break' },
          { h: 'Vírgula decimal',
            items: [
              '<code>float("799,0")</code> dá ValueError: o Python só entende ponto decimal.',
              'Troque antes de converter: <code>float(texto.replace(",", "."))</code>.',
              'Para gravar no padrão brasileiro, faça o caminho inverso: <code>str(valor).replace(".", ",")</code>.'
            ],
            code: 'texto = "1.299,90"  # com separador de milhar\nvalor = float(texto.replace(".", "").replace(",", "."))\nprint(valor)' },
          { h: 'Gravando CSV',
            items: [
              'Abra com <code>newline=""</code>: o módulo csv cuida das quebras de linha (sem isso aparecem linhas em branco no Windows).',
              '<code>csv.writer(arq, delimiter=";")</code> e <code>writerow([...])</code> para cada linha.',
              'Use <code>encoding="utf-8-sig"</code>: o Excel reconhece os acentos corretamente ao abrir com dois cliques.'
            ],
            code: 'import csv\n\nlinhas = [["vendedor", "total"], ["Ana", "1520,50"], ["Bruno", "980,00"]]\nwith open("teste_excel.csv", "w", newline="", encoding="utf-8-sig") as arq:\n    escritor = csv.writer(arq, delimiter=";")\n    for linha in linhas:\n        escritor.writerow(linha)\n\nprint(open("teste_excel.csv", encoding="utf-8-sig").read())' }
        ],
        pratica: [
          { t: 'escolha', q: 'Qual separador de colunas o Excel em português costuma usar no CSV?', op: ['; (ponto e vírgula)', ', (vírgula)', 'tab'], a: 0 },
          { t: 'escolha', q: 'O que acontece?', codigo: 'float("799,0")', op: ['ValueError', 'Retorna 799.0', 'Retorna 7990'], a: 0 },
          { t: 'lacuna', codigo: true, frase: 'valor = float(texto.replace(",", ___))', op: ['"."', '","', '""'], a: 0, pt: 'Troque a vírgula decimal por ponto antes de converter.' },
          { t: 'escolha', q: 'Por que abrir o arquivo com newline="" ao gravar CSV?', op: ['Para não aparecerem linhas em branco extras', 'Para gravar sem cabeçalho', 'Para gravar mais rápido'], a: 0 },
          { t: 'escolha', q: 'Qual encoding faz o Excel abrir os acentos corretamente com dois cliques?', op: ['"utf-8-sig"', '"ascii"', '"latin-1-excel"'], a: 0 },
          { t: 'pares', pares: [['delimiter=";"', 'separador de colunas'], ['newline=""', 'sem linhas em branco'], ['writerow', 'grava uma linha'], ['replace(",", ".")', 'vírgula decimal para ponto']] }
        ],
        desafios: [
          { titulo: 'Resumo por produto para o Excel',
            cenario: 'O financeiro mandou <code>vendas_br.csv</code> (março, formato do Excel brasileiro) e quer de volta um arquivo <code>resumo_produtos.csv</code> para abrir no Excel: separador <code>;</code>, cabeçalho <code>produto;total</code>, uma linha por produto com o faturamento (quantidade × preço) com <strong>vírgula decimal</strong> e 2 casas, ordenado do <strong>maior para o menor</strong> total.',
            arquivos: { 'vendas_br.csv': PY_ARQ['vendas_br.csv'] },
            inicial: 'import csv\n\ntotais = {}\n\nwith open("vendas_br.csv", encoding="utf-8") as arq:\n    for venda in csv.DictReader(arq):\n        pass  # some o faturamento de cada produto em totais\n\n# grave resumo_produtos.csv (produto;total), do maior para o menor\n',
            testes: [
              { py: 'import csv\nr = list(csv.reader(open("resumo_produtos.csv", encoding="utf-8-sig"), delimiter=";"))\nassert r[0] == ["produto", "total"]', msg: 'resumo_produtos.csv gravado com ; e cabeçalho produto;total' },
              { py: 'import csv\nesp = {}\nfor v in csv.DictReader(open("vendas_br.csv", encoding="utf-8"), delimiter=";"):\n    esp[v["produto"]] = esp.get(v["produto"], 0) + int(v["quantidade"]) * float(v["preco_unit"].replace(",", "."))\nr = list(csv.reader(open("resumo_produtos.csv", encoding="utf-8-sig"), delimiter=";"))[1:]\nassert len(r) == len(esp) and all(abs(float(t.replace(",", ".")) - esp[p]) < 0.01 for p, t in r)', msg: 'um total correto para cada produto' },
              { py: 'import csv\nr = list(csv.reader(open("resumo_produtos.csv", encoding="utf-8-sig"), delimiter=";"))[1:]\nassert all("," in t and "." not in t and len(t.split(",")[1]) == 2 for p, t in r)', msg: 'totais com vírgula decimal e 2 casas' },
              { py: 'import csv\nr = list(csv.reader(open("resumo_produtos.csv", encoding="utf-8-sig"), delimiter=";"))[1:]\nv = [float(t.replace(",", ".")) for p, t in r]\nassert v == sorted(v, reverse=True)', msg: 'ordenado do maior para o menor' }
            ],
            dicas: ['Leia com csv.DictReader(arq, delimiter=";") e converta o preço com float(venda["preco_unit"].replace(",", ".")).', 'Para ordenar: sorted(totais.items(), key=lambda par: par[1], reverse=True).', 'Formate com 2 casas e vírgula: f"{total:.2f}".replace(".", ","). Grave com newline="" e csv.writer(arq, delimiter=";").'],
            solucao: 'import csv\n\ntotais = {}\n\nwith open("vendas_br.csv", encoding="utf-8") as arq:\n    for venda in csv.DictReader(arq, delimiter=";"):\n        preco = float(venda["preco_unit"].replace(",", "."))\n        valor = int(venda["quantidade"]) * preco\n        totais[venda["produto"]] = totais.get(venda["produto"], 0) + valor\n\nordenado = sorted(totais.items(), key=lambda par: par[1], reverse=True)\n\nwith open("resumo_produtos.csv", "w", newline="", encoding="utf-8-sig") as arq:\n    escritor = csv.writer(arq, delimiter=";")\n    escritor.writerow(["produto", "total"])\n    for produto, total in ordenado:\n        escritor.writerow([produto, f"{total:.2f}".replace(".", ",")])\n\nprint(open("resumo_produtos.csv", encoding="utf-8-sig").read())' }
        ]
      },
      {
        id: 'py-arquivos-projeto', title: 'Projeto: consolidando planilhas mensais',
        desc: 'Juntar vários arquivos CSV num só com glob, acrescentar a coluna do mês e salvar um resumo em JSON — a tarefa repetitiva que toma horas no Excel.',
        objetivos: [
          'Encontrar vários arquivos com glob',
          'Consolidar CSVs com csv.DictWriter, acrescentando uma coluna',
          'Gravar um resumo em arquivo JSON com json.dump'
        ],
        body: 'Todo mês chega um arquivo novo e alguém copia e cola tudo numa planilha consolidada. Com Python, o script encontra todos os arquivos sozinho, junta as linhas, marca de que mês veio cada uma e ainda gera um resumo. No mês seguinte é só rodar de novo.',
        content: [
          { h: 'Encontrando os arquivos com glob',
            p: 'O <code>glob</code> lista os arquivos que combinam com um padrão; o <code>*</code> vale qualquer texto. Nesta aula o laboratório tem <code>mes_jan.csv</code>, <code>mes_fev.csv</code> e <code>mes_mar.csv</code>.',
            code: 'import glob\n\narquivos = sorted(glob.glob("mes_*.csv"))\nprint(arquivos)\nfor nome in arquivos:\n    mes = nome.replace("mes_", "").replace(".csv", "")\n    print(nome, "->", mes)' },
          { h: 'csv.DictWriter: gravando dicionários',
            items: [
              '<code>csv.DictWriter(arq, fieldnames=[...])</code> grava cada dicionário como uma linha, na ordem das colunas que você definir.',
              '<code>writeheader()</code> grava o cabeçalho; <code>writerow(dicionario)</code> grava uma linha.',
              'Para acrescentar uma coluna, basta incluir a chave no dicionário: <code>venda["mes"] = "jan"</code>.'
            ],
            code: 'import csv\n\nwith open("exemplo.csv", "w", newline="", encoding="utf-8") as arq:\n    escritor = csv.DictWriter(arq, fieldnames=["nome", "cidade"])\n    escritor.writeheader()\n    escritor.writerow({"nome": "Ana", "cidade": "Goiânia"})\n    escritor.writerow({"nome": "Bruno", "cidade": "Santos"})\n\nprint(open("exemplo.csv", encoding="utf-8").read())' },
          { h: 'JSON em arquivo: json.dump e json.load',
            p: 'No Módulo 05 você usou <code>json.dumps</code> (texto). Para arquivos, use <code>json.dump</code> e <code>json.load</code> — sem o "s". É o formato ideal para guardar resumos e configurações.',
            code: 'import json\n\nresumo = {"mes": "jan", "pedidos": 14, "faturamento": 5882.1}\nwith open("resumo_teste.json", "w", encoding="utf-8") as arq:\n    json.dump(resumo, arq, ensure_ascii=False, indent=2)\n\nwith open("resumo_teste.json", encoding="utf-8") as arq:\n    lido = json.load(arq)\nprint(lido["faturamento"])' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que glob.glob("mes_*.csv") retorna?', op: ['Uma lista com os nomes dos arquivos que combinam com o padrão', 'O conteúdo dos arquivos', 'Só o primeiro arquivo encontrado'], a: 0 },
          { t: 'escolha', q: 'Qual a diferença entre json.dump e json.dumps?', op: ['dump grava num arquivo; dumps devolve um texto', 'São iguais', 'dumps grava num arquivo; dump devolve um texto'], a: 0 },
          { t: 'lacuna', codigo: true, frase: 'escritor = csv.DictWriter(arq, ___=["data", "produto", "mes"])', op: ['fieldnames', 'columns', 'header'], a: 0, pt: 'Defina as colunas do arquivo de saída.' },
          { t: 'escolha', q: 'Qual o resultado?', codigo: 'nome = "mes_fev.csv"\nprint(nome.replace("mes_", "").replace(".csv", ""))', op: ['fev', 'mes_fev', 'fev.csv'], a: 0 },
          { t: 'escolha', q: 'O que writeheader() faz?', op: ['Grava a linha de cabeçalho com os nomes das colunas', 'Lê o cabeçalho do arquivo', 'Apaga o cabeçalho'], a: 0 },
          { t: 'ordenar', q: 'Monte o código que grava um resumo em JSON (o módulo json já foi importado).', linhas: ['resumo = {"total": 30276.0}', 'with open("resumo.json", "w", encoding="utf-8") as arq:', '    json.dump(resumo, arq, indent=2)'] }
        ],
        desafios: [
          { titulo: 'Consolidado do trimestre',
            cenario: 'Você recebeu as vendas do trimestre em três arquivos: <code>mes_jan.csv</code>, <code>mes_fev.csv</code> e <code>mes_mar.csv</code>. Faça o script que:<br>1) grava <code>consolidado.csv</code> com <strong>todas</strong> as vendas dos três arquivos, com as colunas originais e mais uma coluna <code>mes</code> no final (<code>jan</code>, <code>fev</code> ou <code>mar</code>);<br>2) grava <code>resumo.json</code> com o faturamento (quantidade × preço, 2 casas) de cada mês e do trimestre: <code>{"jan": ..., "fev": ..., "mar": ..., "trimestre": ...}</code>.',
            arquivos: { 'mes_jan.csv': PY_ARQ['mes_jan.csv'], 'mes_fev.csv': PY_ARQ['mes_fev.csv'], 'mes_mar.csv': PY_ARQ['mes_mar.csv'] },
            inicial: 'import csv, glob, json\n\ncolunas = ["data", "vendedor", "regiao", "produto", "quantidade", "preco_unit", "mes"]\ntodas = []\nresumo = {}\n\nfor nome in sorted(glob.glob("mes_*.csv")):\n    mes = nome.replace("mes_", "").replace(".csv", "")\n    # leia o arquivo, marque o mês em cada venda e some o faturamento do mês\n\n# grave consolidado.csv e resumo.json\n',
            testes: [
              { py: 'import csv\nr = list(csv.DictReader(open("consolidado.csv", encoding="utf-8-sig")))\nassert len(r) == sum(len(list(csv.DictReader(open(f"mes_{m}.csv", encoding="utf-8")))) for m in ["jan", "fev", "mar"])', msg: 'consolidado.csv tem todas as vendas dos três meses' },
              { py: 'import csv\nr = list(csv.reader(open("consolidado.csv", encoding="utf-8-sig")))\nassert r[0] == ["data", "vendedor", "regiao", "produto", "quantidade", "preco_unit", "mes"]', msg: 'colunas originais + mes no final' },
              { py: 'import csv\nfrom collections import Counter\nr = list(csv.DictReader(open("consolidado.csv", encoding="utf-8-sig")))\nesp = Counter({m: len(list(csv.DictReader(open(f"mes_{m}.csv", encoding="utf-8")))) for m in ["jan", "fev", "mar"]})\nassert Counter(v["mes"] for v in r) == esp', msg: 'coluna mes preenchida corretamente' },
              { py: 'import csv, json\nres = json.load(open("resumo.json", encoding="utf-8"))\nesp = {m: round(sum(int(v["quantidade"]) * float(v["preco_unit"]) for v in csv.DictReader(open(f"mes_{m}.csv", encoding="utf-8"))), 2) for m in ["jan", "fev", "mar"]}\nesp["trimestre"] = round(sum(esp.values()), 2)\nassert set(res) == set(esp) and all(abs(res[k] - esp[k]) < 0.01 for k in esp)', msg: 'resumo.json com o faturamento de cada mês e do trimestre' }
            ],
            dicas: ['Dentro do for: abra o arquivo, percorra csv.DictReader e, para cada venda, faça venda["mes"] = mes e todas.append(venda).', 'Some o faturamento do mês numa variável e guarde em resumo[mes] = round(total_mes, 2). Depois do for: resumo["trimestre"] = round(sum(resumo.values()), 2).', 'Grave com csv.DictWriter(arq, fieldnames=colunas), writeheader() e writerows(todas). Para o JSON: json.dump(resumo, arq, indent=2).'],
            solucao: 'import csv, glob, json\n\ncolunas = ["data", "vendedor", "regiao", "produto", "quantidade", "preco_unit", "mes"]\ntodas = []\nresumo = {}\n\nfor nome in sorted(glob.glob("mes_*.csv")):\n    mes = nome.replace("mes_", "").replace(".csv", "")\n    total_mes = 0\n    with open(nome, encoding="utf-8") as arq:\n        for venda in csv.DictReader(arq):\n            venda["mes"] = mes\n            todas.append(venda)\n            total_mes += int(venda["quantidade"]) * float(venda["preco_unit"])\n    resumo[mes] = round(total_mes, 2)\n\nresumo["trimestre"] = round(sum(resumo.values()), 2)\n\nwith open("consolidado.csv", "w", newline="", encoding="utf-8") as arq:\n    escritor = csv.DictWriter(arq, fieldnames=colunas)\n    escritor.writeheader()\n    escritor.writerows(todas)\n\nwith open("resumo.json", "w", encoding="utf-8") as arq:\n    json.dump(resumo, arq, ensure_ascii=False, indent=2)\n\nprint(len(todas), "vendas consolidadas")\nprint(resumo)' }
        ]
      }
    ]
  }
  ,
  {
    id: 'py-m09', title: 'Módulo 09 · pandas I: tabelas de dados (DataFrame)', kind: 'video',
    lessons: [
      {
        id: 'py-pandas-dataframe', title: 'Conhecendo o pandas e o DataFrame',
        desc: 'O que é o pandas, como ler um CSV num DataFrame e as primeiras perguntas para conhecer uma base: tamanho, colunas, tipos e resumo estatístico.',
        objetivos: [
          'Ler um CSV com pd.read_csv',
          'Explorar a base com head, shape, columns, dtypes e info',
          'Tirar estatísticas rápidas com describe, max, min e nunique'
        ],
        body: 'No Módulo 08 você somou vendas linha a linha com o módulo csv. O pandas faz o mesmo trabalho em uma linha e para milhões de registros: ele carrega o arquivo inteiro numa tabela — o DataFrame — com colunas nomeadas, como uma planilha. A partir daqui o Python vira sua ferramenta de análise de dados.',
        content: [
          { h: 'Importando e lendo',
            items: [
              'Por convenção, o pandas é importado como <code>pd</code>: <code>import pandas as pd</code>.',
              '<code>pd.read_csv("arquivo.csv")</code> lê o CSV e devolve um <strong>DataFrame</strong>.',
              'No laboratório, a primeira execução com pandas demora alguns segundos: o navegador baixa a biblioteca uma vez.'
            ],
            p: 'O arquivo <code>vendas_2026.csv</code> tem os pedidos do primeiro semestre de uma distribuidora de informática. Execute:',
            code: 'import pandas as pd\n\ndf = pd.read_csv("vendas_2026.csv")\nprint(df.head())' },
          { h: 'Tamanho, colunas e tipos',
            items: [
              '<code>df.shape</code> — (linhas, colunas).',
              '<code>df.columns</code> — os nomes das colunas.',
              '<code>df.dtypes</code> — o tipo de cada coluna: <code>int64</code> (inteiro), <code>float64</code> (decimal), <code>object</code> (texto).',
              'Diferente do módulo csv, o pandas já converte os números sozinho.'
            ],
            code: 'import pandas as pd\n\ndf = pd.read_csv("vendas_2026.csv")\nprint(df.shape)\nprint(list(df.columns))\nprint(df.dtypes)' },
          { h: 'Uma coluna é uma Series',
            p: 'Cada coluna (<code>df["quantidade"]</code>) é uma <strong>Series</strong>, e ela já sabe calcular: <code>sum</code>, <code>mean</code>, <code>max</code>, <code>min</code>, <code>nunique</code> (quantos valores diferentes).',
            code: 'import pandas as pd\n\ndf = pd.read_csv("vendas_2026.csv")\nprint("Itens vendidos:", df["quantidade"].sum())\nprint("Média por pedido:", round(df["quantidade"].mean(), 2))\nprint("Vendedores:", df["vendedor"].nunique())\nprint(df["quantidade"].describe())' }
        ],
        pratica: [
          { t: 'escolha', q: 'Como o pandas é importado por convenção?', op: ['import pandas as pd', 'import pd', 'from pandas import all'], a: 0 },
          { t: 'escolha', q: 'O que df.shape retorna para uma tabela com 240 linhas e 9 colunas?', op: ['(240, 9)', '(9, 240)', '2160'], a: 0 },
          { t: 'lacuna', codigo: true, frase: 'df = pd.___("vendas.csv")', op: ['read_csv', 'open', 'load_csv'], a: 0, pt: 'Leia o arquivo CSV num DataFrame.' },
          { t: 'escolha', q: 'Qual o tipo de uma coluna de texto no pandas (dtypes)?', op: ['object', 'str64', 'text'], a: 0 },
          { t: 'escolha', q: 'O que df["vendedor"].nunique() retorna?', op: ['Quantos vendedores diferentes existem', 'O primeiro vendedor', 'A lista de vendedores repetidos'], a: 0 },
          { t: 'pares', pares: [['df.head()', 'primeiras linhas'], ['df.shape', 'linhas e colunas'], ['df.dtypes', 'tipo de cada coluna'], ['df.describe()', 'resumo estatístico']] }
        ],
        desafios: [
          { titulo: 'Raio-x da base de vendas',
            cenario: 'Você acabou de receber <code>vendas_2026.csv</code> e precisa responder ao gestor em 5 minutos. Carregue o arquivo em <code>df</code> e preencha: <code>qtd_pedidos</code> (número de linhas), <code>qtd_colunas</code>, <code>produtos_distintos</code> (quantos produtos diferentes) e <code>maior_quantidade</code> (a maior quantidade vendida num único pedido).',
            arquivos: { 'vendas_2026.csv': PY_ARQ['vendas_2026.csv'] },
            inicial: 'import pandas as pd\n\ndf = None  # leia o arquivo aqui\n\nqtd_pedidos = 0\nqtd_colunas = 0\nprodutos_distintos = 0\nmaior_quantidade = 0\n\nprint(qtd_pedidos, qtd_colunas, produtos_distintos, maior_quantidade)\n',
            testes: [
              { py: 'import pandas as pd\nassert isinstance(df, pd.DataFrame) and df.shape == pd.read_csv("vendas_2026.csv").shape', msg: 'df é o DataFrame do arquivo' },
              { py: 'import pandas as pd\n_e = pd.read_csv("vendas_2026.csv")\nassert qtd_pedidos == _e.shape[0] and qtd_colunas == _e.shape[1]', msg: 'qtd_pedidos e qtd_colunas corretos' },
              { py: 'import pandas as pd\n_e = pd.read_csv("vendas_2026.csv")\nassert produtos_distintos == _e["produto"].nunique()', msg: 'produtos_distintos correto' },
              { py: 'import pandas as pd\n_e = pd.read_csv("vendas_2026.csv")\nassert maior_quantidade == _e["quantidade"].max()', msg: 'maior_quantidade correta' }
            ],
            dicas: ['df = pd.read_csv("vendas_2026.csv").', 'df.shape é uma dupla (linhas, colunas): use df.shape[0] e df.shape[1].', 'Para as colunas: df["produto"].nunique() e df["quantidade"].max().'],
            solucao: 'import pandas as pd\n\ndf = pd.read_csv("vendas_2026.csv")\n\nqtd_pedidos = df.shape[0]\nqtd_colunas = df.shape[1]\nprodutos_distintos = df["produto"].nunique()\nmaior_quantidade = df["quantidade"].max()\n\nprint(qtd_pedidos, qtd_colunas, produtos_distintos, maior_quantidade)' }
        ]
      },
      {
        id: 'py-pandas-filtros', title: 'Selecionando colunas e filtrando linhas',
        desc: 'Escolher as colunas que interessam, filtrar linhas por condição (com &, | e isin) e ordenar o resultado — o "filtro" e a "classificação" do Excel, em código.',
        objetivos: [
          'Selecionar uma ou várias colunas',
          'Filtrar linhas com condições e combiná-las com & e |',
          'Ordenar com sort_values e pegar os primeiros com head'
        ],
        body: 'Quase toda pergunta de negócio começa com um filtro: "só os notebooks", "só o Sudeste", "só os pedidos acima de 10 unidades". No pandas, um filtro é uma condição entre colchetes — e ele funciona igual para 200 ou 2 milhões de linhas.',
        content: [
          { h: 'Selecionando colunas',
            items: [
              'Uma coluna: <code>df["produto"]</code> (uma Series).',
              'Várias colunas: <code>df[["pedido", "produto", "quantidade"]]</code> — repare nos <strong>dois</strong> pares de colchetes: dentro vai uma lista.'
            ],
            code: 'import pandas as pd\n\ndf = pd.read_csv("vendas_2026.csv")\nprint(df[["pedido", "vendedor", "produto"]].head())' },
          { h: 'Filtrando linhas',
            p: 'A condição <code>df["categoria"] == "Notebooks"</code> gera uma coluna de True/False; colocada dentro de <code>df[...]</code>, ela mantém só as linhas True.',
            code: 'import pandas as pd\n\ndf = pd.read_csv("vendas_2026.csv")\nnotebooks = df[df["categoria"] == "Notebooks"]\nprint(len(notebooks), "pedidos de notebook")\nprint(notebooks.head())' },
          { h: 'Combinando condições',
            items: [
              '<code>&</code> = E, <code>|</code> = OU, <code>~</code> = NÃO.',
              'Cada condição vai entre <strong>parênteses</strong>: <code>(df["regiao"] == "Sul") & (df["quantidade"] >= 5)</code>.',
              'Vários valores possíveis: <code>df["regiao"].isin(["Sul", "Sudeste"])</code>.',
              'No pandas não se usa <code>and</code>/<code>or</code> entre colunas — dá erro.'
            ],
            code: 'import pandas as pd\n\ndf = pd.read_csv("vendas_2026.csv")\nfiltro = (df["regiao"].isin(["Sul", "Sudeste"])) & (df["quantidade"] >= 10)\nprint(df[filtro][["pedido", "regiao", "produto", "quantidade"]])' },
          { h: 'Ordenando',
            code: 'import pandas as pd\n\ndf = pd.read_csv("vendas_2026.csv")\ntop = df.sort_values("quantidade", ascending=False).head(5)\nprint(top[["pedido", "produto", "quantidade"]])' }
        ],
        pratica: [
          { t: 'escolha', q: 'Como selecionar as colunas produto e quantidade?', op: ['df[["produto", "quantidade"]]', 'df["produto", "quantidade"]', 'df.produto.quantidade'], a: 0 },
          { t: 'lacuna', codigo: true, frase: 'grandes = df[(df["quantidade"] >= 10) ___ (df["regiao"] == "Sul")]', op: ['&', 'and', '+'], a: 0, pt: 'Pedidos com 10 ou mais unidades E da região Sul.' },
          { t: 'escolha', q: 'Por que cada condição fica entre parênteses ao combinar com & ?', op: ['Por causa da ordem das operações: sem eles o & é avaliado antes do ==', 'É só estilo, tanto faz', 'Para o resultado sair ordenado'], a: 0 },
          { t: 'escolha', q: 'O que df["regiao"].isin(["Sul", "Norte"]) faz?', op: ['Marca True nas linhas cuja região é Sul ou Norte', 'Conta quantas regiões existem', 'Troca as regiões por Sul e Norte'], a: 0 },
          { t: 'lacuna', codigo: true, frase: 'df.sort_values("quantidade", ascending=___)', op: ['False', 'True', '"desc"'], a: 0, pt: 'Ordene da maior para a menor quantidade.' },
          { t: 'ordenar', q: 'Monte o código dos 3 pedidos de Monitores com maior quantidade.', linhas: ['monitores = df[df["categoria"] == "Monitores"]', 'top3 = monitores.sort_values("quantidade", ascending=False).head(3)', 'print(top3)'] }
        ],
        desafios: [
          { titulo: 'Lista para o gerente regional',
            cenario: 'O gerente do Sul e do Sudeste quer revisar os pedidos de <strong>Notebooks</strong> e <strong>Monitores</strong> das regiões <strong>Sul</strong> e <strong>Sudeste</strong>. Monte <code>selecao</code> só com essas linhas e só com as colunas <code>pedido</code>, <code>data</code>, <code>regiao</code>, <code>produto</code> e <code>quantidade</code>, ordenada da <strong>maior para a menor quantidade</strong>. Depois guarde em <code>top3</code> as 3 primeiras linhas de <code>selecao</code>.',
            arquivos: { 'vendas_2026.csv': PY_ARQ['vendas_2026.csv'] },
            inicial: 'import pandas as pd\n\ndf = pd.read_csv("vendas_2026.csv")\n\nselecao = df  # filtre, escolha as colunas e ordene\ntop3 = None\n\nprint(len(selecao))\nprint(top3)\n',
            testes: [
              { py: 'import pandas as pd\n_e = pd.read_csv("vendas_2026.csv")\n_e = _e[_e["categoria"].isin(["Notebooks", "Monitores"]) & _e["regiao"].isin(["Sul", "Sudeste"])]\nassert len(selecao) == len(_e) and set(selecao["pedido"]) == set(_e["pedido"])', msg: 'selecao tem exatamente os pedidos pedidos' },
              { py: 'assert list(selecao.columns) == ["pedido", "data", "regiao", "produto", "quantidade"]', msg: 'colunas certas, na ordem pedida' },
              { py: 'assert list(selecao["quantidade"]) == sorted(selecao["quantidade"], reverse=True)', msg: 'ordenada da maior para a menor quantidade' },
              { py: 'assert len(top3) == 3 and list(top3["pedido"]) == list(selecao["pedido"].head(3))', msg: 'top3 são as 3 primeiras de selecao' }
            ],
            dicas: ['Filtro: df["categoria"].isin(["Notebooks", "Monitores"]) & df["regiao"].isin(["Sul", "Sudeste"]).', 'Depois de filtrar, escolha as colunas com uma lista: [["pedido", "data", "regiao", "produto", "quantidade"]].', 'Ordene com .sort_values("quantidade", ascending=False) e use .head(3) para o top3.'],
            solucao: 'import pandas as pd\n\ndf = pd.read_csv("vendas_2026.csv")\n\nfiltro = df["categoria"].isin(["Notebooks", "Monitores"]) & df["regiao"].isin(["Sul", "Sudeste"])\nselecao = df[filtro][["pedido", "data", "regiao", "produto", "quantidade"]]\nselecao = selecao.sort_values("quantidade", ascending=False)\ntop3 = selecao.head(3)\n\nprint(len(selecao))\nprint(top3)' }
        ]
      },
      {
        id: 'py-pandas-colunas', title: 'Colunas calculadas, datas e contagens',
        desc: 'Criar colunas com contas entre colunas, transformar texto em data para extrair o mês e contar ocorrências com value_counts.',
        objetivos: [
          'Criar colunas calculadas (como uma fórmula arrastada no Excel)',
          'Converter datas com pd.to_datetime e extrair mês e dia da semana',
          'Contar ocorrências com value_counts'
        ],
        body: 'No Excel você escreve =G2*H2 e arrasta até a última linha. No pandas, df["faturamento"] = df["quantidade"] * df["preco_unit"] calcula todas as linhas de uma vez. Nesta aula você cria colunas novas, trabalha com datas e descobre o que mais se repete na base.',
        content: [
          { h: 'Coluna calculada',
            code: 'import pandas as pd\n\ndf = pd.read_csv("vendas_2026.csv")\ndf["faturamento"] = df["quantidade"] * df["preco_unit"]\nprint(df[["pedido", "quantidade", "preco_unit", "faturamento"]].head())\nprint("Total:", round(df["faturamento"].sum(), 2))' },
          { h: 'Datas de verdade',
            items: [
              'No CSV a data é texto (<code>object</code>). <code>pd.to_datetime(df["data"])</code> transforma em data.',
              'Com data de verdade, o <code>.dt</code> dá acesso às partes: <code>.dt.month</code>, <code>.dt.year</code>, <code>.dt.day</code>, <code>.dt.dayofweek</code> (0 = segunda).'
            ],
            code: 'import pandas as pd\n\ndf = pd.read_csv("vendas_2026.csv")\ndf["data"] = pd.to_datetime(df["data"])\ndf["mes"] = df["data"].dt.month\nprint(df[["pedido", "data", "mes"]].head())\nprint(df["data"].min(), "até", df["data"].max())' },
          { h: 'Contando com value_counts',
            p: '<code>value_counts()</code> conta quantas vezes cada valor aparece, do mais frequente para o menos. <code>idxmax()</code> devolve o rótulo do maior valor.',
            code: 'import pandas as pd\n\ndf = pd.read_csv("vendas_2026.csv")\ncontagem = df["categoria"].value_counts()\nprint(contagem)\nprint("Mais pedida:", contagem.idxmax())' }
        ],
        pratica: [
          { t: 'lacuna', codigo: true, frase: 'df["faturamento"] = df["quantidade"] ___ df["preco_unit"]', op: ['*', '+', '&'], a: 0, pt: 'Calcule o faturamento de cada linha.' },
          { t: 'escolha', q: 'O que pd.to_datetime(df["data"]) faz?', op: ['Transforma o texto em data de verdade', 'Mostra a data de hoje', 'Ordena por data'], a: 0 },
          { t: 'lacuna', codigo: true, frase: 'df["mes"] = df["data"].___.month', op: ['dt', 'date', 'str'], a: 0, pt: 'Extraia o mês da coluna de datas.' },
          { t: 'escolha', q: 'O que df["vendedor"].value_counts() retorna?', op: ['Quantos pedidos cada vendedor tem, do maior para o menor', 'A soma das vendas de cada vendedor', 'Os vendedores em ordem alfabética'], a: 0 },
          { t: 'escolha', q: 'Numa Series de contagens, o que idxmax() devolve?', op: ['O rótulo (nome) do maior valor', 'O maior valor', 'A posição numérica do maior valor'], a: 0 },
          { t: 'ordenar', q: 'Monte o código que mostra quantos itens foram vendidos em março.', linhas: ['df["data"] = pd.to_datetime(df["data"])', 'marco = df[df["data"].dt.month == 3]', 'print(marco["quantidade"].sum())'] }
        ],
        desafios: [
          { titulo: 'Indicadores do semestre',
            cenario: 'Calcule os indicadores para o painel do semestre a partir de <code>vendas_2026.csv</code>: crie a coluna <code>faturamento</code> em <code>df</code> (quantidade × preço); guarde <code>fat_total</code> (soma) e <code>ticket_medio</code> (média do faturamento por pedido), ambos arredondados com 2 casas; <code>vendedor_mais_pedidos</code> (quem tem mais pedidos) e <code>fat_junho</code> (faturamento de junho, 2 casas).',
            arquivos: { 'vendas_2026.csv': PY_ARQ['vendas_2026.csv'] },
            inicial: 'import pandas as pd\n\ndf = pd.read_csv("vendas_2026.csv")\n\nfat_total = 0\nticket_medio = 0\nvendedor_mais_pedidos = ""\nfat_junho = 0\n\nprint(fat_total, ticket_medio, vendedor_mais_pedidos, fat_junho)\n',
            testes: [
              { py: 'assert "faturamento" in df.columns and abs((df["faturamento"] - df["quantidade"] * df["preco_unit"]).abs().max()) < 0.001', msg: 'coluna faturamento criada' },
              { py: 'import pandas as pd\n_e = pd.read_csv("vendas_2026.csv")\n_f = _e["quantidade"] * _e["preco_unit"]\nassert abs(fat_total - round(_f.sum(), 2)) < 0.01 and abs(ticket_medio - round(_f.mean(), 2)) < 0.01', msg: 'fat_total e ticket_medio corretos' },
              { py: 'import pandas as pd\n_e = pd.read_csv("vendas_2026.csv")\nassert vendedor_mais_pedidos == _e["vendedor"].value_counts().idxmax()', msg: 'vendedor_mais_pedidos correto' },
              { py: 'import pandas as pd\n_e = pd.read_csv("vendas_2026.csv")\n_j = _e[pd.to_datetime(_e["data"]).dt.month == 6]\nassert abs(fat_junho - round((_j["quantidade"] * _j["preco_unit"]).sum(), 2)) < 0.01', msg: 'fat_junho correto' }
            ],
            dicas: ['df["faturamento"] = df["quantidade"] * df["preco_unit"]; depois round(df["faturamento"].sum(), 2) e round(df["faturamento"].mean(), 2).', 'O vendedor com mais pedidos: df["vendedor"].value_counts().idxmax().', 'Para junho: converta a data com pd.to_datetime e filtre df[df["data"].dt.month == 6].'],
            solucao: 'import pandas as pd\n\ndf = pd.read_csv("vendas_2026.csv")\ndf["faturamento"] = df["quantidade"] * df["preco_unit"]\ndf["data"] = pd.to_datetime(df["data"])\n\nfat_total = round(df["faturamento"].sum(), 2)\nticket_medio = round(df["faturamento"].mean(), 2)\nvendedor_mais_pedidos = df["vendedor"].value_counts().idxmax()\nfat_junho = round(df[df["data"].dt.month == 6]["faturamento"].sum(), 2)\n\nprint(fat_total, ticket_medio, vendedor_mais_pedidos, fat_junho)' }
        ]
      },
      {
        id: 'py-pandas-projeto', title: 'Projeto: relatório de pedidos grandes',
        desc: 'Juntar tudo do módulo — leitura, coluna calculada, filtro, ordenação e percentual — e exportar o resultado com to_csv.',
        objetivos: [
          'Responder perguntas de negócio combinando filtros e cálculos',
          'Calcular percentuais sobre a base',
          'Exportar um DataFrame para CSV com to_csv(index=False)'
        ],
        body: 'O comercial quer acompanhar de perto os pedidos grandes, aqueles que pesam no faturamento. Você vai identificar esses pedidos, medir quanto eles representam e entregar a lista num arquivo — o mesmo fluxo que você vai repetir em qualquer análise com pandas.',
        content: [
          { h: 'Percentuais',
            p: 'A média de uma condição True/False é o percentual de True: <code>(df["faturamento"] >= 3000).mean()</code> dá a fração de pedidos grandes.',
            code: 'import pandas as pd\n\ndf = pd.read_csv("vendas_2026.csv")\ndf["faturamento"] = df["quantidade"] * df["preco_unit"]\npct = (df["faturamento"] >= 3000).mean() * 100\nprint(f"{pct:.1f}% dos pedidos têm R$ 3.000 ou mais")' },
          { h: 'A linha do maior valor',
            items: [
              '<code>df["faturamento"].idxmax()</code> devolve o índice (número da linha) do maior faturamento.',
              '<code>df.loc[indice]</code> busca a linha inteira por esse índice; <code>df.loc[indice, "pedido"]</code> busca uma célula.'
            ],
            code: 'import pandas as pd\n\ndf = pd.read_csv("vendas_2026.csv")\ndf["faturamento"] = df["quantidade"] * df["preco_unit"]\ni = df["faturamento"].idxmax()\nprint(df.loc[i])\nprint("Maior pedido:", df.loc[i, "pedido"])' },
          { h: 'Exportando com to_csv',
            items: [
              '<code>df.to_csv("arquivo.csv", index=False)</code> grava o DataFrame — <code>index=False</code> evita uma coluna extra com os números das linhas.',
              'Para o Excel brasileiro: <code>sep=";"</code>, <code>decimal=","</code> e <code>encoding="utf-8-sig"</code>.'
            ],
            code: 'import pandas as pd\n\ndf = pd.read_csv("vendas_2026.csv")\ndf.head(10).to_csv("amostra.csv", index=False, sep=";", decimal=",", encoding="utf-8-sig")\nprint(open("amostra.csv", encoding="utf-8-sig").read()[:300])' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que (df["faturamento"] >= 3000).mean() calcula?', op: ['A fração de pedidos com faturamento de 3000 ou mais', 'A média dos pedidos acima de 3000', 'Quantos pedidos passam de 3000'], a: 0, exp: 'True vale 1 e False vale 0; a média dessa coluna é a proporção de True.' },
          { t: 'escolha', q: 'Para que serve index=False no to_csv?', op: ['Não gravar a coluna com os números das linhas', 'Gravar sem cabeçalho', 'Gravar sem ordenar'], a: 0 },
          { t: 'lacuna', codigo: true, frase: 'df.to_csv("relatorio.csv", index=False, sep=";", decimal=___)', op: ['","', '"."', '";"'], a: 0, pt: 'Grave os números com vírgula decimal para o Excel brasileiro.' },
          { t: 'escolha', q: 'O que df.loc[i, "pedido"] retorna?', op: ['O valor da coluna pedido na linha de índice i', 'A coluna pedido inteira', 'As primeiras i linhas'], a: 0 },
          { t: 'ordenar', q: 'Monte o código que exporta os pedidos de Notebooks.', linhas: ['df = pd.read_csv("vendas_2026.csv")', 'notebooks = df[df["categoria"] == "Notebooks"]', 'notebooks.to_csv("notebooks.csv", index=False)'] }
        ],
        desafios: [
          { titulo: 'Pedidos grandes do semestre',
            cenario: 'Para o comercial, a partir de <code>vendas_2026.csv</code>:<br>1) <code>pct_grandes</code>: percentual de pedidos com faturamento (quantidade × preço) de <strong>R$ 3.000 ou mais</strong>, de 0 a 100, arredondado com 1 casa;<br>2) <code>maior_pedido</code>: o código (coluna <code>pedido</code>) do pedido de maior faturamento;<br>3) grave <code>pedidos_grandes.csv</code> só com esses pedidos de R$ 3.000 ou mais, colunas <code>pedido</code>, <code>data</code>, <code>vendedor</code>, <code>produto</code> e <code>faturamento</code>, do maior para o menor faturamento, sem a coluna de índice.',
            arquivos: { 'vendas_2026.csv': PY_ARQ['vendas_2026.csv'] },
            inicial: 'import pandas as pd\n\ndf = pd.read_csv("vendas_2026.csv")\n\npct_grandes = 0\nmaior_pedido = ""\n\n# grave pedidos_grandes.csv\n\nprint(pct_grandes, maior_pedido)\n',
            testes: [
              { py: 'import pandas as pd\n_e = pd.read_csv("vendas_2026.csv")\n_f = _e["quantidade"] * _e["preco_unit"]\nassert abs(pct_grandes - round((_f >= 3000).mean() * 100, 1)) < 0.05', msg: 'pct_grandes correto' },
              { py: 'import pandas as pd\n_e = pd.read_csv("vendas_2026.csv")\n_f = _e["quantidade"] * _e["preco_unit"]\nassert maior_pedido == _e.loc[_f.idxmax(), "pedido"]', msg: 'maior_pedido correto' },
              { py: 'import pandas as pd\n_g = pd.read_csv("pedidos_grandes.csv")\nassert list(_g.columns) == ["pedido", "data", "vendedor", "produto", "faturamento"]', msg: 'pedidos_grandes.csv gravado com as colunas pedidas (sem índice)' },
              { py: 'import pandas as pd\n_e = pd.read_csv("vendas_2026.csv")\n_f = _e["quantidade"] * _e["preco_unit"]\n_g = pd.read_csv("pedidos_grandes.csv")\nassert set(_g["pedido"]) == set(_e[_f >= 3000]["pedido"]) and list(_g["faturamento"]) == sorted(_g["faturamento"], reverse=True)', msg: 'só os pedidos grandes, do maior para o menor' }
            ],
            dicas: ['Crie df["faturamento"] primeiro. O percentual: round((df["faturamento"] >= 3000).mean() * 100, 1).', 'maior_pedido = df.loc[df["faturamento"].idxmax(), "pedido"].', 'grandes = df[df["faturamento"] >= 3000][[...colunas...]].sort_values("faturamento", ascending=False) e depois grandes.to_csv("pedidos_grandes.csv", index=False).'],
            solucao: 'import pandas as pd\n\ndf = pd.read_csv("vendas_2026.csv")\ndf["faturamento"] = df["quantidade"] * df["preco_unit"]\n\npct_grandes = round((df["faturamento"] >= 3000).mean() * 100, 1)\nmaior_pedido = df.loc[df["faturamento"].idxmax(), "pedido"]\n\ngrandes = df[df["faturamento"] >= 3000][["pedido", "data", "vendedor", "produto", "faturamento"]]\ngrandes = grandes.sort_values("faturamento", ascending=False)\ngrandes.to_csv("pedidos_grandes.csv", index=False)\n\nprint(pct_grandes, maior_pedido)\nprint(grandes.head())' }
        ]
      }
    ]
  }
  ,
  {
    id: 'py-m10', title: 'Módulo 10 · pandas II: limpeza e tratamento de dados', kind: 'video',
    lessons: [
      {
        id: 'py-limpeza-diagnostico', title: 'Diagnóstico: vazios e duplicados',
        desc: 'Encontrar células vazias e linhas duplicadas, decidir o que fazer com elas e medir a base antes e depois da limpeza.',
        objetivos: [
          'Contar valores vazios com isna().sum()',
          'Encontrar e remover duplicados com duplicated e drop_duplicates',
          'Remover ou preencher vazios com dropna e fillna'
        ],
        body: 'Base de dados real chega suja: pedido exportado duas vezes, quantidade em branco, texto com espaço sobrando. Se você soma sem olhar, o relatório sai errado e ninguém percebe. O primeiro passo de toda análise é o diagnóstico — e o pandas faz isso em poucas linhas.',
        content: [
          { h: 'A base suja',
            p: 'O arquivo <code>vendas_sujas.csv</code> é a exportação de abril do sistema antigo: datas no formato brasileiro, preços como texto ("R$ 799,00"), regiões com espaços e maiúsculas, linhas duplicadas e quantidades em branco. Veja:',
            code: 'import pandas as pd\n\ndf = pd.read_csv("vendas_sujas.csv")\nprint(df.head(8))\nprint(df.dtypes)' },
          { h: 'Valores vazios',
            items: [
              'Célula vazia no CSV vira <code>NaN</code> ("not a number") no pandas.',
              '<code>df.isna().sum()</code> conta os vazios de cada coluna.',
              '<code>df["quantidade"].isna()</code> marca True nas linhas com quantidade vazia — dá para usar como filtro.'
            ],
            code: 'import pandas as pd\n\ndf = pd.read_csv("vendas_sujas.csv")\nprint(df.isna().sum())\nprint(df[df["quantidade"].isna()][["pedido", "produto", "quantidade"]])' },
          { h: 'Duplicados',
            items: [
              '<code>df.duplicated()</code> marca True nas linhas que repetem uma linha anterior (todas as colunas iguais).',
              '<code>df.duplicated().sum()</code> conta quantas são.',
              '<code>df.drop_duplicates()</code> devolve a tabela sem elas — guarde o resultado numa variável.'
            ],
            code: 'import pandas as pd\n\ndf = pd.read_csv("vendas_sujas.csv")\nprint("Duplicadas:", df.duplicated().sum())\nsem_dup = df.drop_duplicates()\nprint(len(df), "->", len(sem_dup))' },
          { h: 'Remover ou preencher?',
            items: [
              '<code>df.dropna(subset=["quantidade"])</code> remove as linhas sem quantidade.',
              '<code>df["quantidade"].fillna(1)</code> preenche os vazios com 1.',
              'A decisão é de negócio, não técnica: pergunte a quem conhece o processo e deixe a regra escrita no código.'
            ] }
        ],
        pratica: [
          { t: 'escolha', q: 'Como uma célula vazia do CSV aparece no pandas?', op: ['NaN', '0', '""'], a: 0 },
          { t: 'escolha', q: 'O que df.isna().sum() mostra?', op: ['Quantos vazios existem em cada coluna', 'O total da tabela', 'Quantas linhas estão completas'], a: 0 },
          { t: 'lacuna', codigo: true, frase: 'df = df.___()', op: ['drop_duplicates', 'duplicated', 'unique'], a: 0, pt: 'Remova as linhas repetidas.' },
          { t: 'escolha', q: 'Qual o problema deste código?', codigo: 'df.drop_duplicates()\nprint(len(df))', op: ['O resultado não foi guardado: df continua com os duplicados', 'drop_duplicates não existe', 'len não funciona com DataFrame'], a: 0, exp: 'A maioria dos métodos do pandas devolve uma tabela nova. Use df = df.drop_duplicates().' },
          { t: 'lacuna', codigo: true, frase: 'df = df.dropna(subset=[___])', op: ['"quantidade"', 'quantidade', '0'], a: 0, pt: 'Remova só as linhas sem quantidade.' },
          { t: 'pares', pares: [['isna()', 'marca os vazios'], ['duplicated()', 'marca as repetidas'], ['dropna()', 'remove linhas com vazio'], ['fillna(1)', 'preenche vazios com 1']] }
        ],
        desafios: [
          { titulo: 'Quanto da base está comprometida?',
            cenario: 'Antes de usar <code>vendas_sujas.csv</code>, o gestor quer saber o tamanho do problema. Leia o arquivo e preencha: <code>linhas_total</code> (linhas lidas), <code>duplicadas</code> (linhas repetidas), <code>sem_quantidade</code> (linhas com quantidade vazia, <strong>contadas depois de remover as duplicadas</strong>) e <code>limpo</code>: o DataFrame sem duplicadas e sem as linhas com quantidade vazia.',
            arquivos: { 'vendas_sujas.csv': PY_ARQ['vendas_sujas.csv'] },
            inicial: 'import pandas as pd\n\ndf = pd.read_csv("vendas_sujas.csv")\n\nlinhas_total = 0\nduplicadas = 0\nsem_quantidade = 0\nlimpo = df\n\nprint(linhas_total, duplicadas, sem_quantidade, len(limpo))\n',
            testes: [
              { py: 'import pandas as pd\n_e = pd.read_csv("vendas_sujas.csv")\nassert linhas_total == len(_e) and duplicadas == _e.duplicated().sum()', msg: 'linhas_total e duplicadas corretos' },
              { py: 'import pandas as pd\n_e = pd.read_csv("vendas_sujas.csv").drop_duplicates()\nassert sem_quantidade == _e["quantidade"].isna().sum()', msg: 'sem_quantidade correto (contado sem as duplicadas)' },
              { py: 'import pandas as pd\n_e = pd.read_csv("vendas_sujas.csv").drop_duplicates().dropna(subset=["quantidade"])\nassert len(limpo) == len(_e) and not limpo.duplicated().any() and limpo["quantidade"].notna().all()', msg: 'limpo sem duplicadas e sem quantidade vazia' }
            ],
            dicas: ['linhas_total = len(df) e duplicadas = df.duplicated().sum().', 'Remova as duplicadas primeiro: sem_dup = df.drop_duplicates(); depois sem_dup["quantidade"].isna().sum().', 'limpo = sem_dup.dropna(subset=["quantidade"]).'],
            solucao: 'import pandas as pd\n\ndf = pd.read_csv("vendas_sujas.csv")\n\nlinhas_total = len(df)\nduplicadas = df.duplicated().sum()\nsem_dup = df.drop_duplicates()\nsem_quantidade = sem_dup["quantidade"].isna().sum()\nlimpo = sem_dup.dropna(subset=["quantidade"])\n\nprint(linhas_total, duplicadas, sem_quantidade, len(limpo))' }
        ]
      },
      {
        id: 'py-limpeza-texto', title: 'Padronizando textos e convertendo preços',
        desc: 'Os métodos .str do pandas: tirar espaços, padronizar maiúsculas e transformar "R$ 1.299,90" em número.',
        objetivos: [
          'Padronizar texto com .str.strip() e .str.title()',
          'Trocar trechos de texto com .str.replace',
          'Converter a coluna limpa em número com astype(float)'
        ],
        body: 'Para o computador, "Sudeste", "sudeste" e "  SUDESTE " são três regiões diferentes — e o seu total por região sai partido em três. Preço com "R$" e vírgula não é número, então não soma. Nesta aula você padroniza as colunas de texto da base inteira de uma vez.',
        content: [
          { h: 'O acessor .str',
            items: [
              'Os métodos de texto que você conhece (strip, upper, title, replace) existem para a coluna inteira com <code>.str</code> na frente.',
              '<code>df["regiao"].str.strip()</code> tira os espaços das pontas de todas as linhas.',
              '<code>.str.title()</code> deixa a primeira letra de cada palavra maiúscula: "CENTRO-OESTE" vira "Centro-Oeste".'
            ],
            code: 'import pandas as pd\n\ndf = pd.read_csv("vendas_sujas.csv")\nprint("Antes:", df["regiao"].unique())\ndf["regiao"] = df["regiao"].str.strip().str.title()\nprint("Depois:", df["regiao"].unique())' },
          { h: 'Preço em texto vira número',
            p: 'Encadeie as trocas: tirar o "R$", tirar espaços, trocar a vírgula por ponto — e então converter com <code>astype(float)</code>.',
            code: 'import pandas as pd\n\ndf = pd.read_csv("vendas_sujas.csv")\nprint(df["preco_unit"].head(6).tolist())\npreco = (df["preco_unit"].str.replace("R$", "")\n                         .str.strip()\n                         .str.replace(",", "."))\ndf["preco_unit"] = preco.astype(float)\nprint(df["preco_unit"].head(6).tolist())\nprint(df["preco_unit"].dtype)' },
          { h: 'Cuidado com o separador de milhar',
            items: [
              'Se aparecer "1.299,90", tire o ponto <strong>antes</strong> de trocar a vírgula: <code>.str.replace(".", "").str.replace(",", ".")</code>.',
              'Mas atenção: num valor já no formato "799.0", tirar o ponto estraga o número. Olhe os dados (<code>unique()</code>) antes de escolher as trocas.',
              'Se o <code>astype(float)</code> der ValueError, a mensagem mostra o texto que não pôde ser convertido — é a pista do que falta limpar.'
            ] }
        ],
        pratica: [
          { t: 'escolha', q: 'Por que "Sul" e " sul" aparecem como valores diferentes?', op: ['Espaço e maiúsculas tornam os textos diferentes para o computador', 'É um erro do pandas', 'Porque a coluna é numérica'], a: 0 },
          { t: 'lacuna', codigo: true, frase: 'df["regiao"] = df["regiao"].___.strip()', op: ['str', 'text', 'dt'], a: 0, pt: 'Tire os espaços das pontas em todas as linhas da coluna.' },
          { t: 'escolha', q: 'Qual o resultado de "CENTRO-OESTE".title()?', op: ['Centro-Oeste', 'Centro-oeste', 'CENTRO-OESTE'], a: 0 },
          { t: 'escolha', q: 'O que falta para converter "R$ 49,90" em número?', codigo: 'texto.replace("R$", "").strip()', op: ['Trocar a vírgula por ponto', 'Nada, já é número', 'Tirar o 9 final'], a: 0 },
          { t: 'lacuna', codigo: true, frase: 'df["preco_unit"] = preco.___(float)', op: ['astype', 'convert', 'to'], a: 0, pt: 'Converta a coluna de texto já limpa em número decimal.' },
          { t: 'ordenar', q: 'Monte a limpeza da coluna de preço.', linhas: ['preco = df["preco_unit"].str.replace("R$", "")', 'preco = preco.str.strip().str.replace(",", ".")', 'df["preco_unit"] = preco.astype(float)'] }
        ],
        desafios: [
          { titulo: 'Padronize regiões, vendedores e preços',
            cenario: 'Na <code>vendas_sujas.csv</code>, deixe <code>df</code> com: <code>regiao</code> e <code>vendedor</code> sem espaços nas pontas e com a primeira letra de cada palavra maiúscula ("Centro-Oeste", "Fábio"); e <code>preco_unit</code> como número (float). Depois guarde em <code>regioes</code> a lista ordenada das regiões distintas e em <code>preco_medio</code> a média de <code>preco_unit</code>, arredondada com 2 casas.',
            arquivos: { 'vendas_sujas.csv': PY_ARQ['vendas_sujas.csv'] },
            inicial: 'import pandas as pd\n\ndf = pd.read_csv("vendas_sujas.csv")\n\n# padronize regiao e vendedor\n# converta preco_unit em número\n\nregioes = sorted(df["regiao"].unique())\npreco_medio = 0\nprint(regioes)\nprint(preco_medio)\n',
            testes: [
              { py: 'assert set(df["regiao"]) == {"Centro-Oeste", "Sudeste", "Nordeste", "Sul", "Norte"} & set(df["regiao"]) and all(r == r.strip().title() for r in df["regiao"])', msg: 'regiao padronizada' },
              { py: 'assert all(v == v.strip().title() for v in df["vendedor"])', msg: 'vendedor padronizado' },
              { py: 'import pandas as pd\nassert pd.api.types.is_float_dtype(df["preco_unit"])', msg: 'preco_unit numérico' },
              { py: 'import pandas as pd\n_e = pd.read_csv("vendas_sujas.csv")\n_p = _e["preco_unit"].str.replace("R$", "").str.strip().str.replace(",", ".").astype(float)\nassert abs(preco_medio - round(_p.mean(), 2)) < 0.01 and regioes == sorted(_e["regiao"].str.strip().str.title().unique())', msg: 'regioes e preco_medio corretos' }
            ],
            dicas: ['df["regiao"] = df["regiao"].str.strip().str.title() — e o mesmo para vendedor.', 'Preço: .str.replace("R$", ""), depois .str.strip() e .str.replace(",", "."). Termine com .astype(float).', 'Calcule regioes e preco_medio só depois de limpar: round(df["preco_unit"].mean(), 2).'],
            solucao: 'import pandas as pd\n\ndf = pd.read_csv("vendas_sujas.csv")\n\ndf["regiao"] = df["regiao"].str.strip().str.title()\ndf["vendedor"] = df["vendedor"].str.strip().str.title()\npreco = df["preco_unit"].str.replace("R$", "").str.strip().str.replace(",", ".")\ndf["preco_unit"] = preco.astype(float)\n\nregioes = sorted(df["regiao"].unique())\npreco_medio = round(df["preco_unit"].mean(), 2)\nprint(regioes)\nprint(preco_medio)' }
        ]
      },
      {
        id: 'py-limpeza-datas', title: 'Datas brasileiras, tipos e regras de preenchimento',
        desc: 'Converter "15/04/2026" em data com o formato certo, preencher vazios por regra de negócio e acertar o tipo das colunas.',
        objetivos: [
          'Converter datas dia/mês/ano com pd.to_datetime e format',
          'Preencher vazios com fillna seguindo uma regra definida',
          'Ajustar tipos com astype(int) e renomear colunas com rename'
        ],
        body: 'A data "03/04/2026" é 3 de abril ou 4 de março? Para o pandas, sem instrução, pode ser qualquer um — e o erro passa despercebido. Nesta aula você diz exatamente o formato da data, aplica as regras do negócio para os vazios e deixa cada coluna com o tipo certo.',
        content: [
          { h: 'Datas com formato explícito',
            items: [
              '<code>pd.to_datetime(df["data"], format="%d/%m/%Y")</code>: <code>%d</code> dia, <code>%m</code> mês, <code>%Y</code> ano com 4 dígitos.',
              'Com o formato informado, não há ambiguidade entre dia e mês.',
              'Depois da conversão, <code>.dt.day</code>, <code>.dt.month</code> e <code>.dt.day_name()</code> funcionam.'
            ],
            code: 'import pandas as pd\n\ndf = pd.read_csv("vendas_sujas.csv")\ndf["data"] = pd.to_datetime(df["data"], format="%d/%m/%Y")\nprint(df["data"].head())\nprint(df["data"].dt.day.head().tolist())' },
          { h: 'Preenchendo por regra',
            p: 'O comercial informou: quando a quantidade vem vazia, o pedido foi de <strong>1 unidade</strong>. Depois de preencher, a coluna pode virar inteiro:',
            code: 'import pandas as pd\n\ndf = pd.read_csv("vendas_sujas.csv")\nprint(df["quantidade"].dtype, "| vazios:", df["quantidade"].isna().sum())\ndf["quantidade"] = df["quantidade"].fillna(1).astype(int)\nprint(df["quantidade"].dtype, "| vazios:", df["quantidade"].isna().sum())' },
          { h: 'Renomeando colunas',
            items: [
              '<code>df.rename(columns={"preco_unit": "preco"})</code> troca nomes de colunas — guarde o resultado.',
              'Por que <code>quantidade</code> era <code>float64</code>? Uma coluna de inteiros com NaN vira decimal, porque NaN é um valor decimal.'
            ],
            code: 'import pandas as pd\n\ndf = pd.read_csv("vendas_sujas.csv")\ndf = df.rename(columns={"preco_unit": "preco", "regiao": "região"})\nprint(list(df.columns))' }
        ],
        pratica: [
          { t: 'lacuna', codigo: true, frase: 'pd.to_datetime(df["data"], format="___")', op: ['%d/%m/%Y', '%m/%d/%Y', '%Y-%m-%d'], a: 0, pt: 'Converta datas no formato 15/04/2026.' },
          { t: 'escolha', q: 'Por que uma coluna de quantidades inteiras aparece como float64?', op: ['Porque tem valores vazios (NaN)', 'Porque o CSV só guarda decimais', 'É um erro na leitura'], a: 0 },
          { t: 'escolha', q: 'O que acontece?', codigo: 'df["quantidade"].astype(int)  # a coluna ainda tem NaN', op: ['Dá erro: NaN não pode virar inteiro', 'Os NaN viram 0', 'Os NaN são removidos'], a: 0, exp: 'Preencha (fillna) ou remova (dropna) os vazios antes do astype(int).' },
          { t: 'lacuna', codigo: true, frase: 'df = df.rename(___={"preco_unit": "preco"})', op: ['columns', 'names', 'index'], a: 0, pt: 'Renomeie a coluna preco_unit.' },
          { t: 'escolha', q: 'Quem deve decidir se a quantidade vazia vira 1 ou se a linha é removida?', op: ['A área de negócio que conhece o processo', 'O pandas, automaticamente', 'Tanto faz, o resultado é o mesmo'], a: 0 },
          { t: 'ordenar', q: 'Monte o tratamento da quantidade.', linhas: ['df["quantidade"] = df["quantidade"].fillna(1)', 'df["quantidade"] = df["quantidade"].astype(int)', 'print(df["quantidade"].sum())'] }
        ],
        desafios: [
          { titulo: 'Datas e quantidades corretas',
            cenario: 'Em <code>vendas_sujas.csv</code>: converta <code>data</code> (formato dia/mês/ano) em data de verdade; aplique a regra do comercial (quantidade vazia = 1 unidade) e deixe <code>quantidade</code> como inteiro. Depois guarde <code>itens_total</code> (soma das quantidades) e <code>dia_mais_pedidos</code>: o <strong>dia do mês</strong> (número de 1 a 31) com mais linhas na base.',
            arquivos: { 'vendas_sujas.csv': PY_ARQ['vendas_sujas.csv'] },
            inicial: 'import pandas as pd\n\ndf = pd.read_csv("vendas_sujas.csv")\n\n# converta a data e trate a quantidade\n\nitens_total = 0\ndia_mais_pedidos = 0\nprint(itens_total, dia_mais_pedidos)\n',
            testes: [
              { py: 'import pandas as pd\nassert pd.api.types.is_datetime64_any_dtype(df["data"]) and df["data"].dt.month.eq(4).all()', msg: 'data convertida (dia/mês/ano)' },
              { py: 'import pandas as pd\nassert pd.api.types.is_integer_dtype(df["quantidade"]) and len(df) == len(pd.read_csv("vendas_sujas.csv"))', msg: 'quantidade inteira, sem perder linhas' },
              { py: 'import pandas as pd\n_e = pd.read_csv("vendas_sujas.csv")\nassert itens_total == int(_e["quantidade"].fillna(1).sum())', msg: 'itens_total correto' },
              { py: 'import pandas as pd\n_e = pd.read_csv("vendas_sujas.csv")\nassert int(dia_mais_pedidos) == pd.to_datetime(_e["data"], format="%d/%m/%Y").dt.day.value_counts().idxmax()', msg: 'dia_mais_pedidos correto' }
            ],
            dicas: ['df["data"] = pd.to_datetime(df["data"], format="%d/%m/%Y").', 'df["quantidade"] = df["quantidade"].fillna(1).astype(int); depois itens_total = df["quantidade"].sum().', 'O dia com mais linhas: df["data"].dt.day.value_counts().idxmax().'],
            solucao: 'import pandas as pd\n\ndf = pd.read_csv("vendas_sujas.csv")\n\ndf["data"] = pd.to_datetime(df["data"], format="%d/%m/%Y")\ndf["quantidade"] = df["quantidade"].fillna(1).astype(int)\n\nitens_total = df["quantidade"].sum()\ndia_mais_pedidos = df["data"].dt.day.value_counts().idxmax()\nprint(itens_total, dia_mais_pedidos)' }
        ]
      },
      {
        id: 'py-limpeza-projeto', title: 'Projeto: a função de limpeza reutilizável',
        desc: 'Juntar todos os tratamentos numa função limpar(df) — a mesma limpeza aplicada a cada nova exportação, sem refazer nada à mão.',
        objetivos: [
          'Organizar a limpeza numa função que recebe e devolve um DataFrame',
          'Validar o resultado com assert antes de usar',
          'Exportar a base limpa e calcular os indicadores'
        ],
        body: 'No mês que vem chega outra exportação com os mesmos defeitos. Em vez de repetir a limpeza no Excel, você escreve uma vez a função limpar(df) e ela vale para todos os meses. Junte as funções do Módulo 06 com o pandas e você tem um pipeline de dados de verdade.',
        content: [
          { h: 'A limpeza numa função',
            p: 'A função recebe a tabela crua e devolve a tabela tratada. O <code>.copy()</code> no início evita alterar a tabela original por engano.',
            code: 'import pandas as pd\n\ndef limpar_regiao(df):\n    df = df.copy()\n    df["regiao"] = df["regiao"].str.strip().str.title()\n    return df\n\ncru = pd.read_csv("vendas_sujas.csv")\ntratado = limpar_regiao(cru)\nprint(cru["regiao"].nunique(), "->", tratado["regiao"].nunique(), "regiões")' },
          { h: 'Validando com assert',
            items: [
              '<code>assert condicao, "mensagem"</code> interrompe o programa se a condição for falsa.',
              'Coloque no fim da limpeza as regras que a base limpa precisa cumprir: sem duplicados, sem vazios, preço positivo.',
              'Se uma exportação nova vier com um defeito diferente, o assert avisa na hora — em vez de um relatório errado chegar à diretoria.'
            ],
            code: 'import pandas as pd\n\ndf = pd.read_csv("vendas_sujas.csv").drop_duplicates()\nassert not df.duplicated().any(), "ainda há duplicados"\nprint("Validação ok:", len(df), "linhas")' }
        ],
        pratica: [
          { t: 'escolha', q: 'Por que colocar a limpeza numa função?', op: ['Para aplicar a mesma limpeza a cada nova exportação sem refazer', 'Porque o pandas exige funções', 'Para o código rodar mais rápido'], a: 0 },
          { t: 'escolha', q: 'Para que serve df = df.copy() no início da função?', op: ['Não alterar por engano a tabela original de quem chamou a função', 'Duplicar as linhas', 'Salvar a tabela num arquivo'], a: 0 },
          { t: 'lacuna', codigo: true, frase: '___ df["preco_unit"].gt(0).all(), "preço inválido"', op: ['assert', 'if', 'check'], a: 0, pt: 'Interrompa o programa se houver preço menor ou igual a zero.' },
          { t: 'escolha', q: 'O que acontece quando a condição do assert é falsa?', op: ['O programa para com AssertionError e a mensagem', 'O assert corrige os dados', 'Nada, só aparece um aviso'], a: 0 },
          { t: 'ordenar', q: 'Monte a função de limpeza.', linhas: ['def limpar(df):', '    df = df.drop_duplicates()', '    return df', 'base = limpar(pd.read_csv("vendas_sujas.csv"))'] }
        ],
        desafios: [
          { titulo: 'Pipeline de limpeza de abril',
            cenario: 'Escreva a função <code>limpar(df)</code> que recebe o DataFrame cru de <code>vendas_sujas.csv</code> e devolve a base tratada: sem duplicadas; <code>data</code> como data (dia/mês/ano); <code>regiao</code> e <code>vendedor</code> padronizados (sem espaços, iniciais maiúsculas); <code>preco_unit</code> numérico; <code>quantidade</code> vazia = 1, como inteiro; e uma coluna nova <code>faturamento</code> (quantidade × preço). Depois: <code>base = limpar(pd.read_csv("vendas_sujas.csv"))</code>, grave <code>vendas_abril_limpo.csv</code> (sem índice) e guarde <code>fat_abril</code> (soma do faturamento, 2 casas).',
            arquivos: { 'vendas_sujas.csv': PY_ARQ['vendas_sujas.csv'] },
            inicial: 'import pandas as pd\n\ndef limpar(df):\n    df = df.copy()\n    # 1) duplicadas  2) data  3) regiao e vendedor  4) preco_unit  5) quantidade  6) faturamento\n    return df\n\nbase = limpar(pd.read_csv("vendas_sujas.csv"))\nfat_abril = 0\n\n# grave vendas_abril_limpo.csv\nprint(len(base), fat_abril)\n',
            testes: [
              { py: 'import pandas as pd\n_b = limpar(pd.read_csv("vendas_sujas.csv"))\nassert not _b.duplicated().any() and len(_b) == len(pd.read_csv("vendas_sujas.csv").drop_duplicates())', msg: 'limpar remove as duplicadas (e só elas)' },
              { py: 'import pandas as pd\n_b = limpar(pd.read_csv("vendas_sujas.csv"))\nassert pd.api.types.is_datetime64_any_dtype(_b["data"]) and _b["data"].dt.month.eq(4).all() and all(x == x.strip().title() for x in list(_b["regiao"]) + list(_b["vendedor"]))', msg: 'datas e textos tratados' },
              { py: 'import pandas as pd\n_b = limpar(pd.read_csv("vendas_sujas.csv"))\nassert pd.api.types.is_integer_dtype(_b["quantidade"]) and pd.api.types.is_float_dtype(_b["preco_unit"]) and ((_b["faturamento"] - _b["quantidade"] * _b["preco_unit"]).abs() < 0.001).all()', msg: 'quantidade, preco_unit e faturamento corretos' },
              { py: 'import pandas as pd\n_e = pd.read_csv("vendas_sujas.csv").drop_duplicates()\n_f = (_e["quantidade"].fillna(1) * _e["preco_unit"].str.replace("R$", "").str.strip().str.replace(",", ".").astype(float)).sum()\nassert abs(fat_abril - round(_f, 2)) < 0.01', msg: 'fat_abril correto' },
              { py: 'import pandas as pd\n_g = pd.read_csv("vendas_abril_limpo.csv")\nassert "faturamento" in _g.columns and len(_g) == len(pd.read_csv("vendas_sujas.csv").drop_duplicates()) and not any(c.startswith("Unnamed") for c in _g.columns)', msg: 'vendas_abril_limpo.csv gravado sem a coluna de índice' }
            ],
            dicas: ['Dentro da função, um passo por linha, sempre guardando: df = df.drop_duplicates(); df["data"] = pd.to_datetime(df["data"], format="%d/%m/%Y")...', 'Preço: df["preco_unit"].str.replace("R$", "").str.strip().str.replace(",", ".").astype(float). Quantidade: .fillna(1).astype(int).', 'Fora da função: fat_abril = round(base["faturamento"].sum(), 2) e base.to_csv("vendas_abril_limpo.csv", index=False).'],
            solucao: 'import pandas as pd\n\ndef limpar(df):\n    df = df.copy()\n    df = df.drop_duplicates()\n    df["data"] = pd.to_datetime(df["data"], format="%d/%m/%Y")\n    df["regiao"] = df["regiao"].str.strip().str.title()\n    df["vendedor"] = df["vendedor"].str.strip().str.title()\n    preco = df["preco_unit"].str.replace("R$", "").str.strip().str.replace(",", ".")\n    df["preco_unit"] = preco.astype(float)\n    df["quantidade"] = df["quantidade"].fillna(1).astype(int)\n    df["faturamento"] = df["quantidade"] * df["preco_unit"]\n    return df\n\nbase = limpar(pd.read_csv("vendas_sujas.csv"))\nfat_abril = round(base["faturamento"].sum(), 2)\n\nbase.to_csv("vendas_abril_limpo.csv", index=False)\nprint(len(base), fat_abril)' }
        ]
      }
    ]
  }
];
