<?= $this->extend('layout/base') ?>

<?= $this->section('estilos') ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-control-geocoder@2.4.0/dist/Control.Geocoder.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-search/dist/leaflet-search.min.css" />
<style>
    #mapa { height: 480px; border-radius: 8px; margin-bottom: 24px; }
    table.tabla-parcelas { width: 100%; border-collapse: collapse; }
    table.tabla-parcelas th, table.tabla-parcelas td { padding: 6px 10px; border-bottom: 1px solid #ddd; text-align: left; }
</style>
<?= $this->endSection() ?>

<?php
$colsDisponibles = [
    'id'                => 'ID',
    'nro_catastro'      => 'Nº Catastro',
    'latitud'           => 'Latitud',
    'longitud'          => 'Longitud',
    'superficie_ha'     => 'Superficie (ha)',
    'propietario'       => 'Propietario',
    'cuartel'           => 'Cuartel',
    'anio_relevamiento' => 'Año relevamiento',
];
$colsSeleccionadas = $_GET['cols'] ?? [];
?>

<?= $this->section('sidebar') ?>
<h2>Filtros y columnas</h2>
<form method="get" action="<?= base_url('parcelas') ?>">
    <fieldset>
        <legend>Filtros</legend>
        <label>Año
            <input type="number" name="anio" value="<?= esc($anioSeleccionado ?? '') ?>">
        </label>
        <label>Cuartel
            <input type="text" name="cuartel" value="<?= esc($cuartelSeleccionado ?? '') ?>">
        </label>
    </fieldset>
    <fieldset>
        <legend>Columnas a mostrar</legend>
        <?php foreach ($colsDisponibles as $valor => $etiqueta): ?>
            <label>
                <input type="checkbox" name="cols[]" value="<?= $valor ?>"
                    <?= in_array($valor, $colsSeleccionadas) ? 'checked' : '' ?>>
                <?= $etiqueta ?>
            </label>
        <?php endforeach; ?>
    </fieldset>
    <button type="submit">Aplicar</button>
</form>
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>
<div class="encabezado-pagina">
    <h1>Parcelas rurales</h1>
    <a class="boton boton--primario" href="<?= base_url('parcelas/crear') ?>?<?= http_build_query($_GET) ?>">+ Nueva parcela</a>
</div>

<div id="mapa"></div>

<table class="tabla-parcelas">
    <thead>
        <tr>
            <?php foreach ($colsDisponibles as $valor => $etiqueta): ?>
                <?php if (in_array($valor, $colsSeleccionadas)): ?><th><?= $etiqueta ?></th><?php endif; ?>
            <?php endforeach; ?>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($parcelas as $p): ?>
        <tr>
            <?php foreach ($colsDisponibles as $valor => $etiqueta): ?>
                <?php if (in_array($valor, $colsSeleccionadas)): ?><td><?= esc($p[$valor]) ?></td><?php endif; ?>
            <?php endforeach; ?>
            <td>
              <a href="<?= base_url('parcelas/editar/' . (int) $p['id']) ?>?<?= http_build_query($_GET) ?>">Editar</a> |
              <a href="<?= base_url('parcelas/eliminar/' . (int) $p['id']) ?>"
                 onclick="return confirm('¿Seguro que querés borrar esta parcela?')">Borrar</a>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if (empty($parcelas)): ?>
        <tr><td colspan="<?= count($colsSeleccionadas) + 1 ?>">No hay parcelas cargadas con esos filtros.</td></tr>
    <?php endif; ?>
    </tbody>
</table>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet-control-geocoder@2.4.0/dist/Control.Geocoder.js"></script>
<script src="https://unpkg.com/leaflet-search/dist/leaflet-search.min.js"></script>
<script>
  const callejero = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors'
  });
  const satelite = L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
      subdomains:['mt0','mt1','mt2','mt3'],
      attribution: '&copy; Google'
  });
  const topografico = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenTopoMap contributors'
  });

  const mapa = L.map('mapa', {
      center: [-35.55, -60.45],
      zoom: 11,
      layers: [callejero]
  });

  L.control.layers({
      "Callejero": callejero,
      "Satélite": satelite,
      "Topográfico": topografico
  }).addTo(mapa);

  L.Control.geocoder({
      defaultMarkGeocode: true,
      placeholder: 'Buscar dirección o lugar...'
  }).addTo(mapa);

  // 🔹 Ícono rojo estilo Google Maps
  const iconoRojo = L.icon({
    iconUrl: 'https://maps.gstatic.com/mapfiles/ms2/micons/red-dot.png',
    iconSize: [32, 32],
    iconAnchor: [16, 32],
    popupAnchor: [0, -32]
  });

  fetch('<?= base_url('parcelas/mapaJson') ?><?= ($anioSeleccionado || $cuartelSeleccionado) ? '?' . http_build_query(array_filter(['anio' => $anioSeleccionado ?? null, 'cuartel' => $cuartelSeleccionado ?? null])) : '' ?>')
      .then(r => r.json())
      .then(parcelas => {
          const marcadores = [];
          parcelas.forEach(p => {
              const marker = L.marker([p.latitud, p.longitud], { icon: iconoRojo })
                  .bindPopup(`
                    <b>Catastro:</b> ${p.nro_catastro}<br>
                    <b>Cuartel:</b> ${p.cuartel}<br>
                    <b>Superficie:</b> ${p.superficie_ha} ha<br>
                    <b>Propietario:</b> ${p.propietario}<br>
                    <a href="<?= base_url('parcelas/eliminar/') ?>${p.id}" 
                       onclick="return confirm('¿Seguro que querés borrar esta parcela?')">🗑️ Borrar</a>
                  `);

              marcadores.push(marker);
              marker.addTo(mapa);
          });

          if (marcadores.length === 1) {
              mapa.setView(marcadores[0].getLatLng(), 14);
          } else if (marcadores.length > 1) {
              const grupo = L.featureGroup(marcadores);
              mapa.fitBounds(grupo.getBounds(), { padding: [30, 30] });
          }

          var searchControl = new L.Control.Search({
              layer: L.featureGroup(marcadores),
              propertyName: 'nombre',
              initial: false,
              zoom: 14,
              marker: false
          });
          mapa.addControl(searchControl);
      })
      .catch(err => console.error('No se pudo cargar el mapa:', err));
</script>
<?= $this->endSection() ?>
