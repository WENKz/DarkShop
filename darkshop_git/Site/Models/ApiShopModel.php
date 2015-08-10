<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ApiShopModel
 *
 * @author quentin
 */
class ApiShopModel extends Model {

    public function getKitUnturned($steam, $nom_produit = null) {

        $jointure1 = array("utilisation", "commande", "id_commande");
        $jointure2 = array("utilisation", "produit", "id_produit");
        $jointure3 = array("utilisation", "client", "id_client");
        if ($nom_produit != null) {
            return $this->join(array($jointure1, $jointure2, $jointure3), array("*"), false, array("client.steam_client" => $steam,  "produit.id_produit" => $nom_produit));
        } else {

            return $this->join(array($jointure1, $jointure2, $jointure3), array("*"), false, array("client.steam_client" => $steam, "produit.id_categorie" => "4"));
        }
    }

    public function searchClient($steam_client) {
        $result = $this->count("client", "*", array("steam_client" => $steam_client), true);
        return $result;
    }

}
