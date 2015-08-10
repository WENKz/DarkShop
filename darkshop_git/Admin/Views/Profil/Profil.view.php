<?php extract($this->data); ?>
<h2>Votre Profil</h2>
<a href="profil-commande">Voir historique de commande</a>
<form method="post" action="profil-editer">
    <!--Formulaire à compléter-->
    <p> <?php echo $nom_client ?><br/>
        <?php echo $prenom_client ?> <br/>
        <input type="email" name="email_client" id="email_client" value="<?php echo $email_client ?>" /><br/>
        <input type="text" name="adresse_client" id="adresse_client" value="<?php echo $adresse_client ?>" /><br/>
        <input type="text" name="ville_client" id="ville_client" value="<?php echo $ville_client ?>" /><br/>
        <input type="text" name="cp_client" id="cp_client" value="<?php echo $cp_client ?>" /><br/>
        <input type="text" name="pays_client" id="pays_client" value="<?php echo $pays_client ?>" /><br/>

        <button type="submit">Envoyer</button>
</form>
</div>
</body>
</html>