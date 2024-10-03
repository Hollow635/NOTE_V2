<?php
// Inicia la sesión para poder usar variables de sesión
session_start();

// Establece la conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "pp_note");

// Verifica si hubo un error al conectar a la base de datos
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verifica si se ha enviado el formulario a través del método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura el email y la contraseña del formulario
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Consulta para obtener la contraseña, nombre y tipo de usuario basado en el email
    $sql = "SELECT contraseña, nombre, tipo_usuario FROM usuario WHERE email = ?";
    $stmt = $conn->prepare($sql); // Prepara la consulta
    $stmt->bind_param("s", $email); // Asocia el parámetro
    $stmt->execute(); // Ejecuta la consulta
    $result = $stmt->get_result(); // Obtiene el resultado

    // Verifica si hay resultados para el email proporcionado
    if ($result->num_rows > 0) {
        // Recupera los datos del usuario
        $row = $result->fetch_assoc();
        $hashed_password = $row['contraseña']; // Contraseña hasheada
        $name = $row['nombre']; // Nombre del usuario
        $user_type = $row['tipo_usuario']; // Tipo de usuario

        // Verifica si la contraseña ingresada coincide con la hasheada
        if (password_verify($password, $hashed_password)) {
            // Almacena el email y nombre en la sesión
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $name;

            // Redirige según el tipo de usuario
            if ($user_type === 'admin') {
                echo "<script>alert('Inicio de sesión exitoso como administrador'); window.location.href='../bases/Principal.php';</script>";
            } else {
                echo "<script>alert('Inicio de sesión exitoso como usuario'); window.location.href='../bases/servicio_basico.php';</script>";
            }
        } else {
            // Mensaje de error si la contraseña no coincide
            echo "<script>alert('El Email o Contraseña son incorrectos, intente nuevamente'); window.location.href='../bases/login.php';</script>";
        }
    } else {
        // Mensaje si no se encontró un usuario
        echo "<script>alert('Algo ha salido mal. Intente nuevamente'); window.location.href='../bases/login.php';</script>";
    }

    // Cierra la declaración preparada
    $stmt->close();
}

// Cierra la conexión a la base de datos
$conn->close();
?>
