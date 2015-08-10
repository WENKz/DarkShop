<?php

require_once ('LightOpenID.php');

class LoginController extends Controller {

    public $auth;
    public $api = "steamAPI";
    public $openID;

    public function Editer() {
        if (!$this->isLogged()) {
            header("Location: Login");
        }
        $retour = $this->str_limit(array($_POST["email_client"] => "email"));
        $this->errors = $retour;
        // Si il y a des erreurs, on les affiche

        if (count($this->errors) >= 1) {
            $this->render(array("Profil"));
        }
        $edite = $this->ProfilModel->editProfil($_POST);

        header("Location: Profil");
    }

    public function connexion($log = null) {
        $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);

        $this->openID = new LightOpenID('http://' . $_SERVER['HTTP_HOST'] . $uri_parts[0]);


        if ($this->openID->mode == "") {
            if ($log == "login") {
                $this->openID->identity = "http://steamcommunity.com/openid";
                header("Location: {$this->openID->authUrl()}");
            }
            if (!isset($_SESSION['T2SteamAuth'])) {
                $this->login = "<div id=\"SteamAuth-load\">Welcome Guest <a href=\"login-connexion-login\"><img src=\"http://steamcommunity-a.akamaihd.net/public/images/signinthroughsteam/sits_small.png\" width=\"154\" height=\"23\" border=\"0\"></a></div>";
            }
        } elseif ($this->openID->mode == "cancel") {
            echo "User canceled";
        } else {
            if (!isset($_SESSION["T2SteamAuth"])) {
                $_SESSION["T2SteamAuth"] = $this->openID->validate() ? $this->openID->identity : null;
                $_SESSION["T2SteamID64"] = str_replace("http://steamcommunity.com/openid/id/", "", $_SESSION["T2SteamAuth"]);

                if ($_SESSION["T2SteamAuth"] != null) {
                    $Steam64 = str_replace("http://steamcommunity.com/openid/id/", "", $_SESSION["T2SteamAuth"]);
                    $profile = file_get_contents("http://api.steampowered.com/ISteamUser/GetPLayerSummaries/v0002/?key={$this->api}&steamids={$Steam64}");

                    $buffer = fopen("{$Steam64}.json", "w+");
                    fwrite($buffer, $profile);
                    fclose($buffer);
                }
                header("Location: catalogue");
            }
        }
        if (isset($_SESSION["T2SteamAuth"])) {
            $data = $this->LoginModel->checkAccount();

            if ($data[0]["nombre"] == 0) {

                $this->steam = json_decode(file_get_contents("{$_SESSION["T2SteamID64"]}.json"));
                var_dump($data);
                $this->LoginModel->creerCompte(array("prenom" => $this->steam->response->players[0]->personaname, "steam_client" => $this->steam->response->players[0]->steamid));
            } else {
                $this->steam = json_decode(file_get_contents("{$_SESSION["T2SteamID64"]}.json"));

                $this->LoginModel->editProfil(array("prenom_client" => $this->steam->response->players[0]->personaname));
            }
            $data = $this->LoginModel->checkAccount($_SESSION["T2SteamID64"]);
            extract($data[0]);
            $this->setSession(array("id_client" => $id_client, "token_client" => $token_client, "nom_client" => $prenom_client));
            // header("Location: catalogue");
            $this->login = "<div id='login'><a href='login-deconnexion'>logout</a></div>";
        }

        $this->render(array("Login"), array("title" => "Dark Store - Connexion"));
    }

    public function index($log = null) {
        if ($this->isLogged()) {
            header("Location: Profil");
        }
        header("Location: Login-connexion");
    }

    public function setSession($session) {
        //Créer les données de session
        foreach ($session as $key => $value) {
            $_SESSION[$key] = $value;
        }
    }

    public function Deconnexion() {
        unset($_SESSION['id_client']);
        unset($_SESSION['token_client']);
        unset($_SESSION["T2SteamAuth"]);
        unset($_SESSION["T2SteamID64"]);
        header("Location: Catalogue");
    }

}
