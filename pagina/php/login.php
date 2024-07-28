<?php
session_start();

header('Content-Type: text/plain'); 

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "empresa";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die('Error de conexión: ' . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $usuario = $_POST['usuario'];
    $contrasena = $_POST['password'];

    $usuario = mysqli_real_escape_string($conn, $usuario);
    $contrasena = mysqli_real_escape_string($conn, $contrasena);

    $sql = "SELECT * FROM usuarios WHERE usuario='$usuario' AND password='$contrasena'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['usuario'] = $usuario;
        setcookie('usuario', $usuario, time() + (86400 * 30), "/"); // Guardar la cookie por 30 días
        echo "¡Bienvenido! Usuario y contraseña correctos";
    } else {
        echo "¡Error! Usuario y contraseña incorrectos";
    }
}

$conn->close();
?>
