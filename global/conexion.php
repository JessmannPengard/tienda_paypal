<?php

$servidor = "mysql:dbname=" . DB_NAME . ";host=" . DB_SERVER;

try {
    $pdo = new PDO(
        $servidor,
        DB_USER,
        DB_PASSWORD,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
    );
    echo "<script>alert('Conectado...')</script>";
} catch (PDOException $e) {
    echo "<script>alert('Error de conexión...')</script>";
}
