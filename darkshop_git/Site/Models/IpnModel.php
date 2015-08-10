<?php
if(file_exists("/Site/Pattern/Model.php")){
include_once '/Site/Pattern/Model.php';
}
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IpnModel
 *
 * @author quentin
 */
class IpnModel extends Model {

    public function UpdateSolde($uid, $dp) {
        $this->update("client", array("point_client" => $dp), array("token_client" => $uid));
    }

    public function saveCommande($uid, $payment_amount, $data) {
        $this->insert("orders", array("token_client" => $uid, "amount" => $payment_amount, "created" => "NOW()", "datas" => $data),true);
    }

    public function getOrders($data) {
        $query = $this->select("orders", array("*"), array("datas" => $data), array("1"));
        return $query;
    }

    public function getCode($code) {
        $query = $this->select("allopass", array("*"), array("code" => $code), array("1"));
        return $query;
    }
    
    public function insertCode($values){
        $this->insert("allopass", $values,true);
        
    }
    public function getPoint($uid){
         extract($uid);
        $query = $this->select("client", array("*"), array("token_client" => $uid));

        return $query[0]["point_client"];
    }
}
