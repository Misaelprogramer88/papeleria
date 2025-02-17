<?php
require_once 'db_conexion.php';
session_start();



// Mensaje de éxito o error
$mensaje = '';
$alerta_tipo = '';

$sql = $cnnPDO->prepare("SELECT * FROM pedidos ORDER BY fecha DESC");
$sql->execute();
$pedidos = $sql->fetchAll(PDO::FETCH_ASSOC);

// Verificar si el formulario de producto escolar fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregar_producto_escolar'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];

    // Verificar si se ha subido una imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imagen = $_FILES['imagen'];
        $imagen_binaria = file_get_contents($imagen['tmp_name']);

        // Insertar el producto escolar
        $sql = $cnnPDO->prepare("INSERT INTO productosescolares (nombre, descripcion, precio, imagen) VALUES (?, ?, ?, ?)");
        
        if ($sql->execute([$nombre, $descripcion, $precio, $imagen_binaria])) {
            $mensaje = 'Producto escolar agregado exitosamente.';
            $alerta_tipo = 'success';
        } else {
            $mensaje = 'Error al insertar el producto escolar.';
            $alerta_tipo = 'error';
        }
    } else {
        $mensaje = 'Por favor, sube una imagen válida para el producto escolar.';
        $alerta_tipo = 'error';
    }
}

// Verificar si el formulario de producto de oficina fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregar_producto_oficina'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];

    // Verificar si se ha subido una imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imagen = $_FILES['imagen'];
        $imagen_binaria = file_get_contents($imagen['tmp_name']);

        // Insertar el producto de oficina
        $sql = $cnnPDO->prepare("INSERT INTO productosoficina (nombre, descripcion, precio, imagen) VALUES (?, ?, ?, ?)");
        
        if ($sql->execute([$nombre, $descripcion, $precio, $imagen_binaria])) {
            $mensaje = 'Producto de oficina agregado exitosamente.';
            $alerta_tipo = 'success';
        } else {
            $mensaje = 'Error al insertar el producto de oficina.';
            $alerta_tipo = 'error';
        }
    } else {
        $mensaje = 'Por favor, sube una imagen válida para el producto de oficina.';
        $alerta_tipo = 'error';
    }
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin.css"> <!-- Archivo de estilos personalizados -->
    <link rel="icon" href="imagenes/logop.png" type="image/x-icon">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Función para mostrar la sección correspondiente y ocultar las demás
        function mostrarSeccion(seccion) {
            // Ocultar todas las secciones
            const secciones = ['productosEscolares', 'productosOficina', 'pedidos'];
            secciones.forEach(function(id) {
                document.getElementById(id).style.display = 'none';
            });

            // Mostrar la sección seleccionada
            document.getElementById(seccion).style.display = 'block';
        }

        // Mostrar la primera sección (Productos Escolares) por defecto
        window.onload = function() {
            mostrarSeccion('productosEscolares');
        };
    </script>
</head>
<body>

    <!-- Navbar azul -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="imagenes/logop.png" alt="Logo" class="logo">
            </a>
        </div>
    </nav>

    <div class="container-fluid1">
        <div class="row">
            <!-- Barra lateral izquierda -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="javascript:void(0);" onclick="mostrarSeccion('productosEscolares')">Productos Escolares</a><br>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" onclick="mostrarSeccion('productosOficina')">Productos de Oficina</a><br>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" onclick="mostrarSeccion('pedidos')">Pedidos</a><br>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Configuración</a><br>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="cerrarsesion.php">Cerrar sesión</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Contenido principal -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <!-- Formulario para agregar producto escolar -->
                <div id="productosEscolares" style="display:none;">
                    <h1 class="mt-4">Bienvenido al Panel de Administración</h1>
                    <p>Selecciona una opción del menú lateral para administrar el sitio.</p>

                    <h2 class="mt-4">Agregar Producto Escolar</h2>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio</label>
                            <input type="number" class="form-control" id="precio" name="precio" required>
                        </div>
                        <div class="mb-3">
                            <label for="imagen" class="form-label">Imagen</label>
                            <input type="file" class="form-control" id="imagen" name="imagen" required>
                        </div>
                        <button type="submit" name="agregar_producto_escolar" class="btn btn-primary">Agregar Producto Escolar</button>
                    </form>
                </div>

                <!-- Formulario para agregar producto de oficina -->
                <div id="productosOficina" style="display:none;">
                    <h2 class="mt-4">Agregar Producto de Oficina</h2>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio</label>
                            <input type="number" class="form-control" id="precio" name="precio" required>
                        </div>
                        <div class="mb-3">
                            <label for="imagen" class="form-label">Imagen</label>
                            <input type="file" class="form-control" id="imagen" name="imagen" required>
                        </div>
                        <button type="submit" name="agregar_producto_oficina" class="btn btn-primary">Agregar Producto de Oficina</button>
                    </form>
                </div>
                
                <main class="col-md-9  col-lg-10 px-md-4">
    <div id="pedidos">
        <h1 class="mt-4">Pedidos</h1>
        <p>A continuación se muestran los pedidos realizados en la tienda.</p>

        <!-- Tabla de Pedidos -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Pedido</th>
                    <th>Nombre Usuario</th>
                    <th>Email Usuario</th>
                    <th>Producto</th>
                    <th>Total</th>
                    <th>Fecha</th>
                    <th>Estatus</th>
                    <th>Acción</th> <!-- Columna para actualizar el estatus -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Obtener los pedidos desde la base de datos
                $sql = $cnnPDO->prepare("SELECT * FROM pedidos");
                $sql->execute();
                $pedidos = $sql->fetchAll(PDO::FETCH_ASSOC);

                // Agrupar los pedidos por fecha y mostrar solo una fila por fecha
                $current_date = '';
                $pedido_info = [];
                
                foreach ($pedidos as $pedido) {
                    if ($current_date !== $pedido['fecha']) {
                        if (!empty($pedido_info)) {
                            $total_pedido = 0;
                            echo "<tr>";
                            echo "<td>" . $pedido_info[0]['id'] . "</td>";
                            echo "<td>" . $pedido_info[0]['nombre_usuario'] . "</td>";
                            echo "<td>" . $pedido_info[0]['email_usuario'] . "</td>";
                            
                            echo "<td>";
                            foreach ($pedido_info as $product) {
                                echo "<strong>" . $product['nombre_producto'] . "</strong> | ";
                                echo "Cantidad: " . $product['cantidad'] . " | ";
                                echo "Precio: $" . number_format($product['precio'], 2) . " | ";
                                echo "Total: $" . number_format($product['total'], 2) . "<br>";
                                $total_pedido += $product['total'];
                            }
                            echo "</td>";
                            echo "<td>$" . number_format($total_pedido, 2) . "</td>";
                            echo "<td>" . $current_date . "</td>";

                            // Mostrar el estado del pedido
                            echo "<td>";
                            echo $pedido_info[0]['estatus']; // Mostrar el estatus
                            echo "</td>";

                            // Formulario para actualizar el estatus
                            echo "<td>
                                    <form method='POST' action='actualizar_estatus.php'>
                                        <input type='hidden' name='pedido_id' value='" . $pedido_info[0]['id'] . "'>
                                        <select name='estatus'>
                                            <option value='pendiente' " . ($pedido_info[0]['estatus'] == 'pendiente' ? 'selected' : '') . ">Pendiente</option>
                                            <option value='enviado' " . ($pedido_info[0]['estatus'] == 'enviado' ? 'selected' : '') . ">Enviado</option>
                                            <option value='completado' " . ($pedido_info[0]['estatus'] == 'completado' ? 'selected' : '') . ">Completado</option>
                                        </select>
                                        <button type='submit' class='btn btn-success btn-sm'>Actualizar</button>
                                    </form>
                                  </td>";
                            echo "</tr>";
                        }
                        $current_date = $pedido['fecha'];
                        $pedido_info = [];
                    }
                    $pedido_info[] = $pedido;
                }

                // Mostrar el último grupo de productos si es que queda pendiente
                if (!empty($pedido_info)) {
                    $total_pedido = 0;
                    echo "<tr>";
                    echo "<td>" . $pedido_info[0]['id'] . "</td>";
                    echo "<td>" . $pedido_info[0]['nombre_usuario'] . "</td>";
                    echo "<td>" . $pedido_info[0]['email_usuario'] . "</td>";

                    echo "<td>";
                    foreach ($pedido_info as $product) {
                        echo "<strong>" . $product['nombre_producto'] . "</strong> | ";
                        echo "Cantidad: " . $product['cantidad'] . " | ";
                        echo "Precio: $" . number_format($product['precio'], 2) . " | ";
                        echo "Total: $" . number_format($product['total'], 2) . "<br>";
                        $total_pedido += $product['total'];
                    }
                    echo "</td>";
                    echo "<td>$" . number_format($total_pedido, 2) . "</td>";
                    echo "<td>" . $current_date . "</td>";

                    // Mostrar el estado del pedido
                    echo "<td>" . $pedido_info[0]['estatus'] . "</td>";

                    // Formulario para actualizar el estatus
                    echo "<td>
                            <form method='POST' action='actualizar_estatus.php'>
                                <input type='hidden' name='pedido_id' value='" . $pedido_info[0]['id'] . "'>
                                <select name='estatus'>
                                    <option value='En preparacion' " . ($pedido_info[0]['estatus'] == 'En preparacion' ? 'selected' : '') . ">En preparacion</option>
                                    <option value='Pedido listo' " . ($pedido_info[0]['estatus'] == 'Pedido listo' ? 'selected' : '') . ">Pedido listo</option>
                                    <option value='Completado' " . ($pedido_info[0]['estatus'] == 'Completado' ? 'selected' : '') . ">Completado</option>
                                </select> 
                                <button type='submit' class='btn btn-success btn-sm mt-2'>Actualizar</button>

                            </form>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</main>
                
                
       


                <!-- Mostrar alerta -->
                <?php if (isset($mensaje)): ?>
                    <script>
                        Swal.fire({
                            title: "<?php echo ($alerta_tipo == 'success') ? '¡Éxito!' : 'Hecho'; ?>",
                            text: "<?php echo $mensaje; ?>",
                            icon: "<?php echo $alerta_tipo; ?>",
                            draggable: true,
                            showConfirmButton: false,
                            timer: 3000
                        });
                    </script>
                <?php endif; ?>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mostrar u ocultar formularios según la sección seleccionada
        document.getElementById('productosEscolaresLink').addEventListener('click', function() {
            document.getElementById('productosEscolares').style.display = 'block';
            document.getElementById('productosOficina').style.display = 'none';
        });

        document.getElementById('productosOficinaLink').addEventListener('click', function() {
            document.getElementById('productosOficina').style.display = 'block';
            document.getElementById('productosEscolares').style.display = 'none';
        });
    </script>
</body>
</html>
