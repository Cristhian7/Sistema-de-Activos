<div style="max-width: 1200px; margin: 0 auto; padding: 20px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    
    <!-- Header y Botón Regresar -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h2 style="margin: 0; font-size: 1.75rem; color: #0f172a; font-weight: 700;">Inventario de Equipos</h2>
            <p style="margin: 4px 0 0 0; color: #64748b; font-size: 0.9rem;">Listado general de activos asignados e infraestructura</p>
        </div>
        
        <a href="{{ route('principal') }}" 
            style="display: inline-flex; align-items: center; justify-content: center; background-color: #64748b; color: #ffffff; text-decoration: none; padding: 10px 22px; border-radius: 12px; font-weight: 600; font-size: 0.95rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: background-color 0.2s ease;">
            ← Menú Principal
        </a>
    </div>

    <!-- Tarjeta Principal de la Tabla -->
    <div style="background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); overflow: hidden;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
                <thead>
                    <tr style="background-color: #eff6ff; color: #1d4ed8; padding: 4px 8px; border-radius: 6px; font-weight: 600; font-size: 0.8rem; border: 1px solid #bfdbfe;">
                        <th style="padding: 14px 16px; font-weight: 600;">Cód. TI</th>
                        <th style="padding: 14px 16px; font-weight: 600;">Cód. Contable</th>
                        <th style="padding: 14px 16px; font-weight: 600;">Nombre del Equipo</th>
                        <th style="padding: 14px 16px; font-weight: 600;">Tipo Equipo</th>
                        <th style="padding: 14px 16px; font-weight: 600;">Marca</th>
                        <th style="padding: 14px 16px; font-weight: 600;">Modelo</th>
                        <th style="padding: 14px 16px; font-weight: 600;">Usuario</th>
                        <th style="padding: 14px 16px; font-weight: 600;">Afiliado</th>
                    </tr>
                </thead>
                <tbody style="color: #334155;">
                    @forelse ($equipos as $item)
                        <tr class="table-row" style="border-bottom: 1px solid #f1f5f9; transition: background-color 0.15s ease;">
                            <td style="padding: 14px 16px;">
                                <span style="background-color: #eff6ff; color: #1d4ed8; padding: 4px 8px; border-radius: 6px; font-weight: 600; font-size: 0.8rem; border: 1px solid #bfdbfe;">
                                    {{ $item->cod_ti ?? 'N/A' }}
                                </span>
                            </td>
                            <td style="padding: 14px 16px;">
                                <span style="background-color: #f8fafc; color: #1d4ed8; padding: 4px 8px; border-radius: 6px; font-weight: 500; font-size: 0.8rem; border: 1px solid #e2e8f0;">
                                    {{ $item->cod_contable ?? 'N/A' }}
                                </span>
                            </td>
                            <td style="padding: 14px 16px; font-weight: 600; color: #0f172a;">
                                {{ $item->nombre_equipo }}
                            </td>
                            {{-- Campo Agregado --}}
                            <td style="padding: 14px 16px;">
                                {{ $item->tipo_equipo ?? 'N/A' }}
                            </td>
                            <td style="padding: 14px 16px;">
                                {{ $item->marca ?? 'N/A' }}
                            </td>
                            <td style="padding: 14px 16px;">
                                {{ $item->modelo ?? 'N/A' }}
                            </td>
                            <td style="padding: 14px 16px; color: #475569;">
                                <div style="display: flex; align-items: center; gap: 6px;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    {{ $item->usuario ?? 'Sin Asignar' }}
                                </div>
                            </td>
                            <td style="padding: 14px 16px;">
                                <span style="background-color: #f0fdf4; color: #15803d; padding: 4px 10px; border-radius: 12px; font-weight: 500; font-size: 0.8rem; display: inline-block;">
                                    {{ $item->afiliado ?? 'N/A' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="padding: 40px; text-align: center; color: #94a3b8;">
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                                    <span style="font-size: 1rem; font-weight: 500;">No hay equipos registrados en el inventario</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .table-row:hover {
        background-color: #f8fafc !important;
    }
</style>