<?php
extract($this->data);
foreach ($this->data as $val) {
    extract($val);
    ?>

    <form action="GestionCatalogue-editerCategorie-<?php echo $id_categorie ?>-send" method="POST">

        <input type="text" id="nom_categorie" name="nom_categorie" value="<?php echo $nom_categorie ?>"placeholder="nom nom_categorie"required>

        <input type="submit" value="envoyer">
    </form>
<?php
}