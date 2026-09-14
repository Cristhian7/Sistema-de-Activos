<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Mantenimiento - Ticket N° {{ $mantenimiento->no_ticket ?? $mantenimiento->id_mante }}</title>
    <style>
        @page {
            size: letter portrait;
            margin: 12mm 15mm;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #1f2937;
            line-height: 1.4;
        }
        .header {
            width: 100%;
            border-bottom: 2px solid #1e40af;
            padding-bottom: 8px;
            margin-bottom: 12px;
        }
        .header table {
            width: 100%;
        }
        .title {
            font-size: 15px;
            font-weight: bold;
            color: #1e40af;
            text-transform: uppercase;
        }
        .subtitle {
            font-size: 9.5px;
            color: #6b7280;
        }
        .ticket-box {
            text-align: right;
            font-size: 12px;
            font-weight: bold;
            color: #1e40af;
        }
        .section-header {
            background-color: #f3f4f6;
            color: #1f2937;
            font-weight: bold;
            font-size: 11px;
            padding: 5px 8px;
            border-left: 4px solid #1e40af;
            margin-top: 10px;
            margin-bottom: 6px;
            text-transform: uppercase;
        }
        table.table-data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        table.table-data td {
            padding: 4px 8px;
            border: 1px solid #e5e7eb;
            font-size: 10.5px;
        }
        .label {
            background-color: #f9fafb;
            font-weight: bold;
            color: #374151;
            width: 20%;
        }
        .value {
            width: 30%;
        }
        .text-box {
            border: 1px solid #e5e7eb;
            background-color: #fafafa;
            padding: 6px 10px;
            min-height: 35px;
            border-radius: 3px;
            margin-bottom: 8px;
            white-space: pre-line;
        }
        /* Estilos para las fotos antes y después */
        .table-photos {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            margin-bottom: 8px;
        }
        .table-photos td {
            width: 50%;
            text-align: center;
            border: 1px solid #e5e7eb;
            padding: 6px;
            background-color: #fafafa;
            vertical-align: top;
        }
        .photo-title {
            font-weight: bold;
            color: #374151;
            margin-bottom: 4px;
            font-size: 10.5px;
        }
        .maintenance-img {
            max-width: 100%;
            height: 200px; /* Altura fija para mantener el diseño ordenado */
            object-fit: contain;
            border: 1px solid #d1d5db;
            background-color: #ffffff;
            padding: 2px;
        }
        .signatures {
            width: 100%;
            margin-top: 25px;
        }
        .signatures td {
            width: 50%;
            text-align: center;
            vertical-align: bottom;
            height: 50px;
        }
        .line {
            border-top: 1px solid #4b5563;
            width: 70%;
            margin: 0 auto 4px auto;
        }
        .footer {
            position: fixed;
            bottom: -5mm;
            left: 0;
            right: 0;
            width: 100%;
            font-size: 9px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
            padding-top: 6px;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="header">
        <table>
            <tr>
                <td>
                    <div class="title">Reporte de Mantenimiento</div>
                    <div class="subtitle">Soporte Técnico e Infraestructura Tecnológica</div>
                </td>
                <td class="ticket-box">
                    Ticket N°: {{ $mantenimiento->no_ticket ?? $mantenimiento->id_mante }}
                </td>
            </tr>
        </table>
    </div>

    <div class="section-header">1. Información del Equipo</div>
    <table class="table-data">
        <tr>
            <td class="label">Cód. Contable:</td>
            <td class="value">{{ $mantenimiento->cod_contable ?? 'N/A' }}</td>
            <td class="label">Nombre Equipo:</td>
            <td class="value">{{ $mantenimiento->nombre_equipo ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Marca:</td>
            <td class="value">{{ $mantenimiento->marca ?? 'N/A' }}</td>
            <td class="label">Modelo:</td>
            <td class="value">{{ $mantenimiento->modelo ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Serie / TAG:</td>
            <td class="value">{{ $mantenimiento->serie ?? 'N/A' }}</td>
            <td class="label">Ubicación:</td>
            <td class="value">{{ $mantenimiento->ubicacion ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Estado:</td>
            <td colspan="3">{{ $mantenimiento->estado_nombre ?? 'N/A' }}</td>
        </tr>
    </table>

    <div class="section-header">2. Detalle del Mantenimiento</div>
    <table class="table-data">
        <tr>
            <td class="label">Tipo Mantenimiento:</td>
            <td class="value">{{ $mantenimiento->tipo_mante ?? 'N/A' }}</td>
            <td class="label">Técnico:</td>
            <td class="value">{{ $mantenimiento->tecnico ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Fecha Inicio:</td>
            <td class="value">{{ $mantenimiento->fecha_inicio ? date('d/m/Y', strtotime($mantenimiento->fecha_inicio)) : 'N/A' }}</td>
            <td class="label">Fecha Final:</td>
            <td class="value">{{ $mantenimiento->fecha_final ? date('d/m/Y', strtotime($mantenimiento->fecha_final)) : 'N/A' }}</td>
        </tr>
    </table>

    <div class="section-header">3. Descripción del Trabajo</div>
    <div class="text-box">
        {{ $mantenimiento->descripcion ?? 'Sin observaciones registradas.' }}
    </div>

    <!-- SECCIÓN DE EVIDENCIA FOTOGRÁFICA -->
    <div class="section-header">4. Evidencia Fotográfica</div>
    <table class="table-photos">
        <tr>
            <td>
                <div class="photo-title">Foto Antes</div>
                @if(!empty($mantenimiento->foto_antes))
                    @php
                        // Convierte los datos binarios BLOB directamente a Base64
                        $base64Antes = base64_encode($mantenimiento->foto_antes);
                    @endphp
                    <img src="data:image/jpeg;base64,{{ $base64Antes }}" class="maintenance-img">
                @else
                    <div style="color: #9ca3af; padding: 25px 0; font-size: 10px;">Sin imagen registrada</div>
                @endif
            </td>
            <td>
                <div class="photo-title">Foto Después</div>
                @if(!empty($mantenimiento->foto_despues))
                    @php
                        // Convierte los datos binarios BLOB directamente a Base64
                        $base64Despues = base64_encode($mantenimiento->foto_despues);
                    @endphp
                    <img src="data:image/jpeg;base64,{{ $base64Despues }}" class="maintenance-img">
                @else
                    <div style="color: #9ca3af; padding: 25px 0; font-size: 10px;">Sin imagen registrada</div>
                @endif
            </td>
        </tr>
    </table>

    <table class="signatures">
        <tr>
            <td>
                <!-- Si la firma del técnico está guardada en la BD (BLOB), se muestra aquí -->
                @if(!empty($mantenimiento->firma_tecnico))
                    @php
                        $base64Firma = base64_encode($mantenimiento->firma_tecnico);
                    @endphp
                    <img src="data:image/jpeg;base64,{{ $base64Firma }}" class="signature-img"><br>
                @else
                    <!-- Espacio en blanco si firmarán a mano -->
                    <div style="height: 35px;"></div>
                @endif
                
                <div class="line"></div>
                <strong>Técnico Responsable</strong><br>
                <span>{{ $mantenimiento->tecnico ?? 'Soporte Técnico' }}</span>
            </td>
            <td>
                <!-- Si tienes firma de aprobación o jefatura en la BD -->
                @if(!empty($mantenimiento->firma_jefatura))
                    @php
                        $base64Jefatura = base64_encode($mantenimiento->firma_jefatura);
                    @endphp
                    <img src="data:image/jpeg;base64,{{ $base64Jefatura }}" class="signature-img"><br>
                @else
                    <!-- Espacio en blanco si firmarán y sellarán a mano -->
                    <div style="height: 35px;"></div>
                @endif

                <div class="line"></div>
                <strong>Aprobación / Jefatura</strong><br>
                <span>Firma y Sello</span>
            </td>
        </tr>
    </table>

</body>
</html>