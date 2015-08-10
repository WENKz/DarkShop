

<ul class="tabs">
    <li><a href="Statistique">Statistiques</a></li>
</ul>

<div class="tab-content">
    <h3>Panier moyen à vie <?php echo number_format($this->moyen, 2); ?>€</h3>
    <form method="post" class="search-medium" action="Statistique-moyenCommande">
        <p>Rechercher: 
            <input type="text" id="search-min" name="date_moyen" placeholder="Par année">
            <input type="submit" class="btn btn-third-min" value="OK">
        </p>
    </form>
    <?php if(isset($this->moyen)){ echo "Panier moyen recherché: ".$this->moyen."€"; } ?>
    <h3>Les produits les plus vendus par année</h3>
    <form method="post" class="search-medium" action="Statistique-rechercherDate">
        <p>Rechercher: 
            <input type="text" id="search-min" name="date" placeholder="Par année, mois">
            <input type="submit" class="btn btn-third-min" value="OK">
        </p>
    </form>
<?php if(isset($this->topProd)){?>
    <h3>Les produits les plus vendus depuis le début</h3>
    <table class="table-list">
        <thead><tr>
                <th>Produit</th>
                <th>Quantité vendue</th>
                <th>Nombre de commande</th>
            </tr></thead>
        <?php
        foreach ($this->topProd as $key => $value) {
            extract($value);
            ?>

            <tr>
                <td><?php echo $titre_produit ?></td>
                <td><?php echo $total_produit ?></td>
                <td><?php echo $total_commande ?></td>

            </tr>


            <?php
        }
        ?>
    </table>
<?php } if (isset($this->topDate)){?>
    <h3>Les produits les plus vendus cette année (<?php echo date("Y") ?>)</h3>

    <table class="table-list">
        <tr>
            <th>Produit</th>
            <th>Quantité vendue</th>
            <th>Nombre de commande</th>
        </tr><?php
        foreach ($this->topDate as $key => $value) {
            extract($value);
            ?>

            <tr>
                <td><?php echo $titre_produit ?></td>
                <td><?php echo $total_produit ?></td>
                <td><?php echo $total_commande ?></td>

            </tr>


            <?php
        }
        ?>
    </table>
<?php }?>
</div>