<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Empleados | Sistema de Activos</title>
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
            max-width: 1200px;
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

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #a7f3d0;
            font-size: 14px;
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
            grid-template-columns: 1fr 2.2fr;
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

        .btn-cancel {
            display: block;
            width: 100%;
            text-align: center;
            background-color: #94a3b8;
            color: white;
            padding: 10px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            margin-top: 8px;
        }

        .btn-cancel:hover {
            background-color: #64748b;
        }

        /* Tabla */
        .card-table {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            overflow-x: auto;
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

        /* Botones de Acción */
        .actions-cell {
            display: flex;
            gap: 8px;
        }

        .btn-edit {
            background-color: #f59e0b;
            color: white;
            padding: 6px 10px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
        }

        .btn-edit:hover {
            background-color: #d97706;
        }

        .btn-delete {
            background-color: #ef4444;
            color: white;
            border: none;
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-delete:hover {
            background-color: #dc2626;
        }

        @media (max-width: 900px) {
            .grid-layout {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        
        <div class="header-actions">
            <h2>Gestión de Empleados</h2>
            <a href="{{ route('principal') }}" class="btn-back">← Volver al Menú Principal</a>
        </div>

        <!-- Alertas de Éxito y Error -->
        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

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
            
            <!-- Formulario dinámico (Crear / Editar) -->
            <div class="card-form">
                <h3>{{ $empleadoEditar ? 'Editar Empleado' : 'Nuevo Empleado' }}</h3>
                
                <form action="{{ $empleadoEditar ? route('empleados.update', $empleadoEditar->id_empleado) : route('empleados.store') }}" method="POST">
                    @csrf
                    @if ($empleadoEditar)
                        @method('PUT')
                    @endif
                    
                    <!-- Nombre Completo -->
                    <div class="form-group">
                        <label for="nombre">Nombre Completo</label>
                        <input 
                            type="text" 
                            name="nombre" 
                            id="nombre" 
                            placeholder="Ej. Juan Pérez" 
                            value="{{ old('nombre', $empleadoEditar->nombre ?? '') }}" 
                            required 
                            autofocus
                        >
                    </div>

                    <!-- Afiliado -->
                    <div class="form-group">
                        <label for="id_afiliado">Afiliado</label>
                        <select name="id_afiliado" id="id_afiliado" required>
                            <option value="">-- Seleccione un afiliado --</option>
                            @foreach ($afiliados as $afiliado)
                                <option value="{{ $afiliado->id_afiliado }}" 
                                    {{ old('id_afiliado', $empleadoEditar->id_afiliado ?? '') == $afiliado->id_afiliado ? 'selected' : '' }}>
                                    {{ $afiliado->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Puesto -->
                    <div class="form-group">
                        <label for="id_puesto">Puesto</label>
                        <select name="id_puesto" id="id_puesto" required>
                            <option value="">-- Seleccione un puesto --</option>
                            @foreach ($puestos as $puesto)
                                <option value="{{ $puesto->id_puesto }}" 
                                    {{ old('id_puesto', $empleadoEditar->id_puesto ?? '') == $puesto->id_puesto ? 'selected' : '' }}>
                                    {{ $puesto->puesto ?? $puesto->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Código L4 -->
                    <div class="form-group">
                        <label for="cod_l4">Código L4</label>
                        <input 
                            type="text" 
                            name="cod_l4" 
                            id="cod_l4" 
                            placeholder="Ej. L4-00123" 
                            value="{{ old('cod_l4', $empleadoEditar->cod_l4 ?? '') }}"
                        >
                    </div>

                    <!-- DPI -->
                    <div class="form-group">
                        <label for="dpi">DPI</label>
                        <input 
                            type="text" 
                            name="dpi" 
                            id="dpi" 
                            placeholder="Ej. 1234567890101" 
                            value="{{ old('dpi', $empleadoEditar->dpi ?? '') }}" 
                            required
                        >
                    </div>

                    <button type="submit" class="btn-save">
                        {{ $empleadoEditar ? 'Actualizar Empleado' : 'Guardar Empleado' }}
                    </button>

                    @if ($empleadoEditar)
                        <a href="{{ route('empleados.create') }}" class="btn-cancel">Cancelar Edición</a>
                    @endif
                </form>
            </div>

            <!-- Listado con Acciones de Edición y Eliminación -->
            <div class="card-table">
                <h3>Listado de Empleados</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Afiliado</th>
                            <th>Puesto</th>
                            <th>Cód. L4</th>
                            <th>DPI</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($empleados as $item)
                            <tr>
                                <td>{{ $item->id_empleado }}</td>
                                <td>{{ $item->nombre }}</td>
                                <td>{{ $item->afiliado->nombre ?? 'N/A' }}</td>
                                <td>{{ $item->puesto->puesto ?? $item->puesto->nombre ?? 'N/A' }}</td>
                                <td>{{ $item->cod_l4 ?? '-' }}</td>
                                <td>{{ $item->dpi }}</td>
                                <td>
                                    <div class="actions-cell">
                                        <a href="{{ route('empleados.edit', $item->id_empleado) }}" class="btn-edit">Editar</a>
                                        
                                        <form action="{{ route('empleados.destroy', $item->id_empleado) }}" method="POST" onsubmit="return confirm('¿Está seguro de eliminar este empleado?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; color: #94a3b8;">No hay empleados registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </div>

</body>
</html>