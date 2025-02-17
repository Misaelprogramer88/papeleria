<?php
require 'db_conexion.php';

if (isset($_POST['query'])) {
    $search = "%" . $_POST['query'] . "%";

    $sql = $cnnPDO->prepare("
        SELECT id, nombre, descripcion, precio, imagen FROM productosescolares WHERE nombre LIKE ? 
        UNION 
        SELECT id, nombre, descripcion, precio, imagen FROM productosoficina WHERE nombre LIKE ?
    ");
    $sql->execute([$search, $search]);
    $productos = $sql->fetchAll(PDO::FETCH_ASSOC);

    if ($productos) {
        foreach ($productos as $producto) {
            $imagenBase64 = base64_encode($producto['imagen']);
            echo "
            <div class='col-md-4 mb-3'>
                <div class='card shadow-sm' style='cursor:pointer;' 
                     onclick=\"abrirModal({$producto['id']}, '{$producto['nombre']}', '{$producto['descripcion']}', {$producto['precio']}, '{$imagenBase64}')\">
                    <img src='data:image/jpeg;base64,{$imagenBase64}' class='card-img-top' style='height: 150px; object-fit: cover;'>
                    <div class='card-body text-center'>
                        <h6 class='card-title'>" . htmlspecialchars($producto['nombre']) . "</h6>
                        <p class='card-text'><strong>$" . number_format($producto['precio'], 2) . "</strong></p>
                    </div>
                </div>
            </div>";
        }
    } else {
        echo "<p class='text-center'>No se encontraron productos.</p>";
    }
}
?>

