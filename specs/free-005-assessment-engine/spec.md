# SPEC-FREE-005: Assessment Engine

**Created**: 2026-08-21
**Status**: APPROVED & FROZEN — Engine v1.0 congelado (2026-08-21)
**Type**: Feature (mecanismo de evaluación + persistencia; sin UI — dashboard es FREE-008)
**Contrato**: FREE-001 capacidad **F4**. Resuelve el resto de **PI-F01** (persistencia de evaluaciones).
**Insumos congelados**: Catalog v1.0.0 · Profile v1.0 · Applicability Engine v1.0

> **Separación estricta (instrucción del usuario)**:
> Applicability (FREE-004) responde *¿aplica?* → APPLICABLE / NOT_APPLICABLE / REQUIRES_REVIEW
> Assessment (FREE-005) responde *¿en qué estado está?* → IMPLEMENTED / PARTIAL / PENDING / UNKNOWN
>
> - Un control REQUIRES_REVIEW **nunca** se convierte automáticamente en PENDING.
> - NOT_APPLICABLE nunca desaparece sin dejar rastro.
> - Las capas viajan juntas pero separadas en la vista.

---

## Context

FREE-004 entrega aplicabilidad por control. Falta el mecanismo para registrar, persistir y exponer el **estado declarado/detectado** de cada control, con procedencia trazable — base del diagnóstico (FREE-006).

## Modelo de datos (por evaluación)

```text
chilean_dp_assessments (option, autoload off)
└── <control_id>
    ├── status        IMPLEMENTED | PARTIAL | PENDING | UNKNOWN
    ├── source        user-declared | auto-detected | not-verifiable
    ├── assessed_at   timestamp
    └── observation   string opcional (sanitizada)
```

## Decisiones

| ID | Decisión | Confianza |
|----|----------|-----------|
| D-F501 | Persistencia: única option WP; sin tablas (P5); sobrescritura con metadatos (sin historial — P5) | HIGH |
| D-F502 | `NOT_APPLICABLE` NO es un estado evaluable por usuario: viene solo del motor. Enum de assessment lo excluye | HIGH |
| D-F503 | Vista `get_assessment_view()`: capas passthrough — applicability intacto + assessment aparte; cero transformaciones cruzadas | HIGH |
| D-F504 | Evaluaciones sobre controles no-APPLICABLE se conservan si existían (traza), y la vista las muestra ambas capas para que FREE-006 interprete | MEDIUM |
| D-F505 | `retract()` permite retirar una evaluación (corrección administrativa) dejando registro limpio | HIGH |

## Invariantes (verificables)

| # | Invariante |
|---|------------|
| INV1 | Ninguna operación transforma REQUIRES_REVIEW → PENDING ni viceversa |
| INV2 | La vista expone applicability.status idéntico al output de Engine v1.0 |
| INV3 | Toda evaluación almacenada tiene status+source+assessed_at válidos |
| INV4 | Status/source fuera de enum son rechazados sin mutar almacenamiento |
| INV5 | Una evaluación previa NO se pierde si el control pasa a NOT_APPLICABLE |

## Gates

G1 grabación+round-trip · G2 rechazo de enums inválidos sin mutación · G3 invariantes INV1/INV2/INV5 en escenarios combinados · G4 retract · G5 sanitización observación · G6 regresión admin.

Ver `quickstart.md`.
