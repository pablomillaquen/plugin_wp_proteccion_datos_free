<?php
/**
 * Guidance & Roadmap Engine — SPEC-FREE-007
 * Convierte el diagnóstico (FREE-006) en orientación comprensible y accionable.
 * NO modifica motores congelados. NO produce score. Contrato de salida para FREE-008.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
class Chilean_DP_Guidance_Engine {

    private static $instance = null;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {}

    public function generate() {
        $diag     = Chilean_DP_Diagnostic_Engine::instance()->generate();
        $controls = Chilean_DP_Catalog_Loader::instance()->get_controls();

        $roadmap = [ 'hacer_ahora' => [], 'confirmar' => [], 'evaluar' => [], 'hecho' => [] ];

        foreach ( $diag['controls'] as $cid => $c ) {
            $item = $this->build_item( $cid, $c, $controls[ $cid ] );
            switch ( $c['diagnostic_status'] ) {
                case 'pending':
                case 'partial':
                    $roadmap['hacer_ahora'][] = $item;
                    break;
                case 'requires_review':
                    $roadmap['confirmar'][] = $item;
                    break;
                case 'implemented':
                case 'unknown_state':
                    $roadmap['hecho'][] = $item;
                    break;
                default: // unassessed
                    $roadmap['evaluar'][] = $item;
            }
        }

        // F-EVAL-03: evaluar ordenado por prioridad del control (HIGH primero), nunca como "sin problemas"
        usort( $roadmap['evaluar'], fn( $a, $b ) => strcmp( $a['priority_raw'], $b['priority_raw'] ) ); // H<HIGH < MEDIUM asc
        // Hacer ahora: PENDING antes que PARTIAL; dentro, alta antes que media
        usort( $roadmap['hacer_ahora'], function ( $a, $b ) {
            $rank = fn( $i ) => ( $i['status_internal'] === 'PENDING' ? 0 : 1 )
                . ( 'alta' === $i['priority'] ? '0' : '1' );
            return strcmp( $rank( $a ), $rank( $b ) );
        } );

        $s = $diag['summary'];
        $summary = [
            'attention' => $this->attention_notice( $s ),
            'phrase'    => $this->summary_phrase( $s ),
            'counts'    => $s,
        ];

        return [ 'summary' => $summary, 'roadmap' => $roadmap ];
    }

    private function build_item( $cid, array $c, array $ctrl ) {
        $asmt = Chilean_DP_Assessment_Engine::instance()->get_evaluation( $cid );

        return [
            'id'             => $cid,
            'title'          => $ctrl['name'],
            'priority'       => $c['gap_priority'],
            'priority_raw'   => $ctrl['priority'],
            'status_internal'=> ( 'partial' === $c['diagnostic_status'] ) ? 'PARTIAL'
                                : ( ( 'pending' === $c['diagnostic_status'] ) ? 'PENDING'
                                : ( isset( $asmt['status'] ) ? $asmt['status'] : null ) ),
            'status_label'   => $this->user_label( $c, $asmt ),
            'why'            => $ctrl['objective'],
            'what_to_do'     => $ctrl['recommendation'],
            'legal_refs'     => $this->legal_refs( $ctrl ),
            'review_detail'  => $this->translate_review_reasons( $c['reasons'] ),
            'observation'    => $asmt['observation'] ?? null,
        ];
    }

    /**
     * F-EVAL-02: mapeo contextual interno→usuario. No reemplazo mecánico:
     * cada estado tiene su frase según lo que significa para el dueño de tienda.
     */
    private function user_label( array $c, $asmt ) {
        switch ( $c['diagnostic_status'] ) {
            case 'pending':          return ( 'alta' === $c['gap_priority'] ) ? 'Por hacer — prioritario' : 'Por hacer';
            case 'partial':          return 'Cubierto a medias';
            case 'implemented':      return 'Cubierto';
            case 'requires_review':  return 'Necesita confirmación';
            case 'unknown_state':    return 'Sin confirmar';
            default:                 return ( 'HIGH' === $c['control_priority'] ) ? 'Aún sin evaluar — importante' : 'Aún sin evaluar';
        }
    }

    private function translate_review_reasons( array $reasons ) {
        $out = [];
        foreach ( $reasons as $r ) {
            if ( 'PROFILE_UNKNOWN' === ( $r['code'] ?? '' ) ) {
                $dims = implode( ', ', $r['dimensions'] ?? [] );
                $out[] = 'Falta información de tu tienda para determinar si esto aplica' . ( $dims ? " ($dims)" : '' ) . '.';
            } elseif ( 'KNOWLEDGE_PENDING' === ( $r['code'] ?? '' ) ) {
                $kd = $r['knowledge_reference'] ?? '';
                $out[] = "Pendiente de aclaración oficial ($kd): este punto depende de definiciones que la autoridad aún no ha publicado. No puedes cerrarlo todavía.";
            }
        }
        return $out;
    }

    /**
     * F-EVAL-03: si hay controles sin evaluar, SIEMPRE hay aviso de atención,
     * aunque prioridad_alta=0. Prohibido implicar ausencia de problemas.
     */
    private function attention_notice( array $s ) {
        if ( $s['sin_evaluar'] > 0 ) {
            return [
                'show'  => true,
                'level' => 'info',
                'message' => sprintf(
                    'Todavía hay %d aspectos sin evaluar. Algunos podrían revelar brechas importantes: revisa los marcados como importantes primero.',
                    $s['sin_evaluar']
                ),
            ];
        }
        if ( $s['prioridad_alta'] > 0 || $s['prioridad_media'] > 0 ) {
            return [ 'show' => true, 'level' => 'warning', 'message' => 'Tienes puntos pendientes que requieren tu atención.' ];
        }
        return [ 'show' => false, 'level' => 'ok', 'message' => '' ];
    }

    private function summary_phrase( array $s ) {
        $parts = [];
        if ( $s['prioridad_alta'] > 0 ) {
            $parts[] = $s['prioridad_alta'] . ' punto' . ( 1 === $s['prioridad_alta'] ? '' : 's' ) . ' requieren atención prioritaria';
        }
        if ( $s['prioridad_media'] > 0 ) {
            $parts[] = $s['prioridad_media'] . ' pendiente' . ( 1 === $s['prioridad_media'] ? '' : 's' ) . ' de mejora';
        }
        if ( $s['requiere_revision'] > 0 ) {
            $parts[] = $s['requiere_revision'] . ' necesitan confirmación';
        }
        if ( $s['incertidumbres_evaluacion'] > 0 ) {
            $parts[] = $s['incertidumbres_evaluacion'] . ' sin confirmar';
        }
        if ( $s['sin_evaluar'] > 0 ) {
            $parts[] = $s['sin_evaluar'] . ' aún sin evaluar';
        }
        if ( empty( $parts ) && 0 === $s['no_aplicables'] ) {
            $parts[] = 'Todo cubierto';
        }
        if ( $s['no_aplicables'] > 0 ) {
            $parts[] = $s['no_aplicables'] . ' no aplican a tu tienda';
        }
        return implode( ' · ', $parts );
    }

    private function legal_refs( array $ctrl ) {
        $refs = [];
        foreach ( $ctrl['obligations'] as $oid ) {
            $obl = Chilean_DP_Catalog_Loader::instance()->get_obligations()[ $oid ] ?? null;
            if ( $obl ) { $refs = array_merge( $refs, $obl['legal_references'] ); }
        }
        return array_values( array_unique( $refs ) );
    }
}
