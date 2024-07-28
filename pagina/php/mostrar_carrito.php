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

$query = "SELECT * FROM carrito";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = htmlspecialchars($row['id']);
        $nombre = htmlspecialchars($row['nombre']);
        $precio = htmlspecialchars($row['precio']);
        $imagen = htmlspecialchars($row['imagen']);
        $cantidad = htmlspecialchars($row['cantidad']);

        // Convertir el precio a un formato que pueda ser utilizado para cálculos (sin símbolos de moneda ni comas)
        $precioFormateado = number_format($precio, 2, '.', '');

        echo '<div class="item" style="display: flex; flex-direction: row; margin-bottom: 20px;">';
        echo '    <div class="product-image" style="order: 2; flex: 1;">';
        echo '        <img src="/pagina/imagenes/' . $imagen . '" alt="' . $nombre . '" style="width: 150px; height: auto;">';
        echo '    </div>';
        echo '    <div class="product-details" style="order: 1; flex: 2; text-align: left;">';
        echo '        <h2>' . $nombre . '</h2>';
        echo '        <p class="precio" style="display: none;">' . $precioFormateado . '</p>'; // Precio oculto para cálculos
        echo '        <p><strong>Precio:</strong> ' . number_format($precio, 2) . ' USA</p>';
        echo '        <p><strong>Cantidad:</strong> <span class="cantidad">' . $cantidad . '</span></p>';
        echo '        <input type="number" id="cantidad_' . $id . '" value="1" min="1" max="' . $cantidad . '">';
        echo '        <button onclick="eliminarCantidad(\'' . $id . '\', document.getElementById(\'cantidad_' . $id . '\').value)">Eliminar Cantidad</button>';
        echo '    </div>';
        echo '</div>';
    }
} else {
    echo '<p>El carrito está vacío.</p>';
}

$conn->close();
?>
