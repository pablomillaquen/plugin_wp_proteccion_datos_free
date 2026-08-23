# SPEC-FREE-014: WordPress.org Distribution Readiness

**Created**: 2026-08-22 · **Status**: Draft · **Base**: v1.2.0 (FREE-001..013 FROZEN)
**Objetivo**: responder *"¿WooPrivacy FREE 1.2.0 está preparado para ser instalado por cualquier usuario de WordPress.org, sin nuestro entorno y cumpliendo las reglas del directorio?"*

## Gates

| Gate | Alcance |
|------|---------|
| G1 | Identidad: nombre, slug, headers completos, author, URLs, licencia |
| G2 | Licensing: GPL-compat en PHP/JSON/CSS/JS/assets; sin terceros incompatibles |
| G3 | Seguridad WordPress: capabilities/nonces/sanitize/escape/SQL/AJAX/filesystem (consolidar RG-SEC) |
| G4 | Privacidad del propio plugin: requests externos, telemetría, datos guardados, cookies |
| G5 | Plugin Check oficial: 0 errores inexplicados; warnings revisados y documentados |
| G6 | Compatibilidad: clean install / activar / desactivar / reactivar / uninstall / upgrade / versiones mínimas |
| G7 | Packaging: ZIP producción reproducible, sin artefactos dev, ≤10MB |
| G8 | readme.txt completo (description/installation/FAQ/changelog/screenshots) |
| G9 | Assets directorio: icon/banner/screenshot |
| G10 | Submission: cuenta WP.org, envío, evidencia |
| G11 | Post-aprobación: SVN trunk/tags/1.2.0, stable tag, verificación final |

## Decisiones previas que aplican
- FREE ≠ trialware: funcionalidad gratuita completa + upgrade opcional PRO (frontera FREE-011)
- No publicar en SVN hasta pasar todos los gates (no existe botón deshacer)
- Nombre/slug del directorio se decide ANTES del submission

## Reglas
- Cada warning de Plugin Check se documenta con decisión (aceptado/corregido), no solo "pasa"
- Ningún dato del usuario sale del sitio (verificar y declararlo en README/readme)
- Cambios mínimos: este SPEC no reabre motores ni FREE-001..013 salvo defecto real para distribución
