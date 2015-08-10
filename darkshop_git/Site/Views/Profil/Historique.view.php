
<h2 class="center">Mes commandes</h2>
<ul class="tabs">
    <li><a href="Profil" id="a-Profil">Mon compte</a></li>
    <li class="here"><a href="Profil-Commande" id="a-Commande">Mes commandes</a></li>
</ul>
<div class="tab-content">
    <?php echo $this->flashBag(); ?>
    <div class="liste">
        <?php
        foreach ($this->data as $value) {
            extract($value);
            switch ($value["statut_commande"]) {
                case "1": $this->stats_com = "En préparation";
                    break;
                case "2": $this->stats_com = "prète";
                    break;
                case "3": $this->stats_com = "Expedié";
                    break;
                default:
                    break;
            }
            ?>
            <div class="liste-produit">
                <a href="profil-produitcommande-<?php echo $id_commande ?>">N°commande : <?php echo $id_commande ?><br/>
                    Total Commande : <?php echo number_format($total_commande, 2) ?>€ <br/>
                    Date Commande : <?php echo date("d/m/Y",strtotime($date_commande)); ?> <br/>
                    Statut commande : <?php echo $this->stats_com ?> <br/>
                    
                    <a href="profil-produitcommande-<?php echo $id_commande ?>"" class="btn btn-third">Afficher le détail</a>
            </div>
        <?php } ?>

    </div>
