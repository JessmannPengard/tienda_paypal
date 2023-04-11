<?php
include("global/config.php");
include("global/conexion.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <title>Tienda con Paypal</title>
</head>

<body>

    <nav class="navbar navbar-expand-sm navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Logo de la Empresa</a>
            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php" aria-current="page">Home <span class="visually-hidden">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Carrito(0)</a>
                    </li>
            </div>
        </div>
    </nav>
    <br>
    <div class="container">
        <br>
        <div class="alert alert-success" role="alert">
            Pantalla de mensajes...
            <a href="#" class="badge bg-success">Ver carrito</a>
        </div>

        <div class="row align-items-center g-2">
            <?php
            $sentencia = $pdo->prepare("SELECT * FROM tblProductos");
            $sentencia->execute();
            $listaProductos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            print_r($listaProductos);
            ?>

            <?php foreach ($listaProductos as $producto) { ?>
                <div class="col-3">
                    <div class="card">
                        <img title="<?php echo $producto["nombre"] ?>" class="card-img-top" src="<?php echo $producto["imagen"] ?>" alt="<?php echo $producto["nombre"] ?>" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="<?php echo $producto["descripcion"] ?>">
                        <div class="card-body">
                            <span><?php echo $producto["nombre"] ?></span>
                            <h4 class="card-title"><?php echo $producto["precio"] ?> €</h4>
                            <button type="button" class="btn btn-primary" name="btnAccion" value="Agregar" type="submit">Agregar al carrito</button>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>

    </div>

    <script>
        const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
        const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));
    </script>

</body>

</html>