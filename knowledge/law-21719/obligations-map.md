# Mapa Ley 21.719 → Obligaciones para e-commerce WooCommerce

**Fuente**: Ley 21.719 (`docs/ley_21719.md`) + análisis verificado en PRO SPEC-001 research.md (E1)
**Vigencia**: 01-diciembre-2026
**Alcance**: obligaciones del **responsable** relevantes para una tienda WooCommerce

---

## 1. Derechos del titular (Art. 4)

Todo titular tiene derecho a **acceso, rectificación, supresión, oposición, portabilidad y bloqueo**.
- Personales, intransferibles, irrenunciables; no limitables por convención
- Fallecimiento: los ejercen los herederos
- No se soporta decisión automatizada (Art. 8 bis) en e-commerce estándar — solo se documenta en transparencia si existe

| Derecho | Artículo | Qué implica para la tienda |
|---------|----------|---------------------------|
| Acceso | 5 | Confirmar si trata datos + entregar datos con origen, finalidad, destinatarios, conservación, base de licitud |
| Rectificación | 6 | Modificar/completar datos inexactos o incompletos (principio de calidad) |
| Supresión | 7 | Eliminar salvo excepciones del inc. 2 (p.ej. obligación legal/tributaria sobre pedidos) |
| Oposición | 8 | Detener tratamiento específico (p.ej. marketing) |
| Portabilidad | 9 | Exportar en formato estructurado, genérico, de uso común — datos basados en consentimiento |
| Bloqueo | 8 ter, 11 inc.7 | Suspender tratamiento (no almacenamiento) durante resolución de otra solicitud |

**Nota PROVISIONAL (D-005 de PRO)**: acceso ≠ portabilidad son funcionalidades distintas.

## 2. Medios de ejercicio (Art. 10)

- Mecanismos tecnológicos **expeditos, ágiles y eficaces**; operación **sencilla**
- Gratuidad: rectificación, supresión y oposición siempre gratuitas
- Acceso gratuito al menos trimestralmente; cobro solo por acceso/portabilidad repetido en el mismo trimestre

## 3. Procedimiento de solicitudes (Art. 11)

1. Solicitud **escrita** (email/medio equivalente) con: identificación + autenticación del titular, medio de contacto, datos/tratamiento involucrado, causal (para rectificación/supresión/oposición)
2. **Acuse de recibo** obligatorio
3. Respuesta máx. **30 días corridos**, prorrogable una vez por otros 30
4. Respuesta **por escrito**, guardando respaldo que demuestre remisión, fecha y **contenido íntegro** (inc. 3)
5. Denegación: **fundada** (causa + antecedentes) + informar derecho a reclamar ante la Agencia dentro de **30 días hábiles** (inc. 5)
6. Bloqueo temporal solicitado junto a rectificación/supresión/oposición: responder en **2 días hábiles** (inc. 7)

## 4. Transparencia (Art. 14 ter)

Información permanentemente accesible en el sitio web. **12 literales**:

| Literal | Contenido |
|---------|-----------|
| a) | Política de tratamiento + fecha y versión |
| b) | Identificación responsable, representante, encargado (si existe) |
| c) | Domicilio + canal de contacto para solicitudes |
| d) | Categorías de datos, universo de personas, destinatarios/cesiones, finalidades, base de legitimidad, intereses legítimos |
| e) | Políticas y medidas de seguridad |
| f) | Derechos del titular y cómo ejercerlos |
| g) | Derecho a reclamar ante la Agencia |
| h) | Transferencias internacionales (condicional) |
| i) | Período de conservación |
| j) | Fuente de los datos |
| k) | Retiro del consentimiento (condicional) |
| l) | Decisiones automatizadas / perfilado (condicional) |

## 5. Licitud y consentimiento (Arts. 3, 12, 13)

- Tratamiento lícito solo con **consentimiento** libre, informado, específico, previo e inequívoco (Art. 12) **o** base del Art. 13
- Bases clave e-commerce: contrato (c), obligación legal (b), interés legítimo (d)
- Consentimiento revocable en cualquier momento, sin efectos retroactivos
- El responsable debe **probar** que contó con consentimiento (Art. 12 inc. final)

## 6. Acreditación / accountability (Arts. 3.a, 14.a)

- El responsable debe poder **acreditar la licitud** del tratamiento
- Entregar expeditamente la información cuando se requiera

## 7. Otras obligaciones evaluables

- **Seguridad**: medidas técnicas/organizativas apropiadas (Art. 14 quinquies); seguridad de infraestructura es del host
- **Encargados**: contratos/reglas con procesadores de datos
- **Transferencias internacionales**: garantías adecuadas (Art. 27)
- **Datos sensibles** (Art. 16): e-commerce estándar no los trata; si lo hace → flujo especial
- **Incidentes/vulneraciones**: registro y notificación a la Agencia (acto del responsable)
