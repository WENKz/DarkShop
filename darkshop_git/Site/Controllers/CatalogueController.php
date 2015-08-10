<?php

class CatalogueController extends Controller {

    // Par défaut, afficher les catégories et les nouveautés
    public function index() {
          if (!$this->isLogged()) {
            header("Location: Login");
        }
        $this->nouveautes();
    }
    public function darkpoints(){
          if (!$this->isLogged()) {
            header("Location: Login");
        }
        $this->render(array("darkpoint","Catalogue"),array("title"=>"Acheter des Darkpoints !"));
    }
    // Filtrer les articles par catégorie
    public function categorie($id = 1, $page = 1) {
          if (!$this->isLogged()) {
            header("Location: Login");
        }
        if (!is_numeric($id)) {
            $id = 1;
        }
        $nb_post = 6;
        // Retourner le nombre de page pour la catégorie donnée
        $nb_page = $this->CatalogueModel->getNbPage(array("id_categorie" => $id), $nb_post);
        // Générer la pagination
        $this->pagin = $this->paginate(array("nb_page" => $nb_page, "here" => $page, "link" => "Catalogue-categorie-" . $id . "-"));

        if ($page == 1) {
            $debut = 0;
        } else {
            $debut = ($page * $nb_post) - $nb_post;
        }
        $this->articles = $this->CatalogueModel->parCategorie($id, $debut, $nb_post);
        $this->render(array("Catalogue"), array("title" => "Catégorie " . $id));
    }

    // Afficher le menu des catégories
    public function listerCategories() {
        $this->cur_item = $this->getParam(2);
        $this->categories = $this->CatalogueModel->listerCategories();
        $this->render(array("Categories", "Catalogue"), false);
    }

    // Afficher la fiche détaillée d'un produit
    public function ficheProduit($id) {
        $this->action = __FUNCTION__;
        $this->articles = $this->CatalogueModel->ficheProduit($id);
        $this->render(array("Catalogue"), array("title" => "Fiche produit"));
    }

    // Afficher le menu des catégories
    public function nouveautes($page = 1) {
        $this->action = __FUNCTION__;
        $nb_post = 3;
        // Retourner le nombre de page pour les nouveautés
        $nb_page = $this->CatalogueModel->getNbPage(array("statut_produit" => 1), $nb_post);
        // Générer la pagination
        $this->pagin = $this->paginate(array("nb_page" => $nb_page, "here" => $page, "link" => "Catalogue-nouveautes-"));

        if ($page == 1) {
            $debut = 0;
        } else {
            $debut = ($page * $nb_post) - $nb_post;
        }
        $this->articles = $this->CatalogueModel->nouveautes($debut, $nb_post);
        $this->render(array("Nouveautes", "Catalogue"), array("title" => "Accueil"));
    }

    // Afficher des articles selon un critère (par catégorie, recherche...)
    public function afficherCategorie($nom) {
        $this->CatalogueModel->afficherCategorie($nom);
    }

    // Rechercher des articles par titre, id ou tags
    public function rechercher($recherche = null) {
          if (!$this->isLogged()) {
            header("Location: Login");
        }
        if (isset($_POST['recherche']) && strlen($_POST['recherche']) > 0) {
            $recherche = $_POST['recherche'];
        }
        // Par défaut, on affiche le formulaire
        if ($recherche == null) {
            header("Location: Catalogue");
        }
        // Si il y a une recherche, on affiche le résultat
        else {
            // Filtrer rechercher par ID ou par titre, description et tags
            (is_numeric($recherche)) ? $type = "id_produit" : $type = array("titre_produit", "description_produit", "tags_produit");
            $this->data = $this->CatalogueModel->rechercher($type, $recherche);
            $this->recherche = htmlspecialchars($recherche);
            $this->action = __FUNCTION__;
//            $this->render(array("Catalogue"), array("title" => "Catalogue"));
            $this->render(array("Rechercher", "Catalogue"), array("title" => "Recherche", "js" => "catalogue"));
        }
    }

}
