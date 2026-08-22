# SPEC-FREE-002 — Plan

## Fase 1 — Modelo y esquema
- [x] T201 Definir entidades Obligación/Control y vocabulario de aplicabilidad (spec.md) — D-F205
- [x] T202 Decidir formato y estrategia de carga (research.md D-F201/D-F202)

## Fase 2 — Catalog v1.0 (contenido)
- [x] T203 Redactar 9 obligaciones con referencias legales — src/catalog/catalog.json
- [x] T204 Redactar 29 controles con metadatos completos — src/catalog/catalog.json
- [x] T205 Marcar requires_review según KD-001/KD-002

## Fase 3 — Loader y verificación E2E
- [x] T206 Implementar class-catalog-loader.php fail-closed + cache
- [x] T207 Conectar loader en chilean-data-protection.php load_core()
- [x] T208 E2E en Docker: carga, cobertura, get_control, requires_review — evidence/e2e-catalog-output.txt
- [x] T209 Investigar y corregir F2-01 (recursión) y F2-02 (regex IDs)

## Fase 4 — Gates y cierre
- [x] T210 Ejecutar gates G1–G6 — evidence/gates-report.md
- [x] T211 Documentar refinamiento de G4 (F2-03)
- [ ] T212 Aprobación del usuario → freeze catalog_version 1.0.0
- [ ] T213 Actualizar AGENTS.md + Engram

## Trazabilidad

| Entrega | Verificación |
|---------|--------------|
| Catálogo consumible | E2E Docker (wp eval-file) |
| Fail-closed | Logs de exclusión de corrida rota (comportamiento correcto) |
| Cobertura | Tabla OBL→#controles: mínimo 1, objetivo ≥2 salvo TRANSFERS |
| Sin regresión | Login admin 302, página chilean-dp 200 post-cambios |

## Fuera de plan (explícito)

- Applicability Engine (FREE-004), evaluación persistente (FREE-005), UI del catálogo (FREE-008), preguntas del perfil (FREE-003).
