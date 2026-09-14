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
            {{ isset($bajaEditar) ? 'Editar Baja de Equipo' : 'Nueva Baja de Equipo' }}
        </h2>

        <form action="{{ isset($bajaEditar) ? route('baja.update', $bajaEditar->id_baja) : route('baja.store') }}" 
              method="POST" 
              enctype="multipart/form-data">
            @csrf
            @if(isset($bajaEditar))
                @method('PUT')
            @endif

            <!-- Fila 1: Búsqueda Cód. Contable, Nombre Equipo y Equipo a Solicitar -->
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

                    <input type="hidden" id="id_equipo_hidden" name="id_equipo" required value="{{ $bajaEditar->id_equipo ?? '' }}">
                </div>

                <!-- Nombre del Equipo (Autorellenado) -->
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 6px;">Equipo (Autorellenado)</label>
                    <input type="text" id="input_nombre_equipo" readonly style="width: 100%; padding: 8px 12px; border-radius: 6px; border: 1px solid #e5e7eb; background-color: #f9fafb; color: #374151; font-weight: 600; font-size: 0.875rem;" placeholder="Se rellenará automáticamente...">
                </div>

                <!-- Reemplaza el bloque de "Equipo a Solicitar" por este select con las opciones fijas -->
                 <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 6px;">Equipo a Solicitar / Aplica *</label>
                    <select name="equipo_solicitar" required style="width: 100%; padding: 8px 12px; border-radius: 6px; border: 1px solid #d1d5db; font-size: 0.875rem; background-color: #ffffff;">
                        <option value="">-- Seleccionar --</option>
                        <option value="Aplica" {{ (isset($bajaEditar) && $bajaEditar->equipo_solicitar == 'Aplica') ? 'selected' : '' }}>Aplica</option>
                        <option value="No aplica" {{ (isset($bajaEditar) && $bajaEditar->equipo_solicitar == 'No aplica') ? 'selected' : '' }}>No aplica</option>
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

            <!-- Fila 3: Fecha, Años de Uso (Autocalculado), Estado y Técnico Asignado -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 16px;">
                
                <!-- Fecha -->
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 6px;">Fecha *</label>
                    <input type="date" name="fecha" required value="{{ $bajaEditar->fecha ?? date('Y-m-d') }}" style="width: 100%; padding: 8px 12px; border-radius: 6px; border: 1px solid #d1d5db; font-size: 0.875rem;">
                </div>

                <!-- Años de Uso (Autocalculado) -->
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 6px;">Años de Uso</label>
                    <input type="number" name="años_uso" placeholder="Automático" value="{{ $bajaEditar->años_uso ?? '' }}" style="width: 100%; padding: 8px 12px; border-radius: 6px; border: 1px solid #d1d5db; font-size: 0.875rem;">
                </div>

                <!-- Reemplaza el bloque de "Estado" en tu vista con este código -->
                 <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 6px;">Estado</label>
                    <select name="estado" style="width: 100%; padding: 8px 12px; border-radius: 6px; border: 1px solid #d1d5db; font-size: 0.875rem; background-color: #ffffff;">
                        <option value="">-- Seleccionar --</option>
                        <option value="Inservible" {{ (isset($bajaEditar) && $bajaEditar->estado == 'Inservible') ? 'selected' : '' }}>Inservible</option>
                        <option value="Obsoleto" {{ (isset($bajaEditar) && $bajaEditar->estado == 'Obsoleto') ? 'selected' : '' }}>Obsoleto</option>
                    </select>
                </div>

                <!-- Reemplaza el bloque de "Técnico Asignado" en tu vista con este código -->
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 6px;">Técnico Asignado *</label>
                    <select name="tecnico" required style="width: 100%; padding: 8px 12px; border-radius: 6px; border: 1px solid #d1d5db; font-size: 0.875rem; background-color: #ffffff;">
                        <option value="">-- Seleccionar --</option>
                        <option value="Cristhian Reyes" {{ (isset($bajaEditar) && $bajaEditar->tecnico == 'Cristhian Reyes') ? 'selected' : '' }}>Cristhian Reyes</option>
                        <option value="Josué Lux" {{ (isset($bajaEditar) && $bajaEditar->tecnico == 'Josué Lux') ? 'selected' : '' }}>Josué Lux</option>
                        <option value="Luis Dardon" {{ (isset($bajaEditar) && $bajaEditar->tecnico == 'Luis Dardon') ? 'selected' : '' }}>Luis Dardon</option>
                    </select>
                </div>

            </div>

            <!-- Fila 4: Fotografía -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 6px;">Fotografía del Equipo</label>
                    <input type="file" name="foto" accept="image/*" style="font-size: 0.875rem;">
                    @if(isset($bajaEditar->foto) && $bajaEditar->foto)
                        <div style="margin-top: 8px;">
                            <img src="{{ asset('storage/' . $bajaEditar->foto) }}" alt="Foto Baja" style="max-height: 80px; border-radius: 6px; border: 1px solid #e5e7eb;">
                        </div>
                    @endif
                </div>
            </div>

            <!-- Fila 5: Descripción Ampliada -->
            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 6px;">
                    Descripción / Notas de la Baja *
                </label>
                <textarea name="descripcion" 
                          rows="5" 
                          required 
                          style="width: 100%; padding: 12px; border-radius: 6px; border: 1px solid #d1d5db; font-size: 0.875rem; font-family: inherit; resize: vertical;" 
                          placeholder="Ingrese las observaciones, motivos de la baja o detalles del equipo...">{{ $bajaEditar->descripcion ?? '' }}</textarea>
            </div>

            <!-- Botón de Guardar -->
            <div>
                <button type="submit" 
                        style="background-color: #4f46e5; color: white; padding: 10px 24px; border: none; border-radius: 6px; font-weight: 600; font-size: 0.875rem; cursor: pointer;">
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

<!-- Script de Autollenado y Cálculo de Años de Uso -->
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

        // Cálculo de Años de Uso contra la fecha actual
        if (equipo.fecha_compra) {
            const fechaCompra = new Date(equipo.fecha_compra);
            const fechaActual = new Date();
            
            let diferenciaAnios = fechaActual.getFullYear() - fechaCompra.getFullYear();
            const m = fechaActual.getMonth() - fechaCompra.getMonth();
            
            if (m < 0 || (m === 0 && fechaActual.getDate() < fechaCompra.getDate())) {
                diferenciaAnios--;
            }

            document.querySelector('input[name="años_uso"]').value = diferenciaAnios >= 0 ? diferenciaAnios : 0;
        } else {
            document.querySelector('input[name="años_uso"]').value = '';
        }

    } else {
        document.getElementById('id_equipo_hidden').value = '';
        document.getElementById('input_nombre_equipo').value = '';
        document.getElementById('input_cod_ti').value = '';
        document.getElementById('input_tag').value = '';
        document.getElementById('input_ec').value = '';
        document.getElementById('input_hardware').value = '';
        document.querySelector('input[name="años_uso"]').value = '';
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