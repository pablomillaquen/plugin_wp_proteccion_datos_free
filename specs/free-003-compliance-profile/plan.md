# SPEC-FREE-003 — Plan

## Fase 1 — Modelo
- [x] T301 Análisis dimensión→controles del catalog v1.0.0 (11 condicionales / 18 incondicionales) — spec.md
- [x] T302 Filtro MVP: 9 preguntas, una por dimensión declarativa; consent_processing derivada — spec.md
- [x] T303 Decisiones D-F301..D-F304 + semántica RS1–RS3 — spec.md/research.md

## Fase 2 — Implementación (P6: incremento verificable)
- [x] T304 class-compliance-profile.php: get_questions/get_profile/save_answers/derivation/render_page
- [x] T305 Submenú "Perfil" bajo chilean-dp + wiring en plugin principal
- [x] T306 E2E CLI: 3 casos de derivación + RS3 + round-trip — evidence/e2e-profile-output.txt
- [x] T307 Fix F3-01 (derivación Caso B false→null)
- [x] T308 E2E HTTP: página renderiza, POST sin nonce → 403, POST con nonce → guardado real

## Fase 3 — Gates y cierre
- [x] T309 Gates G1–G6 — quickstart.md/evidence
- [ ] T310 Aprobación usuario → freeze Profile v1.0
- [ ] T311 AGENTS.md + Engram

## Trazabilidad

| Entrega | Verificación |
|---------|--------------|
| 9 preguntas mínimas | Tabla dimensión→controles en spec.md |
| Derivación consent_processing | 3 casos E2E (true/false/null) |
| Persistencia | option round-trip + HTTP save con answered_at |
| Seguridad CSRF/capability | 403 sin nonce; current_user_can en handle_save y render |
| Sin regresiones | páginas admin previas siguen 200 |

## Fuera de plan (explícito)

- Motor de evaluación de condiciones (FREE-004), detección automática (FREE-009), rediseño UI (FREE-008).
