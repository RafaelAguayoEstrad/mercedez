<?php
session_start();
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "empresa";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Capturar datos del formulario
$nombre = $_POST['nombre'];
$apellido_paterno = $_POST['apellido_paterno'];
$apellido_materno = $_POST['apellido_materno'];
$telefono = $_POST['telefono'];
$calle = $_POST['calle'];
$municipio = $_POST['municipio'];
$pais = $_POST['pais'];
$correo = $_POST['correo'];
$forma_pago = $_POST['forma_pago'];
$fecha = date('Y-m-d H:i:s'); // Fecha y hora actual

// Insertar los datos del pedido en la base de datos
$sql = "INSERT INTO pedidos (nombre, apellido_paterno, apellido_materno, telefono, calle, municipio, pais, correo, forma_pago, fecha) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssss", $nombre, $apellido_paterno, $apellido_materno, $telefono, $calle, $municipio, $pais, $correo, $forma_pago, $fecha);

if ($stmt->execute()) {
    // Obtener el ID del pedido insertado
    $pedido_id = $stmt->insert_id;

    // Obtener los productos del carrito
    $query = "SELECT * FROM carrito";
    $result = $conn->query($query);

    while ($row = $result->fetch_assoc()) {
        $producto_id = $row['id'];
        $nombre_producto = $row['nombre'];
        $precio_producto = $row['precio'];
        $imagen_producto = $row['imagen'];
        $cantidad_producto = $row['cantidad'];

        // Insertar los productos en la tabla de detalles del pedido
        $sql_detalle = "INSERT INTO detalles_pedido (pedido_id, producto_id, nombre, precio, imagen, cantidad) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_detalle = $conn->prepare($sql_detalle);
        $stmt_detalle->bind_param("iisssi", $pedido_id, $producto_id, $nombre_producto, $precio_producto, $imagen_producto, $cantidad_producto);
        $stmt_detalle->execute();
    }

    // Vaciar el carrito después del pedido
    $conn->query("DELETE FROM carrito");

    echo "Pedido realizado con éxito";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
