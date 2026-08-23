# G5 — Plugin Check oficial (WordPress.org) · Resultados

**Ejecutado**: 2026-08-22 · `wp plugin check chilean-data-protection` (plugin-check v1.x, estándar del directorio)

## Antes → Después de las correcciones

| Métrica | Antes | Después |
|---------|-------|---------|
| ERRORES | 7 | **0** |
| WARNINGS | 8 | **4** (2 pendiente-usuario + 2 aceptados-documentados) |

## Correcciones aplicadas (pasada distribución)

| # | Fix | Archivo |
|---|-----|---------|
| F14-01 | Headers completos: License URI añadido, Requires Plugins: woocommerce, WC tested 11.0, Plugin URI/Author/AuthorURI reales (antes placeholders example.com/"Tu Nombre") | chilean-data-protection.php |
| F14-02 | Description alineada al producto (assessment & guidance, "entra en vigencia") | ídem |
| F14-03 | readme.txt en INGLÉS (requisito directorio 2025), ≤5 tags, Contributors actualizado | src/readme.txt |
| F14-04 | Sanitización al acceso de $_POST arrays (dashboard + profile) | 2 clases |
| F14-05 | translators comment + placeholders ordenados %1$s/%2$s | guide.php, dashboard |
| F14-06 | CSV sin fopen/fputcsv (string builder RFC4180) — corrige regresión propia introducida en el intento previo | class-report.php |
| F14-07 | Nonces descarga con wp_unslash+sanitize | dashboard |
| F14-08 | load_plugin_textdomain y Domain Path eliminados (WP.org carga traducciones automáticamente) | main |
| F14-09 | phpcs:ignore justificados en salidas intencionalmente crudas (HTML completo / CSV machine-readable) | dashboard |

## Warnings restantes — decisión documentada

| Warning | Decisión |
|---------|----------|
| trademarked_term ×2 ("woo" restringido en nombre) | **PENDIENTE USUARIO** — decisión de marca para el directorio (no se puede resolver unilateralmente). Opciones: renombrar producto/slug, o solicitar excepción. Bloquea SUBMIT, no bloquea el resto de gates. |
| error_log ×2 (loaders) | **ACEPTADO** — logging de diagnóstico activo solo con WP_DEBUG+WP_DEBUG_LOG; patrón estándar fail-closed. |

## Nota operativa
Puerto: FREE ahora corre en **8082** (PRO ocupa 8080); siteurl/home de la BD FREE actualizadas a :8082.
