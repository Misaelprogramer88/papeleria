<?php
require_once 'db_conexion.php'; // Asegúrate de que la conexión esté funcionando correctamente

header('Content-Type: application/json'); // Asegura que se devuelve JSON

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica que los campos estén presentes
    if (isset($_POST['nombre'], $_POST['password'], $_POST['email'])) {
        $nombre = $_POST['nombre'];
        $password = $_POST['password']; 
        $email = $_POST['email'];

        // Verifica que los campos no estén vacíos
        if (empty($nombre) || empty($password) || empty($email)) {
            echo json_encode(["status" => "error", "message" => "Todos los campos son obligatorios"]);
            exit;
        }

        try {
            // Verificar si el email ya existe en la base de datos
            $stmt = $cnnPDO->prepare("SELECT * FROM clientes WHERE email = ?");
            $stmt->execute([$email]);
            $existingEmail = $stmt->fetch();

            if ($existingEmail) {
                // Si el email ya está registrado, devolvemos un error
                echo json_encode(["status" => "error", "message" => "El correo electrónico ya está registrado."]);
                exit;
            }

            // Preparar la consulta de inserción
            $sql = $cnnPDO->prepare("INSERT INTO clientes (nombre, password, email) VALUES (?, ?, ?)");

            // Ejecutar la consulta
            if ($sql->execute([$nombre, $password, $email])) {

                // Configurar el correo
                $subject = "Confirmación de Registro";
                $message = "
                    <html>
                    <head>
                        <title>Bienvenido a Papeleria Rivera $nombre</title>
                    </head>
                    <body style='background-image: url(\"https://plus.unsplash.com/premium_photo-1701760184909-6667c83edcd4?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8Zm9uZG8lMjBhYnN0cmFjdG8lMjBhenVsfGVufDB8fDB8fHww\"); background-size: cover; color: #fff; font-family: Arial, sans-serif; padding: 20px;'>
                        <div style='background-color: rgba(0, 0, 0, 0.5); padding: 30px; border-radius: 10px; margin: 20px auto; width: 80%; text-align: center;'>
                        <p style='color: #fff; font-size: 2rem;'>Papeleria Rivera.</p>    
                        <p style='color: #fff; font-size: 1rem;'>El rincón de la creatividad.</p>
                            <p style='color: #fff; font-size: 1rem;'>¡Bienvenido, $nombre!</p>
                            <p style='color: #fff; font-size: .6rem;'>Gracias por registrarte ahora puedes empezar a comprar.</p>
                        </div>
                    </body>
                    </html>
                ";

                // Para enviar un correo HTML, debe establecerse el encabezado Content-type
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                // Encabezados adicionales
                $headers .= "From: Papeleria Rivera <no-reply@tusitio.com>" . "\r\n";
                $headers .= "Reply-To: contacto@tusitio.com" . "\r\n";

                // Enviar el correo
                if (mail($email, $subject, $message, $headers)) {
                    echo json_encode(["status" => "success", "message" => "Registro Exitoso y correo enviado"]);
                } else {
                    echo json_encode(["status" => "warning", "message" => "Registro exitoso, pero el correo no se pudo enviar"]);
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Error al insertar datos en la base de datos."]);
            }
        } catch (PDOException $e) {
            // Manejo de excepciones y errores de la base de datos
            echo json_encode(["status" => "error", "message" => "Error en la base de datos: " . $e->getMessage()]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Faltan datos."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Solicitud no válida."]);
}
?>


