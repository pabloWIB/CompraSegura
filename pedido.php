<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $producto_id = $_POST['producto_id'] ?? '';
    $cantidad    = $_POST['cantidad'] ?? '';
    $usuario_id  = $_SESSION['usuario_id'] ?? 0;

    if ($usuario_id === 0) {
        die("Error: Debe iniciar sesion para realizar un pedido.");
    }

    if (!filter_var($producto_id, FILTER_VALIDATE_INT) ||
        !filter_var($cantidad, FILTER_VALIDATE_INT) ||
        $cantidad <= 0) {
        die("Error: Los datos del pedido son invalidos.");
    }

    $stmt_precio = $conn->prepare("SELECT precio FROM productos WHERE id = ?");
    $stmt_precio->bind_param("i", $producto_id);
    $stmt_precio->execute();
    $res_precio = $stmt_precio->get_result();

    if ($res_precio->num_rows === 0) {
        die("Error: El producto seleccionado no existe.");
    }

    $producto    = $res_precio->fetch_assoc();
    $precio_real = $producto['precio'];
    $total       = $precio_real * $cantidad;
    $stmt_precio->close();

    $stmt_pedido = $conn->prepare("INSERT INTO pedidos (usuario_id, producto_id, cantidad, total) VALUES (?, ?, ?, ?)");
    $stmt_pedido->bind_param("iiid", $usuario_id, $producto_id, $cantidad, $total);

    if ($stmt_pedido->execute()) {
        echo "Pedido registrado exitosamente. Total calculado: $" . number_format($total, 2);
    } else {
        echo "Error al registrar el pedido.";
    }
    $stmt_pedido->close();
}
?>
<form method="POST">
  <input type="hidden" name="producto_id" value="1">
  <input type="hidden" name="precio" value="3000">
  Cantidad: <input type="number" name="cantidad" value="1">
  <button type="submit">Confirmar pedido</button>
</form>
