# Research — SPEC-FREE-008

## Decisiones
### D-F801 — Server-rendered PHP, sin build tooling
ACCEPTED · TECHNICAL · HIGH · P5: formularios nativos + nonce + admin.css; sin frameworks ni bundlers.

### D-F802 — La UI jamás calcula: consume generate() de FREE-007
ACCEPTED · ARCHITECTURAL · HIGH. Toda etiqueta/mensaje/agrupación proviene del contrato FREE-007; la UI solo añade formularios de captura (que delegan en Assessment Engine v1.0).

### D-F803 — Evaluaciones desde UI siempre source=user-declared
ACCEPTED · POLICY · HIGH. auto-detected llegará solo vía FREE-009; not-verifiable no es seleccionable manualmente.

### D-F804 — Secciones vacías se omiten (no "0 items")
ACCEPTED · UX · MEDIUM. Reduce ruido; el aviso de atención ya comunica lo pendiente.

## Hallazgos
| ID | Descripción | Estado |
|----|-------------|--------|
| F8-01 | Scan anti-score ingenuo sobre HTML admin completo produce falsos positivos (URL-encoding %XX de scripts core y nombres de clases WC como ProductRating) | DOCUMENTED — gate refinado: escanear región propia del plugin excluyendo scripts |
| F8-02 | Quoting anidado docker exec + wp eval falla silencioso | Lección operativa: usar archivos eval-file para verificaciones |

## Trazabilidad hallazgos MVP
F-EVAL-01 → RESUELTO aquí (superficie real). F-EVAL-02 → labels de FREE-007 renderizados tal cual. F-EVAL-03 → aviso visible arriba del todo.
