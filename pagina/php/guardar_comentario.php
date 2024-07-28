<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    die("Error: Usuario no autenticado");
}

$usuario = $_SESSION['usuario'];
$comentario = $_POST['comentario'];

$servidor = "127.0.0.1";
$nombre_usuario = "root";
$contrasena = "";
$nombre_bd = "empresa";

$conn = new mysqli($servidor, $nombre_usuario, $contrasena, $nombre_bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$sql = "INSERT INTO atencion_clientes (usuario, comentario) VALUES ('$usuario', '$comentario')";

if ($conn->query($sql) === TRUE) {
    echo "Comentario enviado correctamente.";
} else {
    echo "Error al guardar el comentario: " . $conn->error;
}

$conn->close();
?>
