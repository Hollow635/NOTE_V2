<?php 
session_start();
require_once '../bases/conexion.php'; // Asegúrate de tener tu archivo de configuración de la BD

// Aquí asumo que tienes la variable $computers ya definida en tu archivo original
$computers = [
    // Ejemplo de estructura de datos. Deberías cargar tus datos reales aquí.
    'A' => [['id' => 'A01', 'status' => 'available'], ['id' => 'A02', 'status' => 'available'], ['id' => 'A04', 'status' => 'available'], ['id' => 'A05', 'status' => 'available'], ['id' => 'A07', 'status' => 'available'], ['id' => 'A09', 'status' => 'available']],
    
    'B' => [['id' => 'B02', 'status' => 'available'], ['id' => 'B03', 'status' => 'available'],['id' => 'B04', 'status' => 'available'], ['id' => 'B06', 'status' => 'available'], ['id' => 'B10', 'status' => 'available']],
    
    'C' => [['id' => 'C01', 'status' => 'available'], ['id' => 'C03', 'status' => 'available'],['id' => 'B06', 'status' => 'available'], ['id' => 'B07', 'status' => 'available']],
    
    'D' => [['id' => 'D03', 'status' => 'available'], ['id' => 'D04', 'status' => 'available'],['id' => 'D07', 'status' => 'available']],
    
    'E' => [['id' => 'E04', 'status' => 'available'], ['id' => 'E05', 'status' => 'available'],['id' => 'E06', 'status' => 'available'], ['id' => 'E07', 'status' => 'available'], ['id' => 'E08', 'status' => 'available'], ['id' => 'E09', 'status' => 'available']],
    
    'F' => [['id' => 'F01', 'status' => 'available'], ['id' => 'F02', 'status' => 'available'],['id' => 'F06', 'status' => 'available'], ['id' => 'F07', 'status' => 'available']],
    
    'G' => [['id' => 'G01', 'status' => 'available'], ['id' => 'G03', 'status' => 'available'],['id' => 'G04', 'status' => 'available'], ['id' => 'F06', 'status' => 'available'], ['id' => 'F07', 'status' => 'available']],
    
    'H' => [['id' => 'H01', 'status' => 'available'], ['id' => 'H03', 'status' => 'available'],['id' => 'H04', 'status' => 'available'], ['id' => 'H06', 'status' => 'available'], ['id' => 'H07', 'status' => 'available']],
    
    'I' => [['id' => 'I01', 'status' => 'available'], ['id' => 'I03', 'status' => 'available'],['id' => 'I04', 'status' => 'available'], ['id' => 'I06', 'status' => 'available'], ['id' => 'I07', 'status' => 'available']],
    
    'J' => [['id' => 'J01', 'status' => 'available'], ['id' => 'J03', 'status' => 'available'],['id' => 'J04', 'status' => 'available'], ['id' => 'J06', 'status' => 'available'], ['id' => 'J07', 'status' => 'available']],
    
    'K' => [['id' => 'K01', 'status' => 'available'], ['id' => 'K03', 'status' => 'available'],['id' => 'K04', 'status' => 'available'], ['id' => 'K06', 'status' => 'available'], ['id' => 'K07', 'status' => 'available']],
    
    'L' => [['id' => 'L01', 'status' => 'available'], ['id' => 'L03', 'status' => 'available'],['id' => 'L04', 'status' => 'available'], ['id' => 'L06', 'status' => 'available'], ['id' => 'L07', 'status' => 'available']],
    
    'M' => [['id' => 'M01', 'status' => 'available'], ['id' => 'M03', 'status' => 'available'],['id' => 'M04', 'status' => 'available'], ['id' => 'M06', 'status' => 'available'], ['id' => 'M07', 'status' => 'available']],
    
    'N' => [['id' => 'N01', 'status' => 'available'], ['id' => 'N03', 'status' => 'available'],['id' => 'N04', 'status' => 'available'], ['id' => 'N06', 'status' => 'available'], ['id' => 'N07', 'status' => 'available']],
    
    'O' => [['id' => 'O01', 'status' => 'available'], ['id' => 'O03', 'status' => 'available'],['id' => 'O04', 'status' => 'available'], ['id' => 'O06', 'status' => 'available'], ['id' => 'O07', 'status' => 'available']],
    
    'P' => [['id' => 'P01', 'status' => 'available'], ['id' => 'P03', 'status' => 'available'],['id' => 'P04', 'status' => 'available'], ['id' => 'P06', 'status' => 'available'], ['id' => 'P07', 'status' => 'available']],
    
    'Q' => [['id' => 'Q01', 'status' => 'available'], ['id' => 'O03', 'status' => 'available'],['id' => 'O04', 'status' => 'available'], ['id' => 'O06', 'status' => 'available'], ['id' => 'O07', 'status' => 'available']],
    
    'R' => [['id' => 'R01', 'status' => 'available'], ['id' => 'R03', 'status' => 'available'],['id' => 'R04', 'status' => 'available'], ['id' => 'R06', 'status' => 'available'], ['id' => 'R07', 'status' => 'available']],
    
    'S' => [['id' => 'S01', 'status' => 'available'], ['id' => 'S03', 'status' => 'available'],['id' => 'S04', 'status' => 'available'], ['id' => 'S06', 'status' => 'available'], ['id' => 'S07', 'status' => 'available']],
    
    'T' => [['id' => 'T01', 'status' => 'available'], ['id' => 'T03', 'status' => 'available'],['id' => 'T04', 'status' => 'available'], ['id' => 'T06', 'status' => 'available'], ['id' => 'T07', 'status' => 'available']],
    
    'U' => [['id' => 'U01', 'status' => 'available'], ['id' => 'U03', 'status' => 'available'],['id' => 'U04', 'status' => 'available'], ['id' => 'U06', 'status' => 'available'], ['id' => 'U07', 'status' => 'available']],
    
    'V' => [['id' => 'V01', 'status' => 'available'], ['id' => 'V03', 'status' => 'available'],['id' => 'V04', 'status' => 'available'], ['id' => 'V06', 'status' => 'available'], ['id' => 'V07', 'status' => 'available']],
    
    'W' => [['id' => 'W01', 'status' => 'available'], ['id' => 'W03', 'status' => 'available'],['id' => 'W04', 'status' => 'available'], ['id' => 'W06', 'status' => 'available'], ['id' => 'W07', 'status' => 'available']],
    
    'X' => [['id' => 'X01', 'status' => 'available'], ['id' => 'X03', 'status' => 'available'],['id' => 'X04', 'status' => 'available'], ['id' => 'X06', 'status' => 'available'], ['id' => 'X07', 'status' => 'available']],
    
    'Y' => [['id' => 'Y01', 'status' => 'available'], ['id' => 'Y03', 'status' => 'available'],['id' => 'Y04', 'status' => 'available'], ['id' => 'Y06', 'status' => 'available'], ['id' => 'Y07', 'status' => 'available']],

    'Z' => [['id' => 'Z01', 'status' => 'available'], ['id' => 'Z03', 'status' => 'available'],['id' => 'Z04', 'status' => 'available'], ['id' => 'Z06', 'status' => 'available'], ['id' => 'Z07', 'status' => 'available']]

    // Agrega el resto de las categorías
];

$message = '';
$reservadas = [];
$prestamoRealizado = false;

// Asegúrate de que el id del usuario está almacenado en la sesión
$idUsuario = isset($_SESSION['id']) ? $_SESSION['id'] : null;
$nombreUsuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : "Hi"; // Obtener el nombre del formulario

// Depuración: Verificar el ID del usuario
if ($idUsuario) {
    echo 'ID de usuario en sesión: ' . htmlspecialchars($idUsuario); // Debugging

    // Consulta para obtener el nombre del usuario desde la base de datos
    try {
        $conn = new PDO("mysql:host=$db_host;dbname=pp_note", $db_user, $db_pass); // Conexión a la base de datos
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Preparar y ejecutar la consulta
        $stmt = $conn->prepare("SELECT nombre FROM usuario WHERE id = :id");
        $stmt->bindParam(':id', $idUsuario);
        $stmt->execute();

        // Obtener el nombre
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($usuario) {
            $nombreUsuario = $usuario['nombre'];
        } else {
            echo 'Usuario no encontrado'; // Debugging
        }

    } catch (PDOException $e) {
        echo "Error en la conexión: " . $e->getMessage(); // Manejo de errores
    }
}

// Manejo del formulario al ser enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cantidad = intval($_POST['cantidad']);
    $horaInicio = $_POST['horaInicio'];
    $horaFin = $_POST['horaFin'];

    // Validar la cantidad
    if ($cantidad < 1 || $cantidad > 12) {
        $message = 'La cantidad debe estar entre 1 y 12.';
    } elseif (!preg_match('/^(0[7-9]|1[0-1]):[0-5][0-9]$|^12:0[0-9]$|^13:[0-5][0-9]$|^(0[1-9]|1[0-7]):[0-5][0-9]$/', $horaInicio) ||
              !preg_match('/^(0[7-9]|1[0-1]):[0-5][0-9]$|^12:0[0-9]$|^13:[0-5][0-9]$|^(0[1-9]|1[0-7]):[0-5][0-9]$/', $horaFin)) {
        $message = 'Las horas de inicio y fin deben estar dentro del horario permitido.';
    } else {
        // Asignar notebooks aleatoriamente
        $availableNotebooks = [];
        foreach ($computers as $category => &$notebooks) {
            foreach ($notebooks as &$notebook) {
                if ($notebook['status'] === 'available') {
                    $availableNotebooks[] = &$notebook;
                }
            }
        }

        shuffle($availableNotebooks); // Mezclar las notebooks disponibles
        $notebooksAsignadas = array_slice($availableNotebooks, 0, $cantidad);
        
        if (count($notebooksAsignadas) < $cantidad) {
            $message = 'No hay suficientes notebooks disponibles.';
        } else {
            foreach ($notebooksAsignadas as &$notebook) {
                $notebook['status'] = 'reserved'; // Cambiar el estado a reservado
                $reservadas[] = $notebook['id'];
            }
            $prestamoRealizado = true;
            ?>
            <h3 class="resultado">Se ha realizado su préstamo. Presione en "Generar PDF" para descargar un comprobante.</h3>
            <?php
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
    <link rel="stylesheet" href="../estilos/styles.css">
</head>
<body>
    <header class="header">
        <h1>Realizar Reserva de Notebooks</h1>
    </header>
    <main class="main-content">
        <form method="POST" action="">
            
            <label for="cantidad">Cantidad de computadoras (máx. 12):</label>
            <input type="number" id="cantidad" name="cantidad" min="1" max="12" required>  
            <br><br>
            
            <label for="horaInicio">Hora de inicio del prestamo:</label>
            <input type="time" id="horaInicio" name="horaInicio" required>
            <br><br>
            
            <label for="horaFin">Hora de fin del prestamo:</label>
            <input type="time" id="horaFin" name="horaFin" required>
            <br><br>
            
            <input type="submit" value="Hacer Reserva" class="request-button">
            <input type="button" value="Volver Atras" class="request-button" onclick="location.href='../bases/servicio_basico.php'">
            <?php if ($prestamoRealizado): ?>
                <input type="button" value="Info de mi Préstamo" class="request-button" onclick="openModal()" style="margin-left: 10px;">
                <button type="button" onclick="generarPDF()" class="request-button" style="margin-left: 10px;">Generar PDF / Comprobante</button>
            <?php endif; ?>
        </form>

        <?php if ($message): ?>
            <div class="message" style="margin-top: 20px;">
                <p><?php echo htmlspecialchars($message); ?></p>
            </div>
        <?php endif; ?>

        <!-- Ventana Modal -->
        <?php if ($prestamoRealizado): ?>
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h3>Información de su Préstamo</h3>
                <p>Cantidad de Computadoras: <?php echo htmlspecialchars($cantidad); ?></p>
                <p>Hora de Inicio: <?php echo htmlspecialchars($horaInicio); ?></p>
                <p>Hora de Fin: <?php echo htmlspecialchars($horaFin); ?></p>
                <p>Notebooks Asignadas: <?php echo implode(', ', $reservadas); ?></p>
            </div>
        </div>
        <?php endif; ?>
    
    </main>
    
    <script>
        async function generarPDF() {
            const { jsPDF } = window.jspdf;
            
            // Crear una instancia del PDF
            const doc = new jsPDF();

            // Capturar los datos del préstamo
            const nombreUsuario = "<?php echo htmlspecialchars($nombreUsuario); ?>";
            const cantidad = "<?php echo htmlspecialchars($cantidad); ?>";
            const horaInicio = "<?php echo htmlspecialchars($horaInicio); ?>";
            const horaFin = "<?php echo htmlspecialchars($horaFin); ?>";
            const notebooksAsignadas = "<?php echo implode(', ', $reservadas); ?>";

            // Titulo del documento
            doc.setFontSize(16);
            doc.text("Comprobante de Préstamo de Notebooks", 10, 10);

            // Añadir detalles del préstamo al PDF
            doc.setFontSize(12);
            doc.text("Cantidad de Notebooks: " + cantidad, 10, 30);
            doc.text("Hora de Inicio: " + horaInicio, 10, 40);
            doc.text("Hora de Fin: " + horaFin, 10, 50);
            doc.text("Notebooks Asignadas: " + notebooksAsignadas, 10, 60);

            // Generar y descargar el PDF
            doc.save("comprobante_prestamo.pdf");
        }
    
        function openModal() {
            document.getElementById("myModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("myModal").style.display = "none";
        }

        window.onclick = function(event) {
            var modal = document.getElementById("myModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</body>
</html>
