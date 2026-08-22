# SPEC-FREE-001 — Quickstart: Escenarios de Validación (Gates)

Cada gate produce evidencia en `evidence/`. La SPEC se cierra solo con G1–G6 PASS.

---

## G1 — Contract completeness

**Qué**: los 10 ítems de la orden tienen respuesta explícita en spec.md.
**Cómo**: verificar presencia de §1..§10 y de la respuesta central.
**Esperado**: checklist completo, sin "por definir".

## G2 — Boundary test

**Qué**: cada afirmación de alcance clasifica sin ambigüedad.
**Cómo**: recorrer F1–F10 y exclusiones E1–E12; para cada una preguntar: ¿esto evalúa/orienta (FREE) o implementa/automatiza/acredita (PRO)?
**Esperado**: 0 casos ambiguos. Caso límite esperado: "detección de entorno" = FREE porque observa, no modifica.

## G3 — No-overpromise scan

**Qué**: cero frases prohibidas en todos los documentos del producto.
**Prohibidas**: "% de cumplimiento legal", "cumplimiento garantizado", "automáticamente conforme", "hace cumplir la ley", "asesoría legal".
**Cómo**: búsqueda textual en spec.md/research.md + regla R2 registrada para FREE-002+.
**Esperado**: 0 ocurrencias.

## G4 — KB traceability

**Qué**: todo claim normativo traza a `knowledge/` y de ahí a `docs/ley_21719.md`.
**Cómo**: revisar tabla de trazabilidad de research.md; muestrear referencias (Art. 10, Art. 14 ter, estados).
**Esperado**: 100% de claims con fuente KB.

## G5 — Exclusions justified

**Qué**: toda exclusión tiene justificación.
**Cómo**: revisar E1–E12.
**Esperado**: 0 exclusiones sin "por qué".

## G6 — Flow completeness

**Qué**: el flujo mínimo cubre el arco completo del producto.
**Cómo**: comparar flujo §9 contra la propuesta de valor (§4): ¿el usuario termina sabiendo qué revisar primero y cómo avanzar?
**Esperado**: sí, incluyendo paso de upgrade info.

---

## Resultados

| Gate | Estado | Evidencia |
|------|--------|-----------|
| G1 | **PASS** | evidence/gates-report.md |
| G2 | **PASS** | evidence/gates-report.md |
| G3 | **PASS** | evidence/gates-report.md |
| G4 | **PASS** | evidence/gates-report.md |
| G5 | **PASS** | evidence/gates-report.md |
| G6 | **PASS** | evidence/gates-report.md |
