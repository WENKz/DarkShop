<?php

class LoginModel extends Model {

    public function index() {
        $query = $this->select("categorie", array("*"));

        return $query;
    }

    public function connexionCompte($fields) {
        //On va chercher l'utilisateur dans la table client
        $result = $this->count("employe", "*", array("nom_employe" => $fields['nom_employe'], "passe_employe" => md5($fields["passe_employe"])), true);
        return $result;
    }

    public function deconnexion() {
        unset($_SESSION['id_employe']);
        unset($_SESSION['nom_employe']);
        header("Location: Login");
    }

}
