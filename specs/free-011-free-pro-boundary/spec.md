# SPEC-FREE-011: FREE/PRO Boundary & Upgrade Path

**Created**: 2026-08-21
**Status**: APPROVED & FROZEN — v1.0 congelado (2026-08-21). NT5 permanente: jamás lenguaje de miedo.
**Type**: Product Strategy Contract (analítica — sin código; implementación de superficie diferida a FREE-012)
**Insumos**: FREE-001..010 FROZEN · knowledge/sources.md (relación con PRO) · exclusiones E1–E12 del contrato FREE-001
**Hipótesis a validar (usuario)**: *¿la separación FREE/PRO imaginada al inicio funciona después de haber construido FREE completo?*

---

## Contexto

La frontera original se definió antes de construir nada. Ahora existe un producto completo y verificable. Esta SPEC **deriva la frontera de lo construido**, no de supuestos, y produce el contrato que habilita FREE-012 y la reanudación futura de PRO.

---

## 1. Valor entregado por FREE 1.0 (inventario desde capas reales)

| Capacidad | Entregado por | Qué obtiene el administrador |
|-----------|---------------|------------------------------|
| Entender su contexto | Profile v1.0 | Perfil de tienda en 9 preguntas |
| Conocer sus deberes | Catalog v1.0.0 | 9 obligaciones + 29 puntos a revisar, citando artículos |
| Saber qué le aplica | Applicability v1.0 | Aplicables / No aplicables / Necesita confirmación (+razón) |
| Registrar su estado | Assessment v1.0 | Evaluación con procedencia y trazabilidad |
| Ver su situación | Diagnostic v1.0 | Contadores honestos, sin score |
| Saber qué hacer primero | Guidance v1.0 | Roadmap en lenguaje claro, aviso anti-falsa-seguridad |
| Usarlo sin WP-CLI | Dashboard v1.0 | Evaluar/retirar desde la UI |
| Evidencia técnica | Detector v1.0 | Observaciones del entorno, adopción = acto del usuario |
| Llevarse el registro | Report v1.0 | HTML imprimible + CSV, con disclaimer no-certificado |

**Valor FREE en una frase**: *"Entender qué revisar, en qué orden, con evidencia — sin prometer cumplimiento."*

## 2. Lo deliberadamente reservado para PRO (justificación funcional)

| # | Reservado a PRO | Por qué es funcionalmente PRO (no solo comercial) |
|---|-----------------|---------------------------------------------------|
| P1 | Consent management real (banner operativo, registro, prueba Art. 12) | Requiere EJECUCIÓN en el sitio + conservación continua de prueba — FREE orienta si existe, no lo construye |
| P2 | Canal ARCO+ del titular + workflow de plazos (30+30, acuse, bloqueo) | Operación continua con terceros (titulares) y plazos legales — diseño ya avanzado en PRO SPEC-002..005 |
| P3 | Ejecución de derechos sobre datos (rectificar, suprimir/anonimizar, portar) | Motor destructivo con excepciones (KD-001) — un error rompe datos reales; requiere capa operativa probada |
| P4 | Repositorio de evidencia append-only + auditoría | Acreditar licitud (Art. 3.a) exige conservación protegida continua — fuera del alcance snapshot de FREE |
| P5 | Gestión de incidentes y flujo de vulneraciones | Operación sensible dependiente de decisiones del responsable |
| P6 | Retención/eliminación automática | Automatización destructiva programada = PRO |
| P7 | RoPA, data mapping avanzado, gestión de encargados/DPA | Gobernanza documental continua |
| P8 | Integraciones externas (CRM, email marketing, fuentes más allá de WP/WC core) | Superficie de riesgo y mantenimiento propia |
| P9 | Monitoreo continuo / vigilancia programada | FREE detecta bajo demanda (snapshot); vigilancia = operación |

## 3. La línea exacta

```text
FREE produce CONOCIMIENTO del estado (snapshot puntual, honesto con incertidumbres)
PRO   produce CAMBIO y PRUEBA del estado (operación continua, automatizada, acreditada)
```

Criterio discriminatorio único: **¿la funcionalidad modifica datos/operación real o acredita algo en el tiempo? → PRO. ¿Solo observa, explica u ordena? → FREE.**

## 4. Reglas anti-teaser y anti-solape (NT, verificables)

- NT1: FREE nunca oculta ni bloquea resultados propios detrás de PRO.
- NT2: menciones a PRO solo contextuales, después de entregar íntegramente el contenido gratuito correspondiente.
- NT3: ningún control FREE requiere PRO para ser comprendido o evaluado.
- NT4: PRO no duplicará assessment — consumirá IDs/metadatos del catálogo FREE (P4).
- NT5: upgrade path NUNCA usa lenguaje de miedo ("estás incumpliendo"); siempre de capacidad ("PRO puede implementarlo y acreditarlo").

## 5. Upgrade path — contenido especificado (implementación visual en FREE-012)

Por sección del roadmap:

| Sección | Mensaje PRO permitido |
|---------|----------------------|
| hacer_ahora | "WooPrivacy PRO puede implementar este punto y registrar la evidencia." |
| confirmar (KD) | "Cuando la autoridad publique definiciones, WooPrivacy PRO incorporará los criterios actualizados." |
| evaluar | Sin mención — evaluar es parte del valor FREE |
| hecho | "PRO puede automatizarlo y auditarlo de forma continua." |

Tabla de mapeo área→módulo PRO (para retomar PRO): rights/channel/dsrproc→Módulo DSR · licitbase→Módulo Consentimiento · evidence→Módulo Evidence · security→Módulo Hardening-asistencia · thirdparties/transfers→Módulo Governance · transparency→Módulo Transparencia dinámica.

## 6. Validación de la hipótesis inicial

**Resultado: la separación SÍ funciona post-construcción**, con evidencia:
1. Todo lo construido cabe en Assessment/Guidance/Detection/Report — ninguna capa implementa P1..P9 (verificable: grep de capacidades en src/).
2. Las KDs heredadas demostraron dónde PRO es imprescindible (supresión parcial, autenticación Agencia).
3. Tensión detectada y resuelta: Detection podría crecer hacia monitoreo (P9) → regla fijada: FREE = snapshot bajo demanda, nunca cron/vigilancia.

---

## Gates

G1 inventario completo contra capas reales · G2 toda exclusión justificada funcionalmente · G3 cero solape (nada de P1..P9 existe hoy en src/) · G4 reglas NT verificadas sobre producto · G5 contenido upgrade-path definido por sección · G6 hipótesis respondida con evidencia · G7 trazabilidad E1–E12 ↔ P1–P9 completa.
