// =========================================================================
// 1. PERSISTENCIA DE SCROLL (CONGELAR PANTALLA AL AGREGAR AL CARRITO)
// =========================================================================
document.addEventListener("submit", function() {
    localStorage.setItem("posicionScrollProductos", window.scrollY);
});

window.addEventListener("load", function() {
    if (localStorage.getItem("posicionScrollProductos") !== null) {
        window.scrollTo(0, parseInt(localStorage.getItem("posicionScrollProductos")));
        localStorage.removeItem("posicionScrollProductos");
    }
});


// =========================================================================
// 2. LÓGICA DE FILTRADO EN TIEMPO REAL (BÚSQUEDA + PESTAÑAS)
// =========================================================================
let categoriaActual = "Todos";
let textoBusqueda = "";

// Filtrado por pestañas de categorías
function filterTab(botonActivo, categoria) {
    // Remover clase activa de todos los botones y ponérsela al seleccionado
    document.querySelectorAll('.filter-tab').forEach(btn => {
        btn.classList.remove('active');
    });
    botonActivo.classList.add('active');

    categoriaActual = categoria;
    aplicarFiltros();
}

// Filtrado por el cuadro de entrada de texto (Buscador)
function filterProducts(valor) {
    textoBusqueda = valor.toLowerCase().trim();
    aplicarFiltros();
}

// Función maestra combinada
function aplicarFiltros() {
    const productos = document.querySelectorAll('.product-card');
    let contadorVisibles = 0;

    productos.forEach(producto => {
        const categoriaProducto = producto.getAttribute('data-cat');
        const nombreProducto = producto.querySelector('.product-name').textContent.toLowerCase();

        const calzaCategoria = (categoriaActual === "Todos" || categoriaProducto === categoriaActual);
        const calzaBusqueda = nombreProducto.includes(textoBusqueda);

        // Se muestra si cumple ambas condiciones, si no, se oculta
        if (calzaCategoria && calzaBusqueda) {
            producto.style.display = "block"; 
            contadorVisibles++;
        } else {
            producto.style.display = "none";
        }
    });

    // Actualizar el contador dinámico en el HTML
    const txtContador = document.getElementById('catalog-count');
    if (txtContador) {
        txtContador.innerHTML = `Mostrando <strong>${contadorVisibles}</strong> de <strong>${productos.length}</strong> productos`;
    }
}