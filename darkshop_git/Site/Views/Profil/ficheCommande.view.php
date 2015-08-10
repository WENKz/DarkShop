<h2 class="center">Détails commande</h2>
<ul class="tabs">
    <li><a href="Profil" id="a-Profil">Mon compte</a></li>
    <li class="here"><a href="Profil-Commande" id="a-Commande">Mes commandes</a></li>
</ul>
<div class="tab-content">
    <p><a href="Profil-commande" class="btn btn-primary">Retour<a></p>
                <?php
                foreach ($this->data as $value) {
                    extract($value);
                    $prix_produit = number_format($prix_produit, 2);
                    ?>
                    <div class="liste-produit">
                        <p><img src="Resources/img/catalogue/<?php echo $id_produit; ?>.jpg" width="100" style="float: left;" alt="" /></p>
                        <p>Titre produit: <a href="catalogue-ficheProduit-<?php echo $id_produit ?>"><?php echo $titre_produit ?></a><br/>
                        <p>Prix produit unité: <?php echo $prix_produit ?>€<br/>
                        <p>Quantité commandée: <?php echo $qte_produit ?><br/>
                        <p>Prix total: <?php echo $prix_produit * $qte_produit ?>€<br/>
                        </p>
                    </div>
                    <?php
                }
                ?>
                </div>