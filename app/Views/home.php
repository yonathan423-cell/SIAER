<?= $this->extend('layout/base') ?>

<?= $this->section('estilos') ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>

  :root {
    --primary-green: #198754;
    --dark-green: #145c34;
    --light-green: #e8f5e9;
    --accent-gold: #c5a059;
    --slate-800: #1e293b;
    --slate-600: #475569;
  }

  .home-container {
    padding: 10px 0 50px 0;
  }

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


  /* Banner Hero Institucional Premium */
  .hero-executive {
    background: linear-gradient(135deg, #0e3d22 0%, #145c34 60%, #198754 100%);
    color: #ffffff;
    padding: 55px 40px;
    border-radius: 20px;
    margin-bottom: 32px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 15px 35px -5px rgba(20, 92, 52, 0.3);
    border: 1px solid rgba(255, 255, 255, 0.1);
  }

  .hero-executive::before {
    content: "";
    position: absolute;
    top: -50%;
    right: -10%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(255,255,255,0.06) 0%, rgba(255,255,255,0) 70%);
    border-radius: 50%;
    pointer-events: none;
  }

  .hero-badge-municipal {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(8px);
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 8px 24px;
    border-radius: 40px;
    margin-bottom: 22px;
    border: 1px solid rgba(255, 255, 255, 0.25);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  }

  .hero-badge-municipal img {
    height: 38px;
    display: block;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.15));
  }

  .hero-badge-municipal span {
    color: #ffffff;
    font-weight: 700;
    font-size: 0.88rem;
    letter-spacing: 0.8px;
    text-transform: uppercase;
  }

  .hero-executive h1 {
    font-size: 2.8rem;
    font-weight: 900;
    margin: 0 0 12px 0;
    color: #ffffff;
    letter-spacing: -0.8px;
    line-height: 1.15;
  }

  .hero-executive p {
    color: #e2e8f0;
    font-size: 1.1rem;
    max-width: 800px;
    margin: 0 auto 28px auto;
    line-height: 1.6;
    font-weight: 400;
  }

  .hero-actions {
    display: flex;
    gap: 16px;
    justify-content: center;
    flex-wrap: wrap;
  }

  .btn-executive-primary {
    background: #ffffff;
    color: var(--dark-green);
    font-weight: 800;
    padding: 14px 28px;
    border-radius: 12px;
    text-decoration: none !important;
    transition: all 0.25s ease;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-size: 0.95rem;
  }

  .btn-executive-primary:hover {
    background: #f0fdf4;
    color: var(--dark-green);
    transform: translateY(-3px);
    box-shadow: 0 10px 22px rgba(0, 0, 0, 0.2);
  }

  .btn-executive-secondary {
    background: rgba(255, 255, 255, 0.12);
    color: #ffffff;
    font-weight: 700;
    padding: 14px 28px;
    border-radius: 12px;
    text-decoration: none !important;
    border: 1px solid rgba(255, 255, 255, 0.3);
    transition: all 0.25s ease;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-size: 0.95rem;
  }

  .btn-executive-secondary:hover {
    background: rgba(255, 255, 255, 0.22);
    color: #ffffff;
    transform: translateY(-3px);
  }

  /* Tira de KPIs / Estadísticas Municipales */
  .kpi-bar {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    margin-bottom: 35px;
  }

  .kpi-card {
    background: #ffffff;
    border-radius: 14px;
    padding: 20px 24px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    display: flex;
    align-items: center;
    gap: 18px;
  }

  .kpi-icon-box {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    background: var(--light-green);
    color: var(--dark-green);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    flex-shrink: 0;
  }

  .kpi-data span {
    display: block;
    font-size: 0.78rem;
    font-weight: 700;
    color: var(--slate-600);
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .kpi-data h3 {
    margin: 2px 0 0 0;
    font-size: 1.6rem;
    font-weight: 900;
    color: var(--dark-green);
  }

  /* Grid de Pilares Técnicos del Sistema */
  .features-section-title {
    font-size: 1.25rem;
    font-weight: 800;
    color: var(--dark-green);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .pillars-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 24px;
    margin-bottom: 35px;
  }

  .pillar-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 30px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    position: relative;
    overflow: hidden;
    transition: all 0.25s ease;
  }

  .pillar-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 5px;
    height: 100%;
    background-color: var(--primary-green);
  }

  .pillar-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.08);
    border-color: #a7f3d0;
  }

  .pillar-header {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 18px;
  }

  .pillar-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: var(--light-green);
    color: var(--dark-green);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.35rem;
    flex-shrink: 0;
  }

  .pillar-card h3 {
    color: var(--dark-green);
    margin: 0;
    font-size: 1.25rem;
    font-weight: 800;
  }

  .pillar-card p {
    color: var(--slate-600);
    font-size: 0.95rem;
    line-height: 1.6;
    margin: 0 0 16px 0;
  }

  .pillar-list {
    padding-left: 0;
    list-style: none;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  .pillar-list li {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    color: var(--slate-800);
    font-size: 0.92rem;
    font-weight: 500;
  }

  .pillar-list li i {
    color: var(--primary-green);
    margin-top: 3px;
    font-size: 0.9rem;
  }

  /* Visualizador GIS del Partido */
  .gis-box {
    background: #ffffff;
    border-radius: 18px;
    border: 1px solid #e2e8f0;
    padding: 28px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    margin-bottom: 35px;
  }

  .gis-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
    flex-wrap: wrap;
    gap: 12px;
  }

  .gis-title {
    font-size: 1.2rem;
    font-weight: 800;
    color: var(--dark-green);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  #mapa-home {
    height: 420px;
    border-radius: 14px;
    border: 1px solid #cbd5e1;
    z-index: 1;
  }

  /* Floating Assistant FAB & Ventana */
  .chat-fab {
    position: fixed;
    bottom: 28px;
    right: 28px;
    width: 62px;
    height: 62px;
    border-radius: 50%;
    background: var(--dark-green);
    color: #fff;
    border: none;
    font-size: 1.6rem;
    cursor: pointer;
    box-shadow: 0 8px 24px -4px rgba(20, 92, 52, 0.5);
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.2s ease, background 0.2s ease;
  }
  .chat-fab:hover {
    transform: scale(1.08);
    background: var(--primary-green);
  }

  .chat-ventana {
    position: fixed;
    bottom: 100px;
    right: 28px;
    width: 360px;
    max-width: calc(100vw - 48px);
    height: 500px;
    max-height: calc(100vh - 130px);
    background: #ffffff;
    border-radius: 18px;
    box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.25);
    z-index: 1000;
    display: none;
    flex-direction: column;
    overflow: hidden;
    border: 1px solid #e2e8f0;
    opacity: 0;
    transform: translateY(15px);
    transition: opacity 0.25s ease, transform 0.25s ease;
  }
  .chat-ventana.abierto {
    display: flex;
    opacity: 1;
    transform: translateY(0);
  }

  .chat-header {
    background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 100%);
    color: #fff;
    padding: 16px 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .chat-header .chat-titulo {
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: 700;
    font-size: 0.95rem;
  }
  .chat-header .chat-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.15rem;
  }
  .chat-header .chat-estado {
    font-size: 0.72rem;
    color: #bbf7d0;
    font-weight: 500;
    display: block;
  }
  .chat-cerrar {
    background: none;
    border: none;
    color: #fff;
    font-size: 1.3rem;
    cursor: pointer;
    line-height: 1;
    opacity: 0.85;
  }
  .chat-cerrar:hover { opacity: 1; }

  .chat-cuerpo {
    flex: 1;
    overflow-y: auto;
    padding: 16px;
    background: #f8fafc;
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  .chat-msg {
    max-width: 82%;
    padding: 10px 14px;
    border-radius: 14px;
    font-size: 0.88rem;
    line-height: 1.45;
    word-wrap: break-word;
    overflow-wrap: anywhere;
  }
  .chat-msg.bot {
    background: #ffffff;
    color: var(--slate-800);
    border: 1px solid #e2e8f0;
    align-self: flex-start;
    border-bottom-left-radius: 4px;
  }
  .chat-msg.user {
    background: var(--primary-green);
    color: #ffffff;
    align-self: flex-end;
    border-bottom-right-radius: 4px;
  }

  .chat-typing {
    align-self: flex-start;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 10px 14px;
    display: flex;
    gap: 4px;
  }
  .chat-typing span {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #94a3b8;
    animation: chatBlink 1.2s infinite;
  }
  .chat-typing span:nth-child(2) { animation-delay: 0.2s; }
  .chat-typing span:nth-child(3) { animation-delay: 0.4s; }
  @keyframes chatBlink {
    0%, 60%, 100% { opacity: 0.3; }
    30% { opacity: 1; }
  }

  .chat-chips {
    padding: 10px 12px;
    border-top: 1px solid #e2e8f0;
    background: #ffffff;
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    max-height: 120px;
    overflow-y: auto;
  }
  .chat-chip {
    background: #f0fdfa;
    color: var(--dark-green);
    border: 1px solid #99f6e4;
    border-radius: 20px;
    padding: 5px 12px;
    font-size: 0.75rem;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.15s ease;
  }
  .chat-chip:hover { background: #ccfbf1; }

  .chat-input-area {
    display: flex;
    gap: 8px;
    padding: 12px 14px;
    border-top: 1px solid #e2e8f0;
    background: #ffffff;
  }
  .chat-input-area input {
    flex: 1;
    border: 1px solid #cbd5e1;
    border-radius: 20px;
    padding: 9px 16px;
    font-size: 0.88rem;
    outline: none;
  }
  .chat-input-area input:focus { border-color: var(--primary-green); }
  .chat-enviar {
    background: var(--primary-green);
    color: #fff;
    border: none;
    border-radius: 50%;
    width: 38px;
    height: 38px;
    cursor: pointer;
    font-size: 1rem;
    flex-shrink: 0;
  }

  .chat-enviar:hover { background: var(--dark-green); }

  .chat-enviar:hover { background: #115e59; }

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


<div class="home-container">
  <!-- Banner Executivo Principal -->
  <div class="hero-executive text-center">
    <div class="hero-badge-municipal">
      <img src="<?= base_url('img/logo_municipalidad.png') ?>" alt="Municipalidad de General Paz" onerror="this.style.display='none'">
      <span>Municipalidad de General Paz — Gestión Municipal</span>
    </div>
    
    <h1>Plataforma de Inteligencia Territorial Rural</h1>
    <p>SIAER: Sistema de Información y Análisis de Explotaciones Rurales. Tecnología GIS avanzada para la consolidación catastral, monitoreo agroproductivo e inspecciones del Municipio de General Paz.</p>

    <div class="hero-actions">
      <a href="<?= base_url('parcelas') ?>" class="btn-executive-primary">
        <i class="fa-solid fa-map-location-dot"></i> Explorar Catastro Georreferenciado
      </a>
      <?php if (session()->get('rol') === 'admin'): ?>
        <a href="<?= base_url('dashboard') ?>" class="btn-executive-secondary">
          <i class="fa-solid fa-chart-pie"></i> Panel Ejecutivo de Control
        </a>
      <?php else: ?>
        <a href="<?= base_url('mis-parcelas') ?>" class="btn-executive-secondary">
          <i class="fa-solid fa-layer-group"></i> Consultar Mis Parcelas
        </a>
      <?php endif; ?>
    </div>
  </div>

  <!-- Tira de Indicadores Clave de Gestión (KPIs) -->
  <div class="kpi-bar">
    <div class="kpi-card">
      <div class="kpi-icon-box"><i class="fa-solid fa-draw-polygon"></i></div>
      <div class="kpi-data">
        <span>Parcelas Registradas</span>
        <h3>173</h3>
      </div>
    </div>
    <div class="kpi-card">
      <div class="kpi-icon-box"><i class="fa-solid fa-vector-square"></i></div>
      <div class="kpi-data">
        <span>Cuarteles Integrados</span>
        <h3>8</h3>
      </div>
    </div>
    <div class="kpi-card">
      <div class="kpi-icon-box"><i class="fa-solid fa-wheat-awn"></i></div>
      <div class="kpi-data">
        <span>Superficie Relevada</span>
        <h3>120.000+ ha</h3>
      </div>
    </div>
    <div class="kpi-card">
      <div class="kpi-icon-box"><i class="fa-solid fa-shield-halved"></i></div>
      <div class="kpi-data">
        <span>Estado del Sistema</span>
        <h3 style="font-size:1.15rem; color: var(--primary-green);">Operativo 100%</h3>
      </div>
    </div>
  </div>

  <!-- Pilares Institucionales de la Plataforma -->
  <div class="features-section-title">
    <i class="fa-solid fa-building-columns"></i>
    <span>Módulos de Valor Público y Gestión Territorial</span>
  </div>

  <div class="pillars-grid">
    <div class="pillar-card">
      <div class="pillar-header">
        <div class="pillar-icon"><i class="fa-solid fa-map-location-dot"></i></div>
        <h3>Visor Geográfico (GIS)</h3>
      </div>
      <p>Delimitación cartográfica precisa de cada explotación rural sobre el partido de General Paz con tecnología de capas georreferenciadas.</p>
      <ul class="pillar-list">
        <li><i class="fa-solid fa-check-double"></i> Coordenadas de alta precisión geodésica.</li>
        <li><i class="fa-solid fa-check-double"></i> Identificación inmediata por nomenclatura catastral.</li>
      </ul>
    </div>

    <div class="pillar-card">
      <div class="pillar-header">
        <div class="pillar-icon"><i class="fa-solid fa-chart-column"></i></div>
        <h3>Análisis Productivo</h3>
      </div>
      <p>Base de datos consolidada para el seguimiento de actividades agrícolas, ganaderas y mixtas desarrolladas en el distrito.</p>
      <ul class="pillar-list">
        <li><i class="fa-solid fa-check-double"></i> Categorización por tipo de explotación y superficie.</li>
        <li><i class="fa-solid fa-check-double"></i> Reportes automatizados exportables a planillas Excel.</li>
      </ul>
    </div>

    <div class="pillar-card">
      <div class="pillar-header">
        <div class="pillar-icon"><i class="fa-solid fa-user-shield"></i></div>
        <h3>Gestión Centralizada</h3>
      </div>
      <p>Matriz de permisos por roles diferenciados para Administradores, Operadores Técnicos Municipales y Productores Clientes.</p>
      <ul class="pillar-list">
        <li><i class="fa-solid fa-check-double"></i> Auditoría completa de cambios y seguridad de datos.</li>
        <li><i class="fa-solid fa-check-double"></i> Interfaz intuitiva y adaptada a dispositivos móviles.</li>
      </ul>
    </div>
  </div>

  <!-- Mapa GIS Integrado -->
  <div class="gis-box">
    <div class="gis-header">
      <h3 class="gis-title"><i class="fa-solid fa-earth-americas"></i> Cobertura Geográfica — Partido de General Paz (Ranchos)</h3>
      <span class="badge bg-success bg-opacity-10 text-success fw-bold px-3 py-2 rounded-pill">Visualización Activa</span>
    </div>
    <div id="mapa-home"></div>
  </div>
</div>

<!-- Asistente Virtual SIAER Chatbot -->
<button class="chat-fab" id="chatFab" title="Asistente de Consultas SIAER" aria-label="Abrir asistente de consultas">💬</button>

<div class="chat-ventana" id="chatVentana">
  <div class="chat-header">
    <div class="chat-titulo">
      <div class="chat-avatar">🤖</div>
      <div>
        Asistente SIAER
        <span class="chat-estado">● En línea</span>
      </div>
    </div>
    <button class="chat-cerrar" id="chatCerrar" aria-label="Cerrar chat">&times;</button>
  </div>

  <div class="chat-cuerpo" id="chatCuerpo"></div>

  <div class="chat-chips" id="chatChips"></div>

  <div class="chat-input-area">
    <input type="text" id="chatInput" placeholder="Escriba su consulta..." autocomplete="off">
    <button class="chat-enviar" id="chatEnviar" aria-label="Enviar">➤</button>
  </div>
</div>


<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js"></script>
<script>

  // Centrado Geográfico Oficial: Ranchos, Partido de General Paz

  const mapa = L.map('mapa-home').setView([-35.55, -60.45], 11);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(mapa);

  // Centrado en el Partido de General Paz (cabecera: Ranchos)

  const mapa = L.map('mapa-home').setView([-35.5164, -58.3189], 13);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; Municipalidad de General Paz — SIAER GIS'
  }).addTo(mapa);

  L.marker([-35.5164, -58.3189]).addTo(mapa)
    .bindPopup('<strong>Cabecera Municipal de General Paz</strong><br>Centro Administrativo SIAER')
    .openPopup();
</script>

<!-- Asistente Virtual de Consultas Institucionales -->
<script>
  (function () {
    const BASE_CONOCIMIENTO = [
      {
        chip: "¿Qué es el SIAER?",
        claves: ["que es", "siaer", "sistema", "sirve", "para que"],
        respuesta: "El SIAER es la Plataforma de Inteligencia Territorial de la Municipalidad de General Paz para la gestión, fiscalización y análisis georreferenciado de explotaciones rurales. 🌱"
      },
      {
        chip: "¿Cómo registrar una parcela?",
        claves: ["registrar", "registro", "nueva parcela", "cargar parcela", "crear", "agregar parcela"],
        respuesta: "Desde el panel técnico, diríjase a 'Nueva Parcela', introduzca la nomenclatura catastral, coordenadas geodésicas, superficie en hectáreas y titularidad registrada. ✅"
      },
      {
        chip: "¿Qué es la Nomenclatura Catastral?",
        claves: ["catastro", "numero de catastro", "nomenclatura"],
        respuesta: "Es la codificación alfanumérica única asignada oficialmente a cada circunscripción, sección y parcela rural dentro del Partido de General Paz. 📌"
      },
      {
        chip: "Consulta por Cuarteles Rurales",
        claves: ["cuartel", "cuarteles", "division", "zona"],
        respuesta: "El Partido de General Paz se organiza en 8 Cuarteles Rurales. El sistema permite filtrar e individualizar los indicadores agrícolas por cada uno de ellos. 📍"
      },
      {
        chip: "📞 Contacto Institucional",
        claves: ["contacto", "telefono", "direccion", "horario", "municipalidad", "ayuda", "comunicar"],
        respuesta: "Municipalidad de General Paz:<br>📍 Obdulio Hernández Castro 2858, Ranchos<br>📞 Teléfono: (02241) 47-5364<br>🕗 Horario de Atención: 07:00 a 14:00 hs"
      }
    ];

    const RESP_DEFECTO = "Disculpe, no poseo una respuesta exacta para esa consulta. Le sugerimos seleccionar una opción recomendada o contactar a la oficina técnica municipal al (02241) 47-5364.";

    const fab = document.getElementById('chatFab');
    const ventana = document.getElementById('chatVentana');
    const cerrar = document.getElementById('chatCerrar');
    const cuerpo = document.getElementById('chatCuerpo');
    const chips = document.getElementById('chatChips');
    const input = document.getElementById('chatInput');
    const enviar = document.getElementById('chatEnviar');

    let bienvenidaMostrada = false;

    function agregarMensaje(contenido, tipo) {
      const div = document.createElement('div');
      div.className = 'chat-msg ' + tipo;
      if (tipo === 'bot') {
        div.innerHTML = contenido;
      } else {
        div.textContent = contenido;
      }
      cuerpo.appendChild(div);
      cuerpo.scrollTop = cuerpo.scrollHeight;
    }

    function mostrarTyping() {
      const t = document.createElement('div');
      t.className = 'chat-typing';
      t.id = 'chatTyping';
      t.innerHTML = '<span></span><span></span><span></span>';
      cuerpo.appendChild(t);
      cuerpo.scrollTop = cuerpo.scrollHeight;
    }

    function quitarTyping() {
      const t = document.getElementById('chatTyping');
      if (t) t.remove();
    }

    function normalizar(txt) {
      return (txt || '').toString().toLowerCase()
        .normalize("NFD").replace(/[\u0300-\u036f]/g, "").trim();
    }

    function buscarRespuesta(textoUsuario) {
      const t = normalizar(textoUsuario);
      let mejor = null;
      let maxCoincidencias = 0;
      BASE_CONOCIMIENTO.forEach(item => {
        let cuenta = 0;
        item.claves.forEach(clave => {
          if (t.includes(normalizar(clave))) cuenta++;
        });
        if (cuenta > maxCoincidencias) {
          maxCoincidencias = cuenta;
          mejor = item;
        }
      });
      return maxCoincidencias > 0 ? mejor.respuesta : RESP_DEFECTO;
    }

    function responderBot(texto) {
      mostrarTyping();
      setTimeout(() => {
        quitarTyping();
        agregarMensaje(texto, 'bot');
      }, 500);
    }

    function procesarEnvio(texto) {
      const limpio = texto.trim();
      if (!limpio) return;
      agregarMensaje(limpio, 'user');
      input.value = '';
      responderBot(buscarRespuesta(limpio));
    }

    function generarChips() {
      chips.innerHTML = '';
      BASE_CONOCIMIENTO.forEach(item => {
        const chip = document.createElement('button');
        chip.className = 'chat-chip';
        chip.textContent = item.chip;
        chip.addEventListener('click', () => {
          agregarMensaje(item.chip, 'user');
          responderBot(item.respuesta);
        });
        chips.appendChild(chip);
      });
    }

    function abrirChat() {
      ventana.classList.add('abierto');
      if (!bienvenidaMostrada) {
        setTimeout(() => {
          agregarMensaje("Bienvenido al Asistente Institucional SIAER. ¿En qué podemos asesorarle respecto a la gestión de parcelas rural?", 'bot');
        }, 300);
        bienvenidaMostrada = true;
      }
      setTimeout(() => input.focus(), 300);
    }

    function cerrarChat() {
      ventana.classList.remove('abierto');
    }

    fab.addEventListener('click', () => {
      ventana.classList.contains('abierto') ? cerrarChat() : abrirChat();
    });
    cerrar.addEventListener('click', cerrarChat);
    enviar.addEventListener('click', () => procesarEnvio(input.value));
    input.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') procesarEnvio(input.value);
    });

    generarChips();
  })();
  
</script>
<?= $this->endSection() ?>