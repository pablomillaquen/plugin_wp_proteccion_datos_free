<?php
/**
 * Applicability Engine — SPEC-FREE-004
 * Catalog v1.0.0 + Profile v1.0 → estado de aplicabilidad por control.
 *
 * Estados: APPLICABLE | NOT_APPLICABLE | REQUIRES_REVIEW
 * REQUIRES_REVIEW preserva las razones (PROFILE_UNKNOWN / KNOWLEDGE_PENDING) — nunca colapsa incertidumbre a booleano.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
class Chilean_DP_Applicability_Engine {

    private static $instance = null;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {}

    public function evaluate_all() {
        $controls   = Chilean_DP_Catalog_Loader::instance()->get_controls();
        $dims       = $this->flatten_profile();

        $results = [];
        foreach ( $controls as $ctrl ) {
            $results[ $ctrl['id'] ] = $this->evaluate_control( $ctrl, $dims );
        }

        return [
            'results'     => $results,
            'obligations' => $this->rollup_obligations( $results ),
            'summary'     => $this->summarize( $results ),
        ];
    }

    public function evaluate_control( array $ctrl, array $dims = null ) {
        if ( null === $dims ) {
            $dims = $this->flatten_profile();
        }

        [ $cond_status, $unknown_dims ] = $this->evaluate_conditions( $ctrl['applicability'], $dims );

        $status  = $cond_status;
        $reasons = [];

        if ( 'REQUIRES_REVIEW' === $cond_status ) {
            $reasons[] = [
                'code'       => 'PROFILE_UNKNOWN',
                'source'     => 'compliance_profile',
                'dimensions' => $unknown_dims,
            ];
        }

        if ( ! empty( $ctrl['requires_review'] ) ) {
            $status     = 'REQUIRES_REVIEW';
            $reasons[]  = [
                'code'                => 'KNOWLEDGE_PENDING',
                'source'              => 'catalog',
                'knowledge_reference' => $this->extract_kd_reference( $ctrl['review_reason'] ?? '' ),
            ];
        }

        return [
            'control_id' => $ctrl['id'],
            'status'     => $status,
            'reasons'    => $reasons,
        ];
    }

    private function flatten_profile() {
        $profile = Chilean_DP_Compliance_Profile::instance()->get_profile();
        return array_merge(
            $profile['characteristics'],
            $profile['processing_context'],
            $profile['integrations'],
            $profile['derived']
        );
    }

    /**
     * @return array{0:string,1:array} estado (APPLICABLE|NOT_APPLICABLE|REQUIRES_REVIEW) y dimensiones unknown
     */
    private function evaluate_conditions( $appl, array $dims ) {
        if ( ! is_array( $appl ) || [] === $appl ) {
            return [ 'APPLICABLE', [] ];
        }

        $any_group_true   = false;
        $all_groups_false = true;
        $unknown_dims     = [];

        foreach ( ( $appl['any_of'] ?? [] ) as $group ) {
            $group_result = 'TRUE';

            foreach ( ( $group['all_of'] ?? [] ) as $cond ) {
                $value = $dims[ $cond['dimension'] ] ?? null;

                if ( null === $value ) {
                    $group_result  = ( 'FALSE' === $group_result ) ? 'FALSE' : 'UNKNOWN';
                    $unknown_dims[ $cond['dimension'] ] = true;
                    continue;
                }
                if ( $value !== (bool) $cond['equals'] ) {
                    $group_result = 'FALSE';
                }
            }

            if ( 'TRUE' === $group_result ) {
                $any_group_true   = true;
            }
            if ( 'FALSE' !== $group_result ) {
                $all_groups_false = false;
            }
        }

        if ( $any_group_true ) {
            return [ 'APPLICABLE', array_keys( $unknown_dims ) ];
        }
        if ( $all_groups_false ) {
            return [ 'NOT_APPLICABLE', array_keys( $unknown_dims ) ];
        }
        return [ 'REQUIRES_REVIEW', array_keys( $unknown_dims ) ];
    }

    private function extract_kd_reference( $review_reason ) {
        if ( preg_match( '/KD-\d+/', (string) $review_reason, $m ) ) {
            return $m[0];
        }
        return null;
    }

    private function rollup_obligations( array $results ) {
        $obligations = Chilean_DP_Catalog_Loader::instance()->get_obligations();
        $out = [];

        foreach ( $obligations as $obl_id => $obl ) {
            $ctrl_ids = [];
            foreach ( Chilean_DP_Catalog_Loader::instance()->get_controls() as $c ) {
                if ( in_array( $obl_id, $c['obligations'], true ) ) {
                    $ctrl_ids[] = $c['id'];
                }
            }
            $states = [];
            foreach ( $ctrl_ids as $cid ) {
                $states[] = $results[ $cid ]['status'];
            }

            if ( empty( $states ) ) {
                continue;
            }
            if ( in_array( 'APPLICABLE', $states, true ) || in_array( 'REQUIRES_REVIEW', $states, true ) ) {
                $out[ $obl_id ] = in_array( 'APPLICABLE', $states, true ) ? 'APPLICABLE' : 'REQUIRES_REVIEW';
            } else {
                $out[ $obl_id ] = 'NOT_APPLICABLE';
            }
        }
        return $out;
    }

    private function summarize( array $results ) {
        $s = [ 'total' => count( $results ), 'APPLICABLE' => 0, 'NOT_APPLICABLE' => 0, 'REQUIRES_REVIEW' => 0 ];
        foreach ( $results as $r ) {
            $s[ $r['status'] ]++;
        }
        return $s;
    }
}
