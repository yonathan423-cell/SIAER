<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= esc($titulo ?? 'SIAER') ?> - Municipalidad de General Paz</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/base.css') ?>">
    <style>
        /* Estilos de la cabecera */
        .cabecera {
            background: linear-gradient(135deg, #1f3864 0%, #162848 100%);
            padding: 14px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .cabecera__marca {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none !important;
            color: #ffffff;
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
            gap: 12px;
        }

        .cabecera__nav a {
            color: #e2e8f0;
            text-decoration: none !important;
            font-size: 0.92rem;
            font-weight: 500;
            padding: 8px 14px;
            border-radius: 6px;
            position: relative;
            transition: color 0.3s ease, background-color 0.3s ease;
            display: inline-flex;
            align-items: center;
        }

        /* Línea verde animada en hover para enlaces comunes */
        .cabecera__nav a:not(.cabecera__login):not(.cabecera__logout):not(.user-badge)::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2.5px;
            bottom: 2px;
            left: 50%;
            background-color: #28a745;
            transition: all 0.3s ease;
            transform: translateX(-50%);
            border-radius: 2px;
        }

        .cabecera__nav a:not(.cabecera__login):not(.cabecera__logout):not(.user-badge):hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.06);
        }

        .cabecera__nav a:not(.cabecera__login):not(.cabecera__logout):not(.user-badge):hover::after {
            width: 75%;
        }

        /* Botón de Iniciar Sesión */
        .cabecera__login {
            background: linear-gradient(135deg, #1d6f42 0%, #185a36 100%) !important;
            color: #ffffff !important;
            padding: 8px 18px !important;
            border-radius: 8px !important;
            font-weight: 600 !important;
            box-shadow: 0 4px 10px rgba(29, 111, 66, 0.3);
            transition: all 0.3s ease !important;
            margin-left: 6px;
        }

        .cabecera__login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(29, 111, 66, 0.45);
        }

        /* Insignia / Info del Usuario Conectado */
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

        /* Botón de Salir */
        .cabecera__logout {
            background: rgba(220, 53, 69, 0.15) !important;
            color: #ff8b8b !important;
            border: 1px solid rgba(220, 53, 69, 0.4) !important;
            padding: 6px 12px !important;
            border-radius: 6px !important;
            font-size: 0.85rem !important;
            transition: all 0.3s ease !important;
        }

        .cabecera__logout:hover {
            background: #dc3545 !important;
            color: #ffffff !important;
        }
    </style>
    <?= $this->renderSection('estilos') ?>
</head>
<body>
    <header class="cabecera">
        <a href="<?= base_url('/') ?>" class="cabecera__marca">
            <strong>SIAER</strong>
            <span class="cabecera__subtitulo">Municipalidad de General Paz</span>
        </a>
        <nav class="cabecera__nav">

            <?php if (session()->get('isLoggedIn')): ?>
                <?php $rolSession = strtolower(session()->get('rol') ?? ''); ?>

                <!-- Módulos para ADMIN y OPERADOR -->
                <?php if (in_array($rolSession, ['admin', 'operador'])): ?>
                    <a href="<?= base_url('parcelas') ?>">🗺️ Mapa</a>
                    <a href="<?= base_url('parcelas/crear') ?>">+ Nueva parcela</a>
                <?php endif; ?>

                <!-- Módulos exclusivos de ADMIN -->
                <?php if ($rolSession === 'admin'): ?>
                    <a href="<?= base_url('dashboard') ?>">📊 Dashboard</a>
                    <a href="<?= base_url('usuarios') ?>">👥 Usuarios</a>
                <?php endif; ?>

                <!-- Módulo exclusivo de CLIENTE -->
                <?php if ($rolSession === 'cliente'): ?>
                    <a href="<?= base_url('mis-parcelas') ?>">📌 Mis Parcelas</a>
                    <a href="<?= base_url('parcelas') ?>">🗺️ Mapa</a>
                <?php endif; ?>

                <!-- Insignia del usuario logueado -->
                <div class="user-badge">
                    👤 <strong><?= esc(session()->get('usuario')) ?></strong>
                    <?php if (session()->get('rol')): ?>
                        <span class="user-role"><?= esc(session()->get('rol')) ?></span>
                    <?php endif; ?>
                </div>

                <a href="<?= base_url('logout') ?>" class="cabecera__logout">🚪 Salir</a>

            <?php else: ?>
                <!-- Estado sin sesión activa -->
                <a href="<?= base_url('login') ?>" class="cabecera__login">Iniciar sesión</a>
            <?php endif; ?>
        </nav>
    </header>

    <?php $sidebarContenido = trim($this->renderSection('sidebar')); ?>
    <div class="layout">
        <?php if ($sidebarContenido !== ''): ?>
        <aside class="sidebar">
            <?= $sidebarContenido ?>
        </aside>
        <?php endif; ?>

        <main class="contenido">
            <?php if (session()->getFlashdata('mensaje')): ?>
                <p class="alerta alerta--ok"><?= esc(session()->getFlashdata('mensaje')) ?></p>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <p class="alerta alerta--error"><?= esc(session()->getFlashdata('error')) ?></p>
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