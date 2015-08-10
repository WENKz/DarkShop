<?php

class GestionCatalogueController extends Controller {

    public function index() {
        $this->listProduit();
    }

    public function listProduit() {
          if (!$this->isLogged()) {
            header("Location: Login");
        }
        //On recupère tous les produits en base
        $this->data = $this->GestionCatalogueModel->getProduit();

        $this->render(array("ListProduit", "GestionCatalogue"), array("title" => "Cesi Store - Listing produit"));
    }

    public function ajouterProduit($send = null) {
          if (!$this->isLogged()) {
            header("Location: Login");
        }
        //On recupèrer les categories pour les ajouter dans le formulaire
        $this->data = $this->GestionCatalogueModel->getCategorie();
        //Si le formulaire est envoyé on traite les données
        if ($send) {
            //On verifie la sintax du titre
            $retour = $this->str_limit(array($_POST["titre_produit"] => "titre|false|false|alpha"));
            $this->errors = $retour;
            $this->fields = $_POST;
            // Si il y a des erreurs, on les affiche
            if (count($this->errors) >= 1) {
                $this->render(array("AjouterProduit", "GestionCatalogue"), array("title" => "Cesi Store - Ajouter produit"));
            }
            //On verifie si le nom du produit existe deja
            $data = $this->GestionCatalogueModel->selectProduit($_POST);
            extract($data[0]);
            //On verifi si l'identifiant existe
            if ($nombre == 0) {
                $data = $this->GestionCatalogueModel->ajouterProduit($_POST);
//                var_dump($data);
                if ($this->addImage($_FILES, $data)) {
                   // echo "upload ok";
                } else {
                   // echo "upload ko";
                }
                $this->flashBag(array("Succès", "Le produit est bien ajouté.", 1));
            } else {
                $this->flashBag(array("Erreur", "Le produit existe deja.", -1));
            }
        }
        $this->render(array("AjouterProduit", "GestionCatalogue"), array("title" => "Cesi Store - Ajouter produit"));
    }

    public function addImage($files, $id) {
        $fichier = basename($files['image_produit']['name']);
        $extension = strrchr($files['image_produit']['name'], '.');
        $extensions = array('.png', '.gif', '.jpg', '.jpeg');
        $dossier = "Resources/img/catalogue/";
        if (!in_array($extension, $extensions)) {

            $this->flashBag(array("Erreur", "Vous devez uploader un fichier de type png, gif, jpg, jpeg."), -1);
            $result = 1;
        } else {
            if (file_exists($dossier . $id)) {
                unlink($dossier . $id);
            }

            if (move_uploaded_file($files['image_produit']['tmp_name'],  $dossier . $id . $extension)) {
                $result = 2;
                $this->flashBag(array("Succès", "Le fichier a bien était uploadé."), 1);
            } else {
                $result = 1;
                $this->flashBag(array("Erreur", "Le fichier n'a pas était uploadé."), -1);
            }
        }
        return $result;
    }

    public function editerProduit($id, $send = null) {
          if (!$this->isLogged()) {
            header("Location: Login");
        }
        $this->categories = $this->GestionCatalogueModel->getCategorie();

        $this->data = $this->GestionCatalogueModel->getProduit(array("id_produit" => $id));
        if ($send != "") {
            $fields = $_POST;
            $fields = array("titre_produit" => $fields["titre_produit"], "description_produit" => $fields["description_produit"], "prix_produit" => $fields["prix_produit"], "prix_ev_produit" => $fields["prix_ev_produit"], "statut_produit" => $fields["statut_produit"], "id_categorie" => $fields["id_categorie"],"typeUtilisation_produit" => $fields["typeUtilisation_produit"],"valeurUtilisation_produit" => $fields["valeurUtilisation_produit"]);
            $this->GestionCatalogueModel->updateProduit($fields, array("id_produit" => $id));
            if (isset($_FILES["image_produit"])) {
                if ($this->addImage($_FILES, $id)) {
                    echo "upload ok";
                } else {
                    echo "upload nok";
                }
            }
            header("Location: GestionCatalogue-editerProduit-" . $id);
        }
        $this->render(array("editerProduit", "GestionCatalogue"), array("title" => "Cesi Store - Editer"));
    }

    public function supprimerProduit($id) {
          if (!$this->isLogged()) {
            header("Location: Login");
        }
        $this->GestionCatalogueModel->supprimer("produit", array("id_produit", $id));
                $this->flashBag("Succès", "Le produit n°" . $id . " a été supprimée.", 1);

                header("Location: GestionCatalogue");

    }

    public function listCategorie() {
          if (!$this->isLogged()) {
            header("Location: Login");
        }
        $this->data = $this->GestionCatalogueModel->getCategorie();

        $this->render(array("ListCategorie", "GestionCatalogue"), array("title" => "Cesi Store - Listing categorie"));
    }

    public function ajouterCategorie($send = null) {
          if (!$this->isLogged()) {
            header("Location: Login");
        }
        if ($send) {
            $retour = $this->str_limit(array($_POST["nom_categorie"] => "nom|false|false|alpha"));
            $this->errors = $retour;
            $this->fields = $_POST;

            // Si il y a des erreurs, on les affiche
            if (count($this->errors) >= 1) {
                $this->render(array("AjouterCategorie", "GestionCatalogue"), array("title" => "Cesi Store - Ajouter produit"));
            }
            $this->data = $this->GestionCatalogueModel->verifExist("categorie", array("nom_categorie" => $_POST["nom_categorie"]));
            extract($this->data[0]);
            //On verifi si l'identifiant existe
            if ($nombre == 0) {
                $this->data = $this->GestionCatalogueModel->ajouterCategorie($_POST);
                $send = null;
                $this->flashBag(array("Succès", "La categorie est bien ajoutée."), 1);
            } else {
                 $send = null;
                $this->flashBag(array("Erreur", "La catégorie existe deja."), -1);
            }
        }

        $this->render(array("AjouterCategorie", "GestionCatalogue"), array("title" => "Cesi Store - Ajouter produit"));
    }

    public function editerCategorie($id_categorie, $send=null) {
          if (!$this->isLogged()) {
            header("Location: Login");
        }
        $this->data = $this->GestionCatalogueModel->getCategorie(array("id_categorie" => $id_categorie));
        if ($send != "") {
            $fields = $_POST;
            $fields = array("nom_categorie" => $fields["nom_categorie"]);
            $this->GestionCatalogueModel->updateCat($fields, array("id_categorie" => $id_categorie));
            header("Location: GestionCatalogue-ListCategorie");
        }
        $this->render(array("editerCategorie", "GestionCatalogue"), array("title" => "Cesi Store - Editer Categorie"));
    }

    public function supprimerCategorie($id) {
          if (!$this->isLogged()) {
            header("Location: Login");
        }
        $this->data = $this->GestionCatalogueModel->supprimer("categorie", array("id_categorie", $id));
        $this->flashBag("Succès", "La catégorie n°" . $id . " a été supprimée.", 1);
        header("Location: GestionCatalogue-ListCategorie");
    }

}
