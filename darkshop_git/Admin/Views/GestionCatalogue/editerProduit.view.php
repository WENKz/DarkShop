<?php extract($this->data); ?>

<ul class="tabs">
    <li class="here"><a href="#">Edition produit</a></li>
</ul>

<div class="tab-content">

    <?php
    foreach ($this->data as $val) {
        extract($val);
        ?>
        <form id="form-profil" action="GestionCatalogue-editerProduit-<?php echo $id_produit ?>-send" method="POST" enctype="multipart/form-data">
            <p>
                <label>Titre</label> <input type="text" id="titre_produit" name="titre_produit" value="<?php echo $titre_produit ?>"placeholder="titre produit"required><br/>
            <br />
            <label>Description</label><textarea class="textarea" type="text" id="description_produit" name="description_produit" placeholder="descritpion produit"required>
                <?php echo $description_produit; ?>
            </textarea><br /><br />


            <label>Prix DarkPoints</label> <input type="text" id="prix_produit" name="prix_produit" value="<?php echo $prix_produit ?>"placeholder="prix produit"><br />
            <label>Prix EventPoints</label> <input type="text" id="prix_ev_produit" name="prix_ev_produit" value="<?php echo $prix_ev_produit ?>"placeholder="prix event produit"><br />
            <br />
            <label>Statut du produit</label> 
            <select id="statut_produit" name="statut_produit">
                <option value="1" <?php
                if ($statut_produit == 1) {
                    echo "selected ";
                }
                ?>>Nouveauté</option>
                <option value="2" <?php
                if ($statut_produit == 2) {
                    echo "selected ";
                }
                ?>>Disponible</option>
                <option value="3" <?php
                if ($statut_produit == 3) {
                    echo "selected ";
                }
                ?>>Hors stock</option>
            </select><br />  

            <label>Catégorie</label>
            <select id="id_categorie" name="id_categorie">
                <?php
                foreach ($this->categories as $key => $val) {
                    ?>

                    <option value="<?php echo $val["id_categorie"] ?>"<?php
                    if ($val["id_categorie"] == $id_categorie) {
                        echo "selected ";
                    }
                    ?> value=""><?php echo $val["nom_categorie"] ?></option>

                    <?php
                }
                ?>
            </select><br />
            <label>Type d'utilisation </label> 
            <select id="typeUtilisation_produit" name="typeUtilisation_produit">
                <option value="1" <?php if($typeUtilisation_produit == 1){echo "selected";}?>>Durée (en jours)</option>
                <option value="2"<?php if($typeUtilisation_produit == 2){echo "selected";}?>>Nombre d'utilisation</option>
            </select><br />
            <label>Valeur Utilisation</label>
            <input type="text" name="valeurUtilisation_produit" value="<?php echo $valeurUtilisation_produit?>" placeholder="Valeur d'utilisation"/><strong>(si infinit entrez -1)</strong>
            <br />
            <label>Image</label>
                <img class="min-img" src="../Resources/img/catalogue/<?php echo $id_produit ?>.jpg" alt="<?php echo $titre_produit ?>" title="<?php echo $titre_produit ?>">
                <input type="file" name="image_produit" />
            </p>
                <p class="jump"><input type="submit" class="btn btn-third" value="Envoyer"></p>
        </form>
        <?php }
    ?>
</div>
</div>