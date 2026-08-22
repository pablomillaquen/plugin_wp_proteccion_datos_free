# SPEC-FREE-002 — Tasks

- [x] T201 Modelo de entidades + vocabulario aplicabilidad — [Evidence: spec.md]
- [x] T202 Formato JSON + loader fail-closed — [Evidence: research.md D-F201/D-F202]
- [x] T203 9 obligaciones — [Evidence: src/catalog/catalog.json]
- [x] T204 29 controles completos — [Evidence: src/catalog/catalog.json]
- [x] T205 requires_review KD-001/KD-002 — [Evidence: catalog.json]
- [x] T206 Loader PHP — [Evidence: src/includes/core/class-catalog-loader.php]
- [x] T207 Conexión en plugin principal — [Evidence: src/chilean-data-protection.php]
- [x] T208 E2E Docker — [Evidence: evidence/e2e-catalog-output.txt]
- [x] T209 Fixes F2-01 (recursión) y F2-02 (regex) — [Evidence: research.md]
- [x] T210 Gates G1–G6 — [Evidence: quickstart.md]
- [x] T211 Refinamiento G4 (F2-03) — [Evidence: research.md, quickstart.md]
- [x] T212 Aprobación usuario (APPROVED) → catalog_version 1.0.0 FROZEN
- [x] T213 AGENTS.md + Engram guardados

## Bugs encontrados y corregidos durante la SPEC

1. **F2-01** Recursión infinita en validación de aplicabilidad (hang silencioso) → parámetro explícito.
2. **F2-02** Regex IDs no aceptaba áreas multi-segmento → 25/29 controles excluidos → regex corregida.

Ambos capturados por los mecanismos propios (fail-closed log + E2E de cobertura) antes de llegar a FREE-004/005.
