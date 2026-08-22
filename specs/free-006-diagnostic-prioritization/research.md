# SPEC-FREE-006 Research

## Decisiones
### D-F601 — Contadores, no scores
ACCEPTED · POLICY · HIGH · P2/R2. Los 8 contadores del summary son los únicos agregados; gate anti-score automatizado impide regresiones.

### D-F602 — gap_priority derivada del catálogo, no del usuario
ACCEPTED · ARCHITECTURAL · HIGH. La severidad de brecha hereda priority del control (HIGH→alta). Evita que el usuario rebaje sus propias brechas críticas. Reordenamiento fino será tema de FREE-007.

### D-F603 — unknown_state separado de requires_review
ACCEPTED · OPERATIONAL · HIGH. Incertidumbre declarada por el usuario (assessment UNKNOWN) ≠ incertidumbre del sistema (REVIEW por perfil/KD). Contadores separados preservan la distinción para FREE-006+ y PRO.

### D-F604 — Motor puro stateless
ACCEPTED · SCOPE · HIGH. generate() recalcula siempre sobre capas congeladas; snapshots históricos son FREE-010/PRO.

## Hallazgos
| ID | Descripción | Estado |
|----|-------------|--------|
| F3-02→F6-01 | 6 fallos iniciales del E2E fueron expectativas mal escritas del test (olvido del overlay KD sobre incondicionales; prioridades reales COOKIES/INVENTORY=HIGH). Motor correcto desde el primer momento | DOCUMENTED |
