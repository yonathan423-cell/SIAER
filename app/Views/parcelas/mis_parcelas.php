<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= esc($titulo ?? 'Mis Parcelas') ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <style>
        :root {
            --primary-green: #198754;
            --dark-green: #145c34;
            --light-green: #e8f5e9;
        }
        body {
            background-color: #f4f7f6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar-custom {
            background-color: var(--dark-green);
            color: white;
            padding: 12px 30px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
            margin-bottom: 30px;
        }
        .navbar-brand-custom {
            font-weight: 700;
            font-size: 1.25rem;
            color: white;
            text-decoration: none;
            letter-spacing: 0.5px;
        }
        .navbar-subtitle {
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.8);
            border-left: 1px solid rgba(255, 255, 255, 0.4);
            padding-left: 15px;
            margin-left: 15px;
        }
        .card-custom {
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            background: white;
            margin-bottom: 25px;
            overflow: hidden;
        }
        .card-header-custom {
            background-color: var(--primary-green);
            color: white;
            font-weight: 600;
            padding: 12px 20px;
        }
        .stat-card {
            border-left: 4px solid var(--primary-green);
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        #map {
            height: 450px;
            width: 100%;
        }
        .table th {
            background-color: var(--light-green);
            color: var(--dark-green);
        }
    </style>
</head>
<body>

    <!-- Barra Superior -->
    <nav class="navbar navbar-custom d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <span class="navbar-brand-custom">SIAER</span>
            <span class="navbar-subtitle">Municipalidad de General Paz</span>
        </div>
        <div>
            <a href="<?= base_url() ?>" class="text-white text-decoration-none fw-semibold small">
                <i class="fa-solid fa-arrow-left me-1"></i> Volver al Inicio
            </a>
        </div>
    </nav>

    <div class="container pb-5">
        
        <!-- Título con icono de parcela / terreno -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1" style="color: var(--dark-green);"><i class="fa-solid fa-map-marked-alt me-2"></i><?= esc($titulo) ?></h2>
                <p class="text-muted mb-0">Análisis y distribución de explotaciones rurales por cuartel</p>
            </div>
            <button onclick="exportarExcel()" class="btn btn-success fw-bold shadow-sm px-4">
                <i class="fa-solid fa-file-excel me-2"></i> Descargar Excel
            </button>
        </div>

        <?php
            // Lógica de análisis para el Dashboard en PHP
            $totalParcelas = 0;
            $superficieTotal = 0;
            $porActividad = [];$porCuartel = [];

            if (!empty($parcelas) && is_array($parcelas)) {
                foreach ($parcelas as $p) {$totalParcelas++;
                    $sup = floatval($p['superficie'] ?? 0);
                    $superficieTotal +=$sup;

                    $act = trim($p['actividad'] ?? 'Sin especificar');
                    if (empty($act)) { $act = 'Sin especificar'; }$porActividad[$act] = ($porActividad[$act] ?? 0) +$sup;

                    $cuartel = trim($p['cuartel'] ?? 'Sin Cuartel');
                    if (empty($cuartel)) { $cuartel = 'Sin Cuartel'; }$porCuartel[$cuartel][] =$p;
                }
                ksort($porCuartel, SORT_NATURAL); // Cuartel 2, 3, 4...
            }
        ?>

        <!-- Dashboard de Métricas -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="text-muted small fw-semibold text-uppercase">Total de Parcelas</div>
                    <div class="fs-3 fw-bold text-dark mt-1"><?= $totalParcelas ?></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="text-muted small fw-semibold text-uppercase">Superficie Total Registrada</div>
                    <div class="fs-3 fw-bold text-success mt-1"><?= number_format($superficieTotal, 2, ',', '.') ?> <span class="fs-6 text-muted">ha</span></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="text-muted small fw-semibold text-uppercase">Cuarteles Involucrados</div>
                    <div class="fs-3 fw-bold text-primary mt-1"><?= count($porCuartel) ?></div>
                </div>
            </div>
        </div>

        <!-- Análisis por Actividad -->
        <div class="card card-custom mb-4">
            <div class="card-header-custom">
                <i class="fa-solid fa-chart-pie me-2"></i>Análisis de Superficie por Actividad
            </div>
            <div class="card-body">
                <div class="row">
                    <?php if (!empty($porActividad)): ?>
                        <?php foreach ($porActividad as $actividad =>$supAct): ?>
                            <div class="col-md-4 mb-3">
                                <div class="p-3 border rounded bg-light">
                                    <div class="fw-bold text-secondary"><?= esc($actividad) ?></div>
                                    <div class="fs-4 fw-semibold text-success mt-1"><?= number_format($supAct, 2, ',', '.') ?> ha</div>
                                    <small class="text-muted"><?= round(($supAct / ($superficieTotal > 0 ?$superficieTotal : 1)) * 100, 1) ?>% del total</small>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12"><p class="text-muted text-center mb-0">No hay datos de actividades registradas.</p></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Tarjeta del Mapa Interactivo -->
        <div class="card card-custom mb-4">
            <div class="card-header-custom d-flex justify-content-between align-items-center">
                <span><i class="fa-solid fa-map-location-dot me-2"></i>Ubicación Geográfica en el Partido</span>
                <span class="badge bg-light text-success fw-bold px-3 py-2">Vista Cliente</span>
            </div>
            <div class="card-body p-0">
                <div id="map"></div>
            </div>
        </div>

        <!-- Listado Separado por Cuartel y Tabla para Excel -->
        <div class="card card-custom">
            <div class="card-header-custom">
                <i class="fa-solid fa-table-list me-2"></i>Detalle de Parcelas por Cuartel
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="tablaParcelas">
                        <thead>
                            <tr>
                                <th>Cuartel</th>
                                <th>Nº Catastro</th>
                                <th>Superficie (ha)</th>
                                <th>Actividad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($porCuartel)): ?>
                                <?php foreach ($porCuartel as $nombreCuartel =>$listaParcelas): ?>
                                    <?php $etiqueta = stripos($nombreCuartel, 'cuartel') !== false ? $nombreCuartel : 'Cuartel ' . $nombreCuartel; ?>
                                    <!-- Fila de cabecera de Cuartel -->
                                    <tr class="table-success">
                                        <td colspan="4" class="fw-bold text-dark">
                                            <i class="fa-solid fa-layer-group me-2"></i><?= esc($etiqueta) ?> (<?= count($listaParcelas) ?> parcelas)
                                        </td>
                                    </tr>
                                    <?php foreach ($listaParcelas as$parcela): ?>
                                        <tr>
                                            <td class="ps-4 text-muted small">↳ <?= esc($etiqueta) ?></td>
                                            <td class="fw-semibold text-secondary"><?= esc($parcela['n_catastro'] ?? '') ?></td>
                                            <td><?= esc($parcela['superficie'] ?? 'N/D') ?></td>
                                            <td><?= esc($parcela['actividad'] ?? 'N/D') ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">No hay parcelas registradas para este usuario.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Inicializar mapa centrado en el partido
        var map = L.map('map').setView([-35.75, -58.6], 11);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Cargar marcadores de las parcelas
        fetch('<?= base_url('parcelas/mapaJson') ?>')
            .then(response => response.json())
            .then(data => {
                if (Array.isArray(data)) {
                    data.forEach(parcela => {
                        if (parcela.latitud && parcela.longitud) {
                            var marker = L.marker([parcela.latitud, parcela.longitud]).addTo(map);
                            marker.bindPopup(`
                                <div style="font-family: sans-serif; padding: 2px;">
                                    <b style="color: #198754;">Catastro:</b> ${parcela.n_catastro || 'N/A'}<br>
                                    <b>Cuartel:</b> ${parcela.cuartel || 'N/A'}<br>
                                    <b>Actividad:</b> ${parcela.actividad || 'N/A'}
                                </div>
                            `);
                        }
                    });
                }
            })
            .catch(error => console.error('Error al cargar las capas del mapa:', error));

        // Función para exportar la tabla organizada a Excel
        function exportarExcel() {
            var htmlTabla = document.getElementById('tablaParcelas').outerHTML;
            var blob = new Blob(['\ufeff' + htmlTabla], { type: 'application/vnd.ms-excel' });
            var url = URL.createObjectURL(blob);
            var a = document.createElement('a');
            a.href = url;
            a.download = 'Analisis_Mis_Parcelas_Por_Cuartel.xls';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }
    </script>
</body>
</html>