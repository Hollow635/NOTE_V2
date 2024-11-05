<?php  
session_start(); // Inicia la sesión

// Verifica si el usuario está autenticado
if (!isset($_SESSION['email']) || !isset($_SESSION['name'])) {
    header("Location: ../bases/login.php");
    exit();
}

// Obtiene la información del usuario de la sesión
$email = $_SESSION['email'];
$name = $_SESSION['name'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración del Sistema</title>
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
                <li class="menu-item"><a href="../bases/Principal.php" class="logout-link"> <-- Volver Atras</a></li>
            </ul>
        </nav>
    </header>

    <div class="admin-container">
    <aside class="sidebar">
    <h2>Opciones de Administración</h2>
    <ul>
        <li><a href="manejo_Usuario.php">Gestionar Usuarios</a></li>
        <li><a href="mantenimiento.php">Manten. Notebooks</a></li>
        <li><a href="manejo_Compu.php">Gestionar Computadoras</a></li>
        <li><a href="control.php" class="active">Registro de los Préstamos</a></li> <!-- Cambiado aquí -->
    </ul>
</aside>
</div>

</body>
</html>
