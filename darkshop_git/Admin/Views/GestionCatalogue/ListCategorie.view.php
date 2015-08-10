<?php echo $this->flashBag(); ?>
<ul class="tabs">
    <li><a href="GestionCatalogue">Gérer les produits</a></li>
    <li class="here"><a href="GestionCatalogue-ListCategorie">Gérer les catégories</a></li>
</ul>

<div class="tab-content">

    <p class="center"><a href="GestionCatalogue-ajouterCategorie" class="btn btn-primary">Ajouter Categorie</a></p>
    <table class="table-list">
        <thead>
            <tr>
                <th>Ref</th>
                <th>Nom</th>
                <th>Editer</th>
                <th>Suppr.</th>
            </tr>
        </thead>
        <?php
        foreach ($this->data as $value) {
            extract($value);
            ?>
            <tr>
                <td><?php echo $id_categorie ?></td>
                <td><?php echo $nom_categorie ?></td>
                <td><a href="GestionCatalogue-editerCategorie-<?php echo $id_categorie ?>">Editer</a></td>
                <td><a href="GestionCatalogue-supprimerCategorie-<?php echo $id_categorie ?>"><img src="../Resources/img/template/delete.png" alt="" /></a></td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>
