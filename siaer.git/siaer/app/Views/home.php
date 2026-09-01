<?= $this->extend('layout/base') ?>

<?= $this->section('estilos') ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css" />
<style>
  .header {
    background: #2c3e50;
    color: #fff;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    text-align: center;
  }
  .header img {
    height: 80px;
    margin-bottom: 10px;
  }
  .home-actions {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 20px;
    flex-wrap: wrap;
  }
  .home-actions a {
    padding: 12px 20px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: bold;
    transition: transform 0.2s;
    color: #fff;
  }
  .home-actions a:hover { transform: scale(1.05); }
  .home-actions a:nth-child(1) { background: #28a745; }
  .home-actions a:nth-child(2) { background: #007bff; }
  .home-actions a:nth-child(3) { background: #ffc107; color: #000; }

  .info-proyecto {
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 20px 24px;
    margin-top: 24px;
  }
  .info-proyecto h3 { margin-top: 0; }
  .info-proyecto ul { margin: 10px 0 0; padding-left: 20px; }
  .info-proyecto li { margin-bottom: 6px; }

  .mapa-home-caja {
    margin-top: 24px;
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid #ddd;
  }
  #mapa-home { height: 320px; }

  .footer {
    margin-top: 30px;
    padding: 10px;
    background: #f1f1f1;
    border-radius: 6px;
    font-size: 0.9rem;
    color: #555;
    text-align: center;
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>
<div class="header">
  <img src="<?= base_url('img/logo_general_paz.png') ?>" alt="Logo Municipalidad de General Paz">
  <h1>SIAER</h1>
  <h2>Sistema de Información y Análisis de Explotaciones Rurales</h2>
  <p>Proyecto Integrador 2026 — Grupo 2</p>
</div>

<div class="home-actions">
  <a href="<?= base_url('login') ?>">🔑 Iniciar sesión</a>
  <a href="<?= base_url('parcelas') ?>">📋 Listado de parcelas</a>
  <a href="<?= base_url('parcelas/crear') ?>">➕ Nueva parcela</a>
</div>

<div class="info-proyecto">
  <h3>¿Qué es SIAER?</h3>
  <p>
    SIAER es una herramienta web que le permite a la Municipalidad de General Paz
    reunir en un solo lugar la información de las parcelas rurales del partido:
    ubicación georreferenciada, actividad productiva, permisos e inspecciones.
    Reemplaza las planillas de Excel sueltas y los expedientes en papel que se
    usaban hasta ahora.
  </p>
  <h3>¿Qué podés hacer acá?</h3>
  <ul>
    <li>Ver el mapa de parcelas rurales del partido, con filtros por año de relevamiento y cuartel.</li>
    <li>Consultar y cargar los datos productivos de cada parcela (cultivos, ganado, infraestructura).</li>
    <li>Dar de alta, editar o eliminar parcelas desde el listado.</li>
  </ul>
</div>

<div class="mapa-home-caja">
  <div id="mapa-home"></div>
</div>

<div class="footer">
  © 2026 — Municipalidad de General Paz | Grupo 2
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
  const mapa = L.map('mapa-home').setView([-35.55, -60.45], 11);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(mapa);
</script>
<?= $this->endSection() ?>