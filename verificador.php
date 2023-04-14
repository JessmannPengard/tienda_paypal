<?php
include("global/config.php");
include("global/conexion.php");

session_start();
$json = file_get_contents("php://input");
$data = json_decode($json);
$ref_id = $data->datos->purchase_units[0]->reference_id;

$ref_data = explode("#", $ref_id);
$id_Venta =  openssl_decrypt($ref_data[1], COD, KEY);
$status = $data->datos->status;

$total = 0;
$SSID = session_id();
foreach ($_SESSION["CARRITO"] as $indice => $producto) {
    $total += $producto["cantidad"] * $producto["precio"];
}
$totalPaypal = $data->datos->purchase_units[0]->payments->captures[0]->amount->value;

$respuesta = array();
$respuesta["estado"] = $status;

if ($status == "COMPLETED") {
    if ($total == $totalPaypal) {
        $respuesta["pago"] = "completo";
    } else {
        $respuesta["pago"] = "incompleto";
    }
}
$consulta = "UPDATE tblventas SET paypal_datos = :paypalDatos, status = :estado WHERE id = :idVenta;";
$sentencia = $pdo->prepare($consulta);
$sentencia->bindParam(":paypalDatos", $json);
$sentencia->bindParam(":estado", $status);
$sentencia->bindParam(":idVenta", $id_Venta);
$sentencia->execute();

// Vaciamos carrito
unset($_SESSION["CARRITO"]);
unset($_SESSION["idVenta"]);

echo json_encode($respuesta);
