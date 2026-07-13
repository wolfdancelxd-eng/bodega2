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

// Encabezado de la pagina con include
include 'include/header.php';
?>  
<main>
      <div id="page-home" class="page active">

        <section class="hero">
            <div class="hero-text">
                <h1>¡Bienvenidos a Bodega el Vecino!</h1>
                <p>Tu tienda de barrio con los mejores productos y precios. Delivery rápido y atención personalizada.</p>
                <div class="hero-btns">
                   <a href="productos.php"> <button class="btn-yellow"> Ver Productos →</button></a>
                  <a href="promociones.php"><button class="btn-outline-white">Ver Promociones</button></a>
                </div>
            </div>
            <div class="hero-img">
                <img src="https://images.unsplash.com/photo-1749648537909-67e35a37fbbb?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&w=800" alt="">
            </div>
        </section>

        <div class="features-strip">
            <div class="feature-item">
                <div class="feature-icon"><img src="img/Truck.png" alt=""></div>
                <div>
                    <h3>Delivery Rápido</h3>
                    <p>Entrega en 30 minutes o menos</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon red-bg"><img src="img/Protect.png" alt=""></div>
                <div>
                    <h3>Productos de Calidad</h3>
                    <p>Garantizamos frescura y calidad</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon gray-bg"><img src="img/Clock.png" alt=""></div>
                <div>
                    <h3>Horario Extendido</h3>
                    <p>Abierto todos los días</p>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="section-header">
                <div>
                    <h2>Productos Destacados</h2>
                    <p>Las mejores ofertas de la semana</p>
                </div>
               <a href="productos.php"><button class="ver-todos">Ver Todos →</button></a> 
            </div>
            <div class="products-grid">
                
                <!-- PRODUCTO 1: Arroz Costeño -->
                <?php
                $stock_inicial_1 = 45;
                $cant_carrito_1 = isset($_SESSION['carrito']['1']) ? $_SESSION['carrito']['1']['cantidad'] : 0;
                $stock_final_1 = $stock_inicial_1 - $cant_carrito_1;
                ?>
                <div class="product-card">
                    <div class="product-img">
                        <div class="product-img-ph">
                            <img src="https://wongfood.vtexassets.com/arquivos/ids/660922/Arroz-Extra-Coste-o-Bolsa-750-g-1-4456.jpg?v=638312817732600000" alt="">
                        </div>
                        <span class="discount-badge">-10%</span>
                        
                        <?php if ($stock_final_1 > 0): ?>
                            <span class="stock-badge"><img src="img/Cardboard Box.png" alt=""> <?php echo $stock_final_1; ?> disponibles</span>
                        <?php else: ?>
                            <span class="stock-badge" style="background-color: #ff4d4d; color: white;">Agotado</span>
                        <?php endif; ?>
                    </div>
                    <form action="index.php" method="POST" class="product-body">
                        <span class="product-category">Abarrotes</span>
                        <div class="product-name">Arroz Costeño 1kg</div>
                        <div class="product-price">
                            <span class="price-current">S/ 4.05</span>
                            <span class="price-original">S/ 4.50</span>
                        </div>
                        
                        <input type="hidden" name="producto_id" value="1">
                        <input type="hidden" name="producto_nombre" value="Arroz Costeño 1kg">
                        <input type="hidden" name="producto_precio" value="4.05">
                        <input type="hidden" name="producto_imagen" value="https://wongfood.vtexassets.com/arquivos/ids/660922/Arroz-Extra-Coste-o-Bolsa-750-g-1-4456.jpg?v=638312817732600000">
                        
                        <?php if ($stock_final_1 > 0): ?>
                            <button type="submit" name="btn_agregar" class="btn-add-cart"><img src="img/Shopping Cart.png" alt=""> Agregar al Carrito</button>
                        <?php else: ?>
                            <button type="button" class="btn-add-cart" style="background-color: #ccc; cursor: not-allowed;" disabled>Agotado</button>
                        <?php endif; ?>
                    </form>
                </div>

                <!-- PRODUCTO 3: Azúcar Blanca -->
                <?php
                $stock_inicial_3 = 60;
                $cant_carrito_3 = isset($_SESSION['carrito']['3']) ? $_SESSION['carrito']['3']['cantidad'] : 0;
                $stock_final_3 = $stock_inicial_3 - $cant_carrito_3;
                ?>
                <div class="product-card">
                    <div class="product-img">
                        <div class="product-img-ph">
                            <img src="https://plazavea.vteximg.com.br/arquivos/ids/423247-418-418/20198550.jpg" alt="">
                        </div>
                        <span class="discount-badge">-15%</span>
                        
                        <?php if ($stock_final_3 > 0): ?>
                            <span class="stock-badge"><img src="img/Cardboard Box.png" alt=""> <?php echo $stock_final_3; ?> disponibles</span>
                        <?php else: ?>
                            <span class="stock-badge" style="background-color: #ff4d4d; color: white;">Agotado</span>
                        <?php endif; ?>
                    </div>
                    <form action="index.php" method="POST" class="product-body">
                        <span class="product-category">Abarrotes</span>
                        <div class="product-name">Azúcar Blanca 1kg</div>
                        <div class="product-price">
                            <span class="price-current">S/ 2.72</span>
                            <span class="price-original">S/ 3.20</span>
                        </div>
                        
                        <input type="hidden" name="producto_id" value="3">
                        <input type="hidden" name="producto_nombre" value="Azúcar Blanca 1kg">
                        <input type="hidden" name="producto_precio" value="2.72">
                        <input type="hidden" name="producto_imagen" value="https://plazavea.vteximg.com.br/arquivos/ids/423247-418-418/20198550.jpg">
                        
                        <?php if ($stock_final_3 > 0): ?>
                            <button type="submit" name="btn_agregar" class="btn-add-cart"><img src="img/Shopping Cart.png" alt=""> Agregar al Carrito</button>
                        <?php else: ?>
                            <button type="button" class="btn-add-cart" style="background-color: #ccc; cursor: not-allowed;" disabled>Agotado</button>
                        <?php endif; ?>
                    </form>
                </div>

                <!-- PRODUCTO 5: Coca Cola 2L -->
                <?php
                $stock_inicial_5 = 120;
                $cant_carrito_5 = isset($_SESSION['carrito']['5']) ? $_SESSION['carrito']['5']['cantidad'] : 0;
                $stock_final_5 = $stock_inicial_5 - $cant_carrito_5;
                ?>
                <div class="product-card">
                    <div class="product-img">
                        <div class="product-img-ph">
                            <img src="https://socialdrinks.pe/wp-content/uploads/2024/11/1883_cocacola.jpg" alt="">
                        </div>
                        <span class="discount-badge">-20%</span>
                        
                        <?php if ($stock_final_5 > 0): ?>
                            <span class="stock-badge"><img src="img/Cardboard Box.png" alt=""> <?php echo $stock_final_5; ?> disponibles</span>
                        <?php else: ?>
                            <span class="stock-badge" style="background-color: #ff4d4d; color: white;">Agotado</span>
                        <?php endif; ?>
                    </div>
                    <form action="index.php" method="POST" class="product-body">
                        <span class="product-category">Bebidas</span>
                        <div class="product-name">Coca Cola 2L</div>
                        <div class="product-price">
                            <span class="price-current">S/ 4.40</span>
                            <span class="price-original">S/ 5.50</span>
                        </div>
                        
                        <input type="hidden" name="producto_id" value="5">
                        <input type="hidden" name="producto_nombre" value="Coca Cola 2L">
                        <input type="hidden" name="producto_precio" value="4.40">
                        <input type="hidden" name="producto_imagen" value="https://socialdrinks.pe/wp-content/uploads/2024/11/1883_cocacola.jpg">
                        
                        <?php if ($stock_final_5 > 0): ?>
                            <button type="submit" name="btn_agregar" class="btn-add-cart"><img src="img/Shopping Cart.png" alt=""> Agregar al Carrito</button>
                        <?php else: ?>
                            <button type="button" class="btn-add-cart" style="background-color: #ccc; cursor: not-allowed;" disabled>Agotado</button>
                        <?php endif; ?>
                    </form>
                </div>

                <!-- PRODUCTO 9: Leche Gloria -->
                <?php
                $stock_inicial_9 = 55;
                $cant_carrito_9 = isset($_SESSION['carrito']['9']) ? $_SESSION['carrito']['9']['cantidad'] : 0;
                $stock_final_9 = $stock_inicial_9 - $cant_carrito_9;
                ?>
                <div class="product-card">
                    <div class="product-img">
                        <div class="product-img-ph">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR0r56u8Vd5JOl4IoWSjdbymKy3sDLcJC0xkv6FKssUNg&s=10" alt="">
                        </div>
                        <span class="discount-badge">-8%</span>
                        
                        <?php if ($stock_final_9 > 0): ?>
                            <span class="stock-badge"><img src="img/Cardboard Box.png" alt=""> <?php echo $stock_final_9; ?> disponibles</span>
                        <?php else: ?>
                            <span class="stock-badge" style="background-color: #ff4d4d; color: white;">Agotado</span>
                        <?php endif; ?>
                    </div>
                    <form action="index.php" method="POST" class="product-body">
                        <span class="product-category">Lácteos</span>
                        <div class="product-name">Leche Gloria 1L</div>
                        <div class="product-price">
                            <span class="price-current">S/ 3.86</span>
                            <span class="price-original">S/ 4.20</span>
                        </div>
                        
                        <input type="hidden" name="producto_id" value="9">
                        <input type="hidden" name="producto_nombre" value="Leche Gloria 1L">
                        <input type="hidden" name="producto_precio" value="3.86">
                        <input type="hidden" name="producto_imagen" value="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR0r56u8Vd5JOl4IoWSjdbymKy3sDLcJC0xkv6FKssUNg&s=10">
                        
                        <?php if ($stock_final_9 > 0): ?>
                            <button type="submit" name="btn_agregar" class="btn-add-cart"><img src="img/Shopping Cart.png" alt=""> Agregar al Carrito</button>
                        <?php else: ?>
                            <button type="button" class="btn-add-cart" style="background-color: #ccc; cursor: not-allowed;" disabled>Agotado</button>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </section>

        <section class="promo-section">
            <div class="section-header">
                <h2>Promociones Vigentes</h2>
                <p>Aprovecha estos descuentos especiales</p>
            </div>
            <div class="promos-grid">
                 <div class="product-card">
                    <div class="product-img">
                        <div class="product-img-ph">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTSkhJZ4k3LGtdBqfS-qK2BVJK6vx8sBzcW5VoZfdc8lQ&s=10" alt="">
                        </div>
                        <span class="discount-badge">-20%</span>
                    </div>
                    <div class="product-body">
                        <div class="product-name">Chocolate Sublime</div>
                        <div class="product-price">
                            <span class="price-current">S/ 2.00</span>
                            <span class="price-original">S/ 2.50</span>
                        </div>
                    </div>
                </div>
                 <div class="product-card">
                    <div class="product-img">
                        <div class="product-img-ph">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9F9jYjLF9UnM5I0DLyLLASzJQfX690UfV8YnwYpOAyP-BvOapXlT_gTk&s=100" alt="">
                        </div>
                        <span class="discount-badge">-20%</span>
                    </div>
                    <div class="product-body">
                        <div class="product-name">Filete de Atún Primor 140 g</div>
                        <div class="product-price">
                            <span class="price-current">S/ 6.00</span>
                            <span class="price-original">S/ 7.50</span>
                        </div>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-img">
                        <div class="product-img-ph">
                            <img src="https://tofuu.getjusto.com/orioneat-local/resized2/MBkp7HC2QAvQePhmv-1000-x.webp" alt="">
                        </div>
                        <span class="discount-badge ">-20%</span>
                    </div>
                    <div class="product-body">
                        <div class="product-name">Galletas Casino 43 g</div>
                        <div class="product-price">
                            <span class="price-current">S/ 1.20</span>
                            <span class="price-original">S/ 1.50</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="whatsapp-cta">
            <h3>¿Quieres recibir nuestras promociones?</h3>
            <p>Suscríbete a nuestro WhatsApp para recibir ofertas exclusivas</p>
            <button class="btn-whatsapp">Suscribirme por WhatsApp</button>
        </div>

       <section>
        <div class="titule">
            <h2>Lo que Dicen Nuestros Clientes</h2>
            <br>
            <p>Testimonios reales de nuestra comunidad</p>
        </div>
        <div class="content-coments">
            <div class="coment">
                <img src="img/Group 29.png" alt="">
                <i><p>"Excelente atención y los mejores precios del barrio. Siempre encuentro todo lo que necesito."</p></i>
                <b><p>María González</p></b>   
            </div>
            <div class="coment">
                <img src="img/Group 29.png" alt="">
                <i><p>"El delivery es súper rápido y los productos siempre frescos. ¡Muy recomendado!"</p></i>
                <b><p>Carlos Ramírez</p></b> 
            </div>
            <div class="coment">
                <img src="img/Group 29.png" alt="">
                <i><p>"Me encanta la variedad de productos y las promociones semanales. Mi bodega favorita."</p></i>
                <b><p>Ana Torres</p></b> 
            </div>
        </div>
       </section>

</main>

<!-- SCRIPT JAVASCRIPT MANTENEDOR DE SCROLL -->
<script>
    // Guardamos la posición exacta en píxeles del scroll vertical antes de enviar el formulario
    document.addEventListener("submit", function() {
        localStorage.setItem("posicionScrollIndex", window.scrollY);
    });

    // Al volver a cargar la página tras añadir el producto, restauramos la vista exacta del usuario
    window.addEventListener("load", function() {
        if (localStorage.getItem("posicionScrollIndex") !== null) {
            window.scrollTo(0, parseInt(localStorage.getItem("posicionScrollIndex")));
            localStorage.removeItem("posicionScrollIndex"); // Limpiamos la caché de posición
        }
    });
</script>

<?php
// 3. MOSTRAMOS LA NOTIFICACIÓN VERDE SI SE AGREGÓ UN PRODUCTO
if ($mostrar_notificacion): ?>
    <div class="toast-fixed-pure-php">
        <span style="display:inline-flex; align-items:center; justify-content:center; background-color:#10b981; color:white; width:20px; height:20px; border-radius:50%; margin-right:10px; font-weight:bold;">✓</span>
        <span><?php echo htmlspecialchars($nombre_producto_agregado); ?> agregado al carrito</span>
    </div>
<?php endif;

include 'include/footer.php';
?>
</div>

</body>
</html>