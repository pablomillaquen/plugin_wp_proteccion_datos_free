# Catálogo de Controles (esqueleto borrador FREE)

**Estado**: ESQUELETO — formalización completa en SPEC-FREE-002
**Relación**: Obligación → Control → Criterio de evaluación → Resultado → Recomendación
**Regla P3**: un control describe qué **debe existir**, no cómo implementarlo. FREE nunca exige que la tienda use WooPrivacy PRO.

---

## Formato (propuesto para FREE-002)

```yaml
ID: CTRL-<AREA>-NNN
nombre: ...
obligacion: OBL-XXX-NNN
descripcion: ...
objetivo: ...
aplicabilidad:            # condiciones del Compliance Profile
  <dimension>: true|false|any
metodo_evaluacion: auto|declarativo|mixto
estados: [IMPLEMENTED, PARTIAL, PENDING, UNKNOWN, NOT_APPLICABLE]
recomendacion: ...
prioridad: HIGH|MEDIUM|LOW
```

---

## Controles semilla (ejemplos derivados del Compliance Profile)

### Consentimiento y marketing

- **CTRL-CONSENT-001** — Mecanismo de consentimiento para marketing directo
  - Obligación: OBL-LICITBASE-001 · Aplicabilidad: `direct_marketing = true`
  - Qué evaluar: existe mecanismo de opt-in; el consentimiento es distinguible de otros aceptos; hay información asociada; existe posibilidad de acreditar su obtención; existe vía de revocación
- **CTRL-CONSENT-002** — Registro de consentimientos con prueba
  - Obligación: OBL-LICITBASE-001 · Aplicabilidad: cualquier tratamiento basado en consentimiento
- **CTRL-COOKIES-001** — Gestión de cookies/tecnologías similares
  - Obligación: OBL-LICITBASE-001 + OBL-TRANSPARENCY-001 · Aplicabilidad: `cookies = true`
- **CTRL-NEWSLETTER-001** — Suscripción/baja de newsletter
  - Obligación: OBL-RIGHTS-001 · Aplicabilidad: `newsletter = true`

### Canal de derechos

- **CTRL-RIGHTS-CHANNEL-001** — Canal público sencillo para ejercer derechos
  - Obligación: OBL-CHANNEL-001 · Aplicabilidad: any (siempre aplicable si hay tratamiento)
- **CTRL-RIGHTS-SLA-001** — Control de plazos de respuesta (30+30; bloqueo 2 días hábiles)
  - Obligación: OBL-DSRPROC-001
- **CTRL-RIGHTS-EVIDENCE-001** — Respaldo íntegro de respuestas
  - Obligación: OBL-EVIDENCE-001

### Transparencia

- **CTRL-TRANSP-PAGE-001** — Página de transparencia con los 12 literales representados
  - Obligación: OBL-TRANSPARENCY-001 · Método: mixto (auto-detecta existencia de página; contenido lo declara el usuario)
- **CTRL-PRIVACYPOLICY-001** — Política de privacidad con fecha/versión accesible
- **CTRL-ACCOUNT-001** — Información de responsable y canal de contacto correcta
  - Obligación: OBL-TRANSPARENCY-001 · Aplicabilidad: any

### Datos y proceso

- **CTRL-INVENTORY-001** — La tienda conoce qué datos personales trata y dónde
  - Obligación: OBL-EVIDENCE-001 · Aplicabilidad: any
- **CTRL-RETENTION-001** — Períodos de conservación definidos y comunicados
  - Obligación: OBL-TRANSPARENCY-001
- **CTRL-THIRDPARTY-DPA-001** — Acuerdos con encargados (pasarelas de pago, email, CRM)
  - Obligación: OBL-THIRDPARTY-001 · Aplicabilidad: `third_parties = true`
- **CTRL-TRANSFERS-DECL-001** — Transferencias internacionales identificadas y declaradas
  - Obligación: OBL-TRANSFERS-001 · Aplicabilidad: `international_transfers = true`
- **CTRL-SECURITY-BASICS-001** — Medidas básicas verificables (HTTPS, roles, backups)
  - Obligación: OBL-SECURITY-001 · Método: auto (parcialmente detectable)

---

## Notas para FREE-002

1. Cada control necesita **método de evaluación** definido: `auto` (WooPrivacy lo detecta), `declarativo` (responde el admin), `mixto`.
2. Los controles ligados a KD-001/KD-002 nacen con flag `requires_review: true`.
3. La recomendación de cada control puede apuntar a "implementable en WooPrivacy PRO" (SPEC-FREE-011 define la frontera).
4. Este esqueleto NO es exhaustivo; FREE-002 hará el barrido completo obligación por obligación.
