# SPEC-FREE-001 Research — Decisiones y trazabilidad

**Método**: E1 (inspección de la FREE Knowledge Base y del contrato propuesto). No se re-abrió PRO salvo referencias ya registradas en `knowledge/sources.md`.

---

## Decisiones

### D-F101 — Identidad de producto y renombrado técnico diferido

- **Status**: ACCEPTED · **Type**: OPERACIONAL · **Confidence**: HIGH · **Evidence**: E1
- El producto se llama **WooPrivacy FREE** (contrato, UI futura, documentación).
- El slug técnico actual (`chilean-data-protection`), text-domain, nombre de archivo principal y el mount de Docker permanecen intactos en esta SPEC.
- **Por qué diferir**: renombrar ahora rompería el entorno verificado (volumen docker → `src/` montado como `chilean-data-protection`) sin entregar valor de contrato. El renombrado es trabajo de packaging → FREE-012.
- **Consecuencia**: FREE-002..011 desarrollarán con slug actual; ningún documento de producto usará "Chilean Data Protection" como marca.

### D-F102 — Definición operacional de Assessment & Guidance

- **Status**: ACCEPTED · **Type**: ARCHITECTURAL (conceptual) · **Confidence**: HIGH · **Evidence**: E1 sobre `knowledge/assessment/state-model.md`
- Assessment = aplicabilidad + estado por control + fuente declarada.
- Guidance = significado + relevancia legal + qué debería existir + siguiente acción, ordenado por prioridad.
- Deliberadamente NO incluye ejecución/configuración/automatización (eso define la frontera con PRO).

### D-F103 — Destino del scaffolding `src/`

- **Status**: ACCEPTED · **Type**: TECHNICAL · **Confidence**: MEDIUM · **Evidence**: FKN-003
- Se conserva temporalmente: sigue activo para verificación de entorno (páginas admin renderizan, E3 previo).
- NO forma parte del contrato: sus settings de empresa/DPO serán re-evaluados en FREE-003 (insumo posible del Compliance Profile); su página informativa estática será sustituida por el flujo assessment real desde FREE-002+.
- Riesgo aceptado: convivencia temporal de dos paradigmas dentro de `src/` hasta el reemplazo.

### D-F104 — Alcance funcional congelado en 10 capacidades

- **Status**: ACCEPTED · **Type**: ARCHITECTURAL · **Confidence**: HIGH
- F1–F10 (spec.md §6) es la lista cerrada de capacidades del producto.
- Cualquier capacidad nueva = modificación de este contrato (con aprobación del usuario), no scope creep silencioso.

### D-F105 — Prohibición temprana de scoring

- **Status**: ACCEPTED · **Type**: POLICY · **Confidence**: HIGH · **Evidence**: P2 + instrucción del usuario
- Ninguna SPEC antes de FREE-006 definirá semáforos/scores/porcentajes agregados.
- FREE-006 definirá representaciones permitidas expresando **estado de preparación**, nunca cumplimiento jurídico.

---

## Preguntas abiertas

PI-F01..PI-F05 (spec.md). Todas tienen SPEC destino asignada — ninguna bloquea este contrato.

## Riesgos detectados

| # | Riesgo | Impacto | Mitigación |
|---|--------|---------|------------|
| RSK-F1 | Scope creep hacia implementación en FREE-002 | Alto | Gates G2/G3 + contrato congelado D-F104 |
| RSK-F2 | KD-001/KD-002 resuelven distinto a lo que FREE asumió | Medio | Controles marcados `requires_review`; sincronización explícita con PRO si cambia |
| RSK-F3 | Scaffolding genera confusión de doble paradigma | Bajo | D-F103 + reemplazo progresivo planificado |
| RSK-F4 | Renombrado tardío (FREE-012) obliga a refactor masivo de textos | Bajo | Regla D-F101: documentos de producto ya usan "WooPrivacy FREE" |

## Trazabilidad con la Knowledge Base

| Contrato FREE-001 | Fuente KB |
|-------------------|-----------|
| Definición Assessment (estados/fuentes) | `knowledge/assessment/state-model.md` |
| Obligaciones y controles (F2) | `knowledge/obligations/catalog.md`, `knowledge/controls/catalog-draft.md` |
| Dimensiones de perfil (F1/F3) | `knowledge/applicability/criteria-notes.md` |
| Restricciones normativas (R3/R4) | `knowledge/law-21719/obligations-map.md`, KDs en `knowledge/sources.md` |
| Lenguaje ARCO+/DSR, reglas P2 | `knowledge/glossary/glossary.md` |
| Justificación de exclusiones E2/E10/E11 | `knowledge/sources.md` (clasificación "no necesario") + decisiones PRO D-026 |
