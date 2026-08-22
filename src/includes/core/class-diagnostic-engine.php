<?php
/**
 * Diagnostic & Prioritization Engine — SPEC-FREE-006
 * Convierte assessment view + catálogo en diagnóstico accionable.
 * REGLA P2/R2: solo contadores honestos. CERO scores, porcentajes o semáforos.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
class Chilean_DP_Diagnostic_Engine {

    private static $instance = null;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {}

    public function generate() {
        $view     = Chilean_DP_Assessment_Engine::instance()->get_assessment_view();
        $controls = Chilean_DP_Catalog_Loader::instance()->get_controls();
        $obligs   = Chilean_DP_Catalog_Loader::instance()->get_obligations();

        $controls_out = [];
        $areas        = [];
        foreach ( $obligs as $oid => $o ) {
            $areas[ $oid ] = [
                'name' => $o['name'], 'priority' => $o['priority'],
                'implemented' => 0, 'partial' => 0, 'pending' => 0,
                'unassessed' => 0, 'unknown_state' => 0,
                'requires_review' => 0, 'not_applicable' => 0,
            ];
        }

        foreach ( $view as $cid => $row ) {
            $ctrl   = $controls[ $cid ];
            $app    = $row['applicability']['status'];
            $asmt   = $row['assessment'];

            if ( 'NOT_APPLICABLE' === $app ) {
                $diag = 'not_applicable';
            } elseif ( 'REQUIRES_REVIEW' === $app ) {
                $diag = 'requires_review';
            } elseif ( null === $asmt ) {
                $diag = 'unassessed';
            } else {
                switch ( $asmt['status'] ) {
                    case 'IMPLEMENTED': $diag = 'implemented'; break;
                    case 'PARTIAL':     $diag = 'partial';     break;
                    case 'PENDING':     $diag = 'pending';     break;
                    default:            $diag = 'unknown_state';
                }
            }

            $gap_priority = null;
            if ( in_array( $diag, [ 'pending', 'partial' ], true ) ) {
                $gap_priority = ( 'HIGH' === $ctrl['priority'] ) ? 'alta' : 'media';
            }

            foreach ( $ctrl['obligations'] as $oid ) {
                if ( isset( $areas[ $oid ][ $diag ] ) ) {
                    $areas[ $oid ][ $diag ]++;
                }
            }

            $controls_out[ $cid ] = [
                'diagnostic_status' => $diag,
                'control_priority'  => $ctrl['priority'],
                'gap_priority'      => $gap_priority,
                'reasons'           => $row['applicability']['reasons'],
            ];
        }

        return [
            'controls' => $controls_out,
            'areas'    => $areas,
            'summary'  => $this->summarize( $controls_out ),
        ];
    }

    public function get_prioritized_gaps() {
        $diag = $this->generate();
        $gaps = [ 'alta' => [], 'media' => [] ];

        foreach ( $diag['controls'] as $cid => $c ) {
            if ( null !== $c['gap_priority'] ) {
                $gaps[ $c['gap_priority'] ][] = [
                    'control_id' => $cid,
                    'status'     => ( 'pending' === $c['diagnostic_status'] ) ? 'PENDING' : 'PARTIAL',
                ];
            }
        }
        return $gaps;
    }

    private function summarize( array $controls ) {
        $s = [
            'prioridad_alta' => 0, 'prioridad_media' => 0,
            'requiere_revision' => 0, 'incertidumbres_evaluacion' => 0,
            'sin_evaluar' => 0, 'implementados' => 0,
            'no_aplicables' => 0, 'total' => count( $controls ),
        ];
        foreach ( $controls as $c ) {
            switch ( $c['diagnostic_status'] ) {
                case 'pending':
                case 'partial':
                    ( 'alta' === $c['gap_priority'] ) ? $s['prioridad_alta']++ : $s['prioridad_media']++;
                    break;
                case 'requires_review':      $s['requiere_revision']++;          break;
                case 'unknown_state':        $s['incertidumbres_evaluacion']++;  break;
                case 'unassessed':           $s['sin_evaluar']++;                break;
                case 'implemented':          $s['implementados']++;              break;
                default:                     $s['no_aplicables']++;
            }
        }
        return $s;
    }
}
