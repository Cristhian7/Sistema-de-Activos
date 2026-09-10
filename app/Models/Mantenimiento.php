<div class="container mx-auto px-4 py-6">

    <!-- Encabezado -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 style="font-size: 1.75rem; font-weight: 700; color: #111827; margin: 0;">
            Listado de Mantenimientos
        </h1>
        <a href="{{ route('principal') }}" 
           style="background-color: #4b5563; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 0.875rem; font-weight: 500; display: inline-flex; align-items: center;">
            ← Menú Principal
        </a>
    </div>

    <!-- Tabla de Registros -->
    <div style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 20px; border: 1px solid #e5e7eb; overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
            <thead>
                <tr style="background-color: #f9fafb; border-bottom: 2px solid #e5e7eb; color: #374151;">
                    <th style="padding: 12px;">Cód. Contable</th>
                    <th style="padding: 12px;">Equipo</th>
                    <th style="padding: 12px;">Tipo</th>
                    <th style="padding: 12px;">Fecha Inicio</th>
                    <th style="padding: 12px;">Fecha Final</th>
                    <th style="padding: 12px;">Técnico</th>
                    <th style="padding: 12px;">N° Ticket</th>
                    <th style="padding: 12px;">Descripción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mantenimientos as $mante)
                    <tr style="border-bottom: 1px solid #e5e7eb; color: #4b5563;">
                        <td style="padding: 12px; font-weight: 600; color: #111827;">{{ $mante->cod_contable ?? 'N/A' }}</td>
                        <td style="padding: 12px;">{{ $mante->nombre_equipo ?? 'N/A' }}</td>
                        <td style="padding: 12px;">
                            <span style="background-color: #e0e7ff; color: #3730a3; padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">
                                {{ $mante->tipo_mante ?? 'General' }}
                            </span>
                        </td>
                        <td style="padding: 12px;">{{ $mante->fecha_inicio ?? '-' }}</td>
                        <td style="padding: 12px;">{{ $mante->fecha_final ?? '-' }}</td>
                        <td style="padding: 12px; font-weight: 500;">{{ $mante->tecnico ?? 'Sin Asignar' }}</td>
                        <td style="padding: 12px;">{{ $mante->no_ticket ?? '-' }}</td>
                        <td style="padding: 12px; max-width: 250px;">{{ $mante->descripcion }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="padding: 20px; text-align: center; color: #6b7280;">
                            No se encontraron registros de mantenimientos.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>