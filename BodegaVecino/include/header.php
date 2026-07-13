<?php
// Validamos si la sesión ya está iniciada, si no, la iniciamos
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Calculamos el total de artículos en el carrito
$total_articulos = 0;
if (isset($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $item) {
        $total_articulos += $item['cantidad'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bodega El Vecino</title>
    <link rel="stylesheet" href="css/style.css?v=18">
</head>
<body>
    <nav>
        <a class="nav-logo" href="#" onclick="showPage('home')">
            <div class="nav-logo-icon">
                <img src="img/logobodega.png" alt="">
            </div>
            <div class="nav-logo-text">
                <div class="brand">Bodega</div>
                <div class="sub">El Vecino</div>
            </div>
        </a>
        
        <ul class="nav-links">
            <li><a href="index.php" id="nav-inicio">Inicio</a></li>
            <li><a href="productos.php" id="nav-productos">Productos</a></li>
            <li><a href="promociones.php" id="nav-promociones" >Promociones</a></li>
            <li><a href="contactos.php" id="nav-contacto">Contacto</a></li>
        </ul>

        <div class="nav-right" style="display: flex; align-items: center; gap: 15px;">
            <a href="carrito.php" style="text-decoration: none;">
                <button class="cart-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="21" r="1" />
                        <circle cx="20" cy="21" r="1" />
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                    </svg>
                    <span class="cart-badge" id="cart-count"><?php echo $total_articulos; ?></span>
                </button>
            </a>
        
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="color: #4b5563; font-weight: 600; font-size: 14px; font-family: sans-serif;">
                        Hola, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?>
                    </span>
                    <a href="logout.php" style="text-decoration: none;">
                        <button class="btn-login" style="background-color: #374151; border-color: #374151;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                            Salir
                        </button>
                    </a>
                </div>
            <?php else: ?>
                <a href="sesion.php">
                    <button class="btn-login">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                        Iniciar Sesión
                    </button>
                </a>
            <?php endif; ?>
        </div>
    </nav>