<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= esc($titulo ?? 'SIAER') ?> - Municipalidad de General Paz</title>
    <!-- Usamos base_url para que siempre apunte bien -->
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

        /* Estilos de la cabecera en tonos verdes institucionales */
        .cabecera {
            background: linear-gradient(135deg, #145c34 0%, #198754 100%);
            padding: 14px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(20, 92, 52, 0.2);
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
            color: #e2e8f0;
            border-left: 1px solid rgba(255, 255, 255, 0.3);
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
            background-color: rgba(255, 255, 255, 0.12);
        }

        .cabecera__login {
            background: #ffffff !important;
            color: #145c34 !important;
            padding: 8px 18px !important;
            border-radius: 8px !important;
            font-weight: 600 !important;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .user-badge {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 6px 12px !important;
            border-radius: 20px !important;
            color: #ffffff !important;
            font-size: 0.85rem !important;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .user-badge .user-role {
            background: #ffffff;
            color: #145c34;
            font-size: 0.7rem;
            padding: 2px 6px;
            border-radius: 10px;
            text-transform: uppercase;
            font-weight: 700;
        }

        .cabecera__logout {
            background: rgba(220, 53, 69, 0.2) !important;
            color: #ffc9c9 !important;
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

    <?= $this->renderSection('estilos') ?>
</head>
<body>
    <header class="cabecera">
        <div class="cabecera__marca">
            <strong>SIAER</strong>
            <span class="cabecera__subtitulo">Municipalidad de General Paz</span>
        </div>
        <nav class="cabecera__nav">
            <a href="<?= base_url('/') ?>">Inicio</a>
            <a href="<?= base_url('parcelas') ?>">Parcelas</a>
            <a href="<?= base_url('parcelas/crear') ?>">+ Nueva parcela</a>
            <a href="<?= base_url('login') ?>" class="cabecera__login">Iniciar sesión</a>
        </nav>
    </header>

    <?php $sidebarContenido = trim($this->renderSection('sidebar')); ?>
    <div class="layout">
        <?php if ($sidebarContenido !== ''): ?>
        <!-- Barra lateral -->
        <aside class="sidebar">
            <?= $sidebarContenido ?>
        </aside>
        <?php endif; ?>

        <!-- Contenido principal -->
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