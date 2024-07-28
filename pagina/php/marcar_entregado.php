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

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Marcar el pedido como entregado (esto es solo un ejemplo, puede que necesites ajustar tu base de datos)
    $sql = "UPDATE pedidos SET estado = 'Entregado' WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            echo "Pedido marcado como entregado.";
        } else {
            echo "Error al ejecutar la consulta: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
    }
} else {
    echo "ID de pedido no proporcionado.";
}

$conn->close();
?>
