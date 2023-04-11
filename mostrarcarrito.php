<?php
include("global/config.php");
include("carrito.php");
include("templates/cabecera.php");
?>

<br>
<h3>Lista del carrito</h3>

<?php if ($mensaje != "") { ?>
    <div class="alert alert-success" role="alert">
        <strong><?= $mensaje ?></strong>
    </div>
<?php } ?>

<?php if (!empty($_SESSION["CARRITO"])) { ?>

    <div class="table-responsive">
        <table class="table table-light table-bordered">
            <thead>
                <tr>
                    <th width="40%" scope="col">Descripción</th>
                    <th width="15%" scope="col">Cantidad</th>
                    <th width="20%" scope="col">Precio</th>
                    <th width="20%" scope="col">Total</th>
                    <th width="5%" scope="col">--</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($_SESSION["CARRITO"] as $indice => $producto) { ?>
                    <tr>
                        <td scope="row"><?php echo $producto["nombre"] ?></td>
                        <td scope="row"><?php echo $producto["cantidad"] ?></td>
                        <td scope="row"><?php echo number_format($producto["precio"], 2, ",", ".") ?></td>
                        <td scope="row"><?php echo number_format($producto["cantidad"] * $producto["precio"], 2, ",", ".") ?></td>

                        <td>
                            <form method="post">
                                <input type="hidden" name="id" id="id" value="<?php echo openssl_encrypt($producto["id"], COD, KEY) ?>">
                                <button class="btn btn-danger" type="submit" value="Eliminar" name="btnAccion">Eliminar</button>
                            </form>
                        </td>

                    </tr>
                <?php
                    $total += $producto["cantidad"] * $producto["precio"];
                } ?>

                <tr>
                    <td colspan="3" align="right">
                        <h3>Total</h3>
                    </td>
                    <td colspan="2" align="right">
                        <h3><?php echo number_format($total, 2, ",", ".") ?></h3>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <form action="pagar.php" method="post">
                            <div class="alert alert-success" role="alert">
                                <div class="mb-3">
                                    <label for="" class="form-label">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Escribe aquí tu email" required>
                                </div>
                                <small id="emailHelp" class="text-muted">Los productos se enviarán a este Email</small>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg btn-block" name="btnAccion" value="Proceder">Proceder a pagar >></button>
                            </div>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

<?php } else { ?>
    <div class="alert alert-success" role="alert">
        <strong>No hay productos en su carrito</strong>
    </div>

<?php } ?>

<?php
include "templates/pie.php";
?>