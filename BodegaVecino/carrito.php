<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Asegúrate de que el bloque que procesa el POST maneje la inserción inicial:
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. LÓGICA PARA VACIAR EL CARRITO COMPLETAMENTE
    if (isset($_POST['accion_vaciar'])) {
        $_SESSION['carrito'] = []; // Limpiamos el array
    }

    // 2. LÓGICA PARA ELIMINAR UN PRODUCTO INDIVIDUAL (El botoncito del tacho de basura)
    if (isset($_POST['accion_eliminar'])) {
        $id_eliminar = $_POST['producto_id'];
        if (isset($_SESSION['carrito'][$id_eliminar])) {
            unset($_SESSION['carrito'][$id_eliminar]);
        }
    }
    
    // 3. LÓGICA PARA SUMAR / RESTAR CANTIDADES
    if (isset($_POST['accion_cantidad'])) {
        $id_modificar = $_POST['producto_id'];
        $tipo = $_POST['accion_cantidad'];
        
        if ($tipo === 'sumar') {
            if (isset($_SESSION['carrito'][$id_modificar])) {
                $_SESSION['carrito'][$id_modificar]['cantidad'] += 1;
            } else {
                // SI NO EXISTE (Viene de productos.php por primera vez), lo creamos:
                $_SESSION['carrito'][$id_modificar] = [
                    'nombre'   => $_POST['nombre'],
                    'precio'   => (float)$_POST['precio'],
                    'imagen'   => $_POST['imagen'],
                    'cantidad' => 1
                ];
            }
        }
        
        if ($tipo === 'restar') {
            if (isset($_SESSION['carrito'][$id_modificar])) {
                $_SESSION['carrito'][$id_modificar]['cantidad'] -= 1;
                // Si la cantidad llega a 0, eliminamos el producto por completo
                if ($_SESSION['carrito'][$id_modificar]['cantidad'] <= 0) {
                    unset($_SESSION['carrito'][$id_modificar]);
                }
            }
        }
    }

    // CRUCIAL: Si la petición viene de productos.php usando fetch,
    // detenemos la ejecución aquí devolviendo un mensaje limpio.
    if (!empty($_POST['nombre'])) {
        echo "OK: Producto " . $_POST['nombre'] . " guardado en la sesión.";
        exit();
    }

    // Si es una petición clásica dentro de la misma página carrito.php, sí redirecciona
    header("Location: carrito.php");
    exit();
}
// 3. Cálculos de artículos y sub-totales
$total_articulos = 0;
$subtotal_carrito = 0.00;

if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $item) {
        $total_articulos += $item['cantidad'];
        $subtotal_carrito += ($item['precio'] * $item['cantidad']);
    }
}

// Lógica de Delivery (Gratis si es mayor a S/ 20.00, si no S/ 5.00)
$costo_delivery = ($subtotal_carrito > 20.00 || $subtotal_carrito == 0) ? 0.00 : 5.00;
$total_final = $subtotal_carrito + $costo_delivery;

include 'include/header.php';
?>

<main style="background-color: #f8f9fa; padding: 40px 20px; font-family: sans-serif; min-height: 80vh; box-sizing: border-box;">
    <div style="max-width: 1200px; margin: 0 auto;">

        <?php if ($total_articulos === 0): ?>
            <section style="background: white; padding: 60px 40px; text-align: center; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); max-width: 600px; margin: 40px auto;">
                <div style="background-color: #f3f4f6; width: 100px; height: 100px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="1.5" width="50" height="50">
                        <path d="M16 11V7a4 4 0 0 0-8 0v4M5 9h14l1 12H4L5 9z" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h2 style="font-size: 24px; font-weight: bold; color: #111827; margin: 0 0 10px 0;">Tu carrito está vacío</h2>
                <p style="color: #6b7280; font-size: 15px; margin-bottom: 30px; margin-top: 0;">Agrega productos desde nuestro catálogo para comenzar tu compra</p>
                <a href="productos.php" style="display: inline-flex; align-items: center; justify-content: center; background-color: #dc2626; color: white; padding: 14px 28px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 16px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18" style="margin-right: 8px;">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                    Ir a Productos
                </a>
            </section>

        <?php else: ?>
            
            <h1 style="font-size: 28px; font-weight: bold; margin-bottom: 5px; color: #111827;">Carrito de Compras</h1>
            <p style="color: #6b7280; font-size: 14px; margin-bottom: 30px;">Revisa tus productos antes de finalizar la compra</p>
            
            <div style="display: flex; gap: 30px; flex-wrap: wrap; align-items: flex-start;">
                
                <div style="flex: 2; min-width: 320px; background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 24px;">
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f3f4f6; padding-bottom: 15px; margin-bottom: 20px;">
                        <h2 style="font-size: 18px; font-weight: bold; color: #111827; margin: 0;">Productos (<?php echo $total_articulos; ?>)</h2>
                        <form action="carrito.php" method="POST" style="margin: 0;">
                            <button type="submit" name="accion_vaciar" style="background: none; border: none; color: #dc2626; font-weight: 600; cursor: pointer; font-size: 14px;">Vaciar Carrito</button>
                        </form>
                    </div>

                    <?php foreach ($_SESSION['carrito'] as $id => $item): 
                        $subtotal_item = $item['precio'] * $item['cantidad'];
                        
                        $categoria = "Abarrotes";
                        if (strpos(strtolower($item['nombre']), 'queso') !== false || strpos(strtolower($item['nombre']), 'leche') !== false) {
                            $categoria = "Lácteos";
                        }
                    ?>
                        <div style="display: flex; gap: 20px; padding: 20px 0; border-bottom: 1px solid #f3f4f6; flex-wrap: wrap;">
                            
                            <div style="width: 90px; height: 90px; min-width: 90px; max-width: 90px; overflow: hidden; border-radius: 8px; border: 1px solid #e5e7eb;">
                                <img src="<?php echo htmlspecialchars($item['imagen']); ?>" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            
                            <div style="flex: 1; min-width: 200px; display: flex; flex-direction: column; justify-content: space-between;">
                                <div>
                                    <h3 style="font-size: 16px; font-weight: 600; margin: 0 0 4px 0; color: #111827;"><?php echo htmlspecialchars($item['nombre']); ?></h3>
                                    <span style="font-size: 13px; color: #9ca3af; display: block; margin-bottom: 8px;"><?php echo $categoria; ?></span>
                                    <span style="font-size: 16px; font-weight: bold; color: #dc2626;">S/ <?php echo number_format($item['precio'], 2); ?></span>
                                </div>
                                
                                <div style="display: flex; align-items: center; gap: 12px; margin-top: 12px;">
                                    <form action="carrito.php" method="POST" style="margin: 0;">
                                        <input type="hidden" name="producto_id" value="<?php echo $id; ?>">
                                        <button type="submit" name="accion_cantidad" value="restar" style="width: 28px; height: 28px; background-color: #f3f4f6; border: none; border-radius: 6px; font-size: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center; color: #4b5563;">−</button>
                                    </form>
                                    
                                    <span style="font-weight: 600; font-size: 14px; width: 20px; text-align: center; color: #111827;"><?php echo $item['cantidad']; ?></span>
                                    
                                    <form action="carrito.php" method="POST" style="margin: 0;">
                                        <input type="hidden" name="producto_id" value="<?php echo $id; ?>">
                                        <button type="submit" name="accion_cantidad" value="sumar" style="width: 28px; height: 28px; background-color: #f3f4f6; border: none; border-radius: 6px; font-size: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center; color: #4b5563;">+</button>
                                    </form>
                                </div>
                            </div>
                            
                            <div style="display: flex; flex-direction: column; justify-content: space-between; align-items: flex-end; min-width: 100px; margin-left: auto;">
                                <form action="carrito.php" method="POST" style="margin: 0;">
                                    <input type="hidden" name="producto_id" value="<?php echo $id; ?>">
                                    <button type="submit" name="accion_eliminar" style="background: none; border: none; color: #9ca3af; cursor: pointer; padding: 4px;" onmouseover="this.style.color='#dc2626'" onmouseout="this.style.color='#9ca3af'">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        </svg>
                                    </button>
                                </form>
                                
                                <div style="text-align: right;">
                                    <span style="font-size: 12px; color: #9ca3af; display: block; margin-bottom: 2px;">Subtotal</span>
                                    <span style="font-weight: bold; color: #111827; font-size: 15px;">S/ <?php echo number_format($subtotal_item, 2); ?></span>
                                </div>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div style="flex: 1; min-width: 300px; display: flex; flex-direction: column; gap: 20px;">
                    
                    <div style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 24px;">
                        <h2 style="font-size: 18px; font-weight: bold; color: #111827; margin: 0 0 20px 0; border-bottom: 1px solid #f3f4f6; padding-bottom: 12px;">Resumen del Pedido</h2>
                        
                        <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 15px; color: #4b5563;">
                            <span>Subtotal</span>
                            <span style="color: #111827; font-weight: 500;">S/ <?php echo number_format($subtotal_carrito, 2); ?></span>
                        </div>
                        
                        <div style="display: flex; justify-content: space-between; margin-bottom: 16px; font-size: 15px; color: #4b5563; border-bottom: 1px solid #f3f4f6; padding-bottom: 16px;">
                            <span>Delivery</span>
                            <?php if ($costo_delivery == 0.00): ?>
                                <span style="color: #eab308; font-weight: bold;">Gratis</span>
                            <?php else: ?>
                                <span style="color: #111827; font-weight: 500;">S/ <?php echo number_format($costo_delivery, 2); ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                            <span style="font-size: 16px; font-weight: bold; color: #111827;">Total</span>
                            <span style="font-size: 20px; font-weight: bold; color: #dc2626;">S/ <?php echo number_format($total_final, 2); ?></span>
                        </div>
                        
                        <!-- VALIDACIÓN DEL BOTÓN FINALIZAR COMPRA -->
                        <?php if (isset($_SESSION['usuario_id'])): ?>
                            <!-- Si está registrado: Lo manda directo a procesar_compra.php -->
                            <a href="procesar_compra.php" style="display: block; width: 100%; text-align: center; background-color: #dc2626; color: white; border: none; padding: 14px; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer; margin-bottom: 12px; text-decoration: none; box-sizing: border-box;">
                                Finalizar Compra
                            </a>
                        <?php else: ?>
                            <!-- Si no está registrado: Abre el modal emergente -->
                            <button onclick="document.getElementById('modalLogin').style.display='flex'" style="width: 100%; background-color: #dc2626; color: white; border: none; padding: 14px; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer; margin-bottom: 12px;">
                                Finalizar Compra
                            </button>
                        <?php endif; ?>
                        
                        <a href="productos.php" style="display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; background-color: #f3f4f6; color: #4b5563; padding: 14px; border-radius: 8px; font-size: 15px; font-weight: 600; text-decoration: none; box-sizing: border-box; text-align: center; border: 1px solid #e5e7eb;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="19" y1="12" x2="5" y2="12"></line>
                                <polyline points="12 19 5 12 12 5"></polyline>
                            </svg>
                            Seguir Comprando
                        </a>
                    </div>
                    
                    <div style="background-color: #fefce8; border: 1px solid #fef08a; border-radius: 12px; padding: 16px; font-size: 13px; color: #713f12; line-height: 1.5;">
                        <strong style="color: #854d0e;">Delivery Gratis</strong> en compras mayores a S/ 20.00
                    </div>
                    
                </div>
                
            </div>
            
        <?php endif; ?>
        
    </div>
</main>

<!-- MODAL PARA ADVERTIR INICIO DE SESIÓN -->
<div id="modalLogin" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
    <div style="background:white; padding:30px; border-radius:12px; text-align:center; max-width:400px; width:90%; box-shadow:0 4px 6px rgba(0,0,0,0.1); font-family: sans-serif;">
        <h3 style="margin-top:0; color:#111827; font-size: 20px; font-weight: bold;">¡Ups! Debes iniciar sesión</h3>
        <p style="color:#6b7280; margin-bottom:25px; font-size: 14px; line-height: 1.5;">Para finalizar tu compra y procesar tu pedido, por favor entra a tu cuenta.</p>
        <div style="display:flex; flex-direction:column; gap:10px;">
            <a href="sesion.php" style="background:#dc2626; color:white; padding:12px; border-radius:8px; text-decoration:none; font-weight:bold; font-size: 15px; display: block;">Ir al Login</a>
            <button onclick="document.getElementById('modalLogin').style.display='none'" style="background:none; border:1px solid #d1d5db; padding:10px; border-radius:8px; cursor:pointer; color: #4b5563; font-weight: 600; font-size: 14px;">Cerrar</button>
        </div>
    </div>
</div>

<script>
    // Guardamos la posición actual de la pantalla en píxeles al enviar el formulario (+, -, eliminar, vaciar)
    document.addEventListener("submit", function() {
        localStorage.setItem("posicionScrollCarrito", window.scrollY);
    });

    // Al recargar la página, si existe una posición congelada previa, forzamos la vista ahí mismo
    window.addEventListener("load", function() {
        if (localStorage.getItem("posicionScrollCarrito") !== null) {
            window.scrollTo(0, parseInt(localStorage.getItem("posicionScrollCarrito")));
            localStorage.removeItem("posicionScrollCarrito"); // Limpiamos la clave para el próximo evento
        }
    });
</script>

<?php include 'include/footer.php'; ?>
