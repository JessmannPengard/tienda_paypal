<?php
include("global/config.php");
include("global/conexion.php");
include("carrito.php");
include("templates/cabecera.php");
?>

<!-- Include the PayPal JavaScript SDK -->
<script src="https://www.paypal.com/sdk/js?client-id=<?php echo CLIENTIDPAYPAL; ?>&currency=EUR"></script>

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
    $idVenta = $pdo->lastInsertId();

    foreach ($_SESSION["CARRITO"] as $indice => $producto) {
        $sentencia = $pdo->prepare("INSERT INTO tbldetalledeventa VALUES
                (NULL, " . $idVenta . ", :idproducto, :precio, :cantidad, 0);");
        $sentencia->bindParam(":idproducto", $producto["id"]);
        $sentencia->bindParam(":precio", $producto["precio"]);
        $sentencia->bindParam(":cantidad", $producto["cantidad"]);
        $sentencia->execute();
    }

    //echo "TOTAL: " . $total;
}
?>

<div class="p-5 mb-4 bg-light rounded-3 text-center">
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">Paso final</h1>
        <p>Estás a punto de pagar con paypal la cantidad de:</p>
        <h4><?php echo number_format($total, 2); ?> €</h4>
        <!-- Set up a container element for the button -->
        <div id="paypal-button-container"></div>
        <p>Los productos podrán ser descargados una vez se procese el pago.</p>
        <strong>Para aclaraciones contacto@jessmann.com</strong>
    </div>
</div>

<script>
    // Render the PayPal button into #paypal-button-container
    paypal.Buttons({

        style: {
            color: 'blue',
            shape: 'pill',
            label: 'pay',
            height: 40
        },

        payment: function(data, actions) {
            return actions.payment.create()({
                payment: {
                    transactions: [{
                        amount: {
                            total: '<=php echo $total ?>',
                            currency: 'EUR'
                        },
                        description: 'Compra de productos en tienda',
                        custom: '<?php echo $SSID ?>'
                    }]
                }
            });
        },

        // Call your server to set up the transaction
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    reference_id: '<?php echo $SSID ?>#<?php echo openssl_encrypt($idVenta, COD, KEY) ?>',
                    description: 'Compra de productos en tienda',
                    amount: {
                        value: '<?php echo $total ?>',
                        currency: 'EUR'
                    },
                }]

            });
        },

        // Call your server to finalize the transaction
        onApprove: function(data, actions) {
            return actions.order.capture()
                .then(function(details) {
                    console.log("Pago completado");
                    console.log(details);
                    window.location = "verificador.php?referenceId=" + details.purchase_units[0].reference_id;
                });

        }

    }).render('#paypal-button-container');
</script>

<?php
include "templates/pie.php";
?>