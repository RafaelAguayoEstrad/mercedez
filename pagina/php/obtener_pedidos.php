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

// Consulta para obtener los pedidos
$sql = "SELECT p.id, p.nombre, p.apellido_paterno, p.apellido_materno, p.telefono, p.calle, p.municipio, p.pais, p.correo, p.forma_pago, p.fecha, d.cantidad, d.producto_id, d.nombre AS producto_nombre, d.precio, d.imagen
        FROM pedidos p
        JOIN detalles_pedido d ON p.id = d.pedido_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $current_pedido_id = null;
    while ($row = $result->fetch_assoc()) {
        if ($row['id'] !== $current_pedido_id) {
            if ($current_pedido_id !== null) {
                echo "</td><td><button onclick='marcarEntregado($current_pedido_id)'>Entregado</button></td></tr>";
            }
            $current_pedido_id = $row['id'];
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['nombre'] . " " . $row['apellido_paterno'] . " " . $row['apellido_materno'] . "</td>";
            echo "<td>" . $row['fecha'] . "</td>";
            
            echo "<td>";
        }
        echo "Producto: " . $row['producto_nombre'] . " - Cantidad: " . $row['cantidad'] . " - Precio: $" . $row['precio'] . "<br>";
    }
    echo "</td><td><button onclick='marcarEntregado($current_pedido_id)'>Entregado</button></td></tr>";
} else {
   echo "<td><button onclick='deleteEmployee(" . $row['id'] . ")'>Eliminar</button></td>";
}

$conn->close();
?>



