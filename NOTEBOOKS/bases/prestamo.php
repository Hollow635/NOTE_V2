<?php 
session_start(); // Inicia la sesión para acceder a variables de sesión
require_once '../bases/conexion.php'; // Incluye el archivo de conexión a la base de datos

$message = ''; // Variable para almacenar mensajes de error o información
$reservadas = []; // Array para almacenar las computadoras reservadas
$prestamoRealizado = false; // Bandera para indicar si se realizó un préstamo
$fechaActual = date('Y-m-d'); // Obtiene la fecha actual
$disponibilidadMensaje = ''; // Mensaje de disponibilidad

// Obtiene el correo del usuario de la sesión, si existe
$emailUsuario = isset($_SESSION['email']) ? $_SESSION['email'] : null; 
$nombreUsuario = ''; // Inicializa el nombre del usuario

// Si hay un usuario logueado, busca su nombre en la base de datos
if ($emailUsuario) {
    try {
        // Crea una nueva conexión PDO
        $conn = new PDO("mysql:host=$db_host;dbname=pp_note", $db_user, $db_pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Prepara la consulta para obtener el nombre del usuario
        $stmt = $conn->prepare("SELECT id, nombre FROM usuario WHERE email = :email");
        $stmt->bindParam(':email', $emailUsuario); // Vincula el parámetro
        $stmt->execute(); // Ejecuta la consulta

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC); // Obtiene el resultado
        if ($usuario) {
            $nombreUsuario = $usuario['nombre']; // Asigna el nombre a la variable
            $idUsuario = $usuario['id']; // Guarda el ID del usuario
        } else {
            $message = 'Usuario no encontrado'; // Mensaje si no se encuentra el usuario
        }
    } catch (PDOException $e) {
        $message = "Error en la conexión: " . $e->getMessage(); // Manejo de errores de conexión
    }
}

$computers = []; // Array para almacenar las computadoras disponibles
try {
    // Prepara la consulta para obtener las computadoras disponibles
    $stmt = $conn->prepare("SELECT NOMBRE FROM COMPUTADORA WHERE estado = 'Disponible'");
    $stmt->execute(); // Ejecuta la consulta

    // Recorre los resultados y los almacena en el array
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $computers[] = $row['NOMBRE'];
    }
} catch (PDOException $e) {
    $message = "Error en la conexión: " . $e->getMessage(); // Manejo de errores de conexión
}

// Manejo de la devolución de computadoras
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['devolver'])) {
    $notebooksDevueltas = $_POST['notebooks']; // Obtiene el array de computadoras devueltas

    // Actualiza el estado de las computadoras devueltas a 'Disponible'
    foreach ($notebooksDevueltas as $notebookId) {
        $updateStmt = $conn->prepare("UPDATE COMPUTADORA SET estado = 'Disponible' WHERE NOMBRE = :NOMBRE");
        $updateStmt->bindParam(':NOMBRE', $notebookId);
        $updateStmt->execute();
    }
}

// Manejo del préstamo de computadoras
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['devolver'])) {
    $cantidad = intval($_POST['cantidad']); // Obtiene la cantidad de computadoras a reservar
    $horaInicio = $_POST['horaInicio']; // Hora de inicio del préstamo
    $horaFin = $_POST['horaFin']; // Hora de fin del préstamo

    // Validaciones
    if ($cantidad < 1 || $cantidad > 12) {
        $message = 'La cantidad debe estar entre 1 y 12.'; // Mensaje de error si la cantidad es inválida
    } elseif (!preg_match('/^(0[7-9]|1[0-1]):[0-5][0-9]$|^11:0[0-9]$|^(13:[3-9][0]|14:[0-1][0-9]|15:[0-1][0-9]|16:[0-1][0-9]|17:0[0-9])$/', $horaInicio) ||
              !preg_match('/^(0[7-9]|1[0-1]):[0-5][0-9]$|^11:0[0-9]$|^(13:[3-9][0]|14:[0-1][0-9]|15:[0-1][0-9]|16:[0-1][0-9]|17:0[0-9])$/', $horaFin)) {
        $message = 'Las horas de inicio y fin deben estar dentro del horario permitido.'; // Mensaje si las horas son inválidas
    } elseif ($horaInicio >= $horaFin) {
        $message = 'La hora de fin debe ser posterior a la hora de inicio.'; // Mensaje si la hora de fin no es válida
    } else {
        // Verifica si hay suficientes computadoras disponibles
        if (count($computers) < $cantidad) {
            $message = 'No hay suficientes computadoras disponibles.'; // Mensaje si no hay computadoras
        } else {
            // Selecciona aleatoriamente las computadoras para el préstamo
            shuffle($computers);
            $notebooksAsignadas = array_slice($computers, 0, $cantidad); // Asigna las computadoras seleccionadas

            // Actualiza el estado de las computadoras a 'Ocupada' y registra el préstamo
            try {
                $conn->beginTransaction(); // Inicia la transacción

                foreach ($notebooksAsignadas as $notebookId) {
                    $updateStmt = $conn->prepare("UPDATE COMPUTADORA SET estado = 'Ocupada' WHERE NOMBRE = :NOMBRE");
                    $updateStmt->bindParam(':NOMBRE', $notebookId);
                    $updateStmt->execute();
                    $reservadas[] = $notebookId; // Agrega a las computadoras reservadas
                }

                // Inserta el préstamo en la base de datos
                $insertStmt = $conn->prepare("INSERT INTO PRESTAMO (FECHA_PRESTAMO, HORA_INICIO_PRESTAMO, HORA_FIN_PRESTAMO, ESTADO_PRESTAMO, ID_USUARIO, NOMBRE_COMPUTADORA) VALUES (?, ?, ?, ?, ?, ?)");
                $estadoPrestamo = "Activo"; // Estado del préstamo
                foreach ($notebooksAsignadas as $notebookId) {
                    $insertStmt->execute([$fechaActual, $horaInicio, $horaFin, $estadoPrestamo, $idUsuario, $notebookId]);
                }

                $conn->commit(); // Confirma la transacción
                $prestamoRealizado = true; // Marca que el préstamo se realizó
                ?>
                <h3 class="resultado">Se ha realizado su préstamo. Presione en "Generar PDF" para descargar un comprobante.</h3>
                <?php
            } catch (PDOException $e) {
                $conn->rollBack(); // Revierte la transacción en caso de error
                $message = "Error al registrar el préstamo: " . $e->getMessage(); // Manejo de errores de inserción
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Reserva</title>
    <link rel="stylesheet" href="../estilos/estilos.css"> <!-- Enlace a la hoja de estilos -->
    <link rel="icon" href="../imagenes/logo.ico"> <!-- Ícono de la pestaña -->
</head>
<body>
    <header class="header">
        <h1>Realizar Reserva de Notebooks</h1> <!-- Título de la página -->
        <?php if ($disponibilidadMensaje): ?>
            <p style="color: gray;"><?php echo $disponibilidadMensaje; ?></p> <!-- Mensaje de disponibilidad -->
        <?php endif; ?>
    </header>
    <main class="main-content">
    <form method="POST" action="">
        <label for="cantidad">Cantidad de computadoras (máx. 12):</label>
        <input type="number" id="cantidad" name="cantidad" min="1" max="12" required>
        <br><br>
        
        <label for="horaInicio">Hora de inicio del préstamo:</label>
        <input type="time" id="horaInicio" name="horaInicio" required>
        <br><br>
        
        <label for="horaFin">Hora de fin del préstamo:</label>
        <input type="time" id="horaFin" name="horaFin" required>
        <br><br>
        
        <input type="submit" value="Hacer Reserva" class="request-button">
        <input type="button" value="Volver Atras" class="request-button" onclick="location.href='../bases/servicio_basico.php'">
        <?php if ($prestamoRealizado): ?>
            <input type="button" value="Info de mi Préstamo" class="request-button" onclick="openModal()" style="margin-left: 10px;">
            <button type="button" onclick="generarPDF()" class="request-button" style="margin-left: 10px;">Generar PDF</button>
        <?php endif; ?>

        <!-- Campo oculto para la hora local -->
        <input type="hidden" id="horaPrestamo" name="horaPrestamo">
    </form>

        <?php if ($message): ?> <!-- Muestra mensaje si existe -->
            <div class="message" style="margin-top: 20px;">
                <p><?php echo htmlspecialchars($message); ?></p>
            </div>
        <?php endif; ?>

        <!-- Ventana Modal -->
        <?php if ($prestamoRealizado): ?>
        <div id="myModal" class="modal" style="display:none;">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span> <!-- Botón para cerrar el modal -->
                <h3>Información de su Préstamo</h3>
                <p>Cantidad de Computadoras: <?php echo htmlspecialchars($cantidad); ?></p>
                <p>Hora de Inicio: <?php echo htmlspecialchars($horaInicio); ?></p>
                <p>Hora de Fin: <?php echo htmlspecialchars($horaFin); ?></p>
                <p>Notebooks Asignadas: <?php echo implode(', ', $reservadas); ?></p> <!-- Muestra las notebooks asignadas -->
            </div>
        </div>
        <?php endif; ?>
        </form>

    </main>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        async function generarPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // Obtener datos desde PHP y JavaScript
    const nombreUsuario = "<?php echo htmlspecialchars($nombreUsuario); ?>";
    const emailUsuario = "<?php echo htmlspecialchars($emailUsuario); ?>";
    const cantidad = "<?php echo htmlspecialchars($cantidad); ?>";
    const horaInicio = "<?php echo htmlspecialchars($horaInicio); ?>";
    const horaFin = "<?php echo htmlspecialchars($horaFin); ?>";
    const fechaActual = "<?php echo htmlspecialchars($fechaActual); ?>";
    const notebooksAsignadas = "<?php echo implode(', ', $reservadas); ?>";
    
    // Obtener la hora local actual desde el formulario oculto
    const horaPrestamo = document.getElementById('horaPrestamo').value;

    // Configurar el contenido del PDF
    doc.setFontSize(16);
    doc.text("Comprobante de Préstamo de Notebooks", 10, 20);
    doc.text("------------------------------------------------------------------------------------------------", 10, 30);
    doc.text("Nombre: " + nombreUsuario, 10, 40);
    doc.text("Email: " + emailUsuario, 10, 50);
    doc.text("Cantidad de Computadoras: " + cantidad, 10, 60);
    doc.text("Hora de Inicio del préstamo: " + horaInicio, 10, 70);
    doc.text("Hora de Fin del préstamo: " + horaFin, 10, 80);
    doc.text("Fecha Actual: " + fechaActual, 10, 90);
    doc.text("Hora de Préstamo: " + horaPrestamo, 10, 100);  // Mostrar la hora del préstamo
    doc.text("Se les asignarán las siguientes notebooks: ", 10 , 110);
    doc.text("Notebooks: " + notebooksAsignadas, 10, 120);

    doc.save("comprobante_prestamo.pdf"); // Descargar el PDF generado
}

        function openModal() {
            document.getElementById("myModal").style.display = "block"; // Muestra el modal
        }

        function closeModal() {
            document.getElementById("myModal").style.display = "none"; // Oculta el modal
        }
    </script>

    <script src="../js/escript.js"></script>
</body>
</html>
