# SPEC-FREE-002: Knowledge Model & Assessment Catalog

**Created**: 2026-08-21
**Status**: APPROVED & FROZEN — Catalog v1.0.0 congelado (2026-08-21); cambios futuros vía semver (1.1.0/1.0.1)
**Type**: Knowledge/Data (produce incremento verificable: catálogo consumible + loader)
**Base contract**: SPEC-FREE-001 (FROZEN) — capacidades F1 (perfil, definición aquí solo como dimensiones) y F2 (catálogo)
**Primary source**: `knowledge/` + `docs/ley_21719.md`. PRO solo READ ONLY para trazabilidad.
**Resuelve del contrato FREE-001**: PI-F02 (formato catálogo). PI-F01 se resuelve parcialmente (el catálogo no requiere persistencia; almacenamiento de evaluaciones queda en FREE-005).

> **Regla heredada de FREE-001**: definir qué necesita el assessment; NO resolver cómo implementar los controles. El catálogo describe lo que **debe existir** en la tienda; FREE no construye esos mecanismos.

---

## Context

### Current State

- Contrato FREE-001 congelado: 10 capacidades F1–F10, frontera BF1–BF4, restricciones R1–R6.
- Knowledge Base con borradores: 9 obligaciones OBL-* y ~14 controles CTRL-* semilla sin metadatos completos ni formato consumible.
- No existe forma machine-readable de alimentar el futuro Applicability Engine (FREE-004) ni el Assessment Engine (FREE-005).

### Problem Statement

El conocimiento existe pero no es **consumible por software**: está en Markdown narrativo. Sin un catálogo versionado y validado, FREE-004/005/006 tendrían que parsear prosa o re-decidir contenido normativo cada vez.

### Goals

1. Definir el **modelo de conocimiento** formal: entidades Obligación y Control con sus campos exactos y semántica.
2. Producir **Catalog v1.0** versionado, machine-readable, con cobertura completa (toda obligación con ≥1 control).
3. Entregar **loader PHP** que carga, valida y expone el catálogo (fail-closed ante datos inválidos).
4. Congelar IDs estables reutilizables por PRO (P4).

### Non-Goals

- No se construye el Applicability Engine (solo se define el vocabulario de condiciones que usará).
- No se define UI ni preguntas del Compliance Profile (FREE-003).
- No se almacena ninguna evaluación del usuario (FREE-005).
- No se implementan controles (P3).
- No se resuelven KD-001/KD-002: los controles afectados nacen `requires_review`.

---

## Modelo de conocimiento

```text
Ley 21.719
   ↓ cita
OBLIGACIÓN (OBL-*)
   ↓ 1:N
CONTROL (CTRL-*)
   ↓ evalúa
CRITERIO DE EVALUACIÓN (método: auto|declared|mixed)
   ↓ produce
RESULTADO (estado + fuente)
   ↓ genera
RECOMENDACIÓN (+ prioridad, + upgrade hint PRO)
```

### Entidad Obligation

| Campo | Tipo | Reglas |
|-------|------|--------|
| id | string `OBL-<AREA>-NNN` | estable, nunca renombrar |
| name | string | corto |
| description | string | qué exige la ley |
| legal_references | array[string] | citas Art. X |
| category | enum rights/channel/procedure/transparency/licitness/accountability/security/third_parties/transfers | |
| priority | enum HIGH/MEDIUM | |

### Entidad Control

| Campo | Tipo | Reglas |
|-------|------|--------|
| id | string `CTRL-<AREA>-NNN` | estable |
| name | string | |
| obligations | array[id] | ≥1 |
| description | string | qué debería existir |
| objective | string | para qué sirve / riesgo que atiende |
| applicability | object `{any_of:[{all_of:[{dimension,equals}]}]}` | `{}` = siempre aplicable. Top-level OR de grupos AND |
| evaluation_method | enum auto/declared/mixed | quién puede determinarlo |
| states | enum fijo | IMPLEMENTED/PARTIAL/PENDING/UNKNOWN/NOT_APPLICABLE |
| recommendation | string | orientación accionable (lenguaje claro R1) |
| priority | HIGH/MEDIUM | |
| requires_review | bool | true si depende de KD abierta o interpretación provisional |
| review_reason | string? | obligatorio si requires_review=true |

### Vocabulario de aplicabilidad (D-F205)

Dimensiones declaradas en `meta.applicability_dimensions` (las definirá operativamente FREE-003):

`customer_accounts · checkout_data · direct_marketing · newsletter · analytics · cookies · third_parties · special_categories · international_transfers · consent_processing (derivada)`

Semántica v1: `equals` booleano únicamente. Limitación documentada: no hay expresiones OR arbitrarias — casos OR se modelan con grupos `any_of` o dimensiones derivadas del perfil.

### Formato y ubicación (D-F201)

- Archivo único: `src/catalog/catalog.json` — data pura (P3), portable a PRO/Core (P4).
- Campos de versión: `meta.schema_version` + `meta.catalog_version` (semver independientes).
- Loader: `src/includes/core/class-catalog-loader.php` — carga, valida campos requeridos, cachea (`wp_cache`), falla cerrado (control inválido se excluye y se registra en log, nunca se evalúa a medias).

## Alcance de Catalog v1.0 (D-F203)

- 9 obligaciones (todas las del borrador KB).
- 27 controles con metadatos completos.
- Cobertura: toda obligación con ≥2 controles (excepto OBL-TRANSFERS-001 con 1, justificado).
- Controles marcados `requires_review`: los que tocan retención/supresión de pedidos (KD-001) y autenticación del canal (KD-002).

---

## Quickstart — Gates

Ver `quickstart.md`: G1 schema compliance · G2 cobertura obligación→control · G3 trazabilidad legal · G4 lenguaje (sin frases prohibidas) · G5 loader E2E en Docker · G6 IDs estables vs KB.

## Closure Checklist

- [ ] catalog.json validado por loader en entorno real (E3)
- [ ] Gates G1–G6 PASS evidenciados
- [ ] Aprobación usuario → freeze Catalog v1.0
