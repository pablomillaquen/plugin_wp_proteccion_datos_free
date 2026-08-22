# SPEC-FREE-003: Compliance Profile

**Created**: 2026-08-21
**Status**: APPROVED & FROZEN — Profile v1.0 congelado (2026-08-21); cambios a preguntas/derivación vía versión nueva
**Type**: Feature (produce incremento verificable: perfil estructurado + UI mínima + persistencia)
**Contrato base**: FREE-001 FROZEN — capacidad **F1**. Resuelve **PI-F03** (preguntas exactas del perfil).
**Insumos**: Catalog v1.0.0 FROZEN (dimensiones de aplicabilidad), knowledge/applicability/criteria-notes.md

> **Disciplina MVP (instrucción del usuario)**: cada campo del perfil debe pasar el filtro
> *"¿Esta información cambia realmente la aplicabilidad de alguna de las 29 evaluaciones?"*
> Si no lo cambia, no entra al MVP.

---

## Context

### Current State

- Catalog v1.0.0 congelado: 29 controles; **11 condicionales** (dependen de dimensiones) y **18 siempre aplicables**.
- Dimensiones declaradas en `meta.applicability_dimensions`: 10 (9 declarativas + `consent_processing` derivada).
- El Applicability Engine (FREE-004) necesita el perfil como entrada; hoy no existe forma de capturarlo.

### Problem Statement

Sin un perfil mínimo formalizado, FREE-004 tendría que inventar criterios o preguntar en exceso. A la inversa, un perfil sobre-dimensionado viola P5 y agrega fricción sin cambiar evaluaciones.

### Goals

1. Conjunto **mínimo** de preguntas: exactamente una por dimensión declarativa usada por ≥1 control.
2. Estructura de perfil versionada (`Store` → characteristics / processing_context / integrations / derived / meta).
3. Regla de derivación para `consent_processing`.
4. Semántica explícita para pregunta sin responder (`null` = UNKNOWN downstream, nunca NOT_APPLICABLE).
5. Persistencia mínima y captura vía página admin funcional.

### Non-Goals

- No se construye el motor que evalúa condiciones (FREE-004 solo recibirá `get_profile()`).
- No hay detección automática de entorno (FREE-009): todas las respuestas son `user-declared` en este MVP.
- No se rediseñan páginas existentes del scaffold (FKN-003).

---

## Análisis de cobertura dimensión → controles afectados (v1.0.0)

| Dimensión | Controles que la consumen | ¿Pregunta en MVP? |
|-----------|---------------------------|-------------------|
| customer_accounts | DATA-MIN (any_of con checkout_data) | SÍ |
| checkout_data | CHECKOUT-NOTICE, DATA-MIN | SÍ |
| direct_marketing | NEWSLETTER (any_of con newsletter) | SÍ |
| newsletter | NEWSLETTER | SÍ |
| analytics | THIRDPARTY-INV (any_of con third_parties) | SÍ |
| cookies | COOKIES | SÍ |
| third_parties | THIRDPARTY-INV, THIRDPARTY-DPA | SÍ |
| special_categories | SENSITIVE-EXCL | SÍ |
| international_transfers | TRANSFERS-DECL | SÍ |
| consent_processing | CONSENT-MECH/REG/REV | DERIVADA (no se pregunta) |

Resultado del filtro MVP: **9 preguntas** — ninguna sobra (todas cambian aplicabilidad de ≥1 control), ninguna falta.

Hallazgo estructural: 18/29 controles son incondicionales → el assessment arranca con valor aunque el usuario no responda nada (solo los condicionales quedan "requieren revisión").

---

## Modelo del perfil

```text
Store Profile (option chilean_dp_profile, profile_version)
├── characteristics      → customer_accounts, checkout_data
├── processing_context   → direct_marketing, newsletter, analytics, cookies, special_categories
├── integrations         → third_parties, international_transfers
├── derived              → consent_processing (regla D-F302)
└── meta                 → answered_at, source="user-declared", profile_version
```

Valores: `true / false / null` (null = sin responder).

### Reglas de semántica

| Regla | Definición |
|-------|------------|
| RS1 | `null` nunca implica NO aplicable; el engine (FREE-004) lo tratará como *requires review* |
| RS2 | Derivación D-F302: si algún input es `null`, el derivado es `null` salvo que otro input sea `true` (true domina) |
| RS3 | Guardar respuestas actualiza `answered_at` y preserva valores previos para campos no enviados |

### D-F302 — Derivación de consent_processing

```text
consent_processing = direct_marketing OR newsletter OR analytics OR cookies
```

Justificación: los tratamientos típicos basados en consentimiento en e-commerce son marketing, newsletters, analítica y cookies no esenciales. Si alguno existe → hay tratamientos que requieren consentimiento. Si todos son explícitamente `false` → `false`. Con `null`s y ningún `true` → `null`.

## Decisiones

| ID | Decisión | Confianza |
|----|----------|-----------|
| D-F301 | Persistencia: única option WP `chilean_dp_profile` (array serializado); sin tablas nuevas (P5) | HIGH |
| D-F302 | Derivación consent_processing = OR(direct_marketing, newsletter, analytics, cookies); true domina sobre null | MEDIUM — provisional, revisable con uso real |
| D-F303 | Captura: página admin propia "Perfil" bajo menú chilean-dp; form con nonce; sanitize a bool/null; capability manage_woocommerce | HIGH |
| D-F304 | Las 9 preguntas son user-declared; clasificables como tal desde ya (alineado a state-model) | HIGH |

## Quickstart — Gates

G1 cobertura completa dimensión↔pregunta · G2 filtro MVP documentado · G3 persistencia round-trip E2E · G4 derivación correcta (casos true/false/null) · G5 seguridad (nonce+capability+sanitize) · G6 sin regresiones admin.

Ver `quickstart.md`.
