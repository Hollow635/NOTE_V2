<?php
// Incluir el archivo de conexión a la base de datos
include("../bases/conexion.php");

// Verificar si se recibió una solicitud POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario y sanitizarlos para evitar inyecciones SQL
    $nombre = mysqli_real_escape_string($conex, $_POST['nombre']);
    $email = mysqli_real_escape_string($conex, $_POST['email']);
    $contraseña = mysqli_real_escape_string($conex, $_POST['password']); // Asegúrate de usar 'password'
    
    // Encriptar la contraseña usando un hash seguro
    $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);
    
    // Asignar tipo de usuario, en este caso 'admin'
    $tipo_usuario = 'admin'; 

    // Obtener la fecha y hora actual
    $fecha = date('Y-m-d H:i:s'); 

    // Verificar si el email ya está registrado en la base de datos
    $checkEmailQuery = $conex->prepare("SELECT * FROM usuario WHERE email = ?");
    if (!$checkEmailQuery) {
        // Manejar error en la preparación de la consulta
        die("Error en la preparación de la consulta: " . $conex->error);
    }

    // Vincular el parámetro y ejecutar la consulta
    $checkEmailQuery->bind_param("s", $email);
    if (!$checkEmailQuery->execute()) {
        // Manejar error al ejecutar la consulta
        die("Error al ejecutar la consulta de verificación de correo: " . $checkEmailQuery->error);
    }

    // Almacenar el resultado de la consulta
    $checkEmailQuery->store_result();

    // Comprobar si se encontró el email
    if ($checkEmailQuery->num_rows > 0) {
        // Mensaje de error si el correo ya está registrado
        echo "<h3 class='error'>El correo ya está registrado. Por favor, use un correo diferente.</h3>";
        header("refresh:3; url=../bases/crear_admin.php"); // Redirigir después de 3 segundos
        exit();
    } else {
        // Preparar la consulta para insertar el nuevo administrador
        $consulta = $conex->prepare("INSERT INTO usuario (nombre, email, contraseña, tipo_usuario, fecha) VALUES (?, ?, ?, ?, ?)");
        if ($consulta) { 
            // Vincular parámetros para la consulta de inserción
            $consulta->bind_param("sssss", $nombre, $email, $contraseña_hash, $tipo_usuario, $fecha);
            // Ejecutar la consulta
            if ($consulta->execute()) {
                // Mensaje de éxito y redirección
                echo "<h3>Administrador registrado exitosamente. Redirigiendo a Login</h3>";
                header("refresh:3; url=../bases/login.php"); // Redirigir después de 3 segundos
                exit();
            } else {
                // Mensaje de error si ocurre un problema al registrarse
                echo "<h3 class='error'>Ocurrió un error al registrarse: " . $consulta->error . "</h3>";
            }
            $consulta->close(); // Cerrar la consulta preparada
        } else {
            // Mensaje de error si ocurre un problema al preparar la consulta de inserción
            echo "<h3 class='error'>Error en la preparación de la consulta de inserción: " . $conex->error . "</h3>";
        }
    }

    // Cerrar la consulta de verificación de email
    $checkEmailQuery->close();
    // Cerrar la conexión a la base de datos
    mysqli_close($conex);
} else {
    // Redirigir si la solicitud no es POST
    header("Location: ../bases/crear_admin.php");
    exit();
}
?>
