<?php
/**
 * Assessment Engine — SPEC-FREE-005
 * Registra, persiste y expone el estado de cada control con procedencia.
 * INVARIANTES: las capas applicability/assessment viajan separadas; sin conversiones automáticas.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
class Chilean_DP_Assessment_Engine {

    const OPTION_KEY = 'chilean_dp_assessments';
    const STATUSES   = [ 'IMPLEMENTED', 'PARTIAL', 'PENDING', 'UNKNOWN' ];
    const SOURCES    = [ 'user-declared', 'auto-detected', 'not-verifiable' ];

    private static $instance = null;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {}

    /**
     * Registra una evaluación. Devuelve ['ok'=>true,'assessment'=>...] o ['ok'=>false,'error'=>...].
     */
    public function record( $control_id, $status, $source = 'user-declared', $observation = '' ) {
        if ( ! Chilean_DP_Catalog_Loader::instance()->get_control( $control_id ) ) {
            return [ 'ok' => false, 'error' => 'control_inexistente' ];
        }
        if ( ! in_array( $status, self::STATUSES, true ) ) {
            return [ 'ok' => false, 'error' => 'status_invalido' ];
        }
        if ( ! in_array( $source, self::SOURCES, true ) ) {
            return [ 'ok' => false, 'error' => 'source_invalido' ];
        }

        $all = $this->get_assessments();
        $all[ $control_id ] = [
            'status'      => $status,
            'source'      => $source,
            'assessed_at' => time(),
            'observation' => sanitize_text_field( $observation ),
        ];
        update_option( self::OPTION_KEY, $all, false );

        return [ 'ok' => true, 'assessment' => $all[ $control_id ] ];
    }

    public function retract( $control_id ) {
        $all = $this->get_assessments();
        if ( ! isset( $all[ $control_id ] ) ) {
            return false;
        }
        unset( $all[ $control_id ] );
        update_option( self::OPTION_KEY, $all, false );
        return true;
    }

    public function get_assessments() {
        $v = get_option( self::OPTION_KEY, [] );
        return is_array( $v ) ? $v : [];
    }

    public function get_evaluation( $control_id ) {
        return $this->get_assessments()[ $control_id ] ?? null;
    }

    /**
     * Vista combinada: capas separadas, passthrough puro (INV2).
     * NO convierte estados entre capas (INV1) ni oculta evaluaciones huérfanas (INV5).
     */
    public function get_assessment_view() {
        $applicability = Chilean_DP_Applicability_Engine::instance()->evaluate_all()['results'];
        $stored        = $this->get_assessments();

        $view = [];
        foreach ( $applicability as $cid => $app ) {
            $view[ $cid ] = [
                'applicability' => $app,
                'assessment'    => $stored[ $cid ] ?? null,
            ];
        }
        return $view;
    }
}
