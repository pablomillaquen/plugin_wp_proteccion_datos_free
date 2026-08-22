# Quality Gates — SPEC-FREE-002

| Gate | Criterio objetivo | Estado |
|------|-------------------|--------|
| G1 | 100% entidades pasan validación loader | PASS |
| G2 | Cobertura OBL→CTRL: min 1, ≥2 salvo TRANSFERS justificado | PASS |
| G3 | Referencias legales completas y cruzadas válidas | PASS |
| G4 | Sin sobrepromesas del producto (refinado F2-03) | PASS |
| G5 | E2E en WordPress real + fail-closed demostrado | PASS |
| G6 | IDs estables vs KB, renombres documentados | PASS |

## Reglas de bloqueo

- Ningún gate FAIL permite freeze de catalog_version.
- Cambios a catalog.json tras aprobación = nueva versión semver (no mutación silenciosa).
- Todo nuevo control debe pasar validación del loader antes de merge.
