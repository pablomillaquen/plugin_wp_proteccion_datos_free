# SPEC-FREE-002 — Quickstart: Gates

## Definiciones

| Gate | Criterio | Método |
|------|----------|--------|
| G1 Schema compliance | 100% controles y obligaciones pasan validación del loader (campos, tipos, enums, regex IDs, applicability) | E2E: loader en Docker |
| G2 Cobertura | Toda obligación con ≥1 control; ≥2 salvo TRANSFERS (1, justificado) | Tabla cobertura del E2E |
| G3 Trazabilidad legal | Cada obligación cita artículos; cada control referencia obligaciones válidas | Validación loader + muestreo manual vs obligations-map.md |
| G4 Lenguaje | Sin sobrepromesas del producto. **Refinado (F2-03)**: prohibido que EL PRODUCTO prometa cumplimiento o asesoría; recomendar asesoría externa profesional es conducta correcta exigida | grep + revisión contextual de matches |
| G5 Loader E2E | Catálogo carga completo en WordPress real sin fatals; fail-closed demostrado | evidence/e2e-catalog-output.txt + logs de exclusión de corrida rota |
| G6 IDs estables | IDs OBL-* idénticos a knowledge/obligations/catalog.md; renombres CTRL-* documentados en research.md | Comparación manual |

## Resultados (2026-08-21)

| Gate | Estado | Evidencia |
|------|--------|-----------|
| G1 | **PASS** | 29/29 controles + 9/9 obligaciones cargados tras fix F2-02 |
| G2 | **PASS** | Mínimo 1 (TRANSFERS), resto ≥2 — tabla en e2e-catalog-output.txt |
| G3 | **PASS** | Loader valida referencias cruzadas; citas verificadas contra obligations-map.md |
| G4 | **PASS** | 2 matches contextuales = recomendación de buscar asesoría externa (correcto); cero promesas del producto |
| G5 | **PASS** | E2E OK + fail-closed demostrado (25 exclusiones logueadas durante bug F2-02) |
| G6 | **PASS** | 9/9 OBL idénticos; 4 renombres CTRL documentados en research.md |

## Escenarios manuales de verificación (para reviewer)

1. `make -C docker wp eval-file /tmp/catalog-test.php` → debe imprimir `E2E CATALOGO OK`.
2. Corromper un campo de catalog.json (p.ej. priority "ALTA") → el control se excluye con entrada `[chilean-dp][catalog]` en debug.log y el sitio sigue funcionando.
3. Verificar que `CTRL-RIGHTS-IDVERIFY-001` y `CTRL-RETENTION-DECL-001` tienen `requires_review=true` con razón KD-002/KD-001.
