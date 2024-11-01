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

// Inicializa las variables de búsqueda
$searchTerm = '';
$selectedLetter = '';

// Manejo de computadoras (CRUD)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_computer'])) {
        // Agregar computadora
        $computerName = $_POST['NOMBRE'];
        $brand = $_POST['MARCA'];
        $status = $_POST['estado']; // Captura el estado del formulario

        // Insertar en la base de datos
        $sql = "INSERT INTO COMPUTADORA (NOMBRE, MARCA, estado) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $computerName, $brand, $status);
        $stmt->execute();
    }

    if (isset($_POST['delete_computer'])) {
        // Eliminar computadora
        $computerId = $_POST['computer_id'];
        $sql = "DELETE FROM COMPUTADORA WHERE NOMBRE = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $computerId);
        $stmt->execute();
    }

    if (isset($_POST['change_status'])) {
        // Cambiar estado de la computadora
        $computerId = $_POST['computer_id'];
        $newStatus = $_POST['new_status'];
        $sql = "UPDATE COMPUTADORA SET estado = ? WHERE NOMBRE = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $newStatus, $computerId);
        $stmt->execute();
    }

    // Captura la letra seleccionada
    if (isset($_POST['letter'])) {
        $selectedLetter = $_POST['letter'];
    }

    // Captura el término de búsqueda por nombre
    if (isset($_POST['search_name'])) {
        $searchTerm = $_POST['search_term'];
    }
}

// Consulta de computadoras filtradas por letra o nombre
$sql = "SELECT * FROM COMPUTADORA WHERE NOMBRE LIKE ?";
$letterParam = $selectedLetter ? $selectedLetter . '%' : '%';
$searchParam = '%' . $searchTerm . '%';

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $letterParam);
$stmt->execute();
$computersByLetter = $stmt->get_result();

// Si hay un término de búsqueda, filtra por nombre
if ($searchTerm) {
    $sql = "SELECT * FROM COMPUTADORA WHERE NOMBRE LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $searchParam);
    $stmt->execute();
    $computersByName = $stmt->get_result();
} else {
    $computersByName = $computersByLetter;
}

$conn->close(); // Cierra la conexión
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Computadoras</title>
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
                <li class="menu-item"><a href="../bases/control.php" class="logout-link"> Regitro de los prestamos --> </a></li>
                <li class="menu-item"><a href="../bases/administracion.php" class="logout-link"> <-- Volver Atras</a></li>
                <li class="menu-item"><a href="../bases/Principal.php" class="logout-link"> <-- Ir a la primera vista</a></li>
            </ul>
        </nav>
    </header>

    <form method="POST">
        <input type="text" name="NOMBRE" placeholder="Nombre" required>
        <input type="text" name="MARCA" placeholder="Marca" required>
        <select name="estado" required>
            <option value="Disponible">Disponible</option>
            <option value="Ocupada">Ocupada</option>
            <option value="Mantenimiento">Mantenimiento</option>
        </select>
        <input type="submit" name="add_computer" value="Agregar Computadora" class="action-button">
    </form>

    <h3 style="color: white;">Buscar Computadoras por Sección</h3>
    <form method="POST">
        <select name="letter" required>
            <option value="">Seleccionar sección</option>
            <?php foreach (range('A', 'Z') as $letter): ?>
                <option value="<?php echo $letter; ?>" <?php if ($selectedLetter === $letter) echo 'selected'; ?>>
                    <?php echo $letter; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Buscar" class="action-button">
    </form>

    <h3 style="color: white;">Buscar Computadoras por Nombre</h3>
    <form method="POST">
        <input type="text" name="search_term" placeholder="Buscar por nombre" value="<?php echo htmlspecialchars($searchTerm); ?>" required>
        <input type="submit" name="search_name" value="Buscar" class="action-button">
    </form>

    <h3 class="computer-list-title" style="color: green;">Lista de Computadoras</h3>
    <div class="computer-list-container">
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Marca</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($computer = $computersByName->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($computer['NOMBRE']); ?></td>
                        <td><?php echo htmlspecialchars($computer['MARCA']); ?></td>
                        <td><?php echo htmlspecialchars($computer['estado']); ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="computer_id" value="<?php echo htmlspecialchars($computer['NOMBRE']); ?>">
                                <input type="submit" name="delete_computer" value="Eliminar" class="action-button">
                            </form>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="computer_id" value="<?php echo htmlspecialchars($computer['NOMBRE']); ?>">
                                <select name="new_status" required>
                                    <option value="">Cambiar Estado</option>
                                    <option value="Disponible">Disponible</option>
                                    <option value="Ocupada">Ocupada</option>
                                    <option value="Mantenimiento">Mantenimiento</option>
                                </select>
                                <input type="submit" name="change_status" value="Cambio" class="action-button">
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
