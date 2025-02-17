<?php
require_once 'db_conexion.php';
session_start();

// Usa $_SESSION['email'] en lugar de $_SESSION['user_id']
$user_email = $_SESSION['email'] ?? null;

if (!$user_email) {
    header("Location: login.php");
    exit;
}

$sql = $cnnPDO->prepare("SELECT * FROM clientes WHERE email = ?");
$sql->execute([$user_email]);
$user = $sql->fetch(PDO::FETCH_ASSOC);

// Si el usuario no existe, redirigir al login
if (!$user) {
    header("Location: index.php");
    exit;
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Papeleria Rivera</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="stylesheet" href="pagusuario.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" href="imagenes/logop.png" type="image/x-icon">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- AOS CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">



</head>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg py-sm-2 fixed-top transparent-nav">
    <div class="container-fluid">
        <!-- Logo en el lado izquierdo -->
        <a class="navbar-brand" href="#">
            <img src="imagenes/logop.png" alt="Logo" class="img-fluid logo-large d-none d-md-block">
            <img src="imagenes/logop.png" alt="Logo" class="img-fluid logo-small d-md-none">
        </a>

        <!-- Barra de Búsqueda -->
        

        <div class="d-flex ms-auto align-items-center">
            <ul class="navbar-nav d-flex align-items-center">
                <!-- Carrito de Compras -->
                <li class="nav-item me-3">
                    <a href="carrito.php" class="btn btn-light">
                        🛒 (<?php echo isset($_SESSION["carrito"]) ? count($_SESSION["carrito"]) : 0; ?>)
                    </a>
                </li>

                <!-- Imagen de usuario que abre el modal -->
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#pedidosModal">
                        <img src="imagenes/usuario.svg" style="width: 40px; cursor: pointer;">
                    </a>
                </li>

                <!-- Cerrar Sesión -->
                <li class="nav-item">
                    <a class="nav-link" href="cerrarsesion.php">Cerrar sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>








   
    <script>
        window.addEventListener('scroll', function() {
            var navbar = document.querySelector('.navbar');
            if (window.scrollY > 500) {
                navbar.classList.add('solid-nav');
                navbar.classList.remove('transparent-nav');
            } else {
                navbar.classList.add('transparent-nav');
                navbar.classList.remove('solid-nav');
            }
        });

    </script>


<!-- Modal -->
<div class="modal fade" id="pedidosModal" tabindex="-1" aria-labelledby="pedidosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <!-- 🔹 Barra azul con el logo -->
            <div class="modal-header bg-primary text-white d-flex align-items-center">
                <img src="imagenes/logop.png" alt="Logo" style="width: 50px; height: auto; margin-right: 10px;">
                <h5 class="modal-title flex-grow-1 text-center">Mis Pedidos</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Productos</th>
                            <th>Total</th>
                            <th>Estatus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $email_usuario = $_SESSION["email"]; // Obtener el email de la sesión

                        // Obtener los pedidos del usuario
                        $sql = $cnnPDO->prepare("SELECT * FROM pedidos WHERE email_usuario = ? ORDER BY fecha DESC");
                        $sql->execute([$email_usuario]);
                        $pedidos = $sql->fetchAll(PDO::FETCH_ASSOC);

                        $current_date = ''; // Para agrupar por fecha
                        $pedido_info = [];

                        foreach ($pedidos as $pedido) {
                            if ($current_date !== $pedido['fecha']) {
                                if (!empty($pedido_info)) {
                                    echo "<tr>";
                                    echo "<td>" . $current_date . "</td>";
                                    echo "<td>";
                                    foreach ($pedido_info as $producto) {
                                        echo "<strong>" . $producto['nombre_producto'] . "</strong> | ";
                                        echo "Cantidad: " . $producto['cantidad'] . " | ";
                                        echo "Precio: $" . number_format($producto['precio'], 2) . " | ";
                                        echo "Total: $" . number_format($producto['total'], 2) . "<br>";
                                    }
                                    echo "</td>";
                                    echo "<td>$" . number_format($total_pedido, 2) . "</td>";
                                    echo "<td>" . $pedido_info[0]['estatus'] . "</td>";
                                    echo "</tr>";
                                }
                                $current_date = $pedido['fecha'];
                                $pedido_info = [];
                                $total_pedido = 0;
                            }
                            $pedido_info[] = $pedido;
                            $total_pedido += $pedido['total'];
                        }

                        // Mostrar el último grupo de pedidos si es necesario
                        if (!empty($pedido_info)) {
                            echo "<tr>";
                            echo "<td>" . $current_date . "</td>";
                            echo "<td>";
                            foreach ($pedido_info as $producto) {
                                echo "<strong>" . $producto['nombre_producto'] . "</strong> | ";
                                echo "Cantidad: " . $producto['cantidad'] . " | ";
                                echo "Precio: $" . number_format($producto['precio'], 2) . " | ";
                                echo "Total: $" . number_format($producto['total'], 2) . "<br>";
                            }
                            echo "</td>";
                            echo "<td>$" . number_format($total_pedido, 2) . "</td>";
                            echo "<td>" . $pedido_info[0]['estatus'] . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

   
    

    <div class="parallax-section">
        <div class="parallax-content">
        <img src="imagenes/fondousuario.png" class="parallax-img">
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<div class="content">
    <div class="container my-5 custom-container">
        <h1 class="title1 slide-in-left"> <br>Bienvenido, <?php echo $user['nombre']; ?>.</h1>
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
            <div class="text-section p-3 flex-grow-1 fade-in-slide">
                <p style="text-align: justify;">
                    Descubre los increibles precios que nuestra papleria tiene para ti, empieza a comprar y deja volar tu creatividad.
                </p>
            </div>


           


           
            

            

          






            
        </div>
        <div class="image-container">
  
</div>
<video width="100%" autoplay loop muted>
    <source src="imagenes/Coffee Break (1920 x 990 px).mp4" type="video/mp4">
</video>
        
    </div>
    
</div>

<img src="imagenes/productosescolares.png" style="width: 84%; ">




 <?php
// Obtener los productos escolares desde la base de datos
$sql = $cnnPDO->prepare("SELECT * FROM productosescolares");
$sql->execute();
$productos = $sql->fetchAll(PDO::FETCH_ASSOC);
?>


    <div class="container-fluid py-5" style="background-color:rgb(242, 245, 248); border-radius: 10px;">
    <div class="content">
    <form class="d-flex mx-auto" id="searchForm">
            <input class="form-control me-2" type="search" id="searchInput" placeholder="Buscar productos..." aria-label="Buscar">
            <button class="btn btn-outline-light" type="submit">🔍</button>
        </form>
        <div class="container mt-3" id="searchResults" style="display: none;">
    <h4>Resultados de búsqueda:</h4>
    <div class="row" id="resultsContainer"></div>
</div>
<script>
document.getElementById("searchForm").addEventListener("submit", function (e) {
    e.preventDefault(); // Evita que la página se recargue

    let query = document.getElementById("searchInput").value;
    if (query.length < 2) {
        document.getElementById("searchResults").style.display = "none";
        return;
    }

    let formData = new FormData();
    formData.append("query", query);

    fetch("buscar_productos.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById("resultsContainer").innerHTML = data;
        document.getElementById("searchResults").style.display = "block";
    })
    .catch(error => console.error("Error en la búsqueda:", error));
});
</script>

<div>
    <h2 class="text-center mb-4">Productos Escolares</h2>
    <div class="row justify-content-center">
        <?php foreach ($productos as $producto): ?>
            <div class="col-md-4 mb-4" data-aos="fade-up">
                <div class="card shadow-sm">
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($producto['imagen']); ?>" 
                         class="card-img-top" 
                         alt="Imagen del producto" 
                         style="height: 150px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h6 class="card-title"><?php echo htmlspecialchars($producto['nombre']); ?></h6>
                        <p class="card-text"><strong>$<?php echo number_format($producto['precio'], 2); ?></strong></p>
                        
                        <!-- Botón que abre el modal con los datos del producto -->
                        <button class="btn btn-primary" 
                                onclick="abrirModal(<?php echo $producto['id']; ?>, '<?php echo htmlspecialchars($producto['nombre']); ?>', '<?php echo htmlspecialchars($producto['descripcion']); ?>', <?php echo $producto['precio']; ?>, '<?php echo base64_encode($producto['imagen']); ?>')">
                            Comprar
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
    </div>
        

  
<img src="imagenes/productooficina.png" style="width: 85%; ">



    </div>
    <?php
// Obtener los productos de oficina desde la base de datos
$sql = $cnnPDO->prepare("SELECT * FROM productosoficina");
$sql->execute();
$productos_oficina = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container-fluid py-5" style="background-color:rgb(255, 255, 255); border-radius: 10px;">
    <div class="content">

        <h2 class="text-center mb-4">Productos de Oficina</h2>
        <div class="row justify-content-center">
            <?php foreach ($productos_oficina as $producto): ?>
                <div class="col-md-4 mb-4" data-aos="flip-up">
                    <div class="card shadow-sm">
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($producto['imagen']); ?>" 
                             class="card-img-top" 
                             alt="Imagen del producto" 
                             style="height: 150px; object-fit: cover;">
                        <div class="card-body text-center">
                            <h6 class="card-title"><?php echo htmlspecialchars($producto['nombre']); ?></h6>
                            <p class="card-text"><strong>$<?php echo number_format($producto['precio'], 2); ?></strong></p>

                            <!-- Botón que abre el modal con los datos del producto -->
                            <button class="btn btn-primary" 
                                    onclick="abrirModal(<?php echo $producto['id']; ?>, '<?php echo htmlspecialchars($producto['nombre']); ?>', '<?php echo htmlspecialchars($producto['descripcion']); ?>', <?php echo $producto['precio']; ?>, '<?php echo base64_encode($producto['imagen']); ?>')">
                                Comprar
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>


<!-- 🔹 Modal de Bootstrap -->
<div class="modal fade" id="productoModal" tabindex="-1" aria-labelledby="productoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="productoModalLabel">Detalles del Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body text-center">
        <img id="modalImagen" src="" class="img-fluid mb-3" alt="Imagen del producto">
        <h5 id="modalNombre"></h5>
        <p id="modalDescripcion"></p>
        <p><strong>Precio: $<span id="modalPrecio"></span></strong></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btnAgregarCarrito">Agregar al carrito</button>
      </div>
    </div>
  </div>
</div>


<script>
function abrirModal(id, nombre, descripcion, precio, imagen) {
    // Llenamos los datos en el modal
    document.getElementById("modalNombre").innerText = nombre;
    document.getElementById("modalDescripcion").innerText = descripcion;
    document.getElementById("modalPrecio").innerText = precio;
    document.getElementById("modalImagen").src = "data:image/jpeg;base64," + imagen;

    // Guardamos el ID del producto en el botón "Agregar al carrito"
    document.getElementById("btnAgregarCarrito").setAttribute("onclick", `agregarAlCarrito(${id}, '${nombre}', ${precio})`);

    // Mostramos el modal
    var modal = new bootstrap.Modal(document.getElementById('productoModal'));
    modal.show();
}
</script>
<script>
function agregarAlCarrito(id, nombre, precio) {
    // Crear datos para enviar
    let formData = new FormData();
    formData.append("id", id);
    formData.append("nombre", nombre);
    formData.append("precio", precio);

    // Enviar datos con AJAX
    fetch("agregar_carrito.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json()) // Convertir respuesta a JSON
    .then(data => {
        if (data.status === "success") {
            // Ocultar el modal después de agregar al carrito
            var modal = bootstrap.Modal.getInstance(document.getElementById('productoModal'));
            modal.hide();

            // Mostrar una alerta con SweetAlert
            Swal.fire({
                title: "¡Producto agregado!",
                text: "El producto ha sido añadido al carrito.",
                icon: "success",
                timer: 2000,
                showConfirmButton: false
            });
        }
    })
    .catch(error => console.error("Error en AJAX:", error));
}
</script>

<div class="content">


</div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </div>
    

<!-- Asegúrate de incluir Font Awesome en tu <head> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">



<script>
    // Intersection Observer para animar las imágenes al hacer scroll
    document.addEventListener("DOMContentLoaded", function() {
        const images = document.querySelectorAll('.fade-in');

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                    observer.unobserve(entry.target); // Dejar de observar después de que la imagen aparezca
                }
            });
        }, { threshold: 0.1 });

        images.forEach(image => {
            observer.observe(image);
        });
    });
    </script>



    <script>
        // Selecciona todos los elementos con la clase 'fade-in-slide'
const fadeInElements = document.querySelectorAll('.fade-in-slide');

function checkVisibility() {
    fadeInElements.forEach((element) => {
        // Verifica si el elemento está en el viewport
        const rect = element.getBoundingClientRect();
        if (rect.top < window.innerHeight - 100) { // 100px antes de que llegue al viewport completo
            element.classList.add('show');
        }
    });
}

// Ejecuta la función en scroll
window.addEventListener('scroll', checkVisibility);

// Ejecuta la función inicialmente para elementos que ya están visibles
checkVisibility();

    </script>

    <script>
        // Selecciona todos los elementos con la clase 'zoom-in'
const zoomInElements = document.querySelectorAll('.zoom-in');

function checkZoomVisibility() {
    zoomInElements.forEach((element) => {
        // Verifica si el elemento está en el viewport
        const rect = element.getBoundingClientRect();
        if (rect.top < window.innerHeight - 100) { // 100px antes de que entre al viewport completo
            element.classList.add('show');
        }
    });
}

// Ejecuta la función en scroll
window.addEventListener('scroll', checkZoomVisibility);

// Ejecuta la función inicialmente para elementos que ya están visibles
checkZoomVisibility();

    </script>

    <script>
        // Selecciona todos los elementos con la clase 'slide-in-left'
const slideInElements = document.querySelectorAll('.slide-in-left');

function checkSlideVisibility() {
    slideInElements.forEach((element) => {
        // Verifica si el elemento está en el viewport
        const rect = element.getBoundingClientRect();
        if (rect.top < window.innerHeight - 100) { // 100px antes de que entre al viewport completo
            element.classList.add('show');
        }
    });
}

// Ejecuta la función en scroll
window.addEventListener('scroll', checkSlideVisibility);

// Ejecuta la función inicialmente para elementos que ya están visibles
checkSlideVisibility();

    </script>
    <div class="sidebar" id="sidebar">
        
    
        <div class="ad-container">
            <!-- Anuncio 1 -->
            <div class="ad" id="ad1">
                <button class="close-ad" onclick="cerrarAnuncio('ad1')">X</button>
                <a href="https://www.ejemplo1.com" target="_blank">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRblvcqpUryTSZNIsaK9RK4T0ElrJSB1gV8tw&s" alt="Anuncio 1">
                </a>
            </div>
    
            <!-- Anuncio 2 -->
            <div class="ad" id="ad2">
                <button class="close-ad" onclick="cerrarAnuncio('ad2')">X</button>
                <a href="https://www.ejemplo2.com" target="_blank">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ5FASTTcho9WcNAHb49-eP1ZaJeHPt9s1sUw&s" alt="Anuncio 2">
                </a>
            </div>
            <div class="ad" id="ad4">
                <button class="close-ad" onclick="cerrarAnuncio('ad4')">X</button>
                <a href="https://www.ejemplo2.com" target="_blank">
                    <img src="https://www.cinconoticias.com/wp-content/uploads/Anuncios_Mas_Famosos_Nesscafe.jpg" alt="Anuncio 4">
                </a>
            </div>
            <div class="ad" id="ad5">
                <button class="close-ad" onclick="cerrarAnuncio('ad5')">X</button>
                <a href="https://www.ejemplo2.com" target="_blank">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTYqkp6Bdu-VZe4KSjNFT1Vylb94qUyrEj6Kw&s" alt="Anuncio 5">
                </a>
            </div>
    
            <!-- Anuncio 3 -->
            <div class="ad" id="ad3">
                <button class="close-ad" onclick="cerrarAnuncio('ad3')">X</button>
                <a href="https://www.ejemplo3.com" target="_blank">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRwHJQ6OmwdvnCsMfjO4w9ud_LPLDnH_ih2hA&s" alt="Anuncio 3">
                </a>
            </div>
        </div>
    </div>
    
    <script>
        window.addEventListener('scroll', function() {
            var sidebar = document.getElementById('sidebar');
            if (window.scrollY > 500) { 
                sidebar.classList.add('show');
            } else {
                sidebar.classList.remove('show');
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Lista de anuncios
            var ads = document.querySelectorAll(".ad");
    
            function mostrarAnuncio() {
                // Selecciona un anuncio aleatorio
                var randomIndex = Math.floor(Math.random() * ads.length);
                var ad = ads[randomIndex];
    
                // Muestra el anuncio si está oculto
                if (ad.style.display === "none" || ad.style.display === "") {
                    ad.style.display = "block";
                }
            }
    
            function cerrarAnuncio(adId) {
                document.getElementById(adId).style.display = "none";
            }
    
            // Muestra un anuncio aleatorio cada 10 segundos
            setInterval(mostrarAnuncio, 10000);
    
            // Hace que un anuncio aparezca cuando el usuario baja 500px
            window.addEventListener("scroll", function() {
                if (window.scrollY > 500) {
                    mostrarAnuncio();
                }
            });
    
            // Asigna la función de cerrar anuncios a la ventana global
            window.cerrarAnuncio = cerrarAnuncio;
        });
    </script>
 


    

</div>
<img src="imagenes/im2.png" style="width:90%">
<footer class="footer mt-5 py-4  text-white">
    <div class="container">
        <div class="row">
            <!-- Sección de Información -->
            <div class="col-md-4">
                <h5>📍 Sobre Nosotros</h5>
                <p>Somos una papelería comprometida con ofrecer los mejores productos escolares y de oficina a precios accesibles.</p>
            </div>

            <!-- Sección de Enlaces Rápidos -->
            <div class="col-md-4">
                <h5>🛍️ Nuestros Servicios</h5>
                <ul class="list-unstyled">
                    <li>✏️ Venta de artículos escolares y de oficina</li>
                    <li>📄 Impresiones y fotocopias</li>
                    <li>🎨 Material para arte y manualidades</li>
                    <li>📚 Encuadernaciones y plastificados</li>
                </ul>
            </div>

            <!-- Sección de Contacto -->
            <div class="col-md-4">
                <h5>📞 Contáctanos</h5>
                <p><i class="fas fa-map-marker-alt"></i> Dirección: Av. Principal #123, Ciudad</p>
                <p><i class="fas fa-phone"></i> Teléfono: +52 55 1234 5678</p>
                <p><i class="fas fa-envelope"></i> Email: contacto@papeleriarivera.com</p>
            </div>
        </div>

        <!-- Línea divisoria -->
        <hr class="bg-light">

        <!-- Redes Sociales -->
        <div class="text-center">
            <h5>Síguenos en Redes Sociales</h5>
            <a href="https://www.facebook.com" target="_blank" class="text-white me-3"><i class="fab fa-facebook fa-2x"></i></a>
            <a href="https://www.instagram.com" target="_blank" class="text-white me-3"><i class="fab fa-instagram fa-2x"></i></a>
            <a href="https://www.twitter.com" target="_blank" class="text-white me-3"><i class="fab fa-twitter fa-2x"></i></a>
            <a href="https://wa.me/+525512345678" target="_blank" class="text-white"><i class="fab fa-whatsapp fa-2x"></i></a>
        </div>

        <!-- Derechos Reservados -->
        <div class="text-center mt-3">
            <p>&copy; 2024 Papelería Rivera. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>

<!-- Agregar FontAwesome para los íconos -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
<!-- AOS JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    AOS.init(); // Inicializar AOS
</script>


    
    

</body>
</html>












