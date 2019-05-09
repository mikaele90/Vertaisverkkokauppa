# REST API

Esimerkkejä:

Hae kaikki itemit:
- http://localhost/Vertaisverkkokauppa/Vertaisverkkokauppa/api/item/read.php

Hae yksittäinen itemi itemid:n perusteella:
- http://localhost/Vertaisverkkokauppa/Vertaisverkkokauppa/api/item/read_one.php?itemid=2

Admin tools (GUI), jossa voi tehdä joko readin tai createn (ei autentikointia ainakaan vielä):
- http://localhost/Vertaisverkkokauppa/Vertaisverkkokauppa/api/admtools/get-create.html
- Postin voi myös toki tehdä ns. pelkällä jsonilla esim. Postman-ohjelmassa.