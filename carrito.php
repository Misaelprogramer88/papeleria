<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="fondo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav >
        <div class="container-fluid">
            <!-- Logo en el lado izquierdo -->
            <a class=" navbar navbar-brand" href="index.php">
                <img src="imagenes/logop.png" alt="Logo" class="img-fluid logo-large d-none d-md-block">
                <img src="imagenes/logop.png" alt="Logo" class="img-fluid logo-small d-md-none">
            </a>
           
        </div>
    </nav>
    <div class="wave"></div>

    <br><br><br><br>
    <div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h2 class="text-center mb-4">🛒 Carrito de Compras</h2>

        <?php if (!empty($_SESSION["carrito"])): ?>
            <table class="table table-hover text-center">
                <thead class="table-primary">
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total = 0;
                    foreach ($_SESSION["carrito"] as $index => $item): 
                        $subtotal = $item["precio"] * $item["cantidad"];
                        $total += $subtotal;
                    ?>
                        <tr>
                            <td><strong><?php echo $item["nombre"]; ?></strong></td>
                            <td>$<?php echo number_format($item["precio"], 2); ?></td>
                            <td>
                                <form method="POST" action="actualizar_carrito.php" class="d-flex justify-content-center align-items-center">
                                    <input type="hidden" name="index" value="<?php echo $index; ?>">
                                    <input type="number" name="cantidad" value="<?php echo $item["cantidad"]; ?>" min="1" class="form-control text-center mx-2" style="width: 60px;">
                                    <button type="submit" class="btn btn-sm btn-primary">🔄</button>
                                </form>
                            </td>
                            <td><strong>$<?php echo number_format($subtotal, 2); ?></strong></td>
                            <td>
                                <a href="eliminar_carrito.php?index=<?php echo $index; ?>" class="btn btn-danger btn-sm">❌</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="text-end mt-4">
                <h4 class="bg-light p-3 rounded shadow-sm"><strong>Total: $<?php echo number_format($total, 2); ?></strong></h4>
            </div>

            <div class="text-center mt-4">
                <form action="procesar_compra.php" method="POST" class="d-inline">
                    <button type="submit" class="btn btn-success btn-lg">✅ Finalizar Compra</button>
                </form>
                <a href="pagusuario.php" class="btn btn-secondary btn-lg">🔙 Seguir Comprando</a>
            </div>

        <?php else: ?>
            <div class="alert alert-success text-center">
                <h5>Tu carrito está vacío 😞</h5>
                <p>Agrega productos para verlos aquí.</p>
                <a href="pagusuario.php" class="btn btn-primary">🛍️ Ir a la tienda</a>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
