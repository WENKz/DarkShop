<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GestionUtilisateurController
 *
 * @author quentin
 */
class GestionUtilisateurController extends Controller {

    public function index() {
        if (!$this->isLogged()) {
            header("Location: Login");
        }
        $this->listerClient();
    }

    public function listerClient() {
        if (!$this->isLogged()) {
            header("Location: Login");
        }
        //On recupère tous les produits en base
        $this->data = $this->GestionUtilisateurModel->getUtilisateur();

        $this->render(array("ListerUtilisateur", "GestionUtilisateur"), array("title" => "Dark Store- Listing Utilisateur"));
    }

    public function editerClient($id_client, $send = null) {
        if (!$this->isLogged()) {
            header("Location: Login");
        }
        //On recupère tous les produits en base
        $this->infoClient = $this->GestionUtilisateurModel->getUtilisateur(array("id_client" => $id_client));
        if ($send == "send") {
            $this->GestionUtilisateurModel->setClient($_POST, array("id_client" => $id_client));
            $this->flashBag(array("Succès", "Le client a été mis à jour.", 1));
            header("Location: GestionUtilisateur");
        }
        $this->render(array("EditerUtilisateur", "GestionUtilisateur"), array("title" => "Dark Store- Listing Utilisateur"));
    }

}
