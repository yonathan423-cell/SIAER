<?= $this->extend('layout/base') ?>

<?= $this->section('contenido') ?>
<h1>Editar parcela</h1>

<?php if (session()->getFlashdata('errores')): ?>
    <ul class="alerta alerta--error">
        <?php foreach (session()->getFlashdata('errores') as $err): ?>
            <li><?= esc($err) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="post" action="<?= base_url('parcelas/editar/' . (int) $parcela['id']) ?>">
    <input type="hidden" name="volver" value="<?= esc(base_url('parcelas') . (isset($_GET) && $_GET ? '?' . http_build_query($_GET) : '')) ?>">
    <label>Nº de catastro <input type="text" name="nro_catastro" value="<?= esc($parcela['nro_catastro']) ?>" required></label><br>
    <label>Latitud <input type="text" name="latitud" value="<?= esc($parcela['latitud']) ?>" required></label><br>
    <label>Longitud <input type="text" name="longitud" value="<?= esc($parcela['longitud']) ?>" required></label><br>
    <label>Superficie (ha) <input type="text" name="superficie_ha" value="<?= esc($parcela['superficie_ha']) ?>"></label><br>
    <label>Propietario <input type="text" name="propietario" value="<?= esc($parcela['propietario']) ?>"></label><br>
    <label>Cuartel <input type="text" name="cuartel" value="<?= esc($parcela['cuartel']) ?>" required></label><br>
    <label>Año de relevamiento <input type="number" name="anio_relevamiento" value="<?= esc($parcela['anio_relevamiento']) ?>" required></label><br>
    <button type="submit">Guardar cambios</button>
    <a href="<?= base_url('parcelas') ?>">Cancelar</a>
</form>
<?= $this->endSection() ?>
