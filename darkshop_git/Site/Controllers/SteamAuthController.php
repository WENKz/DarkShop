<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SteamAuthController
 *
 * @author quentin
 */
class SteamAuthController extends Controller {
   public $api = "EDF319AAD304E0AFB6CAFF88B26C54FF";
   public $openID;
   
  public function __construct() {
      $this->openID = new LightOpenID();
  }
  
  public function load(){
      if($this->openID->mode){
         $this->Open->identity = "http://steamcommunity.com/openid";
         header("Location: {$this->openID->authUrl()}");
      }
      if(!isset($_SESSION['T2SteamAuth'])){
          $this->login = "<div id=\"SteamAuth-load\">Welcome Guest <a href=\"login\"><img src=\"http://steamcommunity-a.akamaihd.net/public/images/signinthroughsteam/sits_small.png\" width=\"154\" height=\"23\" border=\"0\"></a></div>";
      }
  }
}
