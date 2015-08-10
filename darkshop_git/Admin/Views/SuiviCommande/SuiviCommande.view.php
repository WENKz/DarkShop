
<form class="search-medium right">
    <p>
        Rechercher: <input type='search' class="search-admin" name='search' placeholder='Par n° de commande' /> 
        <input type='submit' id="search-btn" class='btn' value='GO' />
    </p>
</form>

<ul class="tabs">
    <li><a href="SuiviCommande-all-1">En attente</a></li>
    <li><a href="SuiviCommande-all-2">Livré</a></li>
</ul>

<div class="tab-content">
<?php
if (count($this->data) == 0) {
    echo "<p>Aucune commande à afficher</p>";
}

//var_dump($this->data);
// Afficher la pagination
foreach ($this->pagin as $page) {
    echo $page;
}

echo "<div class='block'>"
 . "<div class='head'>Suivi des commandes</div>"
 . "<div class='content'>";

// Affichages des commandes
foreach ($this->data as $commande) {
    extract($commande["infos"]);
    extract($commande);
//var_dump($commande);
    echo "<div class='table-commande'>Commande n° " . $id_commande .
    " &nbsp; <span class='more' style='cursor: pointer;' id='more-" . $id_commande . "'>(Afficher +)</span>";

    // Si au moins un article est en rupture de stock pour la commande
    if ($statut_commande == 1 && $stock == false) {
        echo " &nbsp; <span class='info'><i>En attente de réapprovisonnement.</i></span>";
    } else {
        // Lister les possibilités de statut
        echo "&nbsp; Statut: "
        . "<form method='post' style='display: inline;' action='SuiviCommande-changerStatut-" . $id_commande . "-" . $statut_commande . "'>"
        . "<select name='statut_commande'>";
        foreach ($this->statut as $statut => $choix) {
            // Séléctionner le choix par défaut
            ($statut == $statut_commande) ? $s = "selected='selected'" : $s = "";
            echo "<option value='" . $statut . "' " . $s . ">" . $choix . "</option>";
        }
        echo "</select>"
        . " <input type='submit' name='edit_statut' value='Modifier' />"
        . "</form>";
    }
    echo "<br>Date commande: " . $date_commande
    . "<div style='display: none; padding: 1%;' id='a-more-" . $id_commande . "'>";


    // Lister les articles correspondant à la commande
    foreach ($articles as $article) {
        extract($article);
//        var_dump($article);

        echo "<div class='more-article'>"
        . "<img class='min-img' src='../Resources/img/catalogue/" . $id_produit . ".jpg' alt='' />";
        echo "SteamID : <b>$steam_client</b><br/>  Pseudo : <b>$prenom_client</b><br/> <b>" . $titre_produit . "</b> - Ref: C" . $id_categorie . "N" . $id_produit . "<br>"
        . "prix : " . $prix_produit . "Darkpoint<br>";
        echo substr($description_produit, 0, 50) . "...<br>";
        echo "</div>";
    }
    echo "</div>"
    . "</div>";
}

echo "</div>"; echo "</div>";

// Afficher la pagination (x 2)
foreach ($this->pagin as $page) {
    echo $page;
}


