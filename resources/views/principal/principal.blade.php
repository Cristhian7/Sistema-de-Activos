<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Principal | Gestión de Activos</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f8fafc;
            color: #1e293b;
        }

        /* Barra de navegación superior */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ffffff;
            padding: 16px 40px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        /* Lado izquierdo: Menú desplegable + Título */
        .nav-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .navbar h1 {
            font-size: 20px;
            color: #1e293b;
            font-weight: 700;
        }

        /* Lado derecho: Botones directos */
        .nav-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn {
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background-color: #4f46e5;
            color: white;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.25);
        }

        .btn-primary:hover {
            background-color: #4338ca;
            transform: translateY(-1px);
        }

        .btn-danger {
            background-color: #ef4444;
            color: white;
        }

        .btn-danger:hover {
            background-color: #dc2626;
        }

        /* Estilos del Menú Desplegable (Lado Izquierdo) */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-btn {
            background-color: #f1f5f9;
            color: #334155;
            padding: 10px 16px;
            font-size: 14px;
            font-weight: 600;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .dropdown-btn:hover {
            background-color: #e2e8f0;
            color: #1e293b;
        }

        .dropdown-arrow {
            font-size: 10px;
        }

        /* Contenido del menú desplegable */
        .dropdown-menu {
            display: none;
            position: absolute;
            left: 0;
            top: 115%;
            background-color: #ffffff;
            min-width: 220px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            z-index: 1000;
        }

        .dropdown-menu.show {
            display: block;
            animation: fadeIn 0.2s ease;
        }

        .dropdown-header {
            padding: 10px 16px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: #94a3b8;
            letter-spacing: 0.5px;
            background-color: #f8fafc;
            border-bottom: 1px solid #f1f5f9;
        }

        .dropdown-menu a {
            color: #334155;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            font-size: 14px;
            font-weight: 500;
            transition: background-color 0.15s ease, color 0.15s ease;
        }

        .dropdown-menu a:hover {
            background-color: #f1f5f9;
            color: #4f46e5;
        }

        .dropdown-divider {
            height: 1px;
            background-color: #e2e8f0;
            margin: 4px 0;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Banner Principal con Imagen */
        .hero-banner {
            position: relative;
            width: calc(100% - 80px);
            max-width: 1200px;
            margin: 40px auto;
            height: 380px;
            border-radius: 20px;
            overflow: hidden;
            background-image: linear-gradient(rgba(15, 23, 42, 0.65), rgba(15, 23, 42, 0.65)), 
                              url('https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&w=1200&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .hero-banner h2 {
            font-size: 36px;
            font-weight: 800;
            margin-bottom: 12px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .hero-banner p {
            font-size: 18px;
            max-width: 600px;
            opacity: 0.9;
        }

        .alert-success {
            max-width: 1200px;
            margin: 20px auto 0 auto;
            width: calc(100% - 80px);
            background-color: #f0fdf4;
            color: #166534;
            padding: 14px 20px;
            border-radius: 10px;
            border: 1px solid #bbf7d0;
            font-weight: 500;
        }
    </style>
</head>
<body>

    <!-- Menú Superior -->
    <nav class="navbar">
        <!-- Lado Izquierdo: Menú Desplegable + Título -->
        <div class="nav-left">
            <div class="dropdown">
                <button class="dropdown-btn" id="dropdownToggle">
                    <span>☰ Menú</span>
                    <span class="dropdown-arrow">▼</span>
                </button>
                
                <div class="dropdown-menu" id="dropdownMenu">
                    <div class="dropdown-header">Equipos y Catálogos</div>
                    <a href="#">Ver Inventario</a>
                    <a href="#">Nuevo Equipo</a>
                    <!--<a href="#">Nueva Marca</a>-->
                    <!--ruta de nueva marca-->
                    <a href="{{ route('marcas.create') }}">Nueva Marca</a>
                    <a href="{{ route('modelos.create') }}">Nuevo Modelo</a>
                    <a href="{{ route('categorias.create') }}">Nueva Categoría</a>
                    <div class="dropdown-divider"></div>
                    <div class="dropdown-header">Personal</div>
                    <a href="#">Empleados</a>
                    <a href="#">Puestos</a>

                    <div class="dropdown-divider"></div>
                    <div class="dropdown-header">Gestión</div>
                    <a href="#">Mantenimiento</a>
                    <a href="#">Reportería</a>
                </div>
            </div>

            <h1>Sistema de Activos TI</h1>
        </div>

        <!-- Lado Derecho: Botón de Nuevo Usuario y Cerrar Sesión -->
        <div class="nav-right">
            <a href="{{ route('usuarios.create') }}" class="btn btn-primary">+ Nuevo Usuario</a>
            
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
            </form>
        </div>
    </nav>

    <!-- Alerta de éxito -->
    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Banner con Imagen de Computadoras -->
    <div class="hero-banner">
        <h2>Control de Equipos</h2>
        <p>Fundación Hábitat para La Humanidad Guatemala</p>
    </div>

    <!-- Script para abrir/cerrar el menú desplegable -->
    <script>
        const toggleBtn = document.getElementById('dropdownToggle');
        const menu = document.getElementById('dropdownMenu');

        toggleBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            menu.classList.toggle('show');
        });

        document.addEventListener('click', (e) => {
            if (!menu.contains(e.target) && !toggleBtn.contains(e.target)) {
                menu.classList.remove('show');
            }
        });
    </script>

</body>
</html>