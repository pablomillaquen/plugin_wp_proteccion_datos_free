<?php
/**
 * Compliance Profile — SPEC-FREE-003
 * Captura y expone el perfil mínimo de la tienda (entrada del Applicability Engine).
 * Semántica: true/false/null; null = sin responder → requiere revisión downstream.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
class Chilean_DP_Compliance_Profile {

    const OPTION_KEY     = 'chilean_dp_profile';
    const PROFILE_VERSION = '1.0';
    const NONCE_ACTION   = 'chilean_dp_profile_save';
    const NONCE_FIELD    = 'chilean_dp_profile_nonce';

    private static $instance = null;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action( 'admin_init', [ $this, 'handle_save' ] );
    }

    public function get_questions() {
        return [
            [ 'dimension' => 'customer_accounts',       'group' => 'characteristics',    'label' => '¿Tu tienda permite que los clientes creen cuentas?' ],
            [ 'dimension' => 'checkout_data',           'group' => 'characteristics',    'label' => '¿En el proceso de compra se recopilan datos personales de los clientes?' ],
            [ 'dimension' => 'direct_marketing',        'group' => 'processing_context', 'label' => '¿Realizas marketing directo (campañas o envíos comerciales a tus clientes)?' ],
            [ 'dimension' => 'newsletter',              'group' => 'processing_context', 'label' => '¿Tu tienda ofrece suscripción a newsletter?' ],
            [ 'dimension' => 'analytics',               'group' => 'processing_context', 'label' => '¿Usas herramientas de analítica web (por ejemplo Google Analytics)?' ],
            [ 'dimension' => 'cookies',                 'group' => 'processing_context', 'label' => '¿Tu sitio usa cookies o tecnologías similares más allá de las estrictamente necesarias para funcionar?' ],
            [ 'dimension' => 'special_categories',      'group' => 'processing_context', 'label' => '¿Recopilas datos especialmente protegidos (salud, origen étnico, ideología, datos biométricos, etc.)?' ],
            [ 'dimension' => 'third_parties',           'group' => 'integrations',       'label' => '¿Utilizas servicios de terceros que tratan datos de tus clientes (pasarelas de pago, email marketing, CRM, hosting, etc.)?' ],
            [ 'dimension' => 'international_transfers', 'group' => 'integrations',       'label' => '¿Alguno de tus proveedores almacena o procesa estos datos fuera de Chile?' ],
        ];
    }

    public function get_groups() {
        return [
            'characteristics'    => 'Características de la tienda',
            'processing_context' => 'Contexto de tratamiento',
            'integrations'       => 'Integraciones y terceros',
        ];
    }

    public function get_profile() {
        $saved = get_option( self::OPTION_KEY, [] );
        if ( ! is_array( $saved ) ) {
            $saved = [];
        }

        $profile = [
            'characteristics'    => $this->slice( $saved, [ 'customer_accounts', 'checkout_data' ] ),
            'processing_context' => $this->slice( $saved, [ 'direct_marketing', 'newsletter', 'analytics', 'cookies', 'special_categories' ] ),
            'integrations'       => $this->slice( $saved, [ 'third_parties', 'international_transfers' ] ),
            'derived'            => [ 'consent_processing' => $this->derive_consent_processing( $saved ) ],
            'meta'               => [
                'answered_at'     => $saved['_meta']['answered_at'] ?? null,
                'source'          => 'user-declared',
                'profile_version' => self::PROFILE_VERSION,
            ],
        ];

        return $profile;
    }

    public function save_answers( array $raw_answers ) {
        $valid_dims = wp_list_pluck( $this->get_questions(), 'dimension' );
        $current    = get_option( self::OPTION_KEY, [] );
        if ( ! is_array( $current ) ) {
            $current = [];
        }

        foreach ( $valid_dims as $dim ) {
            if ( ! array_key_exists( $dim, $raw_answers ) ) {
                continue; // RS3: preservar valores previos no enviados
            }
            $current[ $dim ] = $this->to_tristate( $raw_answers[ $dim ] );
        }

        $meta                     = is_array( $current['_meta'] ?? null ) ? $current['_meta'] : [];
        $meta['answered_at']      = time();
        $meta['source']           = 'user-declared';
        $meta['profile_version']  = self::PROFILE_VERSION;
        $current['_meta']         = $meta;

        update_option( self::OPTION_KEY, $current, false );
        return $this->get_profile();
    }

    public function handle_save() {
        if ( ! isset( $_POST[ self::NONCE_FIELD ] ) ) {
            return;
        }
        if ( ! current_user_can( 'manage_woocommerce' ) ) {
            return;
        }
        check_admin_referer( self::NONCE_ACTION, self::NONCE_FIELD );

        $answers = isset( $_POST['chilean_dp_profile'] ) && is_array( $_POST['chilean_dp_profile'] )
            ? array_map( 'sanitize_text_field', wp_unslash( $_POST['chilean_dp_profile'] ) )
            : [];

        $this->save_answers( $answers );

        add_settings_error(
            'chilean_dp_profile',
            'chilean_dp_profile_saved',
            __( 'Perfil guardado correctamente.', 'datarights-for-woocommerce' ),
            'success'
        );
    }

    public function render_page() {
        if ( ! current_user_can( 'manage_woocommerce' ) ) {
            wp_die( esc_html__( 'No tienes permisos para acceder a esta página.', 'datarights-for-woocommerce' ) );
        }

        $profile  = $this->get_profile();
        $flat     = array_merge( $profile['characteristics'], $profile['processing_context'], $profile['integrations'] );
        $groups   = $this->get_groups();
        ?>
        <div class="wrap">
            <h1><?php echo esc_html__( 'Perfil de Cumplimiento', 'datarights-for-woocommerce' ); ?></h1>
            <p><?php echo esc_html__( 'Estas respuestas determinan qué obligaciones y controles aplican a tu tienda. Responde solo lo que conozcas: si dejas algo en "Aún no lo sé", ese punto quedará marcado para revisión.', 'datarights-for-woocommerce' ); ?></p>
            <?php settings_errors( 'chilean_dp_profile' ); ?>
            <form method="post">
                <?php wp_nonce_field( self::NONCE_ACTION, self::NONCE_FIELD ); ?>
                <?php foreach ( $groups as $group_key => $group_label ) : ?>
                    <h2><?php echo esc_html( $group_label ); ?></h2>
                    <table class="form-table" role="presentation">
                        <?php foreach ( $this->questions_in_group( $group_key ) as $q ) : ?>
                            <tr>
                                <th scope="row"><?php echo esc_html( $q['label'] ); ?></th>
                                <td>
                                    <?php $this->render_tristate( $q['dimension'], $flat[ $q['dimension'] ] ?? null ); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endforeach; ?>
                <?php submit_button( __( 'Guardar perfil', 'datarights-for-woocommerce' ) ); ?>
            </form>
        </div>
        <?php
    }

    private function derive_consent_processing( array $saved ) {
        $inputs = [ 'direct_marketing', 'newsletter', 'analytics', 'cookies' ];
        foreach ( $inputs as $dim ) {
            if ( true === ( $saved[ $dim ] ?? null ) ) {
                return true;
            }
        }
        foreach ( $inputs as $dim ) {
            if ( null === ( $saved[ $dim ] ?? null ) ) {
                return null;
            }
        }
        return false;
    }

    private function slice( array $saved, array $dims ) {
        $out = [];
        foreach ( $dims as $d ) {
            $out[ $d ] = array_key_exists( $d, $saved ) ? $saved[ $d ] : null;
        }
        return $out;
    }

    private function to_tristate( $value ) {
        if ( '1' === (string) $value ) {
            return true;
        }
        if ( '0' === (string) $value ) {
            return false;
        }
        return null;
    }

    private function questions_in_group( $group ) {
        return array_values( array_filter( $this->get_questions(), fn( $q ) => $q['group'] === $group ) );
    }

    private function render_tristate( $dimension, $current ) {
        $options = [
            '1' => __( 'Sí', 'datarights-for-woocommerce' ),
            '0' => __( 'No', 'datarights-for-woocommerce' ),
            ''  => __( 'Aún no lo sé', 'datarights-for-woocommerce' ),
        ];
        // BUG-004: (string)false === '' marcaba "Sin responder" tras guardar No.
        $cur = null === $current ? '' : ( true === $current ? '1' : '0' );
        printf( '<input type="hidden" name="chilean_dp_profile[%s]" value="" />', esc_attr( $dimension ) );
        foreach ( $options as $value => $label ) {
            printf(
                '<label class="chilean-dp-radio-label"><input type="radio" name="chilean_dp_profile[%s]" value="%s" %s /> %s</label>',
                esc_attr( $dimension ),
                esc_attr( $value ),
                checked( $cur, $value, false ),
                esc_html( $label )
            );
        }
    }
}
