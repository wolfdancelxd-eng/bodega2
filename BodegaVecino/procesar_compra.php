<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Aquí puedes meter la lógica para guardar en base de datos si lo necesitas más adelante.

// 2. Vaciamos el carrito porque la compra ya se realizó
unset($_SESSION['carrito']);

// 3. Incluimos tu cabecera de la bodega para que no pierda el diseño
include 'include/header.php';
?>

<main style="background-color: #f8f9fa; padding: 60px 20px; text-align: center; font-family: sans-serif; min-height: 70vh; display: flex; align-items: center; justify-content: center;">
    <div style="background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); max-width: 500px; width: 100%;">
        <div style="background-color: #d1fae5; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
            <span style="color: #10b981; font-size: 40px; font-weight: bold;">✓</span>
        </div>
        <h1 style="font-size: 28px; font-weight: bold; color: #111827; margin: 0 0 10px 0;">¡Gracias por tu compra!</h1>
        <p style="color: #6b7280; font-size: 16px; margin-bottom: 30px; line-height: 1.5;">Tu pedido en **Bodega El Vecino** ha sido procesado con éxito. Pronto nos pondremos en contacto contigo para la entrega.</p>
        
        <a href="productos.php" style="display: inline-block; background-color: #dc2626; color: white; padding: 14px 28px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 16px;">
            Seguir Comprando
        </a>
    </div>
</main>

<?php 
include 'include/footer.php'; 
?>