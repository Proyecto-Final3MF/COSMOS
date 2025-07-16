document.addEventListener('DOMContentLoaded', () => {
    const solicitudContainer = document.getElementById('solicitud-container');
    const paginacionContainer = document.getElementById('paginacion-container');
    const filterButtons = document.querySelectorAll('.filter-buttons button');

    const elementosPorPagina = 3; // Cantidad de elementos a mostrar por página
    let paginaActual = 1;
    let todosLosProductos = []; // This will store the currently visible products after filtering

    // Function to initialize or re-initialize pagination
    function initializePagination() {
        // Re-fetch the current products after a filter might have changed them
        todosLosProductos = Array.from(solicitudContainer.getElementsByClassName('solicitud'));
        paginaActual = 1; // Reset to the first page when filters change
        mostrarProductosPorPagina(paginaActual);
        generarControlesPaginacion();
        updateActiveFilterButton(); // Update active button state
    }

    // Function to show products for the current page
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

    // Function to generate pagination controls
    function generarControlesPaginacion() {
        paginacionContainer.innerHTML = '';

        const totalPaginas = Math.ceil(todosLosProductos.length / elementosPorPagina);

        if (totalPaginas <= 1) { // Hide pagination if only one page or no products
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

    // Function to update the active state of filter buttons
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

    // Add event listeners to filter buttons
    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            const filterValue = button.dataset.filter;
            // Redirect to the same page with the new 'estado' query parameter
            window.location.href = `?estado=${filterValue}`;
        });
    });

    // Initialize pagination and active button state on page load
    initializePagination();
});

document.addEventListener('DOMContentLoaded', function() {
    const toggleTemaBtn = document.getElementById('toggleTemaBtn');
    const bodyElement = document.body; // 'document.body' já se refere diretamente ao elemento body

    // Adiciona um ouvinte de evento de clique ao botão
    toggleTemaBtn.addEventListener('click', function() {
        // Alterna entre as classes 'tema-claro' e 'tema-escuro' no body
        bodyElement.classList.toggle('tema-claro');
        bodyElement.classList.toggle('tema-escuro');

        // Opcional: Salvar a preferência do usuário (ex: no LocalStorage)
        // Isso faria com que o tema escolhido persistisse mesmo se o usuário sair da página e voltar
        if (bodyElement.classList.contains('tema-escuro')) {
            localStorage.setItem('tema', 'escuro');
        } else {
            localStorage.setItem('tema', 'claro');
        }
    });

    // Opcional: Carregar a preferência de tema ao carregar a página
    const savedTheme = localStorage.getItem('tema');
    if (savedTheme === 'escuro') {
        bodyElement.classList.remove('tema-claro');
        bodyElement.classList.add('tema-escuro');
    } else {
        bodyElement.classList.remove('tema-escuro');
        bodyElement.classList.add('tema-claro');
    }
});