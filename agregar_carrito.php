<?php
session_start();
header('Content-Type: application/json'); // Para que AJAX lo interprete como JSON

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $precio = $_POST["precio"];

    // Verificar si el carrito ya está en la sesión
    if (!isset($_SESSION["carrito"])) {
        $_SESSION["carrito"] = [];
    }

    // Verificar si el producto ya está en el carrito
    $encontrado = false;
    foreach ($_SESSION["carrito"] as &$item) {
        if ($item["id"] == $id) {
            $item["cantidad"]++; // Si ya existe, aumentar la cantidad
            $encontrado = true;
            break;
        }
    }

    // Si el producto no está en el carrito, agregarlo
    if (!$encontrado) {
        $_SESSION["carrito"][] = [
            "id" => $id,
            "nombre" => $nombre,
            "precio" => $precio,
            "cantidad" => 1
        ];
    }

    // Respuesta en formato JSON para AJAX
    echo json_encode(["status" => "success", "message" => "Producto agregado al carrito"]);
    exit();
}
?>
