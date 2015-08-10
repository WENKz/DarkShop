<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
        <!--[if lt IE 9]>
                <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <title>Dark Store - <?php echo $this->title; ?></title>
        <script type="text/javascript" src="Resources/js/libs/jquery.js"></script>
        <?php echo $this->js; ?>
        <link rel="stylesheet" type="text/css" href="../Resources/css/style.css" media="screen" />
    </head>
    <body>
        <div id="max-cont">
            <div id="container">
                <!-- En-tête gauche --> 
                <div id="logo-admin">
                   <!-- <img alt="logo" src="Resources/img/template/logo.jpg" id="logo-img" />-->
                </div>
                <!-- En-tête partie droite --> 
                <?php if ($this->isLogged()) { ?>
                    <div class="menu-login">
                        <p>Bienvenue, <?php echo $_SESSION['nom_employe']; ?></p>
                        <p><a href="login-deconnexion" class="btn btn-primary left">Déconnexion</a></p>
                    </div>
                    <!-- Menu de navigation -->
                    <nav class="menu-small">
                        <ul>
                            <li><a href="GestionCatalogue">Catalogue</a></li>
                            <li><a href="SuiviCommande">Commande</a></li>
                            <li><a href="GestionUtilisateur">Client</a></li>
                        </ul>
                    </nav>
                <?php } else { ?>
                    <div class="menu-login">
                        <nav>
                            <ul>
                                <li><a href="Login">Connexion</a></li>
                            </ul>
                        </nav>
                    </div>
                <?php } ?>
                <div class="jump"></div>
                <?php
                echo $this->flashBag();
                echo $this->content;
                ?>
            </div>
        </div>
    </body>
</html>