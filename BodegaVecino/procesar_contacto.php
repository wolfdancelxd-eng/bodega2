<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// CANDADO DE SEGURIDAD: Si no hay sesión, nadie puede procesar este archivo
if (!isset($_SESSION['usuario_id'])) {
    header("Location: sesion.php");
    exit();
}

// Validar que la petición venga estrictamente por POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // Limpiamos los datos recibidos para evitar inyecciones o errores
    $nombre    = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $telefono  = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
    $correo    = isset($_POST['correo']) ? trim($_POST['correo']) : '';
    $mensaje   = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : '';

    // Validar que los campos esenciales no estén vacíos
    if (empty($nombre) || empty($correo) || empty($mensaje)) {
        echo "<script>
                alert('Por favor, completa todos los campos obligatorios.');
                window.location.href = 'contacto.php';
              </script>";
        exit();
    }

    // =======================================================
    // CONFIGURACIÓN DEL CORREO
    // =======================================================
    $correo_destino = "solisdancel22@gmail.com"; // Tu correo donde recibirás los mensajes
    $asunto = "Nueva consulta web de: " . $nombre;

    // Cuerpo del mensaje en HTML
    $cuerpo = "
    <html>
    <head>
      <title>Nueva Consulta desde la Web</title>
    </head>
    <body>
      <h2>Detalles de la consulta:</h2>
      <p><strong>Nombre:</strong> {$nombre}</p>
      <p><strong>Teléfono:</strong> {$telefono}</p>
      <p><strong>Correo electrónico:</strong> {$correo}</p>
      <p><strong>Mensaje:</strong><br>" . nl2br($mensaje) . "</p>
    </body>
    </html>
    ";

    // Cabeceras estándar para formato HTML
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    
    // IMPORTANTE: En el 'From', usa un correo que simule salir de tu servidor/host 
    // para evitar que rebote o vaya a SPAM (ejemplo: no-reply@tu-servidor.com)
    $headers .= "From: Web Bodega <no-reply@tu-dominio-o-localhost.com>" . "\r\n";
    $headers .= "Reply-To: " . $correo . "\r\n";

    // Intentar enviar el correo
    if (mail($correo_destino, $asunto, $cuerpo, $headers)) {
        // ÉXITO: Alerta bonita y redirección automática
        echo "<script>
                alert('¡Mensaje enviado con éxito! Nos comunicaremos contigo pronto.');
                window.location.href = 'contacto.php';
              </script>";
    } else {
        // ERROR: Si el servidor local/host rechaza la función mail()
        echo "<script>
                alert('El servidor no pudo procesar el envío de correo. Si estás en localhost, recuerda que necesitas configurar un servidor SMTP (como PHPMailer) o subirlo a tu hosting.');
                window.location.href = 'contacto.php';
              </script>";
    }

} else {
    // Si intentan entrar directo al archivo por URL, los botamos a contacto.php
    header("Location: contacto.php");
    exit();
}
?>