<?php

include_once 'User.php';
include_once 'Dipendente.php';
include_once 'Cliente.php';
include_once 'Db.php';


/**
 * Classe per la creazione degli utenti del sistema
 */
class UserFactory {

    private static $singleton;

    private function __constructor() {
        
    }

    /**
     * Restiuisce un singleton per creare utenti
     * @return \UserFactory
     */
    public static function instance() {
        if (!isset(self::$singleton)) {
            self::$singleton = new UserFactory();
        }

        return self::$singleton;
    }

    /**
     * Carica un utente tramite username e password
     * @param string $username
     * @param string $password
     * @return \User|\Dipendente|\Cliente
     */
    public function caricaUtente($username, $password) {


        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[loadUser] impossibile inizializzare il database");
            $mysqli->close();
            return null;
        }

        // cerco prima nella tabella clienti
        $query = "SELECT * FROM clienti WHERE  username =  ? AND  password =  ?";
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[loadUser] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return null;
        }

        if (!$stmt->bind_param('ss', $username, $password)) {
            error_log("[loadUser] impossibile" .
                    " effettuare il binding in input ");
            $mysqli->close();
            return null;
        }

        $dipendente = self::caricaClienteDaStmt($stmt);
        if (isset($dipendente)) {
            // ho trovato uno studente
            $mysqli->close();
            return $dipendente;
        }

        // ora cerco un dipendente
        $query = "select * from dipendente where username = ? and password = ?";

        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[loadUser] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return null;
        }

        if (!$stmt->bind_param('ss', $username, $password)) {
            error_log("[loadUser] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return null;
        }

        $dipendente = self::caricaDipendenteDaStmt($stmt);
        if (isset($dipendente)) {
            // ho trovato un docente
            $mysqli->close();
            return $dipendente;
        }
    }

    
    private function caricaClienteDaStmt(mysqli_stmt $stmt) {

        if (!$stmt->execute()) {
            error_log("[caricaClienteDaStmt] impossibile" .
                    " eseguire lo statement");
            return null;
        }

        $row = array();
        $bind = $stmt->bind_result(
                $row['dipendente_id'], 
                $row['dipendente_username'], 
                $row['dipendente_password'],                
                $row['dipendente_nome'], 
                $row['dipendente_cognome'], 
                $row['dipendente_via'],
                $row['dipendente_civico'],
                $row['dipendente_cap'],
                $row['dipendente_citta'],
                $row['dipendente_telefono']);
        
        if (!$bind) {
            error_log("[caricaClienteDaStmt] impossibile" .
                    " effettuare il binding in output");
            return null;
        }

        if (!$stmt->fetch()) {
            return null;
        }

        $stmt->close();

        return self::creaClienteDaArray($row);
    }
    /**
     * Restituisce un array con i dipendenti presenti nel sistema
     * @return array
     */
    public function &getListaClienti() {
        $clienti = array();
        $query = "select * from clienti";
        
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getListaClienti] impossibile inizializzare il database");
            $mysqli->close();
            return $clienti;
        }
        $result = $mysqli->query($query);
        if ($mysqli->errno > 0) {
            error_log("[getListaClienti] impossibile eseguire la query");
            $mysqli->close();
            return $clienti;
        }

        while ($row = $result->fetch_array()) {
            $clienti[] = self::creaClienteDaArray($row);
        }
        //togliere?
        $mysqli->close();
        return $clienti;
    }

    /**
     * Crea un cliente da una riga del db
     * @param type $row
     * @return \Cliente
     */
    public function creaClienteDaArray($row) {
        $dipendente = new Cliente();
        $dipendente->setId($row['dipendente_id']); 
        $dipendente->setUsername($row['dipendente_username']);
        $dipendente->setPassword($row['dipendente_password']);        
        $dipendente->setNome($row['dipendente_nome']);    
        $dipendente->setCognome($row['dipendente_cognome']);
        $dipendente->setVia($row['dipendente_via']);
        $dipendente->setCivico($row['dipendente_civico']);
        $dipendente->setCitta($row['dipendente_citta']);                  
        $dipendente->setCap($row['dipendente_cap']);
        $dipendente->setTelefono($row['dipendente_telefono']);        
        $dipendente->setRuolo(User::Cliente);

        return $dipendente;
    }
    
    /**
     * Restituisce la lista degli clienti presenti nel sistema
     * @return array
     */
    public function &getListaDipendente() {
        $dipendente = array();
        $query = "select * from dipendente ";
        
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getListaDipendente] impossibile inizializzare il database");
            $mysqli->close();
            return $dipendente;
        }
        $result = $mysqli->query($query);
        if ($mysqli->errno > 0) {
            error_log("[getListaDipendente] impossibile eseguire la query");
            $mysqli->close();
            return $dipendente;
        }

        while ($row = $result->fetch_array()) {
            $dipendente[] = self::creaDipendenteDaArray($row);
        }

        return $dipendente;
    }




    /**
     * Crea un dipendente da una riga del db
     * @param type $row
     * @return \Dipendente
     */
    public function creaDipendenteDaArray($row) {
        $dipendente = new Dipendente();
        $dipendente->setId($row['dipendente_id']);
        $dipendente->setNome($row['dipendente_nome']);
        $dipendente->setCognome($row['dipendente_cognome']);
        $dipendente->setVia($row['dipendente_via']);
        $dipendente->setCivico($row['dipendente_civico']);
        $dipendente->setCitta($row['dipendente_citta']);                  
        $dipendente->setCap($row['dipendente_cap']);
        $dipendente->setTelefono($row['dipendente_telefono']);
        $dipendente->setRuolo(User::Dipendente);
        $dipendente->setUsername($row['dipendente_username']);
        $dipendente->setPassword($row['dipendente_password']);

        return $dipendente;
    }

    /**
     * Salva i dati relativi ad un utente sul db
     * @param User $user
     * @return il numero di righe modificate
     */
    public function salva(User $user) {
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[salva] impossibile inizializzare il database");
            $mysqli->close();
            return 0;
        }

        $stmt = $mysqli->stmt_init();
        $count = 0;
        switch ($user->getRuolo()) {
            case User::Cliente:
                $count = $this->salvaCliente($user, $stmt);
                break;
            case User::Dipendente:
                $count = $this->salvaDipendente($user, $stmt);
        }

        $stmt->close();
        $mysqli->close();
        return $count;
    }

    /**
     * Rende persistenti le modifiche all'anagrafica di uno studente sul db
     * @param Cliente $s lo studente considerato
     * @param mysqli_stmt $stmt un prepared statement
     * @return int il numero di righe modificate
     */
    private function salvaCliente(Cliente $c, mysqli_stmt $stmt) {
        $query = " UPDATE clienti SET 
                    password = ?,
                    nome = ?,
                    cognome = ?,
                    via = ?,
                    civico = ?,
                    citta = ?,
                    cap = ?,
                    telefono = ?
                    WHERE clienti.id = ?";
        
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[salvaCliente] impossibile" .
                    " inizializzare il prepared statement");
            return 0;
        }

        if (!$stmt->bind_param('ssssissii',
                $c->getPassword(),
                $c->getNome(),
                $c->getCognome(),
                $c->getVia(), 
                $c->getCivico(),
                $c->getCitta(),
                $c->getCap(),
                $c->getTelefono(),
                $c->getId())) {
            error_log("[salvaCliente] impossibile" .
                    " effettuare il binding in input 2");
            return 0;
        }

        if (!$stmt->execute()) {
            error_log("[caricaIscritti] impossibile" .
                    " eseguire lo statement");
            return 0;
        }

        return $stmt->affected_rows;
    }
    
    /**
     * Rende persistenti le modifiche all'anagrafica di un docente sul db
     * @param Dipendente $d il docente considerato
     * @param mysqli_stmt $stmt un prepared statement
     * @return int il numero di righe modificate
     */
    private function salvaDipendente(Dipendente $d, mysqli_stmt $stmt) {
        $query = " update dipendente set 
                    password = ?,
                    nome = ?,
                    cognome = ?,
                    via = ?,
                    civico = ?,
                    citta = ?,
                    cap = ?,
                    telefono = ?,
                    where dipendente.id = ?
                    ";
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[salvaCliente] impossibile" .
                    " inizializzare il prepared statement");
            return 0;
        }

        if (!$stmt->bind_param('ssssissii', 
                $d->getPassword(), 
                $d->getNome(), 
                $d->getCognome(), 
                $d->getVia(), 
                $d->getCivico(),
                $d->getCitta(),
                $d->getCap(),
                $d->getTelefono(),
                $d->getId())) {
            error_log("[salvaCliente] impossibile" .
                    " effettuare il binding in input");
            return 0;
        }

        if (!$stmt->execute()) {
            error_log("[caricaIscritti] impossibile" .
                    " eseguire lo statement");
            return 0;
        }

        return $stmt->affected_rows;
    }

    /**
     * Carica un docente eseguendo un prepared statement
     * @param mysqli_stmt $stmt
     * @return null
     */
    private function caricaDipendenteDaStmt(mysqli_stmt $stmt) {

        if (!$stmt->execute()) {
            error_log("[caricaDipendenteDaStmt] impossibile" .
                    " eseguire lo statement");
            return null;
        }

        $row = array();
        $bind = $stmt->bind_result(
                $row['dipendente_id'], 
                $row['dipendente_username'], 
                $row['dipendente_password'],                
                $row['dipendente_nome'], 
                $row['dipendente_cognome'], 
                $row['dipendente_via'],
                $row['dipendente_civico'],
                $row['dipendente_cap'],
                $row['dipendente_citta'],
                $row['dipendente_telefono']);
        if (!$bind) {
            error_log("[caricaDipendenteDaStmt] impossibile" .
                    " effettuare il binding in output");
            return null;
        }

        if (!$stmt->fetch()) {
            return null;
        }

        $stmt->close();

        return self::creaDipendenteDaArray($row);
    }
    
    /**
     * Cerca un utente per id
     * @param int $id
     * @return  un oggetto Cliente nel caso sia stato trovato,
     * NULL altrimenti
     */
    public function cercaUtentePerId($id, $role) {
        $intval = filter_var($id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (!isset($intval)) {
            return null;
        }
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[cercaUtentePerId] impossibile inizializzare il database");
            $mysqli->close();
            return null;
        }

        switch ($role) {
            case User::Cliente:
                $query = "select  * from clienti where id = ?";
                $stmt = $mysqli->stmt_init();
                $stmt->prepare($query);
                if (!$stmt) {
                    error_log("[cercaUtentePerId] impossibile" .
                            " inizializzare il prepared statement");
                    $mysqli->close();
                    return null;
                }

                if (!$stmt->bind_param('i', $intval)) {
                    error_log("[cercaUtentePerId] impossibile" .
                            " effettuare il binding in input");
                    $mysqli->close();
                    return null;
                }

                return self::caricaClienteDaStmt($stmt);
                break;

            case User::Dipendente:
                $query = "select * from dipendente where id = ?";

                $stmt = $mysqli->stmt_init();
                $stmt->prepare($query);
                if (!$stmt) {
                    error_log("[cercaUtentePerId] impossibile" .
                            " inizializzare il prepared statement");
                    $mysqli->close();
                    return null;
                }

                if (!$stmt->bind_param('i', $intval)) {
                    error_log("[loadUser] impossibile" .
                            " effettuare il binding in input");
                    $mysqli->close();
                    return null;
                }

                $toRet =  self::caricaDipendenteDaStmt($stmt);
                $mysqli->close();
                return $toRet;
                break;

            default: return null;
        }
                
    }
    
    /*
    * @param $id id del cliente da ricercare
    * @return dati del cliente corrispondenti all'id considerato
    */    
    public function getClientePerId($id) {
       $dipendente = array();
        $query = "SELECT * FROM clienti WHERE clienti.id = ? ";          
        
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getClientePerId] impossibile inizializzare il database");
            $mysqli->close();
            return $dipendente;
        }

        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[getClientePerId] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return $dipendente;
        }

        if (!$stmt->bind_param('i', $id)) {
            error_log("[getClientePerId] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return $dipendente;
        } 
        
        $dipendente = self::caricaClienteDaStmt($stmt);

        $mysqli->close();
        return $dipendente;        
                
    }
}

?>
