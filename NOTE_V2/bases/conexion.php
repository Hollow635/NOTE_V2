<?php // Archivo que conecta la base de datos

// Establece la conexión a la base de datos utilizando mysqli
$conex = mysqli_connect("localhost", "root", "", "pp_note");

// Verifica si la conexión ha fallado
if (!$conex) {
    // Si la conexión falla, muestra un mensaje de error y detiene la ejecución del script
    die("Conexión fallida: " . mysqli_connect_error());
}
?>
