<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Mantenimientos - Sistema de Activos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; } </style>
</head>
<body class="text-gray-800 antialiased">

    <div class="container mx-auto px-4 py-6 max-w-7xl">

        <!-- Encabezado -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">
                    Historial de Mantenimientos Realizados
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Consulta general de servicios, tickets y mantenimientos aplicados a los equipos de cómputo.
                </p>
            </div>
            <a href="{{ route('principal') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white font-medium text-sm px-4 py-2.5 rounded-lg shadow-sm transition-colors duration-150 inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Menú Principal
            </a>
        </div>

        <!-- Tabla -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <th scope="col" class="py-3.5 px-4">Cód. Contable</th>
                            <th scope="col" class="py-3.5 px-4">Equipo</th>
                            <th scope="col" class="py-3.5 px-4">Tipo Mantenimiento</th>
                            <th scope="col" class="py-3.5 px-4">Fecha Final</th>
                            <th scope="col" class="py-3.5 px-4">Técnico</th>
                            <th scope="col" class="py-3.5 px-4">N° Ticket</th>
                            <th scope="col" class="py-3.5 px-4">Descripción</th>
                            <th scope="col" class="py-3.5 px-4 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($mantenimientos as $mante)
                            <tr class="hover:bg-gray-50/80 transition-colors duration-150">
                                <td class="py-3.5 px-4 font-semibold text-gray-900 whitespace-nowrap">
                                    {{ $mante->cod_contable ?? 'N/A' }}
                                </td>

                                <td class="py-3.5 px-4 text-gray-700 font-medium whitespace-nowrap">
                                    {{ $mante->nombre_equipo ?? 'Equipo no asignado' }}
                                </td>

                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                                        {{ $mante->tipo_mante ?? 'General' }}
                                    </span>
                                </td>

                                <td class="py-3.5 px-4 text-gray-600 whitespace-nowrap">
                                    {{ $mante->fecha_final ? \Carbon\Carbon::parse($mante->fecha_final)->format('d/m/Y') : '-' }}
                                </td>

                                <td class="py-3.5 px-4 text-gray-800 font-medium whitespace-nowrap">
                                    {{ $mante->tecnico ?? 'No registrado' }}
                                </td>

                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    @if($mante->no_ticket)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-mono font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                            {{ $mante->no_ticket }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>

                                <td class="py-3.5 px-4 text-gray-600 max-w-xs leading-relaxed">
                                    {{ $mante->descripcion ?? 'Sin observaciones' }}
                                </td>

                                <!-- Botón PDF por fila -->
                                <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                    <a href="{{ route('mantenimiento.pdf', $mante->id_mante) }}" 
                                       target="_blank"
                                       title="Generar PDF"
                                       class="inline-flex items-center gap-1.5 bg-red-600 hover:bg-red-700 text-white font-medium text-xs px-3 py-1.5 rounded-lg transition-colors shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        PDF
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-12 px-4 text-center text-gray-500">
                                    No hay registros de mantenimientos almacenados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</body>
</html>