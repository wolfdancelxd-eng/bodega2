// =========================================================================
// 1. PERSISTENCIA DE SCROLL
// =========================================================================
document.addEventListener("submit", function () {
    localStorage.setItem("posicionScrollProductos", window.scrollY);
});


// =========================================================================
// 2. VARIABLES GLOBALES
// =========================================================================
let categoriaActual = localStorage.getItem("categoriaActual") || "Todos";
let textoBusqueda = localStorage.getItem("textoBusqueda") || "";


// =========================================================================
// 3. CUANDO CARGA LA PÁGINA
// =========================================================================
window.addEventListener("load", function () {

    // Restaurar scroll
    const posicion = localStorage.getItem("posicionScrollProductos");

    if (posicion !== null) {
        window.scrollTo(0, parseInt(posicion));
        localStorage.removeItem("posicionScrollProductos");
    }

    // Restaurar texto del buscador
    const buscador = document.querySelector(".search-box");

    if (buscador) {
        buscador.value = textoBusqueda;
    }

    // Restaurar pestaña activa
    document.querySelectorAll(".filter-tab").forEach(btn => {

        btn.classList.remove("active");

        if (btn.textContent.trim() === categoriaActual) {
            btn.classList.add("active");
        }

    });

    aplicarFiltros();

});


// =========================================================================
// 4. FILTRO POR CATEGORÍAS
// =========================================================================
function filterTab(botonActivo, categoria) {

    document.querySelectorAll(".filter-tab").forEach(btn => {
        btn.classList.remove("active");
    });

    botonActivo.classList.add("active");

    categoriaActual = categoria;

    // Guardar categoría
    localStorage.setItem("categoriaActual", categoriaActual);

    aplicarFiltros();

}


// =========================================================================
// 5. BUSCADOR
// =========================================================================
function filterProducts(valor) {

    textoBusqueda = valor.toLowerCase().trim();

    // Guardar búsqueda
    localStorage.setItem("textoBusqueda", textoBusqueda);

    aplicarFiltros();

}


// =========================================================================
// 6. FILTRO GENERAL
// =========================================================================
function aplicarFiltros() {

    const productos = document.querySelectorAll(".product-card");

    let contadorVisibles = 0;

    productos.forEach(producto => {

        const categoriaProducto = producto.getAttribute("data-cat");

        const nombreProducto = producto
            .querySelector(".product-name")
            .textContent
            .toLowerCase();

        const calzaCategoria =
            categoriaActual === "Todos" ||
            categoriaProducto === categoriaActual;

        const calzaBusqueda =
            nombreProducto.includes(textoBusqueda);

        if (calzaCategoria && calzaBusqueda) {

            producto.style.display = "block";
            contadorVisibles++;

        } else {

            producto.style.display = "none";

        }

    });

    const txtContador = document.getElementById("catalog-count");

    if (txtContador) {

        txtContador.innerHTML =
            `Mostrando <strong>${contadorVisibles}</strong> de <strong>${productos.length}</strong> productos`;

    }

}
