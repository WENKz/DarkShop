<?php

class GestionCatalogueModel extends Model {

    public function index() {
        
    }
    //Recuperer un ou des produits
    public function getProduit($clause = null) {
        $query = $this->select("produit", array("*"), $clause);
        return $query;
    }
    //recuperer un ou des categories
    public function getCategorie($clause = null) {
        $query = $this->select("categorie", array("*"),$clause);
        return $query;
    }
    //ajouter un produit en base de données
    public function ajouterProduit($fields) {
//        var_dump($fields);
        if($fields["prix_produit"] == "0"){
            $fields["prix_produit"] = NULL;
        }
         if($fields["prix_ev_produit"] == "0"){
            $fields["prix_ev_produit"] = NULL;
        }
        $query = $this->insert("produit", array("id_categorie" => $fields["id_categorie"],"titre_produit" => $fields["titre_produit"], "description_produit" => $fields["description_produit"], "prix_produit" => $fields["prix_produit"], "prix_ev_produit" => $fields["prix_ev_produit"], "status_produit" => $fields["statut_produit"],"typeUtilisation_produit" => $fields["typeUtilisation_produit"],"valeurUtilisation_produit" => $fields["valeurUtilisation_produit"]), true, true);
        return $query;
    }
    //mettre a jour un produit
    public function updateProduit($fields, $clauses) {
        $query = $this->update("produit", $fields, $clauses);
        return $query;
    }
    public function updateCat($fields, $clauses) {
        $query = $this->update("categorie", $fields, $clauses);
        return $query;
    }
    //selectionner un produit
    public function selectProduit($fields) {
        $query = $this->count("produit", "*", array("titre_produit" => $fields['titre_produit']), true);
        return $query;
    }
    //verifier si un produit existe ou une categorie
    public function verifExist($table, $fields) {
        $query = $this->count($table, "*", $fields, true);
        return $query;
    }
    //ajouter une categorie
    public function ajouterCategorie($fields) {
        $query = $this->insert("categorie", array("nom_categorie" => $fields["nom_categorie"]), true, true);
    }
    //supprimer produit ou categorie
    public function supprimer($table, $clause) {
        $this->delete($table, $clause);
    }

}
