# WooPrivacy (FREE)

**Assessment & Guidance de privacidad para tiendas WooCommerce bajo la [Ley 21.719](https://www.bcn.cl/leychile/navegar?idNorma=1185493) de Chile** — vigente desde el **01-diciembre-2026**.

> *WooPrivacy FREE te ayuda a entender qué aspectos de privacidad debes revisar en tu tienda WooCommerce y qué deberías abordar primero.*

---

## Qué hace

| Capacidad | Descripción |
|-----------|-------------|
| 🧭 **Perfil de tienda** | 9 preguntas mínimas que definen qué aplica a tu negocio |
| 📚 **Catálogo normativo** | 9 obligaciones y 29 controles derivados de la ley, con citas a artículos |
| 🎯 **Aplicabilidad** | Qué te aplica, qué no, y qué necesita confirmación — con razones explicadas |
| ✍️ **Evaluación** | Estado por punto con procedencia: lo declaras tú o lo detecta el sistema |
| 📊 **Diagnóstico honesto** | Prioridades y brechas en contadores claros — **sin porcentajes falsos de "cumplimiento"** |
| 🗺️ **Roadmap** | Qué significa cada brecha, por qué importa y qué hacer, ordenado por prioridad |
| 🔍 **Evidencia del entorno** | Observaciones técnicas opcionales que tú decides adoptar |
| 🖨️ **Reporte & CSV** | Documento imprimible para conservar o compartir |

## Qué NO es

- ❌ No es un **certificado de cumplimiento legal** ni asesoría jurídica
- ❌ No implementa ni automatiza controles (evalúa y orienta)
- ❌ No modifica datos de tu tienda (verificado — ver abajo)

## No destructivo, demostrado

WooPrivacy FREE se instala en plataformas que manejan dinero, así que esta propiedad está **respaldada por evidencia**, no por promesa:

1. **Estático** — sus únicas escrituras son 4 options propias (`chilean_dp_*`); cero SQL directo, cero HTTP externo, cero dependencias vendor.
2. **Estructural** — sus hooks son solo de administración; checkout, carrito, pagos, emails, REST y cron son inalcanzables por construcción.
3. **Dinámico** — ciclo completo ejecutado sobre una tienda con productos, stock, cupón, cliente y pedidos: **15 tablas de negocio idénticas antes y después**, y la desinstalación elimina solo sus propios datos.

Auditoría completa: [`specs/release-gate-rg-sec/`](specs/release-gate-rg-sec/).

## Requisitos

| | |
|--|--|
| WordPress | ≥ 6.0 |
| WooCommerce | Activo |
| PHP | ≥ 7.4 |

## Instalación

1. Copia el contenido de [`src/`](src/) como carpeta del plugin en `/wp-content/plugins/chilean-data-protection/`
   (o descarga el zip del [release v1.0.0](../../releases/tag/v1.0.0) e instálalo desde *Plugins → Añadir nuevo*).
2. Actívalo y abre el menú **WooPrivacy**.
3. El diagnóstico inicial funciona de inmediato; el perfil afina los resultados.

## Estructura del repositorio

```text
src/            Plugin instalable (slug técnico: chilean-data-protection)
specs/          Trazabilidad EDSE completa: FREE-001..012 + Release Gate RG-SEC
knowledge/      Base de conocimiento normativa (Ley → obligaciones → controles)
docs/           Texto íntegro de la Ley 21.719
docker/         Entorno de desarrollo (WordPress + WooCommerce + MySQL)
```

## Metodología

Construido con **Evidence-Driven Software Evolution**: cada SPEC congela contrato, decisiones con evidencia mínima E3, regresiones automatizadas y gates de calidad. El release v1.0.0 pasó además un gate de seguridad y no-destructividad ([`specs/release-gate-rg-sec/`](specs/release-gate-rg-sec/spec.md)).

## Licencia

[GPL v2 o posterior](https://www.gnu.org/licenses/gpl-2.0.html)

## Roadmap FREE / PRO

FREE observa → evalúa → explica → orienta → reporta.
La capa de implementación, automatización, evidencia continua y acreditación corresponde a la línea **WooPrivacy PRO** (mismos identificadores conceptuales, frontera documentada en [`specs/free-011-free-pro-boundary/`](specs/free-011-free-pro-boundary/spec.md)).
