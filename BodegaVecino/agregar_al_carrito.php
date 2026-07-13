<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Indicamos que responderemos en formato JSON
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $precio = isset($_POST['precio']) ? $_POST['precio'] : '';
    $imagen = isset($_POST['imagen']) ? $_POST['imagen'] : '';

    if (!empty($id)) {
        if (!isset($_SESSION['carrito'])) { 
            $_SESSION['carrito'] = []; 
        }

        if (isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id]['cantidad'] += 1;
        } else {
            $_SESSION['carrito'][$id] = [
                'nombre' => $nombre, 
                'precio' => $precio, 
                'imagen' => $imagen, 
                'cantidad' => 1
            ];
        }

        // Respondemos un JSON de éxito para JavaScript
        echo json_encode(['success' => true, 'nombre' => $nombre]);
        exit;
    }
}

echo json_encode(['success' => false]);
exit;