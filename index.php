<?php
require_once 'db_conexion.php';

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Papeleria Rivera</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="papeleria.css">
    <link rel="stylesheet" href="form.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" href="imagenes/logop.png" type="image/x-icon">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">


</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg py-sm-2 fixed-top transparent-nav">
        <div class="container-fluid">
            <!-- Logo en el lado izquierdo -->
            <a class="navbar-brand" href="#">
                <img src="imagenes/logop.png" alt="Logo" class="img-fluid logo-large d-none d-md-block">
                <img src="imagenes/logop.png" alt="Logo" class="img-fluid logo-small d-md-none">
            </a>
            <div class="d-flex ms-auto">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#servicio"></a>
                    </li>
                    <div class="d-flex ms-auto">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="#contacto" onclick="abrirFormulario(); return false;">Haz tu pedido.</a>

                            </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mailto:sirmaintenance24@gmail.com" style="color: rgb(255, 255, 255);">
                            <i class="fas fa-envelope icon"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="" style="color: rgb(255, 255, 255);" target="_blank">
                            <i class="fab fa-whatsapp icon"></i>
                        </a>
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
   
    

    <div class="parallax-section">
        <div class="parallax-content">
            <img src="imagenes/eslogan.png" class="fade-in-slide img-fluid " style="margin: 0 auto; width: 900px;" >
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<div class="content">
   



    <div class="container my-5 custom-container">
        <h1 class="title1 slide-in-left"> <br> La mejor papeleria de saltillo.</h1>
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
            <div class="text-section p-3 flex-grow-1 fade-in-slide">
                <p style="text-align: justify;">
                    En nuestra papelería encontrarás todo lo necesario para la escuela, la oficina y tus proyectos creativos. Contamos con una amplia variedad de útiles escolares, material de oficina, artículos de arte y papelería especializada para que siempre tengas lo que necesitas al alcance de tu mano. Además, te ofrecemos productos de la mejor calidad a precios accesibles y un servicio atento que te ayudará a encontrar justo lo que buscas. ¡Visítanos y equipa tu espacio de estudio o trabajo con lo mejor!
                </p>
            </div>


            
            <script>
                function abrirFormulario() {
                    document.getElementById("formOverlay").classList.add("show");
                    document.body.classList.add("show-form"); // Borra el fondo, pero deja la barra lateral visible
                }
            
                function cerrarFormulario() {
                    document.getElementById("formOverlay").classList.remove("show");
                    document.body.classList.remove("show-form");
                }
            </script>
            <script src="app.js"></script>
            <!-- Contenedor del formulario -->
            <div class="form-overlay" id="formOverlay">
                <div class="form-container" >
                    <button class="close-form-btn" onclick="cerrarFormulario()">X</button>
                    <img src="imagenes/logoregis.png" alt="Logo" style="width: 100%;">
                    <form   method="post"  id="registroForm">
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" required>

                        <label for="mensaje">Contraseña:</label>
                        <input type="password" name="password" id="password" rows="4" required></input>

                     <label for="email">Correo:</label>
                        <input type="email" name="email" id="email" required>
                        <a href="iniciosesion.php" class="ya-tienes-cuenta">¿Ya tienes una cuenta?</a>

                        <button type="submit" id="btnRegistrar">Enviar</button>
                        
                        

                    </form>

                </div>
            </div>
        </div>
           <!-- Sección de bienvenida -->
<section class="hero text-center">
    <h1 id="typed-text"></h1>
    <p class="lead">Encuentra todo lo que necesitas en un solo lugar</p>
    
</section>

<!-- Agregar Typed.js -->
<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
<script>
    var typed = new Typed("#typed-text", {
        strings: ["Bienvenido a Papelería Rivera", "Encuentra útiles escolares y de oficina", "Compra fácil y rápido"],
        typeSpeed: 50,
        backSpeed: 30,
        loop: true
    });
</script>

<!-- Estilos CSS -->
<style>
    .hero {
        padding: 80px 0;
        background: linear-gradient(rgba(0, 115, 255, 0.7), rgba(4, 67, 118, 0.8)), url('imagenes/fondoindex.jpg');
        background-size: cover;
        color: white;
    }
    .hero h1 {
        font-size: 2.5rem;
        font-weight: bold;
    }
</style>

    </div>
    <div class="image-container">
    <div class="image-box">
        <a href="#" onclick="abrirFormulario(); return false;">
            <img src="imagenes/pu1.png" alt="Productos Escolares" data-aos="fade-down-right">
        </a>
        <div class="info">
            <h3>Productos Escolares</h3>
            <p>Encuentra una gran variedad de útiles escolares, mochilas, cuadernos y todo lo que necesitas para el regreso a clases.</p>
        </div>
    </div>
    
    <div class="image-box">
        <a href="#" onclick="abrirFormulario(); return false;">
            <img src="imagenes/pu2.png" alt="Productos de Oficina" data-aos="fade-down">
        </a>
        <div class="info">
            <h3>Productos de Oficina</h3>
            <p>Equipamos tu espacio de trabajo con lo mejor: desde plumas y libretas hasta artículos de organización y tecnología.</p>
        </div>
    </div>
    
    <div class="image-box">
        <a href="#" onclick="abrirFormulario(); return false;">
            <img src="imagenes/pu3.png" alt="Recoge tu Pedido" data-aos="fade-down-left">
        </a>
        <div class="info">
            <h3>Recoge tu Pedido con Código QR</h3>
            <p>Realiza tu compra en línea y pasa directamente a caja a recoger tu pedido escaneando tu código QR. ¡Fácil y rápido!</p>
        </div>
    </div>
</div>



    




    


<div class="container my-5 text-center">
    <h1 class="title1 slide-in-left fade-in" > <br>Contamos con las mejores marcas para papeleria.</h1>
</div>
<div class="table-responsive">
    <table>
        <tr>
            <td>
                <div class="img-container fade-in-slide">
                    <img src="imagenes/p1.png" alt="Imagen 1">
                </div>
            </td>
            <td>
                <div class="img-container fade-in-slide">
                    <img src="imagenes/p2.png" alt="Imagen 2">
                </div>
            </td>
            <td>
                <div class="img-container fade-in-slide">
                    <img src="imagenes/p3.png" alt="Imagen 3">
                </div>
            </td>
            <td>
                <div class="img-container fade-in-slide">
                    <img src="imagenes/p4.png" alt="Imagen 4">
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="img-container fade-in-slide">
                    <img src="imagenes/p5.png" alt="Imagen 5">
                </div>
            </td>
            <td>
                <div class="img-container fade-in-slide">
                    <img src="imagenes/p6.png" alt="Imagen 6">
                </div>
            </td>
            <td>
                <div class="img-container fade-in-slide">
                    <img src="imagenes/p7.png" alt="Imagen 7">
                </div>
            </td>
            <td>
                <div class="img-container fade-in-slide">
                    <img src="imagenes/p8.png" alt="Imagen 8">
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="img-container fade-in-slide">
                    <img src="imagenes/p9.png" alt="Imagen 9">
                </div>
            </td>
            <td>
                <div class="img-container fade-in-slide">
                    <img src="imagenes/p10.png" alt="Imagen 10">
                </div>
            </td>
            <td>
                <div class="img-container fade-in-slide">
                    <img src="imagenes/p11.png" alt="Imagen 11">
                </div>
            </td>
            <td>
                <div class="img-container fade-in-slide">
                    <img src="imagenes/p12.png" alt="Imagen 12">
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="img-container fade-in-slide">
                    <img src="imagenes/p13.png" alt="Imagen 13">
                </div>
            </td>
            <td>
                <div class="img-container fade-in-slide">
                    <img src="imagenes/p14.png" alt="Imagen 14">
                </div>
            </td>
            <td>
                <div class="img-container fade-in-slide">
                    <img src="imagenes/p15.png" alt="Imagen 15">
                </div>
            </td>
            <td>
                <div class="img-container fade-in-slide">
                    <img src="imagenes/p16.png" alt="Imagen 16">
                </div>
            </td>
        </tr>
        
    </table>
    

</div>








    





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
<footer class="footer mt-5 py-4  text-white">
    <div class="container">
        <div class="row">
        
            <div class="col-md-4">
                <h5>📍 Sobre Nosotros</h5>
                <p>Somos una papelería comprometida con ofrecer los mejores productos escolares y de oficina a precios accesibles.</p>
            </div>

       
            <div class="col-md-4">
                <h5>🛍️ Nuestros Servicios</h5>
                <ul class="list-unstyled">
                    <li>✏️ Venta de artículos escolares y de oficina</li>
                    <li>📄 Impresiones y fotocopias</li>
                    <li>🎨 Material para arte y manualidades</li>
                    <li>📚 Encuadernaciones y plastificados</li>
                </ul>
            </div>

            <div class="col-md-4">
                <h5>📞 Contáctanos</h5>
                <p><i class="fas fa-map-marker-alt"></i> Dirección: Av. Principal #123, Ciudad</p>
                <p><i class="fas fa-phone"></i> Teléfono: +52 55 1234 5678</p>
                <p><i class="fas fa-envelope"></i> Email: contacto@papeleriarivera.com</p>
            </div>
        </div>

        <hr class="bg-light">
        <div class="text-center">
            <h5>Síguenos en Redes Sociales</h5>
            <a href="https://www.facebook.com" target="_blank" class="text-white me-3"><i class="fab fa-facebook fa-2x"></i></a>
            <a href="https://www.instagram.com" target="_blank" class="text-white me-3"><i class="fab fa-instagram fa-2x"></i></a>
            <a href="https://www.twitter.com" target="_blank" class="text-white me-3"><i class="fab fa-twitter fa-2x"></i></a>
            <a href="https://wa.me/+525512345678" target="_blank" class="text-white"><i class="fab fa-whatsapp fa-2x"></i></a>
        </div>

        <div class="text-center mt-3">
            <p>&copy; 2024 Papelería Rivera. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    AOS.init(); // Inicializar AOS
</script>
    

</body>
</html>












