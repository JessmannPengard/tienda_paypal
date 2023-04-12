<?php
print_r($_GET);

/*
include("global/config.php");
$clientID = CLIENTIDPAYPAL;
$secret = SECRETPAYPAL;

$login = curl_init("https://api-m.sandbox.paypal.com/v1/oauth2/token");

curl_setopt($login, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($login, CURLOPT_USERPWD, $clientID . ":" . $secret);
curl_setopt($login, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

$respuesta = curl_exec($login);

$obj_respuesta = json_decode($respuesta);

$accessToken = $obj_respuesta->access_token;

print_r($accessToken);

$venta = curl_init("https://api-m.sandbox.paypal.com/v1/payment/payment/" . $_GET["paymentID"]);
*/
