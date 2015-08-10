<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ipnController
 *
 * @author quentin
 */
class IpnController extends Controller {


    private function verifOrder($datas) {

        $data = $this->IpnModel->getOrders($data);

        if ($data[0] == 0) {
            file_put_contents('logs/l.txt', 'ok');
            return true;
        } else {
            file_put_contents('logs/l.txt', 'nok');
            return false;
        }
    }

    public function allopass($RECALL) {
        if (!$this->isLogged()) {
            header("Location: Login");
        }

        /* $RECALL = $_GET["RECALL"]; */
        $code = $RECALL;

        if (trim($RECALL) == "") {
            header("Location: Login");
            exit(1);
        }
        // $RECALL contient le code d'accès
        $RECALL = urlencode($RECALL);

        // $AUTH doit contenir l'identifiant de VOTRE document

        $AUTH = urlencode("xxxxx/xxxxxx/xxxxx");
        $r = @file("http://payment.allopass.com/api/checkcode.apu?code=$RECALL&auth=$AUTH");

        // on teste la réponse du serveur

        if (substr($r[0], 0, 2) != "OK") {
            // Le serveur a répondu ERR ou NOK : l'accès est donc refusé

            header("Location: Login");
            exit(1);
        }
        $uid = $_SESSION['token_client'];



        if ($this->verifCode($code) === true) {
            var_dump($code);
            $this->IpnModel->insertCode(array("token_client" => $uid, "code" => $code));

            $dp_ac = $this->IpnModel->getPoint($uid);
            $dp = 300 + $dp_ac;

            $this->IpnModel->UpdateSolde($uid, $dp);
            $this->flashBag(array("Succès", "Votre commande a bien été prise en compte.", 1));
            echo "ok";

            header('Location: catalogue');
        } else {
            echo "nok";
            header('Location: catalogue');
        }

        setCookie("CODE_OK", "1", 0, "/", ".darkgames.fr", false);
    }

    private function getPoint($tokent) {

        $datas = $this->ProfilModel->getProfil(array("token_client" => $_SESSION['token_client'], "id_client" => $_SESSION['id_client']));
        extract($datas);
        if ($point_client == null) {
            $this->points = "0";
        } else {
            $this->points = $point_client;
        }
    }

    private function verifCode($code) {
        $data = $this->IpnModel->getCode($code);
        if ($data[0] == 0) {
            return true;
        } else {
            return false;
        }
    }

}
