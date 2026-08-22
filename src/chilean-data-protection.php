<?php
/**
 * Plugin Name: WooPrivacy (FREE)
 * Plugin URI: https://example.com/chilean-data-protection
 * Description: Plugin informativo para apoyo en el cumplimiento de la Ley de Protección de Datos Chilena (vigente desde 01-diciembre-2026). Versión FREE - Solo informativa.
 * Version: 1.0.2
 * Author: Tu Nombre
 * Author URI: https://example.com
 * License: GPL v2 or later
 * Text Domain: chilean-data-protection
 * Domain Path: /languages
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * WC requires at least: 8.0
 * WC tested up to: 9.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * BUG-001: compatibilidad explícita con features de WooCommerce.
 * Justificado por auditoría RG-SEC: WooPrivacy es administrativo-observacional,
 * sin hooks en storefront/REST/editor/cron; solo lee opciones y registro de gateways,
 * por lo que su funcionamiento es independiente de cada feature listada.
 */
add_action( 'before_woocommerce_init', function () {
	if ( ! class_exists( '\Automattic\WooCommerce\Utilities\FeaturesUtil' ) ) {
		return;
	}
	foreach ( array( 'custom_order_tables', 'cart_checkout_blocks', 'block_editor', 'analytics', 'blueprints' ) as $feature ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( $feature, __FILE__, true );
	}
} );

define('CHILEAN_DP_VERSION', '0.1.0');
define('CHILEAN_DP_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CHILEAN_DP_PLUGIN_URL', plugin_dir_url(__FILE__));
define('CHILEAN_DP_PLUGIN_BASENAME', plugin_basename(__FILE__));

/**
 * Main plugin class
 */
final class Chilean_Data_Protection {

    private static $instance = null;

    public static function instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->init_hooks();
    }

    private function init_hooks() {
        add_action('plugins_loaded', [$this, 'load_textdomain']);
        add_action('init', [$this, 'init_plugin']);
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_assets']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
    }

    public function load_textdomain() {
        load_plugin_textdomain('chilean-data-protection', false, dirname(CHILEAN_DP_PLUGIN_BASENAME) . '/languages');
    }

    public function init_plugin() {
        // Check WooCommerce is active
        if (!class_exists('WooCommerce')) {
            add_action('admin_notices', [$this, 'woocommerce_missing_notice']);
            return;
        }

        // Load core functionality
        $this->load_core();
    }

    public function woocommerce_missing_notice() {
        echo '<div class="notice notice-error is-dismissible"><p>';
        echo esc_html__('WooPrivacy (FREE) requiere WooCommerce activo.', 'chilean-data-protection');
        echo '</p></div>';
    }

    private function load_core() {
        require_once CHILEAN_DP_PLUGIN_DIR . 'includes/core/class-catalog-loader.php';
        require_once CHILEAN_DP_PLUGIN_DIR . 'includes/core/class-compliance-profile.php';
        require_once CHILEAN_DP_PLUGIN_DIR . 'includes/core/class-applicability-engine.php';
        require_once CHILEAN_DP_PLUGIN_DIR . 'includes/core/class-assessment-engine.php';
        require_once CHILEAN_DP_PLUGIN_DIR . 'includes/core/class-diagnostic-engine.php';
        require_once CHILEAN_DP_PLUGIN_DIR . 'includes/core/class-guidance-engine.php';
        require_once CHILEAN_DP_PLUGIN_DIR . 'includes/core/class-environment-detector.php';
        require_once CHILEAN_DP_PLUGIN_DIR . 'includes/core/class-report.php';
        require_once CHILEAN_DP_PLUGIN_DIR . 'includes/core/class-guide.php';
        require_once CHILEAN_DP_PLUGIN_DIR . 'includes/admin/class-dashboard.php';

        Chilean_DP_Catalog_Loader::instance();
        Chilean_DP_Compliance_Profile::instance();
        Chilean_DP_Applicability_Engine::instance();
        Chilean_DP_Assessment_Engine::instance();
        Chilean_DP_Diagnostic_Engine::instance();
        Chilean_DP_Guidance_Engine::instance();
        Chilean_DP_Environment_Detector::instance();
        Chilean_DP_Report::instance();
        Chilean_DP_Guide::instance();
        Chilean_DP_Dashboard::instance();
    }

    public function add_admin_menu() {
        add_menu_page(
            __('WooPrivacy', 'chilean-data-protection'),
            __('WooPrivacy (FREE)', 'chilean-data-protection'),
            'manage_woocommerce',
            'chilean-dp',
            [Chilean_DP_Dashboard::instance(), 'render_page'],
            'dashicons-shield-alt',
            56
        );

        add_submenu_page(
            'chilean-dp',
            __('Guía y acerca de', 'chilean-data-protection'),
            __('Guía', 'chilean-data-protection'),
            'manage_woocommerce',
            'chilean-dp-guide',
            [Chilean_DP_Guide::instance(), 'render_page']
        );

        add_submenu_page(
            'chilean-dp',
            __('Perfil de Cumplimiento', 'chilean-data-protection'),
            __('Perfil', 'chilean-data-protection'),
            'manage_woocommerce',
            'chilean-dp-profile',
            [Chilean_DP_Compliance_Profile::instance(), 'render_page']
        );
    }

    public function enqueue_frontend_assets() {
        wp_enqueue_style(
            'chilean-dp-frontend',
            CHILEAN_DP_PLUGIN_URL . 'assets/css/frontend.css',
            [],
            CHILEAN_DP_VERSION
        );

        wp_enqueue_script(
            'chilean-dp-frontend',
            CHILEAN_DP_PLUGIN_URL . 'assets/js/frontend.js',
            ['jquery'],
            CHILEAN_DP_VERSION,
            true
        );
    }

    public function enqueue_admin_assets($hook) {
        if (strpos($hook, 'chilean-dp') === false) {
            return;
        }

        wp_enqueue_style(
            'chilean-dp-admin',
            CHILEAN_DP_PLUGIN_URL . 'assets/css/admin.css',
            [],
            CHILEAN_DP_VERSION
        );

        wp_enqueue_script(
            'chilean-dp-admin',
            CHILEAN_DP_PLUGIN_URL . 'assets/js/admin.js',
            ['jquery'],
            CHILEAN_DP_VERSION,
            true
        );
    }
}

// Initialize plugin
Chilean_Data_Protection::instance();

// Helper function
function chilean_dp() {
    return Chilean_Data_Protection::instance();
}