<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inicializar el carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// 2. DETECTAMOS PETICIONES POST (Sea AJAX o Clásica)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. VACIAR EL CARRITO COMPLETAMENTE
    if (isset($_POST['accion_vaciar'])) {
        $_SESSION['carrito'] = [];
    }

    // 2. ELIMINAR UN PRODUCTO INDIVIDUAL
    if (isset($_POST['accion_eliminar'])) {
        $id_eliminar = $_POST['producto_id'];
        if (isset($_SESSION['carrito'][$id_eliminar])) {
            unset($_SESSION['carrito'][$id_eliminar]);
        }
    }
    
    // 3. SUMAR / RESTAR CANTIDADES
    if (isset($_POST['accion_cantidad'])) {
        $id_modificar = $_POST['producto_id'];
        $tipo = $_POST['accion_cantidad'];
        
        if ($tipo === 'sumar') {
            if (isset($_SESSION['carrito'][$id_modificar])) {
                $_SESSION['carrito'][$id_modificar]['cantidad'] += 1;
            } else if (!empty($_POST['nombre'])) {
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
                if ($_SESSION['carrito'][$id_modificar]['cantidad'] <= 0) {
                    unset($_SESSION['carrito'][$id_modificar]);
                }
            }
        }
    }

    // --- RESPUESTA AJAX QUIRÚRGICA ---
    if (isset($_POST['is_ajax']) && $_POST['is_ajax'] === 'true') {
        // Recalculamos estadísticas del carrito en caliente
        $total_articulos = 0;
        $subtotal_carrito = 0.00;
        $item_subtotal_actualizado = 0.00;
        $item_cantidad_actualizada = 0;
        $existe_item = false;

        foreach ($_SESSION['carrito'] as $id => $item) {
            $total_articulos += $item['cantidad'];
            $subtotal_carrito += ($item['precio'] * $item['cantidad']);
            
            if (isset($id_modificar) && $id == $id_modificar) {
                $item_subtotal_actualizado = $item['precio'] * $item['cantidad'];
                $item_cantidad_actualizada = $item['cantidad'];
                $existe_item = true;
            }
        }

        $costo_delivery = ($subtotal_carrito > 20.00 || $subtotal_carrito == 0) ? 0.00 : 5.00;
        $total_final = $subtotal_carrito + $costo_delivery;

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'total_articulos' => $total_articulos,
            'subtotal_carrito' => number_format($subtotal_carrito, 2),
            'costo_delivery' => $costo_delivery == 0 ? 'Gratis' : 'S/ ' . number_format($costo_delivery, 2),
            'total_final' => number_format($total_final, 2),
            // Datos del ítem modificado individualmente
            'id_modificado' => $id_modificar ?? null,
            'existe_item' => $existe_item,
            'item_cantidad' => $item_cantidad_actualizada,
            'item_subtotal' => number_format($item_subtotal_actualizado, 2)
        ]);
        exit();
    }

    // Si por alguna razón es una petición clásica, redirecciona normalmente
    header("Location: carrito.php");
    exit();
}

// Cálculos iniciales para la carga síncrona
$total_articulos = 0;
$subtotal_carrito = 0.00;

foreach ($_SESSION['carrito'] as $item) {
    $total_articulos += $item['cantidad'];
    $subtotal_carrito += ($item['precio'] * $item['cantidad']);
}

$costo_delivery = ($subtotal_carrito > 20.00 || $subtotal_carrito == 0) ? 0.00 : 5.00;
$total_final = $subtotal_carrito + $costo_delivery;

include 'include/header.php';
?>

<main style="background-color: #f8f9fa; padding: 40px 20px; font-family: sans-serif; min-height: 80vh; box-sizing: border-box;">
    <div style="max-width: 1200px; margin: 0 auto;" id="contenedor-principal-carrito">

        <section id="seccion-vacio" style="<?php echo ($total_articulos === 0) ? 'display: block;' : 'display: none;'; ?> background: white; padding: 60px 40px; text-align: center; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); max-width: 600px; margin: 40px auto;">
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

        <div id="seccion-con-productos" style="<?php echo ($total_articulos > 0) ? 'display: block;' : 'display: none;'; ?>">
            
            <h1 style="font-size: 28px; font-weight: bold; margin-bottom: 5px; color: #111827;">Carrito de Compras</h1>
            <p style="color: #6b7280; font-size: 14px; margin-bottom: 30px;">Revisa tus productos antes de finalizar la compra</p>
            
            <div style="display: flex; gap: 30px; flex-wrap: wrap; align-items: flex-start;">
                
                <div style="flex: 2; min-width: 320px; background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 24px;">
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f3f4f6; padding-bottom: 15px; margin-bottom: 20px;">
                        <h2 style="font-size: 18px; font-weight: bold; color: #111827; margin: 0;">Productos (<span class="js-total-items-badge"><?php echo $total_articulos; ?></span>)</h2>
                        <form class="js-form-carrito" style="margin: 0;">
                            <input type="hidden" name="accion_vaciar" value="1">
                            <button type="submit" style="background: none; border: none; color: #dc2626; font-weight: 600; cursor: pointer; font-size: 14px;">Vaciar Carrito</button>
                        </form>
                    </div>

                    <div id="wrapper-productos-carrito">
                        <?php foreach ($_SESSION['carrito'] as $id => $item): 
                            $subtotal_item = $item['precio'] * $item['cantidad'];
                            
                            $categoria = "Abarrotes";
                            if (strpos(strtolower($item['nombre']), 'queso') !== false || strpos(strtolower($item['nombre']), 'leche') !== false) {
                                $categoria = "Lácteos";
                            }
                        ?>
                            <div class="js-product-row" data-id="<?php echo $id; ?>" style="display: flex; gap: 20px; padding: 20px 0; border-bottom: 1px solid #f3f4f6; flex-wrap: wrap;">
                                
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
                                        <form class="js-form-carrito" style="margin: 0;">
                                            <input type="hidden" name="producto_id" value="<?php echo $id; ?>">
                                            <input type="hidden" name="accion_cantidad" value="restar">
                                            <button type="submit" style="width: 28px; height: 28px; background-color: #f3f4f6; border: none; border-radius: 6px; font-size: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center; color: #4b5563;">−</button>
                                        </form>
                                        
                                        <span class="js-item-cantidad" style="font-weight: 600; font-size: 14px; width: 20px; text-align: center; color: #111827;"><?php echo $item['cantidad']; ?></span>
                                        
                                        <form class="js-form-carrito" style="margin: 0;">
                                            <input type="hidden" name="producto_id" value="<?php echo $id; ?>">
                                            <input type="hidden" name="accion_cantidad" value="sumar">
                                            <button type="submit" style="width: 28px; height: 28px; background-color: #f3f4f6; border: none; border-radius: 6px; font-size: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center; color: #4b5563;">+</button>
                                        </form>
                                    </div>
                                </div>
                                
                                <div style="display: flex; flex-direction: column; justify-content: space-between; align-items: flex-end; min-width: 100px; margin-left: auto;">
                                    <form class="js-form-carrito" style="margin: 0;">
                                        <input type="hidden" name="producto_id" value="<?php echo $id; ?>">
                                        <input type="hidden" name="accion_eliminar" value="1">
                                        <button type="submit" style="background: none; border: none; color: #9ca3af; cursor: pointer; padding: 4px;" onmouseover="this.style.color='#dc2626'" onmouseout="this.style.color='#9ca3af'">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            </svg>
                                        </button>
                                    </form>
                                    
                                    <div style="text-align: right;">
                                        <span style="font-size: 12px; color: #9ca3af; display: block; margin-bottom: 2px;">Subtotal</span>
                                        <span style="font-weight: bold; color: #111827; font-size: 15px;">S/ <span class="js-item-subtotal"><?php echo number_format($subtotal_item, 2); ?></span></span>
                                    </div>
                                </div>

                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div style="flex: 1; min-width: 300px; display: flex; flex-direction: column; gap: 20px;">
                    
                    <div style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 24px;">
                        <h2 style="font-size: 18px; font-weight: bold; color: #111827; margin: 0 0 20px 0; border-bottom: 1px solid #f3f4f6; padding-bottom: 12px;">Resumen del Pedido</h2>
                        
                        <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 15px; color: #4b5563;">
                            <span>Subtotal</span>
                            <span style="color: #111827; font-weight: 500;">S/ <span id="resumen-subtotal"><?php echo number_format($subtotal_carrito, 2); ?></span></span>
                        </div>
                        
                        <div style="display: flex; justify-content: space-between; margin-bottom: 16px; font-size: 15px; color: #4b5563; border-bottom: 1px solid #f3f4f6; padding-bottom: 16px;">
                            <span>Delivery</span>
                            <span id="resumen-delivery" style="<?php echo ($costo_delivery == 0.00) ? 'color: #eab308; font-weight: bold;' : 'color: #111827; font-weight: 500;'; ?>">
                                <?php echo ($costo_delivery == 0.00) ? 'Gratis' : 'S/ ' . number_format($costo_delivery, 2); ?>
                            </span>
                        </div>
                        
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                            <span style="font-size: 16px; font-weight: bold; color: #111827;">Total</span>
                            <span style="font-size: 20px; font-weight: bold; color: #dc2626;">S/ <span id="resumen-total"><?php echo number_format($total_final, 2); ?></span></span>
                        </div>
                        
                        <?php if (isset($_SESSION['usuario_id'])): ?>
                            <a href="procesar_compra.php" style="display: block; width: 100%; text-align: center; background-color: #dc2626; color: white; border: none; padding: 14px; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer; margin-bottom: 12px; text-decoration: none; box-sizing: border-box;">
                                Finalizar Compra
                            </a>
                        <?php else: ?>
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
            
        </div>
        
    </div>
</main>

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
document.addEventListener('DOMContentLoaded', function() {
    
    // Función central para interceptar los formularios del carrito
    document.addEventListener('submit', function(e) {
        const form = e.target.closest('.js-form-carrito');
        if (!form) return; // Si no es un formulario del carrito, lo ignoramos

        e.preventDefault();
        e.stopPropagation();

        const formData = new FormData(form);
        formData.append('is_ajax', 'true'); // Le indicamos al servidor que responda JSON

        fetch('carrito.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // 1. Si el carrito quedó completamente vacío, mostramos la sección vacía
                if (data.total_articulos <= 0) {
                    document.getElementById('seccion-con-productos').style.display = 'none';
                    document.getElementById('seccion-vacio').style.display = 'block';
                    
                    // Actualizar contador del header a 0
                    actualizarHeaderBadge(0);
                    return;
                }

                // 2. Si fue una acción de vaciar completo (pero que por error no redujo a 0)
                if (formData.has('accion_vaciar')) {
                    document.getElementById('seccion-con-productos').style.display = 'none';
                    document.getElementById('seccion-vacio').style.display = 'block';
                    actualizarHeaderBadge(0);
                    return;
                }

                // 3. Modificación quirúrgica del producto modificado
                if (data.id_modificado) {
                    const productRow = document.querySelector(`.js-product-row[data-id="${data.id_modificado}"]`);
                    
                    if (productRow) {
                        if (data.existe_item) {
                            // Si el ítem aún existe, actualizamos su cantidad y su subtotal individual
                            const cantLabel = productRow.querySelector('.js-item-cantidad');
                            const subtotalLabel = productRow.querySelector('.js-item-subtotal');
                            
                            if (cantLabel) cantLabel.textContent = data.item_cantidad;
                            if (subtotalLabel) subtotalLabel.textContent = data.item_subtotal;
                        } else {
                            // Si fue restado hasta llegar a 0 o se usó el botón eliminar: removemos el nodo de la interfaz de forma limpia
                            productRow.remove();
                        }
                    }
                }

                // 4. Actualizamos los badges e indicadores de cantidades totales
                const badgeArticulos = document.querySelector('.js-total-items-badge');
                if (badgeArticulos) badgeArticulos.textContent = data.total_articulos;

                actualizarHeaderBadge(data.total_articulos);

                // 5. Actualizamos el cuadro resumen de precios lateral
                document.getElementById('resumen-subtotal').textContent = data.subtotal_carrito;
                
                const deliveryLabel = document.getElementById('resumen-delivery');
                if (deliveryLabel) {
                    deliveryLabel.textContent = data.costo_delivery;
                    if (data.costo_delivery === 'Gratis') {
                        deliveryLabel.style.color = '#eab308';
                        deliveryLabel.style.fontWeight = 'bold';
                    } else {
                        deliveryLabel.style.color = '#111827';
                        deliveryLabel.style.fontWeight = '500';
                    }
                }

                document.getElementById('resumen-total').textContent = data.total_final;
            }
        })
        .catch(error => {
            console.error('Error al actualizar el carrito mediante AJAX:', error);
        });
    });

    // Función auxiliar para actualizar el contador de ítems del header
    function actualizarHeaderBadge(totalItems) {
        const cartBadge = document.querySelector('.cart-count') || document.querySelector('.carrito-count') || document.querySelector('[class*="cart"] span');
        if (cartBadge) {
            cartBadge.textContent = totalItems;
        }
    }
});
</script>

<?php include 'include/footer.php'; ?>
