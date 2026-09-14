<div class="container mx-auto px-4 py-6">

    <!-- Encabezado -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 style="font-size: 1.75rem; font-weight: 700; color: #111827; margin: 0;">
            Listado de Bajas de Equipos
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
                    <th style="padding: 12px;">Equipo / Solicitud</th>
                    <th style="padding: 12px;">Años de Uso</th>
                    <th style="padding: 12px;">Fecha</th>
                    <th style="padding: 12px;">Estado</th>
                    <th style="padding: 12px;">Técnico</th>
                    <th style="padding: 12px;">Descripción</th>
                    <th style="padding: 12px;">Foto</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bajas as $baja)
                    <tr style="border-bottom: 1px solid #e5e7eb; color: #4b5563;">
                        <td style="padding: 12px; font-weight: 600; color: #111827;">{{ $baja->equipo_solicitar ?? 'N/A' }}</td>
                        <td style="padding: 12px;">{{ $baja->años_uso ?? '-' }} años</td>
                        <td style="padding: 12px;">{{ $baja->fecha ?? '-' }}</td>
                        <td style="padding: 12px;">
                            <span style="background-color: #fee2e2; color: #991b1b; padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">
                                {{ $baja->estado ?? 'Pendiente' }}
                            </span>
                        </td>
                        <td style="padding: 12px; font-weight: 500;">{{ $baja->tecnico ?? 'Sin Asignar' }}</td>
                        <td style="padding: 12px; max-width: 250px;">{{ $baja->descripcion ?? '-' }}</td>
                        <td style="padding: 12px;">
                            @if(!empty($baja->foto))
                                <span style="color: #2563eb; font-weight: 500;">Disponible</span>
                            @else
                                <span style="color: #6b7280;">Sin foto</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="padding: 20px; text-align: center; color: #6b7280;">
                            No se encontraron registros de bajas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>