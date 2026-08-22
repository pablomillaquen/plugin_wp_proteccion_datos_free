# SPEC-FREE-001 — Plan

**Estrategia**: SPEC de definición de producto (sin código). Fases cortas, gates como criterio de cierre.

## Fases

### Fase 1 — Contrato (esta SPEC)

| Tarea | Descripción | Estado |
|-------|-------------|--------|
| T101 | Redactar spec.md con los 10 ítems + decisiones | ✅ |
| T102 | Registrar decisiones D-F101..D-F105 y riesgos en research.md | ✅ |
| T103 | Definir gates G1–G6 en quickstart.md | ✅ |
| T104 | Ejecutar G1–G6 y registrar evidencia | ⬜ |
| T105 | checklists/quality-gates.md con criterios de cierre | ⬜ |
| T106 | Aprobación del usuario del contrato | ⬜ |
| T107 | Congelar contrato (commit/tag) → habilita FREE-002 | ⬜ |

### Fase 2 — Handoff a FREE-002

| Tarea | Descripción | Estado |
|-------|-------------|--------|
| T108 | Actualizar AGENTS.md (estado SPEC-FREE-001) | ⬜ |
| T109 | Guardar decisiones en Engram | ⬜ |

## Fuera de plan (explícito)

- Cualquier cambio de código.
- Definición del catálogo definitivo (FREE-002).
- Diseño UI/dashboard (FREE-008).

## Trazabilidad

| Ítem orden usuario | Documento |
|--------------------|-----------|
| 1 propósito | spec.md §Respuesta central.1 |
| 2 usuario objetivo | §2 |
| 3 problema | §3 |
| 4 propuesta de valor | §4 |
| 5 Assessment & Guidance | §5 + D-F102 |
| 6 alcance funcional | §6 (F1–F10) |
| 7 exclusiones | §7 (E1–E12) |
| 8 frontera FREE/PRO | §8 (BF1–BF4) |
| 9 flujo conceptual mínimo | §9 |
| 10 principios/restricciones | §10 (P1–P6, R1–R6) |
