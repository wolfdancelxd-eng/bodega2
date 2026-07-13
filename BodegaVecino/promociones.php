<?php 
// 1. INICIALIZAMOS LA SESIÓN ARRIBA DE TODO
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$mostrar_notificacion = false;
$nombre_producto_agregado = "";

// 2. DETECTAMOS SI SE ENVIÓ UN PRODUCTO AL CARRITO DESDE ESTA PÁGINA
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_agregar'])) {
    $id = $_POST['producto_id'];
    $nombre = $_POST['producto_nombre'];
    $precio = $_POST['producto_precio'];
    $imagen = $_POST['producto_imagen'];

    if (!isset($_SESSION['carrito'])) { 
        $_SESSION['carrito'] = []; 
    }

    if (isset($_SESSION['carrito'][$id])) {
        $_SESSION['carrito'][$id]['cantidad'] += 1;
    } else {
        $_SESSION['carrito'][$id] = ['nombre' => $nombre, 'precio' => $precio, 'imagen' => $imagen, 'cantidad' => 1];
    }
    
    $mostrar_notificacion = true;
    $nombre_producto_agregado = $nombre;
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
                    
                    <?php if ($stock_final_1 > 0): ?>
                        <span class="stock-badge"><img src="img/Cardboard Box.png" alt=""> <?php echo $stock_final_1; ?> disponibles</span>
                    <?php else: ?>
                        <span class="stock-badge" style="background-color: #ff4d4d; color: white;">Agotado</span>
                    <?php endif; ?>
                </div>
                <form action="promociones.php" method="POST" class="product-body">
                    <span class="product-category">Abarrotes</span>
                    <div class="product-name">Arroz Costeño 1kg</div>
                    <div class="product-price"><span class="price-current">S/ 4.05</span><span class="price-original">S/ 4.50</span></div>
                    
                    <input type="hidden" name="producto_id" value="1">
                    <input type="hidden" name="producto_nombre" value="Arroz Costeño 1kg">
                    <input type="hidden" name="producto_precio" value="4.05">
                    <input type="hidden" name="producto_imagen" value="https://plazavea.vteximg.com.br/arquivos/ids/27552446-512-512/433778.jpg">
                    
                    <?php if ($stock_final_1 > 0): ?>
                        <button type="submit" name="btn_agregar" class="btn-add-cart"><img src="img/Shopping Cart.png" alt=""> Agregar al Carrito</button>
                    <?php else: ?>
                        <button type="button" class="btn-add-cart" style="background-color: #ccc; cursor: not-allowed;" disabled>Agotado</button>
                    <?php endif; ?>
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
                    
                    <?php if ($stock_final_3 > 0): ?>
                        <span class="stock-badge"><img src="img/Cardboard Box.png" alt=""> <?php echo $stock_final_3; ?> disponibles</span>
                    <?php else: ?>
                        <span class="stock-badge" style="background-color: #ff4d4d; color: white;">Agotado</span>
                    <?php endif; ?>
                </div>
                <form action="promociones.php" method="POST" class="product-body">
                    <span class="product-category">Abarrotes</span>
                    <div class="product-name">Azúcar Blanca 1kg</div>
                    <div class="product-price"><span class="price-current">S/ 2.72</span><span class="price-original">S/ 3.20</span></div>
                    
                    <input type="hidden" name="producto_id" value="3">
                    <input type="hidden" name="producto_nombre" value="Azúcar Blanca 1kg">
                    <input type="hidden" name="producto_precio" value="2.72">
                    <input type="hidden" name="producto_imagen" value="https://plazavea.vteximg.com.br/arquivos/ids/423250-450-450/20198551.jpg?v=637377101398200000">
                    
                    <?php if ($stock_final_3 > 0): ?>
                        <button type="submit" name="btn_agregar" class="btn-add-cart"><img src="img/Shopping Cart.png" alt=""> Agregar al Carrito</button>
                    <?php else: ?>
                        <button type="button" class="btn-add-cart" style="background-color: #ccc; cursor: not-allowed;" disabled>Agotado</button>
                    <?php endif; ?>
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
                    
                    <?php if ($stock_final_5 > 0): ?>
                        <span class="stock-badge"><img src="img/Cardboard Box.png" alt=""> <?php echo $stock_final_5; ?> disponibles</span>
                    <?php else: ?>
                        <span class="stock-badge" style="background-color: #ff4d4d; color: white;">Agotado</span>
                    <?php endif; ?>
                </div>
                <form action="promociones.php" method="POST" class="product-body">
                    <span class="product-category">Bebidas</span>
                    <div class="product-name">Coca Cola 2L</div>
                    <div class="product-price"><span class="price-current">S/ 4.40</span><span class="price-original">S/ 5.50</span></div>
                    
                    <input type="hidden" name="producto_id" value="5">
                    <input type="hidden" name="producto_nombre" value="Coca Cola 2L">
                    <input type="hidden" name="producto_precio" value="4.40">
                    <input type="hidden" name="producto_imagen" value="https://wongfood.vtexassets.com/arquivos/ids/681539/Twopack-Gaseosa-Coca-Cola-Sabor-Original-Botella-2-5L-1-256656667.jpg?v=638381183635800000">
                    
                    <?php if ($stock_final_5 > 0): ?>
                        <button type="submit" name="btn_agregar" class="btn-add-cart"><img src="img/Shopping Cart.png" alt=""> Agregar al Carrito</button>
                    <?php else: ?>
                        <button type="button" class="btn-add-cart" style="background-color: #ccc; cursor: not-allowed;" disabled>Agotado</button>
                    <?php endif; ?>
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
                    
                    <?php if ($stock_final_9 > 0): ?>
                        <span class="stock-badge"><img src="img/Cardboard Box.png" alt=""> <?php echo $stock_final_9; ?> disponibles</span>
                    <?php else: ?>
                        <span class="stock-badge" style="background-color: #ff4d4d; color: white;">Agotado</span>
                    <?php endif; ?>
                </div>
                <form action="promociones.php" method="POST" class="product-body">
                    <span class="product-category">Lácteos</span>
                    <div class="product-name">Leche Gloria 1L</div>
                    <div class="product-price"><span class="price-current">S/ 3.86</span><span class="price-original">S/ 4.20</span></div>
                    
                    <input type="hidden" name="producto_id" value="9">
                    <input type="hidden" name="producto_nombre" value="Leche Gloria 1L">
                    <input type="hidden" name="producto_precio" value="3.86">
                    <input type="hidden" name="producto_imagen" value="https://plazavea.vteximg.com.br/arquivos/ids/35081437-418-418/358217.jpg">
                    
                    <?php if ($stock_final_9 > 0): ?>
                        <button type="submit" name="btn_agregar" class="btn-add-cart"><img src="img/Shopping Cart.png" alt=""> Agregar al Carrito</button>
                    <?php else: ?>
                        <button type="button" class="btn-add-cart" style="background-color: #ccc; cursor: not-allowed;" disabled>Agotado</button>
                    <?php endif; ?>
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
                    
                    <?php if ($stock_final_21 > 0): ?>
                        <span class="stock-badge"><img src="img/Cardboard Box.png" alt=""> <?php echo $stock_final_21; ?> disponibles</span>
                    <?php else: ?>
                        <span class="stock-badge" style="background-color: #ff4d4d; color: white;">Agotado</span>
                    <?php endif; ?>
                </div>
                <form action="promociones.php" method="POST" class="product-body">
                    <span class="product-category">Snacks</span>
                    <div class="product-name">Galletas Oreo 432g</div>
                    <div class="product-price"><span class="price-current">S/ 6.48</span><span class="price-original">S/ 7.20</span></div>
                    
                    <input type="hidden" name="producto_id" value="21">
                    <input type="hidden" name="producto_nombre" value="Galletas Oreo 432g">
                    <input type="hidden" name="producto_precio" value="6.48">
                    <input type="hidden" name="producto_imagen" value="https://vegaperu.vtexassets.com/arquivos/ids/166990/142304.jpg?v=638596857101470000">
                    
                    <?php if ($stock_final_21 > 0): ?>
                        <button type="submit" name="btn_agregar" class="btn-add-cart"><img src="img/Shopping Cart.png" alt=""> Agregar al Carrito</button>
                    <?php else: ?>
                        <button type="button" class="btn-add-cart" style="background-color: #ccc; cursor: not-allowed;" disabled>Agotado</button>
                    <?php endif; ?>
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

<!-- SCRIPT JAVASCRIPT MANTENEDOR DE SCROLL PARA PROMOCIONES -->
<script>
    // Al presionar el botón, guardamos los píxeles exactos de la pantalla en una variable única
    document.addEventListener("submit", function() {
        localStorage.setItem("posicionScrollPromos", window.scrollY);
    });

    // Al recargar la página, si existe una posición guardada, congelamos la pantalla ahí mismo
    window.addEventListener("load", function() {
        if (localStorage.getItem("posicionScrollPromos") !== null) {
            window.scrollTo(0, parseInt(localStorage.getItem("posicionScrollPromos")));
            localStorage.removeItem("posicionScrollPromos"); // Limpiamos caché
        }
    });
</script>

 <?php 
// 3. MOSTRAMOS LA NOTIFICACIÓN VERDE SI SE AGREGÓ UN PRODUCTO (Opcional, igual que index.php)
if ($mostrar_notificacion): ?>
    <div class="toast-fixed-pure-php">
        <span style="display:inline-flex; align-items:center; justify-content:center; background-color:#10b981; color:white; width:20px; height:20px; border-radius:50%; margin-right:10px; font-weight:bold;">✓</span>
        <span><?php echo htmlspecialchars($nombre_producto_agregado); ?> agregado al carrito</span>
    </div>
<?php endif;

 include 'include/footer.php';
 ?>