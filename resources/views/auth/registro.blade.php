<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Nuevo Usuario</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', sans-serif; }
        body { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .card { background: white; padding: 30px; border-radius: 12px; width: 100%; max-width: 400px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: 600; }
        input { width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; }
        .btn { width: 100%; padding: 12px; background: #4f46e5; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Registrar Nuevo Usuario</h2><br>
        <form action="{{ route('usuarios.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nombre de Usuario</label>
                <input type="text" name="nombre_usuario" required>
            </div>
            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn">Guardar Usuario</button>
        </form>
    </div>
</body>
</html>