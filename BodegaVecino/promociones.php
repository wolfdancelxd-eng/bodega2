<?php 
// 1. INICIALIZAMOS LA SESIÓN ARRIBA DE TODO
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. DETECTAMOS SI SE ENVIÓ UN PRODUCTO AL CARRITO DESDE ESTA PÁGINA (Petición AJAX / Sin pestañeo)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ajax_agregar'])) {
    $id = $_POST['producto_id'];
    $nombre = $_POST['producto_nombre'];
    $precio = (float)$_POST['producto_precio'];
    $imagen = $_POST['producto_imagen'];

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
    
    // Lista de stocks iniciales mapeada para las promociones vigentes
    $stocks_iniciales = [
        '1' => 45,  // Arroz Costeño
        '3' => 60,  // Azúcar Blanca
        '5' => 120, // Coca Cola 2L
        '9' => 55,  // Leche Gloria
        '21' => 60  // Galletas Oreo
    ];

    $stock_inicial = $stocks_iniciales[$id] ?? 0;
    $cantidad_en_carrito = $_SESSION['carrito'][$id]['cantidad'];
    $nuevo_stock = max(0, $stock_inicial - $cantidad_en_carrito);

    // Sumamos el total de ítems en carrito para actualizar el header global
    $total_items = array_sum(array_column($_SESSION['carrito'], 'cantidad'));

    // Respondemos JSON inmediato
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'nombre' => $nombre,
        'nuevo_stock' => $nuevo_stock,
        'total_items' => $total_items
    ]);
    exit();
}

include 'include/header.php'; 
?>

<div id="page-promociones">
    <section class="hero-promo">
          <div class="promo-text">
             <div class="promo-img">
                <img src="img/Sale Price Tag.png" alt="">
            </div>
                <h1>Promociones Especiales</h1>
                <p>Aprovecha nuestros descuentos exclusivos de la semana</p>
                <div class="hero-btns">
                    <div class="cuadro-yellow">Válido hasta el Domingo 15 de Junio</div>
                </div>
            </div>
    </section>

    <main>

<!--Promo tops principales-->
<div class="container-promo">
    <div class="top">
       <div class="cont-top">
         <div class="logo-top"><p>Top 1</p></div>
         <h2>Coca cola 2 Litros</h2>
         <div>
           <span class="price-current">S/ 4.40</span>
           <span class="price-original">S/5.50</span>
         </div>
         <p>Ahorra S/1.10</p>
       </div>
       <div class="cont-desc"><p>-20%</p></div>
    </div>

    <div class="top">
        <div class="cont-top">
          <div class="logo-top"><p>Top 2</p></div>
          <h2>Azúcar Blanca 1kg</h2>
          <div>
             <span class="price-current">S/ 2.72</span>
             <span class="price-original">S/3.20</span>
          </div>
          <p>Ahorra S/ 3.20</p>
        </div>   
        <div class="cont-desc"><p>-15%</p></div>  
    </div>

    <div class="top">
        <div class="cont-top">
            <div class="logo-top"><p>Top 3</p></div>
            <h2>Detergente Ariel 1kg</h2>
            <div>
              <span class="price-current">S/ 13.64</span>
              <span class="price-original">S/15.50</span>
            </div>
            <p>Ahorra S/ 1.86</p>
        </div>
        <div class="cont-desc"><p>-12%</p></div>
    </div>
</div>

<!--Encabezado promociones-->
        <div class="promotions-header">
            <h1>Promociones Vigentes</h1>
            <p>Descuentos especiales para ti esta semana</p>
        </div>

<!--Categoria de promociones en un grid-->
        <div class="promotions-grid">
            
            <!-- PRODUCTO 1: Arroz Costeño (ID 1 de tu catálogo) -->
            <?php
            $stock_inicial_1 = 45;
            $cant_carrito_1 = isset($_SESSION['carrito']['1']) ? $_SESSION['carrito']['1']['cantidad'] : 0;
            $stock_final_1 = $stock_inicial_1 - $cant_carrito_1;
            ?>
            <div class="promo-product-card">
                <div class="product-img" style="height:200px;">
                    <div class="product-img-ph"><img src="https://plazavea.vteximg.com.br/arquivos/ids/27552446-512-512/433778.jpg" alt=""></div><span class="discount-badge">-10%</span>
                    
                    <span class="stock-badge js-stock-label">
                        <?php if ($stock_final_1 > 0): ?>
                            <img src="img/Cardboard Box.png" alt=""> <span class="stock-numero"><?php echo $stock_final_1; ?></span> disponibles
                        <?php else: ?>
                            <span class="badge-agotado" style="color: #ff4d4d; font-weight: bold;">Agotado</span>
                        <?php endif; ?>
                    </span>
                </div>
                <form class="product-body form-agregar-carrito">
                    <span class="product-category">Abarrotes</span>
                    <div class="product-name">Arroz Costeño 1kg</div>
                    <div class="product-price"><span class="price-current">S/ 4.05</span><span class="price-original">S/ 4.50</span></div>
                    
                    <input type="hidden" name="producto_id" value="1">
                    <input type="hidden" name="producto_nombre" value="Arroz Costeño 1kg">
                    <input type="hidden" name="producto_precio" value="4.05">
                    <input type="hidden" name="producto_imagen" value="https://plazavea.vteximg.com.br/arquivos/ids/27552446-512-512/433778.jpg">
                    
                    <button type="submit" class="btn-add-cart js-btn-submit" <?php echo ($stock_final_1 <= 0) ? 'disabled style="background-color: #ccc; cursor: not-allowed;"' : ''; ?>>
                        <?php echo ($stock_final_1 > 0) ? '<img src="img/Shopping Cart.png" alt=""> Agregar al Carrito' : 'Agotado'; ?>
                    </button>
                </form>
            </div>

            <!-- PRODUCTO 2: Azúcar Blanca (ID 3 de tu catálogo) -->
            <?php
            $stock_inicial_3 = 60;
            $cant_carrito_3 = isset($_SESSION['carrito']['3']) ? $_SESSION['carrito']['3']['cantidad'] : 0;
            $stock_final_3 = $stock_inicial_3 - $cant_carrito_3;
            ?>
            <div class="promo-product-card">
                <div class="product-img" style="height:200px;">
                    <div class="product-img-ph"><img src="https://plazavea.vteximg.com.br/arquivos/ids/423250-450-450/20198551.jpg?v=637377101398200000" alt=""></div><span class="discount-badge">-15%</span>
                    
                    <span class="stock-badge js-stock-label">
                        <?php if ($stock_final_3 > 0): ?>
                            <img src="img/Cardboard Box.png" alt=""> <span class="stock-numero"><?php echo $stock_final_3; ?></span> disponibles
                        <?php else: ?>
                            <span class="badge-agotado" style="color: #ff4d4d; font-weight: bold;">Agotado</span>
                        <?php endif; ?>
                    </span>
                </div>
                <form class="product-body form-agregar-carrito">
                    <span class="product-category">Abarrotes</span>
                    <div class="product-name">Azúcar Blanca 1kg</div>
                    <div class="product-price"><span class="price-current">S/ 2.72</span><span class="price-original">S/ 3.20</span></div>
                    
                    <input type="hidden" name="producto_id" value="3">
                    <input type="hidden" name="producto_nombre" value="Azúcar Blanca 1kg">
                    <input type="hidden" name="producto_precio" value="2.72">
                    <input type="hidden" name="producto_imagen" value="https://plazavea.vteximg.com.br/arquivos/ids/423250-450-450/20198551.jpg?v=637377101398200000">
                    
                    <button type="submit" class="btn-add-cart js-btn-submit" <?php echo ($stock_final_3 <= 0) ? 'disabled style="background-color: #ccc; cursor: not-allowed;"' : ''; ?>>
                        <?php echo ($stock_final_3 > 0) ? '<img src="img/Shopping Cart.png" alt=""> Agregar al Carrito' : 'Agotado'; ?>
                    </button>
                </form>
            </div>

            <!-- PRODUCTO 3: Coca Cola (ID 5 de tu catálogo) -->
            <?php
            $stock_inicial_5 = 120;
            $cant_carrito_5 = isset($_SESSION['carrito']['5']) ? $_SESSION['carrito']['5']['cantidad'] : 0;
            $stock_final_5 = $stock_inicial_5 - $cant_carrito_5;
            ?>
            <div class="promo-product-card">
                <div class="product-img" style="height:200px;">
                    <div class="product-img-ph"><img src="https://wongfood.vtexassets.com/arquivos/ids/681539/Twopack-Gaseosa-Coca-Cola-Sabor-Original-Botella-2-5L-1-256656667.jpg?v=638381183635800000" alt=""></div><span class="discount-badge">-20%</span>
                    
                    <span class="stock-badge js-stock-label">
                        <?php if ($stock_final_5 > 0): ?>
                            <img src="img/Cardboard Box.png" alt=""> <span class="stock-numero"><?php echo $stock_final_5; ?></span> disponibles
                        <?php else: ?>
                            <span class="badge-agotado" style="color: #ff4d4d; font-weight: bold;">Agotado</span>
                        <?php endif; ?>
                    </span>
                </div>
                <form class="product-body form-agregar-carrito">
                    <span class="product-category">Bebidas</span>
                    <div class="product-name">Coca Cola 2L</div>
                    <div class="product-price"><span class="price-current">S/ 4.40</span><span class="price-original">S/ 5.50</span></div>
                    
                    <input type="hidden" name="producto_id" value="5">
                    <input type="hidden" name="producto_nombre" value="Coca Cola 2L">
                    <input type="hidden" name="producto_precio" value="4.40">
                    <input type="hidden" name="producto_imagen" value="https://wongfood.vtexassets.com/arquivos/ids/681539/Twopack-Gaseosa-Coca-Cola-Sabor-Original-Botella-2-5L-1-256656667.jpg?v=638381183635800000">
                    
                    <button type="submit" class="btn-add-cart js-btn-submit" <?php echo ($stock_final_5 <= 0) ? 'disabled style="background-color: #ccc; cursor: not-allowed;"' : ''; ?>>
                        <?php echo ($stock_final_5 > 0) ? '<img src="img/Shopping Cart.png" alt=""> Agregar al Carrito' : 'Agotado'; ?>
                    </button>
                </form>
            </div>

            <!-- PRODUCTO 4: Leche Gloria (ID 9 de tu catálogo) -->
            <?php
            $stock_inicial_9 = 55;
            $cant_carrito_9 = isset($_SESSION['carrito']['9']) ? $_SESSION['carrito']['9']['cantidad'] : 0;
            $stock_final_9 = $stock_inicial_9 - $cant_carrito_9;
            ?>
            <div class="promo-product-card">
                <div class="product-img" style="height:200px;">
                    <div class="product-img-ph"><img src="https://plazavea.vteximg.com.br/arquivos/ids/35081437-418-418/358217.jpg" alt=""></div><span class="discount-badge">-8%</span>
                    
                    <span class="stock-badge js-stock-label">
                        <?php if ($stock_final_9 > 0): ?>
                            <img src="img/Cardboard Box.png" alt=""> <span class="stock-numero"><?php echo $stock_final_9; ?></span> disponibles
                        <?php else: ?>
                            <span class="badge-agotado" style="color: #ff4d4d; font-weight: bold;">Agotado</span>
                        <?php endif; ?>
                    </span>
                </div>
                <form class="product-body form-agregar-carrito">
                    <span class="product-category">Lácteos</span>
                    <div class="product-name">Leche Gloria 1L</div>
                    <div class="product-price"><span class="price-current">S/ 3.86</span><span class="price-original">S/ 4.20</span></div>
                    
                    <input type="hidden" name="producto_id" value="9">
                    <input type="hidden" name="producto_nombre" value="Leche Gloria 1L">
                    <input type="hidden" name="producto_precio" value="3.86">
                    <input type="hidden" name="producto_imagen" value="https://plazavea.vteximg.com.br/arquivos/ids/35081437-418-418/358217.jpg">
                    
                    <button type="submit" class="btn-add-cart js-btn-submit" <?php echo ($stock_final_9 <= 0) ? 'disabled style="background-color: #ccc; cursor: not-allowed;"' : ''; ?>>
                        <?php echo ($stock_final_9 > 0) ? '<img src="img/Shopping Cart.png" alt=""> Agregar al Carrito' : 'Agotado'; ?>
                    </button>
                </form>
            </div>

            <!-- PRODUCTO 5: Galletas Oreo (ID 21) -->
            <?php
            $stock_inicial_21 = 60;
            $cant_carrito_21 = isset($_SESSION['carrito']['21']) ? $_SESSION['carrito']['21']['cantidad'] : 0;
            $stock_final_21 = $stock_inicial_21 - $cant_carrito_21;
            ?>
            <div class="promo-product-card">
                <div class="product-img" style="height:200px;">
                    <div class="product-img-ph"><img src="https://vegaperu.vtexassets.com/arquivos/ids/166990/142304.jpg?v=638596857101470000" alt=""></div><span class="discount-badge">-8%</span>
                    
                    <span class="stock-badge js-stock-label">
                        <?php if ($stock_final_21 > 0): ?>
                            <img src="img/Cardboard Box.png" alt=""> <span class="stock-numero"><?php echo $stock_final_21; ?></span> disponibles
                        <?php else: ?>
                            <span class="badge-agotado" style="color: #ff4d4d; font-weight: bold;">Agotado</span>
                        <?php endif; ?>
                    </span>
                </div>
                <form class="product-body form-agregar-carrito">
                    <span class="product-category">Snacks</span>
                    <div class="product-name">Galletas Oreo 432g</div>
                    <div class="product-price"><span class="price-current">S/ 6.48</span><span class="price-original">S/ 7.20</span></div>
                    
                    <input type="hidden" name="producto_id" value="21">
                    <input type="hidden" name="producto_nombre" value="Galletas Oreo 432g">
                    <input type="hidden" name="producto_precio" value="6.48">
                    <input type="hidden" name="producto_imagen" value="https://vegaperu.vtexassets.com/arquivos/ids/166990/142304.jpg?v=638596857101470000">
                    
                    <button type="submit" class="btn-add-cart js-btn-submit" <?php echo ($stock_final_21 <= 0) ? 'disabled style="background-color: #ccc; cursor: not-allowed;"' : ''; ?>>
                        <?php echo ($stock_final_21 > 0) ? '<img src="img/Shopping Cart.png" alt=""> Agregar al Carrito' : 'Agotado'; ?>
                    </button>
                </form>
            </div>
        </div>
        
        <div class="promo-sub-cta">
            <h3>¿Quieres recibir nuestras promociones?</h3>
            <p>Suscríbete a nuestro WhatsApp para recibir ofertas exclusivas</p>
            <button class="btn-whatsapp">Suscribirme por WhatsApp</button>
        </div>
    </div>
 </main>

<!-- CONTENEDOR DINÁMICO DE NOTIFICACIONES TOAST (JS) -->
<div id="toast-container" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999;"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const formularios = document.querySelectorAll('.form-agregar-carrito');
    
    formularios.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Evitamos que la página recargue o haga un salto
            e.stopPropagation();

            const formData = new FormData(this);
            formData.append('ajax_agregar', 'true'); // Enviamos la señal para el procesamiento de AJAX

            const tarjetaProducto = this.closest('.promo-product-card');
            const botonSubmit = this.querySelector('.js-btn-submit');

            fetch('promociones.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // 1. Mostrar cartelito flotante apilable en la esquina
                    crearToast(data.nombre);

                    // 2. Modificación de Stock Quirúrgica sin pestañear
                    const tagNumeroStock = tarjetaProducto.querySelector('.stock-numero');
                    const labelStockCompleto = tarjetaProducto.querySelector('.js-stock-label');
                    
                    if (data.nuevo_stock > 0) {
                        if (tagNumeroStock) {
                            tagNumeroStock.textContent = data.nuevo_stock;
                        }
                    } else {
                        // Si se agota, transformamos el contenedor de stock a Agotado
                        if (labelStockCompleto) {
                            labelStockCompleto.innerHTML = `<span class="badge-agotado" style="color: #ff4d4d; font-weight: bold;">Agotado</span>`;
                        }
                        // Deshabilitar el botón de agregar
                        botonSubmit.disabled = true;
                        botonSubmit.style.backgroundColor = '#ccc';
                        botonSubmit.style.cursor = 'not-allowed';
                        botonSubmit.innerHTML = 'Agotado';
                    }

                    // 3. Actualizar el contador del header de forma dinámica
                    const cartBadge = document.querySelector('.cart-count') || document.querySelector('.carrito-count') || document.querySelector('[class*="cart"] span');
                    if (cartBadge) {
                        cartBadge.textContent = data.total_items;
                    }
                }
            })
            .catch(error => {
                console.error('Error al procesar la petición AJAX:', error);
            });
        });
    });
});

// Función creadora de notificaciones sin recargar página (Elegante y flotante)
function crearToast(nombreProducto) {
    const contenedor = document.getElementById("toast-container");
    
    const nuevoToast = document.createElement("div");
    // Estilos limpios, profesionales y idénticos a productos.php
    nuevoToast.style.marginBottom = "10px";
    nuevoToast.style.display = "flex";
    nuevoToast.style.alignItems = "center";
    nuevoToast.style.backgroundColor = "#fff";
    nuevoToast.style.color = "#333";
    nuevoToast.style.padding = "12px 20px";
    nuevoToast.style.borderRadius = "8px";
    nuevoToast.style.boxShadow = "0 4px 15px rgba(0,0,0,0.15)";
    nuevoToast.style.borderLeft = "5px solid #10b981";
    nuevoToast.style.fontFamily = "sans-serif";
    nuevoToast.style.fontSize = "14px";
    nuevoToast.style.opacity = "1";
    nuevoToast.style.transition = "opacity 0.4s ease";

    nuevoToast.innerHTML = `
        <span style="display:inline-flex; align-items:center; justify-content:center; background-color:#10b981; color:white; width:20px; height:20px; border-radius:50%; margin-right:10px; font-weight:bold; font-size:12px;">✓</span>
        <span><strong>${nombreProducto}</strong> agregado al carrito</span>
    `;

    contenedor.appendChild(nuevoToast);

    // Desvanecer y remover de forma programada
    setTimeout(() => {
        nuevoToast.style.opacity = "0";
        setTimeout(() => nuevoToast.remove(), 400);
    }, 3000);
}
</script>

<?php 
 include 'include/footer.php';
?>
