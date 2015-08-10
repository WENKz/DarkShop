<?php echo $this->flashBag(); ?>
<h2 class="center">Créer un compte</h2>
<?php
if ($this->action == "creation") {
    extract($this->fields);
    echo "<div class='error'>";
    foreach ($this->errors as $error) {
        echo $error."<br />";
    }
    echo "</div>";
}
?>
<ul class="tabs">
    <li class="here"><a href="Enregistrement" id="a-Profil">S'enregistrer</a></li>
    <li><a href="Login" id="a-Commande">Connexion</a></li>
</ul>
<div class="tab-content">
    <p>Veuillez renseigner les champs suivants.</p>
<form id="form-profil" method="post" action="Enregistrement-creation">
    <p>
    <label>Email</label> <input type="text" name="email" value="<?php if($this->action == "creation"){ echo $email; } ?>" /><br />
    <label>Mot de passe</label> <input type="password" name="passe" /><br />
    <label>Confirmation</label> <input type="password" name="passe2" /><br />
    <br />
    <label>Nom</label> <input type="text" name="nom" value="<?php if($this->action == "creation"){ echo $nom; } ?>" /><br />
    <label>Prénom</label> <input type="text" name="prenom" value="<?php if($this->action == "creation"){ echo $prenom; } ?>" /><br />
    <label><input type="hidden" name="date_creation" value="<?php echo date("m/d/Y"); ?>" /><br />
    </p>
    <p class="jump"><input type="submit" class="btn btn-third" name="date_creation" value="Valider" /></p>
</form>
</div>
</body>
</html>