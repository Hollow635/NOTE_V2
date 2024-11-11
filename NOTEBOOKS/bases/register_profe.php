<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Profesores - OK NOTEBOOKS</title>
    <link rel="stylesheet" href="../estilos/register_style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" href="../imagenes/logo.ico">
</head>
<body>

    <form method="post">
        <div class="form-header">
            <img src="../imagenes/OK.png" alt="Logo" class="header-image">
            <h2>Registro de profes</h2>
        </div>

        <div class="input-wrapper">
            <input type="text" name="name" placeholder="Nombre Completo" required="">
        </div>

        <div class="input-wrapper">
            <input type="email" name="email" placeholder="Correo Electronico" required="">
        </div>

        <div class="input-wrapper">
            <input type="password" name="password" id="password" placeholder="Contraseña" required="">
            <i class='bx bx-show-alt' id="toggle-password"></i>
        </div>

        <div class="input-wrapper">
            <!-- Campo para ingresar la clave numérica -->
            <input type="text" name="clave" id="clave" placeholder="Clave Numérica (5-8 dígitos)" pattern="^\d{5,8}$" required="">
        </div>

        <div id="password-requirements" class="password-requirements">
            <ul>
                <li id="length" class="invalid">Al menos 8 caracteres</li>
                <li id="lowercase" class="invalid">Debe contener al menos una letra minúscula</li>
                <li id="number" class="invalid">Debe incluir al menos un número</li>
            </ul>
        </div>

        <input class="btn" type="submit" name="register" value="Enviar">

        <p>Ya tienes un usuario? -> <a href="../bases/login.php" class="create-account">Ingrese aqui</a></p>
        <p>Si es un alumno ingrese en el siguiente enlace -> <a href="../bases/register_alumno.php" class="create-account">Ingrese aqui</a></p>
        <p><a href="../bases/index.php" class="create-account"> <-- Volver al inicio</a></p>

        <a href="../bases/acceso_especial.php" class="acceso-especial">Acceso Especial</a>
    </form>

    <?php
        include("../bases/RegistrarProfe.php");
    ?>
    <script src="../js/script.js"></script>
    <script src="../js/form_animate.js"></script>
</body>
</html>
