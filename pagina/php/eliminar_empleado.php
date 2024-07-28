<?php
// Datos de conexión
$servidor_bd = "127.0.0.1";
$usuario_bd = "root";
$contrasena_bd = "";
$base_datos_bd = "empresa";

// Conectar a la base de datos
$conn = new mysqli($servidor_bd, $usuario_bd, $contrasena_bd, $base_datos_bd);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$id = $_POST['id'];

$sql = "DELETE FROM empleados WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "Empleado eliminado correctamente";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
