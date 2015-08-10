<?php

/**
 * Description of ApiShopController
 *
 * @author quentin
 */
class ApiShopController extends Controller {

    public function Unturned($steamid) {

        $data = $this->ApiShopModel->getKitUnturned($steamid);
        //var_dump($data);
        foreach ($data as $key => $val) {

            extract($val);
            echo $steam_client . "_" . $date_commande . "_" . $titre_produit . "_" . $nb_utilisation . ";";
        }
    }

    public function unturnedDec($steamid, $pack) {
        if ($_SERVER['REMOTE_ADDR'] != "188.165.74.180" || $_SERVER['REMOTE_ADDR'] != "188.165.74.181") {
            $pack = strtr($pack, array("__" => " "));
            //  echo $pack;
            $player = $this->ApiShopModel->searchClient($steamid);
            // var_dump($player);

            if ($player[0]["nombre"] != 0) {

                $kit = $this->ApiShopModel->getKitUnturned($steamid, $pack);
                //var_dump($kit);

                foreach ($kit as $val) {
                    if ($val["typeUtilisation_produit"] == 1) {
                        if ($val["typeUtilisation_produit"] < 0) {
                            echo "infinit";
                        } else {

                            $datetime1 = new DateTime($val["date_commande"]);
                            $datetime2 = new DateTime(date("Y-m-d"));
                            $interval = $datetime1->diff($datetime2);
                            if ($interval->format('%a') > 0) {
                                $decrement = $interval->format('%a') - $val["valeurUtilisation_produit"];
                                echo $decrement;
                            } else {
                                echo 'pas de decrement';
                            }
                        }
                    } else {
                        echo "nbutil";
                    }
                    // var_dump($val);
//                 //   var_dump($val);
//                    $datetime1 = new DateTime(date("Y-m-d"));
//                    $datetime2 = new DateTime($kit["date_commande"]);
//
//
//                    $interval = $datetime1->diff($datetime2);
//                    if ($interval->format('%a') < 30) {
//                       echo "on peut debiter";
//                    }
                }
            }
        } else {
            echo "pas bien de tricher, ip enregistré ;)";
        }
    }

}
