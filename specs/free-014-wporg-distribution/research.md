# Research — SPEC-FREE-014

## Decisiones
| ID | Decisión | Razón |
|----|----------|-------|
| D-F1401 | Marca pública → **DataRights for WooCommerce**; slug futuro `datarights-for-woocommerce` | Plugin Check: "woo" término restringido por marca WooCommerce/Automattic; auditoría verificó 4 slugs libres, sin conflictos de mercado; descartado ARCO+ por colisión con arco.legal (SaaS chileno del mismo nicho) |
| D-F1402 | Identidad pública ≠ implementación: `wooprivacy_*`/`chilean-data-protection` intactos | Refactor masivo = regresiones sin valor actual; separación marca/código documentada |
| D-F1403 | Puertos FREE configurables (WP_PORT/PMA_PORT) tras conflicto con stack PRO en 8080 | Coexistencia de ambos entornos en desarrollo |
| D-F1404 | G9–G11 diferidos a fase distribución externa | Son tareas operativas (cuenta WP.org, diseño assets, trámite), no defectos de producto |

## Hallazgos operativos
| ID | Descripción |
|----|-------------|
| F14-10 | `gh release create` crea tag remoto desde HEAD remoto → secuencia push main/borrar tag/push local/edit --draft=false documentada |
| F14-11 | debug.log root-owned silencia fatales de www-data → trap mu-plugin temporal usado durante debugging (retirado) |
| F14-12 | Mercado chileno 21.719 ya tiene actores: arco.legal, aGo Legal Pro (plugin pago), PrivacyEngine, ProtecciónDatosWeb — valida el nicho Y la necesidad de marca propia diferenciada |

## Evidencia de mercado (búsqueda web 2026-08-22)
Competencia directa en WordPress: aGo Legal Pro USD49.9 (banner+ARCO+workflow+consent log SHA-256). Posicionamiento FREE honesto: assessment/guidance gratuito vs su implementación pagada — frontera FREE/PRO consistente.
