<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($titulo ?? 'SIAER - Base de Parcelas') ?></title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome para íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            background-color: #f1f5f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #334155;
        }

        /* Navbar estilo Municipalidad de General Paz */
        .navbar-siaer-oficial {
            background-color: #1e3a60;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .navbar-siaer-oficial .brand-title {
            font-weight: 800;
            color: #ffffff;
            font-size: 1.25rem;
            letter-spacing: 0.5px;
        }

        .navbar-siaer-oficial .brand-subtitle {
            color: #94a3b8;
            font-size: 0.85rem;
            border-left: 1px solid #475569;
            padding-left: 0.75rem;
            margin-left: 0.25rem;
        }

        .navbar-siaer-oficial .nav-link {
            color: #e2e8f0;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .navbar-siaer-oficial .nav-link:hover,
        .navbar-siaer-oficial .nav-link.active {
            color: #ffffff;
        }

        .user-pill {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            padding: 0.35rem 0.85rem;
            color: #ffffff;
            font-size: 0.875rem;
        }

        /* Tarjeta principal */
        .main-card {
            background: #ffffff;
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            padding: 2rem;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        /* Tabla estilizada */
        .table-custom {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
        }

        .table-custom thead th {
            background-color: #f8fafc;
            color: #475569;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 1rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .table-custom tbody tr:hover {
            background-color: #f8fafc;
        }

        .table-custom tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.95rem;
        }

        .badge-catastro {
            background-color: #e2e8f0;
            color: #334155;
            font-weight: 600;
            padding: 0.35em 0.65em;
            border-radius: 6px;
        }

        .btn-detalle {
            background-color: #eff6ff;
            color: #2563eb;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
            padding: 0.4rem 0.8rem;
            font-weight: 500;
            font-size: 0.875rem;
            text-decoration: none;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .btn-detalle:hover {
            background-color: #2563eb;
            color: #ffffff;
            border-color: #2563eb;
        }

        .footer-text {
            color: #94a3b8;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>

<!-- NAVBAR OFICIAL -->
<nav class="navbar navbar-expand-lg navbar-siaer-oficial py-2">
    <div class="container-fluid px-4">
        
        <?php 
            $rolSesion = strtolower(session()->get('rol') ?? 'cliente');
            $homeUrl = session()->get('isLoggedIn') ? (($rolSesion === 'cliente') ? base_url('mis-parcelas') : base_url('/')) : base_url('login');
        ?>

        <a class="navbar-brand d-flex align-items-center text-decoration-none" href="<?= $homeUrl ?>">
            <span class="brand-title">SIAER</span>
            <span class="brand-subtitle d-none d-sm-inline">Municipalidad de General Paz</span>
        </a>

        <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSiaer">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSiaer">
            <ul class="navbar-nav ms-auto me-3 mb-2 mb-lg-0 align-items-center gap-2">
                <li class="nav-item">
                    <a class="nav-link active" href="<?= base_url('mis-parcelas') ?>">
                        <i class="fa-solid fa-thumbtack text-danger me-1"></i> Base de Parcelas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('parcelas') ?>">
                        <i class="fa-solid fa-map text-info me-1"></i> Mapa General
                    </a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-2">
                <?php if (session()->get('isLoggedIn')): ?>
                    <div class="user-pill d-flex align-items-center gap-2">
                        <i class="fa-solid fa-user text-primary-subtle"></i>
                        <span class="fw-semibold"><?= esc(session()->get('usuario') ?? 'Usuario') ?></span>
                        <span class="badge bg-success text-uppercase" style="font-size: 0.65rem;">
                            <?= esc($rolSesion) ?>
                        </span>
                    </div>

                    <a href="<?= base_url('logout') ?>" class="btn btn-outline-danger btn-sm rounded-3 px-3">
                        <i class="fa-solid fa-door-open me-1"></i> Salir
                    </a>
                <?php else: ?>
                    <a href="<?= base_url('login') ?>" class="btn btn-primary btn-sm px-3">
                        Iniciar Sesión
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<!-- CONTENIDO PRINCIPAL -->
<div class="container my-4">
    <div class="main-card">
        
        <!-- Encabezado de la Sección -->
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 border-bottom pb-3 gap-3">
            <div>
                <h2 class="fw-bold m-0 text-dark">
                    <i class="fa-solid fa-database text-primary me-2"></i>Base General de Parcelas
                </h2>
                <p class="text-muted mb-0 mt-1">Módulo completo de consulta, filtrado y desarrollo de registros catastrales.</p>
            </div>
            <div>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill fs-6">
                    <i class="fa-solid fa-layer-group me-1"></i> Total Registros: <span id="contadorTotal"><?= count($parcelas ?? []) ?></span>
                </span>
            </div>
        </div>

        <!-- Barra de Búsqueda Rápida en Vivo -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted border-end-0">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" id="buscadorTabla" class="form-control border-start-0 ps-0 shadow-none" placeholder="Buscar por número de catastro, propietario, actividad o cuartel..." onkeyup="filtrarTablaParcelas()">
                </div>
            </div>
        </div>

        <!-- Tabla Estilizada Completa -->
        <div class="table-responsive">
            <table class="table table-custom align-middle" id="tablaParcelasCliente">
                <thead>
                    <tr>
                        <th scope="col"># CATASTRO</th>
                        <th scope="col">PROPIETARIO / TITULAR</th>
                        <th scope="col">ACTIVIDAD / PRODUCCIÓN</th>
                        <th scope="col">CUARTEL</th>
                        <th scope="col">SUPERFICIE (HA)</th>
                        <th scope="col" class="text-end">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($parcelas)): ?>
                        <?php foreach ($parcelas as $p): ?>
                            <tr>
                                <td>
                                    <span class="badge-catastro">
                                        <?= esc($p['n_catastro'] ?? $p['nro_catastro'] ?? $p['catastro'] ?? $p['id']) ?>
                                    </span>
                                </td>
                                <td class="fw-medium text-dark">
                                    <?= esc($p['propietario'] ?? 'Sin datos') ?>
                                </td>
                                <td>
                                    <span class="text-secondary">
                                        <?= esc($p['actividad'] ?? 'Sin especificar') ?>
                                    </span>
                                </td>
                                <td>
                                    <?= esc($p['cuartel'] ?? 'S/N') ?>
                                </td>
                                <td>
                                    <strong><?= number_format((float)($p['superficie'] ?? $p['superficie_ha'] ?? 0), 2, ',', '.') ?> ha</strong>
                                </td>
                                <td class="text-end">
                                    <a href="<?= base_url('parcelas/ver/' . ($p['id'] ?? '')) ?>" class="btn-detalle">
                                        <i class="fa-solid fa-magnifying-glass"></i> Ver Detalle
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                No se encontraron registros de parcelas cargados en la base de datos.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

    <div class="text-center footer-text mb-4">
        SIAER — Municipalidad de General Paz © 2026
    </div>
</div>

<!-- Script de Búsqueda Instantánea -->
<script>
    function filtrarTablaParcelas() {
        const input = document.getElementById('buscadorTabla').value.toLowerCase();
        const filas = document.querySelectorAll('#tablaParcelasCliente tbody tr');
        let visibles = 0;

        filas.forEach(fila => {
            const textoFila = fila.textContent.toLowerCase();
            if (textoFila.includes(input)) {
                fila.style.display = '';
                visibles++;
            } else {
                fila.style.display = 'none';
            }
        });
        
        document.getElementById('contadorTotal').innerText = visibles;
    }
</script>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>