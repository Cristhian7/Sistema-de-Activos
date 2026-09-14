<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dictamen Técnico de Baja - Cód. {{ is_object($baja->cod_contable ?? null) ? ($baja->cod_contable->cod_contable ?? 'N/A') : ($baja->cod_contable ?? $baja->equipo->cod_contable ?? $baja->id_baja) }}</title>
    <style>
        @page {
            size: letter portrait; /* Tamaño carta (8.5in x 11in) vertical */
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
            border-bottom: 2px solid #b91c1c; /* Color rojo de Baja */
            padding-bottom: 8px;
            margin-bottom: 15px;
        }
        .header table {
            width: 100%;
        }
        .title {
            font-size: 16px;
            font-weight: bold;
            color: #b91c1c;
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
            color: #b91c1c;
        }
        .section-header {
            background-color: #f3f4f6;
            color: #1f2937;
            font-weight: bold;
            font-size: 11px;
            padding: 5px 8px;
            border-left: 4px solid #b91c1c;
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
            min-height: 55px;
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
                    <div class="title">Dictamen Técnico de Baja de Activo</div>
                    <div class="subtitle">Soporte Técnico e Infraestructura Tecnológica</div>
                </td>
                <td class="ticket-box">
                    N° Baja: {{ $baja->id_baja ?? 'N/A' }}<br>
                    <span style="font-size: 10px; font-weight: normal; color: #4b5563;">
                        Ticket: {{ $baja->no_ticket ?? $baja->ticket ?? 'N/A' }}
                    </span>
                </td>
            </tr>
        </table>
    </div>

    <!-- Sección 1: Información del Equipo / Activo -->
    <div class="section-header">1. Información General del Equipo</div>
    <table class="table-data">
        <tr>
            <td class="label">Cód. Contable:</td>
            <td class="value">
                <strong>{{ $baja->cod_contable ?? $baja->equipo->cod_contable ?? 'N/A' }}</strong>
            </td>
            <td class="label">Nombre Equipo:</td>
            <td class="value">
                {{ $baja->nombre_equipo ?? $baja->equipo->nombre_equipo ?? 'N/A' }}
            </td>
        </tr>
        <tr>
            <td class="label">Marca / Modelo:</td>
            <td class="value">
                @php
                    // Obtener objeto de modelo (admite relación Eloquent, array o string)
                    $modeloObj = $baja->equipo->modelo ?? $baja->modelo ?? null;
                    
                    // Extraer nombre del modelo
                    $nombreModelo = 'N/A';
                    if (is_object($modeloObj)) {
                        $nombreModelo = $modeloObj->modelo ?? $modeloObj->nombre ?? 'N/A';
                    } elseif (is_array($modeloObj)) {
                        $nombreModelo = $modeloObj['modelo'] ?? $modeloObj['nombre'] ?? 'N/A';
                    } elseif (is_string($modeloObj)) {
                        $nombreModelo = $modeloObj;
                    }

                    // Obtener objeto de marca
                    $marcaObj = $baja->equipo->marca ?? $baja->marca ?? ($modeloObj->marca ?? null);
                    
                    // Extraer nombre de la marca
                    $nombreMarca = 'N/A';
                    if (is_object($marcaObj)) {
                        $nombreMarca = $marcaObj->marca ?? $marcaObj->nombre ?? 'N/A';
                    } elseif (is_array($marcaObj)) {
                        $nombreMarca = $marcaObj['marca'] ?? $marcaObj['nombre'] ?? 'N/A';
                    } elseif (is_string($marcaObj)) {
                        $nombreMarca = $marcaObj;
                    }
                @endphp

                {{ $nombreMarca }} / {{ $nombreModelo }}
            </td>
            <td class="label">N° Serie / TAG:</td>
            <td class="value">
                {{ $baja->equipo->serie ?? $baja->serie ?? $baja->equipo->tag ?? 'N/A' }}
            </td>
        </tr>
        <tr>
            <td class="label">Ubicación / Afiliado:</td>
            <td class="value">
                @php
                    // Evaluar la ubicación o afiliado desde diferentes posibles relaciones o columnas
                    $afiliadoObj = $baja->equipo->afiliado 
                        ?? $baja->equipo->ubicacion 
                        ?? $baja->afiliado 
                        ?? $baja->ubicacion 
                        ?? null;

                    $nombreAfiliado = 'N/A';

                    if (is_object($afiliadoObj)) {
                        $nombreAfiliado = $afiliadoObj->nombre_afiliado 
                            ?? $afiliadoObj->afiliado 
                            ?? $afiliadoObj->nombre 
                            ?? $afiliadoObj->ubicacion 
                            ?? 'N/A';
                    } elseif (is_array($afiliadoObj)) {
                        $nombreAfiliado = $afiliadoObj['nombre_afiliado'] 
                            ?? $afiliadoObj['afiliado'] 
                            ?? $afiliadoObj['nombre'] 
                            ?? $afiliadoObj['ubicacion'] 
                            ?? 'N/A';
                    } elseif (is_string($afiliadoObj) && !empty($afiliadoObj)) {
                        $nombreAfiliado = $afiliadoObj;
                    }
                @endphp

                {{ $nombreAfiliado }}
            </td>
            <td class="label">Tipo Equipo:</td>
            <td class="value">
                {{ $baja->equipo->tipo_equipo ?? $baja->tipo_equipo ?? 'Equipo de Cómputo' }}
            </td>
        </tr>
    </table>

    <!-- Sección 2: Especificaciones Técnicas -->
    <div class="section-header">2. Especificaciones Técnicas del Equipo</div>
    <table class="table-data">
        <tr>
            <td class="label">Procesador (CPU):</td>
            <td class="value">{{ $baja->cpu ?? $baja->equipo->cpu ?? 'N/A' }}</td>
            <td class="label">Memoria RAM:</td>
            <td class="value">{{ $baja->ram ?? $baja->equipo->ram ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Almacenamiento (HDD/SSD):</td>
            <td class="value">{{ $baja->disco ?? $baja->equipo->disco ?? 'N/A' }}</td>
            <td class="label">Sistema Operativo:</td>
            <td class="value">{{ $baja->so ?? $baja->equipo->so ?? 'N/A' }}</td>
        </tr>
    </table>

    <!-- Sección 3: Datos de la Baja -->
    <div class="section-header">3. Detalle y Registro de la Baja</div>
    <table class="table-data">
        <tr>
            <td class="label">Motivo de Baja:</td>
            <td class="value">
                <strong style="color: #b91c1c;">{{ $baja->motivo_baja ?? $baja->motivo ?? 'Obsolescencia / Daño Irreparable' }}</strong>
            </td>
            <td class="label">Fecha de Procesamiento:</td>
            <td class="value">
                {{ isset($baja->fecha_baja) ? date('d/m/Y', strtotime($baja->fecha_baja)) : (isset($baja->created_at) ? date('d/m/Y', strtotime($baja->created_at)) : date('d/m/Y')) }}
            </td>
        </tr>
        <tr>
            <td class="label">Técnico Dictaminante:</td>
            <td class="value" colspan="3">
                {{ $baja->tecnico ?? $baja->usuario_registro ?? 'Soporte Técnico' }}
            </td>
        </tr>
    </table>

    <!-- Sección 4: Justificación Técnica / Diagnóstico -->
    <div class="section-header">4. Justificación Técnica y Observaciones</div>
    <div class="text-box">
        {{ $baja->descripcion ?? $baja->justificacion ?? $baja->observaciones ?? 'Se procede a la baja definitiva del equipo debido a fallas técnicas irreparables o finalización de su vida útil según los estándares de la organización.' }}
    </div>

    <!-- Sección 5: Evidencia Fotográfica -->
    @if((isset($fotoAntesBase64) && $fotoAntesBase64) || (isset($fotoDespuesBase64) && $fotoDespuesBase64) || (isset($fotoBajaBase64) && $fotoBajaBase64))
        <div class="section-header">5. Evidencia Fotográfica del Estado del Equipo</div>
        <table class="photos-table">
            <tr>
                <td>
                    <div class="photo-card">
                        <div class="photo-label">EVIDENCIA DE ESTADO / DAÑO</div>
                        @if(!empty($fotoAntesBase64))
                            <img src="{{ $fotoAntesBase64 }}" alt="Evidencia 1">
                        @elseif(!empty($fotoBajaBase64))
                            <img src="{{ $fotoBajaBase64 }}" alt="Evidencia 1">
                        @else
                            <div class="no-photo">Sin fotografía registrada</div>
                        @endif
                    </div>
                </td>
                <td>
                    <div class="photo-card">
                        <div class="photo-label">ETIQUETA / CÓDIGO CONTABLE</div>
                        @if(!empty($fotoDespuesBase64))
                            <img src="{{ $fotoDespuesBase64 }}" alt="Evidencia 2">
                        @else
                            <div class="no-photo">Sin fotografía de etiqueta</div>
                        @endif
                    </div>
                </td>
            </tr>
        </table>
    @endif

    <!-- Firmas de Conformidad -->
    <table class="signatures">
        <tr>
            <td>
                <div class="line"></div>
                <strong>{{ $baja->tecnico ?? 'Técnico Responsable' }}</strong><br>
                <span>Soporte Técnico / Dictaminante</span>
            </td>
            <td>
                <div class="line"></div>
                <strong>Jefatura de IT / Administración</strong><br>
                <span>Autorizado Por</span>
            </td>
        </tr>
    </table>

    <!-- Pie de página fijo -->
    <div class="footer">
        Dictamen oficial de baja de activos IT generado el {{ date('d/m/Y H:i') }}.
    </div>

</body>
</html>