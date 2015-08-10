<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GestionUtilisateurModel
 *
 * @author quentin
 */
class GestionUtilisateurModel extends Model {

    public function getUtilisateur($clause = null) {
        $query = $this->select("client", array("*"), $clause);
        return $query;
    }
    public function setClient($fields, $clauses) {
        $query = $this->update("client", $fields, $clauses);
        return $query;
    }

}
