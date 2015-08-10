<!--insertion de la recherche-->
<form class='form-search' action = "Catalogue-rechercher" method = "post">
    <p>
        <img src='Resources/img/template/search.png' alt='' /> &nbsp;
        <input id = "search" type = "search" placeholder = "Titre, description, référence..." name = "recherche" /> &nbsp;
        <input class="btn btn-primary" id="search-btn" type = "submit" value = "Rechercher" />
    </p>
</form>
<?php
if ($this->action == "rechercher") {
    if (count($this->data) == 0) {
        echo "<h2>La recherche <i><span style='color:blue;'>" . $this->recherche . "</i> n'a retourné aucun résultat.</h2>";
    } else {
        echo "<h2>Résultat de la recherche <i><span style='color:#F89B0B;'>'" . $this->recherche . "'</span></i></h2>"
        . "<div class='liste'>";
        foreach ($this->data as $resultat) {
       extract($resultat);

        switch ($id_categorie) {
            case "1": $nom_auteur = "Artiste: " . $nom_auteur;
                break;
            case "2": $nom_auteur = "Réalisateur: " . $nom_auteur;
                break;
            case "3": $nom_auteur = "Auteur: " . $nom_auteur;
                break;
            default: $nom_auteur = "Auteur: ".$nom_auteur;
                break;
        }
        // Statut nouveauté
        ($statut_produit == 1) ? $new = "&nbsp;&nbsp;&nbsp; <span class='new'>nouveauté</span><br />" : $new = "";
        // Attribution de l'image par défaut
        (!is_file("Resources/img/catalogue/" . $id_produit . ".jpg")) ? $img = "Resources/img/template/noarticle.png" : $img = "Resources/img/catalogue/" . $id_produit . ".jpg";
        echo '<div class="liste-produit">
            <p class="article-left">' . $new . '<br />'
            . '<a href="catalogue-ficheProduit-' . $id_produit . '">'
            . '<img class="min-img" src="' . $img . '" alt="" /></a><br />
            <a class="btn btn-third" href="commande-acheterArticle-' . $id_produit . '">Acheter</a>
            </p>
            <h3 class="liste-produit-nom"><a href="catalogue-ficheProduit-' . $id_produit . '">' . $titre_produit . '</a></h3>
            <p class="liste-produit-desc">' . $nom_auteur . '</p>
            <p class="liste-produit-desc">Genre: ' . $genre_produit . '</p>
            <p class="liste-produit-desc">' . $description_produit . '</p>
            <p class="liste-produit-info"><i>paru le ' . date("d/m/Y", strtotime($date_edition)) . '</i></p>
            <h3 class="liste-produit-prix"><span class="imp">Prix: ' . $prix_produit . '€</span></h3>
            <p class="liste-produit-stock-ok">En Stock</p>
        </div>';
        }
        echo "</div>";
    }
}