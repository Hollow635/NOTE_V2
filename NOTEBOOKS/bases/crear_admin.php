<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Administrador</title>
    <link rel="stylesheet" href="../estilos/register_style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" href="../imagenes/logo.ico">
</head>
<body>

    <!-- Encabezado del formulario de registro -->
    <form method="POST" action="../bases/registrar_admin.php">
        <div class="form-header">
            <h2>Registrar Administrador</h2>
        </div>
        
        <div class="input-wrapper">
            <!-- Etiqueta y campo de entrada para el nombre -->
            <input type="text" name="nombre" id="nombre" placeholder="Nombre Completo" required>
        </div>
        
        <div class="input-wrapper">
            <!-- Etiqueta y campo de entrada para el correo electrónico -->
            <input type="email" name="email" id="email" placeholder="Correo Electrónico" required>
        </div>
        
        <div class="input-wrapper">
            <!-- Etiqueta y campo de entrada para la contraseña -->
            <input type="password" name="password" id="password" placeholder="Contraseña" required="">
                <i class='bx bx-show-alt' id="toggle-password"></i>
        </div>

        <div id="password-requirements" class="password-requirements">
            <ul>
                <li>La contraseña debe cumplir los siguientes requisitos: </li>
                <li id="length" class="invalid">Al menos 8 caracteres</li>
                <li id="lowercase" class="invalid">Debe contener al menos una letra minúscula</li>
                <li id="number" class="invalid">Debe incluir al menos un número</li>
            </ul>
        </div>

        <!-- Campo para ingresar la clave de recuperación -->
        <div class="input-wrapper">
            <input type="text" name="clave" id="clave" placeholder="Clave Numérica (5-8 dígitos)" pattern="^\d{5,8}$" required="">
        </div>
        
        <!-- Botón para enviar el formulario -->
        <input class="btn" type="submit" value="Registrar">
        
        <!-- Enlace para volver a la página anterior o al inicio -->
        <p><a href="../bases/index.php" class="create-account">Volver al inicio</a></p>
    </form>

    <script src="../js/script.js"></script>
    <script src="../js/form_animate.js"></script> <!-- Enlace a otro script JavaScript -->
</body>
</html>
