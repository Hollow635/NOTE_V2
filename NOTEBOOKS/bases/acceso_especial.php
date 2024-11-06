<!-- acceso_especial.php -->
<!-- Script en conjunto con otros que permite registrarse como administrador -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Especial</title>
    <link rel="stylesheet" href="../estilos/register_style.css"> <!-- Estilo del formulario -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'> <!-- Iconos de Boxicons -->
    <link rel="icon" href="../imagenes/logo.ico"> <!-- Icono de la página -->
</head>
<body>
    <div class="form-container">
        <!-- Formulario para ingresar la contraseña de acceso especial -->
        <form method="POST" action="../bases/acceso_especial.php">
            <h2>Acceso Especial</h2> <!-- Título del formulario -->
            <div class="input-wrapper">
                <input type="password" name="password" id="password" placeholder="Contraseña" required=""> <!-- Campo para la contraseña -->
                <i class='bx bx-show-alt' id="toggle-password"></i> <!-- Icono para mostrar/ocultar la contraseña -->
            </div>
            <input class="btn" type="submit" name="register" value="Acceder"> <!-- Botón para enviar el formulario -->
        </form>
        
        <?php
        // Verifica si el formulario ha sido enviado mediante el método POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $password = $_POST['password']; // Obtiene la contraseña ingresada

            // Compara la contraseña ingresada con la contraseña esperada
            if ($password === 'Sarmiento') {  // Si deseas cambiar la contraseña, modifica el texto entre comillas
                header("Location: ../bases/crear_admin.php"); // Redirige a la página para crear un usuario
                exit(); // Termina la ejecución del script
            } else {
                // Muestra un mensaje de alerta si la contraseña es incorrecta
                echo "<script>
                alert('Clave de acceso incorrecta. Intente nuevamente o comuníquese con el soporte.');
                window.location.href = '../bases/acceso_especial.php'; // Redirige al mismo formulario
              </script>";
            }
        }
        ?>
    </div>
    <script src="../js/script.js"></script> <!-- Archivo JavaScript para funcionalidad adicional -->
    <script src="../js/form_animate.js"></script> <!-- Enlace a otro script JavaScript -->
</body>
</html>
