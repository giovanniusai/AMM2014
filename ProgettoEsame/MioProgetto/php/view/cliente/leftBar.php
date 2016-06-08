<h2>Informazioni</h2>
<p> 
    Benvenuto <?= $user->getNome()." ". $user->getCognome()?>.
</p>
<p>
<?
if(!isset($_SESSION['pagina'])) $_SESSION['pagina'] = 'home.php';
switch ($_SESSION['pagina']) {
    case 'home.php':?>
        <p>
            Seleziona un'attività dal menù.
        </p>
       <?break;
    case 'anagrafica.php':?>
        <p>
            Indirizzo: Quando viene richiesta una consegna a domicilio questa avverrà all'indirizzo riportato
            in questa pagina. Nel caso in cui si voglia ricevere la consegna ad un indirizzo diverso assicurarsi di modificarlo
            prima di confermare l'ordine.   
        </p>
        <p>
            Password: La password può essere cambiata in qualsiasi momento.
        </p>
       <?break;    
    case 'ordina.php':?>
        <p>
            Inserire la quantità di pizze che si desidera ordinare negli appositi spazi. Ci sono spazi diversi
            a seconda delle dimensioni. L'ordine viene inviato solo dopo la conferma a seguito del riepilogo.
        </p>
        <p>
             Si può indicare una preferenza sull'orario di consegna delle pizze. Nel caso in cui non fosse possibile
            garantire la consegna per la quantità di pizze richiesto in una determinata fascia oraria
            verrà automaticamente selezionato il primo orario utile più vicino a quello richiesto.
        </p>
        <p>
            *verifica sezione Anagrafica
        </p>        
       <?break;  
    case 'elenco_ordini.php':?>
        <p>
            Elenco degli ordini effettuati.
        </p>
       <?break;  
    case 'contatti.php':?>
        <p>
            Siamo aperti dal martedì alla domenica dalle <strong>19.30</strong> alle <strong>22.00</strong>. Lunedì chiuso.
        </p>
        <p>
            Per qualsiasi informazione non esitare a contattarci.
        </p>
       <?break;   
    case 'dettaglio_ordine.php':?>
        <p>
            Dettaglio dei prezzi ed elenco pizze relativi all'ordine selezionato.
        </p>
       <?break;      
   default:
       break;
}
?>
</p>
