# SPEC-FREE-013: Human Guidance & Actionability

**Created**: 2026-08-22
**Status**: Draft
**Type**: Content/UX (capa de contenido; motores y contratos frozen intactos)
**Origen**: F-EVAL-08 — hallazgo de la primera prueba exploratoria real post-release (`findings-origin.md` en esta carpeta)
**Alcance del release afectado**: v1.0.2 → este SPEC producirá v1.1.0 (minor: mejora sustantiva de contenido, sin cambios funcionales)

---

## Regla rectora

> **El usuario no necesita conocer la Ley 21.719 para utilizar WooPrivacy.**
> La ley está detrás del producto. Cadena objetivo:
> **Ley → interpretación → pregunta concreta → acción → evidencia → evaluación.**
> No: Ley → referencia → "buena suerte".

## Invariantes (NO negociables)

| # | Invariante |
|---|-----------|
| I1 | No modificar motores FREE-001..010 ni sus contratos |
| I2 | No modificar estados ni reglas de aplicabilidad |
| I3 | No modificar IDs de controles |
| I4 | Referencias legales solo con corrección documental verificada |
| I5 | No introducir nuevas conclusiones jurídicas |
| I6 | No inventar plazos legales cuando la ley no fija uno |
| I7 | No recomendar borrar datos sin base normativa clara e instrucción apropiada (caso datos sensibles) |
| I8 | Toda referencia legal acompañada de explicación humana |
| I9 | Toda acción indica QUIÉN la ejecuta: WooPrivacy / administrador / WooCommerce / plugin externo / proveedor |
| I10 | Comprobación manual declarada explícitamente |
| I11 | Detección parcial declarada explícitamente |
| I12 | Incertidumbre jurídica permanece visible |

## Solución técnica (respeta freezes)

**Capa de contenido overlay**, separada del catálogo normativo:

```text
catalog.json v1.0.0 (FROZEN — estructura normativa, IDs, refs)
        +
guide-content.json v1.x (NUEVO — contenido humano versionado por control)
        ↓
Dashboard renderiza tarjeta enriquecida
(Guidance Engine intacto; el overlay es insumo de presentación,
 mismo patrón aditivo ya usado en FREE-009/012)
```

- Archivo nuevo `src/catalog/guide-content.json` + loader propio (`class-guide-content.php`)
- Sin mutar catalog.json ni GuidanceEngine: el Dashboard consulta el overlay por control_id

## Estructura de contenido por control

```json
{
  "CTRL-X": {
    "title": "...",
    "what_it_means": "...",
    "why_it_matters": "...",
    "what_to_check": "...",
    "where_to_check": "...",
    "detection_capability": "auto | manual | mixed",
    "detection_note": "qué detecta WooPrivacy y qué no",
    "how_to_know_covered": "condición observable",
    "legal_explanation": "traducción humana de los artículos citados",
    "pro_notes": null | "texto upgrade NT5"
  }
}
```

## Tarjeta destino (UX)

```text
┌─ [título humano] ──────────────────── [badges estado] ─┐
│ ¿Qué significa?      what_it_means                     │
│ ¿Por qué importa?    why_it_matters                    │
│ ¿Qué debes revisar?  what_to_check                     │
│ ¿Dónde?              where_to_check                    │
│ ¿WooPrivacy puede comprobarlo? 🔎/👤/🔎👤 + note       │
│ ¿Cuándo marcarlo Cubierto?   how_to_know_covered       │
│ ¿Qué dice la ley?    legal_explanation + refs          │
│ [evaluación] [nota] [guardar]                         │
└────────────────────────────────────────────────────────┘
Detalles secundarios desplegables si excede altura.
```

## Reglas editoriales congeladas

| Evitar | Preferir |
|--------|----------|
| "Define..." | "Escribe / configura / revisa..." |
| "Documenta..." | "Guarda una copia de..." |
| "Identifica..." | "Haz una lista de..." |
| "Gestiona..." | "Configura..." |
| "Verifica..." | "Abre X y comprueba Y..." |
| "Considera..." | "Si ocurre X, revisa Y..." |
| "Canal" | "Correo, formulario o página..." |
| "tratamiento" | "uso de los datos" (cuando sea jurídicamente posible) |
| "titular" | "cliente o persona cuyos datos tienes" |
| "responsable" | "tu empresa" (cuando corresponda) |

Prohibiciones: jerga sin glosa (opt-in, DPA, RoPA, HPOS) · frases-oráculo · referencia legal como instrucción · inducir borrado de datos · prometer detección que no existe.

## Mensaje perfil→recalculo (F-EVAL respuesta, redacción final congelada)

En controles condicionados:
> **¿Cambiaste algo en tu tienda?**
> Puedes volver a tu perfil y actualizar tus respuestas. WooPrivacy revisará automáticamente qué aspectos de privacidad aplican a tu tienda.

El usuario nunca necesita entender la palabra "recalcular".

## Definición congelada de "Cubierto"

> **"Cubierto" NUNCA significa "WooPrivacy verificó que cumples la ley".**
> Significa que, según la condición descrita por la tarjeta, el administrador declara que la situación está resuelta.

Mantiene intacta FREE-005 (Applicability ≠ Assessment) y evita falsa certificación por parte de la capa amigable.

## Alcance de trabajo

29 controles × estructura completa (español chileno, dueño de tienda como lector). Ejemplos de transformación aprobados:

- *"Consentimiento opt-in distinguible"* → **"Consentimiento separado de la compra"** (+ qué significa opt-in en el cuerpo)
- *"Registro que prueba el consentimiento"* → **"Guarda una prueba de que el cliente aceptó recibir publicidad"** (con dónde revisarlo: Mailchimp/Brevo/etc.)
- *"Canal público..."* → **"Indica a tus clientes cómo pueden solicitar sus derechos"**
- *"Bloqueo temporal disponible"* → **"Puedes detener temporalmente el uso de los datos de un cliente"** (+ "¿Lo hace WooPrivacy? No...")
- Datos sensibles → reformulado para NO inducir borrado (I7)
- Conservación → pedagógica sin inventar plazos (I6): ejemplo compra vs publicidad

## Gates

G1 invariantes I1–I12 verificados (diff de archivos frozen = 0) · G2 cobertura 29/29 controles con estructura completa · **G3 prueba del dueño 9/9 por tarjeta — pregunta 9 añadida: "¿Sé qué NO hace WooPrivacy en este punto?"** (cubierto internamente por la nota de detección de cada entrada) · G4 reglas editoriales auditadas · G5 etiquetas detección correctas según capacidades REALES actuales del detector · G6 regresión suites existentes · G7 verificación visual Chrome DevTools.

**Fórmula de contenido congelada**: acción + ubicación + límite de detección + criterio de cierre. Cada tarjeta responde *"tengo esta tienda delante, ¿qué hago ahora?"* — sin convertirse en manual genérico de protección de datos.
