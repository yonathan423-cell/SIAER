<?= $this->extend('layout/base') ?>

<?= $this->section('estilos') ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css" />
<style>
  
  /* Header Sobrio y Elegante */
  .hero-simple {
    background: #1f3864;
    color: #ffffff;
    padding: 32px 24px;
    border-radius: 14px;
    margin-bottom: 24px;
    text-align: center;
  }

  .hero-logo {
    background: #ffffff;
    display: inline-block;
    padding: 6px 14px;
    border-radius: 10px;
    margin-bottom: 12px;
  }

  .hero-logo img {
    height: 48px;
    display: block;
  }

  .hero-simple h1 {
    font-size: 2rem;
    font-weight: 800;
    margin: 4px 0;
    color: #ffffff;
  }

  .hero-simple p {
    color: #cbd5e1;
    font-size: 0.95rem;
    margin: 0;
  }

  /* Tarjetas Limpias */
  .info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
    margin-bottom: 24px;
  }

  .info-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 22px;
    border: 1px solid #e2e8f0;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
  }

  .info-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.06);
    border-color: #1f3864;
  }

  .info-card h3 {
    color: #1f3864;
    margin-top: 0;
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 10px;
  }

  .info-card p, .info-card ul {
    color: #475569;
    font-size: 0.9rem;
    line-height: 1.5;
    margin: 0;
  }

  .info-card ul {
    padding-left: 18px;
  }

  /* Contenedor del Mapa */
  .map-box {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    padding: 16px;
  }

  .map-title {
    font-size: 1rem;
    font-weight: 700;
    color: #1f3864;
    margin-bottom: 12px;
  }

  #mapa-home {
    height: 380px;
    border-radius: 8px;
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>

<!-- Banner Simple -->
<div class="hero-simple">
  <div class="hero-logo">
    <img src="<?= base_url('img/logo_municipalidad.png') ?>" alt="Municipalidad General Paz">
  </div>
  <h1>SIAER</h1>
  <p>Sistema de Información y Análisis de Explotaciones Rurales — Municipalidad de General Paz</p>
</div>

<!-- 2 Tarjetas Básicas -->
<div class="info-grid">
  <div class="info-card">
    <h3>¿Qué es SIAER?</h3>
    <p>Plataforma para la gestión y consulta georreferenciada de parcelas rurales del partido de General Paz, consolidando datos de actividad productiva e inspecciones.</p>
  </div>
  
  <div class="info-card">
    <h3>Funcionalidades</h3>
    <ul>
      <li>Mapa interactivo del partido con delimitación de parcelas.</li>
      <li>Consulta y actualización de datos productivos.</li>
      <li>Gestión centralizada de usuarios y permisos.</li>
    </ul>
  </div>
</div>

<!-- Mapa -->
<div class="map-box">
  <div class="map-title">📍 Ubicación y Delimitaciones</div>
  <div id="mapa-home"></div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
  const mapa = L.map('mapa-home').setView([-35.55, -58.78], 11);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap'
  }).addTo(mapa);
</script>
<?= $this->endSection() ?>