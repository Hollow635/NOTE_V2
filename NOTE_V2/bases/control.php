<?php  
session_start(); // Inicia la sesión

// Verifica si el usuario está autenticado
if (!isset($_SESSION['email']) || !isset($_SESSION['name'])) {
    header("Location: ../bases/login.php");
    exit();
}

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "pp_note");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener el historial de préstamos
$sql = "SELECT p.ID_PRESTAMO, u.nombre AS usuario, c.NOMBRE AS computadora, p.FECHA_PRESTAMO, p.HORA_INICIO_PRESTAMO, p.HORA_FIN_PRESTAMO, p.ESTADO_PRESTAMO 
        FROM PRESTAMO p 
        JOIN usuario u ON p.ID_USUARIO = u.id 
        JOIN COMPUTADORA c ON p.NOMBRE_COMPUTADORA = c.NOMBRE 
        ORDER BY p.FECHA_PRESTAMO DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Préstamos</title>
    <link rel="stylesheet" href="../estilos/estilo_admin.css">
    <link rel="icon" href="../imagenes/logo.ico">
</head>
<body>
    <header class="header">
        <div class="logo-container">
            <img src="../imagenes/OK.png" alt="Escudo" class="logo"> 
        </div>
        <nav class="menu">
            <ul class="menu-list">
                <li class="menu-item"><a href="../bases/manejo_Compu.php" class="logout-link"> Controlar las Notebooks --> </a></li>
                <li class="menu-item"><a href="../bases/manejo_Usuario.php" class="logout-link"> Controlar de los usuarios --> </a></li>
                <li class="menu-item"><a href="../bases/administracion.php" class="logout-link"> <-- Volver Atras</a></li>
                <li class="menu-item"><a href="../bases/administracion.php" class="logout-link"> <-- Volver a la primera vista</a></li>
            </ul>
        </nav>
    </header>
    <h2 style="color: green;">Historial de Préstamos</h2>
    
    <div class="user-list-container">
        <table>
            <thead>
                <tr>
                    <th>ID Préstamo</th>
                    <th>Usuario</th>
                    <th>Computadora</th>
                    <th>Fecha de Préstamo</th>
                    <th>Hora Inicio</th>
                    <th>Hora Fin</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['ID_PRESTAMO']); ?></td>
                            <td><?php echo htmlspecialchars($row['usuario']); ?></td>
                            <td><?php echo htmlspecialchars($row['computadora']); ?></td>
                            <td><?php echo htmlspecialchars($row['FECHA_PRESTAMO']); ?></td>
                            <td><?php echo htmlspecialchars($row['HORA_INICIO_PRESTAMO']); ?></td>
                            <td><?php echo htmlspecialchars($row['HORA_FIN_PRESTAMO']); ?></td>
                            <td><?php echo htmlspecialchars($row['ESTADO_PRESTAMO']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No hay registros de préstamos.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php 
$conn->close(); // Cierra la conexión a la base de datos
?>