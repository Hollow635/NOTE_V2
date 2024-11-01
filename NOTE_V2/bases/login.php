<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Define el conjunto de caracteres para el documento -->
    <meta charset="UTF-8">
    <!-- Configura la vista para dispositivos móviles -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Título de la página que aparecerá en la pestaña del navegador -->
    <title>Iniciar Sesion</title>
    <!-- Enlace a la hoja de estilos CSS para el diseño de la página de inicio de sesión -->
    <link rel="stylesheet" href="../estilos/login_style.css">
    <!-- Enlace a la biblioteca de íconos Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Enlace al ícono que aparecerá en la pestaña del navegador -->
    <link rel="icon" href="../imagenes/logo.ico">
</head>
<body>

    <!-- Formulario de inicio de sesión que envía datos a IniciarSesion.php -->
    <form action="../bases/IniciarSesion.php" method="post">
        <div class="form-header">
            <!-- Imagen de logo en el encabezado del formulario -->
            <img src="../imagenes/OK.png" alt="Logo" class="header-image">
            <h2>Iniciar Sesion</h2> <!-- Título del formulario -->
        </div>

        <!-- Muestra un mensaje de error si existe uno en la URL -->
        <?php if (isset($_GET['error'])): ?>
            <p class="error-message"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>

        <!-- Campo de entrada para el correo electrónico -->
        <div class="input-wrapper"> 
            <input type="email" name="email" placeholder="Correo Electronico" required="">
        </div>

        <!-- Campo de entrada para la contraseña con ícono para mostrar/ocultar -->
        <div class="input-wrapper">
            <input type="password" name="password" id="password" placeholder="Contraseña" required="">
            <i class='bx bx-show-alt' id="toggle-password"></i> <!-- Ícono para mostrar/ocultar contraseña -->
        </div>

        <!-- Enlace para recuperar la contraseña en caso de haberla olvidado -->
        <p><a href="new_password.php" class="create-account">Olvidaste la contraseña?</a></p>

        <!-- Botón para enviar el formulario de inicio de sesión -->
        <input class="btn" type="submit" name="register" value="Iniciar Sesion">

        <!-- Enlaces para registrarse como alumno o profesor -->
        <p><a href="../bases/register_alumno.php" class="create-account">Registrarse como alumno</a></p>
        <p><a href="../bases/register_profe.php" class="create-account">Registrarse como profesor</a></p>
    </form>

    <!-- Enlace al script JavaScript para manejar interacciones del formulario -->
    <script src="../js/script.js"></script>
</body>
</html>