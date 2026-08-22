# SPEC-FREE-006: Diagnostic & Prioritization

**Created**: 2026-08-21
**Status**: APPROVED & FROZEN — v1.0 congelado (2026-08-21). MVP mínimo real completado.
**Type**: Feature (motor de diagnóstico; sin UI) — capacidad F5 del contrato FREE-001
**Insumos congelados**: Catalog v1.0.0 · Profile v1.0 · Applicability v1.0 · Assessment v1.0
**CIERRA EL MVP MÍNIMO REAL**: Perfil → aplicabilidad → evaluación → diagnóstico.

> Restricción del usuario: NO inventar "compliance score". El diagnóstico responde *¿cómo convertimos resultados en información útil?*, no *¿qué porcentaje calculamos?*. Salida válida esperada: **"N prioridades altas · M controles pendientes · K requieren revisión"**.

## Clasificación diagnóstica por control

| diagnostic_status | Condición |
|-------------------|-----------|
| not_applicable | applicability NOT_APPLICABLE (contado, excluido de brechas) |
| requires_review | applicability REQUIRES_REVIEW (**razones preservadas** en output) |
| unassessed | APPLICABLE sin evaluación |
| implemented / partial / pending | según assessment.status |
| unknown_state | assessment UNKNOWN (incertidumbre declarada) |

## Prioridad de brecha

`gap_priority = alta` si control HIGH y estado pending/partial; `media` si MEDIUM. Deriva del catálogo congelado — no configurable.

## Resumen (únicos agregados permitidos)

prioridad_alta · prioridad_media · requiere_revision · incertidumbres_evaluacion · sin_evaluar · implementados · no_aplicables · total.

**Prohibido** en este y futuros outputs hasta decisión explícita contraria: score, %, semáforos, ratings (verificado automáticamente por gate G-anti-score).

## Áreas

Rollup por obligación (name/priority + contadores por diagnóstico) → identifica áreas con más brechas para FREE-007 roadmap.

## Gates

G1 conteos exactos escenario vacío · G2 buckets con evaluaciones mixtas · G3 razones KD preservadas · G4 áreas rollup · G5 prioritized_gaps · G6 anti-score · G7 regresión admin.
