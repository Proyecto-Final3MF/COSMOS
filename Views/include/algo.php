    <!-- QUE ES ESTA MIERDA -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido, Cliente</title>
    <!-- Para hacer el diseño más rápido, incluimos Tailwind CSS directamente desde su CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">
    
</head>
<body class="flex flex-col items-center py-4">

    <!-- El encabezado principal de la página, ¡dándole la bienvenida al cliente! -->
    <header class="w-full max-w-4xl bg-gradient-to-r from-blue-500 to-indigo-600 text-white p-6 rounded-t-xl shadow-lg mb-4 text-center">
        <h1 class="text-4xl font-extrabold tracking-tight">Bienvenido, Cliente </h1>
        <h2 class="mt-2 text-lg opacity-90">Acá podrá ver sus informaciones </h2>
    </header>

    <!-- La barra de navegación para moverse por la app -->
    <nav class="w-full max-w-4xl bg-gray-800 text-white p-4 rounded-b-xl shadow-lg mb-8">
        <ul class="flex flex-col sm:flex-row justify-center space-y-2 sm:space-y-0 sm:space-x-8">
            <li><a href="#" class="nav-link block py-2 px-4 rounded-md hover:bg-gray-700 transition duration-300">Ver Mis Pedidos</a></li>
            <li><a href="#" class="nav-link block py-2 px-4 rounded-md hover:bg-gray-700 transition duration-300">Crear Nuevo Pedido</a></li>
            <li><a href="#" class="nav-link block py-2 px-4 rounded-md hover:bg-gray-700 transition duration-300">Mi Perfil</a></li>
            <li><a href="#" class="nav-link block py-2 px-4 rounded-md hover:bg-gray-700 transition duration-300">Cerrar Sesión</a></li>
        </ul>
    </nav>

    <main class="w-full max-w-4xl bg-white p-8 rounded-xl shadow-lg">
        <!-- Esta es el área principal de contenido, donde se mostrará la info relevante -->
        <section id="content-area" class="p-6 bg-gray-50 rounded-lg shadow-inner text-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Información Detallada</h2>
            <p class="text-gray-700">Aquí se mostrará la información específica del cliente o los detalles de los pedidos.</p>
          
            <!-- Una pequeña caja para mostrar mensajes al usuario, la escondemos por defecto -->
            <div id="message-box" class="hidden bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mt-6" role="alert">
                <span id="message-text" class="block sm:inline"></span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="document.getElementById('message-box').classList.add('hidden');">
                    <!-- Un icono simple para cerrar el mensaje -->
                    <svg class="fill-current h-6 w-6 text-blue-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Cerrar</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.103l-2.651 3.746a1.2 1.2 0 1 1-1.697-1.697l3.746-2.651-3.746-2.651a1.2 1.2 0 1 1 1.697-1.697L10 8.897l2.651-3.746a1.2 1.2 0 1 1 1.697 1.697L11.103 10l3.746 2.651a1.2 1.2 0 0 1 0 1.698z"/></svg>
                </span>
            </div>
        </section>
    </main>

   
    <script>
        // Una función sencilla para mostrar mensajes temporales al usuario
        function showMessage(text) {
            const msgBox = document.getElementById('message-box');
            const msgText = document.getElementById('message-text');
            msgText.textContent = text;
            msgBox.classList.remove('hidden'); // Hacemos visible la caja de mensajes
            setTimeout(() => {
                msgBox.classList.add('hidden'); // Y la escondemos después de 3 segundos
            }, 3000);
        }

        // Cuando la página se carga, añadimos un "escuchador de eventos" a cada enlace de la navegación
        document.addEventListener('DOMContentLoaded', () => {
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', (event) => {
                    event.preventDefault(); // Esto evita que el navegador recargue la página
                    const linkText = event.target.textContent; // Obtenemos el texto del enlace clicado
                    showMessage(`¡Has hecho clic en: "${linkText}"!`); // Mostramos un mensaje
                    // Si quisiéramos, aquí podríamos cambiar el contenido de la sección 'content-area'
                    // por ejemplo: document.getElementById('content-area').innerHTML = `<h2>Contenido de ${linkText}</h2><p>Este es un ejemplo...</p>`;
                });
            });
        });
    </script>
</body>
</html>
