# Research — SPEC-FREE-011

## Ejecución de gates (evidencia E1/E3, 2026-08-21)

| Gate | Método | Resultado |
|------|--------|-----------|
| G1 inventario | Mapeo 1:1 contra specs FREE-001..010 frozen | PASS — tabla §1 de spec.md |
| G2 exclusiones justificadas | Revisión P1..P9 una a una | PASS — cada una con razón funcional, no solo comercial |
| G3 cero solape | grep src/ de implementaciones P1..P9 (cron, wp_mail, DELETE/anonimización, DSR forms, consent logging, certificados) | PASS — única coincidencia: checkbox muerto `enable_consent_log` del scaffold sin código detrás (F11-01) |
| G4 anti-teaser | Scan dashboard + reporte renderizados | PASS — cero menciones PRO en superficie actual; upgrade-path visual llega en FREE-012 ya especificado |
| G5 contenido upgrade path | Tabla por sección definida | PASS — spec.md §5 |
| G6 hipótesis inicial | Análisis post-construcción | RESPONDIDA: la separación funciona (ver abajo) |
| G7 trazabilidad E↔P | Matriz E1–E12 ↔ P1–P9 | PASS — research.md tabla completa |

## Validación de la hipótesis del usuario (G6)

**La separación imaginada al inicio SOBREVIVE a la construcción real**, con tres evidencias:
1. Todo lo construido cabe íntegro en Assessment/Guidance/Detection/Report — ninguna capa implementa lo reservado.
2. Las KDs heredadas de PRO demostraron empíricamente dónde el conocimiento operativo de PRO es imprescindible.
3. La única tensión detectada (Detection→monitoreo continuo=P9) se resolvió fijando regla: FREE=snapshot bajo demanda.

## Hallazgos

| ID | Tipo | Descripción | Destino |
|----|------|-------------|---------|
| F11-01 | Documentation/Debt | Scaffold `chilean-dp-info` aún muestra tabla "FREE vs Versión COMPLETA" previa al contrato (naming desactualizado y claims que hoy corresponden a módulos PRO específicos). No viola NT gravemente (estático, no bloquea nada) pero debe alinearse | Decisión de reemplazo/limpieza en FREE-012 |
| F11-02 | Discovery | El checkbox scaffold `enable_consent_log` es una opción muerta con nombre de capacidad PRO — nunca tuvo implementación | Mismo destino: FREE-012 |

## Matriz de trazabilidad E1–E12 (FREE-001) ↔ P1–P9

E1→P1 · E2→P2 · E3→P5 · E4→P6 · E5→P4 · E6→P7(parcial RoPA) · E7→P7/P8 · E8→P8 · E9→(anti-score permanente, sin P) · E10→fuera de ambos productos (asesoría humana) · E11→flujo especial futuro PRO · E12→fuera de alcance ambas.
