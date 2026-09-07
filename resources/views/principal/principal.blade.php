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

        .navbar h1 {
            font-size: 20px;
            color: #1e293b;
            font-weight: 700;
        }

        .actions {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .btn {
            padding: 10px 20px;
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
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3);
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

        /* Contenedor principal con imagen de fondo */
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
        <h1>Sistema de Gestión de Activos</h1>
        <div class="actions">
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
        <h2>Control y Administración de Equipos</h2>
        <p>Gestiona los activos de cómputo, licencias y usuarios de tu organización de forma eficiente.</p>
    </div>

</body>
</html>