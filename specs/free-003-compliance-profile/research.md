# SPEC-FREE-003 Research

## Decisiones

### D-F301 — Persistencia en única option WP
**Status**: ACCEPTED · **Type**: TECHNICAL · **Confidence**: HIGH
- Option `chilean_dp_profile` (autoload=false). Sin tablas nuevas (P5).
- Suficiente para 9 campos tristate + meta; migración a tabla propia solo si FREE-005/012 evidencian necesidad.

### D-F302 — Derivación consent_processing (PROVISIONAL)
**Status**: ACCEPTED (provisional) · **Type**: OPERATIONAL · **Confidence**: MEDIUM
- OR(direct_marketing, newsletter, analytics, cookies); true domina sobre null.
- Provisional: la cobertura real de tratamientos por consentimiento se validará con uso; cambiarla = decisión versionada, no edición silenciosa.

### D-F303 — Captura vía submenú propio "Perfil"
**Status**: ACCEPTED · **Type**: TECHNICAL · **Confidence**: HIGH
- Página admin nueva bajo menú existente chilean-dp; no se toca el scaffold Settings (FKN-003).
- Tristate con hidden input "" para que desmarcar todo envíe null explícito.

### D-F304 — Respuestas clasificadas user-declared desde el origen
**Status**: ACCEPTED · **Type**: POLICY · **Confidence**: HIGH
- meta.source="user-declared"; FREE-009 añadirá auto-detected sin cambiar este contrato.

## Hallazgos

| ID | Categoría | Descripción | Estado |
|----|-----------|-------------|--------|
| F3-01 | Functional/Bug | derive_consent_processing devolvía null cuando todos los inputs eran false (lógica invertida: presencia ≠ verdad) | FIXED — loops explícitos true→null→false |
| F3-02 | Discovery | 18/29 controles incondicionales: el assessment tiene valor incluso con perfil vacío | DOCUMENTED — comunica valor temprano del producto |

## Riesgos

| # | Riesgo | Mitigación |
|---|--------|------------|
| RSK-F31 | Preguntas binarias pueden simplificar de más (p.ej. cookies casi siempre true) | Aceptado para MVP; refinamiento solo vía cambio versionado del perfil |
| RSK-F32 | consent_processing provisional arrastra sesgo hacia "aplicable" | RS1 mantiene nulls como revisión; KD tracking en FREE-006 |

## Trazabilidad KB
- Dimensiones: knowledge/applicability/criteria-notes.md
- Semántica null/estados: knowledge/assessment/state-model.md
