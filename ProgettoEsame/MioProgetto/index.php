<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <h1>Progetto "Pizzas From Hell" di Giovanni Usai</h1>
        
        <h2>Accesso al progetto</h2>
    
    <p>
        La homepage del progetto si trova all'indirizzo <a href="php/login">http://spano.sc.unica.it/amm2014/usaiGiovanni/ProgettoEsame/MioProgetto/php/login</a>
    <p>
    <p>E' possibile eseguire l'accesso al sito utilizzando le seguenti credenziali</p>
    <ul>
        <li>Ruolo Cliente:</li>
        
        <ul>
            <li>username: cliente</li>
            <li>password: giovanni</li>
        </ul>
       
        <li>Ruolo dipendente :</li>
        <ul>
            <li>username: dipendente</li>
            <li>password: dimebag</li>
        </ul>
    </ul>
        
        <h2> Descrizione dell'applicazione</h2>
        <p>
            Il sito  si occupa della gestione degli ordini di una pizzeria.
            Ciascun ordine comprende un insieme di pizze (almeno 1) ed ha i seguenti elementi identificativi:
        </p>
        <ul>
            <li>Numero identificativo dell'ordine</li>
            <li>Data di prenotazione dell'ordine</li>
            <li>Prezzo totale</li>
            <li>Stato dell'ordine (ordini pagati o meno)</li>
            <li>Richiesta di consegna a domicilio</li>       
        </ul> 
        <p> 
            Ogni ordine si distingue dagli altri anche per: 
       </p>
       <ul>
            <li>La fascia oraria in cui verrà consegnato</li>
            <li>Il cliente che l'ha richiesto</li>
            <li>Il dipendente al quale è stata assegnata la gestione</li>
        </p>
    
        
        <p>
            Ci sono due tipi di utente che possono interagire in modo differente con l'interfaccia:
        </p>    
        <p><strong>Il cliente</strong></p>
        <p>
            Il cliente può eseguire 4 operazioni principali:
        </p>
         <ul>
            <li>Visualizzare e modificare il suo indirizzo o la password</li>
            <li>Eseguire un nuovo ordine</li>
            <li>Visualizzare l'elenco di tutti gli ordini richiesti in passato</li>
            <li>Visualizzare i contatti della pizzeria</li>       
        </ul> 
        <p>
            I dati relativi all'indirizzo dell'utente vengono utilizzati principalmente nel caso in cui questo richieda una consegna a domicilio. 
            Infatti, nel caso in cui la consegna debba avvenire ad un indirizzo diverso da quello gia presente, questo deve essere modificato
            nella sezione "anagrafica".
        </p>
        <p>
            Accedendo alla sezione "Ordina" viene visualizzato l'elenco delle pizze disponibili e i rispettivi prezzi. Dopo
            aver selezionato le pizze, la quantità e la fascia oraria in cui si desidera ritirare l'ordine viene visualizzata
            una schermata di riepilogo che comprende l'elenco delle pizze, l'orario di consegna e prezzo totale.
            L'orario di consegna, se in quello richiesto dall'utente non è possibile inserire quel determinato quantitativo di pizze
            (sono presenti dei limiti di ordini per ogni fascia oraria), sarà impostato con quello disponibile piu vicino.
            A questo punto il cliente decide se accettare o cancellare l'ordine.
        </p>
        
  
        <p><strong>Il dipendente</strong></p>
        <p>
            Il dipendente può eseguire 2 operazioni principali:
        </p>
         <ul>
            <li>Visualizzare gli ordini della giornata e contrassegnarli come pagati</li>
            <li>Ricercare gli ordini per data e ora</li>      
        </ul> 
         <p>
            Tramite la pagina "Gestione ordini" un dipendente può visualizzare gli ordini del giorno che devono ancora essere ritirati/consegati
            e pagati. Nel momento in cui questi vengono segnalati come pagati non vengono piu visualizzati nell'elenco mentre è possibile
            visualizzarli nella pagina "Ricerca ordini". Un ordine pagato registra l'ID del dipendente che l'ha segnalato come pagato.
            In questa pagina è possibile ricercare qualsiasi ordine, qualunque sia il suo stato, tramite la scelta della data e dell'ora.
        </p>       
        
        <h2> Requisiti del progetto </h2>
        <ul>
            <li>Utilizzo di HTML e CSS</li>
            <li>Utilizzo di PHP e MySQL</li>
            <li>Utilizzo del pattern MVC </li>
            <li>Due ruoli (cliente e dipendente)</li>
            <li>Transazione per il salvataggio(aggiornamento) di un nuovo ordine. Visibile all'interno della classe OrdineFactory.php metodi aggiornaOrdine e nuovoOrdine</li>
            <li>Caricamento ajax dei risultati della ricerca degli ordini da parte del dipendente</li>

        </ul>
        
</body>
</html>

