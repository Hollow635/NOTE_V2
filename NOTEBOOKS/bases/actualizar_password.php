<?php
// Archivo para actualizar la contraseña

include("../bases/conexion.php");

if (isset($_POST['change_password'])) {
    $email = trim($_POST['email']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    if ($new_password === $confirm_password) {
        // Verificar si la contraseña cumple con los requisitos
        if (strlen($new_password) >= 8 && preg_match('/[a-z]/', $new_password) && preg_match('/\d/', $new_password)) {
            // Hashear la nueva contraseña
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            $updateQuery = $conex->prepare("UPDATE usuario SET contraseña = ? WHERE email = ?");
            $updateQuery->bind_param("ss", $hashed_password, $email);

            if ($updateQuery->execute()) {
                echo "<h3 class='success'>Contraseña actualizada correctamente. Redirigiendo al inicio de sesión...</h3>";
                echo "<script>setTimeout(function() { window.location.href = '../bases/login.php'; }, 3000);</script>";
            } else {
                echo "<h3 class='error'>Error al actualizar la contraseña.</h3>";
            }

            $updateQuery->close();
        } else {
            echo "<h3 class='error'>La contraseña no cumple con los requisitos. Debe tener al menos 8 caracteres, una letra minúscula y un número.</h3>";
        }
    } else {
        echo "<h3 class='error'>Las contraseñas no coinciden.</h3>";
    }
}
?>
