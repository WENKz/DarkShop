<?php ?>

<ul class="tabs">
    <li class="here"><a href="GestionCatalogue-ajouterProduit" id="a-Profil">Ajouter un produit</a></li>
    <li><a href="GestionCatalogue-ajouterCategorie" id="a-Commande">Ajouter une catégorie</a></li>
</ul>
<div class="tab-content">

    <form id="form-profil" action="GestionCatalogue-ajouterProduit-send" method="POST" enctype="multipart/form-data">
        <p>
            <label>Titre produit</label> <input type="text" id="titre_produit" name="titre_produit" placeholder="titre produit"required><br />
            <label>Description</label> <textarea type="text" id="description_produit" name="description_produit" placeholder="descritpion produit"required>
            </textarea><br /><br />

            <label> DarkPoint</label> <input type="text" id="prix_produit" name="prix_produit" placeholder="prix darkpoint produit"><br />
            <label>Prix EventPoint</label> <input type="text" id="prix_ev_produit" name="prix_ev_produit" placeholder="prix event produit"><br />

            <label>Statut produit</label> 
            <select id="statut_produit" name="statut_produit">
                <option value="1">Nouveauté</option>
                <option value="2">Disponible</option>
            </select><br /> 
            <label>Catégorie</label> 
            <select id="id_categorie" name="id_categorie">
                <?php
                foreach ($this->data as $value) {
                    extract($value);
                    ?>

                    <option value="<?php echo $id_categorie ?>" value=""><?php echo $nom_categorie ?></option>

                    <?php
                }
                ?>
            </select><br />
            <label>Type d'utilisation </label> 
            <select id="typeUtilisation_produit" name="typeUtilisation_produit">
                <option value="1">Durée (en jours)</option>
                <option value="2">Nombre d'utilisation</option>
            </select><br />
            <label>Valeur Utilisation</label>
            <input type="text" name="valeurUtilisation_produit" placeholder="Valeur d'utilisation"/><strong>(si infinit entrez -1)</strong>
            <br />
            <input type="file" class="btn" name="image_produit" />
        <p>
            <input type="submit" class="btn btn-third" value="Envoyer">
        </p>
    </form>

</div>
</div>
</div>