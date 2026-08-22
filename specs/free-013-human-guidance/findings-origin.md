# Hallazgo de Producto — F-EVAL-08: Human-readable compliance guidance

**Fecha**: 2026-08-22 (post-release v1.0.2)
**Origen**: Primera prueba exploratoria real del dashboard por el dueño del producto, actuando como dueño de tienda sin conocimientos jurídicos.
**Método**: Revisión tarjeta por tarjeta en Chrome DevTools + feedback completo documentado por el asistente.

---

## El patrón sistemático

> **FREE-001..012 resolvió correctamente el problema de ingeniería. Falta resolver el problema de comunicación entre el conocimiento jurídico y el usuario no experto.**

El motor hace exactamente lo diseñado: aplicabilidad con razones, incertidumbre preservada, evaluación con procedencia. Pero el **contenido visible** está escrito demasiado cerca del lenguaje de una matriz jurídica y demasiado lejos del lenguaje de un dueño de tienda.

## Evidencia (muestras del feedback real)

### Títulos incomprensibles
- *"Consentimiento opt-in distinguible"* — ¿qué es opt-in?
- *"Registro que prueba el consentimiento"* — no se entiende ni con su texto

### Explicaciones tipo "galleta de la fortuna"
- *"Atender solicitudes sin verificar identidad crea riesgo de suplantación; verificar en exceso obstaculiza el derecho."* — suena a refrán
- *"Una baja rota equivale a seguir tratando sin base."*
- *"Corresponde al responsable probar el consentimiento (Art. 12 inciso final)."* — nada más

### Referencias legales usadas como sustituto de instrucciones
- *"Literal i) del Art. 14 ter; además limita riesgo acumulado..."* — "¿de verdad me vas a dar solamente la referencia y debo buscarla?"

### Preguntas repetidas del usuario (el patrón "¿dónde?")
- *¿Esto es detectado por el plugin? ¿Podemos hacer una prueba?*
- *¿Dónde lo anoto para que el plugin lo detecte?*
- *¿Dónde se hace esto? ¿Cómo se hace?*
- *¿WooCommerce tiene una página de privacidad?*
- *La documentación de cumplimiento ¿existe?*

### Riesgo identificado que debe corregirse
*"Elimínalos del flujo normal"* (datos sensibles) puede inducir al usuario a borrar datos — debe reformularse para NO inducir eliminaciones.

## Requisito formal registrado

> **F-EVAL-08**: Todo control mostrado al administrador debe poder ser entendido y accionado por un dueño de tienda WooCommerce sin conocimientos previos de la Ley 21.719, sin consultar la ley para comprender qué se pregunta, qué revisar, dónde hacerlo y qué evidencia necesita para marcarlo como evaluado.

**Regla complementaria congelada**: *una referencia legal complementa la explicación; nunca la reemplaza.*

## Las cuatro preguntas que cada tarjeta debe responder (hoy mezcladas o ausentes)

1. ¿Qué significa?
2. ¿Qué tengo que revisar? (acción concreta)
3. ¿Dónde lo reviso? (WordPress / WooCommerce / plugin / proveedor / correo)
4. ¿Cómo sé si puedo marcarlo como "Cubierto"? (condición observable)

Más la quinta que evita expectativas peligrosas:
5. ¿Lo detecta WooPrivacy, lo compruebo yo, o es mixto?

## Etiquetas de capacidad de detección (propuesta aprobada en análisis)

| Etiqueta | Significado |
|----------|-------------|
| 🔎 **WooPrivacy lo puede detectar** | Evidencia técnica automática |
| 👤 **Debes comprobarlo tú** | Revisión del administrador |
| 🔎👤 **Detecta una parte** | WooPrivacy aporta evidencia; el admin confirma |

## Respuesta a la duda sobre cambios de perfil

Mensaje requerido en controles condicionados: *"Este punto depende de una respuesta de tu perfil de tienda. Cuando completes o cambies el perfil, WooPrivacy volverá a calcular automáticamente qué controles aplican."* — elimina la sensación de "¿tengo que reinstalar?".

## Prueba de aceptación (8 preguntas por tarjeta)

1. ¿Entiendo qué significa? 2. ¿Entiendo por qué me importa? 3. ¿Sé qué revisar? 4. ¿Sé dónde? 5. ¿Sé si WooPrivacy puede comprobarlo? 6. ¿Sé qué hacer si está mal? 7. ¿Sé cuándo marcarlo "Cubierto"? 8. ¿Entiendo la referencia legal sin abrir la ley?

Si alguna es "no", el contenido no está terminado.
