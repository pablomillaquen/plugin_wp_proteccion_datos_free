# Dimensiones de Aplicabilidad (notas para SPEC-FREE-003/004)

**Estado**: notas de diseño — formalización en Compliance Profile (FREE-003) y Applicability Engine (FREE-004)

---

## Dimensiones del perfil de tienda

| Dimensión | Pregunta de origen | Afecta principalmente a |
|-----------|--------------------|------------------------|
| `customer_accounts` | ¿Permite creación de cuentas? | CTRL-ACCOUNT-*, inventario datos cuenta |
| `checkout_data` | ¿Recopila datos en checkout? | obligaciones sobre pedidos/facturación |
| `direct_marketing` | ¿Realiza marketing directo? | CTRL-CONSENT-001, OBL-LICITBASE-001 |
| `newsletter` | ¿Usa newsletter? | CTRL-NEWSLETTER-001, bajas de email |
| `analytics` | ¿Usa analítica web? | cookies, terceros |
| `cookies` | ¿Cookies o tecnologías similares? | CTRL-COOKIES-001 |
| `third_parties` | ¿Servicios de terceros tratan datos? | CTRL-THIRDPARTY-DPA-001 |
| `special_categories` | ¿Trata categorías especiales? | flujo especial (fuera de alcance estándar) |
| `international_transfers` | ¿Transferencias al exterior? | CTRL-TRANSFERS-DECL-001 |

## Reglas del motor (para FREE-004)

1. El motor distingue 4 salidas por control:
   - **aplicable**
   - **no aplicable**
   - **potencialmente aplicable**
   - **requiere revisión** (información insuficiente — no forzar decisión)
2. Ejemplo conceptual:
   ```
   CTRL-CONSENT-001 → applicability: direct_marketing = true
   CTRL-ACCOUNT-001 → applicability: customer_accounts = true
   ```
3. Detección automática (FREE-009) alimenta dimensiones cuando sea técnicamente verificable; el resto queda `user-declared`.
4. Cada resultado de detección se clasifica: `Detected / Not detected / Unknown / Requires user confirmation` — no inferir más de lo comprobable.
