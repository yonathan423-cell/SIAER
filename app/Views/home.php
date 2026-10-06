<?= $this->extend('layout/base') ?>

<?= $this->section('estilos') ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css" />
<style>
<<<<<<< HEAD
  .header {
    background: #2c3e50;
    color: #fff;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    text-align: center;
  }
  .header img {
    height: 80px;
    margin-bottom: 10px;
  }
  .home-actions {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 20px;
    flex-wrap: wrap;
  }
  .home-actions a {
    padding: 12px 20px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: bold;
    transition: transform 0.2s;
    color: #fff;
  }
  .home-actions a:hover { transform: scale(1.05); }
  .home-actions a:nth-child(1) { background: #28a745; }
  .home-actions a:nth-child(2) { background: #007bff; }
  .home-actions a:nth-child(3) { background: #ffc107; color: #000; }

  .info-proyecto {
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 20px 24px;
    margin-top: 24px;
  }
  .info-proyecto h3 { margin-top: 0; }
  .info-proyecto ul { margin: 10px 0 0; padding-left: 20px; }
  .info-proyecto li { margin-bottom: 6px; }

  .mapa-home-caja {
    margin-top: 24px;
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid #ddd;
  }
  #mapa-home { height: 320px; }

  .footer {
    margin-top: 30px;
    padding: 10px;
    background: #f1f1f1;
    border-radius: 6px;
    font-size: 0.9rem;
    color: #555;
    text-align: center;
  }
=======

  /* Header Moderno y Elegante */
  .hero-simple {
    background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
    color: #ffffff;
    padding: 40px 30px;
    border-radius: 16px;
    margin-bottom: 24px;
    text-align: center;
    box-shadow: 0 10px 25px -5px rgba(30, 58, 138, 0.2);
  }

  .hero-logo {
    background: #ffffff;
    display: inline-block;
    padding: 8px 16px;
    border-radius: 10px;
    margin-bottom: 14px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
  }

  .hero-logo img {
    height: 42px;
    display: block;
  }

  .hero-simple h1 {
    font-size: 2.2rem;
    font-weight: 800;
    margin: 0 0 6px 0;
    color: #ffffff;
    letter-spacing: -0.5px;
  }

  .hero-simple p {
    color: #cbd5e1;
    font-size: 0.95rem;
    margin: 0;
  }

  /* Tarjetas Limpias */
  .info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin-bottom: 24px;
  }

  .info-card {
    background: #ffffff;
    border-radius: 14px;
    padding: 24px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
  }

  .info-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
    border-color: #94a3b8;
  }

  .info-card h3 {
    color: #0f172a;
    margin-top: 0;
    font-size: 1.1rem;
    font-weight: 800;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .info-card p, .info-card ul {
    color: #475569;
    font-size: 0.9rem;
    line-height: 1.6;
    margin: 0;
  }

  .info-card ul {
    padding-left: 0;
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 8px;
  }

  .info-card ul li {
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .info-card ul li::before {
    content: "✓";
    color: #2563eb;
    font-weight: 800;
  }

  /* Contenedor del Mapa */
  .map-box {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
    padding: 20px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
  }

  .map-title {
    font-size: 1rem;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  #mapa-home {
    height: 380px;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
  }

  /* ===================== CHAT DE DUDAS ===================== */
  .chat-fab {
    position: fixed;
    bottom: 24px;
    right: 24px;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: #0f766e;
    color: #fff;
    border: none;
    font-size: 1.6rem;
    cursor: pointer;
    box-shadow: 0 8px 20px -4px rgba(15, 118, 110, 0.5);
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.2s ease, background 0.2s ease;
  }
  .chat-fab:hover {
    transform: scale(1.08);
    background: #115e59;
  }

  .chat-ventana {
    position: fixed;
    bottom: 96px;
    right: 24px;
    width: 340px;
    max-width: calc(100vw - 48px);
    height: 480px;
    max-height: calc(100vh - 130px);
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.25);
    z-index: 1000;
    display: none;
    flex-direction: column;
    overflow: hidden;
    border: 1px solid #e2e8f0;
    opacity: 0;
    transform: translateY(15px);
    transition: opacity 0.25s ease, transform 0.25s ease;
  }
  .chat-ventana.abierto {
    display: flex;
    opacity: 1;
    transform: translateY(0);
  }

  .chat-header {
    background: linear-gradient(135deg, #0f766e 0%, #115e59 100%);
    color: #fff;
    padding: 14px 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .chat-header .chat-titulo {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 700;
    font-size: 0.95rem;
  }
  .chat-header .chat-avatar {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
  }
  .chat-header .chat-estado {
    font-size: 0.72rem;
    color: #bbf7d0;
    font-weight: 400;
    display: block;
  }
  .chat-cerrar {
    background: none;
    border: none;
    color: #fff;
    font-size: 1.3rem;
    cursor: pointer;
    line-height: 1;
    opacity: 0.85;
  }
  .chat-cerrar:hover { opacity: 1; }

  .chat-cuerpo {
    flex: 1;
    overflow-y: auto;
    padding: 16px;
    background: #f8fafc;
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .chat-msg {
    max-width: 80%;
    padding: 9px 13px;
    border-radius: 14px;
    font-size: 0.85rem;
    line-height: 1.45;
    word-wrap: break-word;
    overflow-wrap: anywhere;
  }
  .chat-msg.bot {
    background: #ffffff;
    color: #334155;
    border: 1px solid #e2e8f0;
    align-self: flex-start;
    border-bottom-left-radius: 4px;
  }
  .chat-msg.user {
    background: #0f766e;
    color: #ffffff;
    align-self: flex-end;
    border-bottom-right-radius: 4px;
  }

  .chat-typing {
    align-self: flex-start;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 10px 14px;
    display: flex;
    gap: 4px;
  }
  .chat-typing span {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #94a3b8;
    animation: chatBlink 1.2s infinite;
  }
  .chat-typing span:nth-child(2) { animation-delay: 0.2s; }
  .chat-typing span:nth-child(3) { animation-delay: 0.4s; }
  @keyframes chatBlink {
    0%, 60%, 100% { opacity: 0.3; }
    30% { opacity: 1; }
  }

  .chat-chips {
    padding: 10px 12px;
    border-top: 1px solid #e2e8f0;
    background: #ffffff;
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    max-height: 120px;
    overflow-y: auto;
  }
  .chat-chip {
    background: #f0fdfa;
    color: #0f766e;
    border: 1px solid #99f6e4;
    border-radius: 20px;
    padding: 5px 11px;
    font-size: 0.75rem;
    cursor: pointer;
    transition: background 0.15s ease;
  }
  .chat-chip:hover { background: #ccfbf1; }

  .chat-input-area {
    display: flex;
    gap: 8px;
    padding: 10px 12px;
    border-top: 1px solid #e2e8f0;
    background: #ffffff;
  }
  .chat-input-area input {
    flex: 1;
    border: 1px solid #cbd5e1;
    border-radius: 20px;
    padding: 8px 14px;
    font-size: 0.85rem;
    outline: none;
  }
  .chat-input-area input:focus { border-color: #0f766e; }
  .chat-enviar {
    background: #0f766e;
    color: #fff;
    border: none;
    border-radius: 50%;
    width: 38px;
    height: 38px;
    cursor: pointer;
    font-size: 1rem;
    flex-shrink: 0;
  }
  .chat-enviar:hover { background: #115e59; }
>>>>>>> login
</style>
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>
<<<<<<< HEAD
<div class="header">
  <img src="<?= base_url('img/logo_general_paz.png') ?>" alt="Logo Municipalidad de General Paz">
  <h1>SIAER</h1>
  <h2>Sistema de Información y Análisis de Explotaciones Rurales</h2>
  <p>Proyecto Integrador 2026 — Grupo 2</p>
</div>

<div class="home-actions">
  <a href="<?= base_url('login') ?>">🔑 Iniciar sesión</a>
  <a href="<?= base_url('parcelas') ?>">📋 Listado de parcelas</a>
  <a href="<?= base_url('parcelas/crear') ?>">➕ Nueva parcela</a>
</div>

<div class="info-proyecto">
  <h3>¿Qué es SIAER?</h3>
  <p>
    SIAER es una herramienta web que le permite a la Municipalidad de General Paz
    reunir en un solo lugar la información de las parcelas rurales del partido:
    ubicación georreferenciada, actividad productiva, permisos e inspecciones.
    Reemplaza las planillas de Excel sueltas y los expedientes en papel que se
    usaban hasta ahora.
  </p>
  <h3>¿Qué podés hacer acá?</h3>
  <ul>
    <li>Ver el mapa de parcelas rurales del partido, con filtros por año de relevamiento y cuartel.</li>
    <li>Consultar y cargar los datos productivos de cada parcela (cultivos, ganado, infraestructura).</li>
    <li>Dar de alta, editar o eliminar parcelas desde el listado.</li>
  </ul>
</div>

<div class="mapa-home-caja">
  <div id="mapa-home"></div>
</div>

<div class="footer">
  © 2026 — Municipalidad de General Paz | Grupo 2
</div>
=======

<!-- Banner Simple -->
<div class="hero-simple">
  <div class="hero-logo">
    <img src="<?= base_url('img/logo_municipalidad.png') ?>" alt="Municipalidad General Paz" onerror="this.style.display='none'">
  </div>
  <h1>SIAER</h1>
  <p>Sistema de Información y Análisis de Explotaciones Rurales — Municipalidad de General Paz</p>
</div>

<!-- 2 Tarjetas Básicas -->
<div class="info-grid">
  <div class="info-card">
    <h3>🌱 ¿Qué es SIAER?</h3>
    <p>Plataforma para la gestión y consulta georreferenciada de parcelas rurales del partido de General Paz, consolidando datos de actividad productiva e inspecciones.</p>
  </div>

  <div class="info-card">
    <h3>⚡ Funcionalidades</h3>
    <ul>
      <li>Mapa interactivo del partido con delimitación de parcelas.</li>
      <li>Consulta y actualización de datos productivos.</li>
      <li>Gestión centralizada de usuarios y permisos.</li>
    </ul>
  </div>
</div>

<!-- Mapa -->
<div class="map-box">
  <div class="map-title">📍 Ubicación y Delimitaciones</div>
  <div id="mapa-home"></div>
</div>

<!-- ===================== CHAT DE DUDAS ===================== -->
<button class="chat-fab" id="chatFab" title="¿Dudas? Chateá con nosotros" aria-label="Abrir chat de dudas">💬</button>

<div class="chat-ventana" id="chatVentana">
  <div class="chat-header">
    <div class="chat-titulo">
      <div class="chat-avatar">🤖</div>
      <div>
        Asistente SIAER
        <span class="chat-estado">● En línea</span>
      </div>
    </div>
    <button class="chat-cerrar" id="chatCerrar" aria-label="Cerrar chat">&times;</button>
  </div>

  <div class="chat-cuerpo" id="chatCuerpo"></div>

  <div class="chat-chips" id="chatChips"></div>

  <div class="chat-input-area">
    <input type="text" id="chatInput" placeholder="Escribí tu duda..." autocomplete="off">
    <button class="chat-enviar" id="chatEnviar" aria-label="Enviar">➤</button>
  </div>
</div>

>>>>>>> login
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
<<<<<<< HEAD
  const mapa = L.map('mapa-home').setView([-35.55, -60.45], 11);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(mapa);
=======
  // Centrado en el Partido de General Paz (cabecera: Ranchos)
  const mapa = L.map('mapa-home').setView([-35.5164, -58.3189], 13);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap'
  }).addTo(mapa);

  // Marcador sobre Ranchos (cabecera del partido)
  L.marker([-35.5164, -58.3189]).addTo(mapa)
    .bindPopup('<strong>Ranchos</strong><br>Cabecera del Partido de General Paz')
    .openPopup();
</script>

<!-- ===================== LÓGICA DEL CHAT DE DUDAS ===================== -->
<script>
  (function () {
    // Base de conocimiento: cada duda tiene palabras clave + respuesta.
    // Para agregar o editar una pregunta, sumá un objeto a esta lista. 👇
    const BASE_CONOCIMIENTO = [
      {
        chip: "¿Qué es el SIAER?",
        claves: ["que es", "siaer", "sistema", "sirve", "para que"],
        respuesta: "El SIAER es el Sistema de Información y Análisis de Explotaciones Rurales de la Municipalidad de General Paz. Sirve para gestionar y consultar de forma georreferenciada las parcelas rurales del partido. 🌱"
      },
      {
        chip: "¿Cómo registro una parcela?",
        claves: ["registrar", "registro", "nueva parcela", "cargar parcela", "crear", "agregar parcela"],
        respuesta: "Ingresá al menú Parcelas → Nueva Parcela, completá el número de catastro, las coordenadas, la superficie y el propietario, y tocá 'Guardar Parcela'. ✅"
      },
      {
        chip: "¿Qué es el Nº de catastro?",
        claves: ["catastro", "numero de catastro", "nomenclatura"],
        respuesta: "El número de catastro es el identificador único de cada parcela en el registro municipal. Sirve para localizarla e identificarla oficialmente. 📌"
      },
      {
        chip: "¿Cómo veo mis parcelas?",
        claves: ["mis parcelas", "ver parcelas", "mis registros", "listado"],
        respuesta: "Andá a la sección 'Mis Parcelas'. Ahí vas a ver únicamente las parcelas registradas a tu nombre. 👤"
      },
      {
        chip: "¿Cómo cargo lat/long?",
        claves: ["latitud", "longitud", "coordenadas", "lat", "long", "ubicacion"],
        respuesta: "En el formulario de registro podés escribir las coordenadas a mano. Ejemplo para General Paz: Latitud -35.5533 y Longitud -58.3059. 🗺️"
      },
      {
        chip: "¿Qué es un cuartel?",
        claves: ["cuartel", "cuarteles", "division", "zona"],
        respuesta: "Un cuartel es una subdivisión territorial del partido de General Paz. Se usa para organizar y agrupar las parcelas por sector. 📍"
      },
      {
        chip: "📞 Contacto de la Municipalidad",
        claves: ["contacto", "telefono", "direccion", "horario", "municipalidad", "ayuda", "comunicar"],
        respuesta: "Podés contactar a la Municipalidad de General Paz:<br>📍 Obdulio Hernández Castro 2858<br>📞 2241 475364<br>🕗 Horario: 07:00 a 14:00 hs"
      }
    ];

    const RESP_DEFECTO = "Mmm, no estoy seguro de eso. 🤔 Probá con una de estas preguntas frecuentes 👇 o contactá a la Municipalidad al 2241 475364.";

    // Referencias del DOM
    const fab = document.getElementById('chatFab');
    const ventana = document.getElementById('chatVentana');
    const cerrar = document.getElementById('chatCerrar');
    const cuerpo = document.getElementById('chatCuerpo');
    const chips = document.getElementById('chatChips');
    const input = document.getElementById('chatInput');
    const enviar = document.getElementById('chatEnviar');

    let bienvenidaMostrada = false;

    // Agrega un mensaje. 'texto' del bot puede tener HTML seguro (definido por nosotros);
    // el texto del usuario se inserta como texto plano para evitar inyección.
    function agregarMensaje(contenido, tipo) {
      const div = document.createElement('div');
      div.className = 'chat-msg ' + tipo;
      if (tipo === 'bot') {
        div.innerHTML = contenido; // contenido controlado por nosotros
      } else {
        div.textContent = contenido; // texto del usuario: seguro
      }
      cuerpo.appendChild(div);
      cuerpo.scrollTop = cuerpo.scrollHeight;
    }

    function mostrarTyping() {
      const t = document.createElement('div');
      t.className = 'chat-typing';
      t.id = 'chatTyping';
      t.innerHTML = '<span></span><span></span><span></span>';
      cuerpo.appendChild(t);
      cuerpo.scrollTop = cuerpo.scrollHeight;
    }
    function quitarTyping() {
      const t = document.getElementById('chatTyping');
      if (t) t.remove();
    }

    // Normaliza texto (minúsculas, sin tildes) para comparar
    function normalizar(txt) {
      return (txt || '').toString().toLowerCase()
        .normalize("NFD").replace(/[\u0300-\u036f]/g, "").trim();
    }

    // Busca la mejor respuesta según palabras clave
    function buscarRespuesta(textoUsuario) {
      const t = normalizar(textoUsuario);
      let mejor = null;
      let maxCoincidencias = 0;
      BASE_CONOCIMIENTO.forEach(item => {
        let cuenta = 0;
        item.claves.forEach(clave => {
          if (t.includes(normalizar(clave))) cuenta++;
        });
        if (cuenta > maxCoincidencias) {
          maxCoincidencias = cuenta;
          mejor = item;
        }
      });
      return maxCoincidencias > 0 ? mejor.respuesta : RESP_DEFECTO;
    }

    // Responde con animación de "escribiendo..."
    function responderBot(texto) {
      mostrarTyping();
      setTimeout(() => {
        quitarTyping();
        agregarMensaje(texto, 'bot');
      }, 600);
    }

    // Procesa el envío del usuario
    function procesarEnvio(texto) {
      const limpio = texto.trim();
      if (!limpio) return;
      agregarMensaje(limpio, 'user');
      input.value = '';
      responderBot(buscarRespuesta(limpio));
    }

    // Genera los chips de preguntas rápidas
    function generarChips() {
      chips.innerHTML = '';
      BASE_CONOCIMIENTO.forEach(item => {
        const chip = document.createElement('button');
        chip.className = 'chat-chip';
        chip.textContent = item.chip;
        chip.addEventListener('click', () => {
          agregarMensaje(item.chip, 'user');
          responderBot(item.respuesta);
        });
        chips.appendChild(chip);
      });
    }

    // Abrir / cerrar
    function abrirChat() {
      ventana.classList.add('abierto');
      if (!bienvenidaMostrada) {
        setTimeout(() => {
          agregarMensaje("¡Hola! 👋 Soy el asistente del SIAER. ¿En qué te puedo ayudar? Elegí una pregunta o escribime tu duda.", 'bot');
        }, 300);
        bienvenidaMostrada = true;
      }
      setTimeout(() => input.focus(), 300);
    }
    function cerrarChat() {
      ventana.classList.remove('abierto');
    }

    // Eventos
    fab.addEventListener('click', () => {
      ventana.classList.contains('abierto') ? cerrarChat() : abrirChat();
    });
    cerrar.addEventListener('click', cerrarChat);
    enviar.addEventListener('click', () => procesarEnvio(input.value));
    input.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') procesarEnvio(input.value);
    });

    // Inicializar chips al cargar
    generarChips();
  })();
>>>>>>> login
</script>
<?= $this->endSection() ?>