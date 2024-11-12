<?php
// Iniciar sesión
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['email']) || !isset($_SESSION['name'])) {
    // Redirigir al usuario a la página de login si no está autenticado
    header("Location: ../bases/login.php");
    exit();
}

// Obtener el correo y el nombre del usuario desde la sesión
$email = $_SESSION['email'];
$name = $_SESSION['name'];

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "pp_note");

// Verificar la conexión a la base de datos
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error); // Manejo de error en la conexión
}

// Obtener el ID del usuario basado en su correo electrónico
$sql_user_id = "SELECT id FROM usuario WHERE email = ?";
$stmt = $conn->prepare($sql_user_id);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si el usuario existe
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $usuario_id = $row['id']; // Asignar el ID del usuario
} else {
    // Si el usuario no existe, redirigir al login
    header("Location: ../bases/login.php");
    exit();
}

// Consultar los préstamos realizados por este usuario
$sql = "SELECT p.ID_PRESTAMO, p.FECHA_PRESTAMO, p.HORA_INICIO_PRESTAMO, p.HORA_FIN_PRESTAMO, p.ESTADO_PRESTAMO, c.MARCA 
        FROM PRESTAMO p
        JOIN COMPUTADORA c ON p.NOMBRE_COMPUTADORA = c.NOMBRE
        WHERE p.ID_USUARIO = ?
        ORDER BY p.FECHA_PRESTAMO DESC";
        
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    // Almacenar los resultados
    $prestamos = [];
    while ($row = $result->fetch_assoc()) {
        $prestamos[] = $row;
    }
} else {
    // Si no hay préstamos, asignar un mensaje de "no hay resultados"
    $noPrestamos = true;
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Préstamos</title>
    <link rel="stylesheet" href="../estilos/MisPrestamos.css"> <!-- Enlace a la hoja de estilos -->
    <link rel="icon" href="../imagenes/logo.ico"> <!-- Icono de la pestaña -->
</head>
<body>
<header class="header">
    <div class="logo-container">
        <img src="../imagenes/OK.png" alt="Escudo" class="logo"> 
        <div class="school-name">Escuela Tecnica N°1 Otto Krause</div>
    </div>
    <nav class="menu">
        <ul class="menu-list">
            <li class="menu-item">Nombre de Usuario: <br> <?php echo htmlspecialchars($name); ?> <br> Email: <?php echo htmlspecialchars($email); ?></li>
            <li class="menu-item"><a href="servicio_basico.php" class="servicio-link">Estado de Computadoras</a></li>
            <li class="menu-item"><a href="../bases/CerrarSesion.php" class="logout-link">Cerrar Sesión</a></li>
        </ul>
    </nav>
</header>

<main class="main-content">
    <h2>Historial de Mis Préstamos</h2>

    <?php if (isset($noPrestamos) && $noPrestamos): ?>
        <p class="no-available-message">No tienes préstamos registrados.</p>
    <?php else: ?>
        <div class="prestamo-table-container">
            <table class="prestamo-table">
                <thead>
                    <tr>
                        <th>ID Préstamo</th>
                        <th>Fecha de Préstamo</th>
                        <th>Hora de Inicio</th>
                        <th>Hora de Fin</th>
                        <th>Estado</th>
                        <th>Marca de la Computadora</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($prestamos as $prestamo): ?>
                        <tr>
                            <td><?php echo $prestamo['ID_PRESTAMO']; ?></td>
                            <td><?php echo $prestamo['FECHA_PRESTAMO']; ?></td>
                            <td><?php echo $prestamo['HORA_INICIO_PRESTAMO']; ?></td>
                            <td><?php echo $prestamo['HORA_FIN_PRESTAMO']; ?></td>
                            <td class="estado-<?php echo strtolower($prestamo['ESTADO_PRESTAMO']); ?>"><?php echo $prestamo['ESTADO_PRESTAMO']; ?></td>
                            <td><?php echo $prestamo['MARCA']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>
</body>
</html>
