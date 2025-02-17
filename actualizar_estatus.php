<?php
require_once 'db_conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pedido_id = $_POST['pedido_id'];  // El ID del pedido
    $estatus = $_POST['estatus'];  // El nuevo estatus

    // Actualizar el estado del pedido en la base de datos
    $sql = $cnnPDO->prepare("UPDATE pedidos SET estatus = ? WHERE id = ?");
    $sql->execute([$estatus, $pedido_id]);

    // Redirigir a la página de pedidos
    header("Location: pagadmin.php#pedidos");
    exit();
}
?>
