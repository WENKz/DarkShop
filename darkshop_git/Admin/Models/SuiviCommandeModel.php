<?php

/**
 * Description of GestionCommandeModel
 *
 * @author Hugo_
 */
class SuiviCommandeModel extends Model {

    public function listerCommandes($debut = 0, $nombre = 10, $statut = 1) {
        $jointure = array("commande", "produit", "id_produit");
        $jointure2 = array("commande", "client", "id_client");

//        // Récupérer le nombre de pages
//        $nb_page = $this->getNbPage($nombre, $statut);
        return $this->join(array($jointure, $jointure2), array("*"),false,  array("statut_commande" => $statut), array("id_commande", "desc"), array($debut, 10));
    }

    public function getNbPage($nombre, $statut) {
        $retour = $this->count("commande", "id_commande", array("statut_commande" => $statut));
        return ceil((float) $retour[0]["nombre"] / (float) $nombre);
    }

    public function getCommande($id_commande) {
        $jointure = array("commande", "produit", "id_produit");
        $jointure2 = array("commande", "client", "id_client");
        return $this->join(array($jointure, $jointure2), array("*"), false, array("commande.id_commande" => $id_commande));
    }

    public function changerStatut($id, $statut_init, $statut, $contenu_commande) {
        // Si le statut demandé est identique au statut actuel
        if ($statut_init == $statut) {
            return false;
        }

        // Mettre à jour le statut de la commande
        $this->update("commande", array("statut_commande" => $statut), array("id_commande" => $id), true);

        // Si la commande passe du statut 'en préparation' à 'prête'
        
        // Si la commande repasse en statut 'en préparation', on réinitialise le stock
      
    }

}
