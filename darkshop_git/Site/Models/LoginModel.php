<?php

class LoginModel extends Model {

    public function index() {
        $query = $this->select("categorie", array("*"));

        return $query;
    }

    public function connexionCompte($fields) {
        //On va chercher l'utilisateur dans la table client
        $result = $this->count("client", "*", array("email_client" => $fields['email_client'], "passe_client" => md5($fields["passe_client"])), true);
        return $result;
    }

    public function creerCompte($fields) {
        extract($fields);
        // On enregistre la création du compte
        $query = $this->insert("client", array("prenom_client" => $prenom, "token_client" => md5(uniqid()), "steam_client" => $steam_client, "point_client" => "0", "event_client" => "0"), true, true);
        return $query;
    }

    public function checkAccount() {
        $result = $this->count("client", "*", array("steam_client" => $_SESSION["T2SteamID64"]), true);
        return $result;
    }

    public function editProfil($field) {
        $query = $this->update("client", $field, array("id_client" => $_SESSION['id_client']));
    }

}
