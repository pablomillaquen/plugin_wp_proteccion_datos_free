# Catálogo de Obligaciones (borrador FREE)

**Estado**: BORRADOR — se congela en SPEC-FREE-002
**Fuente**: `knowledge/law-21719/obligations-map.md` (derivado de PRO SPEC-001, E1)
**Convención de IDs**: compartida con PRO para reutilización futura (Principio P4)
**Regla P3**: el catálogo describe qué **debe existir**; FREE no implementa los controles.

---

## Formato

```yaml
ID: OBL-<AREA>-NNN
nombre: ...
descripcion: ...
referencia: "Art. X"
categoria: rights|channel|procedure|transparency|licitness|accountability|security|third_parties|transfers
prioridad: HIGH|MEDIUM|LOW
```

---

## Catálogo

### OBL-RIGHTS-001 — Garantizar derechos del titular
- **Referencia**: Art. 4
- **Categoría**: rights
- **Descripción**: La tienda permite a los titulares ejercer acceso, rectificación, supresión, oposición, portabilidad y bloqueo sobre sus datos personales.
- **Prioridad**: HIGH

### OBL-CHANNEL-001 — Medios expeditos de ejercicio
- **Referencia**: Art. 10
- **Categoría**: channel
- **Descripción**: Existen mecanismos tecnológicos sencillos, expeditos, ágiles y eficaces para ejercer derechos. Reglas de gratuidad aplicadas (rectificación/supresión/oposición siempre gratis; acceso gratis al menos trimestral).
- **Prioridad**: HIGH

### OBL-DSRPROC-001 — Procedimiento de solicitudes
- **Referencia**: Art. 11
- **Categoría**: procedure
- **Descripción**: Existe procedimiento formal: solicitud escrita con identificación/autenticación, acuse de recibo, respuesta en 30 días corridos (prórroga única +30), respuesta escrita, denegación fundada con aviso de reclamación ante la Agencia, bloqueo temporal en 2 días hábiles cuando aplica.
- **Prioridad**: HIGH

### OBL-EVIDENCE-001 — Acreditación y respaldos
- **Referencia**: Arts. 3.a, 11 inc.3, 14.a
- **Categoría**: accountability
- **Descripción**: El responsable puede acreditar la licitud del tratamiento: conserva respaldo íntegro de respuestas (remisión, fecha, contenido) y registros suficientes de operaciones relevantes.
- **Prioridad**: HIGH

### OBL-TRANSPARENCY-001 — Información permanente accesible
- **Referencia**: Art. 14 ter
- **Categoría**: transparency
- **Descripción**: El sitio mantiene permanentemente accesible la información de los 12 literales (política con versión, responsable, contacto, categorías/finalidades/bases, seguridad, derechos, Agencia, transferencias, conservación, fuente, retiro consentimiento, decisiones automatizadas).
- **Prioridad**: HIGH

### OBL-LICITBASE-001 — Bases de licitud y consentimiento
- **Referencia**: Arts. 3, 12, 13
- **Categoría**: licitness
- **Descripción**: Todo tratamiento cuenta con consentimiento válido o base del Art. 13. Consentimiento revocable. El responsable puede probar el consentimiento otorgado.
- **Prioridad**: HIGH

### OBL-SECURITY-001 — Seguridad del tratamiento
- **Referencia**: Art. 14 quinquies
- **Categoría**: security
- **Descripción**: Medidas técnicas y organizativas apropiadas al riesgo (SSL, control de accesos, backups, registro de incidentes detectados). La seguridad de infraestructura es responsabilidad del host.
- **Prioridad**: MEDIUM

### OBL-THIRDPARTY-001 — Encargados y terceros
- **Referencia**: normativa de encargados / contratos
- **Categoría**: third_parties
- **Descripción**: Los proveedores que tratan datos (pasarelas, CRM, email marketing, analytics) cuentan con cláusulas/acuerdos de encargado adecuados.
- **Prioridad**: MEDIUM

### OBL-TRANSFERS-001 — Transferencias internacionales
- **Referencia**: Art. 27
- **Categoría**: transfers
- **Descricción**: Las transferencias hacia terceros países cuentan con garantías adecuadas; declaradas en transparencia si aplican.
- **Prioridad**: MEDIUM

---

## Notas

1. IDs estables: una vez congelados en FREE-002 no se renombran (compatibilidad PRO futura).
2. Las obligaciones NO implementables por software (p.ej. juicio legal sobre causal de supresión, texto jurídico de política) se evalúan como controles de proceso/documentales.
3. KD-001/KD-002 (deuda de conocimiento de PRO) afectan a OBL-RIGHTS-001 y OBL-DSRPROC-001 → sus controles asociados nacen marcados `requires_review`.
