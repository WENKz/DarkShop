<?php

class StatistiqueController extends Controller {

    public function index() {
        $this->topProductDate("", 5, date("Y"));
        $this->topProduct("", 5);
        $this->moyenCommande();
        $this->render(array("Statistique"), array("title" => "CesiStore - Top 5"));
    }
    //affiche les produits les plus vendus
    public function topProduct($id = null, $limit = null) {
        ($id != "") ? $where = array("contenu_commande.id_produit" => $id) : $where = null;
        $this->topProd = $this->StatistiqueModel->topProduit($limit = null, $where);
        if (count($this->topProd) == 0) {
            $this->flashBag(array("Erreur", "Le produit n'a pas encore été commandé.", -1));
            sleep(0.1);
        }
        if ($id) {
            $this->render(array("StatProduit", "Statistique"), array("title" => "CesiStore - Stats de vente"));
        } else {
            return $this->topProd;
        }
    }
    //affiche les produits les plus vendus à une perdiode donnée
    public function topProductDate($id = null, $limit = null, $mois = null) {
        ($id != "") ? $where = array("contenu_commande.id_produit" => $id) : $where = null;
        $like = array("commande.date_commande" => "%$mois%");
        $this->topDate = $this->StatistiqueModel->topProduit($limit = null, $where, $like);
        if (count($this->topDate) == 0) {
            $this->flashBag(array("Erreur", "Le produit n'a pas encore été commandé.", -1));
            sleep(0.1);
        }
        return $this->topDate;
    }
    //Connaitre la commande moyen selon une date ou non
    public function moyenCommande($date = null) {
        if (isset($_POST['date_moyen'])) {
            $date = $_POST['date_moyen'];
        }
        ($date != "") ? $like = array("commande.date_commande" => "%$date%") : $like = null;
        $montant = $this->StatistiqueModel->getMoyen($like);
        $nbcommande = $this->StatistiqueModel->CountCommande($date);
        $total = 0;
        foreach ($montant as $value) {

            $total+=$value['total_commande'];
        }
        if($nbcommande[0]['nb_commande'] == 0){ return false; }
        $this->moyen = number_format($total / $nbcommande[0]['nb_commande'], 2);
        if (isset($_POST['date_moyen'])) {
            $this->render(array("Statistique"), array("title" => "CesiStore - Panier de l'année " . $_POST['date_moyen']));
        } else {

            return $this->moyen;
        }
    }
    //rechercher les produit vendus à une date
    public function rechercherDate($id = null) {
        if (isset($_POST['date']) && is_numeric($_POST['date'])) {
            $this->id = $id;
            $this->topProdu = $this->topProductDate($id, null, $_POST['date']);
            $this->render(array("StatProduit", "Statistique"), array("title" => "CesiStore - Stats de vente"));
        } else {
            header("Location: Statistique");
        }
    }
    //connaitre les statistiques de ventes d'un produit
    public function StatProduit($id) {
        $this->id = $id;
        $this->topProductDate($id, "", date("Y"));
        $this->topProduct($id, "");
        $this->render(array("StatProduit", "Statistique"), array("title" => "CesiStore - Stats Produit"));
    }

}
