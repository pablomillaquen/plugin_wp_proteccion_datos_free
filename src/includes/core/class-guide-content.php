<?php
/**
 * Guide Content Loader — SPEC-FREE-013
 * Carga la capa overlay de contenido humano (guide-content.json).
 * Entrada inválida se excluye con log y la tarjeta cae al contenido base del catálogo (fail-safe por entrada).
 * No modifica catálogo ni motores frozen.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Chilean_DP_Guide_Content {

    const CACHE_KEY = 'chilean_dp_guide_content_v1';
    const CACHE_GROUP = 'chilean_dp';

    private static $instance = null;
    private $entries = null;

    public static function instance() {
        if ( null === self::$instance ) { self::$instance = new self(); }
        return self::$instance;
    }

    private function __construct() {}

    public function load() {
        if ( null !== $this->entries ) { return $this->entries; }
        $cached = wp_cache_get( self::CACHE_KEY, self::CACHE_GROUP );
        if ( is_array( $cached ) ) { $this->entries = $cached; return $this->entries; }

        $raw = file_get_contents( CHILEAN_DP_PLUGIN_DIR . 'catalog/guide-content.json' );
        $this->entries = [];
        if ( false === $raw ) { $this->log( 'guide-content.json ilegible' ); return $this->entries; }
        $data = json_decode( $raw, true );
        if ( ! is_array( $data ) || ! isset( $data['controls'] ) || ! is_array( $data['controls'] ) ) {
            $this->log( 'guide-content.json inválido' );
            return $this->entries;
        }

        foreach ( $data['controls'] as $id => $entry ) {
            if ( $this->validate_entry( $entry ) ) {
                $this->entries[ $id ] = $entry;
            } else {
                $this->log( 'entrada guide-content inválida excluida: ' . $id );
            }
        }
        wp_cache_set( self::CACHE_KEY, $this->entries, self::CACHE_GROUP );
        return $this->entries;
    }

    /** @return array|null */
    public function get( $control_id ) {
        $all = $this->load();
        return $all[ $control_id ] ?? null;
    }

    private function validate_entry( $e ) {
        if ( ! is_array( $e ) ) { return false; }
        foreach ( [ 'title','what_it_means','why_it_matters','what_to_check',
                    'where_to_check','detection_note','how_to_know_covered','legal_explanation' ] as $f ) {
            if ( empty( $e[ $f ] ) || ! is_string( $e[ $f ] ) ) { return false; }
        }
        return in_array( $e['detection_capability'] ?? '', [ 'auto', 'manual', 'mixed' ], true );
    }

    public function capability_label( $cap ) {
        return [
            'auto'   => __( '🔎 WooPrivacy FREE lo puede detectar', 'datarights-for-woocommerce' ),
            'mixed'  => __( '🔎👤 Detecta una parte — el resto lo compruebas tú', 'datarights-for-woocommerce' ),
            'manual' => __( '👤 Debes comprobarlo tú', 'datarights-for-woocommerce' ),
        ][ $cap ] ?? '';
    }

    private function log( $m ) {
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG && defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
            error_log( '[chilean-dp][guide-content] ' . $m );
        }
    }
}
