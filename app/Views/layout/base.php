<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= esc($titulo ?? 'SIAER') ?> - Municipalidad de General Paz</title>
    <!-- Usamos base_url para que siempre apunte bien -->
    <link rel="stylesheet" href="<?= base_url('assets/css/base.css') ?>">
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