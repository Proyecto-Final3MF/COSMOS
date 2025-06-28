// script.js

document.addEventListener('DOMContentLoaded', () => {
    const productosContainer = document.getElementById('productos-container');
    const paginacionContainer = document.getElementById('paginacion-container');
    const todosLosProductos = Array.from(productosContainer.getElementsByClassName('producto'));

    const elementosPorPagina = 5; // Puedes ajustar cuántos elementos quieres por página
    let paginaActual = 1;

    function mostrarProductosPorPagina(pagina) {
        const inicio = (pagina - 1) * elementosPorPagina;
        const fin = inicio + elementosPorPagina;

        todosLosProductos.forEach((producto, index) => {
            if (index >= inicio && index < fin) {
                producto.style.display = 'block'; // Muestra el producto
            } else {
                producto.style.display = 'none'; // Oculta el producto
            }
        });
    }

    function generarControlesPaginacion() {
        paginacionContainer.innerHTML = ''; // Limpia los controles existentes

        const totalPaginas = Math.ceil(todosLosProductos.length / elementosPorPagina);

        for (let i = 1; i <= totalPaginas; i++) {
            const botonPagina = document.createElement('button');
            botonPagina.textContent = i;
            botonPagina.classList.add('pagina-btn');

            if (i === paginaActual) {
                botonPagina.classList.add('activa'); // Para estilizar la página actual
            }

            botonPagina.addEventListener('click', () => {
                paginaActual = i;
                mostrarProductosPorPagina(paginaActual);
                generarControlesPaginacion(); // Regenera los controles para actualizar el estado activo
            });
            paginacionContainer.appendChild(botonPagina);
        }
    }

    // Inicializar la paginación al cargar la página
    mostrarProductosPorPagina(paginaActual);
    generarControlesPaginacion();
});