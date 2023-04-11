<?php
session_start();

$mensaje = "";

if (isset($_POST['btnAccion'])) {
    switch ($_POST['btnAccion']) {
        case 'Agregar':
            if (is_numeric(openssl_decrypt($_POST["id"], COD, KEY))) {
                $id = openssl_decrypt($_POST["id"], COD, KEY);
                $mensaje .= "Ok ID correcto " . $id . "<br>";
                if (is_string(openssl_decrypt($_POST["nombre"], COD, KEY))) {
                    $nombre = openssl_decrypt($_POST["nombre"], COD, KEY);
                    $mensaje .= "Ok Nombre correcto " . $nombre . "<br>";
                    if (is_numeric(openssl_decrypt($_POST["precio"], COD, KEY))) {
                        $precio = openssl_decrypt($_POST["precio"], COD, KEY);
                        $mensaje .= "Ok Precio correcto " . $precio . "<br>";
                        if (is_numeric(openssl_decrypt($_POST["cantidad"], COD, KEY))) {
                            $cantidad = openssl_decrypt($_POST["cantidad"], COD, KEY);
                            $mensaje .= "Ok Cantidad correcta " . $cantidad . "<br>";
                            $producto = array(
                                "id" => $id,
                                "nombre" => $nombre,
                                "cantidad" => $cantidad,
                                "precio" => $precio
                            );
                            if (!isset($_SESSION["CARRITO"])) {
                                $_SESSION["CARRITO"][0] = $producto;
                            } else {
                                array_push($_SESSION["CARRITO"], $producto);
                            }
                            $mensaje .= print_r($_SESSION["CARRITO"],true);
                        } else {
                            $mensaje .= "Upsss Cantidad incorrecta" . "<br>";
                        }
                    } else {
                        $mensaje .= "Upsss Precio incorrecto" . "<br>";
                    }
                } else {
                    $mensaje .= "Upsss Nombre incorrecto" . "<br>";
                }
            } else {
                $mensaje .= "Upsss ID incorrecto" . "<br>";
            }
            break;

        case 'Eliminar':

            break;
    }
}
