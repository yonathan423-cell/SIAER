<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= esc($titulo ?? 'Iniciar sesión') ?> - SIAER</title>
    
    <!-- SWEETALERT2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        * { box-sizing: border-box; }
        body {
            font-family: system-ui, sans-serif;
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(180deg, #dfe6f0 0%, #eef1f6 100%);
            padding: 24px;
        }
        .login-tarjeta {
            display: flex;
            width: 100%;
            max-width: 960px;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }
        .login-panel {
            flex: 1;
            background: #eef6ee;
            padding: 40px 32px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .login-panel__texto h2 {
            color: #1f3864;
            margin-bottom: 8px;
        }
        .login-panel__texto p {
            color: #555;
            line-height: 1.5;
        }
        .login-panel__ilustracion {
            margin: 24px 0;
        }
        
        /* CORRECCIÓN DEL LOGO SIN RECUADRO BLANCO */
        .login-panel__marca {
            display: flex;
            align-items: center;
        }
        .login-panel__marca img {
            max-height: 55px;
            width: auto;
            background: transparent !important;
            padding: 0 !important;
            border-radius: 0 !important;
            mix-blend-mode: multiply;
        }

        .login-form {
            flex: 1;
            padding: 40px 36px;
        }
        .login-form h1 {
            margin: 0 0 4px;
            color: #1f3864;
        }
        .login-form > p {
            color: #666;
            margin-bottom: 24px;
        }
        .login-form label {
            display: block;
            font-weight: 600;
            font-size: 0.9rem;
            color: #333;
            margin-bottom: 6px;
            margin-top: 18px;
        }
        .login-form input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
        }
        .login-form button {
            width: 100%;
            margin-top: 28px;
            padding: 12px;
            background: #1d6f42;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
        }
        .login-form button:hover { background: #185a36; }
        .login-alerta {
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }
        .login-alerta--ok { background: #e6f4ea; color: #1e7e34; }
        .login-pie {
            text-align: center;
            margin-top: 20px;
            color: #888;
            font-size: 0.85rem;
        }
        @media (max-width: 700px) {
            .login-tarjeta { flex-direction: column; }
        }
    </style>
</head>
<body>
    <div>
        <div class="login-tarjeta">
            <div class="login-panel">
                <div class="login-panel__texto">
                    <h2>Trabajamos por un General Paz más productivo y sostenible.</h2>
                    <p>Plataforma exclusiva para la gestión de explotaciones rurales del municipio.</p>
                </div>
                <div class="login-panel__ilustracion">
                    <svg viewBox="0 0 300 130" width="100%" height="auto">
                        <!-- Sol -->
                        <circle cx="255" cy="30" r="16" fill="none" stroke="#6aa84f" stroke-width="2"/>
                        <line x1="255" y1="5" x2="255" y2="12" stroke="#6aa84f" stroke-width="2"/>
                        <line x1="255" y1="48" x2="255" y2="55" stroke="#6aa84f" stroke-width="2"/>
                        <line x1="230" y1="30" x2="237" y2="30" stroke="#6aa84f" stroke-width="2"/>
                        <line x1="273" y1="30" x2="280" y2="30" stroke="#6aa84f" stroke-width="2"/>

                        <!-- Línea del campo -->
                        <polyline points="0,105 300,105" fill="none" stroke="#6aa84f" stroke-width="2"/>

                        <!-- Surcos de cultivo -->
                        <polyline points="10,105 25,95" fill="none" stroke="#6aa84f" stroke-width="1.5"/>
                        <polyline points="30,105 45,95" fill="none" stroke="#6aa84f" stroke-width="1.5"/>
                        <polyline points="50,105 65,95" fill="none" stroke="#6aa84f" stroke-width="1.5"/>
                        <polyline points="70,105 85,95" fill="none" stroke="#6aa84f" stroke-width="1.5"/>

                        <!-- Vaca (simplificada) -->
                        <g transform="translate(110,75)">
                            <ellipse cx="20" cy="18" rx="22" ry="13" fill="none" stroke="#1f3864" stroke-width="2"/>
                            <circle cx="42" cy="12" r="8" fill="none" stroke="#1f3864" stroke-width="2"/>
                            <line x1="4" y1="30" x2="4" y2="38" stroke="#1f3864" stroke-width="2"/>
                            <line x1="16" y1="31" x2="16" y2="39" stroke="#1f3864" stroke-width="2"/>
                            <line x1="28" y1="31" x2="28" y2="39" stroke="#1f3864" stroke-width="2"/>
                            <ellipse cx="16" cy="20" rx="5" ry="4" fill="#1f3864" opacity="0.15"/>
                        </g>

                        <!-- Oveja (simplificada) -->
                        <g transform="translate(190,85)">
                            <circle cx="8" cy="14" r="11" fill="none" stroke="#6aa84f" stroke-width="2"/>
                            <circle cx="15" cy="6" r="5" fill="none" stroke="#6aa84f" stroke-width="2"/>
                            <line x1="2" y1="23" x2="2" y2="29" stroke="#6aa84f" stroke-width="2"/>
                            <line x1="14" y1="24" x2="14" y2="30" stroke="#6aa84f" stroke-width="2"/>
                        </g>
                    </svg>
                </div>
                <div class="login-panel__marca">
                    <img src="<?= base_url('img/logo_municipalidad.png') ?>" alt="Municipalidad de General Paz">
                </div>
            </div>

            <div class="login-form">
                <h1>Bienvenido</h1>
                <p>Ingresá tus datos para acceder al sistema SIAER.</p>

                <!-- Alerta de éxito (mantiene su formato original si existe) -->
                <?php if (session()->getFlashdata('mensaje')): ?>
                    <p class="login-alerta login-alerta--ok"><?= esc(session()->getFlashdata('mensaje')) ?></p>
                <?php endif; ?>

                <form method="post" action="<?= base_url('login/procesar') ?>">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" placeholder="ejemplo@municipiogp.gob.ar" value="<?= esc(old('email')) ?>" required>

                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>

                    <button type="submit">Iniciar sesión</button>
                </form>
            </div>
        </div>
        <p class="login-pie">SIAER — Proyecto Integrador 2026 · Municipalidad de General Paz</p>
    </div>

    <!-- SCRIPT DE SWEETALERT2 ESTRICTO PARA ERRORES DE LOGIN -->
    <?php if (session()->getFlashdata('error')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Acceso Denegado',
            text: '<?= esc(session()->getFlashdata('error')) ?>',
            confirmButtonText: 'Reintentar',
            confirmButtonColor: '#1d6f42', // Alineado con el verde institucional de tu botón
            allowOutsideClick: false,
            allowEscapeKey: false
        });
    </script>
    <?php endif; ?>

</body>
</html>