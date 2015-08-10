<?php echo $this->flashBag(); ?>
<ul class="tabs">
    <li><a href="GestionCatalogue-ajouterProduit" id="a-Profil">Ajouter un produit</a></li>
    <li class="here"><a href="GestionCatalogue-ajouterCategorie" id="a-Commande">Ajouter une catégorie</a></li>
</ul>
<div class="tab-content">
<form id="form-profil" action="GestionCatalogue-AjouterCategorie-send" method="post">
    <p>
        <label>Nom</label>
        <input type="text" name="nom_categorie" id="nom_categorie" placeholder="">
        
    <p class="jump"><input type="submit" class="btn btn-third" name="envoyer" value="Envoyer"></p>
    </p>
</form>
</div>