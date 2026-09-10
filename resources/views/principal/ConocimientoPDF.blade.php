<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Técnico - Ticket N° {{ $mantenimiento->no_ticket ?? $mantenimiento->id_mante }}</title>
    <style>
        @page {
            size: letter portrait; /* Define tamaño carta (8.5in x 11in) vertical */
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
            margin-bottom: 15px;
        }
        .header table {
            width: 100%;
        }
        .title {
            font-size: 16px;
            font-weight: bold;
            color: #1e40af;
            text-transform: uppercase;
        }
        .subtitle {
            font-size: 10px;
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
            margin-top: 12px;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        table.table-data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
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
            margin-bottom: 10px;
            white-space: pre-line;
        }
        .photos-table {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
        }
        .photos-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 5px;
        }
        .photo-card {
            border: 1px solid #d1d5db;
            padding: 6px;
            border-radius: 4px;
            background-color: #ffffff;
        }
        .photo-card img {
            max-width: 100%;
            max-height: 170px;
            object-fit: contain;
            border-radius: 2px;
        }
        .photo-label {
            font-weight: bold;
            font-size: 10.5px;
            margin-bottom: 6px;
            color: #374151;
        }
        .no-photo {
            color: #9ca3af;
            font-style: italic;
            padding: 30px 0;
        }
        .signatures {
            width: 100%;
            margin-top: 35px;
        }
        .signatures td {
            width: 50%;
            text-align: center;
            vertical-align: bottom;
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

    <!-- Encabezado -->
    <div class="header">
        <table>
            <tr>
                <td>
                    <div class="title">Dictamen Técnico de Mantenimiento</div>
                    <div class="subtitle">Soporte Técnico e Infraestructura Tecnológica</div>
                </td>
                <td class="ticket-box">
                    Ticket N°: {{ $mantenimiento->no_ticket ?? $mantenimiento->id_mante }}
                </td>
            </tr>
        </table>
    </div>

    <!-- Sección 1: Datos del Equipo -->
    <div class="section-header">1. Información del Equipo</div>
    <table class="table-data">
        <tr>
            <td class="label">Cód. Equipo:</td>
            <td class="value">
                {{ $mantenimiento->cod_contable ?? 'N/A' }}
            </td>
            <td class="label">Nombre Equipo:</td>
            <td class="value">
                {{ $mantenimiento->nombre_equipo ?? $mantenimiento->equipo ?? 'N/A' }}
            </td>
        </tr>
        <tr>
            <td class="label">Marca:</td>
            <td class="value">
                {{ $mantenimiento->nombre_marca ?? $mantenimiento->marca ?? 'N/A' }}
            </td>
            <td class="label">Modelo:</td>
            <td class="value">
                {{ $mantenimiento->nombre_modelo ?? $mantenimiento->modelo ?? 'N/A' }}
            </td>
        </tr>
        <tr>
            <td class="label">TAG / Serie:</td>
            <td class="value">
                {{ $mantenimiento->serie ?? $mantenimiento->tag ?? $mantenimiento->service_tag ?? 'N/A' }}
            </td>
            <td class="label">Afiliado / Sede:</td>
            <td class="value">
                {{ $mantenimiento->ubicacion ?? $mantenimiento->afiliado_nombre ?? $mantenimiento->afiliado ?? 'N/A' }}
            </td>
        </tr>
    </table>

    <!-- Sección 2: Registro del Mantenimiento -->
    <div class="section-header">2. Detalle del Mantenimiento</div>
    <table class="table-data">
        <tr>
            <td class="label">Tipo Mantenimiento:</td>
            <td class="value">{{ $mantenimiento->tipo_mante ?? $mantenimiento->tipo_mantenimiento ?? 'N/A' }}</td>
            <td class="label">Técnico Responsable:</td>
            <td class="value">{{ $mantenimiento->tecnico ?? $mantenimiento->usuario_registro ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Fecha Inicio:</td>
            <td class="value">
                {{ $mantenimiento->fecha_inicio ? date('d/m/Y', strtotime($mantenimiento->fecha_inicio)) : 'N/A' }}
            </td>
            <td class="label">Fecha Final:</td>
            <td class="value">
                {{ $mantenimiento->fecha_final ? date('d/m/Y', strtotime($mantenimiento->fecha_final)) : 'N/A' }}
            </td>
        </tr>
    </table>

    <!-- Sección 3: Descripción del Trabajo -->
    <div class="section-header">3. Descripción del Trabajo Realizado</div>
    <div class="text-box">
        {{ $mantenimiento->descripcion ?? $mantenimiento->diagnostico ?? 'Sin descripción registrada.' }}
    </div>

    <!-- Sección 4: Fotografías -->
    @if($fotoAntesBase64 || $fotoDespuesBase64)
        <div class="section-header">4. Evidencia Fotográfica</div>
        <table class="photos-table">
            <tr>
                <td>
                    <div class="photo-card">
                        <div class="photo-label">ANTES</div>
                        @if($fotoAntesBase64)
                            <img src="{{ $fotoAntesBase64 }}" alt="Foto Antes">
                        @else
                            <div class="no-photo">Sin foto previa</div>
                        @endif
                    </div>
                </td>
                <td>
                    <div class="photo-card">
                        <div class="photo-label">DESPUÉS</div>
                        @if($fotoDespuesBase64)
                            <img src="{{ $fotoDespuesBase64 }}" alt="Foto Después">
                        @else
                            <div class="no-photo">Sin foto posterior</div>
                        @endif
                    </div>
                </td>
            </tr>
        </table>
    @endif

    <!-- Firmas -->
    <table class="signatures">
        <tr>
            <td>
                <div class="line"></div>
                <strong>{{ $mantenimiento->tecnico ?? 'Técnico Responsable' }}</strong><br>
                <span>Soporte Técnico</span>
            </td>
            <td>
                <div class="line"></div>
                <strong>Conformidad del Usuario</strong><br>
                <span>Nombre y Firma</span>
            </td>
        </tr>
    </table>

    <!-- Pie de página fijo -->
    <div class="footer">
        Documento de control interno generado el {{ date('d/m/Y H:i') }}.
    </div>

</body>
</html>