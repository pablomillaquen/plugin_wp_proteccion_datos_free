# SPEC-FREE-014: WordPress.org Distribution Readiness

**Created**: 2026-08-22
**Status**: ACCEPTED & FROZEN (2026-08-22) — producto congelado en v1.2.2 durante submission
**Base**: v1.2.0 → producto final congelado: v1.2.2 (rebranding DataRights)

## Resultado de gates al cierre

| Gate | Estado | Nota |
|------|--------|------|
| G1 Identidad | ✅ | Headers reales completos |
| G2 Licensing | ✅ GPL v2+ en todo, sin terceros | |
| G3 Seguridad WP | ✅ RG-SEC + Plugin Check 0 errores | |
| G4 Privacidad plugin | ✅ 0 HTTP externo, 4 options propias | |
| G5 Plugin Check | ✅ 7 errores→0; warnings documentados | |
| G6 Compatibilidad | ✅ instalación limpia + flujo HTTP 8/8 + upgrade tags | |
| G7 Packaging | ✅ zip reproducible verificado por descarga | |
| G8 readme.txt | ✅ EN, ≤5 tags | |
| **G9 Assets** | ⏳ DIFERIDO → fase distribución | icon/banner/screenshots pendientes de diseño |
| **G10 Submission** | ⏳ DIFERIDO → fase distribución | requiere username WP.org del usuario |
| **G11 Review/SVN** | ⏳ DIFERIDO → fase distribución | tras aprobación del directorio |

> Los tres diferidos son tareas operativas externas (cuenta, diseño, trámite), no defectos del producto. El código queda congelado; si la revisión de WP.org exige cambios, se documentan como excepción con nueva versión.
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
