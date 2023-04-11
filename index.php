<?php
include("global/config.php");
include("global/conexion.php");
include("carrito.php");
include("templates/cabecera.php");
?>

<br>
<?php if ($mensaje != "") { ?>
    <div class="alert alert-success" role="alert">
        <?php echo $mensaje; ?>
        <a href="mostrarcarrito.php" class="badge bg-success">Ver carrito</a>
    </div>
<?php } ?>

<div class="row align-items-center g-2">
    <?php
    $sentencia = $pdo->prepare("SELECT * FROM tblProductos");
    $sentencia->execute();
    $listaProductos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    //print_r($listaProductos);
    ?>

    <?php foreach ($listaProductos as $producto) { ?>
        <div class="col-3">
            <div class="card">
                <img title="<?php echo $producto["nombre"] ?>" class="card-img-top" height="317px" src="<?php echo $producto["imagen"] ?>" alt="<?php echo $producto["nombre"] ?>" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="<?php echo $producto["descripcion"] ?>">
                <div class="card-body">
                    <span><?php echo $producto["nombre"] ?></span>
                    <h4 class="card-title"><?php echo $producto["precio"] ?> €</h4>
                    <form action="" method="post">
                        <input type="hidden" name="id" id="id" value="<?php echo openssl_encrypt($producto["id"], COD, KEY) ?>">
                        <input type="hidden" name="nombre" id="nombre" value="<?php echo openssl_encrypt($producto["nombre"], COD, KEY) ?>">
                        <input type="hidden" name="precio" id="precio" value="<?php echo openssl_encrypt($producto["precio"], COD, KEY) ?>">
                        <input type="hidden" name="cantidad" id="cantidad" value="<?php echo openssl_encrypt(1, COD, KEY) ?>">
                        <button type="submit" class="btn btn-primary" name="btnAccion" value="Agregar" type="submit">Agregar al carrito</button>
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>

</div>

<script>
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));
</script>

<?php
include "templates/pie.php";
?>