=== DataRights for WooCommerce ===
Contributors: pablomillaquen
Tags: privacy, woocommerce, data-protection, compliance, chile
Requires at least: 6.0
Tested up to: 7.1
Requires PHP: 7.4
Requires Plugins: woocommerce
Stable tag: 1.2.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Privacy assessment & guidance for WooCommerce stores under Chilean Law 21.719.

== Description ==

DataRights for WooCommerce helps you understand which privacy aspects you should review in your WooCommerce store and which ones to tackle first, under Chilean Law 21.719 (in force from December 1, 2026).

**What it does**

* Store profile with 9 minimal questions
* Normative catalog: 9 obligations and 29 controls derived from the law, with article references
* Applicability engine: what applies to YOUR store, with clear reasons
* Evaluation per control with provenance (declared by admin / technically detected)
* Honest diagnosis: priorities and items needing confirmation — no fake "compliance" percentages
* Environment evidence (optional technical observations you choose to adopt)
* Printable report + CSV export

**What it is NOT**

Not a legal-compliance certificate and not legal advice. It does not implement or automate controls; it assesses and guides.

**Privacy of this plugin**

DataRights runs locally on your WordPress install. It sends nothing to external servers, uses no tracking, and removes its own data on uninstall.

== Installation ==

1. Upload the plugin folder to /wp-content/plugins/ or install from Plugins → Add New.
2. Activate the plugin (requires WooCommerce).
3. Open the DataRights menu — an initial diagnosis is available immediately.

== Frequently Asked Questions ==

= Does this plugin make my store legally compliant? =

No. It assesses and guides you on what to review. Compliance depends on decisions made by the data controller.

= Where is my data stored? =

Locally, in your WordPress database (options). Nothing leaves your site.

= Can I use it without answering the profile? =

Yes. An initial diagnosis is available right away.

== Changelog ==

= 1.2.4 =
* Report CSS now properly enqueued via wp_enqueue_style (WordPress.org requirement).
* Report HTML references CSS via <link> instead of inline <style>.

= 1.2.3 =
* Text domain aligned to plugin slug (WordPress.org requirement).
* Main plugin file renamed to match slug.
* Report CSS extracted to separate file.
* WordPress.org directory assets removed from plugin zip.

= 1.2.2 =
* Admin menu label and page title updated to the new DataRights branding.
* Consistent wording in upgrade notes.

= 1.2.1 =
* Public rebranding to **DataRights for WooCommerce** (previously known as WooPrivacy FREE). Same features, same local-only privacy guarantees.

= 1.2.0 =
* Downloadable report now uses the same human language as the dashboard.
* CSV includes updated human titles.

= 1.1.0 =
* Human-readable guidance for all 29 controls.
* Detection capability labels and profile recalculation messaging.

= 1.0.0 =
* Initial public release.

== Upgrade Notice ==

= 1.2.0 =
Report now speaks the same plain language as your dashboard.
