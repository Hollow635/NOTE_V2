<?php
// Incluye el archivo de conexión a la base de datos
include("../bases/conexion.php");

// Función para determinar el tipo de usuario
function determinarTipoUsuario($nombre) {
    return 'Profesor';
}

// Verifica si se ha enviado el formulario de registro
if (isset($_POST['register'])) {
    // Validación de campos
    if (strlen($_POST['name']) >= 1 && strlen($_POST['email']) >= 1 && strlen($_POST['password']) >= 1 && strlen($_POST['clave']) >= 1) {
        
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);  // Limpiar espacios extras
        $clave = trim($_POST['clave']); // Recupera la clave proporcionada por el usuario


        // Verifica la longitud de la contraseña y otros requisitos
        if (strlen($password) < 8) {
            echo "<h3 class='error'>La contraseña debe tener al menos 8 caracteres.</h3>";
            exit();
        }
        
        if (!preg_match('/[a-z]/', $password)) {
            echo "<h3 class='error'>La contraseña debe incluir al menos una letra minúscula.</h3>";
            exit();
        }
        
        if (!preg_match('/\d/', $password)) {
            echo "<h3 class='error'>La contraseña debe incluir al menos un número.</h3>";
            exit();
        }              

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $fecha = date("Y-m-d");
        $tipo_usuario = determinarTipoUsuario($name);
        $activo = 0; // Valor por defecto para la cuenta inactiva

        // Verificar si el correo ya está registrado
        $checkEmailQuery = $conex->prepare("SELECT * FROM usuario WHERE email = ?");
        if (!$checkEmailQuery) {
            die("Error en la preparación de la consulta: " . $conex->error);
        }

        $checkEmailQuery->bind_param("s", $email);
        if (!$checkEmailQuery->execute()) {
            die("Error al ejecutar la consulta de verificación de correo: " . $checkEmailQuery->error);
        }

        $checkEmailQuery->store_result();
        if ($checkEmailQuery->num_rows > 0) {
            echo "<h3 class='error'>El correo ya está registrado. Por favor, use un correo diferente.</h3>";
            exit();  // Salir si el correo ya existe
        }

        // Insertar los datos del nuevo profesor en la base de datos
        $consulta = $conex->prepare("INSERT INTO usuario(nombre, email, contraseña, tipo_usuario, fecha, clave, activo) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if (!$consulta) {
            echo "<h3 class='error'>Error en la preparación de la consulta de inserción: " . $conex->error . "</h3>";
            exit();
        }

        $consulta->bind_param("sssssss", $name, $email, $hashed_password, $tipo_usuario, $fecha, $clave, $activo);
        
        if ($consulta->execute()) {
            echo "<h3 class='success'>Tu registro como profesor se ha completado, pero debes esperar a que un administrador active tu cuenta.</h3>";
        } else {
            echo "<h3 class='error'>Ocurrió un error al registrarse: " . $consulta->error . "</h3>";
        }
        $consulta->close();
        $checkEmailQuery->close();
    } else {
        echo "<h3 class='error'>Llena todos los campos correctamente.</h3>";
    }
}
?>
