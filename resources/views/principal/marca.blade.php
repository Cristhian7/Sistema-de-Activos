<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Marcas | Sistema de Activos</title>
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

        .form-group input {
            width: 100%;
            padding: 10px 12px;
            border: 1.5px solid #cbd5e1;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
        }

        .form-group input:focus {
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
            <h2>Catálogo de Marcas</h2>
            <a href="{{ route('principal') }}" class="btn-back">← Volver al Menú Principal</a>
        </div>

        <!-- Errores de validación -->
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
            
            <!-- Columna Izquierda: Formulario para crear -->
            <div class="card-form">
                <h3>Nueva Marca</h3>
                <form action="{{ route('marcas.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label for="marca">Nombre de la Marca</label>
                        <input 
                            type="text" 
                            name="marca" 
                            id="marca" 
                            placeholder="Ej. Dell, HP, Lenovo" 
                            value="{{ old('marca') }}" 
                            required 
                            autofocus
                        >
                    </div>

                    <button type="submit" class="btn-save">Guardar Marca</button>
                </form>
            </div>

            <!-- Columna Derecha: Tabla para visualizar -->
            <div class="card-table">
                <h3>Listado de Marcas Registradas</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre de Marca</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($marcas as $item)
                            <tr>
                                <td>{{ $item->id_marca }}</td>
                                <td>{{ $item->marca }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" style="text-align: center; color: #94a3b8;">No hay marcas registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </div>

</body>
</html>