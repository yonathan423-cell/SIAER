<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($titulo ?? 'Iniciar sesión') ?> - Portal General Paz</title>
    
    <!-- FontAwesome para los íconos de inputs -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- SWEETALERT2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: #f3f5f8;
            padding: 24px;
        }

        .login-tarjeta {
            display: flex;
            width: 100%;
            max-width: 860px;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
            border: 1px solid #e2e8f0;
        }

        /* BANNER IZQUIERDO (INSTITUCIONAL CON FONDO VERDE CLARO) */
        .login-panel {
            flex: 1;
            background-color: #eaf6ec;
            padding: 36px 32px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-right: 1px solid #e1efe3;
        }

        .login-panel__marca {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #0b2e63;
            font-weight: 800;
            font-size: 1.1rem;
            line-height: 1.1;
            transition: opacity 0.2s ease;
        }

        .login-panel__marca:hover {
            opacity: 0.85;
        }

        .login-panel__marca-logo {
            width: 38px;
            height: 38px;
            background-color: #0088fe;
            clip-path: polygon(25% 0%, 75% 0%, 100% 50%, 75% 100%, 25% 100%, 0% 50%);
            display: inline-block;
        }

        .login-panel__texto {
            margin-top: 28px;
        }

        .login-panel__texto p {
            color: #1d3254;
            font-weight: 700;
            font-size: 0.98rem;
            line-height: 1.45;
            margin: 0;
        }

        .login-panel__texto span.highlight {
            color: #008837;
        }

        .login-panel__ilustracion {
            margin: 15px 0;
            text-align: center;
        }

        .login-panel__footer-sub {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #0b2e63;
            font-weight: 800;
            font-size: 0.85rem;
        }

        /* COLUMNA DERECHA (FORMULARIO) */
        .login-form-container {
            flex: 1.1;
            padding: 36px 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background-color: #ffffff;
        }

        /* Pestañas Iniciar Sesión / Registrarse */
        .login-tabs {
            display: flex;
            border-bottom: 2px solid #edf2f7;
            margin-bottom: 28px;
        }

        .login-tab-btn {
            flex: 1;
            text-align: center;
            background: none;
            border: none;
            padding-bottom: 12px;
            font-size: 0.95rem;
            font-weight: 700;
            color: #1d3254;
            cursor: pointer;
            position: relative;
            text-decoration: none;
        }

        .login-tab-btn.active {
            color: #008837;
        }

        .login-tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 10%;
            width: 80%;
            height: 3px;
            background-color: #008837;
            border-radius: 3px 3px 0 0;
        }

        .login-form h1 {
            margin: 0 0 6px;
            color: #0b2e63;
            font-size: 1.5rem;
            font-weight: 800;
        }

        .login-form .subtitulo {
            color: #3b5998;
            font-size: 0.85rem;
            margin-bottom: 22px;
            line-height: 1.4;
            font-weight: 500;
        }

        .login-form label {
            display: block;
            font-weight: 700;
            font-size: 0.82rem;
            color: #0b2e63;
            margin-bottom: 6px;
            margin-top: 14px;
        }

        /* Wrapper para inputs con ícono */
        .input-icon-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon-wrapper input, .input-icon-wrapper select {
            width: 100%;
            padding: 10px 38px 10px 12px;
            border: 1px solid #cbd5e0;
            border-radius: 8px;
            font-size: 0.9rem;
            outline: none;
            transition: border-color 0.2s;
            background-color: #ffffff;
        }

        .input-icon-wrapper input:focus, .input-icon-wrapper select:focus {
            border-color: #008837;
            box-shadow: 0 0 0 3px rgba(0, 136, 55, 0.12);
        }

        .input-icon-wrapper .input-icon {
            position: absolute;
            right: 12px;
            color: #008837;
            font-size: 0.9rem;
            pointer-events: none;
        }

        .forgot-pass {
            display: block;
            text-align: right;
            font-size: 0.78rem;
            color: #008837;
            font-weight: 600;
            text-decoration: none;
            margin-top: 8px;
            margin-bottom: 24px;
        }

        .forgot-pass:hover {
            text-decoration: underline;
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            background: #008837;
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .btn-submit:hover {
            background: #006e2c;
        }

        .login-alerta {
            padding: 10px 14px;
            border-radius: 6px;
            margin-bottom: 12px;
            font-size: 0.85rem;
        }

        .login-alerta--ok {
            background: #e6f4ea;
            color: #1e7e34;
            border: 1px solid #c3e6cb;
        }

        .login-pie {
            text-align: center;
            margin-top: 18px;
            color: #3b5998;
            font-size: 0.78rem;
            display: flex;
            gap: 12px;
            justify-content: center;
            font-weight: 600;
        }

        .login-pie span.dot {
            color: #008837;
        }

        @media (max-width: 730px) {
            .login-tarjeta {
                flex-direction: column;
            }
            .login-panel {
                border-right: none;
                border-bottom: 1px solid #edf2f7;
            }
        }
    </style>
</head>
<body>

    <?php 
        // Determinar el destino del Home según la sesión o rol del usuario
        $rolUsuario = session()->get('rol');
        $homeUrl = base_url('login'); // Por defecto va a login si no hay sesión

        if ($rolUsuario === 'admin') {
            $homeUrl = base_url('admin/dashboard');
        } elseif ($rolUsuario === 'operador') {
            $homeUrl = base_url('operador/dashboard');
        } elseif ($rolUsuario === 'usuario') {
            $homeUrl = base_url('inicio');
        }
    ?>

    <div class="login-tarjeta">
        
        <!-- PANEL IZQUIERDO INSTITUCIONAL -->
        <div class="login-panel">
            <div>
                <!-- Enlace al home del rol si tiene sesión activa -->
                <a href="<?= $homeUrl ?>" class="login-panel__marca" title="Ir al Inicio">
                    <img src="<?= base_url('img/logo_municipalidad.png') ?>" alt="Municipalidad General Paz" style="max-height: 48px; width: auto;" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div style="display:none; align-items:center; gap:8px;">
                        <span class="login-panel__marca-logo"></span>
                        <div>Municipalidad<br>General Paz</div>
                    </div>
                </a>
                <div class="login-panel__texto">
                    <p>Plataforma exclusiva para la gestión <span class="highlight">de producción y ambiente del Municipio de General Paz.</span></p>
                    <div style="width:35px; height:3px; background-color:#008837; margin-top:10px; border-radius:2px;"></div>
                </div>
            </div>

            <!-- ILUSTRACIÓN DEL MOLINO RURAL (DETALLADO) -->
            <div class="login-panel__ilustracion">
                <svg viewBox="0 0 240 160" width="100%" height="auto" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Colina / Suelo -->
                    <path d="M 5 135 Q 80 120, 160 132 T 235 135" stroke="#008837" stroke-width="1.8" fill="none" stroke-linecap="round"/>
                    <path d="M 120 132 C 140 138, 170 142, 200 138" stroke="#008837" stroke-width="1.2" fill="none"/>

                    <!-- Arbustos del fondo -->
                    <path d="M 30 133 C 25 125, 40 118, 50 126 C 55 120, 70 120, 75 127 C 80 122, 95 122, 100 128 C 105 124, 120 126, 122 131" stroke="#008837" stroke-width="1.4" fill="none"/>
                    <path d="M 175 132 C 180 125, 195 125, 200 130 C 205 124, 220 126, 225 133" stroke="#008837" stroke-width="1.4" fill="none"/>

                    <!-- Árbol izquierdo (Copa redonda) -->
                    <path d="M 35 130 L 35 108" stroke="#008837" stroke-width="1.8"/>
                    <path d="M 35 118 L 31 113 M 35 115 L 38 111" stroke="#008837" stroke-width="1.4"/>
                    <circle cx="35" cy="98" r="11" stroke="#008837" stroke-width="1.6" fill="none"/>

                    <!-- Árbol derecho (Ciprés estilizado) -->
                    <path d="M 148 131 C 141 120, 140 85, 147 62 C 151 55, 155 75, 157 90 C 158 110, 156 125, 152 131 Z" stroke="#008837" stroke-width="1.6" fill="none"/>
                    <path d="M 148 110 C 145 100, 152 90, 150 78" stroke="#008837" stroke-width="1" fill="none"/>

                    <!-- Nubes -->
                    <path d="M 45 58 C 42 50, 52 45, 58 48 C 62 42, 72 44, 74 50 C 78 48, 85 52, 82 58 Z" stroke="#008837" stroke-width="1.3" fill="none" stroke-linejoin="round"/>
                    <path d="M 165 42 C 163 36, 171 32, 175 35 C 178 30, 186 31, 188 36 C 192 34, 197 38, 195 42 Z" stroke="#008837" stroke-width="1.3" fill="none" stroke-linejoin="round"/>

                    <!-- Pájaro -->
                    <path d="M 190 62 Q 193 59, 196 62 Q 199 59, 202 62" stroke="#008837" stroke-width="1.2" fill="none"/>

                    <!-- TORRE DEL MOLINO -->
                    <path d="M 100 130 L 111 50 L 123 50 L 134 130" stroke="#008837" stroke-width="1.8" fill="none"/>
                    <line x1="117" y1="50" x2="117" y2="130" stroke="#008837" stroke-width="1.4"/>
                    <line x1="108" y1="130" x2="115" y2="50" stroke="#008837" stroke-width="0.8"/>
                    <line x1="126" y1="130" x2="119" y2="50" stroke="#008837" stroke-width="0.8"/>

                    <!-- Niveles y cruces de la torre -->
                    <line x1="109" y1="68" x2="125" y2="68" stroke="#008837" stroke-width="1.5"/>
                    <line x1="106" y1="88" x2="128" y2="88" stroke="#008837" stroke-width="1.5"/>
                    <line x1="103" y1="108" x2="131" y2="108" stroke="#008837" stroke-width="1.5"/>

                    <!-- Tanque/Base inferior -->
                    <rect x="105" y="116" width="24" height="12" rx="1" stroke="#008837" stroke-width="1.5" fill="none"/>
                    <line x1="105" y1="122" x2="129" y2="122" stroke="#008837" stroke-width="1"/>

                    <!-- CABEZAL Y RUEDA DE ASPAS -->
                    <ellipse cx="117" cy="49" rx="8" ry="3" stroke="#008837" stroke-width="1.5" fill="#eaf6ec"/>

                    <!-- Veleta de cola (izquierda) -->
                    <path d="M 117 38 L 88 38 L 86 31 L 102 31 L 117 38 Z" stroke="#008837" stroke-width="1.5" fill="#008837"/>

                    <!-- Centro de la rueda -->
                    <circle cx="117" cy="38" r="4" fill="#008837"/>

                    <!-- Rueda de Aspas -->
                    <g stroke="#008837" stroke-width="1.3">
                        <circle cx="117" cy="38" r="10" stroke-dasharray="2 1" fill="none"/>
                        <circle cx="117" cy="38" r="18" fill="none"/>

                        <line x1="117" y1="20" x2="117" y2="56"/>
                        <line x1="99" y1="38" x2="135" y2="38"/>
                        <line x1="104" y1="25" x2="130" y2="51"/>
                        <line x1="104" y1="51" x2="130" y2="25"/>
                        <line x1="110" y1="21" x2="124" y2="55"/>
                        <line x1="124" y1="21" x2="110" y2="55"/>
                        <line x1="100" y1="31" x2="134" y2="45"/>
                        <line x1="100" y1="45" x2="134" y2="31"/>

                        <path d="M 114 20 L 120 20 M 128 23 L 132 28 M 134 34 L 134 42 M 130 48 L 125 53 M 114 56 L 120 56 M 102 48 L 107 53 M 100 34 L 100 42 M 102 28 L 107 23" stroke-width="2"/>
                    </g>
                </svg>
            </div>

            <div class="login-panel__footer-sub">
                <span class="login-panel__marca-logo" style="width:20px; height:20px;"></span>
                <span>Municipalidad<br>General Paz</span>
            </div>
        </div>

        <!-- PANEL DERECHO (LOGIN / REGISTRO) -->
        <div class="login-form-container">
            <div>
                <!-- Pestañas de Navegación -->
                <div class="login-tabs">
                    <button type="button" class="login-tab-btn active" id="btn-tab-login" onclick="switchAuthTab('login')">Iniciar sesión</button>
                    <button type="button" class="login-tab-btn" id="btn-tab-register" onclick="switchAuthTab('register')">Registrarse</button>
                </div>

                <!-- Mensaje de éxito flashdata -->
                <?php if (session()->getFlashdata('mensaje')): ?>
                    <div class="login-alerta login-alerta--ok">
                        <?= esc(session()->getFlashdata('mensaje')) ?>
                    </div>
                <?php endif; ?>

                <!-- FORMULARIO DE INICIO DE SESIÓN -->
                <form id="form-login" method="post" action="<?= base_url('login/procesar') ?>">
                    <div class="login-form">
                        <h1>Bienvenido</h1>
                        <div class="subtitulo">Ingresá tus datos para acceder a la plataforma de Producción y Ambiente.</div>

                        <label for="email">Correo electrónico</label>
                        <div class="input-icon-wrapper">
                            <input type="email" id="email" name="email" placeholder="ejemplo@municipiogp.gob.ar" value="<?= esc(old('email')) ?>" required>
                            <i class="fa-regular fa-envelope input-icon"></i>
                        </div>

                        <label for="password">Contraseña</label>
                        <div class="input-icon-wrapper">
                            <input type="password" id="password" name="password" placeholder="••••••••" required>
                            <i class="fa-regular fa-eye input-icon" style="cursor: pointer; pointer-events: auto;" onclick="togglePassword('password', this)"></i>
                        </div>

                        <a href="#" class="forgot-pass">¿Olvidaste tu contraseña?</a>

                        <button type="submit" class="btn-submit">Iniciar sesión</button>
                    </div>
                </form>

                <!-- FORMULARIO DE REGISTRO (OCULTO POR DEFECTO) -->
                <form id="form-register" method="post" action="<?= base_url('usuarios/guardar') ?>" style="display: none;">
                    <div class="login-form">
                        <h1>Crear cuenta</h1>
                        <div class="subtitulo">Completá tus datos para unirte a la plataforma.</div>

                        <label for="reg-nombre">Nombre completo</label>
                        <div class="input-icon-wrapper">
                            <input type="text" id="reg-nombre" name="nombre" placeholder="Tu nombre" required>
                            <i class="fa-regular fa-user input-icon"></i>
                        </div>

                        <label for="reg-email">Correo electrónico</label>
                        <div class="input-icon-wrapper">
                            <input type="email" id="reg-email" name="email" placeholder="ejemplo@municipiogp.gob.ar" required>
                            <i class="fa-regular fa-envelope input-icon"></i>
                        </div>

                        <label for="reg-password">Contraseña</label>
                        <div class="input-icon-wrapper">
                            <input type="password" id="reg-password" name="password" placeholder="••••••••" required>
                            <i class="fa-regular fa-eye input-icon" style="cursor: pointer; pointer-events: auto;" onclick="togglePassword('reg-password', this)"></i>
                        </div>

                        <label for="reg-rol">Tipo de usuario</label>
                        <div class="input-icon-wrapper">
                            <select id="reg-rol" name="rol" required>
                                <option value="usuario" selected>Cliente</option>
                                <option value="operador">Operador</option>
                                <option value="admin">Administrador</option>
                            </select>
                        </div>

                        <button type="submit" class="btn-submit" style="margin-top: 24px;">Registrarse</button>
                    </div>
                </form>
            </div>

            <div class="login-pie">
                <span>Municipalidad de General Paz</span>
                <span class="dot">•</span>
                <span>Producción y Ambiente</span>
            </div>
        </div>

    </div>

    <!-- SCRIPT DE INTERACCIÓN -->
    <script>
        function switchAuthTab(mode) {
            const formLogin = document.getElementById('form-login');
            const formRegister = document.getElementById('form-register');
            const tabLogin = document.getElementById('btn-tab-login');
            const tabRegister = document.getElementById('btn-tab-register');

            if (mode === 'login') {
                formLogin.style.display = 'block';
                formRegister.style.display = 'none';
                tabLogin.classList.add('active');
                tabRegister.classList.remove('active');
            } else {
                formLogin.style.display = 'none';
                formRegister.style.display = 'block';
                tabRegister.classList.add('active');
                tabLogin.classList.remove('active');
            }
        }

        function togglePassword(inputId, icon) {
            const input = document.getElementById(inputId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>

    <!-- SWEETALERT2 PARA MANEJO DE ERRORES -->
    <?php if (session()->getFlashdata('error')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Acceso Denegado',
            text: '<?= esc(session()->getFlashdata('error')) ?>',
            confirmButtonText: 'Reintentar',
            confirmButtonColor: '#008837',
            allowOutsideClick: false,
            allowEscapeKey: false
        });
    </script>
    <?php endif; ?>

</body>
</html>