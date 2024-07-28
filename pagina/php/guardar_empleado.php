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

// Obtener datos del formulario
$id = isset($_POST['id']) ? $_POST['id'] : '';
$clave = $_POST['clave'];
$nombre = $_POST['nombre'];
$apellido_paterno = $_POST['apellido_paterno'];
$apellido_materno = $_POST['apellido_materno'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$puesto = $_POST['puesto'];

// Depuración
var_dump($_POST);

if ($id) {
    $sql = "UPDATE empleados SET clave='$clave', nombre='$nombre', apellido_paterno='$apellido_paterno', apellido_materno='$apellido_materno', direccion='$direccion', telefono='$telefono', correo='$correo', puesto='$puesto' WHERE id=$id";
} else {
    $sql = "INSERT INTO empleados (clave, nombre, apellido_paterno, apellido_materno, direccion, telefono, correo, puesto) VALUES ('$clave', '$nombre', '$apellido_paterno', '$apellido_materno', '$direccion', '$telefono', '$correo', '$puesto')";
}

// Depuración
echo $sql;

if ($conn->query($sql) === TRUE) {
    echo "Empleado guardado correctamente";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
