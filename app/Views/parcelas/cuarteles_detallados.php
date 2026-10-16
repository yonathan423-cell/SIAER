<?= $this->extend('layout/base') ?>

<?= $this->section('estilos') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    :root {
        --primary-green: #198754;
        --dark-green: #145c34;
        --light-green: #e8f5e9;
    }

    .report-header {
        background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 100%);
        color: #ffffff;
        padding: 32px;
        border-radius: 14px;
        margin-bottom: 30px;
        box-shadow: 0 8px 20px rgba(20, 92, 52, 0.15);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .report-header h2 {
        font-weight: 800;
        margin: 0 0 6px 0;
        font-size: 1.7rem;
    }

    .report-header p {
        margin: 0;
        color: rgba(255, 255, 255, 0.85);
        font-size: 0.95rem;
    }

    .header-actions {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .card-report {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        overflow: hidden;
        margin-bottom: 40px;
    }

    .table-custom {
        margin-bottom: 0;
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-custom th {
        background-color: #f1f8f5;
        color: var(--dark-green);
        font-weight: 700;
        padding: 16px 20px;
        border-bottom: 2px solid #c8e6c9;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table-custom td {
        padding: 14px 20px;
        vertical-align: middle;
        color: #334155;
        border-bottom: 1px solid #edf2f7;
        font-size: 0.95rem;
    }

    .cuartel-group-row {
        background-color: #e8f5e9 !important;
        font-weight: 700;
        color: var(--dark-green);
    }

    .cuartel-group-row td {
        padding: 16px 20px;
        border-top: 2px solid #c8e6c9;
        border-bottom: 2px solid #c8e6c9;
    }

    .badge-actividad {
        background-color: rgba(25, 135, 84, 0.1);
        color: var(--primary-green);
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>

<!-- Header Superior -->
<div class="report-header">
    <div>
        <h2><i class="fa-solid fa-layer-group me-2"></i><?= esc($titulo) ?></h2>
        <p>Listado detallado de explotaciones rurales organizadas por cuartel en el partido</p>
    </div>
    <div class="header-actions">
        <button onclick="exportarCuartelesExcel()" class="btn btn-light text-success fw-bold px-4 py-2 shadow-sm d-flex align-items-center gap-2">
            <i class="fa-solid fa-file-excel"></i> Descargar Excel
        </button>
        <a href="<?= base_url('dashboard') ?>" class="btn btn-outline-light fw-semibold px-3 py-2 d-flex align-items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Volver al Panel
        </a>
    </div>
</div>

<?php
    $cuartelesAgrupados = [];
    if (!empty($parcelas) && is_array($parcelas)) {
        foreach ($parcelas as $p) {
            $cuartel = trim($p['cuartel'] ?? 'Sin Cuartel');
            if (empty($cuartel)) { $cuartel = 'Sin Cuartel'; }
            $cuartelesAgrupados[$cuartel][] = $p;
        }
    }
?>

<!-- Contenedor Principal de la Tabla -->
<div class="card-report">
    <div class="table-responsive">
        <table class="table table-custom align-middle" id="tablaCuartelesDetalle">
            <thead>
                <tr>
                    <th class="ps-4">Cuartel / Detalle</th>
                    <th>Nº Catastro (Parcela)</th>
                    <th>Superficie</th>
                    <th class="pe-4">Actividad Productiva</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($cuartelesAgrupados)): ?>
                    <?php foreach ($cuartelesAgrupados as $nombreCuartel => $listaParcelas): ?>
                        <!-- Fila de Cabecera del Cuartel -->
                        <tr class="cuartel-group-row">
                            <td colspan="4" class="ps-4">
                                <i class="fa-solid fa-folder-open me-2 text-success"></i>
                                Cuartel: <?= esc($nombreCuartel) ?> 
                                <span class="badge bg-success text-white ms-2 px-2 py-1 fs-6 fw-normal"><?= count($listaParcelas) ?> parcelas asociadas</span>
                            </td>
                        </tr>
                        <?php foreach ($listaParcelas as $parcela): ?>
                            <tr>
                                <td class="ps-5 text-muted small">
                                    <i class="fa-solid fa-angles-right text-success opacity-50 me-1"></i> Cuartel <?= esc($nombreCuartel) ?>
                                </td>
                                <td class="fw-bold text-dark font-monospace"><?= esc($parcela['n_catastro'] ?? 'N/D') ?></td>
                                <td><span class="fw-semibold text-success"><?= esc($parcela['superficie_ha'] ?? '0') ?></span> <span class="text-muted small">ha</span></td>
                                <td class="pe-4">
                                    <span class="badge-actividad"><?= esc($parcela['actividad'] ?? 'Sin especificar') ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted py-5">
                            <i class="fa-solid fa-folder-closed fa-2x mb-2 text-black-50"></i>
                            <p class="mb-0">No hay parcelas registradas para mostrar en este momento.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function exportarCuartelesExcel() {
        var htmlTabla = document.getElementById('tablaCuartelesDetalle').outerHTML;
        var blob = new Blob(['\ufeff' + htmlTabla], { type: 'application/vnd.ms-excel' });
        var url = URL.createObjectURL(blob);
        var a = document.createElement('a');
        a.href = url;
        a.download = 'Parcelas_Por_Cuartel_SIAER.xls';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }
</script>
<?= $this->endSection() ?>