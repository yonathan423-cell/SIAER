<?= $this->extend('layout/base') ?>

<?= $this->section('estilos') ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css" />
<style>
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
    .gis-header .search-center { flex: 1; max-width: 400px; margin: 0 15px; position: relative; }
    .gis-header .search-center input {
        width: 100%; padding: 6px 12px 6px 30px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.85rem; outline: none;
    }
    
    .gis-body {
        display: flex;
        height: 650px;
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
</style>
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>
<div class="gis-wrapper">
    <div class="gis-header">
        <div class="title-area">
            <span style="color:#2563eb;">🌱 MAPA DE PARCELAS</span>
            <span style="color:#64748b; font-weight:400; font-size:0.8rem;">Partido de General Paz, Buenos Aires</span>
        </div>
        
        <div class="search-center">
            <span style="position:absolute; left:10px; top:6px; color:#94a3b8; font-size:0.8rem;">🔍</span>
            <input type="text" id="busquedaGlobal" onkeyup="aplicarFiltros()" placeholder="Buscar dirección, lugar o catastro...">
        </div>
    </div>

    <div class="gis-body">
        <div class="gis-sidebar">
            <div class="sidebar-section">
                <div class="section-title">
                    <span>FILTROS</span>
                    <a onclick="limpiarFiltros()" style="color:#ef4444; cursor:pointer; text-transform:none; font-size:0.75rem;">Limpiar filtros</a>
                </div>
                <input type="text" id="filtroTexto" onkeyup="aplicarFiltros()" placeholder="Partida, nomenclatura, propietario..." style="width:100%; padding:6px; border:1px solid #cbd5e1; border-radius:6px; font-size:0.8rem; box-sizing:border-box;">
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
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    let mapa;
    let rawGeoJSONData = null;
    let geojsonLayer = null;
    let capaSeleccionada = null;

    document.addEventListener("DOMContentLoaded", function () {
        mapa = L.map('mapa', { zoomControl: false }).setView([-35.515, -58.315], 11);
        
        L.control.zoom({ position: 'topright' }).addTo(mapa);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19
        }).addTo(mapa);

        setTimeout(() => { mapa.invalidateSize(); }, 200);

        // Cargar GeoJSON
        fetch('<?= base_url("geojson/cuarteles_general_paz.json") ?>')
            .then(r => r.json())
            .then(data => {
                rawGeoJSONData = data;
                poblarSelectCuarteles(data.features || []);
                actualizarMetricas(data.features || []);
                renderizarGeoJSON(data);
            })
            .catch(e => console.log("Aviso GeoJSON:", e));
    });

    function poblarSelectCuarteles(features) {
        const select = document.getElementById('selectCuartel');
        select.innerHTML = '<option value="">Todos los cuarteles</option>';

        const cuartelesSet = new Set();
        features.forEach(f => {
            const props = f.properties || {};
            if (props.cuartel) cuartelesSet.add(props.cuartel.toString());
        });

        const ordenados = Array.from(cuartelesSet).sort((a, b) => a.localeCompare(b, undefined, {numeric: true}));

        ordenados.forEach(c => {
            const opt = document.createElement('option');
            opt.value = c;
            opt.textContent = `Cuartel ${c}`;
            select.appendChild(opt);
        });
    }

    function renderizarGeoJSON(data) {
        if (geojsonLayer) {
            mapa.removeLayer(geojsonLayer);
        }
        capaSeleccionada = null;

        geojsonLayer = L.geoJSON(data, {
            style: function(feature) {
                return {
                    color: '#2563eb',
                    weight: 1.5,
                    fillColor: '#2563eb',
                    fillOpacity: 0.0 // 100% TRANSPARENTE AL INICIO
                };
            },
            onEachFeature: (feature, layer) => {
                layer.on('mouseover', function () {
                    if (capaSeleccionada !== this) {
                        this.setStyle({ fillOpacity: 0.15, weight: 2 });
                    }
                });

                layer.on('mouseout', function () {
                    if (capaSeleccionada !== this) {
                        this.setStyle({ fillOpacity: 0.0, weight: 1.5 });
                    }
                });

                // PINTAR DE AZUL SOLO CUANDO SE SELECCIONA
                layer.on('click', function () {
                    if (capaSeleccionada) {
                        geojsonLayer.resetStyle(capaSeleccionada);
                    }

                    capaSeleccionada = this;
                    this.setStyle({
                        fillColor: '#2563eb',
                        fillOpacity: 0.45,
                        weight: 2.5,
                        color: '#1d4ed8'
                    });

                    const props = feature.properties || {};
                    const box = document.getElementById('detalleParcelaBox');
                    box.style.textAlign = 'left';
                    box.style.background = '#ffffff';
                    box.style.border = '1px solid #cbd5e1';
                    box.innerHTML = `
                        <h4 style="margin:0 0 6px 0; color:#1f3864;">📌 ${props.nombre || 'Cuartel ' + props.cuartel}</h4>
                        <p style="margin:3px 0; font-size:0.8rem;"><strong>Cuartel:</strong> ${props.cuartel || '-'}</p>
                        <p style="margin:3px 0; font-size:0.8rem;"><strong>Propietario:</strong> ${props.propietario || 'Sin datos'}</p>
                        <p style="margin:3px 0; font-size:0.8rem;"><strong>Actividad:</strong> ${props.actividad || 'No especificada'}</p>
                    `;
                });
            }
        }).addTo(mapa);
    }

    function aplicarFiltros() {
        if (!rawGeoJSONData || !rawGeoJSONData.features) return;

        const textoBusquedaGlobal = document.getElementById('busquedaGlobal').value.toLowerCase().trim();
        const textoFiltro = document.getElementById('filtroTexto').value.toLowerCase().trim();
        const cuartelSeleccionado = document.getElementById('selectCuartel').value;

        const actividadesSeleccionadas = Array.from(document.querySelectorAll('.chip-btn.active'))
                                             .map(btn => btn.getAttribute('data-actividad'));

        const estadosSeleccionados = Array.from(document.querySelectorAll('.filtro-estado:checked'))
                                          .map(cb => cb.value);

        const featuresFiltradas = rawGeoJSONData.features.filter(f => {
            const props = f.properties || {};
            const partida = (props.partida || props.nro_catastro || props.id || '').toString().toLowerCase();
            const propietario = (props.propietario || '').toLowerCase();
            const nomenclatura = (props.nomenclatura || '').toLowerCase();
            const actividad = (props.actividad || '').toLowerCase();
            const cuartel = (props.cuartel || '').toString();
            const estado = (props.estado || (props.propietario ? 'con_ficha' : 'sin_datos')).toLowerCase();

            const coincideTexto = !textoFiltro || partida.includes(textoFiltro) || propietario.includes(textoFiltro) || nomenclatura.includes(textoFiltro);
            const coincideGlobal = !textoBusquedaGlobal || partida.includes(textoBusquedaGlobal) || propietario.includes(textoBusquedaGlobal) || nomenclatura.includes(textoBusquedaGlobal);
            const coincideCuartel = !cuartelSeleccionado || cuartel === cuartelSeleccionado;
            const coincideActividad = actividadesSeleccionadas.length === 0 || actividadesSeleccionadas.some(act => actividad.includes(act));
            const coincideEstado = estadosSeleccionados.length === 0 || estadosSeleccionados.includes(estado);

            return coincideTexto && coincideGlobal && coincideCuartel && coincideActividad && coincideEstado;
        });

        const dataFiltrada = { ...rawGeoJSONData, features: featuresFiltradas };
        renderizarGeoJSON(dataFiltrada);
        actualizarMetricas(featuresFiltradas);
    }

    function actualizarMetricas(features) {
        document.getElementById('totalTodas').innerText = features.length;
        
        let conFicha = 0, sinDatos = 0, incompletas = 0;
        features.forEach(f => {
            const props = f.properties || {};
            if (props.estado === 'incompletas') incompletas++;
            else if (props.propietario && props.propietario !== 'Sin datos') conFicha++;
            else sinDatos++;
        });

        document.getElementById('totalFicha').innerText = conFicha;
        document.getElementById('totalSinDatos').innerText = sinDatos;
        document.getElementById('totalIncompletas').innerText = incompletas;
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
        document.getElementById('busquedaGlobal').value = '';
        aplicarFiltros();
    }
</script>
<?= $this->endSection() ?>