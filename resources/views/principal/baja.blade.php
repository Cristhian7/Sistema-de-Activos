<div class="container mx-auto px-4 py-6">

    <!-- Encabezado Superior -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 style="font-size: 1.75rem; font-weight: 700; color: #111827; margin: 0;">
            Gestión de Bajas de Equipos
        </h1>
        <a href="{{ route('principal') }}" 
           style="background-color: #4b5563; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 0.875rem; font-weight: 500; display: inline-flex; align-items: center;">
            ← Menú Principal
        </a>
    </div>

    <!-- Tarjeta Principal Blanca -->
    <div style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); padding: 24px; border: 1px solid #e5e7eb;">
        
        <h2 style="font-size: 1.125rem; font-weight: 600; color: #1f2937; margin-bottom: 20px;">
            {{ isset($bajaEditar) ? 'Editar Baja' : 'Nueva Baja' }}
        </h2>

        <form action="{{ isset($bajaEditar) ? route('baja.update', $bajaEditar->id_baja) : route('baja.store') }}" 
              method="POST" 
              enctype="multipart/form-data">
            @csrf
            @if(isset($bajaEditar))
                @method('PUT')
            @endif

            <!-- Fila 1: Búsqueda Cód. Contable, Nombre Equipo y Motivo -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 16px;">
                
                <!-- Búsqueda filtrada de Código Contable (Nativo con Datalist) -->
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 6px;">Código Contable *</label>
                    <input type="text" 
                           id="input_cod_contable_search" 
                           list="lista_codigos_contables" 
                           placeholder="Buscar código..." 
                           autocomplete="off"
                           style="width: 100%; padding: 8px 12px; border-radius: 6px; border: 1px solid #d1d5db; font-size: 0.875rem;"
                           oninput="buscarYAutollenarEquipo(this.value)"
                           onchange="buscarYAutollenarEquipo(this.value)">

                    <datalist id="lista_codigos_contables">
                        @foreach($equipos->unique('cod_contable') as $eq)
                            @if(!empty($eq->cod_contable))
                                <option value="{{ $eq->cod_contable }}">
                            @endif
                        @endforeach
                    </datalist>

                    <input type="hidden" id="id_equipo_hidden" name="id_equipo" required value="{{ $bajaEditar->id_equipo ?? '' }}">
                </div>

                <!-- Nombre del Equipo (Autorellenado) -->
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 6px;">Equipo (Autorellenado)</label>
                    <input type="text" id="input_nombre_equipo" readonly style="width: 100%; padding: 8px 12px; border-radius: 6px; border: 1px solid #e5e7eb; background-color: #f9fafb; color: #374151; font-weight: 600; font-size: 0.875rem;" placeholder="Se rellenará automáticamente...">
                </div>

                <!-- Motivo de la Baja -->
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 6px;">Motivo de Baja *</label>
                    <select name="motivo" required style="width: 100%; padding: 8px 12px; border-radius: 6px; border: 1px solid #d1d5db; font-size: 0.875rem; background-color: #ffffff;">
                        <option value="">-- Seleccionar --</option>
                        <option value="Obsoleto" {{ ($bajaEditar->motivo ?? '') == 'Obsoleto' ? 'selected' : '' }}>Obsoleto</option>
                        <option value="Daño Irreparable" {{ ($bajaEditar->motivo ?? '') == 'Daño Irreparable' ? 'selected' : '' }}>Daño Irreparable</option>
                        <option value="Extravío" {{ ($bajaEditar->motivo ?? '') == 'Extravío' ? 'selected' : '' }}>Extravío</option>
                        <option value="Otro" {{ ($bajaEditar->motivo ?? '') == 'Otro' ? 'selected' : '' }}>Otro</option>
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

            <!-- Fila 3: Fecha de Baja y Responsable -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 16px;">
                
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 6px;">Fecha de Baja *</label>
                    <input type="date" name="fecha_baja" required value="{{ $bajaEditar->fecha_baja ?? date('Y-m-d') }}" style="width: 100%; padding: 8px 12px; border-radius: 6px; border: 1px solid #d1d5db; font-size: 0.875rem;">
                </div>

                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 6px;">Responsable / Técnico *</label>
                    <select name="responsable" required style="width: 100%; padding: 8px 12px; border-radius: 6px; border: 1px solid #d1d5db; font-size: 0.875rem; background-color: #ffffff;">
                        <option value="">-- Seleccionar --</option>
                        <option value="Cristhian Reyes" {{ ($bajaEditar->responsable ?? '') == 'Cristhian Reyes' ? 'selected' : '' }}>Cristhian Reyes</option>
                        <option value="Josue Lux" {{ ($bajaEditar->responsable ?? '') == 'Josue Lux' ? 'selected' : '' }}>Josue Lux</option>
                        <option value="Luis Dardon" {{ ($bajaEditar->responsable ?? '') == 'Luis Dardon' ? 'selected' : '' }}>Luis Dardon</option>
                    </select>
                </div>

            </div>

            <!-- Fila 4: Observaciones / Descripción -->
            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 6px;">
                    Observaciones de la Baja *
                </label>
                <textarea name="observaciones" 
                          rows="5" 
                          required 
                          style="width: 100%; padding: 12px; border-radius: 6px; border: 1px solid #d1d5db; font-size: 0.875rem; font-family: inherit; resize: vertical;" 
                          placeholder="Ingrese detalles adicionales del motivo de baja...">{{ $bajaEditar->observaciones ?? '' }}</textarea>
            </div>

            <!-- Botón de Guardar -->
            <div>
                <button type="submit" 
                        style="background-color: #dc2626; color: white; padding: 10px 24px; border: none; border-radius: 6px; font-weight: 600; font-size: 0.875rem; cursor: pointer;">
                    {{ isset($bajaEditar) ? 'Actualizar Baja' : 'Guardar Baja' }}
                </button>
            </div>

            <!-- Mensaje de éxito de sesión -->
            @if(session('success'))
                <div style="background-color: #d1fae5; border-left: 4px solid #10b981; color: #065f46; padding: 12px 16px; border-radius: 6px; margin-top: 20px; font-size: 0.875rem; font-weight: 500; display: flex; align-items: center; justify-content: space-between;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; color: #065f46; cursor: pointer; font-size: 1.125rem; font-weight: bold;">&times;</button>
                </div>
            @endif

        </form>
    </div>
</div>

<!-- Script corregido con múltiples propiedades de respaldo por si varían los nombres de columnas -->
<script>
const equiposDB = @json($equipos);
console.log("Equipos cargados en JS:", equiposDB); // Abre la consola (F12) para verificar que los datos lleguen aquí

function buscarYAutollenarEquipo(valorEscrito) {
    const valorLimpio = valorEscrito ? valorEscrito.trim().toLowerCase() : '';
    
    // Buscamos evaluando variantes comunes de nombres de columnas en la BD
    const equipo = equiposDB.find(eq => {
        const codigo = eq.cod_contable || eq.codigo_contable || eq.codigo || '';
        return codigo.toString().toLowerCase() === valorLimpio;
    });

    if (equipo) {
        document.getElementById('id_equipo_hidden').value = equipo.id_equipo || equipo.id || '';
        document.getElementById('input_nombre_equipo').value = equipo.nombre_equipo || equipo.nombre || equipo.descripcion || 'Sin Nombre';
        document.getElementById('input_cod_ti').value = equipo.cod_ti || equipo.codigo_ti || 'N/A';
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
        const equipoExistente = equiposDB.find(eq => (eq.id_equipo == idEditar || eq.id == idEditar));
        if (equipoExistente) {
            const codigoEncontrado = equipoExistente.cod_contable || equipoExistente.codigo_contable || equipoExistente.codigo || '';
            document.getElementById('input_cod_contable_search').value = codigoEncontrado;
            buscarYAutollenarEquipo(codigoEncontrado);
        }
    }
});
</script>