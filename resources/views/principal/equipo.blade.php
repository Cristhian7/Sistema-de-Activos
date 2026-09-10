<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Equipos | Sistema de Activos</title>
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
            padding: 30px 20px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
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
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #a7f3d0;
        }

        .alert-danger {
            background-color: #fef2f2;
            color: #991b1b;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #fecaca;
        }

        .card-form {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .card-form h3 {
            font-size: 18px;
            margin-bottom: 20px;
            color: #1e293b;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 10px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
        }

        .form-group input, 
        .form-group select, 
        .form-group textarea {
            padding: 9px 12px;
            border: 1.5px solid #cbd5e1;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            background-color: #fff;
        }

        .form-group input:focus, 
        .form-group select:focus, 
        .form-group textarea:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        }

        .form-actions {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }

        .btn-save {
            background-color: #4f46e5;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-cancel {
            background-color: #94a3b8;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
        }

        .card-table {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        th, td {
            text-align: left;
            padding: 10px 12px;
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
        }

        th {
            background-color: #f8fafc;
            color: #64748b;
            font-weight: 600;
        }

        tr:hover {
            background-color: #f1f5f9;
        }

        .img-preview {
            width: 45px;
            height: 45px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
        }

        .actions-cell {
            display: flex;
            gap: 6px;
        }

        .btn-edit {
            background-color: #f59e0b;
            color: white;
            padding: 5px 10px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 12px;
        }

        .btn-delete {
            background-color: #ef4444;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <div class="container">
        
        <div class="header-actions">
            <h2>Gestión de Equipos</h2>
            <a href="{{ route('principal') }}" class="btn-back">← Menú Principal</a>
        </div>

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
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

        <!-- Formulario -->
        <div class="card-form">
            <h3>{{ $equipoEditar ? 'Editar Equipo' : 'Nuevo Equipo' }}</h3>
            
            <form action="{{ $equipoEditar ? route('equipo.update', $equipoEditar->id_equipo) : route('equipo.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if ($equipoEditar)
                    @method('PUT')
                @endif
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nombre_equipo">Nombre del Equipo *</label>
                        <input type="text" name="nombre_equipo" id="nombre_equipo" value="{{ old('nombre_equipo', $equipoEditar->nombre_equipo ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="tipo_equipo">Tipo de Equipo</label>
                        <input type="text" name="tipo_equipo" id="tipo_equipo" value="{{ old('tipo_equipo', $equipoEditar->tipo_equipo ?? '') }}" placeholder="Ej. Laptop, Desktop, Servidor">
                    </div>

                    <div class="form-group">
                        <label for="cod_contable">Código Contable</label>
                        <input type="text" name="cod_contable" id="cod_contable" value="{{ old('cod_contable', $equipoEditar->cod_contable ?? '') }}">
                    </div>

                    <div class="form-group">
                        <label for="cod_ti">Código TI</label>
                        <input type="text" name="cod_ti" id="cod_ti" value="{{ old('cod_ti', $equipoEditar->cod_ti ?? '') }}">
                    </div>

                    <div class="form-group">
                        <label for="tag">Tag</label>
                        <input type="text" name="tag" id="tag" value="{{ old('tag', $equipoEditar->tag ?? '') }}">
                    </div>

                    <div class="form-group">
                        <label for="ip">Dirección IP</label>
                        <input type="text" name="ip" id="ip" value="{{ old('ip', $equipoEditar->ip ?? '') }}" placeholder="192.168.x.x">
                    </div>

                    <div class="form-group">
                        <label for="cpu">Procesador (CPU)</label>
                        <input type="text" name="cpu" id="cpu" value="{{ old('cpu', $equipoEditar->cpu ?? '') }}" placeholder="Ej. Core i7-1185G7">
                    </div>

                    <div class="form-group">
                        <label for="ram">Memoria RAM</label>
                        <input type="text" name="ram" id="ram" value="{{ old('ram', $equipoEditar->ram ?? '') }}" placeholder="Ej. 16 GB">
                    </div>

                    <div class="form-group">
                        <label for="disco">Disco Duro / Almacenamiento</label>
                        <input type="text" name="disco" id="disco" value="{{ old('disco', $equipoEditar->disco ?? '') }}" placeholder="Ej. 512 GB SSD">
                    </div>

                    <div class="form-group">
                        <label for="usuario">Usuario del Sistema</label>
                        <input type="text" name="usuario" id="usuario" value="{{ old('usuario', $equipoEditar->usuario ?? '') }}">
                    </div>

                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="text" name="password" id="password" value="{{ old('password', $equipoEditar->password ?? '') }}">
                    </div>

                    <div class="form-group">
                        <label for="ec">EC</label>
                        <input type="text" name="ec" id="ec" value="{{ old('ec', $equipoEditar->ec ?? '') }}">
                    </div>

                    <div class="form-group">
                        <label for="referencia">Referencia</label>
                        <input type="text" name="referencia" id="referencia" value="{{ old('referencia', $equipoEditar->referencia ?? '') }}">
                    </div>

                    <div class="form-group">
                        <label for="valor">Valor (Q)</label>
                        <input type="number" step="0.01" name="valor" id="valor" value="{{ old('valor', $equipoEditar->valor ?? '') }}">
                    </div>

                    <div class="form-group">
                        <label for="fecha_compra">Fecha de Compra</label>
                        <input type="date" name="fecha_compra" id="fecha_compra" value="{{ old('fecha_compra', $equipoEditar->fecha_compra ?? '') }}">
                    </div>

                    <!-- Combos de relaciones -->
                    <div class="form-group">
                        <label for="id_afiliado">Afiliado</label>
                        <select name="id_afiliado" id="id_afiliado">
                            <option value="">-- Seleccionar --</option>
                            @foreach ($afiliados as $afiliado)
                                <option value="{{ $afiliado->id_afiliado }}" {{ old('id_afiliado', $equipoEditar->id_afiliado ?? '') == $afiliado->id_afiliado ? 'selected' : '' }}>
                                    {{ $afiliado->nombre ?? $afiliado->id_afiliado }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_categoria">Categoría</label>
                        <select name="id_categoria" id="id_categoria">
                            <option value="">-- Seleccionar --</option>
                            @foreach ($categorias as $categoria)
                                @php
                                    $idCat = $categoria->id_categoria ?? $categoria->id;
                                    $nombreCat = $categoria->nombre ?? $categoria->nombre_categoria ?? $categoria->categoria ?? $idCat;                                
                                @endphp
                                <option value="{{ $categoria->id_categoria }}" {{ old('id_categoria', $equipoEditar->id_categoria ?? '') == $categoria->id_categoria ? 'selected' : '' }}>
                                    {{ $nombreCat }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_empleado">Empleado Asignado</label>
                        <select name="id_empleado" id="id_empleado">
                            <option value="">-- Seleccionar --</option>
                            @foreach ($empleados as $empleado)
                                <option value="{{ $empleado->id_empleado }}" {{ old('id_empleado', $equipoEditar->id_empleado ?? '') == $empleado->id_empleado ? 'selected' : '' }}>
                                    {{ $empleado->nombre ?? $empleado->id_empleado }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_estado">Estado</label>
                        <select name="id_estado" id="id_estado">
                            <option value="">-- Seleccionar --</option>
                            @foreach ($estados as $estado)
                                <option value="{{ $estado->id_estado }}" {{ old('id_estado', $equipoEditar->id_estado ?? '') == $estado->id_estado ? 'selected' : '' }}>
                                    {{ $estado->nombre ?? $estado->id_estado }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_modelo">Modelo / Marca</label>
                        <select name="id_modelo" id="id_modelo">
                            <option value="">-- Seleccionar Modelo --</option>
                            @foreach ($modelos as $modelo)
                                @php
                                    $idMod = $modelo->id_modelo ?? $modelo->id; 
                                    $nombreMod = $modelo->nombre ?? $modelo->nombre_modelo ?? $modelo->modelo ?? $idMod;
                                    $nombreMarca = $modelo->marca ?? '';
                                @endphp
                                <option value="{{ $idMod }}" {{ old('id_modelo', $equipoEditar->id_modelo ?? '') == $idMod ? 'selected' : '' }}>
                                    {{ $nombreMarca ? $nombreMarca . ' - ' : '' }}{{ $nombreMod }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="imagen">Imagen del Equipo</label>
                        <input type="file" name="imagen" id="imagen" accept="image/*">
                    </div>

                    <div class="form-group full-width">
                        <label for="descripcion">Descripción / Notas Adicionales</label>
                        <textarea name="descripcion" id="descripcion" rows="3">{{ old('descripcion', $equipoEditar->descripcion ?? '') }}</textarea>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save">
                        {{ $equipoEditar ? 'Actualizar Equipo' : 'Guardar Equipo' }}
                    </button>
                    @if ($equipoEditar)
                        <a href="{{ route('equipo.index') }}" class="btn-cancel">Cancelar Edición</a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Tabla -->
        <div class="card-table">
            <h3>Equipos Registrados</h3>
            <table>
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Cód. TI</th>
                        <th>IP</th>
                        <th>Procesador</th>
                        <th>RAM</th>
                        <th>Disco</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($equipos as $item)
                        <tr>
                            <td>
                                @if ($item->imagen)
                                    <img src="{{ route('equipo.imagen', $item->id_equipo) }}" alt="Foto" class="img-preview">
                                @else
                                    <span style="color: #94a3b8;">Sin foto</span>
                                @endif
                            </td>
                            <td><strong>{{ $item->nombre_equipo }}</strong></td>
                            <td>{{ $item->tipo_equipo ?? '-' }}</td>
                            <td>{{ $item->cod_ti ?? '-' }}</td>
                            <td>{{ $item->ip ?? '-' }}</td>
                            <td>{{ $item->cpu ?? '-' }}</td>
                            <td>{{ $item->ram ?? '-' }}</td>
                            <td>{{ $item->disco ?? '-' }}</td>
                            <td style="white-space: nowrap;">
                                <!-- Botón Editar -->
                                <a href="{{ route('equipo.index', ['editar' => $item->id_equipo ?? $item->id]) }}" class="btn-edit"
                                style="text-decoration: none; color: white; background-color: #f59e0b; padding: 6px 12px; border-radius: 6px; font-weight: 500; margin-right: 8px;">Editar</a>

                                <!-- Botón Eliminar -->
                                <form action="{{ route('equipo.destroy', $item->id_equipo ?? $item->id) }}" method="POST"
                                style="display: inline;" onsubmit="return confirm('¿Está seguro de eliminar este equipo?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                    style="background-color: #ef4444; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-weight: 500;">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align: center; color: #94a3b8;">No hay equipos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>