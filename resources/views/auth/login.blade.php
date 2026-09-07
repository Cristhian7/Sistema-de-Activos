<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | Sistema de Activos</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            /* Fondo con degradado llamativo y moderno */
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #d946ef 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-card {
            background-color: #ffffff;
            padding: 40px 32px;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            transform: translateY(0);
            transition: transform 0.3s ease;
        }

        .login-header {
            text-align: center;
            margin-bottom: 28px;
        }

        .login-header h2 {
            color: #1e293b;
            font-size: 26px;
            font-weight: 700;
        }

        .login-header p {
            color: #64748b;
            font-size: 14px;
            margin-top: 6px;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .alert-danger {
            background-color: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert-success {
            background-color: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert ul {
            list-style-position: inside;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid #cbd5e1;
            border-radius: 10px;
            font-size: 15px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
            outline: none;
        }

        .form-group input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.2);
        }

        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: #ffffff;
            border: none;
            padding: 14px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.35);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.45);
        }

        .btn-submit:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-header">
            <h2>Gestión de Activos</h2>
            <p>Ingresa tus datos para acceder</p>
        </div>

        <!-- Alerta de mensaje exitoso -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Alerta de errores de validación -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="nombre_usuario">Nombre de Usuario</label>
                <input 
                    type="text" 
                    name="nombre_usuario" 
                    id="nombre_usuario" 
                    value="{{ old('nombre_usuario') }}" 
                    placeholder="Ej. cristhian"
                    required 
                    autofocus
                >
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    placeholder="••••••••"
                    required
                >
            </div>

            <button type="submit" class="btn-submit">Ingresar</button>
        </form>
    </div>

</body>
</html>