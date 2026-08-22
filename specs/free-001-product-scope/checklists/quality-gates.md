# Quality Gates — SPEC-FREE-001

Cierre de la SPEC requiere TODOS los gates en PASS.

| Gate | Criterio objetivo | Método de verificación |
|------|-------------------|------------------------|
| G1 | 10/10 ítems respondidos sin placeholders | Inspección spec.md §1–§10 |
| G2 | 0 afirmaciones ambiguas FREE vs PRO | Recorrido F1–F10 + E1–E12 |
| G3 | 0 frases prohibidas | Búsqueda textual |
| G4 | 100% claims normativos con fuente KB | Tabla trazabilidad research.md + muestreo |
| G5 | 12/12 exclusiones justificadas | Inspección E1–E12 |
| G6 | Flujo cubre perfil→diagnóstico→roadmap→upgrade | Comparación contra propuesta de valor |

## Reglas de bloqueo (gating)

- Si cualquier gate FALLA → no se congela contrato, se corrige y re-ejecuta.
- Cambios al contrato tras aprobación del usuario requieren su autorización explícita (spec frozen).
