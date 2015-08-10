<form method="POST" action="Statistique-rechercherDate-<?php echo $this->id ?>">
    Rechercher: <input type="text" name="date" placeholder="année ou mois">
    <input type="submit" class="btn btn-third-min" value="GO">
</form>
<?php if (isset($this->topProdu)) {
    if($_POST['date']==""){ echo "<h2>Statistiques des commandes au global</h2>"; }
?>
    <h3>Statistiques produit pour <?php echo htmlspecialchars($_POST['date']); ?></h3>
    <table class="table-list">
        <tr>
            <th>Produit</th>
            <th>Quantité vendue</th>
            <th>Nombre de commande</th>
        </tr><?php
        foreach ($this->topProdu as $key => $value) {
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
<?php
}if(isset($this->topProd)){
?>

<h3>Stats depuis le début</h3>
<table>
    <tr>
        <td>Nom Produit</td>
        <td>Quantité vendu</td>
        <td>Nombre de commande</td>
    </tr><?php
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
<h3>Stats de cet année(<?php echo date("Y") ?>)</h3>

<table>
    <tr>
        <td>Nom Produit</td>
        <td>Quantité vendu</td>
        <td>Nombre de commande</td>
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
<?php }