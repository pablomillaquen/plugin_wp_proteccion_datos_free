# SPEC-FREE-005 — Quickstart

## Resultados: 19/19 PASS — evidence/e2e-assessment-output.txt

Cobertura de tests:
S1 estado limpio · S2 grabación+sanitización+timestamp · S3/S4 rechazo enums/control inexistente sin mutación (INV4) · S5 UNKNOWN+not-verifiable válidos · INV2 passthrough idéntico · INV1 REVIEW no→PENDING (capas separadas incluso al evaluar) · INV5 evaluación sobrevive NOT_APPLICABLE visible · retract ±.

## Escenario manual reviewer
1. wp eval: record CTRL-RIGHTS-CHANNEL-001 IMPLEMENTED user-declared → get_evaluation devuelve status/source/assessed_at/observation.
2. Cambiar perfil hasta hacer NOT_APPLICABLE ese control → view mantiene ambas capas.
3. record con status 'CUMPLE' → ok=false error=status_invalido; option sin cambios.
