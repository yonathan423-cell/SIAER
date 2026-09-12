<?= $this->extend('layout/base') ?>

<?= $this->section('estilos') ?>
<!-- Leaflet CSS para el mapa interactivo -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<style>
  .grid-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    align-items: start;
    margin-top: 15px;
  }

  @media (max-width: 900px) {
    .grid-container {
      grid-template-columns: 1fr;
    }
  }

  form.form-parcela {
    width: 100%;
    margin: 0;
    padding: 24px;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    border: 1px solid #e2e8f0;
    box-sizing: border-box;
  }

  form.form-parcela label {
    display: block;
    margin-bottom: 14px;
    font-weight: 600;
    color: #1e293b;
    font-size: 0.88rem;
  }

  form.form-parcela input[type="text"],
  form.form-parcela input[type="number"],
  form.form-parcela select {
    width: 100%;
    padding: 10px 12px;
    margin-top: 5px;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    font-size: 0.9rem;
    box-sizing: border-box;
    transition: border-color 0.2s;
  }

  form.form-parcela input:focus,
  form.form-parcela select:focus {
    border-color: #1f3864;
    outline: none;
    box-shadow: 0 0 0 3px rgba(31, 56, 100, 0.1);
  }

  .coords-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
  }

  #mapaSelector {
    height: 480px;
    width: 100%;
    border-radius: 12px;
    border: 1px solid #cbd5e1;
    box-shadow: 0 4px 12px rgba(0,0,0,0.06);
  }

  form.form-parcela button {
    background: #1f3864;
    color: white;
    border: none;
    padding: 10px 18px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    font-size: 0.9rem;
  }

  form.form-parcela button:hover {
    background: #162848;
  }

  form.form-parcela a {
    margin-left: 12px;
    color: #64748b;
    text-decoration: none;
    font-weight: 500;
  }

  form.form-parcela a:hover {
    text-decoration: underline;
    color: #1e293b;
  }

  .alerta.alerta--error {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fca5a5;
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 20px;
    list-style-position: inside;
  }

  .btn-nueva {
    display: inline-block;
    margin-top: 10px;
    padding: 8px 14px;
    background: #1f3864;
    color: #fff;
    border-radius: 6px;
    text-decoration: none;
    font-size: 0.88rem;
    font-weight: 500;
  }

  .btn-nueva:hover {
    background: #162848;
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('sidebar') ?>
<h2>Acciones</h2>
<p>Desde aquí podés volver al listado o cancelar los cambios.</p>
<a class="btn-nueva" href="<?= base_url('parcelas') ?>">← Volver al listado</a>
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>
<h1 style="color: #1f3864; margin-bottom: 5px;">Editar parcela</h1>
<p style="color: #64748b; margin-top: 0; font-size: 0.9rem;">Podés hacer clic en el mapa si querés reubicar las coordenadas de la parcela.</p>

<?php if (session()->getFlashdata('errores')): ?>
    <ul class="alerta alerta--error">
        <?php foreach (session()->getFlashdata('errores') as $err): ?>
            <li><?= esc($err) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<div class="grid-container">
    <!-- Formulario de edición -->
    <form class="form-parcela" method="post" action="<?= base_url('parcelas/editar/' . (int) $parcela['id']) ?>">
        <input type="hidden" name="volver" value="<?= esc(base_url('parcelas') . (isset($_GET) && $_GET ? '?' . http_build_query($_GET) : '')) ?>">

        <label>Nº de catastro 
            <input type="text" name="nro_catastro" value="<?= esc($parcela['nro_catastro']) ?>" required>
        </label>

        <div class="coords-grid">
            <label>Latitud 📍
                <input type="text" name="latitud" id="latitud" value="<?= esc($parcela['latitud']) ?>" required readonly style="background-color: #f8fafc;">
            </label>

            <label>Longitud 📍
                <input type="text" name="longitud" id="longitud" value="<?= esc($parcela['longitud']) ?>" required readonly style="background-color: #f8fafc;">
            </label>
        </div>

        <label>Superficie (ha) 
            <input type="text" name="superficie_ha" value="<?= esc($parcela['superficie_ha']) ?>">
        </label>

        <label>Propietario 
            <input type="text" name="propietario" value="<?= esc($parcela['propietario']) ?>">
        </label>

        <label>Cuartel 
            <select name="cuartel" required>
                <?php 
                $cuarteles = [2 => 'Cuartel 2 (Prioritario)', 8 => 'Cuartel 8 (Prioritario)', 1 => 'Cuartel 1', 3 => 'Cuartel 3', 4 => 'Cuartel 4', 5 => 'Cuartel 5', 6 => 'Cuartel 6', 7 => 'Cuartel 7'];
                foreach ($cuarteles as $val => $texto): 
                ?>
                    <option value="<?= $val ?>" <?= ((string)$parcela['cuartel'] === (string)$val) ? 'selected' : '' ?>><?= $texto ?></option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>Año de relevamiento 
            <select name="anio_relevamiento" required>
                <?php 
                $anios = [2026, 2025, 2024, 2023];
                foreach ($anios as $a): 
                ?>
                    <option value="<?= $a ?>" <?= ((string)$parcela['anio_relevamiento'] === (string)$a) ? 'selected' : '' ?>><?= $a ?></option>
                <?php endforeach; ?>
            </select>
        </label>

        <div style="margin-top: 15px;">
            <button type="submit">Guardar cambios</button>
            <a href="<?= base_url('parcelas') ?>">Cancelar</a>
        </div>
    </form>

    <!-- Mapa Selector -->
    <div>
        <div id="mapaSelector"></div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // 1. Obtener coordenadas actuales de la parcela
    const latInicial = parseFloat(document.getElementById('latitud').value);
    const lngInicial = parseFloat(document.getElementById('longitud').value);

    // 2. Centrar mapa en la parcela si tiene coordenadas, o por defecto en la zona
    const tieneCoords = !isNaN(latInicial) && !isNaN(lngInicial);
    const centro = tieneCoords ? [latInicial, lngInicial] : [-35.576, -58.012];
    const zoomInicial = tieneCoords ? 14 : 12;

    const map = L.map('mapaSelector').setView(centro, zoomInicial);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    // 3. Cargar capas de cuarteles en el fondo
    fetch('<?= base_url('parcelas/mapaJson') ?>')
        .then(response => response.json())
        .then(data => {
            L.geoJSON(data, {
                style: {
                    color: '#1f3864',
                    weight: 1.5,
                    fillOpacity: 0.1
                }
            }).addTo(map);
        })
        .catch(err => console.error('Error cargando capa GeoJSON:', err));

    let marcador;

    // 4. Si ya existían coordenadas, ubicar el pin inicial
    if (tieneCoords) {
        marcador = L.marker(centro).addTo(map)
            .bindPopup('<b>Ubicación actual</b><br>Catastro: <?= esc($parcela['nro_catastro']) ?>')
            .openPopup();
    }

    // 5. Al hacer clic en el mapa, reubicar la parcela y actualizar inputs
    map.on('click', function(e) {
        const lat = e.latlng.lat.toFixed(6);
        const lng = e.latlng.lng.toFixed(6);

        document.getElementById('latitud').value = lat;
        document.getElementById('longitud').value = lng;

        if (marcador) {
            marcador.setLatLng(e.latlng);
        } else {
            marcador = L.marker(e.latlng).addTo(map);
        }

        marcador.bindPopup(`<b>Nueva ubicación</b><br>Lat: ${lat}<br>Lng: ${lng}`).openPopup();
    });
</script>
<?= $this->endSection() ?>