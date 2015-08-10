<?php

class GestionStockModel extends Model {

    // Lister les articles selon un critère défini
    public function listerStock($filtre, $tri = false, $debut = 0, $nb = 6) {
        return $this->select("produit", array("*"), array($filtre[0] => $filtre[1]), $tri, array($debut, $nb));
    }

    // Effectuer une recherche de produit
    public function rechercher($criteres, $recherche) {
        $query = "";
        // Rechercher par titre, description, tags
        if (is_array($criteres)) {
            $query = $this->select("produit", array("*"), array($criteres[0] => "%" . $recherche . "%", $criteres[1] => "%" . $recherche . "%"));
        }
        // Recherche par ID
        else {
            $query = $this->select("produit", array("*"), array($criteres => $recherche));
        }
        return $query;
    }

    // Mettre à jour le stock pour un article donné
    public function majArticle($id, $qte) {
        $this->update("produit", array("stock_produit" => $qte), array("id_produit" => $id));
    }

    // Lister les produits en rupture de stock
    public function rupture($debut = 0, $nb = 6) {
        return $this->load("SELECT * FROM produit WHERE stock_produit <= seuil_produit AND statut_produit IN(1,2) ORDER BY stock_produit DESC LIMIT " . $debut . " ," . $nb);
    }

    // Récupérer le nombre de page pour une catégorie donnée
    public function getNbPage($nombre, $id) {
        $retour = $this->count("produit", "id_produit", array("id_categorie" => $id));
        return ceil((float) $retour[0]["nombre"] / (float) $nombre);
    }

    // Lister les catégories de produit
    public function listerCategories() {
        return $this->select("categorie", array("*"));
    }

}
