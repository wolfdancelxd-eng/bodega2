document.addEventListener('DOMContentLoaded', () => {
    
    // Seleccionamos todos los botones que tengan la clase constructora
    const botonesAgregar = document.querySelectorAll('.btn-agregar-ajax');

    botonesAgregar.forEach(boton => {
        boton.addEventListener('click', function() {
            // Obtenemos los valores guardados en los atributos data-
            const id = this.getAttribute('data-id');
            const nombre = this.getAttribute('data-nombre');
            const precio = this.getAttribute('data-precio');
            const imagen = this.getAttribute('data-imagen');

            // Preparamos los parámetros en formato de formulario tradicional (POST)
            const params = new URLSearchParams();
            params.append('id', id);
            params.append('nombre', nombre);
            params.append('precio', precio);
            params.append('imagen', imagen);

            // Enviamos la petición asíncrona al archivo en la raíz
            fetch('agregar_al_carrito.php', {
                method: 'POST',
                body: params
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Aquí puedes mandar un alert de confirmación temporal
                    alert('¡' + data.nombre + ' agregado al carrito!');
                    
                    // NOTA: Si prefieres mostrar tu div de notificación verde flotante de forma fluida,
                    // puedes crearla por CSS/JS o cambiar el contenido de un elemento dinámico aquí.
                } else {
                    alert('Hubo un problema al agregar el producto.');
                }
            })
            .catch(error => {
                console.error('Error en la petición AJAX:', error);
            });
        });
    });
});