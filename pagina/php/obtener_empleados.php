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

// Consulta para obtener los empleados
$sql = "SELECT * FROM empleados";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['clave'] . "</td>";
        echo "<td>" . $row['nombre'] . "</td>";
        echo "<td>" . $row['apellido_paterno'] . "</td>";
        echo "<td>" . $row['apellido_materno'] . "</td>";
        echo "<td>" . $row['direccion'] . "</td>";
        echo "<td>" . $row['telefono'] . "</td>";
        echo "<td>" . $row['correo'] . "</td>";
        echo "<td>" . $row['puesto'] . "</td>";
        echo "<td><button onclick='deleteEmployee(" . $row['id'] . ")'>Eliminar</button></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='9'>No hay empleados registrados</td></tr>";
}

$conn->close();
?>
