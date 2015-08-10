<h2 class='center'>Nouveautés</h2>
<?php
echo "<div id='nouveautes'>";
foreach ($this->articles as $article) {
    extract($article);
    ($typeUtilisation_produit == 1) ? $util = $valeurUtilisation_produit . " Jours" : $util = $valeurUtilisation_produit . " Utilisations";
    ($util == "-1 Jours") ? $util = "infinit" : $util = $util;

    (!is_file("Resources/img/catalogue/" . $id_produit . ".jpg")) ? $img = "Resources/img/template/noarticle.png" : $img = "Resources/img/catalogue/" . $id_produit . ".jpg";
    echo "<div class='nouveaute-accueil'>
        <h2 class='center min'><a href='catalogue-ficheProduit-" . $id_produit . "'>" . $titre_produit . "</a></h2>";
    echo "<p><a href='catalogue-ficheProduit-" . $id_produit . "'><img class='large-img' src='" . $img . "' alt='' /></a></p>";
    echo '<p class="liste-produit-desc">' . $description_produit . '<br/>Type Utilisation :<strong> ' . $util . "</strong></p>";
    if ($prix_produit != NULL || $prix_produit != 0) {
        echo "<h3>Prix: " . $prix_produit . " DarkPoints</h3>";
    }
    if ($prix_ev_produit != NULL || $prix_ev_produit != 0) {
        echo "<h3>Prix: " . $prix_ev_produit . " DarkEvents</h3>";
    }
    if ($prix_produit != NULL || $prix_produit != 0) {
        echo "<a class='btn btn-second' href='commande-acheterArticle-" . $id_produit . "-point' class='btn'>Acheter en DarkPoints</a>";
    }

    if ($prix_ev_produit != NULL || $prix_ev_produit != 0) {
        echo "<a class='btn btn-second' href='commande-acheterArticle-" . $id_produit . "-event' class='btn'>Acheter en DarkEvents</a>";
    }
    echo "</div>";
}
echo "</div>";
?>