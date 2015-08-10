<?php

class LoginController extends Controller {

    public function index() {
        if ($this->isLogged()) {
            header("Location: Profil");
        }
        $this->render(array("Login"), array("title" => "Interface de connexion"));
    }
    //module de connexion
    public function connexion() {
        if ($this->isLogged()) {
            header("Location: Catalogue");
        }
        $this->fields = $_POST;
        // On va rechercher les données par rapport au $_POST
        $this->data = $this->LoginModel->connexionCompte($_POST);
        var_dump($this->data);
        extract($this->data[0]);
        if ($nombre == 1) {
            //Si il correspond on créé la session de l'utilisateur et on y insère son token ainsi que son id
            $this->setSession(array("nom_employe" => $nom_employe, "id_employe" => $id_employe));
            $this->flashBag(array("Succès", "Vous êtes bien connecté.", 1));
            header("Location: GestionCatalogue");
        } else {
            $this->flashBag(array("Erreur", "Votre mot de passe est incorrect.", -1));
        }

        $this->render(array("Login"), array("title" => "Connexion"));
    }
    //donner une session après authentification
    public function setSession($session) {
        //Créer les données de session
        foreach ($session as $key => $value) {
            $_SESSION[$key] = $value;
        }
    }
    //module de deconnexion
    public function deconnexion() {
        unset($_SESSION['id_employe']);
        unset($_SESSION['token_employe']);
        unset($_SESSION['nom_employe']);
        header("Location: GestionCatalogue");
    }

}
