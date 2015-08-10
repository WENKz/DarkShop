<?php

require_once 'CatalogueController.php';
require_once 'ProfilController.php';

class CommandeController extends Controller {

    // Valider une commande
    public function index() {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }

    public function acheterArticle($idProduit, $type = null) {

        $this->cat = new CatalogueController();
        $this->profil = new ProfilController();
        $product = $this->cat->CatalogueModel->ficheProduit($idProduit);

        $product = $product[0];
        extract($product);
        $profil = $this->profil->ProfilModel->getProfil(array("token_client" => $_SESSION['token_client'], "id_client" => $_SESSION['id_client']));
        if ($type == "point") {
            if ($prix_produit != NULL && $prix_produit > "0" && $prix_produit <= $profil["point_client"]) {
                $this->CommandeModel->addCommande(array("id_produit" => $idProduit, "date_commande" => date("Y-m-d"), "statut_commande" => "1", "id_client" => $profil['id_client']));
                $lastid_commande = $this->CommandeModel->listerCommandes(array("id_produit" => $idProduit, "date_commande" => date("Y-m-d"), "id_client" => $profil['id_client']));
                foreach ($lastid_commande as $value) {
                    $val = $value["id_commande"];
                }

                $util = $this->CommandeModel->verifUtil(array("id_client" => $_SESSION['id_client'], "id_produit" => $idProduit));
                if ($util[0] != 0) {
                    $valeurUtilisation_produit = $util[0]["nb_utilisation"] + $valeurUtilisation_produit;
                    $this->CommandeModel->editUtilisation(array("id_client" => $_SESSION['id_client'], "nb_utilisation" => $valeurUtilisation_produit,"id_commande" => $val),array("id_utilisation" => $util[0]["id_utilisation"]));
                } else {
                    $this->CommandeModel->addUtilisation(array("id_client" => $_SESSION['id_client'], "id_produit" => $idProduit, "id_commande" => $val, "nb_utilisation" => $valeurUtilisation_produit));
                }
                $point_final = $profil["point_client"] - $prix_produit;
                //   echo $point_final;
                $this->CommandeModel->UpdateSolde($profil["token_client"], $point_final);
                $Name = "Dark Store"; //senders name 
                $email = "contact@darkgames.fr"; //senders e-mail adress 
                $recipient = "quentin.grisard@gmail.com,kro55f1r3@hotmail.com,loumani71@gmail.com"; //recipient 
                $mail_body = "Des commandes en attentes de livraisons  merci de verifier !  http://boutique.darkgames.fr/Admin"; //mail body 
                $subject = "DarkGames Store Commande"; //subject 
                $header = "From: " . $Name . " <" . $email . ">\r\n"; //optional headerfields 

                mail($recipient, $subject, $mail_body, $header); //mail command :) 
                $this->flashBag(array("Success", "Votre article a bien été acheté.", 1));

                 header("Location: " . $_SERVER['HTTP_REFERER']);
            } else {
                $this->flashBag(array("Erreur", "Vous n'avez pas assez de DarkPoints.", -1));

                   header("Location: " . $_SERVER['HTTP_REFERER']);
            }
        }

        if ($type == "event") {
            if ($prix_ev_produit != NULL && $prix_ev_produit > "0" && $prix_ev_produit <= $profil["event_client"]) {

                $this->CommandeModel->addCommande(array("id_produit" => $idProduit, "date_commande" => date("Y-m-d"), "statut_commande" => "1", "id_client" => $profil['id_client']));
                $event_final = $profil["event_client"] - $prix_ev_produit;
                $this->CommandeModel->UpdateSolde($profil["token_client"], null, $event_final);
                $this->flashBag(array("Success", "Votre article a bien été acheté.", 1));
                header("Location: " . $_SERVER['HTTP_REFERER']);
            } else {
                $this->flashBag(array("Erreur", "Vous n'avez pas assez de points évenements.", -1));
                header("Location: " . $_SERVER['HTTP_REFERER']);
            }
        }
    }

    // Retourner le panier actuel
    public function getPanier($action = "afficher") {
        $this->action = $action;
        // Si le panier contient des articles
        if (isset($_SESSION["article"]) && is_array($_SESSION['article']) && count($_SESSION["article"] > 0)) {

            $values = array_keys((array) $_SESSION["article"]);
            $this->panier_tmp = $this->CommandeModel->getPanier($values);
            $this->panier = array();
            $montant_qte = array();

            foreach ($this->panier_tmp as $article) {
                foreach ($_SESSION["article"] as $id_produit => $qte) {
                    // Associer la quantité à chaque article dans le panier
                    if ($id_produit == $article["id_produit"]) {
                        $article["qte_produit"] = $qte;
                        // Formater le tableau pour calculer le montant total de la commande
                        $montant_qte[$id_produit]["prix"] = (float) $article["prix_produit"];
                        $montant_qte[$id_produit]["qte"] = $qte;
                    }
                }
                array_push($this->panier, $article);
            }
            // Nombre d'articles dans le panier
            $this->nb = count($_SESSION["article"]);
            $this->total = $this->getTotal($montant_qte);
        }
        // Panier vide
        else {
            $this->nb = 0;
            $this->total = 0;
        }
        // Page de commande
        if ($action == "valider") {
            if ($this->isLogged()) {
                $this->adresse = $this->CommandeModel->getAdresse();
                if ($this->nb > 0) {
                    $this->date = $this->getDelay($_SESSION['article']);
                }
            }
            $this->render(array("Commande"), array("title" => "Validation du panier"));
        }
        // Affichage du panier 
        else {
            $this->render(array("Commande"), false);
        }
    }

    // Calculer le délai de livraison (délais de préparation + 2 + date de la commande)
    public function getDelay($commande) {
        $values = array_keys((array) $_SESSION["article"]);
//        var_dump($values);
        $panier = $this->CommandeModel->getDelay($values);
        $i = 1;
        $delai_prep = 1;
        // Vérifier si chaque article est en stock pour la quantité demandé
        foreach ($commande as $id_produit => $qte) {
//            echo $id_produit . " " . $qte["qte"] . "<br>";
            foreach ($panier as $produit) {
                if ($produit["id_produit"] == $id_produit) {
                    /* Si un produit est en stock insuffisant pour la commande
                      On passe le délai de préparation à 3 jours */
                    if ($produit["stock_produit"] < $qte["qte"]) {
                        $delai_prep = 3;
                        break;
                    }
                }
            }
            $i++;
        }
        // + 2 jours d'acheminement
        $delai_prep += 2;
        // Calculer la date à partir d'aujourd'hui
        $delai_prep = date("d/m/Y", strtotime("+" . $delai_prep . " days"));
        return $delai_prep;
    }

    // Calculer le montant total du panier
    public function getTotal($values) {
        $montant = 0;
        foreach ($values as $value) {
            extract($value["qte"]);
//            echo $value["prix"];
            $montant += (int) $qte * (float) $value["prix"];
        }
        return $montant;
    }

    // Ajouter un article au panier
    public function ajouterArticle($id, $qte = 1) {
        $nb = count($_SESSION["article"]);
        if (isset($_SESSION["article"][$id])) {
            $_SESSION["article"][$id]["qte"] += 1;
        } else {
            $_SESSION["article"][$id]["qte"] = $qte;
        }
        $this->flashBag(array("", "Votre article a bien été ajouté au panier.", 1));
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }

    // Modifier la quantité d'un article présent dans le panier
    public function mettreAJourQte($id, $ope = "plus") {
        // Ajouter 1 en quantité
        if ($ope == "plus") {
            $_SESSION["article"][$id]["qte"] += 1;
        }
        // Soustraire 1 en quantité
        else {
            if ($_SESSION["article"][$id]["qte"] == 1) {
                $this->supprimerArticle($id);
            } else {
                $_SESSION["article"][$id]["qte"] -= 1;
            }
        }
        header("Location: Commande");
    }

    // Supprimer un article du panier
    public function supprimerArticle($id) {
        // Si le panier ne contient plus d'articles, on le vide
        if (count($_SESSION["article"]) == 1) {
            $this->viderPanier();
        }
        // Supprimer un article du panier
        unset($_SESSION["article"][$id]);
        header("Location: Commande");
    }

    public function viderPanier() {
        unset($_SESSION["article"]);
        header("Location: Commande");
    }

    // Valider définitivement la commande
    public function valider() {
        $this->action = __FUNCTION__;
        $fields = $_POST;
        // On vérifie si les informations de paiement sont correctement renseignées
        $this->errors = $this->checkFields(array("type_carte", "num_carte", "date_exp"), $fields);
        $retour = $this->str_limit(array($fields["type_carte"] => "type carte|1|1|int", $fields["date_exp"] => "date", $fields["num_carte"] => "num carte|10|10|int"));
        $this->errors = array_merge((array) $this->errors, $retour);

        // Si la date d'expiration de la carte est au bon format
        if (count($this->str_limit(array($fields["date_exp"] => "date"))) == 0) {
            // Si la date d'expiration de la carte est dépassée par la date actuelle
            $datejour = date('d/m/Y');
            $datefin = $fields["date_exp"];
            $dfin = explode("/", $datefin);
            $djour = explode("/", $datejour);
            $date_carte = $dfin[2] . $dfin[1] . $dfin[0];
            $auj = $djour[2] . $djour[1] . $djour[0];
            if ($auj > $date_carte) {
                array_push($this->errors, "La <b>date</b> de la carte est expirée.");
            }
        }
        // Définir l'adresse de livraison
        if (!empty($fields["adr_autre"])) {
            $adr_livraison = $fields["adr_autre"];
        } else {
            $adr_livraison = $this->CommandeModel->getAdresse();
            extract($adr_livraison[0]);
            $adr_livraison = $adresse_client . ", " . $ville_client . ", " . $pays_client;
        }
        // Si il y a des erreurs, on les affiche
        $this->errors = array_filter($this->errors);
        if (count($this->errors) >= 1) {
            $this->getPanier("valider");
            exit();
        }
        // Si l'utilisateur est connecté, on valide la commande
        if ($this->isLogged()) {
            $infos_commande = array("moyen_paiement" => $fields["type_carte"], "adresse_livraison" => $adr_livraison);
            $commande = array("infos" => $infos_commande, "articles" => $_SESSION["article"]);
            $this->CommandeModel->validerCommande($commande);
            $this->flashBag(array("Succès", "Votre commande a bien été prise en compte.", 1));
            $this->viderPanier();
            header("Location: Profil-commande");
        }
        // Sinon, on lui propose de créer un compte pour encaisser sa commande
        else {
            $this->flashBag(array("Erreur", "Veuillez vous inscrire pour finaliser la commande.", -1));
            $this->getPanier("valider");
        }
    }

}
