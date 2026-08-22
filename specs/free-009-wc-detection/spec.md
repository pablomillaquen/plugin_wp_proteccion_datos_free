# SPEC-FREE-009: WooCommerce Environment Detection

**Created**: 2026-08-21
**Status**: APPROVED & FROZEN — v1.0 congelado (2026-08-21). Invariantes RD1-RD3 congelados.
**Type**: Feature (capa de evidencia) — capacidad F8 del contrato FREE-001
**Regla del usuario**: "detección técnica, sí; promesas de cumplimiento, no". Una observación técnica NUNCA es una conclusión jurídica.

## Alcance real de la detección

> WooPrivacy observa aspectos técnicos de la instalación y aporta EVIDENCIA para el assessment. No verifica cumplimiento.

| Dimensión | Método técnico | Valor honesto |
|-----------|---------------|---------------|
| customer_accounts | opción WC `woocommerce_enable_myaccount_registration` | true/false |
| newsletter | plugins conocidos activos (mailpoet, newsletter…) | true o **null** (sin plugin no significa sin newsletters) |
| analytics | plugins conocidos (site-kit, monsterinsights…) | true o null |
| cookies | plugins cookies/CMP conocidos | true o **null** (scripts manuales no observables) |
| third_parties | pasarelas de pago activas ≠ offline (bacs/cheque/cod) | true/false |
| (info) | wp_version · wc_version · ssl | metadatos del snapshot |

Fuente: siempre `auto-detected`. Snapshot en option propia `chilean_dp_detections` — **ningún motor congelado fue modificado**.

## Relación detección↔declaración (vista de evidencia)

match · mismatch · unconfirmed (detectado, sin declarar) · undetected (sin evidencia técnica).

## Reglas

| # | Regla |
|---|-------|
| RD1 | La detección nunca muta perfil ni aplicabilidad por sí sola. Solo el acto explícito del usuario ("Usar detección") escribe vía save_answers() frozen; source sigue siendo user-declared |
| RD2 | Sin evidencia técnica ⇒ null ⇒ undetected; jamás se infiere un false afirmativo |
| RD3 | Los mismatches se muestran como discrepancia informativa, no como error ni incumplimiento |

## Superficie

Panel "Evidencia del entorno" en Dashboard (aditivo, justificado por esta SPEC): tabla aspecto/detección/respuesta/estado + botón "Usar detección" solo en mismatch/unconfirmed.

## Gates
G1 snapshot persistido con meta · G2 relaciones correctas en 4 estados · G3 adopción round-trip vía UI HTTP · G4 nulls honestos · G5 fuente auto-detected preservada · G6 motores congelados intactos.
