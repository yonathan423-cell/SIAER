<?= $this->extend('layout/base') ?>

<?= $this->section('estilos') ?>
<style>
  form.form-parcela {
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    background: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  }

  form.form-parcela label {
    display: block;
    margin-bottom: 12px;
    font-weight: bold;
    color: #333;
  }

  form.form-parcela input[type="text"],
  form.form-parcela input[type="number"] {
    width: 100%;
    padding: 8px 10px;
    margin-top: 4px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }

  form.form-parcela button {
    background: #007bff;
    color: white;
    border: none;
    padding: 10px 16px;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
  }

  form.form-parcela button:hover {
    background: #0056b3;
  }

  form.form-parcela a {
    margin-left: 10px;
    color: #555;
    text-decoration: none;
  }

  form.form-parcela a:hover {
    text-decoration: underline;
  }

  .alerta.alerta--error {
    background: #f8d7da;
    color: #842029;
    border: 1px solid #f5c2c7;
    padding: 10px 15px;
    border-radius: 6px;
    margin-bottom: 20px;
  }

  .btn-nueva {
    display: inline-block;
    margin-top: 10px;
    padding: 8px 12px;
    background: #6c757d;
    color: #fff;
    border-radius: 4px;
    text-decoration: none;
  }

  .btn-nueva:hover {
    background: #5a6268;
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('sidebar') ?>
<h2>Acciones</h2>
<p>Desde aquí podés volver al listado o crear nuevas parcelas.</p>
<a class="btn-nueva" href="<?= base_url('parcelas') ?>">← Volver al listado</a>
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>
<h1>Nueva parcela</h1>

<?php if (session()->getFlashdata('errores')): ?>
    <ul class="alerta alerta--error">
        <?php foreach (session()->getFlashdata('errores') as $err): ?>
            <li><?= esc($err) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form class="form-parcela" method="post" action="<?= base_url('parcelas/guardar') ?>">
    <input type="hidden" name="volver" value="<?= esc(base_url('parcelas') . (isset($_GET) && $_GET ? '?' . http_build_query($_GET) : '')) ?>">

    <label>Nº de catastro 
        <input type="text" name="nro_catastro" required>
    </label>

    <label>Latitud 
        <input type="text" name="latitud" required>
    </label>

    <label>Longitud 
        <input type="text" name="longitud" required>
    </label>

    <label>Superficie (ha) 
        <input type="text" name="superficie_ha">
    </label>

    <label>Propietario 
        <input type="text" name="propietario">
    </label>

    <label>Cuartel 
        <input type="text" name="cuartel" required>
    </label>

    <label>Año de relevamiento 
        <input type="number" name="anio_relevamiento" required>
    </label>

    <button type="submit">Guardar</button>
    <a href="<?= base_url('parcelas') ?>">Cancelar</a>
</form>
<?= $this->endSection() ?>
