<?php

class CommandeModel extends Model {

    // Récupérer les articles du panier
    public function getPanier($values) {
        return $this->select("produit", array("*"), array("id_produit" => $values));
    }

    // Valider définitivement la commande
    public function validerCommande($commande) {
        // Enregistrement de la commande
        extract($commande["infos"]);
        extract($commande["articles"]);
        $date = date("Y-m-d");
        $id_commande = $this->insert("commande", array("date_commande" => $date, "statut_commande" => 1, "moyen_paiement" => $moyen_paiement, "adresse_livraison" => $adresse_livraison, "id_client" => $_SESSION["id_client"]), true, true);
        $lines = 0;
        // Enregistrement des articles de la commande
        foreach ($_SESSION["article"] as $id_produit => $qte) {
            $lines += $this->insert("contenu_commande", array("qte_produit" => $qte["qte"], "id_commande" => $id_commande, "id_produit" => $id_produit), true, true);
        }
        return $lines;
    }

    public function listerCommandes($fields) {

        return $this->select("commande", array("*"), $fields);
    }

    public function verifUtil($fields) {
        return $this->select("utilisation", array("*"), $fields);
    }

    public function editUtilisation($vals, $clauses) {
        $this->update("utilisation", $vals, $clauses);
    }

    public function addUtilisation($field) {
        $this->insert("utilisation", $field, true);
    }

    public function addCommande($values) {
        $this->insert("commande", $values, true);
    }

    // Retourner l'adresse du client
    public function getAdresse() {
        return $this->select("client", array("adresse_client", "ville_client", "pays_client"), array("id_client" => $_SESSION['id_client']));
    }

    // Calculer le délai de livraison (délais de préparation + 2 + date de la commande)
    public function getDelay($values) {
        return $this->select("produit", array("id_produit, stock_produit"), array("id_produit" => $values));
    }

    public function getClient($value) {
        return $this->select("client", array("*"), array("token_client" => $value));
    }

    public function UpdateSolde($uid, $dp = false, $event = false) {
        if ($dp) {
            $this->update("client", array("point_client" => $dp), array("token_client" => $uid));
        }
        if ($event) {
            $this->update("client", array("event_client" => $event), array("token_client" => $uid));
        }
    }

}
