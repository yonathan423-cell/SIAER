<?= $this->extend('layout/base') ?>

<?= $this->section('estilos') ?>
<style>
  .dashboard-header {
    background: linear-gradient(135deg, #1f3864 0%, #162848 100%);
    color: #fff;
    padding: 28px 32px;
    border-radius: 14px;
    margin-bottom: 28px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 10px 25px -5px rgba(31, 56, 100, 0.2);
  }

  .dashboard-header p {
    margin: 4px 0 0 0;
    color: #cbd5e1;
    font-size: 0.95rem;
  }

  .badge-rol {
    background: #1d6f42;
    color: #ffffff;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
  }

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
    text-decoration: none;
    color: #2d3748;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    display: flex;
    flex-direction: column;
    gap: 6px;
  }

  .card-modulo:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.06);
    border-color: #94a3b8;
  }

  .card-modulo h3 {
    margin: 0 0 4px;
    color: #1f3864;
    font-size: 1.1rem;
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

  /* Estadísticas del Sistema (Integradas abajo) */
  .stats-section-title {
    font-size: 1.15rem;
    font-weight: 800;
    color: #1f3864;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 18px;
  }

  .stat-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 18px 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.02);
  }

  .stat-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    background: #f1f5f9;
    color: #1f3864;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
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
    color: #1f3864;
    margin: 2px 0 0 0;
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>

<div class="dashboard-header">
  <div>
    <h1>Panel de Control</h1>
    <p>Bienvenido, <strong><?= esc($usuario) ?></strong>.</p>
  </div>
  <span class="badge-rol">Rol: <?= esc($rol ?? 'Operador') ?></span>
</div>

<div class="dashboard-grid">
  <a href="<?= base_url('parcelas') ?>" class="card-modulo">
    <h3>📋 Listado de Parcelas</h3>
    <p>Consultar la información georreferenciada e inspecciones.</p>
  </a>

  <a href="<?= base_url('parcelas/crear') ?>" class="card-modulo">
    <h3>➕ Nueva Parcela</h3>
    <p>Registrar y dar de alta una nueva explotación rural.</p>
  </a>

  <?php if (isset($rol) && strtolower($rol) === 'admin'): ?>
    <a href="<?= base_url('usuarios') ?>" class="card-modulo">
      <h3>👥 Gestión de Usuarios</h3>
      <p>Administrar cuentas, contraseñas y permisos de acceso.</p>
    </a>
  <?php endif; ?>
</div>

<!-- Control General y Base de Datos -->
<div>
  <div class="stats-section-title">📊 Estado General del Sistema y Base de Datos</div>
  
  <div class="stats-grid">
      <div class="stat-card">
          <div class="stat-icon">🌾</div>
          <div class="stat-info">
              <span>Parcelas Registradas</span>
              <h4><?= esc($total_parcelas ?? 0) ?></h4>
          </div>
      </div>

      <div class="stat-card">
          <div class="stat-icon">👥</div>
          <div class="stat-info">
              <span>Usuarios Activos</span>
              <h4><?= esc($total_usuarios ?? 0) ?></h4>
          </div>
      </div>

      <div class="stat-card">
          <div class="stat-icon">🗂️</div>
          <div class="stat-info">
              <span>Cuarteles Habilitados</span>
              <h4>8</h4>
          </div>
      </div>

      <div class="stat-card">
          <div class="stat-icon">🟢</div>
          <div class="stat-info">
              <span>Base de Datos</span>
              <h4 style="font-size: 1rem; color: #1d6f42; margin-top: 4px;">Conectada</h4>
          </div>
      </div>
  </div>
</div>

<?= $this->endSection() ?>