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

//Encabezado de la pagina con include
include 'include/header.php';
?>     
  <main>
    <div id="page-productos">

    <div class="catalog-header">
            <h1>Catálogo de Productos</h1>
            <p>Encuentra todo lo que necesitas para tu hogar</p>
        </div>
        <div class="catalog-filters">
            <input type="text" class="search-box" placeholder="Buscar productos..."
                oninput="filterProducts(this.value)">
            <span class="filter-icon">⚗</span>
            <div class="filter-tabs">
                <button class="filter-tab active" onclick="filterTab(this,'Todos')">Todos</button>
                <button class="filter-tab" onclick="filterTab(this,'Abarrotes')">Abarrotes</button>
                <button class="filter-tab" onclick="filterTab(this,'Bebidas')">Bebidas</button>
                <button class="filter-tab" onclick="filterTab(this,'Lácteos')">Lácteos</button>
                <button class="filter-tab" onclick="filterTab(this,'Limpieza')">Limpieza</button>
                <button class="filter-tab" onclick="filterTab(this,'Snacks')">Snacks</button>
            </div>
        </div>
        <p class="catalog-count" id="catalog-count">Mostrando <strong>20</strong> productos</p>
        <div class="catalog-grid" id="catalog-grid">

            <?php
            $stock_inicial_1 = 45;
            $cant_carrito_1 = isset($_SESSION['carrito']['1']) ? $_SESSION['carrito']['1']['cantidad'] : 0;
            $stock_final_1 = $stock_inicial_1 - $cant_carrito_1;
            ?>
            <div class="product-card" data-cat="Abarrotes">
                <div class="product-img">
                    <div class="product-img-ph"><img src="https://wongfood.vtexassets.com/arquivos/ids/660922/Arroz-Extra-Coste-o-Bolsa-750-g-1-4456.jpg?v=638312817732600000" alt=""></div><span class="discount-badge">-10%</span>
                    <?php if ($stock_final_1 > 0): ?>
                        <span class="stock-badge"><img src="img/Cardboard Box.png" alt=""> <?php echo $stock_final_1; ?> disponibles</span>
                    <?php else: ?>
                        <span class="stock-badge" style="background-color: #ff4d4d; color: white;">Agotado</span>
                    <?php endif; ?>
                </div>
                <form action="productos.php" method="POST" class="product-body"><span class="product-category">Abarrotes</span>
                    <div class="product-name">Arroz Costeño 1kg</div>
                    <div class="product-price"><span class="price-current">S/ 4.05</span><span class="price-original">S/ 4.50</span></div>
                    
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

            <?php
            $stock_inicial_2 = 30;
            $cant_carrito_2 = isset($_SESSION['carrito']['2']) ? $_SESSION['carrito']['2']['cantidad'] : 0;
            $stock_final_2 = $stock_inicial_2 - $cant_carrito_2;
            ?>
            <div class="product-card" data-cat="Abarrotes">
                <div class="product-img">
                    <div class="product-img-ph"><img src="https://mercury.vtexassets.com/arquivos/ids/8617030/image-5b43357ca57f4424a2e7d31c4b6fa8c3.jpg?v=638841439603370000" alt=""></div>
                    <?php if ($stock_final_2 > 0): ?>
                        <span class="stock-badge"><img src="img/Cardboard Box.png" alt=""> <?php echo $stock_final_2; ?> disponibles</span>
                    <?php else: ?>
                        <span class="stock-badge" style="background-color: #ff4d4d; color: white;">Agotado</span>
                    <?php endif; ?>
                </div>
                <form action="productos.php" method="POST" class="product-body"><span class="product-category">Abarrotes</span>
                    <div class="product-name">Aceite Primor 1L</div>
                    <div class="product-price"><span class="price-current">S/ 8.90</span></div>
                    
                    <input type="hidden" name="producto_id" value="2">
                    <input type="hidden" name="producto_nombre" value="Aceite Primor 1L">
                    <input type="hidden" name="producto_precio" value="8.90">
                    <input type="hidden" name="producto_imagen" value="https://mercury.vtexassets.com/arquivos/ids/8617030/image-5b43357ca57f4424a2e7d31c4b6fa8c3.jpg?v=638841439603370000">
                    
                    <?php if ($stock_final_2 > 0): ?>
                        <button type="submit" name="btn_agregar" class="btn-add-cart"><img src="img/Shopping Cart.png" alt=""> Agregar al Carrito</button>
                    <?php else: ?>
                        <button type="button" class="btn-add-cart" style="background-color: #ccc; cursor: not-allowed;" disabled>Agotado</button>
                    <?php endif; ?>
                </form>
            </div>

            <?php
            $stock_inicial_3 = 60;
            $cant_carrito_3 = isset($_SESSION['carrito']['3']) ? $_SESSION['carrito']['3']['cantidad'] : 0;
            $stock_final_3 = $stock_inicial_3 - $cant_carrito_3;
            ?>
            <div class="product-card" data-cat="Abarrotes">
                <div class="product-img">
                    <div class="product-img-ph"><img src="https://plazavea.vteximg.com.br/arquivos/ids/423250-450-450/20198551.jpg?v=637377101398200000" alt=""></div><span class="discount-badge">-15%</span>
                    <?php if ($stock_final_3 > 0): ?>
                        <span class="stock-badge"><img src="img/Cardboard Box.png" alt=""> <?php echo $stock_final_3; ?> disponibles</span>
                    <?php else: ?>
                        <span class="stock-badge" style="background-color: #ff4d4d; color: white;">Agotado</span>
                    <?php endif; ?>
                </div>
                <form action="productos.php" method="POST" class="product-body"><span class="product-category">Abarrotes</span>
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

            <?php
            $stock_inicial_4 = 80;
            $cant_carrito_4 = isset($_SESSION['carrito']['4']) ? $_SESSION['carrito']['4']['cantidad'] : 0;
            $stock_final_4 = $stock_inicial_4 - $cant_carrito_4;
            ?>
            <div class="product-card" data-cat="Abarrotes">
                <div class="product-img">
                    <div class="product-img-ph"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT-KMErDDz3k6GbOn2HwfP8WZGnCAec4pqFjkpoDJO3K4eml5jCNbSnn2S7&s=10" alt=""></div>
                    <?php if ($stock_final_4 > 0): ?>
                        <span class="stock-badge"><img src="img/Cardboard Box.png" alt=""> <?php echo $stock_final_4; ?> disponibles</span>
                    <?php else: ?>
                        <span class="stock-badge" style="background-color: #ff4d4d; color: white;">Agotado</span>
                    <?php endif; ?>
                </div>
                <form action="productos.php" method="POST" class="product-body"><span class="product-category">Abarrotes</span>
                    <div class="product-name">Fideos Don Vittorio 500g</div>
                    <div class="product-price"><span class="price-current">S/ 2.80</span></div>
                    
                    <input type="hidden" name="producto_id" value="4">
                    <input type="hidden" name="producto_nombre" value="Fideos Don Vittorio 500g">
                    <input type="hidden" name="producto_precio" value="2.80">
                    <input type="hidden" name="producto_imagen" value="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT-KMErDDz3k6GbOn2HwfP8WZGnCAec4pqFjkpoDJO3K4eml5jCNbSnn2S7&s=10">
                    
                    <?php if ($stock_final_4 > 0): ?>
                        <button type="submit" name="btn_agregar" class="btn-add-cart"><img src="img/Shopping Cart.png" alt=""> Agregar al Carrito</button>
                    <?php else: ?>
                        <button type="button" class="btn-add-cart" style="background-color: #ccc; cursor: not-allowed;" disabled>Agotado</button>
                    <?php endif; ?>
                </form>
            </div>

            <?php
            $stock_inicial_5 = 120;
            $cant_carrito_5 = isset($_SESSION['carrito']['5']) ? $_SESSION['carrito']['5']['cantidad'] : 0;
            $stock_final_5 = $stock_inicial_5 - $cant_carrito_5;
            ?>
            <div class="product-card" data-cat="Bebidas">
                <div class="product-img">
                    <div class="product-img-ph"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSjo3ppZ7MYeNPA4GMCEoBTM5dTms6FePL5yvFVvLePhhImFN_jgw39Nt4&s=10" alt=""></div><span class="discount-badge">-20%</span>
                    <?php if ($stock_final_5 > 0): ?>
                        <span class="stock-badge"><img src="img/Cardboard Box.png" alt=""> <?php echo $stock_final_5; ?> disponibles</span>
                    <?php else: ?>
                        <span class="stock-badge" style="background-color: #ff4d4d; color: white;">Agotado</span>
                    <?php endif; ?>
                </div>
                <form action="productos.php" method="POST" class="product-body"><span class="product-category">Bebidas</span>
                    <div class="product-name">Coca Cola 2L</div>
                    <div class="product-price"><span class="price-current">S/ 4.40</span><span class="price-original">S/ 5.50</span></div>
                    
                    <input type="hidden" name="producto_id" value="5">
                    <input type="hidden" name="producto_nombre" value="Coca Cola 2L">
                    <input type="hidden" name="producto_precio" value="4.40">
                    <input type="hidden" name="producto_imagen" value="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSjo3ppZ7MYeNPA4GMCEoBTM5dTms6FePL5yvFVvLePhhImFN_jgw39Nt4&s=10">
                    
                    <?php if ($stock_final_5 > 0): ?>
                        <button type="submit" name="btn_agregar" class="btn-add-cart"><img src="img/Shopping Cart.png" alt=""> Agregar al Carrito</button>
                    <?php else: ?>
                        <button type="button" class="btn-add-cart" style="background-color: #ccc; cursor: not-allowed;" disabled>Agotado</button>
                    <?php endif; ?>
                </form>
            </div>

            <?php
            $stock_inicial_6 = 90;
            $cant_carrito_6 = isset($_SESSION['carrito']['6']) ? $_SESSION['carrito']['6']['cantidad'] : 0;
            $stock_final_6 = $stock_inicial_6 - $cant_carrito_6;
            ?>
            <div class="product-card" data-cat="Bebidas">
                <div class="product-img">
                    <div class="product-img-ph"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQUxZk_8cG6NznL6uNPPFnGY2smmj66pTokOYguSV736WBOpcuxruepTS4&s=10" alt=""></div>
                    <?php if ($stock_final_6 > 0): ?>
                        <span class="stock-badge"><img src="img/Cardboard Box.png" alt=""> <?php echo $stock_final_6; ?> disponibles</span>
                    <?php else: ?>
                        <span class="stock-badge" style="background-color: #ff4d4d; color: white;">Agotado</span>
                    <?php endif; ?>
                </div>
                <form action="productos.php" method="POST" class="product-body"><span class="product-category">Bebidas</span>
                    <div class="product-name">Inca Kola 1.5L</div>
                    <div class="product-price"><span class="price-current">S/ 4.80</span></div>
                    
                    <input type="hidden" name="producto_id" value="6">
                    <input type="hidden" name="producto_nombre" value="Inca Kola 1.5L">
                    <input type="hidden" name="producto_precio" value="4.80">
                    <input type="hidden" name="producto_imagen" value="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQUxZk_8cG6NznL6uNPPFnGY2smmj66pTokOYguSV736WBOpcuxruepTS4&s=10">
                    
                    <?php if ($stock_final_6 > 0): ?>
                        <button type="submit" name="btn_agregar" class="btn-add-cart"><img src="img/Shopping Cart.png" alt=""> Agregar al Carrito</button>
                    <?php else: ?>
                        <button type="button" class="btn-add-cart" style="background-color: #ccc; cursor: not-allowed;" disabled>Agotado</button>
                    <?php endif; ?>
                </form>
            </div>

            <?php
            $stock_inicial_7 = 150;
            $cant_carrito_7 = isset($_SESSION['carrito']['7']) ? $_SESSION['carrito']['7']['cantidad'] : 0;
            $stock_final_7 = $stock_inicial_7 - $cant_carrito_7;
            ?>
            <div class="product-card" data-cat="Bebidas">
                <div class="product-img">
                    <div class="product-img-ph"><img src="https://vegaperu.vtexassets.com/arquivos/ids/155546/7750298000727.jpg?v=637612900295230000" alt=""></div>
                    <?php if ($stock_final_7 > 0): ?>
                        <span class="stock-badge"><img src="img/Cardboard Box.png" alt=""> <?php echo $stock_final_7; ?> disponibles</span>
                    <?php else: ?>
                        <span class="stock-badge" style="background-color: #ff4d4d; color: white;">Agotado</span>
                    <?php endif; ?>
                </div>
                <form action="productos.php" method="POST" class="product-body"><span class="product-category">Bebidas</span>
                    <div class="product-name">Agua San Luis 2.5L</div>
                    <div class="product-price"><span class="price-current">S/ 2.50</span></div>
                    
                    <input type="hidden" name="producto_id" value="7">
                    <input type="hidden" name="producto_nombre" value="Agua San Luis 2.5L">
                    <input type="hidden" name="producto_precio" value="2.50">
                    <input type="hidden" name="producto_imagen" value="https://vegaperu.vtexassets.com/arquivos/ids/155546/7750298000727.jpg?v=637612900295230000">
                    
                    <?php if ($stock_final_7 > 0): ?>
                        <button type="submit" name="btn_agregar" class="btn-add-cart"><img src="img/Shopping Cart.png" alt=""> Agregar al Carrito</button>
                    <?php else: ?>
                        <button type="button" class="btn-add-cart" style="background-color: #ccc; cursor: not-allowed;" disabled>Agotado</button>
                    <?php endif; ?>
                </form>
            </div>

            <?php
            $stock_inicial_8 = 75;
            $cant_carrito_8 = isset($_SESSION['carrito']['8']) ? $_SESSION['carrito']['8']['cantidad'] : 0;
            $stock_final_8 = $stock_inicial_8 - $cant_carrito_8;
            ?>
            <div class="product-card" data-cat="Bebidas">
                <div class="product-img">
                    <div class="product-img-ph"><img src="https://http2.mlstatic.com/D_NQ_NP_970566-MLA49961092441_052022-O.webp" alt=""></div>
                    <?php if ($stock_final_8 > 0): ?>
                        <span class="stock-badge"><img src="img/Cardboard Box.png" alt=""> <?php echo $stock_final_8; ?> disponibles</span>
                    <?php else: ?>
                        <span class="stock-badge" style="background-color: #ff4d4d; color: white;">Agotado</span>
                    <?php endif; ?>
                </div>
                <form action="productos.php" method="POST" class="product-body"><span class="product-category">Bebidas</span>
                    <div class="product-name">Gaseosa Sprite 1.5L</div>
                    <div class="product-price"><span class="price-current">S/ 4.50</span></div>
                    
                    <input type="hidden" name="producto_id" value="8">
                    <input type="hidden" name="producto_nombre" value="Gaseosa Sprite 1.5L">
                    <input type="hidden" name="producto_precio" value="4.50">
                    <input type="hidden" name="producto_imagen" value="https://http2.mlstatic.com/D_NQ_NP_970566-MLA49961092441_052022-O.webp">
                    
                    <?php if ($stock_final_8 > 0): ?>
                        <button type="submit" name="btn_agregar" class="btn-add-cart"><img src="img/Shopping Cart.png" alt=""> Agregar al Carrito</button>
                    <?php else: ?>
                        <button type="button" class="btn-add-cart" style="background-color: #ccc; cursor: not-allowed;" disabled>Agotado</button>
                    <?php endif; ?>
                </form>
            </div>

            <?php
            $stock_inicial_9 = 55;
            $cant_carrito_9 = isset($_SESSION['carrito']['9']) ? $_SESSION['carrito']['9']['cantidad'] : 0;
            $stock_final_9 = $stock_inicial_9 - $cant_carrito_9;
            ?>
            <div class="product-card" data-cat="Lácteos">
                <div class="product-img">
                    <div class="product-img-ph"><img src="https://plazavea.vteximg.com.br/arquivos/ids/35081437-418-418/358217.jpg" alt=""></div><span class="discount-badge">-8%</span>
                    <?php if ($stock_final_9 > 0): ?>
                        <span class="stock-badge"><img src="img/Cardboard Box.png" alt=""> <?php echo $stock_final_9; ?> disponibles</span>
                    <?php else: ?>
                        <span class="stock-badge" style="background-color: #ff4d4d; color: white;">Agotado</span>
                    <?php endif; ?>
                </div>
                <form action="productos.php" method="POST" class="product-body"><span class="product-category">Lácteos</span>
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

            <?php
            $stock_inicial_10 = 40;
            $cant_carrito_10 = isset($_SESSION['carrito']['10']) ? $_SESSION['carrito']['10']['cantidad'] : 0;
            $stock_final_10 = $stock_inicial_10 - $cant_carrito_10;
            ?>
            <div class="product-card" data-cat="Lácteos">
                <div class="product-img">
                    <div class="product-img-ph"><img src="https://plazavea.vteximg.com.br/arquivos/ids/34359084-450-450/20219240.jpg?v=639125037828330000" alt=""></div>
                    <?php if ($stock_final_10 > 0): ?>
                        <span class="stock-badge"><img src="img/Cardboard Box.png" alt=""> <?php echo $stock_final_10; ?> disponibles</span>
                    <?php else: ?>
                        <span class="stock-badge" style="background-color: #ff4d4d; color: white;">Agotado</span>
                    <?php endif; ?>
                </div>
                <form action="productos.php" method="POST" class="product-body"><span class="product-category">Lácteos</span>
                    <div class="product-name">Queso Fresco 250g</div>
                    <div class="product-price"><span class="price-current">S/ 5.50</span></div>
                    
                    <input type="hidden" name="producto_id" value="10">
                    <input type="hidden" name="producto_nombre" value="Queso Fresco 250g">
                    <input type="hidden" name="producto_precio" value="5.50">
                    <input type="hidden" name="producto_imagen" value="https://plazavea.vteximg.com.br/arquivos/ids/34359084-450-450/20219240.jpg?v=639125037828330000">
                    
                    <?php if ($stock_final_10 > 0): ?>
                        <button type="submit" name="btn_agregar" class="btn-add-cart"><img src="img/Shopping Cart.png" alt=""> Agregar al Carrito</button>
                    <?php else: ?>
                        <button type="button" class="btn-add-cart" style="background-color: #ccc; cursor: not-allowed;" disabled>Agotado</button>
                    <?php endif; ?>
                </form>
            </div>

            <?php
            $stock_inicial_11 = 25;
            $cant_carrito_11 = isset($_SESSION['carrito']['11']) ? $_SESSION['carrito']['11']['cantidad'] : 0;
            $stock_final_11 = $stock_inicial_11 - $cant_carrito_11;
            ?>
            <div class="product-card" data-cat="Lácteos">
                <div class="product-img">
                    <div class="product-img-ph"><img src="https://plazavea.vteximg.com.br/arquivos/ids/34367598-450-450/20504518.jpg?v=639125092781730000" alt=""></div>
                    <?php if ($stock_final_11 > 0): ?>
                        <span class="stock-badge"><img src="img/Cardboard Box.png" alt=""> <?php echo $stock_final_11; ?> disponibles</span>
                    <?php else: ?>
                        <span class="stock-badge" style="background-color: #ff4d4d; color: white;">Agotado</span>
                    <?php endif; ?>
                </div>
                <form action="productos.php" method="POST" class="product-body"><span class="product-category">Lácteos</span>
                    <div class="product-name">Mantequilla Laive 90g</div>
                    <div class="product-price"><span class="price-current">S/ 4.20</span></div>
                    
                    <input type="hidden" name="producto_id" value="11">
                    <input type="hidden" name="producto_nombre" value="Mantequilla Laive 90g">
                    <input type="hidden" name="producto_precio" value="4.20">
                    <input type="hidden" name="producto_imagen" value="https://plazavea.vteximg.com.br/arquivos/ids/34367598-450-450/20504518.jpg?v=639125092781730000">
                    
                    <?php if ($stock_final_11 > 0): ?>
                        <button type="submit" name="btn_agregar" class="btn-add-cart"><img src="img/Shopping Cart.png" alt=""> Agregar al Carrito</button>
                    <?php else: ?>
                        <button type="button" class="btn-add-cart" style="background-color: #ccc; cursor: not-allowed;" disabled>Agotado</button>
                    <?php endif; ?>
                </form>
            </div>

            <?php
            $stock_inicial_12 = 35;
            $cant_carrito_12 = isset($_SESSION['carrito']['12']) ? $_SESSION['carrito']['12']['cantidad'] : 0;
            $stock_final_12 = $stock_inicial_12 - $cant_carrito_12;
            ?>
            <div class="product-card" data-cat="Lácteos">
                <div class="product-img">
                    <div class="product-img-ph"><img src="https://metroio.vtexassets.com/arquivos/ids/598523/48255001-01-22056.jpg?v=638896665932930000" alt=""></div>
                    <?php if ($stock_final_12 > 0): ?>
                        <span class="stock-badge"><img src="img/Cardboard Box.png" alt=""> <?php echo $stock_final_12; ?> disponibles</span>
                    <?php else: ?>
                        <span class="stock-badge" style="background-color: #ff4d4d; color: white;">Agotado</span>
                    <?php endif; ?>
                </div>
                <form action="productos.php" method="POST" class="product-body"><span class="product-category">Lácteos</span>
                    <div class="product-name">Yogurt Gloria 1kg</div>
                    <div class="product-price"><span class="price-current">S/ 6.90</span></div>
                    
                    <input type="hidden" name="producto_id" value="12">
                    <input type="hidden" name="producto_nombre" value="Yogurt Gloria 1kg">
                    <input type="hidden" name="producto_precio" value="6.90">
                    <input type="hidden" name="producto_imagen" value="https://metroio.vtexassets.com/arquivos/ids/598523/48255001-01-22056.jpg?v=638896665932930000">
                    
                    <?php if ($stock_final_12 > 0): ?>
                        <button type="submit" name="btn_agregar" class="btn-add-cart"><img src="img/Shopping Cart.png" alt=""> Agregar al Carrito</button>
                    <?php else: ?>
                        <button type="button" class="btn-add-cart" style="background-color: #ccc; cursor: not-allowed;" disabled>Agotado</button>
                    <?php endif; ?>
                </form>
            </div>

            <?php
            $stock_inicial_13 = 40;
            $cant_carrito_13 = isset($_SESSION['carrito']['13']) ? $_SESSION['carrito']['13']['cantidad'] : 0;
            $stock_final_13 = $stock_inicial_13 - $cant_carrito_13;
            ?>
            <div class="product-card" data-cat="Limpieza">
                <div class="product-img">
                    <div class="product-img-ph"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQp8Bw6_jebE6tb2kdi1S7tCse8rRPDR4HhGxU-gf5EReexGIssAD1p5mNO&s=10" alt=""></div>
                    <?php if ($stock_final_13 > 0): ?>
                        <span class="stock-badge"><img src="img/Cardboard Box.png" alt=""> <?php echo $stock_final_13; ?> disponibles</span>
                    <?php else: ?>
                        <span class="stock-badge" style="background-color: #ff4d4d; color: white;">Agotado</span>
                    <?php endif; ?>
                </div>
                <form action="productos.php" method="POST" class="product-body"><span class="product-category">Limpieza</span>
                    <div class="product-name">Detergente Ariel 360g</div>
                    <div class="product-price"><span class="price-current">S/ 5.50</span></div>
                    
                    <input type="hidden" name="producto_id" value="13">
                    <input type="hidden" name="producto_nombre" value="Detergente Ariel 360g">
                    <input type="hidden" name="producto_precio" value="5.50">
                    <input type="hidden" name="producto_imagen" value="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQp8Bw6_jebE6tb2kdi1S7tCse8rRPDR4HhGxU-gf5EReexGIssAD1p5mNO&s=10">
                    
                    <?php if ($stock_final_13 > 0): ?>
                        <button type="submit" name="btn_agregar" class="btn-add-cart"><img src="img/Shopping Cart.png" alt=""> Agregar al Carrito</button>
                    <?php else: ?>
                        <button type="button" class="btn-add-cart" style="background-color: #ccc; cursor: not-allowed;" disabled>Agotado</button>
                    <?php endif; ?>
                </form>
            </div>

            <?php
            $stock_inicial_14 = 60;
            $cant_carrito_14 = isset($_SESSION['carrito']['14']) ? $_SESSION['carrito']['14']['cantidad'] : 0;
            $stock_final_14 = $stock_inicial_14 - $cant_carrito_14;
            ?>
            <div class="product-card" data-cat="Limpieza">
                <div class="product-img">
                    <div class="product-img-ph"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSl9FUvl3KnujwFL9Vy-y1UY20d0EWPjIq-5PKeGqYfdg&s=10" alt=""></div>
                    <?php if ($stock_final_14 > 0): ?>
                        <span class="stock-badge"><img src="img/Cardboard Box.png" alt=""> <?php echo $stock_final_14; ?> disponibles</span>
                    <?php else: ?>
                        <span class="stock-badge" style="background-color: #ff4d4d; color: white;">Agotado</span>
                    <?php endif; ?>
                </div>
                <form action="productos.php" method="POST" class="product-body"><span class="product-category">Limpieza</span>
                    <div class="product-name">Lejía Clorox 900ml</div>
                    <div class="product-price"><span class="price-current">S/ 3.80</span></div>
                    
                    <input type="hidden" name="producto_id" value="14">
                    <input type="hidden" name="producto_nombre" value="Lejía Clorox 900ml">
                    <input type="hidden" name="producto_precio" value="3.80">
                    <input type="hidden" name="producto_imagen" value="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSl9FUvl3KnujwFL9Vy-y1UY20d0EWPjIq-5PKeGqYfdg&s=10">
                    
                    <?php if ($stock_final_14 > 0): ?>
                        <button type="submit" name="btn_agregar" class="btn-add-cart"><img src="img/Shopping Cart.png" alt=""> Agregar al Carrito</button>
                    <?php else: ?>
                        <button type="button" class="btn-add-cart" style="background-color: #ccc; cursor: not-allowed;" disabled>Agotado</button>
                    <?php endif; ?>
                </form>
            </div>

            <?php
            $stock_inicial_15 = 80;
            $cant_carrito_15 = isset($_SESSION['carrito']['15']) ? $_SESSION['carrito']['15']['cantidad'] : 0;
            $stock_final_15 = $stock_inicial_15 - $cant_carrito_15;
            ?>
            <div class="product-card" data-cat="Limpieza">
                <div class="product-img">
                    <div class="product-img-ph"><img src="https://plazavea.vteximg.com.br/arquivos/ids/29259400-450-450/20426302.jpg?v=638572959946070000" alt=""></div>
                    <?php if ($stock_final_15 > 0): ?>
                        <span class="stock-badge"><img src="img/Cardboard Box.png" alt=""> <?php echo $stock_final_15; ?> disponibles</span>
                    <?php else: ?>
                        <span class="stock-badge" style="background-color: #ff4d4d; color: white;">Agotado</span>
                    <?php endif; ?>
                </div>
                <form action="productos.php" method="POST" class="product-body"><span class="product-category">Limpieza</span>
                    <div class="product-name">Esponja Scoth-Brite x2</div>
                    <div class="product-price"><span class="price-current">S/ 2.50</span></div>
                    
                    <input type="hidden" name="producto_id" value="15">
                    <input type="hidden" name="producto_nombre" value="Esponja Scoth-Brite x2">
                    <input type="hidden" name="producto_precio" value="2.50">
                    <input type="hidden" name="producto_imagen" value="https://plazavea.vteximg.com.br/arquivos/ids/29259400-450-450/20426302.jpg?v=638572959946070000">
                    
                    <?php if ($stock_final_15 > 0): ?>
                        <button type="submit" name="btn_agregar" class="btn-add-cart"><img src="img/Shopping Cart.png" alt=""> Agregar al Carrito</button>
                    <?php else: ?>
                        <button type="button" class="btn-add-cart" style="background-color: #ccc; cursor: not-allowed;" disabled>Agotado</button>
                    <?php endif; ?>
                </form>
            </div>

            <?php
            $stock_inicial_16 = 45;
            $cant_carrito_16 = isset($_SESSION['carrito']['16']) ? $_SESSION['carrito']['16']['cantidad'] : 0;
            $stock_final_16 = $stock_inicial_16 - $cant_carrito_16;
            ?>
            <div class="product-card" data-cat="Limpieza">
                <div class="product-img">
                    <div class="product-img-ph"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTTutgQxINNYmTIlWs4StVvlp8l_nZZOE65LMrz7i5NJg&s=10" alt=""></div>
                    <?php if ($stock_final_16 > 0): ?>
                        <span class="stock-badge"><img src="img/Cardboard Box.png" alt=""> <?php echo $stock_final_16; ?> disponibles</span>
                    <?php else: ?>
                        <span class="stock-badge" style="background-color: #ff4d4d; color: white;">Agotado</span>
                    <?php endif; ?>
                </div>
                <form action="productos.php" method="POST" class="product-body"><span class="product-category">Limpieza</span>
                    <div class="product-name">Lava Vajillas Sapolio 500g</div>
                    <div class="product-price"><span class="price-current">S/ 3.20</span></div>
                    
                    <input type="hidden" name="producto_id" value="16">
                    <input type="hidden" name="producto_nombre" value="Lava Vajillas Sapolio 500g">
                    <input type="hidden" name="producto_precio" value="3.20">
                    <input type="hidden" name="producto_imagen" value="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTTutgQxINNYmTIlWs4StVvlp8l_nZZOE65LMrz7i5NJg&s=10">
                    
                    <?php if ($stock_final_16 > 0): ?>
                        <button type="submit" name="btn_agregar" class="btn-add-cart"><img src="img/Shopping Cart.png" alt=""> Agregar al Carrito</button>
                    <?php else: ?>
                        <button type="button" class="btn-add-cart" style="background-color: #ccc; cursor: not-allowed;" disabled>Agotado</button>
                    <?php endif; ?>
                </form>
            </div>

            <?php
            $stock_inicial_17 = 60;
            $cant_carrito_17 = isset($_SESSION['carrito']['17']) ? $_SESSION['carrito']['17']['cantidad'] : 0;
            $stock_final_17 = $stock_inicial_17 - $cant_carrito_17;
            ?>
            <div class="product-card" data-cat="Snacks">
                <div class="product-img">
                    <div class="product-img-ph"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRt3e4TjnCCfgiZA3ag7Wls6vK3Tok4A1-HoM8CfPM0KbQMQYK98HxpHdHI&s=10" alt=""></div><span class="discount-badge">-8%</span>
                    <?php if ($stock_final_17 > 0): ?>
                        <span class="stock-badge"><img src="img/Cardboard Box.png" alt=""> <?php echo $stock_final_17; ?> disponibles</span>
                    <?php else: ?>
                        <span class="stock-badge" style="background-color: #ff4d4d; color: white;">Agotado</span>
                    <?php endif; ?>
                </div>
                <form action="productos.php" method="POST" class="product-body"><span class="product-category">Snacks</span>
                    <div class="product-name">Galletas Oreo 432g</div>
                    <div class="product-price"><span class="price-current">S/ 6.48</span><span class="price-original">S/ 7.20</span></div>
                    
                    <input type="hidden" name="producto_id" value="17">
                    <input type="hidden" name="producto_nombre" value="Galletas Oreo 432g">
                    <input type="hidden" name="producto_precio" value="6.48">
                    <input type="hidden" name="producto_imagen" value="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRt3e4TjnCCfgiZA3ag7Wls6vK3Tok4A1-HoM8CfPM0KbQMQYK98HxpHdHI&s=10">
                    
                    <?php if ($stock_final_17 > 0): ?>
                        <button type="submit" name="btn_agregar" class="btn-add-cart"><img src="img/Shopping Cart.png" alt=""> Agregar al Carrito</button>
                    <?php else: ?>
                        <button type="button" class="btn-add-cart" style="background-color: #ccc; cursor: not-allowed;" disabled>Agotado</button>
                    <?php endif; ?>
                </form>
            </div>

            <?php
            $stock_inicial_18 = 50;
            $cant_carrito_18 = isset($_SESSION['carrito']['18']) ? $_SESSION['carrito']['18']['cantidad'] : 0;
            $stock_final_18 = $stock_inicial_18 - $cant_carrito_18;
            ?>
            <div class="product-card" data-cat="Snacks">
                <div class="product-img">
                    <div class="product-img-ph"><img src="https://http2.mlstatic.com/D_NQ_NP_672316-MLU70488113408_072023-O.webp" alt=""></div>
                    <?php if ($stock_final_18 > 0): ?>
                        <span class="stock-badge"><img src="img/Cardboard Box.png" alt=""> <?php echo $stock_final_18; ?> disponibles</span>
                    <?php else: ?>
                        <span class="stock-badge" style="background-color: #ff4d4d; color: white;">Agotado</span>
                    <?php endif; ?>
                </div>
                <form action="productos.php" method="POST" class="product-body"><span class="product-category">Snacks</span>
                    <div class="product-name">Papas Lay's 42g</div>
                    <div class="product-price"><span class="price-current">S/ 2.20</span></div>
                    
                    <input type="hidden" name="producto_id" value="18">
                    <input type="hidden" name="producto_nombre" value="Papas Lay's 42g">
                    <input type="hidden" name="producto_precio" value="2.20">
                    <input type="hidden" name="producto_imagen" value="https://http2.mlstatic.com/D_NQ_NP_672316-MLU70488113408_072023-O.webp">
                    
                    <?php if ($stock_final_18 > 0): ?>
                        <button type="submit" name="btn_agregar" class="btn-add-cart"><img src="img/Shopping Cart.png" alt=""> Agregar al Carrito</button>
                    <?php else: ?>
                        <button type="button" class="btn-add-cart" style="background-color: #ccc; cursor: not-allowed;" disabled>Agotado</button>
                    <?php endif; ?>
                </form>
            </div>

            <?php
            $stock_inicial_19 = 35;
            $cant_carrito_19 = isset($_SESSION['carrito']['19']) ? $_SESSION['carrito']['19']['cantidad'] : 0;
            $stock_final_19 = $stock_inicial_19 - $cant_carrito_19;
            ?>
            <div class="product-card" data-cat="Snacks">
                <div class="product-img">
                    <div class="product-img-ph"><img src="https://metroio.vtexassets.com/arquivos/ids/413595-800-auto?v=638279067253330000&width=800&height=auto&aspect=true" alt=""></div>
                    <?php if ($stock_final_19 > 0): ?>
                        <span class="stock-badge"><img src="img/Cardboard Box.png" alt=""> <?php echo $stock_final_19; ?> disponibles</span>
                    <?php else: ?>
                        <span class="stock-badge" style="background-color: #ff4d4d; color: white;">Agotado</span>
                    <?php endif; ?>
                </div>
                <form action="productos.php" method="POST" class="product-body"><span class="product-category">Snacks</span>
                    <div class="product-name">Sublime 35g</div>
                    <div class="product-price"><span class="price-current">S/ 1.50</span></div>
                    
                    <input type="hidden" name="producto_id" value="19">
                    <input type="hidden" name="producto_nombre" value="Sublime 35g">
                    <input type="hidden" name="producto_precio" value="1.50">
                    <input type="hidden" name="producto_imagen" value="https://metroio.vtexassets.com/arquivos/ids/413595-800-auto?v=638279067253330000&width=800&height=auto&aspect=true">
                    
                    <?php if ($stock_final_19 > 0): ?>
                        <button type="submit" name="btn_agregar" class="btn-add-cart"><img src="img/Shopping Cart.png" alt=""> Agregar al Carrito</button>
                    <?php else: ?>
                        <button type="button" class="btn-add-cart" style="background-color: #ccc; cursor: not-allowed;" disabled>Agotado</button>
                    <?php endif; ?>
                </form>
            </div>

            <?php
            $stock_inicial_20 = 70;
            $cant_carrito_20 = isset($_SESSION['carrito']['20']) ? $_SESSION['carrito']['20']['cantidad'] : 0;
            $stock_final_20 = $stock_inicial_20 - $cant_carrito_20;
            ?>
            <div class="product-card" data-cat="Snacks">
                <div class="product-img">
                    <div class="product-img-ph"><img src="https://metroio.vtexassets.com/arquivos/ids/534450/473159-01-23940.jpg?v=638557437894730000" alt=""></div>
                    <?php if ($stock_final_20 > 0): ?>
                        <span class="stock-badge"><img src="img/Cardboard Box.png" alt=""> <?php echo $stock_final_20; ?> disponibles</span>
                    <?php else: ?>
                        <span class="stock-badge" style="background-color: #ff4d4d; color: white;">Agotado</span>
                    <?php endif; ?>
                </div>
                <form action="productos.php" method="POST" class="product-body"><span class="product-category">Snacks</span>
                    <div class="product-name">Chancay x6</div>
                    <div class="product-price"><span class="price-current">S/ 3.00</span></div>
                    
                    <input type="hidden" name="producto_id" value="20">
                    <input type="hidden" name="producto_nombre" value="Chancay x6">
                    <input type="hidden" name="producto_precio" value="3.00">
                    <input type="hidden" name="producto_imagen" value="https://metroio.vtexassets.com/arquivos/ids/534450/473159-01-23940.jpg?v=638557437894730000">
                    
                    <?php if ($stock_final_20 > 0): ?>
                        <button type="submit" name="btn_agregar" class="btn-add-cart"><img src="img/Shopping Cart.png" alt=""> Agregar al Carrito</button>
                    <?php else: ?>
                        <button type="button" class="btn-add-cart" style="background-color: #ccc; cursor: not-allowed;" disabled>Agotado</button>
                    <?php endif; ?>
                </form>
            </div>
        </div>
        
      </div>
</main>

<script>
    // Guardamos la posición exacta en píxeles del scroll vertical antes de enviar el formulario
    document.addEventListener("submit", function() {
        localStorage.setItem("posicionScrollProductos", window.scrollY);
    });

    // Al volver a cargar la página tras añadir el producto, restauramos la vista exacta del usuario
    window.addEventListener("load", function() {
        if (localStorage.getItem("posicionScrollProductos") !== null) {
            window.scrollTo(0, parseInt(localStorage.getItem("posicionScrollProductos")));
            localStorage.removeItem("posicionScrollProductos"); // Limpiamos la caché de posición
        }
    });
</script>

<script src="js/buscador.js"></script>

<?php
// 3. MOSTRAMOS LA NOTIFICACIÓN VERDE SI SE AGREGÓ UN PRODUCTO
if ($mostrar_notificacion): ?>
    <div class="toast-fixed-pure-php">
        <span style="display:inline-flex; align-items:center; justify-content:center; background-color:#10b981; color:white; width:20px; height:20px; border-radius:50%; margin-right:10px; font-weight:bold;">✓</span>
        <span><?php echo htmlspecialchars($nombre_producto_agregado); ?> agregado al carrito</span>
    </div>
<?php endif;

  //Pie de paginna vinculado con include
  include 'include/footer.php';
?>