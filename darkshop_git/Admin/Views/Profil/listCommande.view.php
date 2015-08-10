<?php
foreach ($this->data as $value) {
    extract($value);
    $prix_produit = number_format($prix_produit, 2);
    ?>
    <div style="border:1px solid black">
        <p>Titre produit: <a href="catalogue-ficheProduit-<?php echo $id_produit ?>"><?php echo $titre_produit ?></a><br/>
        <p>Prix produit unité: <?php echo $prix_produit ?><br/>
        <p>Quantité produit: <?php echo $qte_produit ?><br/>
        <p>Prix total: <?php echo $prix_produit * $qte_produit ?><br/>
        </p>
    </div>
    <?php
}