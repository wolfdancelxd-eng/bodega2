<?php
// 1. Iniciamos la sesión para poder guardar los datos del usuario logueado
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['usuario_id'])) {
    // Si el carrito existe y tiene artículos, lo mandamos a pagar
    if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
        header("Location: carrito.php");
    } else {
        // Si no tiene nada en el carrito, lo mandamos al catálogo general
        header("Location: productos.php"); 
    }
    exit();
}

$error_mensaje = "";

// 2. FUNCIÓN CON ARREGLO MULTIDIMENSIONAL
function validarLogin($correo_ingresado, $contrasena_ingresada) {
    // Nuestro arreglo multidimensional de usuarios registrados para la demo
    $usuarios = [
        [
            "id" => 1,
            "nombre" => "Dancel Solis",
            "correo" => "solisdancel22@gmail.com",
            "password" => "123456"
        ],
        [
            "id" => 2,
            "nombre" => "Angel Requena",
            "correo" => "requenaangel61@gmail.com",
            "password" => "abc123"
        ]
    ];

    // Recorremos el arreglo buscando coincidencias
    foreach ($usuarios as $usuario) {
        if ($usuario['correo'] === $correo_ingresado && $usuario['password'] === $contrasena_ingresada) {
            return $usuario; // Si coincide, devolvemos los datos del usuario
        }
    }
    
    return false; // Si termina el ciclo y no encontró nada
}

// 3. PROCESAR EL FORMULARIO CUANDO SE HACE POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo'] ?? '');
    $contrasena = trim($_POST['contrasena'] ?? '');

    // Llamamos a la función
    $usuario_valido = validarLogin($correo, $contrasena);

    if ($usuario_valido) {
        // ¡ÉXITO! Guardamos los datos clave en la sesión
        $_SESSION['usuario_id'] = $usuario_valido['id'];
        $_SESSION['usuario_nombre'] = $usuario_valido['nombre'];

        // Redireccionamos al carrito automáticamente para que finalice la compra
        header("Location: carrito.php");
        exit();
    } else {
        $error_mensaje = "Correo o contraseña incorrectos. Intenta con juan@gmail.com (Clave: 123456)";
    }
}

include 'include/header.php';
?>

<div class="container-session">

    <div class="panel-banner">
        <br><br>
        <img src="https://images.unsplash.com/photo-1760776140488-32fcfab4066a?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&w=800" alt="">
        <br>
        <h2>¡Bienvenido de nuevo!</h2>
        <br>
        <p>Accede a tu cuenta para ver tu historial de compras y productos favoritos.</p>
    </div>

    <div class="cont-sesion">
        <form action="sesion.php" method="POST">
            <div>
                <img src="img/user-svgrepo-com.png" alt="">
                <h2>Iniciar Sesión</h2>
                <br>
                <p>Ingresa tus credenciales para continuar</p>
            </div>    

            <?php if (!empty($error_mensaje)): ?>
                <div style="background-color: #ffeeeb; color: #dc2626; padding: 10px; border-radius: 6px; margin-bottom: 15px; font-size: 13px; border: 1px solid #fecaca; text-align: left;">
                    <?php echo $error_mensaje; ?>
                </div>
            <?php endif; ?>

            <label for="correo">Correo Electrónico</label>
            <input type="email" name="correo" id="correo" placeholder="tu@gmail.com" required value="<?php echo htmlspecialchars($_POST['correo'] ?? ''); ?>">
            
            <label for="contrasena">Contraseña:</label>
            <input type="password" name="contrasena" id="contrasena" placeholder="Ingresa tu contraseña" required>
            
            <input type="submit" value="Iniciar Sesion">
            
            <div class="cont-botoom">
                <p>¿Aún no tienes cuenta?</p> <span>Registrate aqui</span>
            </div>
            
            <p style="margin-top: 15px; font-size: 13px; color: #6b7280;">
                <b>Demo:</b> Usa <code>juan@gmail.com</code> y contraseña <code>123456</code>
            </p>
        </form>
    </div>
</div>

<?php
include 'include/footer.php';
?>