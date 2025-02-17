<?php
session_start();
require 'cdn.html';
require 'db_conexion.php';
$error = false;

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password']; 

    $select = $cnnPDO->prepare('SELECT * from clientes WHERE email =? and password=?');
    $select->execute([$email, $password]);
    $count = $select->rowCount();
    $campo = $select->fetch();

    if ($count) {    
        $_SESSION['nombre'] = $campo['nombre'];
        $_SESSION['email'] = $campo['email'];
        $_SESSION['password'] = $campo['password'];
    
        
        if ($email === 'admin@gmail.com' && $password === '123') {
           
            header('Location: pagadmin.php');
        } else {
            
            header('Location: pagusuario.php');
        }
        exit();
    } else {
        $error = true;
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Papeleria Rivera</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="stylesheet" href="iniciosesion.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" href="imagenes/logop.png" type="image/x-icon">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
</head>
<body>
    <!-- Navbar -->
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
        <div class="table-container">
  <table style="width: 47%; height: 300px;">
    <tr>
        <td>
            <img src="imagenes/imginiciosesion.png" width="100%" height="100%" style="margin-top: 15px; margin-left: 20px;" >
        </td>
    </tr> 
  
    <tr>
        <td>
                
        <div class="container mt-5">
                    <div style="width: 300px;"> 
                      
                        <form class="formulario-con-borde" style="padding: 30px;" action="" method="post" >
                        <h1 style="margin-left: 0px;margin-top: 20px;">Inicio de sesion</h1>
                        
                        
                            <div class="mb-3"style="margin-top: 40px;">
                                <label class="form-label"style="font-size: 20px;">Correo Electronico</label><br><br>
                                <input type="text" class="form-control" name="email" placeholder="Introduce tu correo electronico" >
                            </div>
                            <div class="mb-3"style="margin-top: 40px;">
                                <label class="form-label"style="font-size: 20px;">Contraseña</label><br><br>
                                <input type="password" class="form-control" name="password" placeholder="Introduce tu contraseña" >
                            </div>
                            <?php if ($error): ?>
                            <div class="alert alert-danger" role="alert">
                                Correo electrónico o contraseña incorrectos.
                            </div>
                        <?php endif; ?>
                        
                            <br>
                            <a href="index.php" class="no-tienes-cuenta">¿No tienes una cuenta?</a>
                            <br><br><br><br>
                            

                           
      
                            <button type="submit" name="login" class="btn btn-primary botonpagar" style="font-size: 20px;width:60%;  margin-left: 30px;">Iniciar sesion</button>
                        </form>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>



   
    </body>
    </html>