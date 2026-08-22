# SPEC-FREE-012: Validation, Hardening & Release

**Created**: 2026-08-21
**Status**: APPROVED & FROZEN — v1.0.0 RELEASE CANDIDATE (2026-08-21). Puerta final antes de distribución pública: RG-SEC Security & Non-Destructive Validation.
**Type**: Validation/Hardening/Release — última SPEC; NO agrega funcionalidades.
**Insumos**: FREE-001..011 FROZEN + hallazgos F11-01/F11-02.

## Entregado

### Limpieza (FKN-003/F11-01/F11-02)
- Eliminado `class-settings.php` (checkbox muerto enable_consent_log) y su submenú
- Reemplazada página scaffold "FREE vs COMPLETA" por **Guía & Acerca de** (`class-guide.php`): ley en breve, derechos ARCO+, cómo usar, recursos oficiales, declaración no-certificado
- Eliminado `admin_page_callback` muerto y `class-compliance-info.php`

### Upgrade path implementado (FREE-011 §5, NT2/NT5)
- Notas contextuales por sección del roadmap (hacer_ahora/confirmar/hecho) desde el Dashboard; sección evaluar sin mención

### Hardening
- Guard `ABSPATH` en los 10 archivos que lo carecían (verificado 0 pendientes)
- `uninstall.php`: elimina las 4 options propias al desinstalar; no toca datos de WooCommerce
- Auditoría nonce/capability: todos los formularios con nonce + manage_woocommerce (previo, re-verificado)

### Packaging
- Versión del plugin **1.0.0** (era 0.1.0) · `readme.txt` WordPress-standard con FAQ y changelog

### Validación completa
- php -l limpio en todos los PHP
- Regresión total re-ejecutada tras cambios: R1 catálogo OK · R2 perfil OK · R3 aplicabilidad 19 PASS · R4 assessment 19 PASS · R5 diagnóstico OK · R6 guidance OK · R7 detector OK
- **Instalación limpia + recorrido completo como usuario real (HTTP puro, sin WP-CLI): 8/8 pasos PASS** (evidence/clean-install-walkthrough.txt)

## Gates
G1 lint · G2 regresión 7 suites · G3 instalación limpia end-to-end · G4 limpieza scaffold verificable (clases/menus muertos ausentes) · G5 upgrade-path visible NT2/NT5 · G6 uninstall limpia datos · G7 versión/readme release-ready.
