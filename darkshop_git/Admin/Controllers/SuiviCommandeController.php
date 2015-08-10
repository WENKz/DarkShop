<?php

class SuiviCommandeController extends Controller {

    public function index($page = 1) {
          if (!$this->isLogged()) {
            header("Location: Login");
        }
        $this->page = $page;
        $this->all(1, $page);
        $this->render(array("SuiviCommande"), array("title" => "Suivi des commandes"));
    }

    // Afficher toutes les commandes selon le statut
    public function all($type = 1, $page = 1) {
          if (!$this->isLogged()) {
            header("Location: Login");
        }
        // Rediriger si paramètre 'page' non numérique
        if (!is_numeric($page)) {
            header("Location: SuiviCommande-all");
        }
        // Lister 10 commandes par page
        $this->listerCommandes($page, 10, $type);
        // Récupérer le nombre de pages pour la pagination
        $nb_page = $this->SuiviCommandeModel->getNbPage(10, $type);
        // Générer la pagination
        $this->pagin = $this->paginate(array("nb_page" => $nb_page, "here" => $page, "link" => "SuiviCommande-all-" . $type . "-"));
        $this->render(array("SuiviCommande"), array("title" => "Suivi des commandes"));
    }

    // Lister un nombre de commandes d'un type donné
    public function listerCommandes($page = 1, $nb = 10, $statut = 1, $one = false) {
          if (!$this->isLogged()) {
            header("Location: Login");
        }

        // Récupérer les commandes selon le type et le nombre spécifié
        if ($page == 1) {
            $debut = 0;
        } else {
            $debut = ($page * $nb) - $nb;
        }
        $articles = $this->SuiviCommandeModel->listerCommandes($debut, $nb, $statut);
        $commandes = array();
        $i = 0;
        $b = 0;
        $last_id = 0;

        // On regroupe les articles rattachés à chaque commande
        foreach ($articles as $key => $contenu) {
            // Si le produit est différent du dernier parcouru, on passe au suivant
            if ($contenu["id_commande"] != $last_id && $last_id != 0) {
                $i++;
                $b = 0;
            } else {
                // Si on parcoure toujours le même produit, on rattache l'article suivant au même produit
                $b++;
            }
            // Informations relatives à la commande
            $commandes[$i]["infos"] = array_slice($contenu, 0, 6);
            // Articles rattachés à la commande
            $commandes[$i]["articles"][$b] = array_slice($contenu, 6);
            $last_id = $contenu["id_commande"];
            // Si le stock est insuffisant pour la commande
            if ($contenu["stock_produit"] < $contenu["qte_produit"]) {
                $commandes[$i]["articles"][$b]["stock"] = false;
                $commandes[$i]["stock"] = false;
            } else {
                $commandes[$i]["articles"][$b]["stock"] = true;
                $commandes[$i]["stock"] = true;
            }           
            //var_dump($commandes);

        }

        // Adapter le changement de statut selon le type de commande choisi :
        if ($statut == 1) {
            // "En préparation" ne peut pas passer directement en expédiée
            $this->statut = array(1 => "En attente", 2 => "Livré");
        } else {
            $this->statut = array(1 => "En attente", 2 => "Livré");
        }
        $this->data = $commandes;
//            $this->render(array("Commandes", "SuiviCommande"), array("title"=>"Suivi des commandes"));
    }

    // Retourner le nombre de commandes d'un type donné
    public function getNbPage($nb_post, $statut) {
          if (!$this->isLogged()) {
            header("Location: Login");
        }
        return $this->SuiviCommandeModel->getNbPage($nb_post, $statut);
    }

    // Changer le statut d'une commande
    public function changerStatut($id_commande, $statut_init) {
          if (!$this->isLogged()) {
            header("Location: Login");
        }
        if (isset($_POST["statut_commande"])) {
            $contenu_commande = $this->SuiviCommandeModel->getCommande($id_commande);
            $this->SuiviCommandeModel->changerStatut($id_commande, $statut_init, $_POST['statut_commande'], $contenu_commande);
            $this->flashBag(array("Succès", "Le statut de la commande n°" . $id_commande . " a été mise à jour.", 1));
            header("Location: SuiviCommande");
        } else {
            header("Location: SuiviCommande");
        }
    }

    // Récupérer le contenu d'une commande par son identifiant
    public function getCommande($id) {
        $this->SuiviCommandeModel->getCommande($id);
    }

}
