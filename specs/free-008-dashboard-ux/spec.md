# SPEC-FREE-008: Dashboard & UX

**Created**: 2026-08-21
**Status**: APPROVED & FROZEN — v1.0 congelado (2026-08-21). Regla del usuario: "Los motores deciden; Guidance interpreta; Dashboard presenta."
**Type**: Feature (superficie de usuario) — capacidades F7 + flujo del contrato FREE-001
**Insumos**: FREE-001..007 FROZEN · hallazgos F-EVAL-01..07
**Resuelve**: F-EVAL-01 (requisito duro) — el producto se vuelve visible sin WP-CLI.

## Regla rectora (usuario)
> El Dashboard es PROYECCIÓN de los motores, no otro motor. Cero lógica de cumplimiento nueva.

## Entregado

1. **Página principal `chilean-dp` reescrita como Dashboard real** (`includes/admin/class-dashboard.php`):
   - Aviso de atención (attention_notice de Guidance) con niveles info/warning/ok
   - Frase resumen honesta (summary_phrase)
   - Fila de contadores (los 8 de FREE-006, sin score)
   - Secciones roadmap en orden del contrato: Acciones prioritarias → Necesitan confirmación → Aún sin evaluar → Cubierto (secciones vacías se omiten)
   - Tarjeta por control: título, badges prioridad/estado, why, what_to_do, notas de revisión KD traducidas, observación, referencias legales
2. **Evaluar desde la UI** (sin WP-CLI): form tristate+observación por tarjeta → Assessment Engine (source siempre user-declared desde UI); botón "Retirar mi evaluación" cuando existe
3. **Navegación**: enlace Editar perfil de tienda (página FREE-003)
4. CSS propio del dashboard (assets no congelados)

## Fuera de alcance (explícito)

Onboarding wizard multi-paso completo, export/report (FREE-010), upgrade path visual (FREE-011), detección auto (FREE-009).

## Gates
G1 render 200 con contenido motor · G2 evaluar-vía-UI round-trip · G3 retract UI · G4 cero códigos internos en HTML · G5 anti-score región propia · G6 regresión ×3 páginas.
