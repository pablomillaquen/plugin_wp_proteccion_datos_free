# SPEC-FREE-003 — Quickstart: Gates

## Resultados (2026-08-21)

| Gate | Criterio | Estado | Evidencia |
|------|----------|--------|-----------|
| G1 | 9/9 dimensiones declarativas tienen pregunta; derivada no se pregunta | **PASS** | Tabla spec.md |
| G2 | Filtro MVP: toda pregunta cambia aplicabilidad de ≥1 control | **PASS** | Análisis dimensión→controles (spec.md); mínimo: special_categories→1 control, máx: consent_processing→3 |
| G3 | Persistencia round-trip | **PASS** | save_answers→get_option→get_profile; option con 9 dims + meta |
| G4 | Derivación consent_processing correcta | **PASS** | Caso A true / Caso B false (tras fix F3-01) / Caso C null — evidence/e2e-profile-output.txt |
| G5 | Seguridad: nonce + capability + tristate sanitizado | **PASS** | POST sin nonce → HTTP 403 sin guardado; current_user_can('manage_woocommerce') en handle_save y render_page |
| G6 | Sin regresiones admin | **PASS** | chilean-dp/-settings/-info 200 tras cambios |

## Hallazgos de la SPEC

- **F3-01 (FIXED)**: derivación devolvía null en caso "todos false" por lógica invertida del loop. Capturada por los casos de gate G4 antes de que FREE-004 consumiera el valor.
- **Hallazgo estructural positivo**: 18/29 controles son incondicionales → hay diagnóstico útil incluso con perfil vacío.

## Escenarios manuales para reviewer

1. Admin → Datos CL (FREE) → Perfil → responder preguntas mixtas → Guardar → recargar: valores persisten.
2. Marcar todo "Aún no lo sé" → guardar → perfil queda todo null (downstream = revisión).
3. POST a la página sin nonce → 403.
