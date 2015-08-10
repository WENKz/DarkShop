<h2 class="center">Catalogue</h2>
<?php echo $this->flashBag(); ?>
<ul class="tabs">
    <li class="here"><a href="GestionCatalogue">Gérer les produits</a></li>
    <li><a href="GestionCatalogue-ListCategorie">Gérer les catégories</a></li>
</ul>

<div class="tab-content">

    <p class='center'><a href="GestionCatalogue-ajouterProduit" class="btn btn-primary">Ajouter Produit</a></p>
    <table class="table-list">
        <thead>
            <tr>
                <th>
                    Produit
                </th>
                <th>
                    Titre
                </th>
                <th>
                    DarkPoint
                </th>
                <th>
                    EventPoint
                </th>
                <th>
                    Statut
                </th>
                <th>
                    Type utilisation
                </th>
                <th>
                    Valeur utilisation
                </th>
                <th>
                    Editer
                </th>
                <th>
                    Suppr.
                </th>
            </tr>
        </thead>
        <?php
        foreach ($this->data as $value) {
            extract($value);
            ?>
            <tr>
                <td>
                    <img src="../Resources/img/catalogue/<?php echo $id_produit ?>.jpg" class="min-img" alt="" />
                </td>
                <td>
                    <?php
                    echo "<b>" . $titre_produit . "</b><br />"
                    ?>
                </td>
                <td>
                    <?php echo $prix_produit ?>
                </td>
                <td>
                    <?php echo $prix_ev_produit ?>
                </td>
                <td>
                    <?php echo $statut_produit ?>
                </td>
                <td>
                    <?php if ($typeUtilisation_produit == 1) {
                        echo "Durée";
                    } else {
                        echo "Utilisation";
                    } ?>
                </td>
                <td>
    <?php if ($valeurUtilisation_produit == -1) {
        echo "infinit";
    } else {
        echo $valeurUtilisation_produit;
    } ?>
                </td>
                <td>
                    <a href="GestionCatalogue-editerProduit-<?php echo $id_produit ?>">Editer</a>
                </td>
                <td>
                    <a href="GestionCatalogue-supprimerProduit-<?php echo $id_produit ?>"><img src="../Resources/img/template/delete.png" alt="" /></a>
                </td>
            </tr>

    <?php
}
?>
    </table>
</div>
