<?php
// Incluir la conexión a la base de datos
include("../bases/conexion.php");

// Verificar si el formulario ha sido enviado
if (isset($_POST['verify'])) {
    // Obtener el email y la clave de recuperación del formulario
    $email = trim($_POST['email']);
    $recuperacion_clave = trim($_POST['clave']);  // Ahora coinciden con el campo del formulario

    // Preparar la consulta para verificar si el email y la clave de recuperación existen en la base de datos
    $checkQuery = $conex->prepare("SELECT * FROM usuario WHERE email = ? AND clave = ?");
    $checkQuery->bind_param("ss", $email, $recuperacion_clave);

    if ($checkQuery->execute()) {
        // Verificar si se encontró el usuario con el email y la clave de recuperación
        $result = $checkQuery->get_result();
        if ($result->num_rows > 0) {
            // Si el email y la clave de recuperación coinciden, redirigir al formulario de cambio de contraseña
            $row = $result->fetch_assoc();
            $email = $row['email']; // Recuperamos el email

            // Redirigir al formulario para cambiar la contraseña, pasando el email como parámetro
            header("Location: cambiar_password.php?email=" . urlencode($email));
            exit();
        } else {
            // Si no se encuentra el email o la clave, mostrar un mensaje de error
            echo "<h3 class='error'>El correo electrónico o la clave de recuperación no son válidos.</h3>";
        }
    } else {
        // Si hay un error en la consulta
        echo "<h3 class='error'>Error en la consulta de verificación.</h3>";
    }
    
    // Cerrar la conexión
    $checkQuery->close();
    mysqli_close($conex);
}
?>
