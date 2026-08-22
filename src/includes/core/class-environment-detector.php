<?php
/**
 * Environment Detection — SPEC-FREE-009
 * Observa aspectos técnicos verificables de la instalación y aporta EVIDENCIA
 * para el assessment. REGLA: una observación técnica NUNCA es una conclusión jurídica.
 *
 * No modifica motores congelados: guarda detecciones en su propia option y las expone
 * como evidencia comparable con las declaraciones del perfil (adoptar = usar API pública frozen).
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
class Chilean_DP_Environment_Detector {

    const OPTION_KEY   = 'chilean_dp_detections';
    const SOURCE       = 'auto-detected';

    private static $instance = null;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {}

    /** Dimensiones del perfil que este detector puede observar. */
    public function detectable_dimensions() {
        return [ 'customer_accounts', 'newsletter', 'analytics', 'cookies', 'third_parties' ];
    }

    /** Ejecuta todas las detecciones técnicas y persiste el snapshot. */
    public function run() {
        $detections = [
            '_meta' => [
                'ran_at'      => time(),
                'source'      => self::SOURCE,
                'wp_version'  => get_bloginfo( 'version' ),
                'wc_version'  => defined( 'WC_VERSION' ) ? WC_VERSION : null,
                'ssl'         => is_ssl() || force_ssl_admin(),
            ],
        ];

        foreach ( $this->checks() as $dim => $check ) {
            $detections[ $dim ] = [
                'value'   => $check['value'],
                'method'  => $check['method'],
                'details' => $check['details'],
            ];
        }

        update_option( self::OPTION_KEY, $detections, false );
        return $detections;
    }

    public function get_detections() {
        $v = get_option( self::OPTION_KEY, [] );
        return is_array( $v ) ? $v : [];
    }

    /**
     * Vista de evidencia por dimensión detectable:
     * compara detección vs declaración SIN alterar ninguna capa (solo informa).
     * match | mismatch | unconfirmed (perfil null) | undetected (no observable)
     */
    public function get_evidence_view() {
        $det     = $this->get_detections();
        $profile = Chilean_DP_Compliance_Profile::instance()->get_profile();
        $dims    = array_merge( $profile['characteristics'], $profile['processing_context'], $profile['integrations'] );

        $view = [];
        foreach ( $this->detectable_dimensions() as $dim ) {
            $observed = isset( $det[ $dim ] ) ? $det[ $dim ]['value'] : null;
            $declared = $dims[ $dim ] ?? null;

            if ( null === $observed ) {
                $relation = 'undetected';
            } elseif ( null === $declared ) {
                $relation = 'unconfirmed';
            } else {
                $relation = ( $observed === $declared ) ? 'match' : 'mismatch';
            }

            $view[ $dim ] = [
                'observed' => $observed,
                'declared' => $declared,
                'relation' => $relation,
                'method'   => $det[ $dim ]['method'] ?? null,
                'details'  => $det[ $dim ]['details'] ?? [],
            ];
        }
        return $view;
    }

    /**
     * Adoptar una detección como declaración del usuario.
     * Usa SOLO la API pública congelada save_answers(); source sigue siendo user-declared
     * porque la adopción es un acto del administrador.
     */
    public function adopt_dimension( $dimension, $value ) {
        if ( ! in_array( $dimension, $this->detectable_dimensions(), true ) ) {
            return false;
        }
        Chilean_DP_Compliance_Profile::instance()->save_answers( [ $dimension => $value ? '1' : '0' ] );
        return true;
    }

    private function checks() {
        $checks = [];

        // Cuentas de cliente (ajuste WooCommerce)
        $checks['customer_accounts'] = [
            'value'   => class_exists( 'WooCommerce' ) && 'yes' === get_option( 'woocommerce_enable_myaccount_registration', 'no' ),
            'method'  => 'Opción WooCommerce "crear cuenta en mi cuenta"',
            'details' => [ 'woocommerce_enable_myaccount_registration' ],
        ];

        // Plugins newsletter conocidos
        $news = $this->active_plugin_match( [ 'mailpoet', 'newsletter', 'mailster', 'sendinblue', 'wysija-newsletters' ] );
        $checks['newsletter'] = [
            'value'   => null !== $news ? true : null,
            'method'  => 'Presencia de plugins conocidos de email marketing',
            'details' => null !== $news ? [ $news ] : [],
        ];

        // Plugins analítica conocidos
        $ana = $this->active_plugin_match( [ 'google-site-kit', 'ga-google-analytics', 'google-analytics-for-wordpress', 'monsterinsights', 'exactmetrics', 'matomo' ] );
        $checks['analytics'] = [
            'value'   => null !== $ana ? true : null,
            'method'  => 'Presencia de plugins conocidos de analítica',
            'details' => null !== $ana ? [ $ana ] : [],
        ];

        // Plugins cookies/CMP conocidos
        $cook = $this->active_plugin_match( [ 'complianz-gdpr', 'cookie-notice', 'cookieyes', 'borlabs-cookie', 'gdpr-cookie-compliance', 'iubenda-cookie' ] );
        $checks['cookies'] = [
            'value'   => null !== $cook ? true : null,
            'method'  => 'Presencia de plugins conocidos de cookies/consentimiento',
            'details' => null !== $cook ? [ $cook ] : [],
        ];
        // Nota honesta: ausencia de plugin NO prueba ausencia de cookies (scripts manuales) → null si no hay match

        // Terceros: pasarelas de pago activas (excluye métodos offline)
        $tp = null; $list = [];
        if ( class_exists( 'WC_Payment_Gateways' ) && function_exists( 'WC' ) ) {
            $gateways = WC_Payment_Gateways::instance()->get_available_payment_gateways();
            $offline  = [ 'bacs', 'cheque', 'cod' ];
            foreach ( $gateways as $id => $gw ) {
                if ( ! in_array( $id, $offline, true ) ) { $list[] = $id; }
            }
            $tp = empty( $list ) ? false : true;
        }
        $checks['third_parties'] = [
            'value'   => $tp,
            'method'  => 'Pasarelas de pago activas distintas de métodos offline',
            'details' => $list,
        ];

        return $checks;
    }

    private function active_plugin_match( array $slugs ) {
        $active = (array) get_option( 'active_plugins', [] );
        foreach ( $active as $plugin ) {
            foreach ( $slugs as $slug ) {
                if ( false !== strpos( strtolower( $plugin ), $slug ) ) {
                    return basename( $plugin, '.php' );
                }
            }
        }
        return null;
    }
}
