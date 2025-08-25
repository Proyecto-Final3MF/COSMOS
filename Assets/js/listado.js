document.addEventListener('DOMContentLoaded', () => {
    const solicitudContainer = document.getElementById('solicitud-container');
    const paginacionContainer = document.getElementById('paginacion-container');
    const filterButtons = document.querySelectorAll('.filter-buttons button');

    const elementosPorPagina = 3;
    let paginaActual = 1;
    let todosLosProductos = [];

    function initializePagination() {
        todosLosProductos = Array.from(solicitudContainer.getElementsByClassName('solicitud'));
        paginaActual = 1;
        mostrarProductosPorPagina(paginaActual);
        generarControlesPaginacion();
        updateActiveFilterButton();
    }

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

        if (totalPaginas <= 1) {
            return;
        }

        // --- "Primera Página" Button ---
        const btnPrimera = document.createElement('button');
        btnPrimera.textContent = '<<';
        btnPrimera.classList.add('pagina-btn', 'control-btn');
        btnPrimera.disabled = (paginaActual === 1);
        btnPrimera.addEventListener('click', () => {
            paginaActual = 1;
            mostrarProductosPorPagina(paginaActual);
            generarControlesPaginacion();
        });
        paginacionContainer.appendChild(btnPrimera);

        // --- "Anterior" Button ---
        const btnAnterior = document.createElement('button');
        btnAnterior.textContent = '<';
        btnAnterior.classList.add('pagina-btn', 'control-btn');
        btnAnterior.disabled = (paginaActual === 1);
        btnAnterior.addEventListener('click', () => {
            if (paginaActual > 1) {
                paginaActual--;
                mostrarProductosPorPagina(paginaActual);
                generarControlesPaginacion();
            }
        });
        paginacionContainer.appendChild(btnAnterior);

        // --- Page Number Buttons ---
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

        // --- "Siguiente" Button ---
        const btnSiguiente = document.createElement('button');
        btnSiguiente.textContent = '>';
        btnSiguiente.classList.add('pagina-btn', 'control-btn');
        btnSiguiente.disabled = (paginaActual === totalPaginas);
        btnSiguiente.addEventListener('click', () => {
            if (paginaActual < totalPaginas) {
                paginaActual++;
                mostrarProductosPorPagina(paginaActual);
                generarControlesPaginacion();
            }
        });
        paginacionContainer.appendChild(btnSiguiente);

        // --- "Última Página" Button ---
        const btnUltima = document.createElement('button');
        btnUltima.textContent = '>>';
        btnUltima.classList.add('pagina-btn', 'control-btn');
        btnUltima.disabled = (paginaActual === totalPaginas);
        btnUltima.addEventListener('click', () => {
            paginaActual = totalPaginas;
            mostrarProductosPorPagina(paginaActual);
            generarControlesPaginacion();
        });
        paginacionContainer.appendChild(btnUltima);
    }

    function updateActiveFilterButton() {
        const urlParams = new URLSearchParams(window.location.search);
        const currentFilter = urlParams.get('estado') || 'all';

        filterButtons.forEach(button => {
            if (button.dataset.filter === currentFilter) {
                button.classList.add('active');
            } else {
                button.classList.remove('active');
            }
        });
    }

    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            const filterValue = button.dataset.filter;
            window.location.href = `?estado=${filterValue}`;
        });
    });

    initializePagination();
});