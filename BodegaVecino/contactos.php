<?php include 'include/header.php';?>

<div id="page-contacto" >
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
                    <p>+51 987 654 321<br><a class="red-link">Enviar WhatsApp</a></p>
                </div>
                <div class="contact-card">
                    <div class="contact-card-icon red"><img src="img/Gmail Logo.png" alt=""></div>
                    <h3>Correo Electrónico</h3>
                    <p>contacto@bodegalaesquina.pe</p>
                </div>
        </div>
        
            <form class="contact-form-card" id="form-consulta" action="procesar_contacto.php" method="POST">
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
    // Capturamos el estado real de la sesión desde PHP
    var usuarioLogueado = <?php echo isset($_SESSION['usuario_id']) ? 'true' : 'false'; ?>;
    
    if (!usuarioLogueado) {
        // 1. Detenemos el envío automático a procesar_contacto.php
        event.preventDefault();
        
        // 2. Abrimos el modal nativo idéntico al del carrito
        document.getElementById('modalLogin').style.display = 'flex';
    }
});
</script>

<?php include 'include/footer.php';?>