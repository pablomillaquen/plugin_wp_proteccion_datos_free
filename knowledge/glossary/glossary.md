# Glosario WooPrivacy FREE

**Fuente parcial**: convención D-026 de PRO (ARCO+ en UI, DSR interno)

| Término | Definición | Uso en FREE |
|---------|-----------|-------------|
| **Titular** | Persona natural a quien pertenecen los datos personales | UI pública y admin |
| **Responsable** | Quien decide el tratamiento (el dueño de la tienda) | UI; FREE asiste al responsable |
| **Encargado** | Quien trata datos por cuenta del responsable | Catálogo controles |
| **Agencia** | Agencia de Protección de Datos Personales de Chile | Siempre mencionada como derecho del titular |
| **ARCO+** | Acceso, Rectificación, Cancelación/Supresión, Oposición + Portabilidad y Bloqueo | **Denominación visible en toda interfaz** |
| **DSR** | Data Subject Request — denominación interna de ingeniería | Solo código/comentarios internos, nunca UI |
| **Ley 21.719** | Nueva ley chilena de protección de datos; vigencia 01-DIC-2026 | Referencia normativa única |
| **Control** | Práctica/mecanismo que debería existir para atender una obligación | Unidad de evaluación FREE |
| **Obligación** | Deber normativo derivado de la ley | Nivel superior del catálogo |
| **Compliance Profile** | Estructura con características/contexto/integraciones declaradas de la tienda | Entrada del motor de aplicabilidad |
| **Assessment** | Proceso de evaluar el estado de los controles aplicables | Función central de FREE |
| **Brecha (gap)** | Control aplicable en estado PENDING o PARTIAL | Base del diagnóstico |
| **HPOS** | High-Performance Order Storage (tablas `wp_wc_orders*`) | Detección técnica WooCommerce |
| **KD-001/KD-002** | Deudas de conocimiento heredadas de PRO (supresión parcial; autenticación exigida por la Agencia) | Marcan controles `requires_review` |

## Reglas de lenguaje (heredadas de Gates de PRO)

1. "asiste/ayuda a evaluar" ≠ "cumple/hace cumplir"
2. Nunca prometer "todos los datos del sitio" — solo lo gestionable/evaluable
3. Nunca "% de cumplimiento legal" — solo estado de preparación
4. Lenguaje claro para administrador no especialista (Gate de legibilidad)
