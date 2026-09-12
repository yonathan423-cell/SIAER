<?= $this->extend('layout/base') ?>

<?= $this->section('estilos') ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css" />
<style>
  
  /* Header Moderno y Elegante */
  .hero-simple {
    background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
    color: #ffffff;
    padding: 40px 30px;
    border-radius: 16px;
    margin-bottom: 24px;
    text-align: center;
    box-shadow: 0 10px 25px -5px rgba(30, 58, 138, 0.2);
  }

  .hero-logo {
    background: #ffffff;
    display: inline-block;
    padding: 8px 16px;
    border-radius: 10px;
    margin-bottom: 14px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
  }

  .hero-logo img {
    height: 42px;
    display: block;
  }

  .hero-simple h1 {
    font-size: 2.2rem;
    font-weight: 800;
    margin: 0 0 6px 0;
    color: #ffffff;
    letter-spacing: -0.5px;
  }

  .hero-simple p {
    color: #cbd5e1;
    font-size: 0.95rem;
    margin: 0;
  }

  /* Tarjetas Limpias */
  .info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin-bottom: 24px;
  }

  .info-card {
    background: #ffffff;
    border-radius: 14px;
    padding: 24px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
  }

  .info-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
    border-color: #94a3b8;
  }

  .info-card h3 {
    color: #0f172a;
    margin-top: 0;
    font-size: 1.1rem;
    font-weight: 800;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .info-card p, .info-card ul {
    color: #475569;
    font-size: 0.9rem;
    line-height: 1.6;
    margin: 0;
  }

  .info-card ul {
    padding-left: 0;
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 8px;
  }

  .info-card ul li {
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .info-card ul li::before {
    content: "✓";
    color: #2563eb;
    font-weight: 800;
  }

  /* Contenedor del Mapa */
  .map-box {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
    padding: 20px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
  }

  .map-title {
    font-size: 1rem;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  #mapa-home {
    height: 380px;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>

<!-- Banner Simple -->
<div class="hero-simple">
  <div class="hero-logo">
    <img src="<?= base_url('img/logo_municipalidad.png') ?>" alt="Municipalidad General Paz" onerror="this.style.display='none'">
  </div>
  <h1>SIAER</h1>
  <p>Sistema de Información y Análisis de Explotaciones Rurales — Municipalidad de General Paz</p>
</div>

<!-- 2 Tarjetas Básicas -->
<div class="info-grid">
  <div class="info-card">
    <h3>🌱 ¿Qué es SIAER?</h3>
    <p>Plataforma para la gestión y consulta georreferenciada de parcelas rurales del partido de General Paz, consolidando datos de actividad productiva e inspecciones.</p>
  </div>
  
  <div class="info-card">
    <h3>⚡ Funcionalidades</h3>
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
  const mapa = L.map('mapa-home', { zoomControl: false }).setView([-35.55, -58.78], 11);
  L.control.zoom({ position: 'topright' }).addTo(mapa);
  
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap'
  }).addTo(mapa);
</script>
<?= $this->endSection() ?>