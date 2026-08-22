# SPEC-FREE-007: Guidance & Roadmap

**Created**: 2026-08-21
**Status**: APPROVED & FROZEN — v1.0 congelado (2026-08-21). D-F703 congelada explícitamente por el usuario: "Todo cubierto" es inalcanzable por diseño mientras exista incertidumbre jurídica.
**Type**: Feature (capa de interpretación; sin UI — dashboard es FREE-008) — capacidad F6 del contrato FREE-001
**Insumos**: FREE-001..006 FROZEN + hallazgos `specs/mvp-evaluation-2026-08/findings.md` (F-EVAL-01..07)

> Separación sana acordada por el usuario: **FREE-006 = datos · FREE-007 = interpretación/orientación · FREE-008 = experiencia**.
> Este SPEC produce el CONTRATO FUNCIONAL que FREE-008 consumirá.

## Responsabilidad

Transformar Diagnostic v1.0 en orientación comprensible y accionable:

1. Qué significa cada brecha (why = objetivo del control, lenguaje claro)
2. Qué revisar (what_to_do = recomendación del catálogo)
3. Qué acción se recomienda (secciones del roadmap)
4. Cómo ordenar las acciones (reglas D-F702)
5. Cómo presentar REQUIRES_REVIEW (F-EVAL-04: razones traducidas, KD visible)
6. Cómo tratar SIN_EVALUAR (F-EVAL-03: nunca "sin problemas", siempre ordenado por prioridad)
7. Prioridad alta ≠ ausencia de información (aviso de atención permanente mientras haya sin_evaluar)

## Contrato de salida (para FREE-008)

```text
summary:
  phrase         "N puntos requieren atención prioritaria · M aún sin evaluar · K necesitan confirmación"
  attention      {show, level: info|warning|ok, message}
  counts         (los 8 contadores de FREE-006)
roadmap:
  hacer_ahora[]  brechas: PENDING antes que PARTIAL; alta antes que media
  confirmar[]    REVIEW con review_detail traducido + referencia KD preservada
  evaluar[]      sin evaluar, HIGH primero (F-EVAL-03)
  hecho[]        implemented + unknown_state
item:
  id · title · priority(alta|media|null) · status_label(user) · why · what_to_do
  legal_refs · review_detail[] · observation
```

## Decisiones clave

| ID | Decisión |
|----|----------|
| D-F701 | Guidance Engine = nueva capa stateless sobre motores congelados; cero modificaciones a FREE-002..006 |
| D-F702 | Orden roadmap: hacer_ahora(PENDING→PARTIAL, alta→media) · confirmar · evaluar(HIGH→MEDIUM) · hecho |
| D-F703 | Con KDs permanentes el estado terminal SIEMPRE incluye "necesitan confirmación" — "Todo cubierto" es inalcanzable por diseño (consecuencia honesta de D-F402) |
| D-F704 | Mapeo de lenguaje contextual por estado+prioridad (`Por hacer — prioritario`, `Cubierto a medias`, `Necesita confirmación`...); códigos internos PROHIBIDOS en campos de usuario (verificado en E2E) |
| D-F705 | Aviso de atención (F-EVAL-03): sin_evaluar>0 ⇒ aviso info SIEMPRE, aunque prioridad_alta=0 |

## Gates

G1 avisos F-EVAL-03 · G2 mapeo contextual · G3 orden roadmap · G4 cero códigos internos en texto usuario · G5 KDs traducidas con referencia · G6 anti-score sobre guidance · G7 renombrado WooPrivacy sin regresión.
