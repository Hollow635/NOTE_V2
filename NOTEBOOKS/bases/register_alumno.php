<!DOCTYPE html>
<html lang="en"> <!-- Define el lenguaje de la página como inglés -->
<head>
    <meta charset="UTF-8"> <!-- Establece la codificación de caracteres a UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Configura la vista para dispositivos móviles -->
    <title>Registro de Alumnos - OK NOTEBOOKS</title> <!-- Título de la página -->
    <link rel="stylesheet" href="../estilos/register_style.css"> <!-- Enlace a la hoja de estilos -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'> <!-- Enlace a íconos de Boxicons -->
    <link rel="icon" href="../imagenes/logo.ico"> <!-- Ícono de la pestaña -->
</head>
<body>

    <!-- Formulario para el registro de alumnos -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="form-header">
            <img src="../imagenes/OK.png" alt="Logo" class="header-image"> <!-- Logo en el encabezado del formulario -->
            <h2>Registro de alumnos</h2> <!-- Título del formulario -->
        </div>

        <!-- Campo para ingresar el nombre completo -->
        <div class="input-wrapper">
            <input type="text" name="name" placeholder="Nombre Completo" required=""> <!-- Campo obligatorio -->
        </div>

        <!-- Campo para ingresar el correo electrónico -->
        <div class="input-wrapper"> 
            <input type="email" name="email" placeholder="Correo Electronico" required=""> <!-- Campo obligatorio -->
        </div>

        <!-- Campo para ingresar la contraseña -->
        <div class="input-wrapper"> 
            <input type="password" name="password" id="password" placeholder="Contraseña" required=""> <!-- Campo obligatorio -->
            <i class='bx bx-show-alt' id="toggle-password"></i> <!-- Ícono para mostrar/ocultar la contraseña -->
        </div>

        <!-- Campo para ingresar la división del alumno -->
        <div class="input-wrapper"> 
            <input type="text" name="division" id="division" placeholder="Division" required="" oninput="validateDivision()"> <!-- Campo obligatorio -->
        </div>

        <!-- Selector de especialidad, oculto inicialmente -->
        <div class="input-wrapper" id="especialidad-wrapper" style="display:none;"> 
            <select name="especial" id="especial"> <!-- Selector para elegir la especialidad -->
                <option value="" disabled selected>Selecciona tu Especialidad</option> <!-- Opción por defecto -->
                <option value="Computacion">Computacion</option>
                <option value="Construcciones">Construcciones</option>
                <option value="Electricidad">Electricidad</option>
                <option value="Electronica">Electronica</option>
                <option value="Mecanica">Mecanica</option>
                <option value="Quimica">Quimica</option>
            </select>
        </div>

        <div id="password-requirements" class="password-requirements">
            <ul>
                <li>La contraseña debe cumplir los siguientes requisitos: </li>
                <li id="length" class="invalid">Al menos 8 caracteres</li>
                <li id="lowercase" class="invalid">Debe contener al menos una letra minúscula</li>
                <li id="number" class="invalid">Debe incluir al menos un número</li>
            </ul>
        </div>

        <input class="btn" type="submit" name="register" value="Enviar"> <!-- Botón para enviar el formulario -->

        <!-- Enlaces para el acceso a otras secciones -->
        <p>Ya tienes un usuario? -> <a href="../bases/login.php" class="create-account">Ingrese aqui</a></p>
        <p>Si es un profesor ingrese al siguiente enlace -> <a href="../bases/register_profe.php" class="create-account">Ingrese aqui</a></p>
        <p><a href="../bases/index.php" class="create-account">  <--Volver al inicio</a></p>
    </form>

    <?php
        // Incluye el archivo para registrar al alumno si se envía el formulario
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            include("../bases/RegistrarAlumno.php");
        }
    ?>
    <script src="../js/script.js"></script> <!-- Enlace a un script JavaScript -->
    <script src="../js/grado.js"></script> <!-- Enlace a otro script JavaScript -->
</body>
</html>