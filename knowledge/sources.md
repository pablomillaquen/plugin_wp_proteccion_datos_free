# FREE Knowledge Base — Sources & Classification

**Fecha de extracción**: 2026-08-21
**Método**: Knowledge Extraction (Bootstrap) desde proyecto PRO
**Regla inviolable**: PRO es **READ ONLY**. Nunca modificar archivos de PRO.

---

## 1. Fuentes consultadas

| Fuente | Ubicación (PRO) | Qué se extrajo |
|--------|-----------------|----------------|
| SPEC-001 Producto | `specs/001-producto-ley-21719/spec.md` | Definición de producto, hallazgos H-001..H-008, decisiones D-001..D-005, inventario HPOS, matriz transparencia 12 literales, Access Report 16 secciones |
| SPEC-001 Research | `specs/001-producto-ley-21719/research.md` | Análisis legal completo: Arts. 3, 4, 5, 6, 7, 8, 8 ter, 9, 10, 11, 12, 13, 14.a, 14 ter, 14 quinquies; PI-001..PI-008 resueltas; KD-001/KD-002 |
| AGENTS.md PRO | `AGENTS.md` | Estado del proyecto (v0.5.0), convenciones ARCO+/DSR, bugs conocidos, reglas "No Hacer" |
| SPEC-002 Canal DSR | `specs/002-canal-titular-e2e/spec.md` | Decisiones D-006..D-013 (shortcode, modelo datos, verificación, seguridad canal público) |
| SPEC-003 Rectificación | `specs/003-rectificacion-art6/spec.md` | Decisiones D-014..D-028 (whitelist, relectura antes de escritura, billing_email≠user_email, ARCO+ terminología UI) |
| SPEC-004 Supresión | `specs/004-supresion-art7/spec.md` | Decisiones D-029..D-043 (supresión parcial, responsable humano en ciclo, tratamiento por tabla) |
| SPEC-005 Oposición | `specs/005-oposicion/` | En progreso (Research/Fase 0) — solo referencia |
| Ley completa | `docs/ley_21719.md` (copia local FREE, idéntica a PRO) | Texto normativo íntegro |

---

## 2. Clasificación del conocimiento extraído

### Reutilizable (estable, adoptado por FREE tal cual)

- Los **6 derechos del Art. 4**: acceso, rectificación, supresión, oposición, portabilidad, bloqueo
- Mapa artículo → obligación (ver `law-21719/obligations-map.md`)
- Matriz de los **12 literales del Art. 14 ter** para transparencia
- Procedimiento Art. 11: solicitud escrita, acuse de recibo, plazo 30+30 corridos, respuesta escrita con respaldo íntegro, denegación fundada + aviso derecho a reclamar ante Agencia (30 días hábiles), bloqueo temporal 2 días hábiles
- Reglas de gratuidad Art. 10: rectificación/supresión/oposición siempre gratuitas; acceso gratuito al menos trimestralmente; cobro solo por repetición en el trimestre
- Bases de licitud e-commerce: contrato (Art. 13.c), obligación legal (Art. 13.b), interés legítimo (Art. 13.d), consentimiento (Art. 12)
- Inventario de tablas WooCommerce HPOS con PII
- Terminología: interfaz usa **ARCO+**, `DSR` solo interno (D-026)

### Adaptable (concepto PRO transformado al modelo assessment)

- **Obligaciones y controles**: PRO los implementa; FREE los evalúa. El catálogo FREE dice "debe existir X" sin construir X (Principio P3)
- **Estados de decisión PRO** (CORREGIDO/RECHAZADO/ERROR) → inspiran estados de evaluación FREE pero con semántica propia: IMPLEMENTED/PARTIAL/PENDING/UNKNOWN/NOT_APPLICABLE
- **Separación acción vs resultado** (D-027) → FREE separa "fuente de evaluación" (auto-detected / user-declared / not-verifiable)
- Inventario HPOS → dimensiones de detección automática (SPEC-FREE-009)

### No necesario para FREE

- Implementación destructiva de supresión (D-029..D-043 son reglas de ejecución, no evaluación)
- Motor de handlers por tipo de derecho (D-009)
- Mailer, tokens de verificación, rate limiting del canal público
- Reportes HTML/PDF de respuestas DSR
- Whitelist de campos rectificables

### Provisional (marcado así en PRO — FREE lo trata como "requiere revisión")

- **KD-001**: ¿regla "pedidos → obligación tributaria → no supresión" es suficiente?
- **KD-002**: nivel de autenticación que exigirá la Agencia para ejercicio vía web
- **D-004** (PRO): supresión no automatizada — PROVISIONAL
- **D-005** (PRO): acceso ≠ portabilidad — PROVISIONAL
- **D-008** (PRO): verificación por token email — documentada provisional

---

## 3. Relación FREE ↔ PRO

```
WooPrivacy PRO (/Proyectos/plugin_wp_proteccion_datos/)
        │
        │ READ ONLY — fuente de conocimiento
        ▼
FREE Knowledge Base (knowledge/)
        │
        │ adaptado a assessment
        ▼
SPECs FREE-001..012 (specs/)
```

- Sin dependencia operacional: si PRO se pausa, FREE sigue.
- Si FREE detecta inconsistencia en PRO → registrar en `free-knowledge-notes.md`, NO corregir PRO.
- Sincronizaciones futuras = extracciones explícitas nuevas, no dependencia permanente.
