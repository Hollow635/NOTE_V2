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

// Manejo de usuarios (CRUD)
$searchTerm = ''; // Inicializa la variable de búsqueda
$searchType = ''; // Inicializa el tipo de usuario
$searchSpecialty = ''; // Inicializa la especialidad

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_user'])) {
        // Eliminar usuario
        $userId = $_POST['user_id'];
        $sql = "DELETE FROM usuario WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
    }

    if (isset($_POST['toggle_active'])) {
        // Alternar estado activo
        $userId = $_POST['user_id'];
        $sql = "SELECT activo FROM usuario WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        $newStatus = $user['activo'] ? 0 : 1;
        $sql = "UPDATE usuario SET activo = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $newStatus, $userId);
        $stmt->execute();
    }

    if (isset($_POST['search_user'])) {
        // Buscar usuario
        $searchTerm = $_POST['search_term'];
        $searchType = $_POST['tipo'] ?? '';
        $searchSpecialty = $_POST['especialidad'] ?? '';
    }
}

// Construir la consulta de búsqueda
$sql = "SELECT * FROM usuario WHERE 1=1"; // 1=1 permite agregar condiciones dinámicamente
$params = [];
$wildcard = '%' . $searchTerm . '%';

if ($searchTerm) {
    $sql .= " AND nombre LIKE ?";
    $params[] = $wildcard;
}

if ($searchType) {
    $sql .= " AND tipo_usuario = ?";
    $params[] = $searchType;
}

if ($searchSpecialty) {
    $sql .= " AND especialidad = ?";
    $params[] = $searchSpecialty;
}

// Preparar la consulta
$stmt = $conn->prepare($sql);

// Vincular parámetros si existen
if (count($params) > 0) {
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);
}

$stmt->execute();
$users = $stmt->get_result();
$conn->close(); // Cierra la conexión
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="../estilos/estilo_admin.css">
    <link rel="icon" href="../imagenes/logo.ico">
</head>
<body>
<header class="header">
    <div class="logo-container">
        <img src="../imagenes/OK.png" alt="Escudo" class="logo"> 
    </div>
    <!-- Barra de navegación con botones alineados a la izquierda -->
    <nav class="menu">
        <ul class="menu-list">
            <li class="menu-item">
                <a href="../bases/manejo_Compu.php" class="logout-link">Controlar las Notebooks</a>
            </li>
            <li class="menu-item">
                <a href="../bases/control.php" class="logout-link">Registro de los prestamos</a>
            </li>
            <li class="menu-item">
                <a href="../bases/administracion.php" class="logout-link">Volver Atras</a>
            </li>
        </ul>
    </nav>
</header>

    <!-- Formulario de búsqueda -->
    <form method="POST" style="margin-top: 20px;">
        <input type="text" name="search_term" placeholder="Buscar por nombre" value="<?php echo htmlspecialchars($searchTerm); ?>">
        <select name="tipo">
            <option value="">Tipo de Usuario</option>
            <option value="Alumno" <?php echo ($searchType == 'Alumno') ? 'selected' : ''; ?>>Alumno</option>
            <option value="Profesor" <?php echo ($searchType == 'Profesor') ? 'selected' : ''; ?>>Profesor</option>
            <option value="Administrador" <?php echo ($searchType == 'Administrador') ? 'selected' : ''; ?>>Administrador</option>
        </select>
        <select name="especialidad">
            <option value="">Especialidad (opcional)</option>
            <option value="Computacion" <?php echo ($searchSpecialty == 'Computacion') ? 'selected' : ''; ?>>Computacion</option>
            <option value="Construcciones" <?php echo ($searchSpecialty == 'Construcciones') ? 'selected' : ''; ?>>Construcciones</option>
            <option value="Electricidad" <?php echo ($searchSpecialty == 'Electricidad') ? 'selected' : ''; ?>>Electricidad</option>
            <option value="Electronica" <?php echo ($searchSpecialty == 'Electronica') ? 'selected' : ''; ?>>Electrónica</option>
            <option value="Mecanica" <?php echo ($searchSpecialty == 'Mecanica') ? 'selected' : ''; ?>>Mecanica</option>
            <option value="Quimica" <?php echo ($searchSpecialty == 'Quimica') ? 'selected' : ''; ?>>Química</option>
            <option value="Ciclo Basico" <?php echo ($searchSpecialty == 'Ciclo Basico') ? 'selected' : ''; ?>>Ciclo Basico</option>
        </select>
        <input type="submit" name="search_user" value="Buscar" class="action-button">
    </form>

    <h3 class="computer-list-title" style="color: green;">Lista de Usuarios</h3>
<div class="user-list-container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Tipo de Usuario</th>
                <th>Especialidad</th>
                <th>División</th> <!-- Ahora la división está antes del estado -->
                <th>Estado</th> <!-- Estado ahora está después de división -->
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $users->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['tipo_usuario']); ?></td>
                    <td><?php echo htmlspecialchars($row['especialidad']); ?></td>
                    
                    <!-- Mostrar la división solo si el usuario es un 'Alumno' -->
                    <td>
                        <?php 
                            if ($row['tipo_usuario'] == 'alumno') {
                                echo htmlspecialchars($row['division']);
                            } else {
                                echo ''; // Dejar en blanco para profesores y administradores
                            }
                        ?>
                    </td>

                    <td><?php echo $row['activo'] ? 'Activo' : 'Deshabilitado'; ?></td>

                    <td>
                        <form method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                            <input type="submit" name="toggle_active" value="<?php echo $row['activo'] ? 'Deshabilitar' : 'Habilitar'; ?>" class="action-button">
                            <input type="submit" name="delete_user" value="Eliminar" class="action-button">
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
