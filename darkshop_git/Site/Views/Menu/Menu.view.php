<?php
if ($this->isLogged()) {
    echo "<p>Bienvenue, $machin</p>";
    echo "<form action='connexion-deconnexion'><input type='submit' value='Déconnexion' /></form>";
}
else{
?>
<nav>
    <ul>
        <li>Créer un compte</li>
        <li>Connexion</li>
    </ul>
</nav>

<?php } ?>