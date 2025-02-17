<?php 
session_start();
require_once 'db_conexion.php';
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
require_once('phpqrcode-2010100721_1.1.4/phpqrcode/qrlib.php'); // Incluir la librería PHP QR Code

// Verificar si hay un usuario logueado
if (!isset($_SESSION["nombre"]) || !isset($_SESSION["email"])) {
    echo "<script>
        Swal.fire({
            title: '¡Atención!',
            text: 'Debes iniciar sesión para finalizar la compra.',
            icon: 'warning',
            confirmButtonText: 'Iniciar sesión'
        }).then(() => {
            window.location.href = 'iniciosesion.php';
        });
    </script>";
    exit();
}

$nombre_usuario = $_SESSION["nombre"];
$email_usuario = $_SESSION["email"];

// Verificar si el carrito tiene productos
if (!isset($_SESSION["carrito"]) || empty($_SESSION["carrito"])) {
    echo "<script>
        Swal.fire({
            title: 'Carrito vacío',
            text: 'No tienes productos en el carrito.',
            icon: 'info',
            confirmButtonText: 'Ir a la tienda'
        }).then(() => {
            window.location.href = 'pagusuario.php';
        });
    </script>";
    exit();
}

// Crear un array con la información del pedido
$pedido_info = [
    'nombre_usuario' => $nombre_usuario,
    'email_usuario' => $email_usuario,
    'productos' => []
];

// Añadir los productos al array
$total = 0;
foreach ($_SESSION["carrito"] as $item) {
    $subtotal = $item["cantidad"] * $item["precio"];
    $pedido_info['productos'][] = [
        'producto' => $item["nombre"],
        'cantidad' => $item["cantidad"],
        'precio' => $item["precio"],
        'total' => $subtotal
    ];
    $total += $subtotal;
}

$pedido_info['total'] = $total;  // Agregar el total al array

// Generar el código QR con el JSON
$filename = 'qrcode_' . $nombre_usuario . '.png';

// Convertir el array a JSON para el QR
$pedido_info_json = json_encode($pedido_info, JSON_PRETTY_PRINT);
QRcode::png($pedido_info_json, $filename); // Genera el QR y lo guarda en la carpeta actual

// Guardar los productos en la base de datos
try {
    $cnnPDO->beginTransaction(); // Iniciar transacción
    $fecha_actual = date('Y-m-d H:i:s'); // Obtener la fecha y hora actual

    foreach ($_SESSION["carrito"] as $item) {
        $sql = $cnnPDO->prepare("INSERT INTO pedidos (nombre_usuario, email_usuario, nombre_producto, cantidad, precio, total, fecha, estatus) 
                                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $total_producto = $item["cantidad"] * $item["precio"];
        $estatus = 'Enviado'; // Valor predeterminado para el campo estatus
        $sql->execute([$nombre_usuario, $email_usuario, $item["nombre"], $item["cantidad"], $item["precio"], $total_producto, $fecha_actual, $estatus]);
    }

    $cnnPDO->commit(); // Confirmar la transacción
    $_SESSION["carrito"] = []; // Vaciar el carrito después de la compra

} catch (Exception $e) {
    $cnnPDO->rollBack(); // Revertir cambios si hay error
    echo "<script>
        Swal.fire({
            title: 'Error',
            text: 'Hubo un problema al procesar tu compra.',
            icon: 'error',
            confirmButtonText: 'Intentar de nuevo'
        }).then(() => {
            window.location.href = 'carrito.php';
        });
    </script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .pedido-card {
            max-width: 600px;
            margin: 30px auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .pedido-header {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 15px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .pedido-body {
            padding: 20px;
        }
        .pedido-footer {
            text-align: center;
            padding: 15px;
            background-color: #f1f1f1;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }
        .qr-img {
            max-width: 150px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="imagenes/logop.png" alt="Logo" class="logo" style="width: 90px;">
            </a>
        </div>
        <div class="d-flex ms-auto align-items-center">
            <ul class="navbar-nav d-flex align-items-center">
                

                <li class="nav-item">
                                <a class="nav-link" href="pagusuario.php" >Regresar</a>

                            </li>

            </ul>
        </div>
    </div>
    </nav><br><br><br><br>

<div class="container">
    <div class="card pedido-card">
        <div class="pedido-header">
            <h3>Detalles del Pedido</h3>
        </div>
        <div class="pedido-body">
            <p><strong>👤 Nombre:</strong> <?php echo $nombre_usuario; ?></p>
            <p><strong>📧 Email:</strong> <?php echo $email_usuario; ?></p>

            <h4 class="mt-3">🛍 Productos:</h4>
            <ul class="list-group">
                <?php foreach ($pedido_info['productos'] as $producto): ?>
                    <li class="list-group-item">
                        <strong> <?php echo $producto['producto']; ?></strong>  
                        <br>  Cantidad: <?php echo $producto['cantidad']; ?>  
                        <br>  Precio: $<?php echo number_format($producto['precio'], 2); ?>  
                        <br>  Total: <strong>$<?php echo number_format($producto['total'], 2); ?></strong>
                    </li>
                <?php endforeach; ?>
            </ul>

            <h4 class="mt-3 text-end"><strong> Total: $<?php echo number_format($total, 2); ?></strong></h4>
        </div>
        <div class="pedido-footer">
            <h5> Muestra este codigo QR en la caja para que recibas tu pedido.</h5>
            <img src="<?php echo $filename; ?>" alt="Código QR de Pedido" class="qr-img">
        </div>
    </div>
</div>

</body>
</html>


