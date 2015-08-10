<?php

class EnregistrementModel extends Model {

    public function index() {
        $query = $this->select("categorie", array("*"));
        return $query;
    }

    public function creerCompte($fields) {
        extract($fields);
        // On enregistre la création du compte
        $query = $this->insert("client", array("nom_client" => $nom, "prenom_client" => $prenom, "passe_client" => md5($passe), "token_client" => md5(uniqid()), "email_client" => $email,"point_client"=>"0"), true, true);
        return $query;
    }

    // Vérifier si le compte existe déjà en base
    public function checkAccount() {
        $fields = $_POST;
        $result = $this->count("client", "*", array("email_client" => $fields['email_client']), true);
        return $result;
    }

}
