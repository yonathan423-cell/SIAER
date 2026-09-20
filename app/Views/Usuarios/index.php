<?= $this->extend('layout/base') ?>

<?= $this->section('estilos') ?>
<style>
  .user-container {
    padding: 10px 0;
  }
  
  .user-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 16px;
  }

  .user-title {
    font-size: 1.6rem;
    color: #1f3864;
    font-weight: 700;
    margin: 0;
  }

  /* Barra de herramientas (Buscador + Botón) */
  .toolbar {
    display: flex;
    gap: 12px;
    align-items: center;
    width: 100%;
    max-width: 500px;
  }

  .search-input {
    flex: 1;
    padding: 10px 16px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    font-size: 0.9rem;
    outline: none;
    transition: all 0.2s;
    background: white;
  }

  .search-input:focus {
    border-color: #1f3864;
    box-shadow: 0 0 0 3px rgba(31, 56, 100, 0.15);
  }

  .btn-primary-custom {
    background: #1f3864;
    color: white;
    padding: 10px 18px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    border: none;
    cursor: pointer;
    transition: background 0.2s;
    white-space: nowrap;
  }

  .btn-primary-custom:hover {
    background: #162848;
  }

  /* Tabla Estilizada */
  .table-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    border: 1px solid #e2e8f0;
    overflow: hidden;
  }

  .custom-table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
  }

  .custom-table th {
    background: #1f3864;
    color: white;
    padding: 14px 18px;
    font-weight: 600;
    font-size: 0.9rem;
  }

  .custom-table td {
    padding: 14px 18px;
    border-bottom: 1px solid #f1f5f9;
    color: #334155;
    font-size: 0.92rem;
    vertical-align: middle;
  }

  .custom-table tr:hover {
    background-color: #f8fafc;
  }

  /* Badges de Roles Estáticos y Modernos */
  .role-badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.5px;
    display: inline-block;
    text-transform: uppercase;
  }

  .role-admin { background-color: #e0e7ff; color: #3730a3; border: 1px solid #c7d2fe; }
  .role-operador { background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
  .role-cliente { background-color: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }

  /* Botones de Acción (Editar con Lápiz y Eliminar) */
  .actions-container {
    display: flex;
    gap: 8px;
    justify-content: flex-end;
  }

  .btn-edit {
    color: #1e40af;
    background: #dbeafe;
    padding: 6px 12px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 4px;
  }

  .btn-edit:hover {
    background: #bfdbfe;
    color: #1e3a8a;
  }

  .btn-delete {
    color: #ef4444;
    background: #fee2e2;
    padding: 6px 12px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 4px;
  }

  .btn-delete:hover {
    background: #fca5a5;
    color: #991b1b;
  }

  /* Modales */
  .modal-overlay {
    position: fixed;
    top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0,0,0,0.4);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 1000;
  }

  .modal-box {
    background: white;
    padding: 28px;
    border-radius: 14px;
    width: 100%;
    max-width: 420px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
  }

  .form-group {
    margin-bottom: 16px;
  }

  .form-group label {
    display: block;
    margin-bottom: 6px;
    font-size: 0.85rem;
    color: #475569;
    font-weight: 600;
  }

  .form-group input, .form-group select {
    width: 100%;
    padding: 10px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    font-size: 0.9rem;
    box-sizing: border-box;
    background: #fff;
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>

<div class="user-container">
  <div class="user-header">
    <h2 class="user-title">👥 Gestión de Usuarios</h2>
    
    <div class="toolbar">
      <input type="text" id="buscador" class="search-input" placeholder="🔍 Buscar por nombre, email o rol..." onkeyup="filtrarTabla()">
      <button onclick="abrirModalCrear()" class="btn-primary-custom">➕ Nuevo Usuario</button>
    </div>
  </div>

  <?php if (session()->getFlashdata('mensaje')): ?>
    <div style="background: #dcfce7; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-weight: 500;">
      <?= session()->getFlashdata('mensaje') ?>
    </div>
  <?php endif; ?>

  <div class="table-card">
    <table class="custom-table" id="tablaUsuarios">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Email</th>
          <th>Rol Asignado</th>
          <th style="text-align: right;">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($usuarios)): ?>
          <?php foreach ($usuarios as $u): ?>
            <?php 
              $rolClean = strtolower(trim($u['rol'] ?? 'operador')); 
              $classRol = 'role-' . $rolClean;
              $nombreUser = $u['nombre'] ?? $u['usuario'] ?? '';
            ?>
            <tr>
              <td><strong>#<?= $u['id'] ?></strong></td>
              <td><?= esc($nombreUser) ?></td>
              <td><?= esc($u['email'] ?? '-') ?></td>
              <td>
                <span class="role-badge <?= $classRol ?>"><?= strtoupper($rolClean) ?></span>
              </td>
              <td style="text-align: right;">
                <div class="actions-container">
                    <!-- Botón Lápiz para abrir el modal de edición rápida -->
                    <button type="button" class="btn-edit" onclick="abrirModalEditar(<?= $u['id'] ?>, '<?= esc($nombreUser, 'js') ?>', '<?= esc($u['email'] ?? '', 'js') ?>', '<?= $rolClean ?>')">
                        ✏️ Editar
                    </button>

                    <a href="<?= base_url('usuarios/eliminar/' . $u['id']) ?>" 
                       onclick="return confirm('¿Confirmas que deseas eliminar el usuario <?= esc($nombreUser, 'js') ?>?')" 
                       class="btn-delete">🗑️ Eliminar</a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="5" style="text-align: center; color: #94a3b8; padding: 24px;">No hay usuarios registrados.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal para Crear Usuario -->
<div class="modal-overlay" id="modalCrear">
  <div class="modal-box">
    <h3 style="margin-top:0; color:#1f3864;">Nuevo Usuario</h3>
    <form action="<?= base_url('usuarios/guardar') ?>" method="POST">
      <div class="form-group">
        <label>Nombre Completo</label>
        <input type="text" name="nombre" required placeholder="Ej: Juan Pérez">
      </div>
      <div class="form-group">
        <label>Correo Electrónico</label>
        <input type="email" name="email" required placeholder="ejemplo@municipiogp.gob.ar">
      </div>
      <div class="form-group">
        <label>Contraseña</label>
        <input type="password" name="password" required placeholder="******">
      </div>
      <div class="form-group">
        <label>Rol asignado</label>
        <select name="rol" required>
          <option value="operador">Operador</option>
          <option value="admin">Administrador</option>
          <option value="cliente">Cliente</option>
        </select>
      </div>
      <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:20px;">
        <button type="button" onclick="cerrarModales()" style="background:#e2e8f0; border:none; padding:10px 16px; border-radius:8px; cursor:pointer; font-weight:600;">Cancelar</button>
        <button type="submit" class="btn-primary-custom">Guardar Usuario</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal para Editar Usuario (Se abre con el lápiz) -->
<div class="modal-overlay" id="modalEditar">
  <div class="modal-box">
    <h3 style="margin-top:0; color:#1f3864;">✏️ Modificar Usuario y Rol</h3>
    <!-- Apuntalo a tu ruta de actualizar, por ejemplo usuarios/actualizar o usuarios/modificar -->
    <form id="formEditar" action="<?= base_url('usuarios/actualizar') ?>" method="POST">
      <input type="hidden" name="id" id="edit_id">
      
      <div class="form-group">
        <label>Nombre Completo</label>
        <input type="text" name="nombre" id="edit_nombre" required>
      </div>
      <div class="form-group">
        <label>Correo Electrónico</label>
        <input type="email" name="email" id="edit_email" required>
      </div>
      <div class="form-group">
        <label>Rol asignado</label>
        <select name="rol" id="edit_rol" required>
          <option value="admin">Administrador</option>
          <option value="operador">Operador</option>
          <option value="cliente">Cliente</option>
        </select>
      </div>
      <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:20px;">
        <button type="button" onclick="cerrarModales()" style="background:#e2e8f0; border:none; padding:10px 16px; border-radius:8px; cursor:pointer; font-weight:600;">Cancelar</button>
        <button type="submit" class="btn-primary-custom">Actualizar Cambios</button>
      </div>
    </form>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  // Filtro dinámico en tiempo real
  function filtrarTabla() {
    const input = document.getElementById('buscador').value.toLowerCase();
    const filas = document.querySelectorAll('#tablaUsuarios tbody tr');

    filas.forEach(fila => {
      const texto = fila.innerText.toLowerCase();
      fila.style.display = texto.includes(input) ? '' : 'none';
    });
  }

  // Modales
  function abrirModalCrear() {
    document.getElementById('modalCrear').style.display = 'flex';
  }

  function abrirModalEditar(id, nombre, email, rol) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_nombre').value = nombre;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_rol').value = rol;
    document.getElementById('modalEditar').style.display = 'flex';
  }

  function cerrarModales() {
    document.getElementById('modalCrear').style.display = 'none';
    document.getElementById('modalEditar').style.display = 'none';
  }
</script>
<?= $this->endSection() ?>