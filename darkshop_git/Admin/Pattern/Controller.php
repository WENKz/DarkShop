<?php
header('Content-Type: text/html; charset=utf-8');
class Controller {

//    protected $model;
    protected $data;
    protected $action;

    public function __construct() {
        // Vérifier si l'employé est identifié pour accéder à l'intranet
        if (!$this->isLogged() && get_class($this) != "LoginController") {
            header("Location: Login");
            exit();
        }
        $this->loadModel(str_replace("Controller", "", get_class($this)));
    }

    protected function isLogged() {
        if (isset($_SESSION['nom_employe']) && isset($_SESSION['id_employe'])) {
            return true;
        }
    }

    protected function loadModel($model) {
        $model .= "Model";
        include_once("Models/" . ucfirst($model) . ".php");
        $this->$model = new $model();
    }

    protected function render($path_view, $template = false) {
//        array("FicheRappel", "Path"), array("Doctype", "js" => "FicheRappel");
        // Si aucun chemin spécifié, chemin par défaut
        if (!isset($path_view[1])) {
            $path_view[1] = $path_view[0];
        }
        // Incorporer une vue dans un template
        if (is_array($template) && isset($template["title"])) {
            // Définir le template par défaut
            if (!isset($template["path"])) {
                $template["path"] = "Doctype";
            }
            // Définir les chemins des ressources par défaut
            $this->css = "<link href='Resources/css/" . $path_view[1] . "/" . $path_view[0] . ".css' type='text/css' rel='stylesheet' media='screen'>" . PHP_EOL;
            $this->js = "<script type='text/javascript' src='Resources/js/" . strtolower($path_view[1]) . "/" . strtolower($path_view[0]) . ".js'></script>" . PHP_EOL;

            // Charger les ressources JS
            if (isset($template["js"])) {
                $this->js = $template["js"];
            }
            // Charger les ressources CSS
            if (isset($template["css"])) {
                $this->css = $template["css"];
            }
            // Incorporer une vue dans un template
            ob_start();
            include_once("Views/" . $path_view[1] . "/" . $path_view[0] . ".view.php");
            $this->content = ob_get_clean();

            $this->title = $template["title"];
            include_once("Views/Template/" . $template["path"] . ".view.php");
        }
        // Appeler une vue classique
        else {
//            var_dump($path_view);
            /* On met include et non include_once, car on peut avoir besoin d'inclure plusieurs fois
             *  la vue sans template */
            include("Views/" . $path_view[1] . "/" . $path_view[0] . ".view.php");
        }
        // Vider le flashbag après avoir rendu la page
        if (isset($_SESSION['message'])) {
            unset($_SESSION['message']);
        }
    }

//    protected function render_action($controlleur, $action, $param = false) {
////        $controller = get_class($this);
//        if (!$param) {
//            $param = "";
//        }
//        $controlleur.="Controller";
//        include_once("./Controllers/" . $controlleur . ".php");
//        $controlleur = new $controlleur();
//        $controlleur->$action($param);
//    }

    protected function render_action($controller, $action, $params) {
        $controller .= "Controller";
        $controller = new $controller();
        call_user_func_array(array($controller, $action), $params);
    }

    /* Renvoyer un système de pagination
     * $infos contient un tableau avec :
     * link => Format du lien à insérer
     * here => N° de la page actuelle
     */

    public function paginate($infos) {
        extract($infos);
        $items = array("<nav class='barre-navigation'><ul>");
        $i = 1;
        // Bouton précédent
        if ($here > 1) {
            $prec = $here - 1;
            array_push($items, "<li><a href='" . $link . $prec . "'>Préc.</a></li>");
        }
        while ($i <= $nb_page) {
            // Différencier la page actuelle des autres pages
            ($i == $here) ? array_push($items, '<li><span>' . $i . '</span></li>') : array_push($items, "<li><a href='" . $link . $i . "'>" . $i . "</a></li>");
            $i++;
        }
        // Bouton suivant
        if ($here < $nb_page) {
            $suiv = $here + 1;
            array_push($items, "<li><a href='" . $link . $suiv . "'>Suiv.</a></li>");
        }
        array_push($items, "</ul></nav>");
        $this->items = $items;
        return $items;
//        $this->render(array("Paginate","Template"),false);
    }

    public function checkFields($checklist, $fields, $write = false) {
        $errors = array();
        extract($fields);
// Vérifier l'existence des champs obligatoires
        foreach ($checklist as $item) {
            if (!isset($$item) || empty($$item)) {
                $$item = "";
                array_push($errors, "Le champ <b>" . ucfirst($item) . "</b> est requis.");
            }
        }
// Retourner les erreurs si il y en a
        if (count($errors) >= 1) {
            if ($write) {
                echo "<div class='error'>";
                foreach ($errors as $err) {
                    echo $err;
                }
                echo "</div>";
// Stopper le script après l'affichage des erreurs
                exit();
            } else {
                return $errors;
            }
        } else {
            return false;
        }
    }

    /*
     * Imposer la longueur, le type ou le format d'un champ
     * Arguments: $champ => nom|min|max|type
     * /!\ si un seul paramètre envoyé, regex possible: 'email'
     * arguments max et type optionnels
     * Types possibles: int(numérique), an(alphanumérique, sans caractère spéciaux)
     */

    protected function str_limit($champs) {
        $errors = array();
        foreach ($champs as $champ => $limits) {
            $len = strlen($champ);
            $nom = "";
            $limits = explode("|", $limits);
            // Si un seul paramètre envoyé, champ-type
            if (count($limits) == 1) {
                // Traiter une adresse email
                if ($limits[0] == "email") {
                    $regex = "#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#";
                    if (!preg_match($regex, $champ)) {
                        array_push($errors, "<b>L'adresse email</b> est incorrecte.");
                    }
                    continue;
                }
            }
            $nom = ucfirst($limits[0]);
            // Si champ min défini
            if ($len < $limits[1]) {
                array_push($errors, "Le champ <b>" . $nom . "</b> doit comporter au moins " . $limits[1] . " caractères.");
            }
            // Si champ maximum défini
            if (isset($limits[2]) && $limits[2] != "false" && $len > $limits[2]) {
                array_push($errors, "Le champ <b>" . $nom . "</b> doit comporter entre " . $limits[1] . " et " . $limits[2] . " caractères.");
            }
            // Si champ type défini
            if (isset($limits[3])) {
                switch ($limits[3]) {
                    case "int":
                        if (!is_numeric($champ)) {
                            array_push($errors, "Le champ <b>" . $nom . "</b> doit être au format numérique.");
                        } break;
                    case "alpha":
                        if (!ctype_alnum($champ)) {
                            array_push($errors, "Le champ <b>" . $nom . "</b> doit être composé uniquement de lettres.");
                        }
                        break;
                    case "an":
                        if (!ctype_alnum($champ)) {
                            array_push($errors, "Le champ <b>" . $nom . "</b> ne doit pas contenir de caractères spéciaux.");
                        }
                        break;
                }
            }
        }
        return $errors;
    }

    protected function flashBag($content = "print") {
        // Si on ajoute des données au flashbag
        if (is_array($content)) {
            $_SESSION['message']['lib'] = $content[0];
            $_SESSION['message']['info'] = $content[1];
            if (!isset($content[2])) {
                $content[2] = "1";
            }
            switch ($content[2]) {
                case "-1": $_SESSION['message']['type'] = "error";
                    break;
                case "1": $_SESSION['message']['type'] = "success";
                    break;
            }
            // Si on demande l'affichage du flashbag
        } else {
            if (isset($_SESSION['message']) && $content == "print") {
                return "<div class='info " . $_SESSION['message']['type'] . "'>" . $_SESSION['message']['info'] . "</div>";
            }
        }
    }

    // Retourner le nom de la classe utilisée
    protected function getName() {
        return str_replace("Controller", "", get_class($this));
    }

    // Récupérer les paramètres passés dans l'url
    protected function getParam($id) {
        $params = explode("/", $_SERVER["REQUEST_URI"]);
        // Récupérer la page et les paramètres
        $page_pos = count($params) - 1;
        $params = $params[$page_pos];
        // Extraire uniquement les paramètres
        $params = explode("-", $params);
        $params = array_slice($params, 2);
        isset($params[$id]) ? $retour = $params[$id] : $retour = 0;
        return $retour;
    }

}
