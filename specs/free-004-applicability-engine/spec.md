# SPEC-FREE-004: Applicability Engine

**Created**: 2026-08-21
**Status**: APPROVED & FROZEN — Engine v1.0 congelado (2026-08-21)
**Type**: Feature (motor puro, sin UI) — capacidad F3 del contrato FREE-001
**Insumos congelados**: Catalog v1.0.0 + Profile v1.0

> Regla de separación: FREE-004 determina **qué aplica**. La evaluación de estado es FREE-005; el diagnóstico/priorización es FREE-006.

## Objetivo

Consumir `Catalog` + `Profile` y producir, por control:

```text
APPLICABLE | NOT_APPLICABLE | REQUIRES_REVIEW (+ razones preservadas)
```

## Requisito central (instrucción del usuario)

REQUIRES_REVIEW **no equivale a UNKNOWN**: cada resultado conserva el array `reasons[]` con código, fuente y detalle:

| reason.code | source | Detalle |
|-------------|--------|---------|
| PROFILE_UNKNOWN | compliance_profile | dimensiones null que impiden concluir (lista incluida) |
| KNOWLEDGE_PENDING | catalog | control marcado requires_review; incluye knowledge_reference (KD-NNN) |

Pueden coexistir ambas razones en un mismo control.

## Semántica de evaluación de condiciones (D-F401)

- `{}` → APPLICABLE incondicional.
- Condición `{dimension, equals}`: MATCH si valor===equals; MISMATCH si difiere (definido); UNKNOWN si valor null.
- Grupo `all_of`: cualquier MISMATCH → grupo FALSE; algún UNKNOWN sin MISMATCH → UNKNOWN; resto TRUE.
- `any_of`: algún grupo TRUE → APPLICABLE; TODOS FALSE → NOT_APPLICABLE; en otro caso REQUIRES_REVIEW.
- Derivado `consent_processing` se evalúa como dimensión más (ya calculado por Profile v1.0).

## Rollup por obligación

Obligación: APPLICABLE si ≥1 control APPLICABLE; si no, REQUIRES_REVIEW si ≥1 REVIEW; si no, NOT_APPLICABLE.

## Fuera de alcance

Evaluación de estado del usuario, persistencia de resultados, UI/dashboard, prioridades (FREE-005/006/008).

## Gates

G1 matriz E2E 18/18 · G2 razones preservadas (códigos+dimensiones+KD refs) · G3 rollup correcto · G4 sin regresiones admin · G5 sin fugas de alcance (no evalúa estados, no persiste).
