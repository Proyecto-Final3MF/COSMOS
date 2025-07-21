<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tecnicos y Asociados</title>
    <style>
        :root {
            --primary-color: #3a86ff;
            --secondary-color: #8338ec;
            --dark-color: #212529;
            --light-color: #f8f9fa;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #fd7e14;
            --border-radius: 4px;
            --box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma,  Verdana, sans-serif;
        }

        body {
            background-color: #f5f5f5;
            color: var(--dark-color);
            line-height: 1.6;
        }

       
        .navbar {
            background-color: white;
            box-shadow: var(--box-shadow);
            padding: 0.8rem 2rem;
            position: sticky;
            top: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .logo-icon {
            margin-right: 0.5rem;
        }

        .nav-links {
            display: flex;
            list-style: none;
            margin-left: auto;
        }

        .nav-links li {
            margin-left: 1.5rem;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--dark-color);
            font-weight: 500;
            transition: var(--transition);
            padding: 0.5rem 0;
            position: relative;
        }

        .nav-links a:hover {
            color: var(--primary-color);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--primary-color);
            transition: var(--transition);
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        
        .search-bar {
            display: flex;
            margin: 0 1.5rem;
            flex-grow: 1;
            max-width: 500px;
        }

        .search-bar input {
            width: 100%;
            padding: 0.6rem 1rem;
            border: 1px solid #ddd;
            border-radius: var(--border-radius) 0 0 var(--border-radius);
            font-size: 0.9rem;
            outline: none;
            transition: var(--transition);
        }

        .search-bar input:focus {
            border-color: var(--primary-color);
        }

        .search-bar button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0.6rem 1rem;
            border-radius: 0 var(--border-radius) var(--border-radius) 0;
            cursor: pointer;
            transition: var(--transition);
        }

        .search-bar button:hover {
            background-color: #2979e6;
        }

        
        .action-buttons {
            display: flex;
            align-items: center;
        }

        .btn {
            padding: 0.6rem 1.2rem;
            border-radius: var(--border-radius);
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            border: none;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            font-size: 0.9rem;
        }

        .btn-login {
            background-color: transparent;
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
            margin-right: 1rem;
        }

        .btn-login:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-signup {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-signup:hover {
            background-color: #2979e6;
        }

        
        .main-content {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .hero {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 3rem 2rem;
            text-align: center;
            box-shadow: var(--box-shadow);
            margin-bottom: 2rem;
            background-image: linear-gradient(to bottom right, rgba(58, 134, 255, 0.1), rgba(131, 56, 236, 0.1));
        }

        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--dark-color);
        }

        .hero p {
            font-size: 1.1rem;
            color: #555;
            max-width: 700px;
            margin: 0 auto 2rem;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .feature-card {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .feature-card img {
            width: 100%;
            border-radius: var(--border-radius);
            margin-bottom: 1rem;
        }

        .feature-card h3 {
            margin-bottom: 0.8rem;
            color: var(--primary-color);
        }

       
        .menu-toggle {
            display: none;
            cursor: pointer;
            font-size: 1.5rem;
            padding: 0.5rem;
        }

        
    </style>
</head>

<body>
    <nav class="navbar">
       
        <a href="#" class="logo">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQz59MAQOT2A_bbCS4Agn-5_40puEUcq69CM19b6obLlg5ugTM34Vs1wq65mAtsoCsv_Kc&usqp=CAU" height="55px" alt="logo con una T y A por tencicos y asociados :V"> 
        </a>
        
        
       
        
       
        <ul class="nav-links" id="nav-links">
            <li><a href="#">Inicio</a></li>
            <li><a href="#">Tecnicos</a></li>
            <li><a href="#">Servicios</a></li>
            <li><a href="#">Nosotros</a></li>
            <li><a href="#">Contacto</a></li>
            
        </ul>
        
        
        <div class="search-bar">
            <input type="text" placeholder="Buscador para buscar" aria-label="Buscar">
            <button type="submit">Buscar</button>
        </div>
        
       
        <div class="action-buttons">
            <button class="btn btn-login">Iniciar sesión</button>
            <button class="btn btn-signup pulse">Registrarse</button>
        </div>
    </nav>
    
   
    <main class="main-content">
        <section class="hero">
            <h1>Bienvenido a Tecnicos y Asociados</h1>
            <p>Te ayudamos a encontrar un tecnico para arreglar tu dispositivo en tiempo recor</p>
            <button class="btn btn-signup">Empezar ahora</button>
        </section>
        
        <section class="features">
            <article class="feature-card">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSamHeMYQ8nCOH82kWTvlVr8emS0NTU3a8Gd8YiL2wsC_fhItbzWdEC5tX4cXJH6l3m_C0&usqp=CAU" alt="Foto de algun tencino ahi vemos en clase">
                <h3>Benito Camelo</h3>
                <p>Tecnico del caiocelular de los mas rapidos</p>
            </article>
            
            <article class="feature-card">
                <img src="https://preview.redd.it/is-hakari-special-grade-v0-2o4idoxhyrnc1.jpeg?width=640&crop=smart&auto=webp&s=c5068f0e928b6c80047873a139377c932ee85339" alt="Lo mismo de arriba">
                <h3>Jonatan joestars</h3>
                <p>Disponible 24/7 De los mas mejores de la ciudad</p>
            </article>
            
            <article class="feature-card">
                <img src="https://content.imageresizer.com/images/memes/I-robot-Tesla-meme-96v08g.jpg" alt="lo mismo que el de arriba del de arriba">
                <h3>Daniel Domingo</h3>
                <p>Tecnico indie, lo mas nuevo en tecnologia</p>
            </article>
        </section>
    </main>
</body>
</html>
