<?php  
// Inicia la sesión para manejar la autenticación del usuario
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['email']) || !isset($_SESSION['name'])) {
    // Redirige al usuario a la página de login si no está autenticado
    header("Location: ../bases/login.php");
    exit();
}

// Obtiene el correo y el nombre del usuario desde la sesión
$email = $_SESSION['email'];
$name = $_SESSION['name'];

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "pp_note");

// Verificar la conexión a la base de datos
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error); // Manejo de error en la conexión
}

// Consulta para obtener las computadoras disponibles
$sql = "SELECT NOMBRE AS id, estado FROM COMPUTADORA WHERE estado = 'Disponible' ORDER BY NOMBRE ASC";
$result = $conn->query($sql); // Ejecuta la consulta

$computersByLetter = []; // Inicializa un arreglo para agrupar computadoras por letra
if ($result->num_rows > 0) {
    // Procesa los resultados si hay computadoras disponibles
    while ($row = $result->fetch_assoc()) {
        $status = 'available'; // Define el estado como 'available'
        $letter = substr($row['id'], 0, 1); // Obtiene la primera letra del nombre de la computadora
        // Agrupa las computadoras por letra
        $computersByLetter[$letter][] = [
            'id' => htmlspecialchars($row['id']), // Escapa caracteres especiales
            'status' => $status,
            'message' => 'Esta notebook se encuentra disponible' // Mensaje de disponibilidad
        ];
    }
} else {
    // Indica que no hay computadoras disponibles
    $noComputersAvailable = true;
}

// Cierra la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado de Computadoras</title>
    <link rel="stylesheet" href="../estilos/estilos.css"> <!-- Enlace a la hoja de estilos -->
    <link rel="icon" href="../imagenes/logo.ico"> <!-- Icono de la pestaña -->
    <style>
        /* Estilo para el mensaje de "No hay computadoras disponibles" */
        .no-available-message {
            color: #00BFFF; /* Celeste */
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin-top: 10px;
        }
    </style>
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
        <!-- Botón "Mis Préstamos" -->
        <li class="menu-item"><a href="../bases/MisPrestamos.php" class="mis-prestamos-link">Mis Préstamos</a></li>
        <!-- Botón "Cerrar sesión" -->
        <li class="menu-item"><a href="../bases/CerrarSesion.php" class="logout-link">Cerrar Sesión</a></li>
    </ul>
</nav>


    <!-- Mostrar mensaje si no hay computadoras disponibles -->
    <?php if (isset($noComputersAvailable) && $noComputersAvailable): ?>
        <div class="no-available-message">
            No hay computadoras disponibles.
        </div>
    <?php endif; ?>
</header>

    <main class="main-content">
        <div class="status-title">
            <h2 style="color: green;">ESTADO DE LAS NOTEBOOKS</h2> <!-- Título de la sección -->
        </div>
        <div class="status-container">
            <!-- Muestra las computadoras agrupadas por letra -->
            <?php foreach ($computersByLetter as $letter => $computers): ?>
                <div class="computer-column">
                    <?php foreach ($computers as $computer): ?>
                        <!-- Cada computadora es un elemento clickeable que abre un modal -->
                        <div class="computer-item" onclick="openModal('modal<?php echo $computer['id']; ?>')">
                            <span><?php echo $computer['id']; ?></span>
                            <div class="status <?php echo $computer['status']; ?>"></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Botón para realizar el pedido de computadoras -->
        <div class="order-button-container" style="text-align: center; margin-top: 20px;">
            <input type="button" value="Ordenar" class="request-button" onclick="location.href='../bases/prestamo.php'">
        </div>
    </main>

    <!-- Modal para cada computadora -->
    <?php foreach ($computersByLetter as $letter => $computers): ?>
        <?php foreach ($computers as $computer): ?>
            <div id="modal<?php echo $computer['id']; ?>" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('modal<?php echo $computer['id']; ?>')">&times;</span> <!-- Botón para cerrar el modal -->
                    <p>Mensaje para <?php echo $computer['id']; ?>:</p>
                    <p><?php echo $computer['message']; ?></p> <!-- Mensaje de disponibilidad -->
                </div>
            </div>
        <?php endforeach; ?>
    <?php endforeach; ?>

    <script src="../js/inicio.js"></script> <!-- Enlace al script JavaScript -->
</body>
</html>
