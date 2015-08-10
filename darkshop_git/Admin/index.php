<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
define("WEBROOT", str_replace("index.php", "", $_SERVER['SCRIPT_NAME']));
define("ROOT", str_replace("index.php", "", $_SERVER['SCRIPT_FILENAME']));

require(ROOT . "Pattern/Controller.php");
require(ROOT . "Pattern/Model.php");
if($_GET['page'] == "Admin"){
            header("Location: GestionCatalogue");
}
// Extraction des paramètres GET et définition de la page d'Index
$controller = isset($_GET['page']) ? $params = explode("-", $_GET['page']) : $params[0] = "GestionCatalogue";
// Controlleur
$controller = ucfirst($params[0] . "Controller");
// Action à Emettre
$action = isset($params[1]) ? $action = $params[1] : $action = "index";

if (!empty($controller) && is_file("Controllers/" . $controller . ".php")) {

    require ("Controllers/" . $controller . ".php");
    $controller = new $controller();

    if (method_exists($controller, $action)) {
        $params = array_slice($params, 2);
//        var_dump($params);
        call_user_func_array(array($controller, $action), $params);
    } else {
        require("Views/Template/Error.view.php");
    }
} else {
    require("Views/Template/Error.view.php");
}
