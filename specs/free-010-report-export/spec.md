# SPEC-FREE-010: Report & Export

**Created**: 2026-08-21
**Status**: APPROVED & FROZEN — v1.0 congelado (2026-08-21)
**Type**: Feature (representación exportable) — capacidad F9 del contrato FREE-001
**Regla del usuario**: el reporte es REPRESENTACIÓN del assessment existente, no un motor de interpretación; JAMÁS un certificado de cumplimiento.

## Entregado

1. **Reporte HTML autocontenido listo para imprimir** (`class-report.php`): el navegador genera el PDF (D-F1001 — sin librerías vendor, P5)
   - Encabezado con tienda, fecha, versiones WP/WC/plugin/catálogo/perfil
   - **Disclaimer destacado**: qué es y qué NO es (no certificado, no asesoría, estado de preparación ≠ %)
   - Resumen (frase + 8 contadores)
   - Perfil declarado (con fuente y fecha)
   - Evidencia técnica del entorno (detección vs respuesta + relación)
   - Roadmap completo por secciones, cada ítem con **línea de procedencia** ("Declarado por el administrador · fecha" / "incertidumbre documentada" / "Pendiente de evaluación") y refs legales
   - KDs visibles con su explicación
2. **CSV machine-readable** (29 filas): enums internos permitidos SOLO aquí (artefacto técnico), columnas de procedencia incluidas
3. Botones "Descargar reporte" / "Exportar CSV" en Dashboard → endpoints admin-post con nonce+capability

## Decisiones

| ID | Decisión |
|----|----------|
| D-F1001 | PDF vía print-HTML del navegador; sin dompdf/vendor (P5) |
| D-F1002 | Reporte = proyección de Guidance/Diagnostic/Assessment/Profile/Detector frozen; cero interpretación nueva |
| D-F1003 | Disclaimer no-certificado obligatorio en cada reporte |
| D-F1004 | Procedencia visible en lenguaje usuario; enums técnicos solo en CSV |

## Gates
G1 descargas HTTP 200 attachment · G2 disclaimer presente · G3 procedencias renderizadas · G4 KDs visibles · G5 anti-score texto visible (refinado F10-01) · G6 cero códigos internos en narrativa · G7 CSV 30 líneas · G8 regresión dashboard.
