# Form per traballò
## Note
- il percorso del submit deve essere relativo e deve specificare il file PHP (ho provato a mettere una cartella con l'index ma non funziona, quindi rimarrà <code>axios.postForm("../submit.php", ...)</code>
- `/index/form -> /front/build` per avere tutti i file dentro `/index`

## TODO
- finire sistema di application \[V]
- login ~~con keycloak/microsoft~~ per dare accesso alle application *(fatto con email)* \[V]
- creare feedback utente sulla base dell'esito dell'application
- *minor:* valutare se inserire logica di submit nello stesso file del form (evitando di avere una pagina a cui non avrebbe senso accedere)
- download csv dalla pagina delle iscrizioni `admin/applications.php`
- rimuovere visualizzazione errori di PHP
- testare il deploy **2 giorni prima almeno**
