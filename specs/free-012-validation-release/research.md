# Research — SPEC-FREE-012
## Decisiones
| ID | Decisión | Razón |
|----|----------|-------|
| D-F1201 | Página info scaffold REEMPLAZADA por Guía mínima (no solo borrar tabla comparativa): el contenido educativo útil se conserva sin claims desactualizados | F11-01 |
| D-F1202 | Upgrade path como notas de sección en Dashboard (contenido textual frozen de FREE-011 §5), sin tocar Guidance v1.0 | Respeta freezes; presentación ≠ interpretación |
| D-F1203 | uninstall.php borra SOLO options propias | Nunca tocar datos WC/usuarios |
| D-F1204 | Validación crítica = instalación limpia con flujo HTTP puro; CLI solo para provisioning del entorno (estándar hosting-equivalent) | Instrucción literal del usuario |

## Hallazgos operativos
- wp db reset falla silencioso sin permisos DROP del usuario WP → usar root MySQL para limpieza total (F12-01)
- wp_nonce_url escapa &#038;; reconstrucción de URLs en tests debe decodificar entidades (recurrente desde F10-02)
