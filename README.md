DarkShop
========================

Simple boutique PHP avec API,
Unturned, Starmade,Garry's mod,ARK

Le plugin unturned lier au shop est disponible ici https://github.com/WENKz/Unturned_ShopAuto
<br/>Demo: http://boutique.darkgames.fr/

Site officiel
========================
https://darkgames.fr<br/>
http://quentingrisard.fr

Installation ( BETA )
========================

Téléchargez DarkShop, placez le dans votre répertoir WEB
Editez les fichiers Site/Pattern/Model.php et Admin/Pattern/Model.php 
Créez une base donéne et importez créez la base de données a partir du fichier BD.sql
remplacez les differentes informations de connection a la base de donnée
    <pre>
    protected $db;
    protected $dbname = "DarkShop";
    protected $login = "Login";
    protected $pass = "Password";
    </pre>


<br/>
Les API pour rendre la boutique compatible avec un plugin son placé ici : darkshop_git/Site/Controllers/ApiShopController.php<br>
Si vous avez des problèmes contacter moi a l'adresse email suivante:  <a href="mailto:quentin.grisard@gmail.com" title="quentin grisard">quentin[dot]grisard[at]gmail[dot]com</a>

Changelog
========================
0.1.0 : <br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;# Boutique automatique PHP pour unturned, starmade et autre jeux<br/>
