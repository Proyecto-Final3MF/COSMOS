document.addEventListener('DOMContentLoaded', () => {
    const productosContainer = document.getElementById('productos-container');
    const paginacionContainer = document.getElementById('paginacion-container');
    const todosLosProductos = Array.from(productosContainer.getElementsByClassName('producto'));

    const elementosPorPagina = 5;
    let paginaActual = 1;

    function mostrarProductosPorPagina(pagina) {
        const inicio = (pagina - 1) * elementosPorPagina;
        const fin = inicio + elementosPorPagina;

        todosLosProductos.forEach((producto, index) => {
            if (index >= inicio && index < fin) {
                producto.style.display = 'block';
            } else {
                producto.style.display = 'none'; 
            }
        });
    }

    function generarControlesPaginacion() {
        paginacionContainer.innerHTML = ''; 

        const totalPaginas = Math.ceil(todosLosProductos.length / elementosPorPagina);

        for (let i = 1; i <= totalPaginas; i++) {
            const botonPagina = document.createElement('button');
            botonPagina.textContent = i;
            botonPagina.classList.add('pagina-btn');

            if (i === paginaActual) {
                botonPagina.classList.add('activa');
            }

            botonPagina.addEventListener('click', () => {
                paginaActual = i;
                mostrarProductosPorPagina(paginaActual);
                generarControlesPaginacion();
            });
            paginacionContainer.appendChild(botonPagina);
        }
    }

    // Inicializar la paginación al cargar la página
    mostrarProductosPorPagina(paginaActual);
    generarControlesPaginacion();
});