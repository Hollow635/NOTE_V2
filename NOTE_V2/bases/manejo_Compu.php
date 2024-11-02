<?php  
session_start(); // Inicia la sesión

if (!isset($_SESSION['email']) || !isset($_SESSION['name'])) {
    header("Location: ../bases/login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "pp_note");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$searchTerm = '';
$selectedLetter = '';
$selectedStatus = '';

// Manejo de computadoras (CRUD)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Agregar computadora
    if (isset($_POST['add_computer'])) {
        $computerName = $_POST['NOMBRE'];
        $brand = $_POST['MARCA'];
        $status = $_POST['estado'];
        
        $sql = "INSERT INTO COMPUTADORA (NOMBRE, MARCA, estado) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $computerName, $brand, $status);
        if ($stmt->execute()) {
            echo "<script>alert('Computadora agregada exitosamente.');</script>";
        } else {
            echo "<script>alert('Error al agregar la computadora.');</script>";
        }
    }

    // Eliminar computadora
    if (isset($_POST['delete_computer'])) {
        $computerId = $_POST['computer_id'];
        $sql = "DELETE FROM COMPUTADORA WHERE NOMBRE = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $computerId);
        if ($stmt->execute()) {
            echo "<script>alert('Computadora eliminada exitosamente.');</script>";
        } else {
            echo "<script>alert('Error al eliminar la computadora.');</script>";
        }
    }

    // Cambiar estado de la computadora
    if (isset($_POST['change_status'])) {
        $computerId = $_POST['computer_id'];
        $newStatus = $_POST['new_status'];
        $sql = "UPDATE COMPUTADORA SET estado = ? WHERE NOMBRE = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $newStatus, $computerId);
        if ($stmt->execute()) {
            echo "<script>alert('Estado actualizado exitosamente.');</script>";
        } else {
            echo "<script>alert('Error al cambiar el estado.');</script>";
        }
    }

    // Filtrar por letra o término de búsqueda
    if (isset($_POST['letter'])) {
        $selectedLetter = $_POST['letter'];
    }
    if (isset($_POST['search_name'])) {
        $searchTerm = $_POST['search_term'];
    }
    // Filtrar por estado
    if (isset($_POST['search_status'])) {
        $selectedStatus = $_POST['status'];
    }
}

// Consulta de computadoras
$sql = "SELECT * FROM COMPUTADORA WHERE NOMBRE LIKE ? ";
$letterParam = $selectedLetter ? $selectedLetter . '%' : '%';
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $letterParam);
$stmt->execute();
$computersByLetter = $stmt->get_result();

$searchParam = '%' . $searchTerm . '%';
if ($searchTerm) {
    $sql = "SELECT * FROM COMPUTADORA WHERE NOMBRE LIKE ? ORDER BY NOMBRE ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $searchParam);
    $stmt->execute();
    $computersByName = $stmt->get_result();
} else {
    $computersByName = $computersByLetter;
}

// Filtrar por estado
if ($selectedStatus) {
    $sql = "SELECT * FROM COMPUTADORA WHERE estado = ? ORDER BY NOMBRE ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $selectedStatus);
    $stmt->execute();
    $computersByStatus = $stmt->get_result();
} else {
    $computersByStatus = $computersByName; // Si no hay estado seleccionado, mostrar los resultados de búsqueda por nombre
}

$conn->close();
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
                <li class="menu-item"><a href="../bases/control.php" class="logout-link"> Registro de los préstamos --> </a></li>
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

    <h3 style="color: white;">Buscar Computadoras por Estado</h3>
    <form method="POST">
        <select name="status" required>
            <option value="">Seleccionar estado</option>
            <option value="Disponible">Disponible</option>
            <option value="Ocupada">Ocupada</option>
            <option value="Mantenimiento">Mantenimiento</option>
        </select>
        <input type="submit" name="search_status" value="Buscar" class="action-button">
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
                <?php while ($computer = $computersByStatus->fetch_assoc()): ?>
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
