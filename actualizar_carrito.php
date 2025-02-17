<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["index"]) && isset($_POST["cantidad"])) {
    $index = $_POST["index"];
    $cantidad = intval($_POST["cantidad"]);

    if ($cantidad > 0) {
        $_SESSION["carrito"][$index]["cantidad"] = $cantidad;
    } else {
        unset($_SESSION["carrito"][$index]); // Si la cantidad es 0, se elimina el producto
    }
}

// Redirigir de nuevo al carrito
header("Location: carrito.php");
exit();
?>
