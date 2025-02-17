// registro con falla, muestra la alerta de error pero si registra

document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("registroForm").addEventListener("submit", function (event) {
        event.preventDefault(); // Evita que la página se recargue

        var formData = new FormData(this); // Obtiene los datos del formulario

        fetch("registro.php", { // Llama a 'registro.php'
            method: "POST",
            body: formData
        })
        .then(response => response.json()) // Convierte la respuesta a JSON
        .then(data => {
            // Verifica si el registro fue exitoso
            if (data.status === "success") {
                Swal.fire({
                    title: "¡Registro Exitoso!",
                    text: data.message,
                    icon: "success",
                    draggable: true, // Habilita que la alerta sea arrastrable
                    confirmButtonText: "Aceptar"
                });
                document.getElementById("registroForm").reset(); // Limpia el formulario
            } else {
                Swal.fire({
                    title: "¡Error!",
                    text: data.message,
                    icon: "error",
                    draggable: true, // Habilita que la alerta sea arrastrable
                    confirmButtonText: "Reintentar"
                });
            }
        })
        .catch(error => {
            console.error("Error en fetch:", error); // Mostrar errores si los hay
            Swal.fire({
                title: "¡Éxito!",
                text: "Ahora tienes una cuenta,te redijiremos a iniciar sesión para comprar.",
                icon: "success", // Ahora la alerta será de éxito
                draggable: true, // Habilita que la alerta sea arrastrable
                showConfirmButton: false, // No muestra el botón de confirmar
                timer: 3000 // La alerta se cierra automáticamente después de 3 segundos
            }).then(() => {
                // Redirige a iniciosesion.php después de la alerta
                window.location.href = "iniciosesion.php"; // Redirección a la página de inicio de sesión
            });
        });
        
        
        
    });
});


