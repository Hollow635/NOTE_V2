<?php  
session_start(); // Inicia la sesión para acceder a las variables de sesión

// Verifica si el usuario está logueado, redirige al login si no
if (!isset($_SESSION['email']) || !isset($_SESSION['name'])) {
    header("Location: ../bases/login.php");
    exit(); // Termina el script para evitar continuar
}

// Obtiene el correo y nombre del usuario de la sesión
$email = $_SESSION['email'];
$name = $_SESSION['name'];

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "pp_note");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error); // Manejo de errores en la conexión
}

// Consulta para obtener las computadoras y su estado
$sql = "SELECT NOMBRE AS id, estado FROM COMPUTADORA ORDER BY NOMBRE ASC"; // Consulta SQL
$result = $conn->query($sql); // Ejecuta la consulta

$computersByLetter = []; // Array para almacenar computadoras organizadas por letra
if ($result->num_rows > 0) {
    // Recorre los resultados de la consulta
    while ($row = $result->fetch_assoc()) {
        $statusClass = ''; // Clase para el estado
        $statusMessage = ''; // Mensaje para el estado

        // Asigna la clase y mensaje según el estado de la computadora
        switch ($row['estado']) {
            case 'Disponible':
                $statusClass = 'available'; // Clase para estado disponible
                $statusMessage = "Esta computadora se encuentra disponible para el préstamo.";
                break;
            case 'Ocupada':
                $statusClass = 'unavailable'; // Clase para estado ocupado
                $statusMessage = "Esta computadora aún no está disponible.";
                break;
            case 'Mantenimiento':
                $statusClass = 'maintenance'; // Clase para mantenimiento
                $statusMessage = "Esta computadora está en mantenimiento.";
                break;
        }

        // Obtiene la primera letra del nombre de la computadora
        $letter = strtoupper(substr($row['id'], 0, 1));
        // Almacena la computadora en el array agrupado por letra
        $computersByLetter[$letter][] = [
            'id' => htmlspecialchars($row['id']), // Sanitiza el ID
            'status' => $statusClass,
            'message' => htmlspecialchars($statusMessage) // Sanitiza el mensaje
        ];
    }
} else {
    $message = "No hay computadoras disponibles."; // Mensaje si no hay computadoras
}

$conn->close(); // Cierra la conexión a la base de datos

// Manejo de devolución de computadoras
$message = ''; // Inicializa el mensaje
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['devolver'])) {
    $notebooksDevueltas = $_POST['notebooks']; // Obtiene el array de computadoras devueltas
    $conn = new mysqli("localhost", "root", "", "pp_note"); // Nueva conexión

    // Actualiza el estado de las computadoras devueltas a 'Disponible'
    foreach ($notebooksDevueltas as $notebookId) {
        $updateStmt = $conn->prepare("UPDATE COMPUTADORA SET estado = 'Disponible' WHERE NOMBRE = ?"); // Prepara la consulta
        $updateStmt->bind_param("s", $notebookId); // Vincula el parámetro
        $updateStmt->execute(); // Ejecuta la actualización
    }

    $message = "Computadoras devueltas exitosamente."; // Mensaje de éxito
    $conn->close(); // Cierra la conexión
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado de Computadoras</title>
    <link rel="stylesheet" href="../estilos/styles.css"> <!-- Enlace a la hoja de estilos -->
    <link rel="icon" href="../imagenes/logo.ico"> <!-- Ícono de la pestaña -->
</head>
<body>
    <header class="header">
        <div class="logo-container">
            <img src="../imagenes/OK.png" alt="Escudo" class="logo"> <!-- Logo de la página -->
        </div>
        <nav class="menu">
            <ul class="menu-list">
                <li class="menu-item" style="text-align: left;">
                    Nombre de Usuario: <br> <?php echo htmlspecialchars($name); ?> <br> Email: <?php echo htmlspecialchars($email); ?>
                </li>
                <li class="menu-item"><a href="../bases/administracion.php">Administrar Sistema</a></li> <!-- Enlace a la administración -->
                <li class="menu-item"><a href="../bases/CerrarSesion.php" class="logout-link">Cerrar Sesión</a></li> <!-- Enlace para cerrar sesión -->
            </ul>
        </nav>
    </header>

    <main class="main-content">
        <div class="status-title">
            <h2 >ESTADO DE LAS COMPUTADORAS</h2> <!-- Título del estado -->
        </div>
        <?php if ($message): ?> <!-- Muestra mensaje si existe -->
            <div class="message">
                <p><?php echo htmlspecialchars($message); ?></p> <!-- Mensaje de éxito o error -->
            </div>
        <?php endif; ?>

        <div class="status-container">
            <?php foreach ($computersByLetter as $letter => $computers): ?> <!-- Recorre computadoras agrupadas por letra -->
                <div class="computer-column">
                    <h3><?php echo $letter; ?></h3> <!-- Muestra la letra del grupo -->
                    <?php foreach ($computers as $computer): ?> <!-- Recorre las computadoras de cada letra -->
                        <div class="computer-item" onclick="openModal('modal<?php echo $computer['id']; ?>')"> <!-- Elemento de computadora, abre modal al hacer clic -->
                            <span><?php echo $computer['id']; ?></span> <!-- Muestra el ID de la computadora -->
                            <div class="status <?php echo $computer['status']; ?>" title="<?php echo ucfirst($computer['status']); ?>"></div> <!-- Estado visual de la computadora -->
                        </div>

                        <!-- Modal para cada computadora -->
                        <div id="modal<?php echo $computer['id']; ?>" class="modal"> <!-- Modal para mostrar información -->
                            <div class="modal-content">
                                <span class="close" onclick="closeModal('modal<?php echo $computer['id']; ?>')">&times;</span> <!-- Botón para cerrar el modal -->
                                <p><?php echo $computer['message']; ?></p> <!-- Mensaje de estado de la computadora -->
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Formulario para devolver computadoras -->
        <h2>Devolver Computadoras</h2>
        <form method="POST" action="">
            <label for="notebooks">Seleccione las computadoras a devolver:</label>
            <select id="notebooks" name="notebooks[]" multiple required> <!-- Selección múltiple para devolver computadoras -->
                <?php foreach ($computersByLetter as $computers): ?> <!-- Recorre computadoras agrupadas por letra -->
                    <?php foreach ($computers as $computer): ?> <!-- Recorre las computadoras de cada letra -->
                        <?php if ($computer['status'] == 'unavailable'): ?> <!-- Solo muestra computadoras ocupadas -->
                            <option value="<?php echo htmlspecialchars($computer['id']); ?>"><?php echo htmlspecialchars($computer['id']); ?></option> <!-- Opción para devolver -->
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </select>
            <br><br>
            <input type="submit" name="devolver" value="Devolver" class="request-button"> <!-- Botón para enviar el formulario -->
        </form>
    </main>
    <script src="../js/inicio.js"></script> <!-- Enlace a un script JavaScript -->
</body>
</html>