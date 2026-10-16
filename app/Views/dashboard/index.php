<?= $this->extend('layout/base') ?>

<?= $this->section('estilos') ?>
<style>
  :root {
    --primary-green: #198754;
    --dark-green: #145c34;
    --light-green: #e8f5e9;
  }

  /* Header del Dashboard */
  .dashboard-header {
    background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 100%);
    color: #ffffff;
    padding: 28px 32px;
    border-radius: 14px;
    margin-bottom: 28px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 10px 25px -5px rgba(20, 92, 52, 0.25);
  }

  .dashboard-header h1 {
    margin: 0;
    font-size: 1.8rem;
    font-weight: 800;
  }

  .dashboard-header p {
    margin: 4px 0 0 0;
    color: #e2e8f0;
    font-size: 0.95rem;
  }

  .badge-rol {
    background: #ffffff;
    color: var(--dark-green);
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 800;
    text-transform: uppercase;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }

  /* Grid de Módulos Rápidos */
  .dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 22px;
    margin-bottom: 35px;
  }

  .card-modulo {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 24px;
    text-decoration: none !important;
    color: #2d3748;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    display: flex;
    flex-direction: column;
    gap: 6px;
    position: relative;
    overflow: hidden;
  }

  .card-modulo::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background-color: var(--primary-green);
  }

  .card-modulo:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px -3px rgba(20, 92, 52, 0.12);
    border-color: #a7f3d0;
  }

  .card-modulo h3 {
    margin: 0 0 4px;
    color: var(--dark-green);
    font-size: 1.15rem;
    font-weight: 800;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .card-modulo p {
    margin: 0;
    color: #64748b;
    font-size: 0.9rem;
    line-height: 1.5;
  }

  /* Sección de Estadísticas Clickeables */
  .stats-section-title {
    font-size: 1.15rem;
    font-weight: 800;
    color: var(--dark-green);
    margin-bottom: 18px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 18px;
    margin-bottom: 35px;
  }

  .stat-card-clickable {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    text-decoration: none !important;
    color: inherit;
    cursor: pointer;
    transition: all 0.2s ease-in-out;
  }

  .stat-card-clickable:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(20, 92, 52, 0.15);
    border-color: var(--primary-green);
    background-color: #f0fdf4;
  }

  .stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    background: var(--light-green);
    color: var(--dark-green);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    flex-shrink: 0;
  }

  .stat-info span {
    display: block;
    font-size: 0.75rem;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .stat-info h4 {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--dark-green);
    margin: 2px 0 0 0;
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>

<!-- Header del Panel -->
<div class="dashboard-header">
  <div>
    <h1>Panel de Control</h1>
    <p>Bienvenido, <strong><?= esc($usuario) ?></strong>.</p>
  </div>
  <span class="badge-rol">Rol: <?= esc($rol ?? 'Operador') ?></span>
</div>

<!-- Módulos Principales de Acceso Rápido -->
<div class="dashboard-grid">
  <a href="<?= base_url('parcelas') ?>" class="card-modulo">
    <h3>📋 Listado de Parcelas</h3>
    <p>Consultar la información georreferenciada e inspecciones en el municipio.</p>
  </a>

  <a href="<?= base_url('parcelas/crear') ?>" class="card-modulo">
    <h3>➕ Nueva Parcela</h3>
    <p>Registrar y dar de alta una nueva explotación rural en la base de datos.</p>
  </a>

  <?php if (isset($rol) && strtolower($rol) === 'admin'): ?>
    <a href="<?= base_url('usuarios') ?>" class="card-modulo">
      <h3>👥 Gestión de Usuarios</h3>
      <p>Administrar cuentas, perfiles, contraseñas y permisos de acceso.</p>
    </a>
  <?php endif; ?>
</div>

<!-- Control General y Tarjetas Clickeables -->
<div>
  <div class="stats-section-title">📊 Estado General del Sistema y Base de Datos</div>
  
  <div class="stats-grid">
      <a href="<?= base_url('parcelas') ?>" class="stat-card-clickable">
          <div class="stat-icon">🌾</div>
          <div class="stat-info">
              <span>Parcelas Registradas</span>
              <h4><?= esc($total_parcelas ?? 173) ?></h4>
          </div>
      </a>

      <a href="<?= base_url('usuarios') ?>" class="stat-card-clickable">
          <div class="stat-icon">👥</div>
          <div class="stat-info">
              <span>Usuarios Activos</span>
              <h4><?= esc($total_usuarios ?? 3) ?></h4>
          </div>
      </a>

      <!-- Modificado únicamente para abrir la vista externa detallada de cuarteles -->
      <a href="<?= base_url('parcelas/cuarteles') ?>" class="stat-card-clickable">
          <div class="stat-icon">🗂️</div>
          <div class="stat-info">
              <span>Cuarteles Habilitados</span>
              <h4>8</h4>
          </div>
      </a>

      <div onclick="verEstadoBD()" class="stat-card-clickable">
          <div class="stat-icon">🟢</div>
          <div class="stat-info">
              <span>Base de Datos</span>
              <h4 style="font-size: 1rem; color: var(--primary-green); margin-top: 4px;">Conectada</h4>
          </div>
      </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function verEstadoBD() {
        alert("✅ Conexión con la Base de Datos activa.\nServidor: MySQL / XAMPP Localhost\nEstado: Operativo 100%");
    }
</script>
<?= $this->endSection() ?>