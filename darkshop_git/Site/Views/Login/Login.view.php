<?php echo $this->flashBag(); 

?>

<h2 class="center">Connexion à votre espace client</h2>
<ul class="tabs">
    <li class="here"><a href="Login" id="a-Commande">Connexion</a></li>
</ul>
<?php 

?>
<div class="tab-content">
    <p>Veuillez vous identifier:</p>
    <?php echo $this->login;?>
 <?php  /* <form method="post" id="form-profil" action="login-connexion">
        <!--Formulaire à compléter-->
        <p>
            <label>Email</label><input type="email" name="email_client" id="email_client" required /><br />
            <label>Mot de passe</label><input type="password" name="passe_client" id="passe_client" required /><br />
            <input type="submit" class="btn btn-third jump" value="Envoyer" />
        </p>
    </form>*/?>
</div>



</body>
</html>