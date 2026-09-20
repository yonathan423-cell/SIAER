<?= $this->extend('layout/base') ?>

<<<<<<< HEAD
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
=======
<?= $this->section('contenido') ?>

<style>
    .parcela-wrapper {
        padding: 24px;
        background-color: #f8f9fa;
        min-height: calc(100vh - 70px);
    }
    .parcela-header {
        margin-bottom: 24px;
        max-width: 960px;
        margin-left: auto;
        margin-right: auto;
    }
    .parcela-header h2 {
        font-weight: 700;
        color: #1e293b;
        font-size: 1.5rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .parcela-header p {
        color: #64748b;
        font-size: 0.9rem;
        margin: 6px 0 0 0;
    }

    /* Tarjeta principal a todo el ancho (centrada y con tope máximo) */
    .card-panel {
        background: #ffffff;
        padding: 32px;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        max-width: 960px;
        margin: 0 auto;
    }

    /* Grilla responsiva del formulario */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    /* El primer campo (catastro) y el propietario ocupan toda la fila */
    .grid-full {
        grid-column: 1 / -1;
    }

    .form-label-custom {
        display: block;
        font-weight: 600;
        font-size: 0.82rem;
        color: #334155;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .form-control-custom, .form-select-custom {
        width: 100%;
        padding: 10px 12px;
        font-size: 0.9rem;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        background-color: #fff;
        color: #1e293b;
        box-sizing: border-box;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    .form-control-custom:focus, .form-select-custom:focus {
        border-color: #0f766e; /* Verde jade en foco */
        outline: 0;
        box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.15);
    }
    .campo-ayuda {
        font-size: 0.75rem;
        color: #94a3b8;
        margin: 4px 0 0 0;
    }

    /* Separador de sección */
    .seccion-titulo {
        grid-column: 1 / -1;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #0f766e;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 8px;
        margin-top: 8px;
    }

    /* Barra de acciones */
    .acciones-form {
        grid-column: 1 / -1;
        border-top: 1px solid #e2e8f0;
        padding-top: 20px;
        margin-top: 8px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    /* Botón Principal en Verde Jade */
    .btn-guardar {
        background-color: #0f766e;
        color: #fff;
        border: none;
        padding: 10px 20px;
        font-weight: 600;
        font-size: 0.9rem;
        border-radius: 8px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background-color 0.2s;
    }
    .btn-guardar:hover {
        background-color: #115e59;
    }
    .btn-cancelar {
        background-color: transparent;
        color: #64748b;
        border: 1px solid #cbd5e1;
        padding: 10px 16px;
        font-weight: 600;
        font-size: 0.9rem;
        border-radius: 8px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: all 0.2s;
    }
    .btn-cancelar:hover {
        background-color: #f1f5f9;
        color: #1e293b;
    }

    /* Que en pantallas chicas pase a una sola columna */
    @media (max-width: 640px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="parcela-wrapper">

    <!-- Título y descripción -->
    <div class="parcela-header">
        <h2>
            <i class="fa-solid fa-map-pin" style="color: #0f766e;"></i> Registrar Nueva Parcela
        </h2>
        <p>Complete los datos catastrales de la parcela. Ingrese las coordenadas de latitud y longitud de forma manual.</p>
    </div>

    <!-- Tarjeta con el formulario a todo el ancho -->
    <div class="card-panel">
        <form action="<?= base_url('parcelas/guardar') ?>" method="POST" autocomplete="off">
            <?= csrf_field() ?>

            <div class="form-grid">

                <!-- Datos catastrales -->
                <div class="seccion-titulo">Datos Catastrales</div>

                <div class="grid-full">
                    <label for="catastro" class="form-label-custom">Nº de Catastro</label>
                    <input type="text" class="form-control-custom" id="catastro" name="catastro" placeholder="Ej: 055-1234" required>
                </div>

                <div>
                    <label for="superficie" class="form-label-custom">Superficie (hectáreas)</label>
                    <input type="number" step="0.01" class="form-control-custom" id="superficie" name="superficie" placeholder="Ej: 12.50">
                </div>

                <div>
                    <label for="propietario" class="form-label-custom">Propietario / Titular</label>
                    <input type="text" class="form-control-custom" id="propietario" name="propietario" placeholder="Nombre o Razón Social">
                </div>

                <!-- Ubicación -->
                <div class="seccion-titulo">Ubicación Geográfica</div>

                <div>
                    <label for="latitud" class="form-label-custom">Latitud *</label>
                    <input type="text" class="form-control-custom" id="latitud" name="latitud" placeholder="-35.55..." required>
                    <p class="campo-ayuda">Ejemplo para General Paz: -35.5533</p>
                </div>

                <div>
                    <label for="longitud" class="form-label-custom">Longitud *</label>
                    <input type="text" class="form-control-custom" id="longitud" name="longitud" placeholder="-58.30..." required>
                    <p class="campo-ayuda">Ejemplo para General Paz: -58.3059</p>
                </div>

                <!-- Clasificación -->
                <div class="seccion-titulo">Clasificación</div>

                <div>
                    <label for="cuartel" class="form-label-custom">Cuartel</label>
                    <select class="form-select-custom" id="cuartel" name="cuartel">
                        <option value="Cuartel 1">Cuartel 1</option>
                        <option value="Cuartel 2" selected>Cuartel 2 (Prioritario)</option>
                        <option value="Cuartel 3">Cuartel 3</option>
                        <option value="Cuartel 4">Cuartel 4</option>
                        <option value="Cuartel 5">Cuartel 5</option>
                        <option value="Cuartel 6">Cuartel 6</option>
                        <option value="Cuartel 7">Cuartel 7</option>
                        <option value="Cuartel 8">Cuartel 8</option>
                    </select>
                </div>

                <div>
                    <label for="anio_relevamiento" class="form-label-custom">Año Relevamiento</label>
                    <select class="form-select-custom" id="anio_relevamiento" name="anio_relevamiento">
                        <option value="2026" selected>2026</option>
                        <option value="2025">2025</option>
                        <option value="2024">2024</option>
                        <option value="2023">2023</option>
                    </select>
                </div>

                <!-- Acciones -->
                <div class="acciones-form">
                    <button type="submit" class="btn-guardar">
                        <i class="fa-solid fa-floppy-disk"></i> Guardar Parcela
                    </button>
                    <a href="<?= base_url('parcelas') ?>" class="btn-cancelar">
                        Cancelar
                    </a>
                </div>

            </div>
        </form>
    </div>

</div>
<?= $this->endSection() ?>
>>>>>>> login
