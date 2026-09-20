<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= esc($titulo ?? 'SIAER') ?> - Municipalidad de General Paz</title>
<<<<<<< HEAD
    <!-- Usamos base_url para que siempre apunte bien -->
    <link rel="stylesheet" href="<?= base_url('assets/css/base.css') ?>">
=======
    <link rel="stylesheet" href="<?= base_url('assets/css/base.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/parcelas.css') ?>">
    <style>
        /* Estilos generales para estirar y modernizar el layout fluido */
        body {
            margin: 0;
            background-color: #f8fafc;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            color: #1e293b;
        }

        /* Estilos de la cabecera optimizados para ancho completo */
        .cabecera {
            background: linear-gradient(135deg, #1f3864 0%, #162848 100%);
            padding: 14px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
            width: 100%;
            box-sizing: border-box;
        }

        .cabecera__marca {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none !important;
            color: #ffffff;
            cursor: pointer;
            transition: opacity 0.2s ease, transform 0.2s ease;
        }

        .cabecera__marca:hover {
            text-decoration: none !important;
            color: #ffffff;
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .cabecera__marca strong {
            font-size: 1.4rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            color: #ffffff;
        }

        .cabecera__subtitulo {
            font-size: 0.85rem;
            color: #a0aec0;
            border-left: 1px solid rgba(255, 255, 255, 0.2);
            padding-left: 12px;
            font-weight: 400;
        }

        .cabecera__nav {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cabecera__nav a {
            color: #e2e8f0;
            text-decoration: none !important;
            font-size: 0.9rem;
            font-weight: 500;
            padding: 8px 14px;
            border-radius: 6px;
            position: relative;
            transition: color 0.3s ease, background-color 0.3s ease;
            display: inline-flex;
            align-items: center;
        }

        .cabecera__nav a:not(.cabecera__login):not(.cabecera__logout):not(.user-badge):hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.08);
        }

        .cabecera__login {
            background: linear-gradient(135deg, #1d6f42 0%, #185a36 100%) !important;
            color: #ffffff !important;
            padding: 8px 18px !important;
            border-radius: 8px !important;
            font-weight: 600 !important;
            box-shadow: 0 4px 10px rgba(29, 111, 66, 0.3);
        }

        .user-badge {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 6px 12px !important;
            border-radius: 20px !important;
            color: #ffffff !important;
            font-size: 0.85rem !important;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .user-badge .user-role {
            background: #28a745;
            color: #fff;
            font-size: 0.7rem;
            padding: 2px 6px;
            border-radius: 10px;
            text-transform: uppercase;
            font-weight: 700;
        }

        .cabecera__logout {
            background: rgba(220, 53, 69, 0.15) !important;
            color: #ff8b8b !important;
            border: 1px solid rgba(220, 53, 69, 0.4) !important;
            padding: 6px 12px !important;
            border-radius: 6px !important;
        }

        .cabecera__logout:hover {
            background: #dc3545 !important;
            color: #ffffff !important;
        }

        /* Contenedor fluido de pantalla completa (Estirado al 100%) */
        .layout {
            display: flex;
            min-height: calc(100vh - 130px);
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box;
        }

        .sidebar {
            width: 260px;
            background: #ffffff;
            border-right: 1px solid #e2e8f0;
            padding: 24px;
            box-sizing: border-box;
            flex-shrink: 0;
        }

        .contenido {
            flex: 1;
            padding: 24px 32px;
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box;
            background-color: #f8fafc;
        }

        .pie {
            background: #ffffff;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            padding: 15px;
            font-size: 0.85rem;
            color: #64748b;
        }

        /* Alertas limpias */
        .alerta {
            padding: 12px 18px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
        }
        .alerta--ok { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .alerta--error { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
    </style>
>>>>>>> login
    <?= $this->renderSection('estilos') ?>
</head>
<body>
    <header class="cabecera">
<<<<<<< HEAD
        <div class="cabecera__marca">
            <strong>SIAER</strong>
            <span class="cabecera__subtitulo">Municipalidad de General Paz</span>
        </div>
        <nav class="cabecera__nav">
            <a href="<?= base_url('/') ?>">Inicio</a>
            <a href="<?= base_url('parcelas') ?>">Parcelas</a>
            <a href="<?= base_url('parcelas/crear') ?>">+ Nueva parcela</a>
            <a href="<?= base_url('login') ?>" class="cabecera__login">Iniciar sesión</a>
=======
        <a href="<?= base_url('/') ?>" class="cabecera__marca" title="Volver al inicio" aria-label="Volver al inicio de SIAER">
            <strong>SIAER</strong>
            <span class="cabecera__subtitulo">Municipalidad de General Paz</span>
        </a>
        <nav class="cabecera__nav">

            <?php if (session()->get('isLoggedIn')): ?>
                <?php $rolSession = strtolower(session()->get('rol') ?? ''); ?>

                <?php if (in_array($rolSession, ['admin', 'operador'])): ?>
                    <a href="<?= base_url('parcelas') ?>">🗺️ Mapa</a>
                    <a href="<?= base_url('parcelas/crear') ?>">+ Nueva parcela</a>
                <?php endif; ?>

                <?php if ($rolSession === 'admin'): ?>
                    <a href="<?= base_url('dashboard') ?>">📊 Dashboard</a>
                    <a href="<?= base_url('usuarios') ?>">👥 Usuarios</a>
                <?php endif; ?>

                <?php if ($rolSession === 'cliente'): ?>
                    <a href="<?= base_url('mis-parcelas') ?>">📌 Mis Parcelas</a>
                    <a href="<?= base_url('parcelas') ?>">🗺️ Mapa</a>
                <?php endif; ?>

                <div class="user-badge">
                    👤 <strong><?= esc(session()->get('usuario')) ?></strong>
                    <?php if (session()->get('rol')): ?>
                        <span class="user-role"><?= esc(session()->get('rol')) ?></span>
                    <?php endif; ?>
                </div>

                <a href="<?= base_url('logout') ?>" class="cabecera__logout">🚪 Salir</a>

            <?php else: ?>
                <a href="<?= base_url('login') ?>" class="cabecera__login">Iniciar sesión</a>
            <?php endif; ?>
>>>>>>> login
        </nav>
    </header>

    <?php $sidebarContenido = trim($this->renderSection('sidebar')); ?>
    <div class="layout">
        <?php if ($sidebarContenido !== ''): ?>
<<<<<<< HEAD
        <!-- Barra lateral -->
=======
>>>>>>> login
        <aside class="sidebar">
            <?= $sidebarContenido ?>
        </aside>
        <?php endif; ?>

<<<<<<< HEAD
        <!-- Contenido principal -->
        <main class="contenido">
            <?php if (session()->getFlashdata('mensaje')): ?>
                <p class="alerta alerta--ok"><?= esc(session()->getFlashdata('mensaje')) ?></p>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <p class="alerta alerta--error"><?= esc(session()->getFlashdata('error')) ?></p>
=======
        <main class="contenido">
            <?php if (session()->getFlashdata('mensaje')): ?>
                <div class="alerta alerta--ok"><?= esc(session()->getFlashdata('mensaje')) ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alerta alerta--error"><?= esc(session()->getFlashdata('error')) ?></div>
>>>>>>> login
            <?php endif; ?>

            <?= $this->renderSection('contenido') ?>
        </main>
    </div>

    <footer class="pie">
        <p>SIAER — Proyecto Integrador 2026</p>
    </footer>

    <?= $this->renderSection('scripts') ?>
</body>
</html>