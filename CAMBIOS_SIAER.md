# SIAER: resumen de cambios de esta versión

Base: `Siaer_copia_de_seguridad.zip`. El `.env`, la base de datos, las dependencias y la carpeta `.git` no se tocaron.

## 1. Código alineado con la base real (siaer_db)
- `app/Models/ParcelaModel.php`: columnas reales (`n_catastro`, `superficie`, `anio_relevamiento`, etc.). Nuevo `conExplotacion()` que une cada parcela con su explotación, toma la actividad de `explotaciones` cuando `parcelas.actividad` está vacía y muestra "5" como "Cuartel 5" (solo al leer; no modifica la base).
- `app/Models/ExplotacionModel.php` y `PermisoModel.php`: apuntan a las tablas y columnas reales (`explotaciones`, `permisos`, `id_parcelas`, etc.).
- `app/Controllers/Parcelas.php`: el alta ya no envía la columna inexistente `estado`; se guardan catastro, superficie y año al crear y editar; se quitó el `dd()` de depuración; nuevos métodos `mapaJson()` y `ver($id)`; las tarjetas de superficie usan datos reales.
- `app/Controllers/MapaController.php`: usa el mismo modelo.
- Vistas de parcelas: `superficie_ha` pasa a `superficie`; el formulario de alta envía `n_catastro`.

## 2. Mapa con colores reales
- Las parcelas se pintan según la actividad de `explotaciones`. "Mixto Agrícola-Ganadero" se pinta como mixto y los filtros Agrícola y Ganadera no lo incluyen. El popup y la ficha muestran cultivo y ganado.

## 3. Seguridad
- **CSRF activado** para toda la aplicación (`app/Config/Filters.php`). Todos los formularios llevan `csrf_field()`: login, registro, usuarios (alta y edición), alta y edición de parcelas.
- **Borrados por POST:** parcelas y usuarios ahora se eliminan con un formulario con token (antes era un enlace GET). Las rutas `parcelas/eliminar` y `usuarios/eliminar` aceptan solo POST.
- Se borró `public/info.php`.
- Si algo falla por CSRF, se puede desactivar volviendo a comentar la línea `'csrf',` en `app/Config/Filters.php` (dentro de `$globals['before']`).

## 4. Migraciones
- Las 4 migraciones viejas (con columnas que no coincidían) se reemplazaron por una sola, `2026-10-17-000001_EsquemaReal.php`, igual a la base real. Usa "IF NOT EXISTS", así que no cambia nada sobre una base ya existente.

## Cómo probar
1. Iniciá sesión (si el login falla con un error de seguridad, borrá las cookies del sitio y recargá).
2. `/parcelas`: mapa con seis colores; el filtro "Mixtos" debe traer 26 puntos.
3. Creá, editá y eliminá una parcela de prueba (el borrado pide confirmación).
4. Como administrador, creá, editá y eliminá un usuario de prueba.
5. Abrí `/parcelas/ver/1` y `/parcelas/cuarteles`.
6. Entrá con el usuario cliente y revisá `/mis-parcelas`.

## No incluido (a propósito)
- Importador del Excel, módulo de permisos e inspecciones, dashboard con gráficos y agrupación de marcadores: son funciones nuevas, no correcciones.
- "Cada cliente ve solo sus parcelas": hoy casi todas las parcelas no tienen propietario cargado, y la lista quedaría vacía.
- Limpieza de datos en la base (propietarios vacíos, fechas de permisos vacías, tambos sin coordenadas).
- `CI_ENVIRONMENT` sigue en `development`; cambialo a `production` antes de una entrega real.
