<?= $this->extend('layout/base') ?>

<?= $this->section('estilos') ?>
<!-- Leaflet CSS para el mapa interactivo -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<style>
  .grid-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
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
    padding: 28px;
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    border: 1px solid #e2e8f0;
    box-sizing: border-box;
  }

  form.form-parcela label {
    display: block;
    margin-bottom: 16px;
    font-weight: 700;
    color: #0f172a;
    font-size: 0.85rem;
  }

  form.form-parcela input[type="text"],
  form.form-parcela input[type="number"],
  form.form-parcela select {
    width: 100%;
    padding: 10px 14px;
    margin-top: 6px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    font-size: 0.9rem;
    box-sizing: border-box;
    transition: all 0.2s ease;
    background-color: #ffffff;
  }

  form.form-parcela input:focus,
  form.form-parcela select:focus {
    border-color: #2563eb;
    outline: none;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
  }

  .coords-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
  }

  #mapaSelector {
    height: 535px;
    width: 100%;
    border-radius: 16px;
    border: 1px solid #cbd5e1;
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
  }

  form.form-parcela button {
    background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 700;
    font-size: 0.9rem;
    box-shadow: 0 4px 10px rgba(30, 58, 138, 0.2);
    transition: transform 0.2s, background 0.2s;
  }

  form.form-parcela button:hover {
    background: linear-gradient(135deg, #1e293b 0%, #1d4ed8 100%);
    transform: translateY(-1px);
  }

  form.form-parcela a {
    margin-left: 14px;
    color: #64748b;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
  }

  form.form-parcela a:hover {
    text-decoration: underline;
    color: #0f172a;
  }

  .alerta.alerta--error {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fca5a5;
    padding: 14px 18px;
    border-radius: 10px;
    margin-bottom: 20px;
    list-style-position: inside;
    font-size: 0.9rem;
  }

  .btn-nueva {
    display: inline-block;
    margin-top: 10px;
    padding: 10px 16px;
    background: #1e3a8a;
    color: #fff;
    border-radius: 8px;
    text-decoration: none;
    font-size: 0.88rem;
    font-weight: 600;
    transition: background 0.2s;
  }

  .btn-nueva:hover {
    background: #1d4ed8;
    color: #fff;
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('sidebar') ?>
<h2 style="color: #0f172a; font-size: 1.1rem; font-weight: 800; margin-bottom: 6px;">Acciones</h2>
<p style="color: #64748b; font-size: 0.85rem; margin-top: 0; line-height: 1.4;">Desde aquí podés volver al listado o crear nuevas parcelas.</p>
<a class="btn-nueva" href="<?= base_url('parcelas') ?>">← Volver al listado</a>
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>
<h1 style="color: #0f172a; margin-bottom: 4px; font-weight: 800; font-size: 1.8rem;">Nueva parcela</h1>
<p style="color: #64748b; margin-top: 0; font-size: 0.9rem;">Hacé clic en el mapa para capturar las coordenadas de forma automática.</p>

<?php if (session()->getFlashdata('errores')): ?>
    <ul class="alerta alerta--error">
        <?php foreach (session()->getFlashdata('errores') as $err): ?>
            <li><?= esc($err) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<div class="grid-container">
    <!-- Formulario de carga -->
    <form class="form-parcela" method="post" action="<?= base_url('parcelas/guardar') ?>">
        <input type="hidden" name="volver" value="<?= esc(base_url('parcelas') . (isset($_GET) && $_GET ? '?' . http_build_query($_GET) : '')) ?>">

        <label>Nº de catastro 
            <input type="text" name="nro_catastro" required placeholder="Ej: 055-1234">
        </label>

        <div class="coords-grid">
            <label>Latitud 📍
                <input type="text" name="latitud" id="latitud" required readonly style="background-color: #f8fafc; cursor: not-allowed;" placeholder="-35.51...">
            </label>

            <label>Longitud 📍
                <input type="text" name="longitud" id="longitud" required readonly style="background-color: #f8fafc; cursor: not-allowed;" placeholder="-58.31...">
            </label>
        </div>

        <label>Superficie (ha) 
            <input type="text" name="superficie_ha" placeholder="Ej: 12.50">
        </label>

        <label>Propietario 
            <input type="text" name="propietario" placeholder="Nombre o Razón Social">
        </label>

        <label>Cuartel 
            <select name="cuartel" required>
                <option value="2" selected>Cuartel 2 (Prioritario)</option>
                <option value="8">Cuartel 8 (Prioritario)</option>
                <option value="1">Cuartel 1</option>
                <option value="3">Cuartel 3</option>
                <option value="4">Cuartel 4</option>
                <option value="5">Cuartel 5</option>
                <option value="6">Cuartel 6</option>
                <option value="7">Cuartel 7</option>
            </select>
        </label>

        <label>Año de relevamiento 
            <select name="anio_relevamiento" required>
                <option value="2026" selected>2026</option>
                <option value="2025">2025</option>
                <option value="2024">2024</option>
                <option value="2023">2023</option>
            </select>
        </label>

        <div style="margin-top: 20px; display: flex; align-items: center;">
            <button type="submit">Guardar Parcela</button>
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
    // 1. Inicializar mapa enfocado correctamente en General Paz (Ranchos)
    const map = L.map('mapaSelector', { zoomControl: false }).setView([-35.515, -58.315], 11);
    L.control.zoom({ position: 'topright' }).addTo(map);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    // 2. Cargar los cuarteles de fondo para guiarse
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

    // 3. Capturar coordenadas al hacer clic
    map.on('click', function(e) {
        const lat = e.latlng.lat.toFixed(6);
        const lng = e.latlng.lng.toFixed(6);

        // Actualizar inputs del formulario
        document.getElementById('latitud').value = lat;
        document.getElementById('longitud').value = lng;

        // Mover o crear pin con Popup
        if (marcador) {
            marcador.setLatLng(e.latlng);
        } else {
            marcador = L.marker(e.latlng).addTo(map);
        }

        marcador.bindPopup(`<b>Ubicación seleccionada</b><br>Lat: ${lat}<br>Lng: ${lng}`).openPopup();
    });

    setTimeout(() => { map.invalidateSize(); }, 200);
</script>
<?= $this->endSection() ?>