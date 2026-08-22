<?php
/**
 * Catalog Loader — carga y valida el Knowledge/Assessment Catalog (SPEC-FREE-002)
 *
 * Fail-closed: un control con campos inválidos se excluye del resultado y se registra en el log;
 * nunca se expone un catálogo a medias.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
class Chilean_DP_Catalog_Loader {

    const CACHE_KEY   = 'chilean_dp_catalog_v1';
    const CACHE_GROUP = 'chilean_dp';

    private static $instance = null;
    private $catalog = null;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {}

    public function load() {
        if ( null !== $this->catalog ) {
            return $this->catalog;
        }

        $cached = wp_cache_get( self::CACHE_KEY, self::CACHE_GROUP );
        if ( is_array( $cached ) ) {
            $this->catalog = $cached;
            return $this->catalog;
        }

        $raw = file_get_contents( CHILEAN_DP_PLUGIN_DIR . 'catalog/catalog.json' );
        if ( false === $raw ) {
            $this->log( 'No se pudo leer catalog.json' );
            $this->catalog = $this->empty_catalog();
            return $this->catalog;
        }

        $data = json_decode( $raw, true );
        if ( ! is_array( $data ) || ! $this->validate_meta( $data['meta'] ?? null ) ) {
            $this->log( 'catalog.json inválido o sin meta válida' );
            $this->catalog = $this->empty_catalog();
            return $this->catalog;
        }

        $obligations = [];
        foreach ( ( $data['obligations'] ?? [] ) as $obl ) {
            if ( $this->validate_obligation( $obl ) ) {
                $obligations[ $obl['id'] ] = $obl;
            } else {
                $this->log( 'Obligación inválida excluida: ' . ( $obl['id'] ?? '(sin id)' ) );
            }
        }

        $controls = [];
        $known_dims = array_keys( $data['meta']['applicability_dimensions'] );
        foreach ( ( $data['controls'] ?? [] ) as $ctrl ) {
            if ( $this->validate_control( $ctrl, array_keys( $obligations ), $known_dims ) ) {
                $controls[ $ctrl['id'] ] = $ctrl;
            } else {
                $this->log( 'Control inválido excluido: ' . ( $ctrl['id'] ?? '(sin id)' ) );
            }
        }

        $this->catalog = [
            'meta'        => $data['meta'],
            'obligations' => $obligations,
            'controls'    => $controls,
        ];

        wp_cache_set( self::CACHE_KEY, $this->catalog, self::CACHE_GROUP );
        return $this->catalog;
    }

    public function get_meta() {
        return $this->load()['meta'];
    }

    public function get_obligations() {
        return $this->load()['obligations'];
    }

    public function get_controls() {
        return $this->load()['controls'];
    }

    public function get_control( $id ) {
        return $this->load()['controls'][ $id ] ?? null;
    }

    private function empty_catalog() {
        return [ 'meta' => [], 'obligations' => [], 'controls' => [] ];
    }

    private function validate_meta( $meta ) {
        return is_array( $meta )
            && isset( $meta['schema_version'], $meta['catalog_version'], $meta['law'], $meta['effective_date'] )
            && isset( $meta['applicability_dimensions'] )
            && is_array( $meta['applicability_dimensions'] );
    }

    private function validate_obligation( $obl ) {
        return is_array( $obl )
            && isset( $obl['id'], $obl['name'], $obl['description'], $obl['legal_references'], $obl['category'], $obl['priority'] )
            && preg_match( '/^OBL-[A-Z]+(?:-[A-Z]+)*-\d{3}$/', $obl['id'] )
            && is_array( $obl['legal_references'] )
            && in_array( $obl['priority'], [ 'HIGH', 'MEDIUM' ], true );
    }

    private function validate_control( $ctrl, $valid_obligation_ids, $known_dims ) {
        if ( ! is_array( $ctrl ) || ! isset(
            $ctrl['id'], $ctrl['name'], $ctrl['obligations'], $ctrl['description'],
            $ctrl['objective'], $ctrl['applicability'], $ctrl['evaluation_method'],
            $ctrl['states'], $ctrl['recommendation'], $ctrl['priority'],
            $ctrl['requires_review']
        ) ) {
            return false;
        }

        if ( ! preg_match( '/^CTRL-[A-Z]+(?:-[A-Z]+)*-\d{3}$/', $ctrl['id'] ) ) {
            return false;
        }

        foreach ( $ctrl['obligations'] as $oid ) {
            if ( ! in_array( $oid, $valid_obligation_ids, true ) ) {
                return false;
            }
        }

        if ( ! in_array( $ctrl['evaluation_method'], [ 'auto', 'declared', 'mixed' ], true ) ) {
            return false;
        }

        if ( ! in_array( $ctrl['priority'], [ 'HIGH', 'MEDIUM' ], true ) ) {
            return false;
        }

        if ( $ctrl['requires_review'] && empty( $ctrl['review_reason'] ) ) {
            return false;
        }

        return $this->validate_applicability( $ctrl['applicability'], $known_dims );
    }

    private function validate_applicability( $appl, $known_dims ) {
        if ( ! is_array( $appl ) || [] === $appl ) {
            return true; // {} = siempre aplicable
        }
        if ( ! isset( $appl['any_of'] ) || ! is_array( $appl['any_of'] ) ) {
            return false;
        }

        foreach ( $appl['any_of'] as $group ) {
            if ( ! is_array( $group ) || ! isset( $group['all_of'] ) || ! is_array( $group['all_of'] ) ) {
                return false;
            }
            foreach ( $group['all_of'] as $cond ) {
                if ( ! is_array( $cond ) || ! isset( $cond['dimension'] ) || ! array_key_exists( 'equals', $cond ) ) {
                    return false;
                }
                if ( [] !== $known_dims && ! in_array( $cond['dimension'], $known_dims, true ) ) {
                    return false;
                }
            }
        }
        return true;
    }

    private function log( $message ) {
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG && defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
            error_log( '[chilean-dp][catalog] ' . $message );
        }
    }
}
