<?php

include_once 'User.php';

/**
 * Classe che rappresenta un Cliente
 */
class Cliente extends User {


    /**
     * Costruttore della classe
     */
    public function __construct() {
        // richiamiamo il costruttore della superclasse
        parent::__construct();
        $this->setRuolo(User::Cliente);
        
    }


}

?>
