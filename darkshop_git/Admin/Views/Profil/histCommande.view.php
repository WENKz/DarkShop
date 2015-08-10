<a href="profil">Mon Compte</a>

<?php
foreach ($this->data as $value) {
    extract($value);
    ?>
    <p><a href="profil-produitcommande-<?php echo $id_commande ?>">N°commande : <?php echo $id_commande ?><br/>
        Total Commande : <?php echo number_format($total_commande,2) ?>€ <br/>
        Date Commande : <?php echo $date_commande ?> <br/>
        nom produit : <?php echo $titre_produit ?></a> <br/>


        <?php
    }
    ?>
