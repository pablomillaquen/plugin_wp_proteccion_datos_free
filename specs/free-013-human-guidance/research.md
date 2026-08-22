# Research — SPEC-FREE-013

## Origen
F-EVAL-08 (findings-origin.md): primera prueba exploratoria real del producto por el dueño como usuario lego. Patrón sistemático: contenido escrito en lenguaje jurídico-técnico; preguntas repetidas "¿dónde?", "¿lo detecta el plugin?", "¿cómo lo hago?".

## Decisión arquitectónica: overlay vs mutar catálogo
**D-F1301 — Capa overlay separada** · ACCEPTED · HIGH
- catalog.json v1.0.0 FROZEN no se toca: la estructura normativa (IDs, refs, estados, aplicabilidad) es estable y es lo que PRO reutilizará.
- El contenido humano evoluciona más rápido que el derecho: merece versionado propio (guide-content.json v1.x).
- Precedente de capa aditiva sobre frozen ya validado (FREE-009 panel, FREE-012 notas).

**D-F1302 — Dashboard consume overlay directamente**
ACCEPTED · HIGH · GuidanceEngine intacto (I1). El enriquecimiento es presentación.

**D-F1303 — detection_capability derivado + nota manual**
ACCEPTED · MEDIUM · Cada control declara auto/manual/mixed alineado con evaluation_method del catálogo; la nota explica exactamente qué ve WooPrivacy y qué no (honestidad RD2 de FREE-009).

## Transformaciones aprobadas (muestras del análisis completo)
Ver findings-origin.md y conversación: opt-in→"Consentimiento separado de la compra"; registro consentimiento→"Guarda una prueba..."; canal→"Indica a tus clientes..."; bloqueo→"Puedes detener temporalmente..." (+explícito "WooPrivacy NO lo hace"); sensibles→reformulado sin inducir borrado; conservación→pedagógica sin plazos inventados.

## Riesgos
| # | Riesgo | Mitigación |
|---|--------|-----------|
| R1 | Contenido humano introduce matiz jurídico incorrecto | I5/I6/I7 + revisión cruzada contra obligations-map |
| R2 | Overlay diverge de futuras versiones de catálogo | Clave por control_id; loader fail-closed si falta entrada → cae a texto base |
| R3 | Tarjetas demasiado largas | Detalles desplegables; prueba dueño valida lectura |
