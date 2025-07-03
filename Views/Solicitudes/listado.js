document.addEventListener('DOMContentLoaded', () => {
    const productosContainer = document.getElementById('solicitud-container');
    const paginacionContainer = document.getElementById('paginacion-container');
    const todosLosProductos = Array.from(productosContainer.getElementsByClassName('solicitud'));

    const elementosPorPagina = 5; // Cantidad de elementos a mostrar por página
    let paginaActual = 1;

    // Función para mostrar los productos correspondientes a la página actual
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

    // Función para generar todos los controles de paginación
    function generarControlesPaginacion() {
        paginacionContainer.innerHTML = ''; // Limpia los controles existentes

        const totalPaginas = Math.ceil(todosLosProductos.length / elementosPorPagina);

        // --- Botón "Primera Página" ---
        const btnPrimera = document.createElement('button');
        btnPrimera.textContent = '<<';
        btnPrimera.classList.add('pagina-btn', 'control-btn');
        btnPrimera.disabled = (paginaActual === 1); // Deshabilita si ya estás en la primera página
        btnPrimera.addEventListener('click', () => {
            paginaActual = 1;
            mostrarProductosPorPagina(paginaActual);
            generarControlesPaginacion();
        });
        paginacionContainer.appendChild(btnPrimera);

        // --- Botón "Anterior" ---
        const btnAnterior = document.createElement('button');
        btnAnterior.textContent = '<';
        btnAnterior.classList.add('pagina-btn', 'control-btn');
        btnAnterior.disabled = (paginaActual === 1); // Deshabilita si ya estás en la primera página
        btnAnterior.addEventListener('click', () => {
            if (paginaActual > 1) {
                paginaActual--;
                mostrarProductosPorPagina(paginaActual);
                generarControlesPaginacion();
            }
        });
        paginacionContainer.appendChild(btnAnterior);

        // --- Botones de Números de Página ---
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
                generarControlesPaginacion(); // Regenera los controles para actualizar el estado activo y los botones de control
            });
            paginacionContainer.appendChild(botonPagina);
        }

        // --- Botón "Siguiente" ---
        const btnSiguiente = document.createElement('button');
        btnSiguiente.textContent = '>';
        btnSiguiente.classList.add('pagina-btn', 'control-btn');
        btnSiguiente.disabled = (paginaActual === totalPaginas); // Deshabilita si ya estás en la última página
        btnSiguiente.addEventListener('click', () => {
            if (paginaActual < totalPaginas) {
                paginaActual++;
                mostrarProductosPorPagina(paginaActual);
                generarControlesPaginacion();
            }
        });
        paginacionContainer.appendChild(btnSiguiente);

        // --- Botón "Última Página" ---
        const btnUltima = document.createElement('button');
        btnUltima.textContent = '>>';
        btnUltima.classList.add('pagina-btn', 'control-btn');
        btnUltima.disabled = (paginaActual === totalPaginas); // Deshabilita si ya estás en la última página
        btnUltima.addEventListener('click', () => {
            paginaActual = totalPaginas;
            mostrarProductosPorPagina(paginaActual);
            generarControlesPaginacion();
        });
        paginacionContainer.appendChild(btnUltima);
    }

    // Inicializar la paginación al cargar la página
    mostrarProductosPorPagina(paginaActual);
    generarControlesPaginacion();
});