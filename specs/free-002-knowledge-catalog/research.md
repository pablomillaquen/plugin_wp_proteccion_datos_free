# SPEC-FREE-002 Research — Decisiones y Hallazgos

**Método**: E1 (diseño de esquema) + E3 (validación E2E del catálogo en entorno Docker real).

---

## Decisiones

### D-F201 — Formato del catálogo: JSON canónico + loader PHP con validación

**Status**: ACCEPTED · **Type**: ARCHITECTURAL · **Confidence**: HIGH · **Evidence**: E1
- Resuelve **PI-F02** del contrato FREE-001.
- JSON único (`src/catalog/catalog.json`) = dato puro, no código ejecutable (P3); portable a PRO/Core (P4).
- Loader PHP (`class-catalog-loader.php`): carga → valida campos → cachea (`wp_cache`) → expone. Fail-closed: control/obligación inválido se excluye y se loguea; nunca se sirve un catálogo parcial sin aviso.
- Alternativas descartadas: arrays PHP (mezcla dato/código, riesgo de side-effects), Markdown (no consumible).

### D-F202 — El catálogo no requiere persistencia de usuario

**Status**: ACCEPTED · **Type**: TECHNICAL · **Confidence**: HIGH
- Resuelve la parte de **PI-F01** que corresponde a esta SPEC: el catálogo viaja como archivos del plugin; el almacenamiento de evaluaciones/profile es tema de FREE-003/005.
- Alcance del loader limitado a leer/validar/exponer. Sin lógica de aplicabilidad (FREE-004) ni estados guardados (FREE-005).

### D-F203 — Alcance Catalog v1.0

**Status**: ACCEPTED · **Type**: OPERATIONAL · **Confidence**: MEDIUM
- 9 obligaciones + 29 controles. Toda obligación con ≥1 control; 8 de 9 con ≥2 (TRANSFERS con 1, justificado por ser declaración documental única).
- Cobertura priorizada sobre exhaustividad: v1 es extensible vía `catalog_version`.

### D-F204 — Semántica `requires_review`

**Status**: ACCEPTED · **Type**: POLICY · **Confidence**: HIGH · **Evidence**: R4 contrato FREE-001
- Controles afectados por KD abiertas nacen `requires_review: true` + `review_reason` obligatorio.
- Aplicado a: `CTRL-RIGHTS-IDVERIFY-001` (KD-002 autenticación Agencia), `CTRL-RETENTION-DECL-001` (KD-001 retención tributaria de pedidos).

### D-F205 — Vocabulario de aplicabilidad

**Status**: ACCEPTED · **Type**: ARCHITECTURAL · **Confidence**: HIGH
- `{}` = siempre aplicable. En caso contrario: `{any_of: [{all_of: [{dimension, equals}]}]}` = OR de grupos AND.
- Solo `equals` booleano en v1. Casos OR entre dimensiones se expresan con `any_of`; derivaciones (p.ej. `consent_processing`) serán calculadas por el perfil (FREE-003).
- Limitación documentada deliberadamente: no se introduce un lenguaje de expresiones.

---

## Findings (E3 durante implementación)

| ID | Categoría | Descripción | Resolución |
|----|-----------|-------------|------------|
| F2-01 | Functional/Bug | Recursión infinita: `validate_applicability()` llamaba `$this->load()` mientras el catálogo aún se construía → hang silencioso bajo memory_limit 256M | FIXED — dimensiones conocidas pasadas como parámetro desde `load()` |
| F2-02 | Functional/Bug | Regex de IDs `CTRL-[A-Z]+-\d{3}` rechazaba áreas multi-segmento (`CTRL-RIGHTS-CHANNEL-001`) excluyendo 25/29 controles | FIXED — regex `^(CTRL\|OBL)-[A-Z]+(?:-[A-Z]+)*-\d{3}$` |
| F2-03 | Documentation | Gate anti-sobrepromesa G4 detectaba falsos positivos: "asesoría legal" aparece recomendando buscar abogados (conducta correcta heredada de PRO Gate 2), no ofreciéndola | DOCUMENTED — G4 refinado: prohibido que EL PRODUCTO prometa cumplimiento/asesoría; recomendar asesoría externa es práctica exigida |

Ambos bugs fueron capturados exactamente por los mecanismos diseñados: fail-closed logueó las exclusiones (evidencia positiva) y la verificación E2E detectó la pérdida de cobertura antes de cualquier uso downstream.

---

## Renombres respecto a controles semilla (KB)

| Seed (controls/catalog-draft.md) | Catalog v1.0 | Motivo |
|----------------------------------|--------------|--------|
| CTRL-ACCOUNT-001 (info responsable) | CTRL-TRANSP-CONTACT-001 | Evitar colisión semántica con "cuentas de cliente" |
| CTRL-CONSENT-001 / -002 | CTRL-CONSENT-MECH-001 / -REG-001 | Desambiguación |
| CTRL-RETENTION-001 | CTRL-RETENTION-DECL-001 | Explicita naturaleza declarativa |
| CTRL-SECURITY-BASICS-001 | CTRL-SEC-HTTPS-001 + SEC-ROLES-001 + SEC-BACKUP-001 | Separación evaluación/método |

Los IDs finales quedan congelados al aprobarse esta SPEC (P4). FREE-004+ consumen exclusivamente catalog.json.
