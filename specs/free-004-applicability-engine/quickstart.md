# SPEC-FREE-004 — Quickstart

## Resultados
Todos los gates PASS — ver evidence/e2e-engine-output.txt (18 checks, 3 escenarios):
A perfil vacío (nulls) · B respondido (definidos) · C OR mixto con unknowns.

## Escenario manual para reviewer
1. Perfil vacío → engine: 29 controles = A(n)+R(29-n), KDs siempre en REVIEW con su referencia.
2. Responder perfil → condicionales migran a APPLICABLE/NOT_APPLICABLE según reglas D-F401.
3. CTRL-RIGHTS-IDVERIFY-001 permanece REQUIRES_REVIEW/KD-002 en TODO escenario (conocimiento pendiente, no información faltante del usuario).
