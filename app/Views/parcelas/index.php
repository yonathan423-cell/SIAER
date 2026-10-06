<?= $this->extend('layout/base') ?>

<?= $this->section('estilos') ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css" />
<style>
    /* Estilos del Módulo GIS (Mapa y Sidebar) */
    .gis-wrapper {
        display: flex;
        flex-direction: column;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 20px;
    }
    
    .gis-header {
        height: 50px;
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 16px;
    }
    .gis-header .title-area { display: flex; align-items: baseline; gap: 8px; color: #1e293b; font-weight: 800; font-size: 0.95rem; }
    
    .gis-body {
        display: flex;
        height: 600px;
        position: relative;
        width: 100%;
    }
    
    .gis-sidebar {
        width: 320px;
        min-width: 320px;
        background: #ffffff;
        border-right: 1px solid #cbd5e1;
        display: flex;
        flex-direction: column;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 14px;
        gap: 12px;
        box-sizing: border-box;
    }
    .sidebar-section { border-bottom: 1px solid #f1f5f9; padding-bottom: 12px; }
    .section-title { font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: #475569; letter-spacing: 0.5px; margin-bottom: 8px; display: flex; justify-content: space-between; }
    
    .gis-select {
        width: 100%;
        padding: 6px 8px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 0.8rem;
        background-color: #ffffff;
        color: #334155;
        outline: none;
    }

    .chips-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 5px; }
    .chip-btn {
        padding: 6px 2px; border-radius: 6px; border: 1px solid #e2e8f0; background: #f8fafc;
        font-size: 0.75rem; font-weight: 700; color: #334155; cursor: pointer; text-align: center;
        user-select: none;
    }
    .chip-btn.active { background: #2563eb; color: white; border-color: #2563eb; }

    .metrics-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 4px; background: #ffffff; padding: 6px; border-radius: 6px; border: 1px solid #e2e8f0; }
    .metric-card { text-align: center; }
    .metric-card .num { font-size: 0.95rem; font-weight: 800; color: #0f172a; }
    .metric-card .label { font-size: 0.6rem; color: #64748b; font-weight: 700; text-transform: uppercase; }

    .info-box { background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 6px; padding: 12px; text-align: center; color: #64748b; font-size: 0.8rem; }

    #detalleParcelaBox {
        overflow-wrap: anywhere;
        word-break: break-word;
        max-width: 100%;
        box-sizing: border-box;
    }
    #detalleParcelaBox h4 {
        font-size: 0.82rem;
        line-height: 1.35;
        margin: 0 0 6px 0;
        word-break: break-all;
        overflow-wrap: anywhere;
    }
    #detalleParcelaBox p {
        word-break: break-word;
        overflow-wrap: anywhere;
    }

    .gis-map-container {
        flex: 1;
        position: relative;
        height: 100%;
        overflow: hidden;
    }
    #mapa {
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0; bottom: 0; left: 0; right: 0;
        background: #e5e7eb;
    }

    /* Popup del mapa */
    .popup-parcela { font-size: 0.82rem; line-height: 1.45; min-width: 180px; }
    .popup-parcela .popup-titulo { color: #1f3864; font-weight: 800; display: block; margin-bottom: 5px; word-break: break-all; }
    .popup-parcela .popup-dato { margin: 2px 0; }

    /* Badges de Rol */
    .badge-rol {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
    }
    .badge-rol-admin { background: #fee2e2; color: #991b1b; }
    .badge-rol-operador { background: #fef3c7; color: #92400e; }
    .badge-rol-cliente { background: #dcfce7; color: #166534; }

    /* Estilos de Métricas y Tabla */
    .tarjetas-resumen-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 12px;
        margin-bottom: 16px;
    }
    .tarjeta-stat {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 12px 16px;
    }
    .tarjeta-stat .stat-label {
        font-size: 0.7rem;
        color: #64748b;
        font-weight: 700;
        display: block;
        text-transform: uppercase;
    }
    .tarjeta-stat .stat-num {
        font-size: 1.15rem;
        color: #0f172a;
        font-weight: 800;
        margin-top: 2px;
        display: block;
    }

    .contenedor-tabla-catastro {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        overflow-x: auto;
        margin-bottom: 30px;
    }
    .tabla-catastro {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 0.85rem;
    }
    .tabla-catastro thead tr {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        color: #475569;
    }
    .tabla-catastro th {
        padding: 10px 14px;
        font-size: 0.75rem;
        text-transform: uppercase;
        font-weight: 700;
    }
    .tabla-catastro td {
        padding: 10px 14px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
    }
    .subtexto-tabla {
        display: block;
        color: #94a3b8;
        font-size: 0.75rem;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>
<?php 
    $rolSesion = session()->get('rol') ?? 'cliente';
    $claseRol = match($rolSesion) {
        'admin' => 'badge-rol-admin',
        'operador' => 'badge-rol-operador',
        default => 'badge-rol-cliente'
    };
?>

<!-- 1. BLOQUE MAPA Y FILTROS GIS -->
<div class="gis-wrapper">
    <div class="gis-header">
        <div class="title-area">
            <span style="color:#2563eb;">🌱 MAPA DE PARCELAS</span>
            <span style="color:#64748b; font-weight:400; font-size:0.8rem;">Partido de General Paz, Buenos Aires</span>
        </div>
        
        <div>
            <span class="badge-rol <?= $claseRol ?>">Rol: <?= esc(ucfirst($rolSesion)) ?></span>
        </div>
    </div>

    <div class="gis-body">
        <div class="gis-sidebar">
            <div class="sidebar-section">
                <div class="section-title">
                    <span>FILTROS</span>
                    <a onclick="limpiarFiltros()" style="color:#ef4444; cursor:pointer; text-transform:none; font-size:0.75rem;">Limpiar filtros</a>
                </div>
                <input type="text" id="filtroTexto" onkeyup="aplicarFiltros()" placeholder="Partida, nomenclatura, propietario, actividad..." style="width:100%; padding:6px; border:1px solid #cbd5e1; border-radius:6px; font-size:0.8rem; box-sizing:border-box;">
            </div>

            <div class="sidebar-section">
                <div class="section-title">CUARTEL</div>
                <select id="selectCuartel" class="gis-select" onchange="aplicarFiltros()">
                    <option value="">Todos los cuarteles</option>
                </select>
            </div>

            <div class="sidebar-section">
                <div class="section-title">ACTIVIDAD</div>
                <div class="chips-grid">
                    <button type="button" class="chip-btn" data-actividad="agricola" onclick="toggleChip(this)">🌾 Agrícola</button>
                    <button type="button" class="chip-btn" data-actividad="ganadera" onclick="toggleChip(this)">🐄 Ganadera</button>
                    <button type="button" class="chip-btn" data-actividad="multiple" onclick="toggleChip(this)">📚 Múltiple</button>
                    <button type="button" class="chip-btn" data-actividad="pollos" onclick="toggleChip(this)">🐓 Pollos</button>
                    <button type="button" class="chip-btn" data-actividad="colmenas" onclick="toggleChip(this)">🐝 Colmenas</button>
                    <button type="button" class="chip-btn" data-actividad="tambos" onclick="toggleChip(this)">🥛 Tambos</button>
                    <button type="button" class="chip-btn" data-actividad="mixtos" onclick="toggleChip(this)">🔀 Mixtos</button>
                </div>
            </div>

            <div class="sidebar-section">
                <div class="section-title">ESTADO</div>
                <label style="display:block; font-size:0.8rem; margin-bottom:2px;"><input type="checkbox" value="con_ficha" class="filtro-estado" onchange="aplicarFiltros()"> Con ficha</label>
                <label style="display:block; font-size:0.8rem; margin-bottom:2px;"><input type="checkbox" value="sin_datos" class="filtro-estado" onchange="aplicarFiltros()"> Sin datos</label>
                <label style="display:block; font-size:0.8rem;"><input type="checkbox" value="incompletas" class="filtro-estado" onchange="aplicarFiltros()"> Incompletas</label>
            </div>

            <div class="sidebar-section">
                <div class="section-title">COBERTURA DEL EXCEL</div>
                <div class="metrics-grid">
                    <div class="metric-card"><div class="num" id="totalTodas">0</div><div class="label">TODAS</div></div>
                    <div class="metric-card"><div class="num" id="totalFicha">0</div><div class="label">FICHA</div></div>
                    <div class="metric-card"><div class="num" id="totalSinDatos">0</div><div class="label">SIN DATOS</div></div>
                    <div class="metric-card"><div class="num" id="totalIncompletas">0</div><div class="label">INCOMPL.</div></div>
                </div>
            </div>

            <div class="sidebar-section">
                <div class="section-title">INFORMACIÓN DE LA PARCELA</div>
                <div id="detalleParcelaBox" class="info-box">
                    Seleccioná una parcela en el mapa para ver su ficha
                </div>
            </div>
        </div>

        <div class="gis-map-container">
            <div id="mapa"></div>
        </div>
    </div>
</div>

<!-- 2. BLOQUE DE TARJETAS DE MÉTRICAS -->
<div class="tarjetas-resumen-grid">
    <div class="tarjeta-stat">
        <span class="stat-label">Superficie Total</span>
        <strong class="stat-num"><?= number_format((float)($superficie_total ?? 2046312), 1, ',', '.') ?> ha</strong>
    </div>
    <div class="tarjeta-stat">
        <span class="stat-label">Ganadería Recría</span>
        <strong class="stat-num"><?= number_format((float)($sup_recria ?? 343454), 1, ',', '.') ?> ha</strong>
    </div>
    <div class="tarjeta-stat">
        <span class="stat-label">Urbano / Residencial</span>
        <strong class="stat-num"><?= number_format((float)($sup_urbano ?? 102.5), 1, ',', '.') ?> ha</strong>
    </div>
    <div class="tarjeta-stat">
        <span class="stat-label">Agrícola Soja/Maíz</span>
        <strong class="stat-num"><?= number_format((float)($sup_agricola ?? 337785), 1, ',', '.') ?> ha</strong>
    </div>
</div>

<!-- 3. BLOQUE DE TABLA CATASTRAL -->
<div class="contenedor-tabla-catastro">
    <table class="tabla-catastro">
        <thead>
            <tr>
                <th>Parcela</th>
                <th>Localidad / Ubicación</th>
                <th>Superficie</th>
                <th>Producción</th>
                <th>Estado</th>
                <th style="text-align:right;">Acciones</th>
            </tr>
        </thead>
        <tbody id="tablaCuerpo">
            <?php if (!empty($parcelas)): ?>
                <?php foreach ($parcelas as$p): ?>
                <?php 
                    // Filtro para la tabla HTML: si es Cuartel 1, se omite
                    $numCuartelP = preg_replace('/cuartel/i', '',$p['cuartel'] ?? '');
                    if (trim($numCuartelP) === '1' || strtolower(trim($p['cuartel'] ?? '')) === 'cuartel 1' || strtolower(trim($p['cuartel'] ?? '')) === 'cuartel i') {
                        continue;
                    }
                ?>
                <tr>
                    <td>
                        <strong>Catastro: <?= esc($p['n_catastro'] ?? $p['id']) ?></strong>
                        <small class="subtexto-tabla"><?= esc($p['cuartel'] ?? 'S/N') ?></small>
                    </td>
                    <td>
                        <span><?= esc($p['cuartel'] ?? 'S/D') ?></span>
                        <small class="subtexto-tabla"><?= esc($p['localidad'] ?? 'General Paz') ?></small>
                    </td>
                    <td>
                        <strong><?= number_format((float)($p['superficie'] ?? 0), 1, ',', '.') ?> ha</strong>
                    </td>
                    <td><?= esc($p['actividad'] ?? 'Ganadería Recría') ?></td>
                    <td>
                        <span style="color:#16a34a; font-weight:700;">● <?= esc($p['estado'] ?? 'activa') ?></span>
                    </td>
                    <td style="text-align:right;">
                        <?php if (in_array($rolSesion, ['admin', 'operador'])): ?>
                            <a href="<?= base_url('parcelas/editar/' . ($p['id'] ?? '')) ?>" title="Editar" style="text-decoration:none; margin-right:8px;">✏️</a>
                        <?php endif; ?>
                        <?php if ($rolSesion === 'admin'): ?>
                            <a href="<?= base_url('parcelas/eliminar/' . ($p['id'] ?? '')) ?>" title="Eliminar" onclick="return confirm('¿Eliminar parcela?')" style="text-decoration:none; margin-right:8px;">🗑️</a>
                        <?php endif; ?>
                        <a href="#" title="Ver Detalle" style="text-decoration:none;">👁️</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align:center; padding:16px; color:#64748b;">No hay registros cargados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    let mapa;
    let parcelasReales = [];      
    let capaMarcadores = null;

    function normalizarTexto(txt) {
        return (txt || '').toString().toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "").trim();
    }

    function esc(txt) {
        return (txt == null ? '' : txt.toString())
            .replace(/&/g, '&amp;').replace(/</g, '&lt;')
            .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    document.addEventListener("DOMContentLoaded", function () {
        mapa = L.map('mapa', { zoomControl: false }).setView([-35.515, -58.315], 10);
        
        L.control.zoom({ position: 'topright' }).addTo(mapa);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19
        }).addTo(mapa);

        setTimeout(() => { mapa.invalidateSize(); }, 200);

        cargarParcelasReales();
    });

    function cargarParcelasReales() {
        // Fallback: Obtenemos directamente las parcelas cargadas desde PHP por si falla AJAX
        const parcelasDesdePhp = <?= json_encode($parcelas ?? []) ?>;

        fetch('<?= base_url("mapa/obtenerCapas") ?>')
            .then(r => {
                if (!r.ok) throw new Error("Error HTTP " + r.status);
                return r.json();
            })
            .then(puntos => {
                procesarYRenderizar(puntos);
            })
            .catch(e => {
                console.warn('Fallo AJAX en mapa/obtenerCapas, usando datos locales de PHP:', e);
                procesarYRenderizar(parcelasDesdePhp);
            });
    }

    function procesarYRenderizar(puntos) {
        // Mapeo unificado de coordenadas y campos flexibles
        parcelasReales = puntos.map(p => ({
            id: p.id,
            nro_catastro: p.nro_catastro || p.n_catastro || p.padron || 'S/N',
            cuartel: p.cuartel || '',
            propietario: p.propietario || 'Sin datos',
            superficie_ha: parseFloat(p.superficie_ha || p.superficie || p.hectareas || 0),
            actividad: p.actividad || p.uso_suelo || 'Sin especificar',
            latitud: parseFloat(p.latitud || p.lat),
            longitud: parseFloat(p.longitud || p.lng || p.long)
        })).filter(p => {
            // Exclusión estricta de Cuartel 1 y filtro de coordenadas válidas
            if (!p.latitud || !p.longitud || isNaN(p.latitud) || isNaN(p.longitud)) return false;
            let num = p.cuartel.toString().replace(/cuartel/gi, '').trim();
            return num !== '1' && num.toLowerCase() !== 'i';
        });

        pintarMarcadoresReales(parcelasReales, true);
        poblarSelectCuartelesReal(parcelasReales);
        actualizarMetricasReales(parcelasReales);
    }

    function armarPopup(p) {
        return `
            <div class="popup-parcela">
                <span class="popup-titulo">📌 Catastro ${esc(p.nro_catastro)}</span>
                <div class="popup-dato"><strong>Cuartel:</strong> ${esc(p.cuartel || '-')}</div>
                <div class="popup-dato"><strong>Propietario:</strong> ${esc(p.propietario)}</div>
                <div class="popup-dato"><strong>Superficie:</strong> ${p.superficie_ha.toLocaleString('es-AR')} ha</div>
                <div class="popup-dato"><strong>Actividad:</strong> ${esc(p.actividad)}</div>
            </div>
        `;
    }

    function pintarMarcadoresReales(puntos, reencuadrar = true) {
        if (capaMarcadores) {
            mapa.removeLayer(capaMarcadores);
        }
        capaMarcadores = L.layerGroup();

        const rolSesion = "<?= $rolSesion ?>";
        const coords = [];

        puntos.forEach(p => {
            coords.push([p.latitud, p.longitud]);

            const marker = L.circleMarker([p.latitud, p.longitud], {
                radius: 7,
                color: '#1d6f42',
                fillColor: '#2ecc71',
                fillOpacity: 0.9,
                weight: 1.5
            });

            marker.bindPopup(armarPopup(p));

            marker.on('click', function () {
                mapa.flyTo([p.latitud, p.longitud], 15, { duration: 0.5 });
                mostrarDetalleReal(p, rolSesion);
            });

            capaMarcadores.addLayer(marker);
        });

        capaMarcadores.addTo(mapa);

        if (reencuadrar && coords.length > 0) {
            mapa.fitBounds(coords, { padding: [30, 30] });
        }
    }

    function mostrarDetalleReal(p, rolSesion) {
        const box = document.getElementById('detalleParcelaBox');
        box.style.textAlign = 'left';
        box.style.background = '#ffffff';
        box.style.border = '1px solid #cbd5e1';

        let botonEditar = '';
        if (rolSesion === 'admin' || rolSesion === 'operador') {
            botonEditar = `<div style="margin-top:10px;"><a href="<?= base_url('parcelas/editar/') ?>${p.id}" class="chip-btn" style="display:inline-block; text-decoration:none; padding:4px 8px; background:#1d6f42; color:#fff;">✏️ Editar Ficha</a></div>`;
        }

        box.innerHTML = `
            <h4 style="margin:0 0 6px 0; color:#1f3864;">📌 Catastro ${esc(p.nro_catastro)}</h4>
            <p style="margin:3px 0; font-size:0.8rem;"><strong>Cuartel:</strong> ${esc(p.cuartel || '-')}</p>
            <p style="margin:3px 0; font-size:0.8rem;"><strong>Propietario:</strong> ${esc(p.propietario)}</p>
            <p style="margin:3px 0; font-size:0.8rem;"><strong>Superficie:</strong> ${p.superficie_ha.toLocaleString('es-AR')} ha</p>
            <p style="margin:3px 0; font-size:0.8rem;"><strong>Actividad:</strong> ${esc(p.actividad)}</p>
            ${botonEditar}
        `;
    }

    function poblarSelectCuartelesReal(puntos) {
        const select = document.getElementById('selectCuartel');
        select.innerHTML = '<option value="">Todos los cuarteles</option>';

        const cuartelesSet = new Set();
        puntos.forEach(p => { 
            if (p.cuartel) {
                let numCuartel = p.cuartel.toString().replace(/cuartel/gi, '').trim();
                if (numCuartel !== '1' && numCuartel.toLowerCase() !== 'i') {
                    cuartelesSet.add(numCuartel); 
                }
            }
        });

        Array.from(cuartelesSet).sort((a,b) => a.localeCompare(b, undefined, {numeric: true})).forEach(c => {
            const opt = document.createElement('option');
            opt.value = c;
            opt.textContent = `Cuartel ${c}`;
            select.appendChild(opt);
        });

        select.value = '';
    }

    function actualizarMetricasReales(puntos) {
        const conFicha = puntos.filter(p => p.propietario && normalizarTexto(p.propietario) !== 'sin datos').length;
        const sinDatos = puntos.length - conFicha;

        document.getElementById('totalTodas').innerText = puntos.length;
        document.getElementById('totalFicha').innerText = conFicha;
        document.getElementById('totalSinDatos').innerText = sinDatos;
        document.getElementById('totalIncompletas').innerText = 0;
    }

    function aplicarFiltros() {
        const textoFiltro = normalizarTexto(document.getElementById('filtroTexto').value);
        const cuartelSeleccionado = document.getElementById('selectCuartel').value;

        const actividadesSeleccionadas = Array.from(document.querySelectorAll('.chip-btn.active'))
                                             .map(btn => btn.getAttribute('data-actividad'));

        const estadosSeleccionados = Array.from(document.querySelectorAll('.filtro-estado:checked'))
                                          .map(cb => cb.value);

        const diccionarioActividad = {
            'agricola': ['agricola', 'agricultura', 'soja', 'maiz', 'trigo'],
            'ganadera': ['ganadera', 'ganaderia', 'pastizal', 'vacas'],
            'multiple': ['multiple', 'varias'],
            'pollos': ['pollos', 'avicultura', 'aves', 'avícola'],
            'colmenas': ['colmenas', 'apicultura', 'miel'],
            'tambos': ['tambos', 'tambo', 'leche'],
            'mixtos': ['mixtos', 'mixta', 'agrícola-ganadera', 'agricola-ganadera']
        };

        const parcelasFiltradas = parcelasReales.filter(p => {
            const catastro = normalizarTexto(p.nro_catastro);
            const propietario = normalizarTexto(p.propietario);
            const actividad = normalizarTexto(p.actividad);
            
            const numParcelaCuartel = (p.cuartel || '').toString().replace(/cuartel/gi, '').trim();

            const tieneFicha = p.propietario && normalizarTexto(p.propietario) !== 'sin datos';
            const estado = tieneFicha ? 'con_ficha' : 'sin_datos';

            const coincideTexto = !textoFiltro || 
                                  catastro.includes(textoFiltro) || 
                                  propietario.includes(textoFiltro) || 
                                  actividad.includes(textoFiltro);

            const coincideCuartel = !cuartelSeleccionado || numParcelaCuartel === cuartelSeleccionado;
            
            const coincideActividad = actividadesSeleccionadas.length === 0 || actividadesSeleccionadas.some(chip => {
                const terminos = diccionarioActividad[chip] || [chip];
                return terminos.some(term => actividad.includes(term));
            });

            const coincideEstado = estadosSeleccionados.length === 0 || estadosSeleccionados.includes(estado);

            return coincideTexto && coincideCuartel && coincideActividad && coincideEstado;
        });

        pintarMarcadoresReales(parcelasFiltradas, true);
        actualizarMetricasReales(parcelasFiltradas);
    }

    function toggleChip(btn) {
        btn.classList.toggle('active');
        aplicarFiltros();
    }

    function limpiarFiltros() {
        document.querySelectorAll('.chip-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.filtro-estado').forEach(cb => cb.checked = false);
        document.getElementById('selectCuartel').value = '';
        document.getElementById('filtroTexto').value = '';
        aplicarFiltros();
    }
</script>
<?= $this->endSection() ?>