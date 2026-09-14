<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dictamen Técnico de Baja - N° {{ $baja->id_baja ?? $baja->id }}</title>
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
            border-bottom: 2px solid #991b1b; /* Línea roja oscura institucional */
            padding-bottom: 8px;
            margin-bottom: 12px;
        }
        .header table {
            width: 100%;
        }
        .title {
            font-size: 15px;
            font-weight: bold;
            color: #991b1b;
            text-transform: uppercase;
        }
        .subtitle {
            font-size: 9.5px;
            color: #6b7280;
        }
        .ticket-box {
            text-align: right;
            font-size: 11px;
            font-weight: bold;
            color: #4b5563;
        }
        .section-header {
            background-color: #f3f4f6;
            color: #1f2937;
            font-weight: bold;
            font-size: 11px;
            padding: 5px 8px;
            border-left: 4px solid #991b1b; /* Detalle rojo institucional */
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
            padding: 5px 8px;
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
            padding: 8px 10px;
            min-height: 45px;
            border-radius: 3px;
            margin-bottom: 8px;
            white-space: pre-line;
        }
        .signatures {
            width: 100%;
            margin-top: 30px;
        }
        .signatures td {
            width: 50%;
            text-align: center;
            vertical-align: bottom;
            height: 60px;
        }
        .signature-img {
            max-height: 45px;
            width: auto;
            object-fit: contain;
            margin-bottom: 2px;
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
                    <div class="title">Dictamen Técnico de Baja de Activo</div>
                    <div class="subtitle">Soporte Técnico e Infraestructura Tecnológica</div>
                </td>
                <td class="ticket-box">
                    N° Baja: {{ $baja->id_baja ?? $baja->id }}<br>
                    <span style="font-size: 10px; font-weight: normal; color: #6b7280;">Ticket: {{ $baja->no_ticket ?? $baja->ticket ?? 'N/A' }}</span>
                </td>
            </tr>
        </table>
    </div>

    <!-- SECCIÓN 1: INFORMACIÓN GENERAL DEL EQUIPO -->
    <div class="section-header">1. Información General del Equipo</div>
    <table class="table-data">
        <tr>
            <td class="label">Cód. Contable:</td>
            <td class="value" style="font-weight: bold; color: #1e3a8a;">{{ $baja->cod_contable ?? 'N/A' }}</td>
            <td class="label">Nombre Equipo:</td>
            <td class="value">{{ $baja->nombre_equipo ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Marca / Modelo:</td>
            <td class="value">
                {{ trim(($baja->nombre_marca ?? '') . ' ' . ($baja->nombre_modelo ?? '')) ?: 'N/A' }}
            </td>
            <td class="label">N° Serie / TAG:</td>
            <td class="value">{{ $baja->tag ?? $baja->ec ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Ubicación:</td>
            <td class="value" colspan="3">{{ $baja->afiliado ?? $baja->ubicacion ?? 'N/A' }}</td>
        </tr>
    </table>

    <!-- SECCIÓN 2: ESPECIFICACIONES TÉCNICAS DEL EQUIPO -->
    <div class="section-header">2. Especificaciones Técnicas del Equipo</div>
    <table class="table-data">
        <tr>
            <td class="label">Procesador (CPU):</td>
            <td class="value">{{ $baja->cpu ?? 'N/A' }}</td>
            <td class="label">Memoria RAM:</td>
            <td class="value">{{ $baja->ram ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Almacenamiento:</td>
            <td class="value">{{ $baja->disco ?? 'N/A' }}</td>
            <td class="label"></td>
            <td> </td>
        </tr>
    </table>>

    <!-- SECCIÓN 3: DETALLE Y REGISTRO DE LA BAJA -->
    <div class="section-header">3. Detalle y Registro de la Baja</div>
    <table class="table-data">
        <tr>
            <td class="label">Motivo de Baja:</td>
            <td class="value" style="font-weight: bold; color: #991b1b;">{{ $baja->motivo_baja ?? $baja->estado ?? 'Obsolescencia / Daño Irreparable' }}</td>
            <td class="label">Fecha de Procesamiento:</td>
            <td class="value">
                @php
                    $fechaOriginal = $baja->fecha_baja ?? $baja->created_at ?? now();
                @endphp
                {{ \Carbon\Carbon::parse($fechaOriginal)->format('d/m/Y') }}
            </td>
        </tr>
        <tr>
            <td class="label">Técnico Dictaminante:</td>
            <td colspan="3">{{ $baja->tecnico ?? $baja->tecnico_responsable ?? 'Cristhian Reyes' }}</td>
        </tr>
    </table>

    <!-- SECCIÓN 4: JUSTIFICACIÓN TÉCNICA Y OBSERVACIONES -->
    <div class="section-header">4. Justificación Técnica y Observaciones</div>
    <div class="text-box">
        {{ $baja->justificacion ?? $baja->descripcion ?? 'Sin observaciones adicionales registradas.' }}
    </div>

<!-- SECCIÓN DE EVIDENCIA FOTOGRÁFICA -->
    <div class="section-header">Evidencia Fotográfica del Equipo</div>
    <table class="table-photos">
        <tr>
            <td style="text-align: center; vertical-align: middle; background-color: #fafafa; border: 1px solid #e5e7eb; padding: 10px; height: 210px;">
                @if(!empty($baja->foto_base64))
                    <img src="{{ $baja->foto_base64 }}" style="display: block; margin: 0 auto; max-width: 100%; max-height: 200px; object-fit: contain; border: 1px solid #d1d5db; background-color: #ffffff; padding: 2px;">
                @else
                    <div style="color: #9ca3af; padding: 25px 0; font-size: 10px;">Sin imagen registrada</div>
                @endif
            </td>
        </tr>
    </table>

    <!-- SECCIÓN DE FIRMAS -->
    <table class="signatures" style="width: 100%; margin-top: 35px; border-collapse: collapse;">
        <tr>
            <td style="width: 50%; text-align: center; vertical-align: bottom; padding: 0 20px;">
                <!-- Espacio o imagen para la firma del técnico -->
                <div style="height: 40px;"></div>
                
                <div style="border-top: 1px solid #4b5563; width: 80%; margin: 0 auto 4px auto;"></div>
                <strong style="font-size: 11px; color: #1f2937;">Técnico Responsable</strong><br>
                <span style="font-size: 10px; color: #4b5563;">{{ $baja->tecnico ?? 'Soporte Técnico' }}</span>
            </td>
            <td style="width: 50%; text-align: center; vertical-align: bottom; padding: 0 20px;">
                <!-- Espacio para firma de aprobación o jefatura -->
                <div style="height: 40px;"></div>

                <div style="border-top: 1px solid #4b5563; width: 80%; margin: 0 auto 4px auto;"></div>
                <strong style="font-size: 11px; color: #1f2937;">Aprobación / Jefatura</strong><br>
                <span style="font-size: 10px; color: #4b5563;">Firma y Sello</span>
            </td>
        </tr>
    </table>

</body>
</html>