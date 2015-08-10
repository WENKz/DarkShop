<?php extract($this->data); ?>
<h2 class="center">Mon compte</h2>

<ul class="tabs">
    <li class="here"><a href="Profil" id="a-Profil">Mon compte</a></li>
    <li><a href="Profil-Commande" id="a-Commande">Mes commandes</a></li>
</ul>
<div class="tab-content">
    <form id="form-profil" method="post" action="profil-editer">
        <p>Nom: <?php echo $nom_client . " " . $prenom_client ?><br /><br />
            <label for="email">Email</label> <input type="email" name="email_client" id="email_client" value="<?php echo $email_client ?>" /><br/>
            <label for="password">Mot de passe</label> <input type="password" name="passe_client" id="passe_client" value="<?php echo $passe_client ?>" /><br/>
   </p>
        <button class="btn btn-third" type="submit">Mettre à jour</button>
    </form>
</div>
</body>
</html>