<?php
header('Content-Type: text/plain'); // Establecer el tipo de contenido a texto plano

$servername = "127.0.0.1"; 
$username = "root";
$password = ""; 
$dbname = "empresa"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $correo = $_POST["correo"];
    $password = $_POST["password"]; 
    $confirm_password = $_POST["confirm_password"];

    if ($password != $confirm_password) {
        echo "Las contraseñas no coinciden";
    } else {
        $sql = "SELECT * FROM usuarios WHERE usuario='$usuario' OR correo='$correo'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "El usuario o el correo ya existen";
        } else {
            $sql = "INSERT INTO usuarios (usuario, correo, password) VALUES ('$usuario', '$correo', '$password')";

            if ($conn->query($sql) === TRUE) {
                echo "Usuario registrado exitosamente";
            } else {
                echo "Hubo un problema al registrar el usuario: " . $conn->error;
            }
        }
    }
}

$conn->close();
?>
