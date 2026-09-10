<div class="container mx-auto px-4 py-6">

    <!-- Encabezado Superior -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 style="font-size: 1.75rem; font-weight: 700; color: #111827; margin: 0;">
            Gestión de Mantenimientos
        </h1>
        <a href="{{ route('principal') }}" 
           style="background-color: #4b5563; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 0.875rem; font-weight: 500; display: inline-flex; align-items: center;">
            ← Menú Principal
        </a>
    </div>

    <!-- Tarjeta Principal Blanca -->
    <div style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); padding: 24px; border: 1px solid #e5e7eb;">
        
        <h2 style="font-size: 1.125rem; font-weight: 600; color: #1f2937; margin-bottom: 20px;">
            {{ isset($mantenimientoEditar) ? 'Editar Mantenimiento' : 'Nuevo Mantenimiento' }}
        </h2>

        <form action="{{ isset($mantenimientoEditar) ? route('mantenimiento.update', $mantenimientoEditar->id_mante) : route('mantenimiento.store') }}" 
              method="POST" 
              enctype="multipart/form-data">
            @csrf
            @if(isset($mantenimientoEditar))
                @method('PUT')
            @endif

            <!-- Fila 1: Búsqueda Cód. Contable, Nombre Equipo y Tipo Mantenimiento -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 16px;">
                
                <!-- Búsqueda filtrada de Código Contable -->
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 6px;">Código Contable *</label>
                    <input type="text" 
                           id="input_cod_contable_search" 
                           list="lista_codigos_contables" 
                           placeholder="Buscar código..." 
                           autocomplete="off"
                           style="width: 100%; padding: 8px 12px; border-radius: 6px; border: 1px solid #d1d5db; font-size: 0.875rem;"
                           oninput="buscarYAutollenarEquipo(this.value)">

                    <datalist id="lista_codigos_contables">
                        @foreach($equipos as $eq)
                            <option value="{{ $eq->cod_contable }}">
                        @endforeach
                    </datalist>

                    <input type="hidden" id="id_equipo_hidden" name="id_equipo" required value="{{ $mantenimientoEditar->id_equipo ?? '' }}">
                </div>

                <!-- Nombre del Equipo (Autorellenado) -->
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 6px;">Equipo (Autorellenado)</label>
                    <input type="text" id="input_nombre_equipo" readonly style="width: 100%; padding: 8px 12px; border-radius: 6px; border: 1px solid #e5e7eb; background-color: #f9fafb; color: #374151; font-weight: 600; font-size: 0.875rem;" placeholder="Se rellenará automáticamente...">
                </div>

                <!-- Tipo de Mantenimiento -->
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 6px;">Tipo de Mantenimiento *</label>
                    <select name="id_tipo_mante" required style="width: 100%; padding: 8px 12px; border-radius: 6px; border: 1px solid #d1d5db; font-size: 0.875rem; background-color: #ffffff;">
                        <option value="">-- Seleccionar --</option>
                        @foreach($tiposMantenimiento as $tipo)
                            <option value="{{ $tipo->id_tipo_mante }}" {{ ($mantenimientoEditar->id_tipo_mante ?? '') == $tipo->id_tipo_mante ? 'selected' : '' }}>
                                {{ $tipo->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <!-- Fila 2: Detalles Técnicos del Equipo (Solo Lectura) -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 16px; margin-bottom: 16px; background-color: #f8fafc; padding: 12px; border-radius: 6px; border: 1px solid #f1f5f9;">
                <div>
                    <label style="display: block; font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 4px;">Código TI</label>
                    <input type="text" id="input_cod_ti" readonly style="width: 100%; padding: 6px 10px; border-radius: 4px; border: 1px solid #cbd5e1; background-color: #f1f5f9; font-size: 0.85rem;" placeholder="...">
                </div>

                <div>
                    <label style="display: block; font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 4px;">Tag</label>
                    <input type="text" id="input_tag" readonly style="width: 100%; padding: 6px 10px; border-radius: 4px; border: 1px solid #cbd5e1; background-color: #f1f5f9; font-size: 0.85rem;" placeholder="...">
                </div>

                <div>
                    <label style="display: block; font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 4px;">EC</label>
                    <input type="text" id="input_ec" readonly style="width: 100%; padding: 6px 10px; border-radius: 4px; border: 1px solid #cbd5e1; background-color: #f1f5f9; font-size: 0.85rem;" placeholder="...">
                </div>

                <div>
                    <label style="display: block; font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 4px;">Hardware (CPU / RAM / Disco)</label>
                    <input type="text" id="input_hardware" readonly style="width: 100%; padding: 6px 10px; border-radius: 4px; border: 1px solid #cbd5e1; background-color: #f1f5f9; font-size: 0.85rem;" placeholder="...">
                </div>
            </div>

            <!-- Fila 3: Fechas, Técnico Asignado y N° Ticket -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 16px;">
                
                <!-- Fecha Inicio (Cambiado a fecha_inicio para coincidir con la DB) -->
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 6px;">Fecha Inicial *</label>
                    <input type="date" name="fecha_inicio" required value="{{ $mantenimientoEditar->fecha_inicio ?? date('Y-m-d') }}" style="width: 100%; padding: 8px 12px; border-radius: 6px; border: 1px solid #d1d5db; font-size: 0.875rem;">
                </div>

                <!-- Fecha Final -->
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 6px;">Fecha Final</label>
                    <input type="date" name="fecha_final" value="{{ $mantenimientoEditar->fecha_final ?? '' }}" style="width: 100%; padding: 8px 12px; border-radius: 6px; border: 1px solid #d1d5db; font-size: 0.875rem;">
                </div>

                <!-- Combobox Técnico Fijo (Cambiado a name="tecnico") -->
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 6px;">Técnico Asignado *</label>
                    <select name="tecnico" required style="width: 100%; padding: 8px 12px; border-radius: 6px; border: 1px solid #d1d5db; font-size: 0.875rem; background-color: #ffffff;">
                        <option value="">-- Seleccionar --</option>
                        <option value="Cristhian Reyes" {{ ($mantenimientoEditar->tecnico ?? '') == 'Cristhian Reyes' ? 'selected' : '' }}>Cristhian Reyes</option>
                        <option value="Josue Lux" {{ ($mantenimientoEditar->tecnico ?? '') == 'Josue Lux' ? 'selected' : '' }}>Josue Lux</option>
                        <option value="Luis Dardon" {{ ($mantenimientoEditar->tecnico ?? '') == 'Luis Dardon' ? 'selected' : '' }}>Luis Dardon</option>
                    </select>
                </div>

                <!-- Número de Ticket -->
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 6px;">N° de Ticket</label>
                    <input type="text" name="no_ticket" placeholder="Ej. TCK-1024" value="{{ $mantenimientoEditar->no_ticket ?? '' }}" style="width: 100%; padding: 8px 12px; border-radius: 6px; border: 1px solid #d1d5db; font-size: 0.875rem;">
                </div>

            </div>

            <!-- Fila 4: Fotografía Antes y Después -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px; margin-bottom: 20px;">
                
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 6px;">Foto Antes del Mantenimiento</label>
                    <input type="file" name="foto_antes" accept="image/*" style="font-size: 0.875rem;">
                    @if(isset($mantenimientoEditar->foto_antes) && $mantenimientoEditar->foto_antes)
                        <div style="margin-top: 8px;">
                            <img src="{{ asset('storage/' . $mantenimientoEditar->foto_antes) }}" alt="Foto Antes" style="max-height: 80px; border-radius: 6px; border: 1px solid #e5e7eb;">
                        </div>
                    @endif
                </div>

                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 6px;">Foto Después del Mantenimiento</label>
                    <input type="file" name="foto_despues" accept="image/*" style="font-size: 0.875rem;">
                    @if(isset($mantenimientoEditar->foto_despues) && $mantenimientoEditar->foto_despues)
                        <div style="margin-top: 8px;">
                            <img src="{{ asset('storage/' . $mantenimientoEditar->foto_despues) }}" alt="Foto Después" style="max-height: 80px; border-radius: 6px; border: 1px solid #e5e7eb;">
                        </div>
                    @endif
                </div>

            </div>

            <!-- Fila 5: Descripción Ampliada -->
            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 6px;">
                    Descripción / Notas del Mantenimiento *
                </label>
                <textarea name="descripcion" 
                          rows="5" 
                          required 
                          style="width: 100%; padding: 12px; border-radius: 6px; border: 1px solid #d1d5db; font-size: 0.875rem; font-family: inherit; resize: vertical;" 
                          placeholder="Ingrese las observaciones, trabajos realizados o detalles del mantenimiento...">{{ $mantenimientoEditar->descripcion ?? '' }}</textarea>
            </div>

            <!-- Botón de Guardar -->
            <div>
                <button type="submit" 
                        style="background-color: #4f46e5; color: white; padding: 10px 24px; border: none; border-radius: 6px; font-weight: 600; font-size: 0.875rem; cursor: pointer;">
                    {{ isset($mantenimientoEditar) ? 'Actualizar Mantenimiento' : 'Guardar Mantenimiento' }}
                </button>
            </div>

            <!-- Mensaje de éxito de sesión -->
@if(session('success'))
    <div style="background-color: #d1fae5; border-left: 4px solid #10b981; color: #065f46; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-size: 0.875rem; font-weight: 500; display: flex; align-items: center; justify-content: space-between;">
        <div style="display: flex; align-items: center; gap: 8px;">
            <svg style="width: 20px; height: 20px; fill: currentColor;" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; color: #065f46; cursor: pointer; font-size: 1.125rem; font-weight: bold;">&times;</button>
    </div>
@endif

        </form>
    </div>
</div>

<!-- Script de Autollenado por Código Contable -->
<script>
const equiposDB = @json($equipos);

function buscarYAutollenarEquipo(valorEscrito) {
    const equipo = equiposDB.find(eq => eq.cod_contable && eq.cod_contable.toLowerCase() === valorEscrito.trim().toLowerCase());

    if (equipo) {
        document.getElementById('id_equipo_hidden').value = equipo.id_equipo;
        document.getElementById('input_nombre_equipo').value = equipo.nombre_equipo || 'Sin Nombre';
        document.getElementById('input_cod_ti').value = equipo.cod_ti || 'N/A';
        document.getElementById('input_tag').value = equipo.tag || 'N/A';
        document.getElementById('input_ec').value = equipo.ec || 'N/A';
        
        const cpu = equipo.cpu || '';
        const ram = equipo.ram || '';
        const disco = equipo.disco || '';
        document.getElementById('input_hardware').value = (cpu || ram || disco) ? `${cpu} / ${ram} / ${disco}` : 'N/A';
    } else {
        document.getElementById('id_equipo_hidden').value = '';
        document.getElementById('input_nombre_equipo').value = '';
        document.getElementById('input_cod_ti').value = '';
        document.getElementById('input_tag').value = '';
        document.getElementById('input_ec').value = '';
        document.getElementById('input_hardware').value = '';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const idEditar = document.getElementById('id_equipo_hidden').value;
    if (idEditar) {
        const equipoExistente = equiposDB.find(eq => eq.id_equipo == idEditar);
        if (equipoExistente) {
            document.getElementById('input_cod_contable_search').value = equipoExistente.cod_contable || '';
            buscarYAutollenarEquipo(equipoExistente.cod_contable || '');
        }
    }
});
</script>