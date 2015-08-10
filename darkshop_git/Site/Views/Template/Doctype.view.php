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
        <link rel="stylesheet" type="text/css" href="Resources/css/style.css" media="screen" />
    </head>
    <body>
        <div id="max-cont">
            <div id="container" class="center">
               <!-- <div id="logo"><img alt="logo" src="Resources/img/template/logo.jpg" id="logo-img" /></div>-->
                <div id="block-haut-droit">
                    <?php if ($this->isLogged()) { ?>
                        <p>Bienvenue, <?php echo $_SESSION['nom_client']; ?> <br/>
                          
                            <a href="login-deconnexion" class="btn btn-primary">Déconnexion</a>

                            <?php
                            $this->render_action("Profil", "AffichertPoint", $_SESSION["token_client"]);
                           
                        } else {
                            ?>
                        <nav id="menu-login">
                            <ul>
                                <li><a href="Login">Connexion</a></li>
                            </ul>
                        </nav>
                    <?php } ?>
                </div>
                <?php
                // Afficher le nombre d'articles du panier
                if ($this->action == "Rechercher") {
                    $this->render_action("Catalogue", "rechercher");
                }
                // Si aucune recherche, on affiche uniquement la barre de recherche
                else {
                    $this->render(array("Rechercher", "Catalogue"));
                }

                // Lister les catégories de produit
                $this->render_action("Catalogue", "listerCategories");
                echo $this->flashBag();
                echo $this->content;
                ?>
            </div>
        </div>
    </body>
</html>