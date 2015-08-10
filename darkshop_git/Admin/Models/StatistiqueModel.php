<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StatistiqueModel
 *
 * @author quentin
 */
class StatistiqueModel extends Model {
    //rechercher en base les produits les plus vendu
    public function topProduit($limit = null, $where = null, $like = null) {
        $join1 = array("contenu_commande", "produit", "id_produit");
        $join2 = array("contenu_commande", "commande", "id_commande");
        $data = array("* ,sum(`qte_produit`) as total_produit,count(contenu_commande.id_commande) as total_commande");
        $clause = array("contenu_commande.id_produit");
        $order = array("total_produit", "DESC");

        $query = $this->join(array($join1, $join2), $data, $clause, $where, $order, $limit, $like);
        return $query;
    }
    // avoir les commandes moyennes
    public function getMoyen($like = null) {
        $jointure2 = array("contenu_commande", "produit", "id_produit");

        $query = $this->join(array($jointure2), array("*", "SUM(prix_produit*qte_produit) as total_commande "), array("id_commande"), '', '', '', $like);
        return $query;
    }
    //Compter le nombre de commande
    public function CountCommande($like = null) {
        $jointure2 = array("commande", "contenu_commande", "id_commande");

        $query = $this->join(array($jointure2), array("count(commande.id_commande) as nb_commande "), '', '', '', $like);
        return $query;
    }

}
