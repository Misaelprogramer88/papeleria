<?php
session_start();

if (isset($_GET["index"])) {
    $index = $_GET["index"];
    unset($_SESSION["carrito"][$index]); // Eliminar producto del carrito
}

// Redirigir de nuevo al carrito
header("Location: carrito.php");
exit();
?>
