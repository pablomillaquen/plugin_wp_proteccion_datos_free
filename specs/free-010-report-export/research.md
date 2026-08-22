# Research — SPEC-FREE-010
## Hallazgos
| ID | Descripción | Estado |
|----|-------------|--------|
| F10-01 | Gate anti-score ingenuo sobre HTML completo: falso positivo 'porcentaje' = frase del PROPIO disclaimer negándolo (patrón ya visto en G4/FREE-001); además matches CSS width:100% | DOCUMENTED — gate refinado a texto visible excluyendo style/script y la negación del disclaimer |
| F10-02 | esc_url() escapa & como &#038;; un test que reconstruye URLs desde HTML debe decodificar TODAS las entidades (&#038; y &amp;) o corta la query en '#' | FIXED (lección operativa) |

## Decisiones
(ver spec.md D-F1001..F1004) — ninguna modificación a motores FREE-001..009.
