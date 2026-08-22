# Quality Gates — SPEC-FREE-003

| Gate | Criterio | Estado |
|------|----------|--------|
| G1 | Cobertura dimensión↔pregunta completa (9 declarativas) | PASS |
| G2 | Filtro MVP: cada pregunta modifica ≥1 aplicabilidad | PASS |
| G3 | Persistencia round-trip verificada | PASS |
| G4 | Derivación correcta en casos true/false/null | PASS (tras fix F3-01) |
| G5 | Nonce + capability + sanitización tristate | PASS (403 demostrado) |
| G6 | Sin regresiones en páginas admin existentes | PASS |

## Reglas de bloqueo
- Cambios a las 9 preguntas tras aprobación = versión nueva del perfil (profile_version).
- La derivación D-F302 solo puede modificarse con decisión documentada.
