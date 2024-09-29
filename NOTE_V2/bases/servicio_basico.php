<?php
session_start();

if (!isset($_SESSION['email']) || !isset($_SESSION['name'])) {
    header("Location: ../bases/login.php");
    exit();
}

$email = $_SESSION['email'];
$name = $_SESSION['name'];

// Aquí puedes definir el estado de las notebooks o cualquier otro contenido necesario
$computers = [
    'A' => [
        ['id' => 'A01', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible, si desea pedirla presione en Pedir.'],
        ['id' => 'A02', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible, si desea pedirla presione en Pedir.'],
        // Agrega más notebooks según sea necesario
    ],
    'B' => [
        ['id' => 'B01', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        // Agrega más notebooks según sea necesario
    ],
    // Agrega más categorías si es necesario

    //si quieres que se vea solo las disponibles solo quita las computadoras de las seccion b
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicio Básico</title>
    <link rel="stylesheet" href="../estilos/styles.css">
    <link rel="icon" href="../imagenes/logo.ico">
</head>
<body>
    <header class="header">
        <div class="logo-container">
            <img src="../imagenes/OK.png" alt="Escudo" class="logo"> 
        </div>
        <nav class="menu">
            <ul class="menu-list">
                <li class="menu-item">Nombre de Usuario: <br> <?php echo htmlspecialchars($name); ?> <br> Email: <?php echo htmlspecialchars($email); ?></li>
                <li class="menu-item"><a href="../bases/error.php">Guía Rápida</a></li>
                <li class="menu-item"><a href="../bases/CerrarSesion.php" class="logout-link">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main class="main-content">
        <div class="status-title">
            <h2>ESTADO DE LAS NOTEBOOKS</h2>
        </div>
        <div class="status-container">
            <?php foreach (['A', 'B'] as $category): ?>
                <div class="computer-list">
                    <?php foreach ($computers[$category] as $computer): ?>
                        <div class="computer-item" onclick="openModal('modal<?php echo $computer['id']; ?>')">
                            <span><?php echo $computer['id']; ?></span>
                            <div class="status <?php echo $computer['status']; ?>"></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <?php foreach ($computers as $category => $computersList): ?>
        <?php foreach ($computersList as $computer): ?>
            <div id="modal<?php echo $computer['id']; ?>" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('modal<?php echo $computer['id']; ?>')">&times;</span>
                    <p>Mensaje para <?php echo $computer['id']; ?>:</p>
                    <p><?php echo $computer['message']; ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endforeach; ?>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        window.onclick = function(event) {
            var modals = document.getElementsByClassName('modal');
            for (var i = 0; i < modals.length; i++) {
                if (event.target == modals[i]) {
                    modals[i].style.display = 'none';
                }
            }
        }
    </script>
</body>
</html>
