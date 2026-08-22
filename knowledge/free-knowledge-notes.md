# FREE Knowledge Notes

Registro de observaciones sobre PRO. **Regla: nunca modificar PRO.** Si FREE detecta una inconsistencia upstream, se documenta aquí con la interpretación que FREE usa.

Formato:

```markdown
## FKN-NNN — [título]
Source: PRO/<ruta>
Issue: [...]
Interpretation used by FREE: [...]
Potential upstream inconsistency: [...]
Action: No modificar PRO.
```

---

## FKN-001 — Versiones de entorno difieren entre proyectos

**Source**: `PRO/AGENTS.md` (entorno WP 7.0.4 + Woo 11.0.1, MariaDB, contenedores wooprivacy_*)
**Issue**: El proyecto FREE usa su propio stack (WP 7.1 + Woo 11.0.1 + MySQL 8.0, contenedores wp-cl-data-protection-*). Los inventarios de tablas HPOS verificados en PRO provienen de un esquema MariaDB; MySQL 8.0 puede tener diferencias menores de tipos/índices (no de nombres de tabla).
**Interpretation used by FREE**: Para assessment, los nombres de entidades (`wp_wc_orders`, etc.) son estables entre motores; las diferencias de motor no afectan el modelo de conocimiento. La detección técnica (FREE-009) validará en vivo contra el esquema real de cada instalación.
**Action**: No modificar PRO.

---

## FKN-002 — Deudas de conocimiento heredadas

**Source**: PRO SPEC-001 research.md (KD-001, KD-002), decisiones D-004/D-005/D-008 PROVISIONAL
**Issue**: PRO dejó abiertas KD-001 (suficiencia de la regla tributaria en supresión) y KD-002 (autenticación exigida por la Agencia). D-005 (acceso ≠ portabilidad) es PROVISIONAL.
**Interpretation used by FREE**: FREE no depende de estas resoluciones para evaluar: los controles afectados se marcan `requires_review` y sus recomendaciones explican la incertidumbre al usuario. Si PRO resuelve las KDs en el futuro, una sincronización explícita actualizará esta Knowledge Base.
**Action**: No modificar PRO.

---

## FKN-003 — Alcance del plugin informativo previo vs nuevo alcance FREE

**Source**: Código actual `src/` en FREE (v0.1.0 creado como placeholder informativo)
**Issue**: El código inicial de FREE (clases Settings/Compliance_Info con páginas admin y comparativa FREE vs COMPLETA) fue escrito antes de existir el plan de Assessment & Guidance. Su modelo (settings de empresa/DPO + página informativa estática) no coincide con el producto definido por el plan (profile → applicability → assessment → diagnóstico → roadmap).
**Interpretation used by FREE**: Ese código es scaffolding desechable/adaptable. FREE-001 congelará el alcance real y decidirá qué conservar (p.ej. settings de empresa sirven al Compliance Profile). No hay deuda: nada de eso está liberado ni tiene usuarios.
**Action**: Decisión de reemplazo/refactor en SPEC-FREE-001.
