# SPEC-FREE-004 Research

## Decisiones

### D-F401 — Trivalor en grupos de condiciones
**Status**: ACCEPTED · Type: ARCHITECTURAL · Confidence: HIGH · Evidence: E2E 18/18
- MISMATCH dentro de all_of hace el grupo definitivamente FALSE aunque haya otros unknowns (un contraejemplo decide el AND); UNKNOWN solo contagia si no hay contraejemplo. any_of exige TODOS los grupos false para NOT_APPLICABLE — un solo true basta.

### D-F402 — KD pending convierte aplicable→REQUIRES_REVIEW
**Status**: ACCEPTED · Type: POLICY · Confidence: HIGH
- Siguiendo instrucción del usuario: la incertidumbre jurídica (KD) no se esconde dentro de APPLICABLE; el control pasa a REVIEW conservando knowledge_reference extraída del review_reason del catálogo (regex KD-\d+).

### D-F403 — Motor puro sin persistencia ni UI
**Status**: ACCEPTED · Type: SCOPE · Confidence: HIGH
- evaluate_all() es stateless sobre Catalog+Profile actuales. Persistir snapshots es decisión de FREE-005/006. Sin página admin: el dashboard llega en FREE-008.

### D-F404 — Rollup mínimo de obligaciones
**Status**: ACCEPTED · Type: OPERATIONAL · Confidence: MEDIUM
- Obligación NOT_APPLICABLE solo si TODOS sus controles lo son (conservador: evita ocultar obligaciones por un único control descartado).

## Hallazgos
- Ningún bug en primera corrida E2E (18/18 PASS). El diseño trivalor del perfil (FREE-003) hizo trivial el motor: null fluye sin casos especiales.
- Cobertura completa confirmada: las 10 dimensiones del catálogo son resolubles con Profile v1.0 — no se requirió una "décima pregunta" (valida la disciplina MVP).
