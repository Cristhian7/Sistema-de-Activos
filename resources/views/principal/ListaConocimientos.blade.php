<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Mantenimientos - Sistema de Activos</title>
    <!-- Tailwind CSS (CDN para asegurar consistencia de estilos) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
    </style>
</head>
<body class="text-gray-800 antialiased">

    <div class="container mx-auto px-4 py-6 max-w-7xl">

        <!-- Encabezado Principal -->
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

        <!-- Alerta de mensaje de éxito de sesión (Opcional) -->
        @if(session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-md mb-6 shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900 font-bold text-lg leading-none">&times;</button>
            </div>
        @endif

        <!-- Tarjeta Contenedora de la Tabla -->
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
                            <th scope="col" class="py-3.5 px-4">Descripción del Trabajo</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($mantenimientos as $mante)
                            <tr class="hover:bg-gray-50/80 transition-colors duration-150">
                                <!-- Código Contable -->
                                <td class="py-3.5 px-4 font-semibold text-gray-900 whitespace-nowrap">
                                    {{ $mante->cod_contable ?? 'N/A' }}
                                </td>

                                <!-- Nombre del Equipo -->
                                <td class="py-3.5 px-4 text-gray-700 font-medium whitespace-nowrap">
                                    {{ $mante->nombre_equipo ?? 'Equipo no asignado' }}
                                </td>

                                <!-- Tipo de Mantenimiento -->
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                                        {{ $mante->tipo_mante ?? 'General' }}
                                    </span>
                                </td>

                                <!-- Fecha Final -->
                                <td class="py-3.5 px-4 text-gray-600 whitespace-nowrap">
                                    {{ $mante->fecha_final ? \Carbon\Carbon::parse($mante->fecha_final)->format('d/m/Y') : '-' }}
                                </td>

                                <!-- Técnico Asignado -->
                                <td class="py-3.5 px-4 text-gray-800 font-medium whitespace-nowrap">
                                    {{ $mante->tecnico ?? 'No registrado' }}
                                </td>

                                <!-- N° Ticket Jira / Incidencia -->
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    @if($mante->no_ticket)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-mono font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                            {{ $mante->no_ticket }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>

                                <!-- Descripción -->
                                <td class="py-3.5 px-4 text-gray-600 max-w-xs leading-relaxed">
                                    {{ $mante->descripcion ?? 'Sin observaciones detalladas' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 px-4 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-500">
                                        <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <p class="text-base font-medium text-gray-600">No hay registros de mantenimientos almacenados.</p>
                                        <p class="text-sm text-gray-400 mt-1">Los registros guardados aparecerán listados automáticamente en esta sección.</p>
                                    </div>
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