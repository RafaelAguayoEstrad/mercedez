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
$id_producto = $_POST['id'];
$cantidad_a_modificar = intval($_POST['cantidad']); // Asegurarse de que la cantidad sea un número entero

// Verificar si el ID del producto y la cantidad están definidos
if (isset($id_producto) && !empty($id_producto) && isset($cantidad_a_modificar) && $cantidad_a_modificar > 0) {
    // Obtener la cantidad actual en el carrito
    $sql_verificar_producto = "SELECT cantidad FROM carrito WHERE id = ?";
    $sentencia_verificar = $conexion_bd->prepare($sql_verificar_producto);
    $sentencia_verificar->bind_param("i", $id_producto);
    $sentencia_verificar->execute();
    $resultado_producto = $sentencia_verificar->get_result();
    $fila_producto = $resultado_producto->fetch_assoc();

    if ($fila_producto) {
        $cantidad_actual = $fila_producto['cantidad'];
        if ($cantidad_a_modificar >= $cantidad_actual) {
            // Eliminar el producto si la cantidad es mayor o igual a la cantidad actual
            $sql_eliminar_producto = "DELETE FROM carrito WHERE id = ?";
            $sentencia_eliminar = $conexion_bd->prepare($sql_eliminar_producto);
            $sentencia_eliminar->bind_param("i", $id_producto);
            if ($sentencia_eliminar->execute()) {
                echo "Producto eliminado del carrito";
            } else {
                echo "Error al eliminar el producto: " . $sentencia_eliminar->error;
            }
            $sentencia_eliminar->close();
        } else {
            // Reducir la cantidad si la cantidad es menor que la cantidad actual
            $sql_actualizar_cantidad = "UPDATE carrito SET cantidad = cantidad - ? WHERE id = ?";
            $sentencia_actualizar = $conexion_bd->prepare($sql_actualizar_cantidad);
            $sentencia_actualizar->bind_param("ii", $cantidad_a_modificar, $id_producto);
            if ($sentencia_actualizar->execute()) {
                echo "Cantidad actualizada";
            } else {
                echo "Error al actualizar la cantidad: " . $sentencia_actualizar->error;
            }
            $sentencia_actualizar->close();
        }
    } else {
        echo "Producto no encontrado";
    }

    $sentencia_verificar->close();
} else {
    echo "ID de producto o cantidad no válida";
}

// Cerrar conexión
$conexion_bd->close();
?>
