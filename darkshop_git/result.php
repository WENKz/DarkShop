<?php 
$url = "ipn-allopass";

$p= "-".$_GET["RECALL"];


$url = $url.$p;

header("Location: $url");
?>