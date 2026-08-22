# AGENTS.md - WooPrivacy FREE — Assessment & Guidance para WooCommerce

## Contexto del Proyecto

**Nombre en la aplicación**: WooPrivacy (FREE) (renombrado 2026-08-21; slug técnico chilean-data-protection intacto hasta FREE-012)
**Producto**: **WooPrivacy FREE** — plugin WordPress/WooCommerce de **Compliance Assessment & Guidance** para la Ley de Protección de Datos Chilena 21.719 (vigente desde 01-diciembre-2026)
**Frontera FREE/PRO** (congelada):
```text
FREE = Assessment + Guidance (evalúa y orienta; NO implementa controles)
PRO  = Implementation + Automation + Evidence + Management
```
**Directorio**: `/Users/pablomillaquen/Proyectos/plugin_wordpress_proteccion_datos_free`
**Ley completa**: `docs/ley_21719.md`

## Principios del Producto (P1–P6, NO negociables)

1. **P1 — Assessment antes que Implementation**: FREE evalúa y orienta; PRO implementa/automatiza.
2. **P2 — No afirmar cumplimiento jurídico**: nunca "% de cumplimiento legal"; solo estado de preparación/evaluación, brechas, prioridades.
3. **P3 — Separar conocimiento de implementación**: el catálogo dice "debe existir X" sin construir X.
4. **P4 — Reutilización**: mismos IDs/conceptos/metadatos que usará PRO después.
5. **P5 — MVP pequeño**: NO incluir consent management completo, CMP, gestión de derechos, incidentes, retención automática, auditoría avanzada, automatizaciones ni integraciones complejas.
6. **P6 — Cada SPEC produce un incremento verificable**: sin SPEC puramente arquitectónicas.

## Proyecto PRO (fuente de conocimiento — READ ONLY)

- **Ubicación**: `/Users/pablomillaquen/Proyectos/plugin_wp_proteccion_datos/`
- **Estado**: v0.5.0 (SPEC-002 Acceso, SPEC-003 Rectificación, SPEC-004 Supresión E2E PASS; SPEC-005 Oposición en progreso)
- **REGLA INVIOLABLE**: **PRO es READ ONLY. NUNCA modificar archivos de PRO.**
- Si se detecta inconsistencia en PRO → registrar en `knowledge/free-knowledge-notes.md` (formato FKN-NNN), sin corregir allá.
- Extracción ya realizada: ver `knowledge/sources.md` (clasificación reutilizable/adaptable/no necesario/provisional).

## FREE Knowledge Base (`knowledge/`)

```
knowledge/
├── sources.md                    # Fuentes consultadas en PRO + clasificación
├── law-21719/
│   └── obligations-map.md        # Ley → obligaciones e-commerce (Arts. 4,10,11,12,13,14 ter...)
├── obligations/
│   └── catalog.md                # Catálogo OBL-* (borrador; congela FREE-002)
├── controls/
│   └── catalog-draft.md          # Controles CTRL-* semilla (esqueleto)
├── applicability/
│   └── criteria-notes.md         # Dimensiones del Compliance Profile
├── assessment/
│   └── state-model.md            # Estados IMPLEMENTED/PARTIAL/PENDING/UNKNOWN/NOT_APPLICABLE
├── glossary/
│   └── glossary.md               # ARCO+ (UI) vs DSR (interno), reglas de lenguaje
└── free-knowledge-notes.md       # FKN-001..003 (observaciones sobre PRO)
```

## Roadmap de SPECs (plan aprobado por el usuario)

```text
FASE A — Producto y conocimiento:  FREE-001 Scope&Architecture · FREE-002 Knowledge Model&Catalog · FREE-003 Compliance Profile
FASE B — Motor (MVP real):         FREE-004 Applicability Engine · FREE-005 Assessment Engine · FREE-006 Diagnostic&Prioritization · FREE-007 Guidance&Roadmap
FASE C — Producto WooCommerce:     FREE-008 Dashboard&UX · FREE-009 WC Environment Detection · FREE-010 Report&Export
FASE D — Comercialización:         FREE-011 FREE/PRO Boundary&Upgrade Path · FREE-012 Validation,Hardening&Release
```

- **MVP mínimo real**: FREE-001→FREE-006 (Perfil → aplicables → evaluación → diagnóstico). FREE-007 añade roadmap.
- **Recomendación**: FREE-001 con alcance deliberadamente PEQUEÑO (congelar frontera FREE/PRO). FREE-002 es la SPEC crítica.
- Valor propuesto (1 frase): *"WooPrivacy FREE te ayuda a entender qué aspectos de privacidad debes revisar en tu tienda WooCommerce y qué deberías abordar primero."*

## Estado producto (2026-08-21) — RELEASE READY v1.0.0

```text
FREE-001..011 FROZEN · FREE-012 implementada pendiente de aprobación final
Plugin: WooPrivacy (FREE) v1.0.0 · slug técnico chilean-data-protection
Cadena completa: Catalog→Profile→Applicability→Assessment→Diagnostic→Guidance→Dashboard(+Detector+Evidencia)→Report/CSV→Guía
Superficies: Dashboard (evaluación desde UI) · Perfil · Evidencia entorno · Reporte descargable · Guía
Páginas eliminadas en FREE-012: chilean-dp-settings y chilean-dp-info (scaffold)
```

## Estado MVP (2026-08-21)

```text
Catalog v1.0.0 → Profile v1.0 → Applicability v1.0 → Assessment v1.0 → Diagnostic v1.0
FREE-001..006: TODAS FROZEN — MVP mínimo real COMPLETADO y evaluado
Motores puros sin UI; superficie de usuario = FREE-007/008 con requisitos de findings.md
```

## Flujo del producto (FREE 1.0)

```text
Perfil de tienda → Obligaciones relevantes → Controles aplicables → Evaluación → Diagnóstico → Brechas prioritarias → Recomendaciones → Roadmap → Info upgrade PRO
```

## Stack Tecnológico

- **WordPress** + **WooCommerce**
- **PHP** (versión compatible con WP actual)
- **Docker** para desarrollo y testing
- **Evidence-Driven Software Evolution (EDSE)** como metodología de desarrollo

## Metodología: Evidence-Driven Software Evolution (EDSE)

Usaremos el skill **Evidence-Driven Software Evolution** (v3) ubicado en `~/.agents/skills/evidence-driven-evolution/v3/`

### Principios clave EDSE aplicados:
1. **Evidencia mínima E1** para todos los Findings (inspección de código)
2. **Evidencia mínima E3** para todos los cambios de código (tests automatizados)
3. **E4 requerido** para claims de performance
4. **Nunca E0** (opinión sin datos)

### Ciclo EDSE:
```
Question → Investigation → Findings → Decisions → Implementation → Evidence → Health Report → Governance Feedback → Next Question
```

### Documentos SPEC requeridos por iteración:
- `spec.md` - Qué y por qué (congelado durante implementación)
- `plan.md` - Cómo (fases, tareas, trazabilidad)
- `research.md` - Decisiones con justificación
- `data-model.md` - Entidades afectadas (si hay cambios de schema)
- `quickstart.md` - Escenarios de validación
- `tasks.md` - Lista de tareas con estado
- `checklists/` - Quality gates
- `evidence/` - Todos los artefactos de prueba

## Skills Obligatorios Cargados

1. **Evidence-Driven Software Evolution** - Metodología principal
2. **Proteccion Archivos Criticos** - Protege archivos sensibles (NO modificar `.env`, `environment.ts`, `environment.prod.ts`)

## Estructura de Carpetas (Planeada)

```
plugin_wordpress_proteccion_datos_free/
├── AGENTS.md                          # Este archivo
├── docker/                            # Configuración Docker
│   ├── Dockerfile
│   ├── docker-compose.yml
│   └── .env.example
├── specs/                             # SPECs EDSE
│   └── 001-foundation/                # SPEC inicial
├── docs/
│   ├── adr/                           # Architecture Decision Records
│   ├── architecture/                  # Diagramas Mermaid
│   ├── releases/                      # Release Reports
│   └── platform/
│       └── health-metrics.md          # Métricas de salud (EDSE)
├── src/                               # Código del plugin
│   ├── chilean-data-protection.php    # Archivo principal
│   ├── includes/
│   │   ├── admin/                     # Admin panels
│   │   ├── frontend/                  # Frontend components
│   │   └── core/                      # Lógica central
│   └── assets/
│       ├── css/
│       └── js/
├── tests/                             # Tests (PHPUnit)
│   ├── unit/
│   └── integration/
└── .gitignore
```

## MCPs Disponibles (Engram)

> **Nota de proyecto Engram**: desde que existe `.git` con remote, Engram puede detectar `plugin_wp_proteccion_datos_free` (desde la URL remota) en lugar del histórico `plugin_wordpress_proteccion_datos_free` (basename del directorio, donde viven las ~860 observaciones históricas). Si buscas memoria antigua sin resultados, probar ambos nombres o usar `all_projects=true`.

El sistema **Engram** proporciona memoria persistente entre sesiones:
- `mem_save` - Guardar observaciones (decisions, bugfixes, architecture, etc.)
- `mem_search` - Buscar en memoria histórica
- `mem_context` - Contexto de sesiones recientes
- `mem_session_summary` - Resumen obligatorio al cerrar sesión
- `mem_current_project` - Detectar proyecto actual

## Entorno Docker (VERIFICADO FUNCIONANDO 2026-08-21 — WP 7.1)

### Credenciales de Acceso (NO buscar de nuevo, están aquí)

| Servicio | URL | Usuario | Contraseña |
|----------|-----|---------|------------|
| **WordPress Admin** | http://localhost:8080/wp-admin | `admin` | `admin` |
| WordPress Frontend | http://localhost:8080 | - | - |
| **phpMyAdmin** | http://localhost:8081 | `wp_user` | `wp_password` |
| MySQL (externo) | localhost:3306 | `wp_user` | `wp_password` |

**Base de datos**: `wp_cl_data_protection` (host interno: `db`, root: `root_password`)
**Email admin WP**: `admin@test.local`

### Comandos

```bash
make -C docker up           # Levantar servicios
make -C docker install-wc   # Instalar Woo + QM + activar plugin (auto-detecta si falta wp core install)
make -C docker down         # Parar servicios
make -C docker logs         # Ver logs
make -C docker shell        # Bash en contenedor WP
make -C docker wp CMD="plugin list"  # WP-CLI passthrough
```

⚠️ **IMPORTANTE**: Los plugins instalados vía WP-CLI (WooCommerce, Query Monitor) NO persisten al recrear contenedores (`down` + `up` o `--force-recreate`). Solo la base de datos persiste (volumen `db-data`). Tras recrear, ejecutar `make -C docker install-wc`. `make clean` borra TODO incluida la DB.

⚠️ **GOTCHA — Actualizar versión de WordPress**: La imagen oficial declara `VOLUME /var/www/html` como volumen anónimo y Compose lo **preserva al recrear** → los archivos viejos de WP sobreviven y el core NO se actualiza aunque cambies el `FROM` del Dockerfile. Para actualizar WordPress:
```bash
# 1. Editar FROM en docker/Dockerfile
# 2. Recrear renovando volúmenes anónimos:
docker compose -f docker/docker-compose.yml up -d --build --force-recreate --renew-anon-volumes wordpress
# 3. Migrar BD + reinstalar plugins:
make -C docker install-wc
docker compose -f docker/docker-compose.yml exec wordpress wp core update-db --allow-root
```

### Versiones del Entorno

- **WordPress**: 7.1
- **PHP**: 8.2 (Apache)
- **MySQL**: 8.0
- **WooCommerce**: 11.0.1 (última, compatible con WP 7.1)
- **Query Monitor**: 4.0.7 (debugging)

### Estado Verificado (E3 - tests manuales ejecutados)

- ✅ Contenedores levantan y responden
- ✅ WordPress instalado y login admin funciona (HTTP 302 → sesión activa)
- ✅ Plugin `chilean-data-protection` v0.1.0 activo, clases cargan sin errores
- ✅ Página admin principal (`page=chilean-dp`) renderiza: HTTP 200
- ✅ Página settings (`page=chilean-dp-settings`) renderiza secciones empresa/DPO
- ✅ Página info legal (`page=chilean-dp-info`) renderiza principios/derechos/obligaciones
- ✅ WooCommerce activo, `/tienda/` responde HTTP 200
- ✅ 0 errores PHP nuevos en debug.log tras carga de páginas admin

## Próximos Pasos Inmediatos

1. ~~Crear configuración Docker~~ ✅ Hecho y verificado (WP 7.1 + Woo 11.0.1)
2. ~~Bootstrap: extracción de conocimiento desde PRO~~ ✅ `knowledge/` creada
3. ~~SPEC-FREE-001: Product Scope~~ ✅ APROBADO Y CONGELADO (`specs/free-001-product-scope/`, evidence/approval.md)
4. ~~SPEC-FREE-002: Knowledge Model & Catalog~~ ✅ Implementado, gates 6/6 PASS — **PENDIENTE: aprobación del usuario** para freeze catalog v1.0.0 (`src/catalog/catalog.json` + loader; `specs/free-002-knowledge-catalog/`)
5. ~~FREE-003: Compliance Profile~~ ✅ Implementado, gates 6/6 PASS — **PENDIENTE: aprobación del usuario** para freeze Profile v1.0 (`specs/free-003-compliance-profile/`; página admin `page=chilean-dp-profile`)
6. ~~FREE-004: Applicability Engine~~ ✅ Implementado, E2E 18/18 PASS — **PENDIENTE: aprobación del usuario** para freeze Engine v1.0 (`specs/free-004-applicability-engine/`; motor puro sin UI)
7. ~~FREE-005: Assessment Engine~~ ✅ Implementado, E2E 19/19 PASS — **PENDIENTE: aprobación del usuario** para freeze v1.0 (`specs/free-005-assessment-engine/`; motor+persistencia sin UI)
8. ~~FREE-006: Diagnostic & Prioritization~~ ✅ Implementado, E2E 17/17 PASS — **PENDIENTE: aprobación del usuario** para freeze v1.0 → **CIERRA EL MVP MÍNIMO REAL** (`specs/free-006-diagnostic-prioritization/`)
9. ~~PAUSA evaluación MVP~~ ✅ Ejecutada 2026-08-21 (`specs/mvp-evaluation-2026-08/findings.md`): cadena sólida (A/B ✅); hallazgos F-EVAL-01..07 → requisitos para FREE-007/008 (superficie de usuario + mapeo de lenguaje). Motores SIN tocar durante la pausa.
10. ~~FREE-007: Guidance & Roadmap~~ ✅ Implementado, E2E 18/18 PASS — **PENDIENTE: aprobación del usuario** para freeze v1.0 (`specs/free-007-guidance-roadmap/`; capa interpretación sobre motores congelados; incorpora F-EVAL-02/03/04/07)
11. ~~FREE-008: Dashboard & UX~~ ✅ Implementado, E2E PASS (render/evaluar-vía-UI/retract/scans/regresión) — **PENDIENTE: aprobación del usuario** para freeze v1.0 (`specs/free-008-dashboard-ux/`; dashboard proyección pura de motores, cero lógica propia)
12. ~~FREE-009: WC Environment Detection~~ ✅ Implementado, E2E 13/13 CLI + HTTP PASS — **PENDIENTE: aprobación del usuario** para freeze v1.0 (`specs/free-009-wc-detection/`; evidencia técnica en option propia, adopción=acto del usuario)
13. ~~FREE-010: Report & Export~~ ✅ Implementado, E2E PASS (descargas/disclaimer/procedencias/scans/regresión) — **PENDIENTE: aprobación del usuario** para freeze v1.0 (`specs/free-010-report-export/`; HTML imprimible+CSV, sin librerías vendor)
14. ~~FREE-011: FREE/PRO Boundary~~ ✅ Contrato analítico completado, gates 7/7 PASS — **PENDIENTE: aprobación del usuario** para freeze (`specs/free-011-free-pro-boundary/`; línea: FREE=conocimiento snapshot, PRO=cambio+prueba continua; hallazgos F11-01/02 scaffold→FREE-012)
15. ~~FREE-012~~ ✅ FROZEN — v1.0.0 RELEASE CANDIDATE
16. ~~RG-SEC~~ ✅ **GATE SUPERADO** (`specs/release-gate-rg-sec/`): no-destructivo demostrado (A→lifecycle→S0 idéntico en 15 tablas), escrituras=4 options propias, 0 destructivos/SQL/HTTP/vendor, hooks solo admin (comercio inalcanzable), uninstall fix F12-SEC-01 + test OK, comercio operativo con plugin activo (orden+stock 8→5)
17. **🎉 RELEASE PÚBLICO DECLARADO — WooPrivacy (FREE) v1.0.0** · git main+tag v1.0.0 → github.com/pablomillaquen/plugin_wp_proteccion_datos_free
18. ~~Mantenimiento 1.0.1~~ ✅ BUG-001..004 corregidos y verificados con Chrome DevTools (`594a95b..5b4ea50`, tag v1.0.1 + zip asset publicado). Detalle: BUG-001=FeaturesUtil×5 features; BUG-002=notice éxito+badge "Tu evaluación" en confirmar (guardado ya funcionaba; era invisible por D-F402); BUG-004=(string)false='' marcaba "Sin responder" tras guardar No; BUG-003=URL ya correcta, no reproducible (era scaffold viejo). Sin tocar motores frozen.
19. ~~Mantenimiento 1.0.2~~ ✅ Explicación KD en Guía (`#confirmaciones`: delegación a la Agencia, ejemplo Art.11, qué hacer mientras tanto, actualización automática futura) + enlace contextual desde sección confirmar del panel (`7a01aca`, tag v1.0.2 + zip). Motivado por feedback de usuario: el mensaje KD generaba incertidumbre sin explicación.
20. ~~SPEC-FREE-013~~ ✅ **IMPLEMENTADA Y PUBLICADA v1.1.0** (`a64c962`, tag+zip en GitHub): primera prueba exploratoria real encontró F-EVAL-08 — contenido de tarjetas en lenguaje jurídico-técnico incomprensible para dueño de tienda (`specs/free-013-human-guidance/`). Solución: capa overlay `guide-content.json` (29 controles × estructura ¿Qué significa?/¿Por qué importa?/¿Qué revisar?/¿Dónde?/¿Qué detecta WooPrivacy?/¿Cuándo Cubierto?/explicación legal humana) + rediseño tarjeta dashboard + etiquetas detección 🔎/👤/🔎👤 + mensaje perfil→recalculo. INVARIANTES: motores frozen intactos, IDs/estados/aplicabilidad intactos, no inventar plazos, no inducir borrados, referencia legal nunca sustituye explicación. Gate de aceptación = "prueba del dueño" 8 preguntas × 29 tarjetas.

## Notas Importantes

- **Ley chilena vigente**: 01-diciembre-2026
- **No modificar archivos protegidos** por skill Proteccion Archivos Criticos
- **No modificar PRO** bajo ninguna circunstancia (READ ONLY)
- **Guardar todo en Engram** después de decisiones importantes
- **AGENTS.md** es la fuente de verdad para contexto entre sesiones/modelos
- El código actual en `src/` es scaffolding previo al plan; FREE-001 decide qué conservar (ver FKN-003)

---

*Última actualización: 2026-08-22 · v1.1.0 publicada (FREE-013 Human Guidance implementada: overlay guide-content.json 29/29 + tarjeta guiada + etiquetas 🔎/👤/🔎👤; G3 prueba dueño 29×9 PASS autoevaluación, pendiente re-lectura del dueño)*