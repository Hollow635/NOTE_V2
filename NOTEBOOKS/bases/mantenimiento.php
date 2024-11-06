<?php  
session_start(); 

if (!isset($_SESSION['email']) || !isset($_SESSION['name'])) {
    header("Location: ../bases/login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "pp_note");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener computadoras en mantenimiento
$sql = "SELECT ID_MANTENIMIENTO, DESCRIPCION, FECHA_MANTENIMIENTO, NOMBRE_COMPUTADORA FROM MANTENIMIENTO";
$result = $conn->query($sql); 

$conn->close(); 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Designar Mantenimiento</title>
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
                <li class="menu-item"><a href="../bases/manejo_Usuario.php" class="logout-link"> Controlar a los usuarios --> </a></li>
                <li class="menu-item"><a href="../bases/control.php" class="logout-link"> Registro de los préstamos --> </a></li>
                <li class="menu-item"><a href="../bases/administracion.php" class="logout-link"> <-- Volver Atras</a></li>
            </ul>
        </nav>
    </header>
        <main class="main-content">
            <h2 class="computer-list-title">Computadoras en Mantenimiento</h2>

            <div class="computer-list-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID Mantenimiento</th>
                            <th>Descripción</th>
                            <th>Fecha Mantenimiento</th>
                            <th>Nombre Computadora</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['ID_MANTENIMIENTO']); ?></td>
                                    <td><?php echo htmlspecialchars($row['DESCRIPCION']); ?></td>
                                    <td><?php echo htmlspecialchars($row['FECHA_MANTENIMIENTO']); ?></td>
                                    <td><?php echo htmlspecialchars($row['NOMBRE_COMPUTADORA']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">No hay computadoras en mantenimiento.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
