<?php
//    echo $this->flashBag();
// Page de validation de commande
if ($this->action == "valider") {
    echo "<h3><img src='Resources/img/template/shop.png' alt='' /> &nbsp;Régler la commande (" . $this->nb . " article(s))</h3>";

    // Si il y a des erreurs, on les affiche
    if (isset($this->errors) && count($this->errors) >= 1) {
        echo "<div class='error'>";
        foreach ($this->errors as $error) {
            echo $error . "<br />";
        }
        echo "</div>";
    }

    if (isset($this->panier) && count($this->panier) >= 1) {
//            En-tête du tableau
        echo "<table class='table-list'>"
        . "<tr><th>Produit</th>"
        . "<th>Description</th>"
        . "<th>Prix unité</th>"
        . "<th>Qté</th>"
        . "<th>Total</th>"
        . "<th>Suppr.</th>"
        . "</tr>";

        foreach ($this->panier as $article) {
            extract($article);
            echo "<tr><td>Ref: " . $id_produit . "<br /><img class='medium-img' src='Resources/img/catalogue/" . $id_produit . ".jpg' alt='' />"
            . "</td><td><h3 class='min'><a href='catalogue-ficheProduit-" . $id_produit . "'> " . $titre_produit . "</a></h3>"
            . "<p class='min'>Artiste: ".$nom_auteur."<br />"
            . "Genre: ".$genre_produit."<br />"
            . "Paru le ".date("d/m/Y", strtotime($date_edition)) ."<br />"
            . "<td>" . $prix_produit . "€</td>"
            . "</td><td><p>Qté: x " . $qte_produit["qte"] . "</p>
            <div class = 'btns-qte'>
            <a href = 'commande-mettreAJourQte-" . $id_produit . "-moins' > - </a>"
            . " <a href = 'commande-mettreAJourQte-" . $id_produit . "-plus' > + </a>
            </div>
            </td><td>" . $prix_produit * $qte_produit["qte"] . "€</td>
            </td><td><a href='Commande-supprimerArticle-" . $id_produit . "'><img src='Resources/img/template/delete.png' alt='' /></a></td>"
            . "</tr>";
        }
        echo "<tr><td colspan='6' class='align-r'>Montant total de la commande: " . $this->total . "€ TTC &nbsp;</td>";
        echo "</table>";
        // Si traitement d'une commande

        if ($this->islogged()) {
            echo '<a class="btn btn-primary" href="Commande-viderPanier">Vider le panier</a>';
            extract($this->adresse[0]);
            ?>
            <div class="block">
                <div class="head"><b>Livraison</b></div>
                <div class="content">
                    <div class="col">
                        <h3>Adresse de livraison</h3>
                        <p>Livrer à mon adresse habituelle : <br>
                            <?php echo $adresse_client . "<br>" . $ville_client . ", " . $pays_client; ?>
                        </p>
                        <form method="post" action="Commande-valider">
                            <p>Ou livrer à une autre adresse (renseignez) :<br>
                                <input type="text" name="adr_autre" class="medium-input" />
                            </p>
                    </div>
                    <div class="col">
                        <h3>Paiement</h3>
                        <p>Date de livraison estimée: le <?php echo $this->date; ?></p>
                        <p>Mode de paiement:
                            <select name="type_carte">
                                <option value="1">Visa</option>
                                <option value="2">Master Card</option>
                            </select>
                        </p>
                        <p>Saisissez le n° de carte: <input type="text" name="num_carte" value="" /></p>
                        <p>Date d'expiration (dd/mm/yyyy): <input type="text" size="10" name="date_exp" /></p>
                        <p><input type='submit' class="btn btn-third" name='valider' value='Valider le panier' /></p>
                        </form>
                    </div>
                    <div class="jump"></div>
                </div>
                <?php
            } else {
                echo "<p class='error'>Veuillez <a href='Enregistrement'><b>créer un compte</b></a> ou vous <a href='Login'><b>identifier</b></a> pour finaliser votre commande.</p>";
            }
        } else {
            echo "<p>Panier vide</p>";
        }
    } else {
        echo "<p class='panier'><img src='Resources/img/template/shop.png' alt='' /> <a href='Commande'>Panier (" . $this->nb . ")</a></p>";
    }
    ?>
</div>