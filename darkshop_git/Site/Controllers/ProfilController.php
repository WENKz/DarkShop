<?php

class ProfilController extends Controller {

    public function index() {
        $this->Profil();
        $this->render(array("Profil"), array("title" => "Dark Store - Mon compte"));
    }
    //Afficher les profils
    public function Profil() {
        if (!$this->isLogged()) {
            header("Location: Login");
        }
        $this->cur_tab = $this->getParam(1);
        $this->data = $this->ProfilModel->getProfil(array("token_client" => $_SESSION['token_client'], "id_client" => $_SESSION['id_client']));

      /*  $this->render(array("Profil"), array("title" => "Dark Store - Gestion de compte"));*/
    }
    
     private function getPoint($tokent){
        
        $datas = $this->ProfilModel->getProfil(array("token_client" => $_SESSION['token_client'], "id_client" => $_SESSION['id_client']));
        extract($datas);
        if($point_client == null){
            $this->points = "0";
        }else{
            $this->points = $point_client;
        }
        if($event_client == null){
            $this->points_ev = "0";
        }else{
            $this->points_ev = $event_client;
        }
    }
    
       public function AffichertPoint($tokent){
         $this->getPoint($tokent);
         $this->render(array("Points","Profil"));
    }
    //Edit
    //Editer son profil
  /*  public function Editer() {
        if (!$this->isLogged()) {
            header("Location: Login");
        }
        $retour = $this->str_limit(array($_POST["email_client"] => "email"));
        $this->errors = $retour;
        // Si il y a des erreurs, on les affiche

        if (count($this->errors) >= 1) {
            $this->render(array("Profil"));
        }
        $edite = $this->ProfilModel->editProfil($_POST);

        header("Location: Profil");
    }*
    //afficher ses commandes
    public function Commande() {
        if (!$this->isLogged()) {
            header("Location: Login");
        }
        $this->data = $this->ProfilModel->getCommande(array("id_client" => $_SESSION['id_client']));
        $this->stats_com = "";
       
        $this->render(array("Historique", "Profil"), array("title" => "Dark Store - Historique des commandes"));
    }
    //recuperer les produit d'une commande
    public function ProduitCommande($id) {
        if (!$this->isLogged()) {
            header("Location: Login");
        }
        $this->data = $this->ProfilModel->listCommande(array("id_client" => $_SESSION['id_client'], "commande.id_commande" => $id));
        $this->render(array("ficheCommande", "Profil"), array("title" => "Dark Store - Commande n°$id"));
    }*/

}
