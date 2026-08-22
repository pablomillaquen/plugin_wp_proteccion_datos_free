# Evaluación Transversal del MVP — WooPrivacy FREE (Pausa post FREE-006)

**Fecha**: 2026-08-21
**Alcance congelado evaluado**: Catalog v1.0.0 · Profile v1.0 · Applicability v1.0 · Assessment v1.0 · Diagnostic v1.0
**Regla de esta pausa (instrucción del usuario)**: producir Hallazgos → Decisiones → Cambios. **NO se modificó ningún motor ni archivo de src/ durante la evaluación.**
**Método**: Revisión A ejecutada en entorno real (evidencia E3, `evidence/walkthrough-outputs.txt`); B/C/D analíticas (E1) sobre artefactos congelados.

---

## A. Revisión funcional — RESULTADO: CADENA SÓLIDA

Recorrido completo ejecutado con 3 perfiles reales:

| Perfil | Resultado observado |
|--------|---------------------|
| Vacío (primera instalación) | 16 sin evaluar · 13 revisión · 0 gaps — diagnóstico inmediato sin onboarding |
| Tienda típica CL | 25 sin evaluar · 2 revisión (solo KDs) · 2 no aplicables; tras evaluar 5 controles → **3 brechas alta accionables** (CHANNEL partial, CONSENT-MECH y COOKIES pending) |
| Tienda mínima | 20 sin evaluar · 7 no aplicables · coherente con el perfil declarado |

**Hallazgo F-EVAL-05** (positivo): la cadena produce resultados coherentes y diferenciados por perfil; las brechas priorizadas emergen con muy pocas evaluaciones del usuario.
**Sin hallazgos funcionales negativos.**

## B. Revisión del modelo

Datos: 29 controles = 16 HIGH + 13 MEDIUM; 2 KD en revisión permanente; 9 preguntas perfil; todas las dimensiones consumidas.

- **F-EVAL-06** (positivo): ningún momento del walkthrough requirió información que el perfil no capture — las 9 preguntas bastaron.
- **F-EVAL-03**: los buckets solo cuentan brechas **declaradas**; un perfil típico sin evaluar muestra `prioridad_alta=0` aunque tenga 16 controles sin evaluar. Riesgo UX: "todo tranquilo" malinterpretado. *Propuesta futura (decisión en FREE-008/006-post): presentar sin_evaluar ordenado por prioridad del control ("lo más importante primero"), sin crear score.*
- **F-EVAL-04**: los 2 controles KD nunca "se cierran" — correcto conceptualmente, pero requerirá explicación explícita en UI para no frustrar.
- 29 controles: cobertura completa por obligación verificada; no se identificó control sobrante ni ausencia crítica para el alcance assessment.

## C. Revisión de lenguaje — HALLAZGO PRINCIPAL PARA FREE-008

- **F-EVAL-02**: el vocabulario interno (`control`, `obligación`, `aplicabilidad`, `requires_review`, `REQUIRES_REVIEW`) es preciso pero NO es el lenguaje natural de un dueño de tienda. La capa UI necesitará mapeo, p.ej.: control→"punto a revisar", obligación→"deber legal", requiere revisión→"necesita confirmación". **Solo propuesta — nada implementado.**
- Las recomendaciones del catálogo YA están en lenguaje claro (verificadas contra reglas G4/glosario); el problema es exclusivamente de etiquetas/encabezados futuros.

## D. Revisión de producto — LA PREGUNTA DE LOS 5 MINUTOS

- **F-EVAL-01 (hallazgo principal)**: hoy el MVP **no tiene superficie de usuario**: los motores solo son accesibles vía WP-CLI/eval. Para un administrador real, los primeros 5 minutos entregan valor cero. Esto es esperable según plan (dashboard = FREE-008), pero la evaluación lo fija como requisito duro: FREE-007/008 no son "más features", son **el producto mismo volviéndose visible**.
- **F-EVAL-07** (propuesta validada): primera sesión útil = instalar → diagnóstico inicial automático → perfil opcional que afina → evaluar 3–5 controles HIGH → obtener prioridades. El walkthrough demostró que esta secuencia funciona conceptualmente.

## Resumen ejecutivo

| # | Hallazgo | Tipo | Destino |
|---|----------|------|---------|
| F-EVAL-01 | Sin superficie de usuario; valor 5-min pendiente de FREE-008 | Producto | Requisito duro FREE-007/008 |
| F-EVAL-02 | Vocabulario interno requiere mapeo UI | Lenguaje | FREE-008 (+glosario) |
| F-EVAL-03 | sin_evaluar no priorizado puede leerse como "sin riesgos" | Modelo/UX | Decisión FREE-008 |
| F-EVAL-04 | KD permanentes necesitan explicación en UI | Lenguaje | FREE-008 |
| F-EVAL-05 | Cadena sólida, gaps accionables con poco esfuerzo ✅ | Funcional | — |
| F-EVAL-06 | 9 preguntas suficientes ✅ | Modelo | — |
| F-EVAL-07 | Primera sesión útil validada conceptualmente | Producto | Guion para FREE-008 |

## Conclusión

El MVP **funciona como unidad conceptual** (A/B positivos). El trabajo restante hasta que sea *producto* está concentrado en superficie y lenguaje (FREE-007 Guidance & Roadmap + FREE-008 Dashboard), no en motores. Los motores permanecen congelados; estos hallazgos entran como requisitos a las SPECs siguientes.
