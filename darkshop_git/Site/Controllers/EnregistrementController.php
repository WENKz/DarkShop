<?php

class EnregistrementController extends Controller {

// Par défaut, afficher le formulaire d'enregistrement
    public function index() {
        $this->render(array("Enregistrement"), array("title" => "Création de compte"));
    }

// Créer le compte
    public function creation() {
        $this->action = __FUNCTION__;
        if(isset($_POST)){ $fields = $_POST; }
        else{ $fields = array(); }

        // On vérifie que tous les champs obligatoires sont renseignés
        $checklist = array("email", "passe", "passe2", "nom", "prenom");
        $this->errors = (array) $this->checkFields($checklist, $fields, false);
        // On efface les données valant false
        $this->errors = array_filter($this->errors);

        
//        var_dump($nb_compte);

        //Comparaison des deux mots de passe
        if ($fields["passe"] != $fields["passe2"]) {
            array_push($this->errors, "Les mots de passe ne sont pas identiques.");
        }
        // On vérifie que le format attendu pour chaque champ est respecté
        $retour = $this->str_limit(array($fields["email"] => "email", $fields["passe"] => "passe|8|20|an"));
        $this->errors = array_merge((array) $this->errors, $retour);
        $this->fields = $fields;
        // Si il y a des erreurs, on les affiche
        if (count($this->errors) >= 1) {
            $this->render(array("Enregistrement"), array("title" => "Création de compte"));
        }
        // Sinon, on crée le compte
        else {
            $this->data = $this->EnregistrementModel->creerCompte($fields);
            // Si le compte est bien crée, on affiche un message de confirmation
            if (is_numeric($this->data)) {
                $this->flashBag(array("Succès", "Votre compte a bien été crée.", 1));
                sleep(1);
                header("Location: Catalogue");
            } else {
                $this->flashBag(array("Erreur", "Le compte n'a pas pu être crée.", -1));
                sleep(1);
                $this->render(array("Enregistrement"), array("title" => "Création de compte"));
            }
        }
    }

}
