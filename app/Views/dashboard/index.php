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
  }

  .badge-rol {
    background: #1d6f42;
    color: #ffffff;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
  }

  .dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 22px;
  }

  .card-modulo {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 24px;
    text-decoration: none;
    color: #2d3748;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
  }

  .card-modulo h3 {
    margin: 0 0 8px;
    color: #1f3864;
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

<?= $this->endSection() ?>