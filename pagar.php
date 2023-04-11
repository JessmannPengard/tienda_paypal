<?php
include("global/config.php");
include("global/conexion.php");
include("carrito.php");
include("templates/cabecera.php");
?>

<?php
if ($_POST) {
    $total = 0;
    $SSID = session_id();

    foreach ($_SESSION["CARRITO"] as $indice => $producto) {
        $total += $producto["precio"] * $producto["cantidad"];
    }

    $sentencia = $pdo->prepare("INSERT INTO tblventas VALUES
                (NULL, :clave_transaccion, '', NOW(), :email, :total, 'Pendiente');");
    $sentencia->bindParam(":clave_transaccion", $SSID);
    $sentencia->bindParam(":email", $_POST["email"]);
    $sentencia->bindParam(":total", $total);
    $sentencia->execute();

    echo "TOTAL: " . $total;
}
?>

<?php
include "templates/pie.php";
?>