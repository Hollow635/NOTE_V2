<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
    <link rel="stylesheet" href="../estilos/login_style.css">
    <link rel="icon" href="../imagenes/logo.ico">
</head>
<body>

    <?php
    // Obtiene el email de la URL, si existe, y lo limpia para evitar inyecciones XSS
    $email = isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '';
    ?>

    <form action="../bases/actualizar_password.php" method="post">
        <input type="hidden" name="email" value="<?php echo $email; ?>">

        <div class="form-header">
            <h2>Establecer Nueva Contraseña</h2>
        </div>

        <div class="input-wrapper">
            <input type="password" name="new_password" id="new_password" placeholder="Nueva Contraseña" required="" onkeyup="checkPassword()">
        </div>

        <div class="input-wrapper">
            <input type="password" name="confirm_password" placeholder="Confirmar Contraseña" required="">
        </div>

        <div id="password-requirements" class="password-requirements">
            <ul>
                <li id="length" class="invalid">Al menos 8 caracteres</li>
                <li id="lowercase" class="invalid">Debe contener al menos una letra minúscula</li>
                <li id="number" class="invalid">Debe incluir al menos un número</li>
            </ul>
        </div>

        <input class="btn" type="submit" name="change_password" value="Cambiar Contraseña">
    </form>

    <script>
        function checkPassword() {
            var password = document.getElementById('new_password').value;

            // Requisitos de la contraseña
            var lengthRequirement = document.getElementById('length');
            var lowercaseRequirement = document.getElementById('lowercase');
            var numberRequirement = document.getElementById('number');

            // Validar los requisitos
            var isLengthValid = password.length >= 8;
            var isLowercaseValid = /[a-z]/.test(password);
            var isNumberValid = /\d/.test(password);

            // Cambiar el estado de los requisitos según la contraseña
            lengthRequirement.classList.toggle('valid', isLengthValid);
            lengthRequirement.classList.toggle('invalid', !isLengthValid);

            lowercaseRequirement.classList.toggle('valid', isLowercaseValid);
            lowercaseRequirement.classList.toggle('invalid', !isLowercaseValid);

            numberRequirement.classList.toggle('valid', isNumberValid);
            numberRequirement.classList.toggle('invalid', !isNumberValid);
        }
    </script>

</body>
</html>
