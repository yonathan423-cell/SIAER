<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($titulo ?? 'Detalle de Parcela') ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Leaflet para el mini-mapa -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

    <style>
        body {
            background-color: #f1f5f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #334155;
        }
        .navbar-siaer-oficial {
            background-color: #1e3a60;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .navbar-siaer-oficial .brand-title { font-weight: 800; color: #fff; font-size: 1.25rem; }
        .navbar-siaer-oficial .brand-subtitle {
            color: #94a3b8; font-size: 0.85rem;
            border-left: 1px solid #475569; padding-left: 0.75rem; margin-left: 0.25rem;
        }
        .navbar-siaer-oficial .nav-link { color: #e2e8f0; font-weight: 500; }
        .main-card {
            background: #fff; border-radius: 12px; border: none;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,.05), 0 2px 4px -1px rgba(0,0,0,.03);
            padding: 2rem; margin-top: 2rem; margin-bottom: 2rem;
        }
        .badge-catastro {
            background-color: #e2e8f0; color: #334155; font-weight: 600;
            padding: 0.4em 0.7em; border-radius: 6px; font-size: 0.95rem;
        }
        .dato-label {
            font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;
            color: #94a3b8; font-weight: 600; margin-bottom: 0.15rem;
        }
        .dato-valor { font-size: 1.05rem; font-weight: 600; color: #1e293b; }
        .dato-item {
            padding: 1rem; background: #f8fafc; border-radius: 10px;
            border: 1px solid #eef2f7; height: 100%;
        }
        #mapaParcela { height: 320px; border-radius: 12px; z-index: 1; }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-siaer-oficial py-2">
    <div class="container-fluid px-4">
        <a class="navbar-brand d-flex align-items-center text-decoration-none" href="<?= base_url('mis-parcelas') ?>">
            <span class="brand-title">SIAER</span>
            <span class="brand-subtitle d-none d-sm-inline">Municipalidad de General Paz</span>
        </a>
        <div class="ms-auto d-flex align-items-center gap-2">
            <a href="<?= base_url('mis-parcelas') ?>" class="btn btn-outline-light btn-sm">
                <i class="fa-solid fa-arrow-left me-1"></i> Volver a la Base
            </a>
        </div>
    </div>
</nav>

<!-- CONTENIDO -->
<div class="container my-4">
    <div class="main-card">

        <!-- Encabezado -->
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 border-bottom pb-3 gap-3">
            <div>
                <h2 class="fw-bold m-0 text-dark">
                    <i class="fa-solid fa-map-location-dot text-primary me-2"></i>Detalle de Parcela
                </h2>
                <p class="text-muted mb-0 mt-1">Información catastral completa del registro seleccionado.</p>
            </div>
            <span class="badge-catastro">
                <i class="fa-solid fa-hashtag me-1"></i>
                <?= esc($parcela['n_catastro'] ?? $parcela['catastro'] ?? $parcela['id']) ?>
            </span>
        </div>

        <div class="row g-4">
            <!-- Columna de datos -->
            <div class="col-lg-6">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="dato-item">
                            <div class="dato-label">Propietario / Titular</div>
                            <div class="dato-valor"><?= esc($parcela['propietario'] ?? 'Sin datos') ?></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="dato-item">
                            <div class="dato-label">Cuartel</div>
                            <div class="dato-valor"><?= esc($parcela['cuartel'] ?? 'S/N') ?></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="dato-item">
                            <div class="dato-label">Superficie</div>
                            <div class="dato-valor">
                                <?= number_format((float)($parcela['superficie'] ?? 0), 2, ',', '.') ?> ha
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="dato-item">
                            <div class="dato-label">Año de Relevamiento</div>
                            <div class="dato-valor"><?= esc($parcela['anio_relevamiento'] ?? 'S/N') ?></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="dato-item">
                            <div class="dato-label">Coordenadas</div>
                            <div class="dato-valor" style="font-size: 0.9rem;">
                                <?= esc($parcela['latitud'] ?? '—') ?>, <?= esc($parcela['longitud'] ?? '—') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Columna del mapa -->
            <div class="col-lg-6">
                <div id="mapaParcela"></div>
            </div>
        </div>

    </div>

    <div class="text-center text-muted mb-4" style="font-size: 0.85rem;">
        SIAER — Municipalidad de General Paz © 2026
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const lat = parseFloat("<?= esc($parcela['latitud'] ?? 0) ?>") || -35.5;
    const lng = parseFloat("<?= esc($parcela['longitud'] ?? 0) ?>") || -58.3;

    const mapa = L.map('mapaParcela').setView([lat, lng], 16);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(mapa);

    L.marker([lat, lng]).addTo(mapa)
        .bindPopup("Parcela: <?= esc($parcela['n_catastro'] ?? '') ?>")
        .openPopup();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>