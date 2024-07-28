<?php
session_start();

// Datos de conexión
$servidor_bd = "127.0.0.1";
$usuario_bd = "root";
$contrasena_bd = "";
$base_datos_bd = "empresa";

// Conectar a la base de datos
$conexion_bd = new mysqli($servidor_bd, $usuario_bd, $contrasena_bd, $base_datos_bd);

// Verificar la conexión
if ($conexion_bd->connect_error) {
    die("Conexión fallida: " . $conexion_bd->connect_error);
}

// Obtener datos del formulario
$nombre_producto = $_POST['nombre'];
$precio_producto = $_POST['precio'];
$imagen_producto = $_POST['imagen'];

// Verificar si el producto ya está en el carrito
$sql_verificar_producto = "SELECT id, cantidad FROM carrito WHERE nombre = ? AND imagen = ?";
$sentencia_verificar = $conexion_bd->prepare($sql_verificar_producto);
$sentencia_verificar->bind_param("ss", $nombre_producto, $imagen_producto);
$sentencia_verificar->execute();
$resultado_producto = $sentencia_verificar->get_result();

if ($resultado_producto->num_rows > 0) {
    // Producto ya existe, actualizar la cantidad
    $fila_producto = $resultado_producto->fetch_assoc();
    $id_producto = $fila_producto['id'];
    $nueva_cantidad = $fila_producto['cantidad'] + 1;

    $sql_actualizar_cantidad = "UPDATE carrito SET cantidad = ? WHERE id = ?";
    $sentencia_actualizar = $conexion_bd->prepare($sql_actualizar_cantidad);
    $sentencia_actualizar->bind_param("ii", $nueva_cantidad, $id_producto);
    if ($sentencia_actualizar->execute()) {
        echo "Cantidad actualizada en el carrito";
    } else {
        echo "Error al actualizar la cantidad: " . $sentencia_actualizar->error;
    }
} else {
    // Producto no existe, insertar nuevo
    $sql_insertar_producto = "INSERT INTO carrito (nombre, precio, imagen) VALUES (?, ?, ?)";
    $sentencia_insertar = $conexion_bd->prepare($sql_insertar_producto);
    $sentencia_insertar->bind_param("sss", $nombre_producto, $precio_producto, $imagen_producto);
    if ($sentencia_insertar->execute()) {
        echo "Producto agregado al carrito";
    } else {
        echo "Error al agregar el producto: " . $sentencia_insertar->error;
    }
}

// Cerrar conexiones
$sentencia_verificar->close();
$conexion_bd->close();
?>
