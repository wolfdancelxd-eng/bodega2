<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Eliminamos la lógica de procesamiento PHP de arriba para que no interfiera 
// y el script fluya directo al HTML.

include 'include/header.php';
?>

<div id="page-contacto">
    <div class="contact-header">
        <h1>Contáctanos</h1>
        <p>Estamos aquí para ayudarte. Envíanos tu consulta y te responderemos lo antes posible.</p>
    </div>

    <div class="contact-body">
        <div class="contact-info">
            <div class="contact-card">
                <div class="contact-card-icon"><img src="img/Address.png" alt=""></div>
                <h3>Nuestra Ubicación</h3>
                <p>Av. Los Olivos 456<br>San Miguel, Lima<br>Perú</p>
            </div>
            <div class="contact-card">
                <div class="contact-card-icon"><img src="img/Phone.png" alt=""></div>
                <h3>Teléfono y WhatsApp</h3>
                <p>+51 987 654 321<br><a href="https://wa.me/51987654321" target="_blank" class="red-link">Enviar WhatsApp</a></p>
            </div>
            <div class="contact-card">
                <div class="contact-card-icon red"><img src="img/Gmail Logo.png" alt=""></div>
                <h3>Correo Electrónico</h3>
                <p>contacto@bodegalaesquina.pe</p>
            </div>
        </div>
        
        <form class="contact-form-card" id="form-consulta" method="POST">
            <h2>Envíanos un Mensaje</h2>
            <div class="form-row">
                <div class="form-group" style="margin-bottom:0">
                    <label>Nombre Completo</label>
                    <input type="text" name="nombre" placeholder="Juan Pérez" value="<?php echo isset($_SESSION['usuario_nombre']) ? htmlspecialchars($_SESSION['usuario_nombre']) : ''; ?>" required>
                </div>
                <div class="form-group" style="margin-bottom:0">
                    <label>Teléfono</label>
                    <input type="tel" name="telefono" placeholder="+51 987 654 321" required>
                </div>
            </div>
            <div class="form-group">
                <label>Correo Electrónico</label>
                <input type="email" name="correo" placeholder="tu@email.com" required>
            </div>
            <div class="form-group">
                <label>Mensaje</label>
                <textarea name="mensaje" placeholder="Escribe tu consulta aquí..." required></textarea>
            </div>
            <button type="submit" class="btn-send">Enviar Mensaje</button>
        </form>
    </div>

    <div class="info-grid">
        <div class="info-card">
            <img src="img/Clock2.png" alt="">
            <h3>Horario de Atención</h3>
            <p>
                Lunes a Sábado: <strong style="color:var(--red)">7:00 AM - 10:00 PM</strong><br>
                Domingo: <strong style="color:var(--red)">8:00 AM - 8:00 PM</strong>
            </p>
        </div>
        <div class="info-card">
            <img src="img/logobodega.png" alt="">
            <h3>Nuestra Ubicación</h3>
            <p>
                Av. Los Olivos 456<br>
                San Miguel, Lima<br>
                <span class="phone">+51 987 654 321</span>
            </p>
        </div>
    </div>
</div>

<div id="toast-container-contacto" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999;"></div>

<div id="modalLogin" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
    <div style="background:white; padding:30px; border-radius:12px; text-align:center; max-width:400px; width:90%; box-shadow:0 4px 6px rgba(0,0,0,0.1); font-family: sans-serif;">
        <h3 style="margin-top:0; color:#111827; font-size: 20px; font-weight: bold;">¡Ups! Debes iniciar sesión</h3>
        <p style="color:#6b7280; margin-bottom:25px; font-size: 14px; line-height: 1.5;">Para enviar tu consulta y procesar tu mensaje, por favor entra a tu cuenta.</p>
        <div style="display:flex; flex-direction:column; gap:10px;">
            <a href="sesion.php" style="background:#dc2626; color:white; padding:12px; border-radius:8px; text-decoration:none; font-weight:bold; font-size: 15px; display: block;">Ir al Login</a>
            <button onclick="document.getElementById('modalLogin').style.display='none'" style="background:none; border:1px solid #d1d5db; padding:10px; border-radius:8px; cursor:pointer; color: #4b5563; font-weight: 600; font-size: 14px;">Cerrar</button>
        </div>
    </div>
</div>

<script>
document.getElementById('form-consulta').addEventListener('submit', function(event) {
    event.preventDefault(); // Evitamos que la página parpadee o se recargue
    
    // Validamos el estado real del inicio de sesión
    var usuarioLogueado = <?php echo isset($_SESSION['usuario_id']) && !empty($_SESSION['usuario_id']) ? 'true' : 'false'; ?>;
    
    if (!usuarioLogueado) {
        document.getElementById('modalLogin').style.display = 'flex';
        return;
    }

    // SI ESTÁ LOGUEADO: Hacemos la simulación súper premium
    const form = this;
    const btn = form.querySelector('.btn-send');
    const originalText = btn.textContent;
    
    // Deshabilitamos el botón para simular carga de red
    btn.textContent = "Enviando mensaje...";
    btn.disabled = true;

    // Generamos un retraso de 1.5 segundos simulado
    setTimeout(() => {
        // Restauramos el botón
        btn.textContent = originalText;
        btn.disabled = false;

        // Disparamos el Toast verde de éxito instantáneo
        crearToastContacto('¡Tu mensaje ha sido enviado con éxito! Te responderemos muy pronto.', '#10b981');
        
        // Reseteamos el formulario
        form.reset();
    }, 1500);
});

// Función dinámica para mostrar la alerta toast premium de manera fluida
function crearToastContacto(mensaje, colorBorde) {
    const contenedor = document.getElementById("toast-container-contacto");
    if (!contenedor) return;

    const nuevoToast = document.createElement("div");
    nuevoToast.style.marginBottom = "10px";
    nuevoToast.style.display = "flex";
    nuevoToast.style.alignItems = "center";
    nuevoToast.style.backgroundColor = "#fff";
    nuevoToast.style.color = "#333";
    nuevoToast.style.padding = "14px 20px";
    nuevoToast.style.borderRadius = "8px";
    nuevoToast.style.boxShadow = "0 4px 15px rgba(0,0,0,0.15)";
    nuevoToast.style.borderLeft = `5px solid ${colorBorde}`;
    nuevoToast.style.fontSize = "14px";
    nuevoToast.style.opacity = "1";
    nuevoToast.style.transition = "opacity 0.4s ease";
    nuevoToast.style.fontFamily = "sans-serif";

    const checkIcon = colorBorde === '#10b981' ? '✓' : '✕';

    nuevoToast.innerHTML = `
        <span style="display:inline-flex; align-items:center; justify-content:center; background-color:${colorBorde}; color:white; width:22px; height:22px; border-radius:50%; margin-right:12px; font-weight:bold; font-size:12px;">${checkIcon}</span>
        <span>${mensaje}</span>
    `;

    contenedor.appendChild(nuevoToast);

    // Se desvanece de manera estética a los 4 segundos
    setTimeout(() => {
        nuevoToast.style.opacity = "0";
        setTimeout(() => nuevoToast.remove(), 400);
    }, 4000);
}
</script>

<?php include 'include/footer.php'; ?>
