# Modelo de Estados de Evaluación (propuesta)

**Estado**: propuesta — semántica formal en SPEC-FREE-005
**Inspiración**: separación acción/resultado de PRO (D-027) adaptada a assessment

---

## Estados de un control evaluado

| Estado | Significado | No significa |
|--------|-------------|--------------|
| `IMPLEMENTED` | El control existe y funciona según lo declarado/detectado | Que la tienda "cumple la ley" |
| `PARTIAL` | Existe pero incompleto o no verificable en parte | Que basta para cumplir |
| `PENDING` | No existe / sin evidencia de existencia | Incumplimiento jurídico declarado |
| `UNKNOWN` | Sin información suficiente | Aplicable o no aplicable |
| `NOT_APPLICABLE` | El motor determinó que no aplica al perfil | Que fue ignorado |

**Regla P2**: NUNCA presentar agregados como "% de cumplimiento legal". Los agregados expresan **estado de preparación/evaluación** (p.ej. "3 controles pendientes", "evaluación 60% completada").

## Fuentes de la evaluación

| Fuente | Origen | Credibilidad |
|--------|--------|--------------|
| `auto-detected` | WooPrivacy verifica técnicamente el entorno | Alta, limitada a lo comprobable |
| `user-declared` | El administrador declara el estado | Declarativa; se muestra como tal |
| `not-verifiable` | Ni el sistema ni una declaración simple pueden determinar | Marca el control como UNKNOWN/requiere revisión |

Toda evaluación conserva: control, estado, fuente, fecha, observación opcional.

## Diagnóstico (FREE-006) — salida esperada

```
PRIORIDAD ALTA     → N controles pendientes
PRIORIDAD MEDIA    → M controles parciales
REQUIERE REVISIÓN  → K controles sin información suficiente
```

Sin score único tipo "73% conforme".
