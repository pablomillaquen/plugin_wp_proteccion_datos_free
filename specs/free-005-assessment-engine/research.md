# SPEC-FREE-005 Research

## Decisiones

### D-F501 — Option única, sobrescritura con metadatos
**Status**: ACCEPTED · Type: TECHNICAL · Confidence: HIGH
- `chilean_dp_assessments` (autoload off). Sin historial de cambios (P5); trazabilidad mínima = assessed_at + source. Historial/auditoría es territorio PRO.

### D-F502 — NOT_APPLICABLE excluido del enum evaluable
**Status**: ACCEPTED · Type: POLICY · Confidence: HIGH
- NOT_APPLICABLE nace solo del motor (FREE-004). Un admin no puede "declarar" no-aplicabilidad: eso evitaría que decisiones del usuario contaminen la capa normativa.

### D-F503 — Vista passthrough puro
**Status**: ACCEPTED · Type: ARCHITECTURAL · Confidence: HIGH · Evidence: E2E INV2
- get_assessment_view() copia applicability tal cual + assessment aparte. CERO lógica de conversión cruzada — FREE-006 decidirá interpretaciones.

### D-F504 — Evaluaciones huérfanas se conservan visibles
**Status**: ACCEPTED · Type: OPERATIONAL · Confidence: MEDIUM
- Si un control pasa a NOT_APPLICABLE tras cambio de perfil, su evaluación previa permanece en storage y visible en la vista (INV5). No se borra silenciosamente: traza para el diagnóstico y para detectar evaluaciones obsoletas.

### D-F505 — retract() explícito
**Status**: ACCEPTED · Type: TECHNICAL · Confidence: HIGH
- La corrección administrativa retira evaluaciones explícitamente; sin borrados automáticos.

## Hallazgos
- 19/19 PASS primera corrida: los invariantes exigidos (INV1–INV5) resultaron directamente testeables gracias a que las capas ya estaban separadas por diseño.
- UNKNOWN(user) vs not-verifiable(source) vs PENDING(status): tres incertidumbres distintas que conviven sin colisionar; quedará reflejado así en FREE-006.
