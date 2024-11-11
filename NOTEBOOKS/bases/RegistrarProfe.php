<?php
// Incluye el archivo de conexión a la base de datos
include("../bases/conexion.php");

// Verifica si se ha enviado el formulario de registro
if (isset($_POST['register'])) {
    if (strlen($_POST['name']) >= 1 && strlen($_POST['email']) >= 1 && strlen($_POST['password']) >= 1 && strlen($_POST['clave']) >= 1) {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $clave = trim($_POST['clave']); // Recibe la clave de recuperación

        // Validar la contraseña
        if (!preg_match('/^(?=.*[a-z])(?=.*\d)[a-zA-Z\d]{8,}$/', $password)) {
            echo "<h3 class='error'>La contraseña debe tener al menos 8 caracteres, incluir una letra minúscula y un número.</h3>";
            exit();  // Detener la ejecución si la contraseña no es válida
        }

        // Validar que la clave tenga entre 5 y 8 dígitos
        if (!preg_match('/^\d{5,8}$/', $clave)) {
            echo "<h3 class='error'>La clave de recuperación debe tener entre 5 y 8 dígitos numéricos.</h3>";
            exit();
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $fecha = date("Y-m-d");
        $tipo_usuario = "Profesor";

        // Comprobar si el correo ya está registrado
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
        } else {
            // Insertar el nuevo profesor junto con la clave de recuperación
            $consulta = $conex->prepare("INSERT INTO usuario(nombre, email, contraseña, tipo_usuario, fecha, clave, activo) VALUES (?, ?, ?, ?, ?, ?, 0)");
            if ($consulta) {
                $consulta->bind_param("ssssss", $name, $email, $hashed_password, $tipo_usuario, $fecha, $clave);
                if ($consulta->execute()) {
                    echo "<h3 class='success'>Tu registro como profesor se ha completado, pero debes esperar a que un administrador active tu cuenta.</h3>";
                } else {
                    echo "<h3 class='error'>Ocurrió un error al registrarse: " . $consulta->error . "</h3>";
                }
                $consulta->close();
            } else {
                echo "<h3 class='error'>Error en la preparación de la consulta de inserción: " . $conex->error . "</h3>";
            }
        }

        $checkEmailQuery->close();
    } else {
        echo "<h3 class='error'>Llena todos los campos</h3>";
    }
}
?>
