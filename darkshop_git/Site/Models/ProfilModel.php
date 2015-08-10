<?php

class ProfilModel extends Model {

    //recuperer les infos profil
    public function getProfil($info) {
        extract($info);
        $query = $this->select("client", array("*"), array("token_client" => $token_client, "id_client" => $id_client));

        return $query[0];
    }

    //enregistrement en base pour editer profil
    public function editProfil($field) {
        $query = $this->update("client", $field, array("id_client" => $_SESSION['id_client']));
    }

    //recuperer les produits d'une commande
    public function getCommande($id_produit) {
        $jointure = array("commande", "contenu_commande", "id_commande");
        $jointure2 = array("contenu_commande", "produit", "id_produit");

        $query = $this->join(array($jointure, $jointure2), array("contenu_commande.id_commande", "date_commande", "moyen_paiement", "titre_produit", "statut_commande", "SUM(prix_produit*qte_produit) as total_commande "), array("id_commande"), $id_produit, $order = null);
        return $query;
    }

    //lister toutes les commandes
    public function listCommande($clause) {
        $jointure = array("commande", "contenu_commande", "id_commande");
        $jointure2 = array("contenu_commande", "produit", "id_produit");

        $query = $this->join(array($jointure, $jointure2), array("*"), null, $clause);
        return $query;
    }

    public function UpdateSolde($uid, $dp) {
        $this->update("client", array("point_client" => $dp), array("token_client" => $uid));
    }

}
