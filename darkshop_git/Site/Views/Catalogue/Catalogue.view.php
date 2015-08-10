<?php

echo $this->flashBag();
if (isset($_SESSION['message'])) {
    unset($_SESSION['message']);
}

if (count($this->articles) == 0) {
    echo "<p>Aucun article disponible.</p>";
} else {
    if ($this->action != "ficheProduit") {
        // Afficher la pagination
        foreach ($this->pagin as $page) {
            echo $page;
        }
    }
    echo "<div class='liste'>";
    foreach ($this->articles as $article) {
        extract($article);

        // Statut nouveauté
        ($statut_produit == 1) ? $new = "&nbsp;&nbsp;&nbsp; <span class='new'>nouveauté</span><br />" : $new = "";
        // Attribution de l'image par défaut
        (!is_file("Resources/img/catalogue/" . $id_produit . ".jpg")) ? $img = "Resources/img/template/noarticle.png" : $img = "Resources/img/catalogue/" . $id_produit . ".jpg";
        echo '<div class="liste-produit">
            <div style="
    width: 120px;
    float: left;
    height: 291px;
"><p class="article-left">' . $new . '<br />'
        . '<img class="min-img" src="' . $img . '" alt="" /><br />
            </p></div>';

($typeUtilisation_produit == 1)? $util = $valeurUtilisation_produit." Jours" : $util = $valeurUtilisation_produit." Utilisations";
($util == "-1 Jours") ? $util = "infinit" : $util = $util;
        echo '    <h3 class="liste-produit-nom">' . $titre_produit . '</h3>
            <p class="liste-produit-desc">' . $description_produit . '<br/>Type Utilisation :<strong> '.$util."</strong></p>";
        if ($prix_produit != NULL || $prix_produit != 0) {
            echo '<h3 class="liste-produit-prix"><span class="imp">Prix: ' . $prix_produit . ' DarkPoints</h3>';
        }
        if ($prix_ev_produit != NULL || $prix_ev_produit != 0) {
            echo '<h3 class="liste-produit-prix"><span class="imp">Prix: ' . $prix_ev_produit . ' DarkEvents</h3>';
        }
        echo '<p class="liste-produit-stock-ok">En Stock</p>';
        if ($prix_produit != NULL || $prix_produit != 0) {
            echo "<p><a class='btn btn-third' href='commande-acheterArticle-" . $id_produit . "-point' class='btn'>Acheter en DarkPoints</a> </p>";
        }

        if ($prix_ev_produit != NULL || $prix_ev_produit != 0) {
            echo " <p><a class='btn btn-third' href='commande-acheterArticle-" . $id_produit . "-envent' class='btn'>Acheter en DarkEvents</a></p>";
        }
        echo '</div>';
    }
    echo "</div>";
    if ($this->action != "ficheProduit") {
        // Afficher la pagination (x 2)
        foreach ($this->pagin as $page) {
            echo $page;
        }
    } else {
        echo "<p>Nous attirons l'attention de notre aimable clientèle en vous informant que conformément à notre politique de vente à petits prix,<br />"
        . " les frais de livraison de vos articles sont entièrement <i><u>gratuits</u></i>.</p>";
    }
}