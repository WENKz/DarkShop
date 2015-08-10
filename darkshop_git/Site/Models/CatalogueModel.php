<?php

class CatalogueModel extends Model {

    // Lister les catégories de produits
    public function listerCategories() {
        $query = $this->select("categorie", array("*"));
        return $query;
    }

    /* Retourner le nombre de page d'articles selon le filtre spécifié
     * $filtre Champ à filtrer [array] clé => valeur
     * $nb_post Nombre d'articles par page souhaité
     */

    public function getNbPage($filtre, $nb_post) {
        $champ = key($filtre);
        $val = $filtre[$champ];
        $retour = $this->count("produit", "id_produit", array($champ => $val));
        return ceil((float) $retour[0]["nombre"] / (float) $nb_post);
    }

    // Lister les nouveautés
    public function nouveautes($debut, $nb_post) {
        $jointure = array("produit", "categorie", "id_categorie");
        $query = $this->join(array($jointure), array("*"), false, array("statut_produit" => "1"), false, array("3"));
//        $query = $this->select("produit", array("*"), array("statut_produit" => "1"), array($debut, $nb_post));
        return $query;
    }

    // Retourner la fiche détaillée d'un produit donné
    public function ficheProduit($id) {
        $query = $this->select("produit", array("*"), array("id_produit" => $id, "statut_produit" => array("1", "2")));
        return $query;
    }

    // Lister les produits d'une catégorie donnée
    public function parCategorie($id = 1, $debut = 0, $nb_post = 5) {

        $query = $this->select("produit", array("*"), array("id_categorie" => $id), array($debut, $nb_post));
        return $query;
    }

    // Effectuer une recherche de produit sur le site
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

}
