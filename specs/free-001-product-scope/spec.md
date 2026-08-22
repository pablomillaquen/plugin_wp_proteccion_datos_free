# SPEC-FREE-001: Product Scope & Architecture — Contrato de Producto WooPrivacy FREE

**Branch**: `main` (sin git inicializado aún en FREE)
**Created**: 2026-08-21
**Status**: APPROVED & FROZEN (2026-08-21 — aprobación del usuario; ver evidence/approval.md)
**Type**: Product Definition (NO programa código)
**Primary Source**: FREE Knowledge Base (`knowledge/`) creada en el Bootstrap
**PRO Access**: READ ONLY, solo para verificar trazabilidad de referencias

> **Este SPEC NO implementa nada.** Congela el contrato del producto: qué es WooPrivacy FREE, qué NO es, y dónde termina FREE para que las SPECs FREE-002+ trabajen dentro de un alcance estable.

---

## Context

### Current State

- Entorno Docker verificado: WP 7.1 + WooCommerce 11.0.1 + PHP 8.2 (`docker/`).
- FREE Knowledge Base completa tras el Bootstrap: mapa legal, catálogo OBL-* borrador, controles CTRL-* semilla, dimensiones de aplicabilidad, modelo de estados, glosario, FKN-001..003.
- Existe scaffolding informativo previo al plan (`src/`, FKN-003): settings de empresa/DPO + página informativa estática. No coincide con el producto Assessment & Guidance.
- PRO existe como producto separado (v0.5.0) y es fuente de conocimiento READ ONLY.

### Problem Statement

Sin un contrato de producto congelado, las siguientes SPECs (FREE-002 en adelante) arrastrarían riesgo permanente de scope creep: reintroducir funcionalidades de implementación propias de PRO (consent management, ejecución de derechos, automatización), o diseñar prematuramente motores/UI/scoring antes de saber qué se evalúa.

### Goals

- Responder de forma inequívoca: ¿qué es WooPrivacy FREE y qué NO es?
- Congelar la frontera FREE/PRO a nivel conceptual.
- Definir Assessment & Guidance en términos operacionales concretos.
- Establecer los principios/restricciones que obligan a FREE-002..FREE-012.
- Decidir el destino del scaffolding actual (`src/`).

### Non-Goals

- No se diseña la implementación detallada de controles.
- No se define esquema de base de datos definitivo (FREE-002+).
- No se diseña UI final ni dashboard (FREE-008).
- No se define scoring, semáforos ni métricas agregadas (FREE-006).
- No se construye el motor de aplicabilidad (FREE-004).
- No se modifica código en este SPEC salvo lo decidido explícitamente sobre el scaffold.

---

## Respuesta central

> **WooPrivacy FREE es un plugin de WordPress/WooCommerce que evalúa el estado de preparación de una tienda frente a la Ley 21.719 y guía al administrador sobre qué debería revisar y abordar primero.**
>
> **No implementa controles de privacidad. No automatiza cumplimiento. No gestiona derechos. Eso es WooPrivacy PRO.**

### 1. Propósito del producto

Convertir el conocimiento normativo de la Ley 21.719 (obligaciones y controles) en un **assessment accionable** para tiendas WooCommerce chilenas: perfil → aplicables → evaluación → diagnóstico → recomendaciones → roadmap.

### 2. Usuario objetivo

El **administrador de la tienda WooCommerce** (responsable de datos en términos de la ley), que:

- no necesariamente es especialista en privacidad ni abogado;
- necesita entender qué le exige la ley vigente desde el 01-DIC-2026;
- decide qué corregir y con qué herramientas (incluida eventualmente PRO).

### 3. Problema que resuelve

La tienda trata datos personales (clientes, pedidos, marketing) pero el administrador **no tiene forma sencilla de saber** qué obligaciones le aplican, qué controles debería tener implementados, ni por dónde empezar. La ley entra en vigencia el 01-DIC-2026 y no existe una herramienta de evaluación orientada al e-commerce chileno.

### 4. Propuesta de valor

> *"WooPrivacy FREE te ayuda a entender qué aspectos de privacidad debes revisar en tu tienda WooCommerce y qué deberías abordar primero."*

Valor = claridad + priorización + orientación. No promete cumplimiento; reduce la incertidumbre.

### 5. Definición operacional de "Assessment & Guidance"

| Término | Significado concreto en FREE |
|---------|------------------------------|
| **Assessment** | Determinar (1) qué obligaciones y controles aplican al perfil de esta tienda; (2) en qué estado está cada control aplicable (`IMPLEMENTED / PARTIAL / PENDING / UNKNOWN / NOT_APPLICABLE`); con fuente declarada (`auto-detected / user-declared / not-verifiable`). |
| **Guidance** | Para cada brecha: explicar qué significa el control, por qué importa (referencia legal), qué debería existir, qué revisar y qué hacer a continuación — ordenado por prioridad (roadmap). |

Lo que **no** incluye: ejecutar/configurar/automatizar controles, registrar evidencia de operaciones, auditar, gestionar solicitudes de titulares.

### 6. Alcance funcional del producto (nivel contrato)

```text
F1  Compliance Profile        — cuestionario mínimo de contexto de la tienda
F2  Catálogo de conocimiento  — obligaciones y controles versionados (datos, no UI)
F3  Applicability             — determinar aplicables / no aplicables / potenciales / requiere-revisión
F4  Assessment                — evaluación de estado por control, persistente
F5  Diagnóstico               — brechas, prioridades, elementos sin información suficiente
F6  Guidance & Roadmap        — explicación y plan ordenado de acciones
F7  Dashboard básico          — flujo guiado install→profile→assessment→results
F8  Detección de entorno      — lo técnicamente verificable de WP/WC (clasificado)
F9  Reporte/Export            — reporte básico exportable
F10 Upgrade path              — señalar dónde PRO implementa lo que aquí solo se orienta
```

Las capacidades F1–F10 se especifican e implementan en FREE-002..FREE-011. Este SPEC solo las enumera y acota.

### 7. Exclusiones explícitas (con justificación)

| # | Excluido | Por qué |
|---|----------|---------|
| E1 | Consent management completo / CMP banner funcional | Implementación propia de PRO; FREE solo orienta |
| E2 | Gestión/ejecución de derechos ARCO+ (canal público, workflows, plazos) | Es el core de PRO (SPEC-002..005); FREE evalúa si existen mecanismos |
| E3 | Gestión de incidentes y notificación de brechas | Acto del responsable; fuera del assessment MVP |
| E4 | Retención/eliminación automática de datos | Automatización = PRO |
| E5 | Repositorio avanzado de evidencia / auditoría | PRO (Evidence) |
| E6 | Registro de actividades de tratamiento (RoPA) completo | Fuera del MVP (P5); posible guía simple futura |
| E7 | Data mapping avanzado, DPA, gestión de encargados | PRO / Core futuro |
| E8 | Integraciones externas complejas (CRM, MailPoet…) | Solo se detectan/declaran, nunca se integran |
| E9 | Scoring tipo "% de cumplimiento legal" | Prohibido por P2; métricas se definen en FREE-006 |
| E10 | Asesoría legal / texto jurídico de políticas | Requiere profesional; FREE orienta, no asesora |
| E11 | Datos sensibles (Art. 16) | Flujo especial fuera del e-commerce estándar (heredado de PRO) |
| E12 | Multi-sitio / SaaS / arquitectura cloud | Alcance single-site WordPress |

### 8. Frontera FREE/PRO

```text
                 WooPrivacy Knowledge (IDs/conceptos compartidos)
                         │
            ┌────────────┴────────────┐
            ▼                         ▼
     WooPrivacy FREE           WooPrivacy PRO
     Assessment                Implementation
     Guidance                  Configuration
     Roadmap                   Automation
            │                  Evidence
            ▼                  Management
     "Qué deberías revisar          │
      y en qué orden"               ▼
            │              "Hecho y acreditado"
            └──────────┬──────────┘
                       ▼
        FREE muestra: Control → Estado → Qué debería
        existir → Qué hacer → "Implementación:
        disponible en WooPrivacy PRO"
```

Reglas de frontera:

- BF1: FREE **nunca** bloquea funcionalidad para vender PRO; la mención a PRO es informativa contextual (detalle técnico en FREE-011).
- BF2: Todo ID de obligación/control/metadato definido en FREE debe ser reutilizable por PRO (P4).
- BF3: Si un control puede auto-implementarse, eso ocurre solo en PRO; FREE siempre lo expresa como evaluación + recomendación.
- BF4: FREE funciona standalone; sin PRO instalado no hay dependencia funcional.

### 9. Flujo conceptual mínimo

```text
Instalar → Welcome
   ↓
Compliance Profile (preguntas mínimas)
   ↓
Obligaciones y Controles aplicables
   ↓
Evaluación por control (estados + fuente)
   ↓
Diagnóstico (brechas, prioridades, revisiones)
   ↓
Recomendaciones y Roadmap
   ↓
Información de upgrade a PRO
```

### 10. Principios y restricciones para FREE-002+

- **P1–P6 vigentes** (ver AGENTS.md) — vinculantes para toda SPEC posterior.
- R1: Lenguaje UI: español claro, término visible **ARCO+**, `DSR` solo interno (glosario).
- R2: Nunca presentar agregados como "% de cumplimiento legal"; expresiones permitidas: estado de preparación, N controles pendientes, progreso de evaluación.
- R3: Todo claim normativo cita artículo de `docs/ley_21719.md` vía `knowledge/law-21719/obligations-map.md`.
- R4: Controles afectados por KD-001/KD-002 nacen marcados `requires_review`.
- R5: Los estados y fuentes de evaluación son los definidos en `knowledge/assessment/state-model.md`; cambios de semántica requieren decisión documentada.
- R6: Cada SPEC produce capacidad verificable (P6): escenario E2E ejecutable por persona.

---

## Decisiones (resumen — detalle en research.md)

| ID | Decisión | Estado |
|----|----------|--------|
| D-F101 | Identidad de producto = "WooPrivacy FREE"; renombrado técnico (slug/text-domain/archivos) diferido a SPEC de packaging (FREE-012) para no romper entorno verificado | ACCEPTED |
| D-F102 | Assessment & Guidance definidos operacionalmente según tabla de §5 | ACCEPTED |
| D-F103 | El scaffolding `src/` actual se conserva temporalmente como placeholder funcional (verifica entorno), NO forma parte del contrato; su reemplazo comienza en FREE-002 | ACCEPTED |
| D-F104 | Alcance funcional congelado en 10 capacidades (F1–F10); toda nueva capacidad requiere nueva SPEC o modificación de este contrato | ACCEPTED |
| D-F105 | Prohibición de scoring legal (%) reafirmada como restricción R2 hasta que FREE-006 defina métricas permitidas | ACCEPTED |

## Open Questions (deuda hacia siguientes SPECs)

| PI | Pregunta | Se resuelve en |
|----|----------|----------------|
| PI-F01 | ¿Persistencia del profile/evaluación: options vs tablas propias? | FREE-002 |
| PI-F02 | ¿Formato exacto del catálogo consumible (arrays PHP vs JSON versionado)? | FREE-002 |
| PI-F03 | ¿Qué preguntas exactas componen el Compliance Profile mínimo? | FREE-003 |
| PI-F04 | ¿Representación visual de resultados (sin %)? | FREE-006/FREE-008 |
| PI-F05 | ¿Mecanismo de upgrade path (links, banners, comparativa)? | FREE-011 |

## Quickstart — Escenarios de validación

Ver `quickstart.md`. Resumen de gates:

1. **G1 Contract completeness** — los 10 puntos de la orden tienen respuesta explícita.
2. **G2 Boundary test** — cada afirmación de alcance clasifica sin ambigüedad en FREE o PRO.
3. **G3 No-overpromise scan** — cero frases prohibidas ("cumplimiento garantizado", "% de cumplimiento", "automáticamente conforme").
4. **G4 KB traceability** — todo claim normativo traza a `knowledge/` y de ahí a la ley.
5. **G5 Exclusions justified** — toda exclusión tiene justificación.
6. **G6 Flow completeness** — el flujo mínimo cubre perfil→diagnóstico→roadmap→upgrade info.

---

## Closure Checklist

- [ ] Los 10 ítems de la orden respondidos (este spec.md)
- [ ] Gates G1–G6 verificados y evidenciados
- [ ] Aprobación del usuario del contrato
- [ ] Baseline: tag/commit de congelación del contrato
- [ ] Habilita FREE-002
