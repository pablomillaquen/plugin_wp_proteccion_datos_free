# FREE-015: WordPress.org Review Response Plan

**Created**: 2026-08-23
**Status**: PREPARATION (pending reviewer response)
**Base**: v1.2.2 submitted to WordPress.org

## Context

DataRights for WooCommerce v1.2.2 was submitted to WordPress.org on Aug 23, 2026.
Automated scan flagged `textdomain_mismatch` — this is a **real issue**, not a false positive.

WordPress.org requires:
- Text Domain header must match plugin slug
- Main plugin filename should match plugin slug

## Current State

| Item | Current | Required |
|------|---------|----------|
| Plugin slug | `datarights-for-woocommerce` | — |
| Text Domain | `chilean-data-protection` | `datarights-for-woocommerce` |
| Main filename | `chilean-data-protection.php` | `datarights-for-woocommerce.php` |

## Inventory: Text Domain `chilean-data-protection`

### PHP files with i18n calls

| File | Occurrences |
|------|-------------|
| `chilean-data-protection.php` | 8 (`__()`, `_e()`) |
| `includes/admin/class-dashboard.php` | 45+ (`__()`, `_e()`, `esc_html__()`, `esc_html_e()`, `esc_attr_e()`) |
| `includes/core/class-compliance-profile.php` | 6 |
| `includes/core/class-guide.php` | 12 |
| `includes/core/class-report.php` | 0 (uses constant) |
| `includes/core/class-catalog-loader.php` | 0 (uses constant) |
| `includes/core/class-applicability-engine.php` | 0 |
| `includes/core/class-assessment-engine.php` | 0 |
| `includes/core/class-diagnostic-engine.php` | 0 |
| `includes/core/class-guidance-engine.php` | 0 |
| `includes/core/class-environment-detector.php` | 0 |
| `includes/core/class-guide-content.php` | 0 |
| `uninstall.php` | 1 (comment only) |

**Total i18n calls**: ~71 occurrences across 4 PHP files

### Constants using `chilean_dp`

| Constant | Value | Used in |
|----------|-------|---------|
| `CHILEAN_DP_VERSION` | `'0.1.0'` (note: header says 1.2.2) | Multiple files |
| `CHILEAN_DP_PLUGIN_DIR` | `plugin_dir_path(__FILE__)` | Multiple files |
| `CHILEAN_DP_PLUGIN_URL` | `plugin_dir_url(__FILE__)` | Multiple files |
| `CHILEAN_DP_PLUGIN_BASENAME` | `plugin_basename(__FILE__)` | Multiple files |

**Note**: Constants are internal identifiers, NOT user-facing text domains. They can remain as-is if desired, but renaming them improves consistency.

### Option keys using `chilean_dp_`

| Option Key | Used in |
|------------|---------|
| `chilean_dp_profile` | `class-compliance-profile.php`, `uninstall.php` |
| `chilean_dp_assessments` | `class-assessment-engine.php`, `uninstall.php` |
| `chilean_dp_detections` | `class-environment-detector.php`, `uninstall.php` |
| `chilean_dp_catalog_v1` | `class-catalog-loader.php` (cache) |
| `chilean_dp_guide_content_v1` | `class-guide-content.php` (cache) |

**Note**: Option keys are database identifiers. Changing them would break existing user data. **DO NOT CHANGE** without migration.

### JavaScript using `chilean_dp_`

| File | Variables |
|------|-----------|
| `assets/js/admin.js` | `chilean_dp_admin.i18n.*`, `chilean_dp_settings` |
| `assets/js/frontend.js` | `chilean_dp_frontend.*`, `chilean_dp_cookie_dismissed` |

### Nonce actions/fields

| Constant | Value |
|----------|-------|
| `NONCE_ACTION` | `'chilean_dp_dashboard'` |
| `NONCE_FIELD` | `'chilean_dp_dash_nonce'` |
| (profile) | `'chilean_dp_profile_save'`, `'chilean_dp_profile_nonce'` |

### Translation files

- `.po` files: **NONE**
- `.mo` files: **NONE**
- `.pot` files: **NONE**
- `load_plugin_textdomain()`: **NOT CALLED**

**Impact**: No existing translations to preserve. Fix is safe.

## Fix Plan (IF REQUESTED BY REVIEWER)

### R1: Text Domain Change

**Scope**: Replace `chilean-data-protection` → `datarights-for-woocommerce` in:
- `Text Domain:` header in main plugin file
- All `__()`, `_e()`, `esc_html__()`, `esc_html_e()`, `esc_attr_e()` calls
- `textdomain` in `readme.txt` (if present)

**NOT changing**:
- Option keys (`chilean_dp_*`) — database identifiers, would break existing users
- Constants (`CHILEAN_DP_*`) — internal, not user-facing (optional future cleanup)
- Nonce actions — internal, not user-facing

### R2: Main Filename Change

**Scope**: Rename `chilean-data-protection.php` → `datarights-for-woocommerce.php`

**Impact**: Requires update to:
- `Plugin URI` if hardcoded
- Any documentation references

### R3: Version Bump

If changes are made, version becomes `1.2.3` (or `1.3.0` if significant).

### R4: Resubmission

Upload new zip via same WordPress.org submission page.

## Decision Matrix

| Reviewer Says | Action |
|---------------|--------|
| "Fix text domain" | Execute R1 → R3 → R4 |
| "Fix filename" | Execute R2 → R3 → R4 |
| "Fix both" | Execute R1 + R2 → R3 → R4 |
| "Approved as-is" | G11 → SVN → publication |
| "Other issues" | Analyze each, decide per issue |

## INVARIANTS

1. **Option keys NEVER change** without migration — would destroy user data
2. **Catalog IDs unchanged** — PRO compatibility preserved
3. **Assessment statuses unchanged** — user evaluations preserved
4. **All fixes are cosmetic/i18n** — no behavioral changes

## Current Action

**WAIT** for email from plugins@wordpress.org with subject:
"[WordPress Plugin Directory] Review in Progress: DataRights for WooCommerce"

Do NOT preemptively create v1.2.3 until reviewer responds.
