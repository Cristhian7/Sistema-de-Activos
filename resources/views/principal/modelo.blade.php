<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Modelos | Sistema de Activos</title>
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
            padding: 40px 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .header-actions h2 {
            font-size: 24px;
            color: #0f172a;
        }

        .btn-back {
            background-color: #64748b;
            color: white;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: background 0.2s;
        }

        .btn-back:hover {
            background-color: #475569;
        }

        .alert-danger {
            background-color: #fef2f2;
            color: #991b1b;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #fecaca;
            font-size: 14px;
        }

        .alert-danger ul {
            list-style-position: inside;
        }

        .grid-layout {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 24px;
        }

        /* Formulario */
        .card-form {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            height: fit-content;
        }

        .card-form h3 {
            font-size: 18px;
            margin-bottom: 16px;
            color: #1e293b;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 10px 12px;
            border: 1.5px solid #cbd5e1;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            background-color: #fff;
        }

        .form-group input:focus, .form-group select:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        }

        .btn-save {
            width: 100%;
            background-color: #4f46e5;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-save:hover {
            background-color: #4338ca;
        }

        /* Tabla */
        .card-table {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .card-table h3 {
            font-size: 18px;
            margin-bottom: 16px;
            color: #1e293b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        th, td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
        }

        th {
            background-color: #f8fafc;
            color: #64748b;
            font-weight: 600;
        }

        tr:hover {
            background-color: #f1f5f9;
        }

        @media (max-width: 768px) {
            .grid-layout {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        
        <div class="header-actions">
            <h2>Catálogo de Modelos</h2>
            <a href="{{ route('principal') }}" class="btn-back">← Volver al Menú Principal</a>
        </div>

        <!-- Mensajes de Error de Validación -->
        @if ($errors->any())
            <div class="alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid-layout">
            
            <!-- Columna Izquierda: Formulario -->
            <div class="card-form">
                <h3>Nuevo Modelo</h3>
                <form action="{{ route('modelos.store') }}" method="POST">
                    @csrf
                    
                    <!-- Selección de Marca (Desplegable) -->
                    <div class="form-group">
                        <label for="id_marca">Marca</label>
                        <select name="id_marca" id="id_marca" required>
                            <option value="">-- Seleccione una marca --</option>
                            @foreach ($marcas as $marca)
                                <option value="{{ $marca->id_marca }}" {{ old('id_marca') == $marca->id_marca ? 'selected' : '' }}>
                                    {{ $marca->marca }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Nombre del Modelo -->
                    <div class="form-group">
                        <label for="modelo">Nombre del Modelo</label>
                        <input 
                            type="text" 
                            name="modelo" 
                            id="modelo" 
                            placeholder="Ej. Latitude 3420, ThinkPad X1" 
                            value="{{ old('modelo') }}" 
                            required
                        >
                    </div>

                    <button type="submit" class="btn-save">Guardar Modelo</button>
                </form>
            </div>

            <!-- Columna Derecha: Tabla -->
            <div class="card-table">
                <h3>Listado de Modelos Registrados</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Modelo</th>
                            <th>Marca</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($modelos as $item)
                            <tr>
                                <td>{{ $item->id_modelo }}</td>
                                <td>{{ $item->modelo }}</td>
                                <td>{{ $item->marca->marca ?? 'Sin marca' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="text-align: center; color: #94a3b8;">No hay modelos registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </div>

</body>
</html>