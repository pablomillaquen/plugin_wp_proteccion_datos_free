<?php
/**
 * Dashboard & UX — SPEC-FREE-008
 * PROYECCIÓN de los motores congelados. CERO lógica de cumplimiento propia:
 * no interpreta, no calcula, no decide — solo presenta lo que FREE-007 entregó
 * y captura evaluaciones del usuario vía Assessment Engine.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
class Chilean_DP_Dashboard {

    const NONCE_ACTION = 'chilean_dp_dashboard';
    const NONCE_FIELD  = 'chilean_dp_dash_nonce';

    private static $instance = null;
    private $flash_notice = '';

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action( 'admin_init', [ $this, 'handle_actions' ] );
        add_action( 'admin_post_chilean_dp_report_html', [ $this, 'download_html' ] );
        add_action( 'admin_post_chilean_dp_report_csv', [ $this, 'download_csv' ] );
    }

    public function download_html() {
        $nonce = isset( $_GET['_wpnonce'] ) ? sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ) : '';
        if ( ! current_user_can( 'manage_woocommerce' ) || ! wp_verify_nonce( $nonce, 'chilean_dp_report' ) ) {
            wp_die( esc_html__( 'Enlace no válido o caducado.', 'datarights-for-woocommerce' ) );
        }
        header( 'Content-Type: text/html; charset=utf-8' );
        header( 'Content-Disposition: attachment; filename=wooprivacy-reporte-' . gmdate( 'Ymd-His' ) . '.html' );
        // Salida intencionalmente cruda: documento HTML completo generado por el propio plugin.
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- reporte completo, no fragmento.
        echo Chilean_DP_Report::instance()->render_html();
        exit;
    }

    public function download_csv() {
        $nonce = isset( $_GET['_wpnonce'] ) ? sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ) : '';
        if ( ! current_user_can( 'manage_woocommerce' ) || ! wp_verify_nonce( $nonce, 'chilean_dp_report' ) ) {
            wp_die( esc_html__( 'Enlace no válido o caducado.', 'datarights-for-woocommerce' ) );
        }
        header( 'Content-Type: text/csv; charset=utf-8' );
        header( 'Content-Disposition: attachment; filename=wooprivacy-controles-' . gmdate( 'Ymd-His' ) . '.csv' );
        // Salida intencionalmente cruda: datos para procesamiento machine-readable.
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escapar rompería el CSV.
        echo Chilean_DP_Report::instance()->to_csv();
        exit;
    }

    public function handle_actions() {
        if ( ! isset( $_POST[ self::NONCE_FIELD ] ) ) {
            return;
        }
        if ( ! current_user_can( 'manage_woocommerce' ) ) {
            return;
        }
        check_admin_referer( self::NONCE_ACTION, self::NONCE_FIELD );

        $assess = Chilean_DP_Assessment_Engine::instance();

        if ( isset( $_POST['chilean_dp_record'] ) && is_array( $_POST['chilean_dp_record'] ) ) {
            $rec = array_map( 'sanitize_text_field', wp_unslash( $_POST['chilean_dp_record'] ) );
            $cid = $rec['control_id'] ?? '';
            if ( '' !== $cid ) {
                $result = $assess->record(
                    $cid,
                    $rec['status'] ?? '',
                    'user-declared',
                    $rec['observation'] ?? ''
                );
                if ( ! empty( $result['ok'] ) ) {
                    $this->flash_notice = __( 'Evaluación guardada correctamente.', 'datarights-for-woocommerce' );
                }
            }
        }

        if ( isset( $_POST['chilean_dp_retract'] ) ) {
            if ( $assess->retract( sanitize_text_field( wp_unslash( $_POST['chilean_dp_retract'] ) ) ) ) {
                $this->flash_notice = __( 'Evaluación retirada.', 'datarights-for-woocommerce' );
            }
        }

        if ( isset( $_POST['chilean_dp_adopt'] ) ) {
            $dim     = sanitize_text_field( wp_unslash( $_POST['chilean_dp_adopt'] ) );
            $value   = isset( $_POST['chilean_dp_adopt_value'] ) && '1' === sanitize_text_field( wp_unslash( $_POST['chilean_dp_adopt_value'] ) );
            if ( Chilean_DP_Environment_Detector::instance()->adopt_dimension( $dim, $value ) ) {
                $this->flash_notice = __( 'Respuesta actualizada con la detección del entorno.', 'datarights-for-woocommerce' );
            }
        }
    }

    private function eval_label( $status ) {
        return [
            'IMPLEMENTED' => __( 'Cubierto', 'datarights-for-woocommerce' ),
            'PARTIAL'     => __( 'Cubierto a medias', 'datarights-for-woocommerce' ),
            'PENDING'     => __( 'Por hacer', 'datarights-for-woocommerce' ),
            'UNKNOWN'     => __( 'Sin confirmar', 'datarights-for-woocommerce' ),
        ][ $status ] ?? $status;
    }

    public function render_page() {
        if ( ! current_user_can( 'manage_woocommerce' ) ) {
            wp_die( esc_html__( 'No tienes permisos para acceder a esta página.', 'datarights-for-woocommerce' ) );
        }

        $g       = Chilean_DP_Guidance_Engine::instance()->generate();
        $att     = $g['summary']['attention'];
        ?>
        <div class="wrap chilean-dp-dash">
            <h1>DataRights <span style="font-weight:400">for WooCommerce</span></h1>
            <p class="chilean-dp-subtitle">
                <?php esc_html_e( 'Assessment & Guidance — Ley 21.719 (vigente desde 01-diciembre-2026)', 'datarights-for-woocommerce' ); ?>
                · <a href="<?php echo esc_url( admin_url( 'admin.php?page=chilean-dp-profile' ) ); ?>"><?php esc_html_e( 'Editar perfil de tienda', 'datarights-for-woocommerce' ); ?></a>
            </p>

            <?php
            settings_errors( 'chilean_dp_profile' );
            if ( '' !== $this->flash_notice ) {
                printf( '<div class="notice notice-success is-dismissible"><p>%s</p></div>', esc_html( $this->flash_notice ) );
            }
            ?>

            <div class="chilean-dp-attention chilean-dp-attention-<?php echo esc_attr( $att['level'] ); ?>">
                <?php echo esc_html( $att['message'] ); ?>
            </div>

            <div class="chilean-dp-phrase">
                <?php echo esc_html( $g['summary']['phrase'] ); ?>
                <?php
                $rep_url = wp_nonce_url( admin_url( 'admin-post.php?action=chilean_dp_report_html' ), 'chilean_dp_report' );
                $csv_url = wp_nonce_url( admin_url( 'admin-post.php?action=chilean_dp_report_csv' ), 'chilean_dp_report' );
                ?>
                <a class="button button-small" href="<?php echo esc_url( $rep_url ); ?>"><?php esc_html_e( 'Descargar reporte', 'datarights-for-woocommerce' ); ?></a>
                <a class="button button-small" href="<?php echo esc_url( $csv_url ); ?>"><?php esc_html_e( 'Exportar CSV', 'datarights-for-woocommerce' ); ?></a>
            </div>

            <?php $this->render_evidence_panel(); ?>

            <div class="chilean-dp-counters">
                <?php foreach ( $this->counter_boxes( $g['summary']['counts'] ) as $box ) : ?>
                    <div class="chilean-dp-counter chilean-dp-counter-<?php echo esc_attr( $box['class'] ); ?>">
                        <span class="num"><?php echo esc_html( $box['n'] ); ?></span>
                        <span class="lbl"><?php echo esc_html( $box['label'] ); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php
            // Contenido upgrade-path congelado en FREE-011 §5 (NT2: solo tras entregar el contenido completo; NT5: capacidad, nunca miedo)
            $pro_notes = [
                'hacer_ahora' => __( 'La versión PRO puede implementar estos puntos y registrar la evidencia por ti.', 'datarights-for-woocommerce' ),
                'confirmar'   => __( 'Cuando la autoridad publique definiciones, la versión PRO incorporará los criterios actualizados.', 'datarights-for-woocommerce' ),
                'hecho'       => __( 'La versión PRO puede automatizar estos controles y auditarlos de forma continua.', 'datarights-for-woocommerce' ),
            ];
            $guide_url = admin_url( 'admin.php?page=chilean-dp-guide' );
            $kd_link   = [
                'confirmar' => sprintf(
                    '<a href="%s#confirmaciones">%s</a>',
                    esc_url( $guide_url ),
                    esc_html__( '¿Por qué aparece este aviso? Ver explicación en la Guía.', 'datarights-for-woocommerce' )
                ),
            ];
            $sections = [
                'hacer_ahora' => __( 'Acciones prioritarias', 'datarights-for-woocommerce' ),
                'confirmar'   => __( 'Necesitan confirmación', 'datarights-for-woocommerce' ),
                'evaluar'     => __( 'Aún sin evaluar — empieza por los importantes', 'datarights-for-woocommerce' ),
                'hecho'       => __( 'Cubierto', 'datarights-for-woocommerce' ),
            ];
            foreach ( $sections as $key => $label ) :
                if ( empty( $g['roadmap'][ $key ] ) ) { continue; } ?>
                <h2 class="chilean-dp-section-title"><?php echo esc_html( $label ); ?> <span class="count">(<?php echo count( $g['roadmap'][ $key ] ); ?>)</span></h2>
                <?php if ( isset( $pro_notes[ $key ] ) ) : ?>
                    <p class="chilean-dp-pro-note"><?php echo esc_html( $pro_notes[ $key ] ); ?><?php if ( isset( $kd_link[ $key ] ) ) : ?> <span class="chilean-dp-kd-link">— <?php echo wp_kses_post( $kd_link[ $key ] ); ?></span><?php endif; ?></p>
                <?php endif; ?>
                <?php foreach ( $g['roadmap'][ $key ] as $item ) : ?>
                    <?php $this->render_item( $item, $key ); ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </div>
        <?php
    }

    private function counter_boxes( array $s ) {
        return [
            [ 'n' => $s['prioridad_alta'],          'label' => __( 'Atención prioritaria', 'datarights-for-woocommerce' ), 'class' => 'alta' ],
            [ 'n' => $s['prioridad_media'],         'label' => __( 'Pendientes de mejora', 'datarights-for-woocommerce' ),  'class' => 'media' ],
            [ 'n' => $s['requiere_revision'],       'label' => __( 'Necesitan confirmación', 'datarights-for-woocommerce' ), 'class' => 'rev' ],
            [ 'n' => $s['incertidumbres_evaluacion'],'label' => __( 'Sin confirmar', 'datarights-for-woocommerce' ),         'class' => 'unk' ],
            [ 'n' => $s['sin_evaluar'],             'label' => __( 'Aún sin evaluar', 'datarights-for-woocommerce' ),        'class' => 'unev' ],
            [ 'n' => $s['implementados'],           'label' => __( 'Cubiertos', 'datarights-for-woocommerce' ),              'class' => 'ok' ],
            [ 'n' => $s['no_aplicables'],           'label' => __( 'No aplican a tu tienda', 'datarights-for-woocommerce' ), 'class' => 'na' ],
        ];
    }

    private function render_item( array $i, string $section ) {
        $gc = Chilean_DP_Guide_Content::instance()->get( $i['id'] );
        ?>
        <div class="chilean-dp-item chilean-dp-item-<?php echo esc_attr( $section ); ?>">
            <div class="chilean-dp-item-head">
                <strong><?php echo esc_html( $gc['title'] ?? $i['title'] ); ?></strong>
                <?php if ( 'alta' === $i['priority'] ) : ?><span class="badge badge-alta"><?php esc_html_e( 'Prioridad alta', 'datarights-for-woocommerce' ); ?></span><?php endif; ?>
                <?php if ( 'media' === $i['priority'] ) : ?><span class="badge badge-media"><?php esc_html_e( 'Prioridad media', 'datarights-for-woocommerce' ); ?></span><?php endif; ?>
                <span class="badge badge-status"><?php echo esc_html( $i['status_label'] ); ?></span>
                <?php if ( 'confirmar' === $section && ! empty( $i['status_internal'] ) && null !== Chilean_DP_Assessment_Engine::instance()->get_evaluation( $i['id'] ) ) : ?>
                    <?php
                    /* translators: %s: estado de la evaluación declarada por el administrador. */
                    ?>
                    <?php
                    /* translators: %s: estado de la evaluación declarada por el administrador. */
                    $user_eval = sprintf( __( 'Tu evaluación: %s', 'datarights-for-woocommerce' ), $this->eval_label( $i['status_internal'] ) );
                    ?>
                    <span class="badge badge-user-eval"><?php echo esc_html( $user_eval ); ?></span>
                <?php endif; ?>
            </div>

            <?php if ( $gc ) : ?>
                <div class="chilean-dp-guide">
                    <p class="g-q"><?php esc_html_e( '¿Qué significa?', 'datarights-for-woocommerce' ); ?></p>
                    <p><?php echo esc_html( $gc['what_it_means'] ); ?></p>
                    <p class="g-q"><?php esc_html_e( 'Por qué importa', 'datarights-for-woocommerce' ); ?></p>
                    <p><?php echo esc_html( $gc['why_it_matters'] ); ?></p>
                    <p class="g-q"><?php esc_html_e( '¿Qué debes revisar?', 'datarights-for-woocommerce' ); ?></p>
                    <p><?php echo esc_html( $gc['what_to_check'] ); ?></p>
                    <p class="g-q"><?php esc_html_e( '¿Dónde lo revisas?', 'datarights-for-woocommerce' ); ?></p>
                    <p><?php echo esc_html( $gc['where_to_check'] ); ?></p>
                    <p class="g-q"><?php esc_html_e( '¿DataRights puede comprobarlo?', 'datarights-for-woocommerce' ); ?></p>
                    <p><span class="badge badge-cap cap-<?php echo esc_attr( $gc['detection_capability'] ); ?>"><?php echo esc_html( Chilean_DP_Guide_Content::instance()->capability_label( $gc['detection_capability'] ) ); ?></span></p>
                    <p class="g-note"><?php echo esc_html( $gc['detection_note'] ); ?></p>
                    <details class="chilean-dp-details">
                        <summary><?php esc_html_e( '¿Cuándo marcarlo como Cubierto? · ¿Qué dice la ley?', 'datarights-for-woocommerce' ); ?></summary>
                        <p class="g-q"><?php esc_html_e( 'Puedes marcarlo Cubierto cuando…', 'datarights-for-woocommerce' ); ?></p>
                        <p><?php echo esc_html( $gc['how_to_know_covered'] ); ?></p>
                        <p class="g-q"><?php esc_html_e( 'Qué dice la ley', 'datarights-for-woocommerce' ); ?> <span class="refs">(<?php echo esc_html( implode( ' · ', (array) $i['legal_refs'] ) ); ?>)</span></p>
                        <p><?php echo esc_html( $gc['legal_explanation'] ); ?></p>
                    </details>
                </div>
            <?php else : ?>
                <p class="why"><em><?php echo esc_html( $i['why'] ); ?></em></p>
                <p class="todo"><?php echo esc_html( $i['what_to_do'] ); ?></p>
                <?php if ( ! empty( $i['review_detail'] ) ) : ?>
                    <ul class="review-notes">
                        <?php foreach ( (array) $i['review_detail'] as $note ) : ?><li><?php echo esc_html( $note ); ?></li><?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <?php if ( ! empty( $i['legal_refs'] ) ) : ?>
                    <p class="refs"><?php echo esc_html( implode( ' · ', (array) $i['legal_refs'] ) ); ?></p>
                <?php endif; ?>
            <?php endif; ?>

            <?php foreach ( (array) $i['reasons'] as $r ) :
                if ( ( $r['code'] ?? '' ) === 'PROFILE_UNKNOWN' ) : ?>
                    <div class="chilean-dp-profile-hint">
                        <strong><?php esc_html_e( '¿Cambiaste algo en tu tienda?', 'datarights-for-woocommerce' ); ?></strong>
                        <a href="<?php echo esc_url( admin_url( 'admin.php?page=chilean-dp-profile' ) ); ?>"><?php esc_html_e( 'Actualiza tus respuestas en tu perfil', 'datarights-for-woocommerce' ); ?></a> — <?php esc_html_e( 'WooPrivacy FREE revisará automáticamente qué aspectos de privacidad aplican a tu tienda.', 'datarights-for-woocommerce' ); ?>
                    </div>
                <?php endif;
            endforeach;

            if ( ! empty( $i['observation'] ) ) : ?>
                <p class="obs"><?php esc_html_e( 'Tu nota:', 'datarights-for-woocommerce' ); ?> <?php echo esc_html( $i['observation'] ); ?></p>
            <?php endif; ?>

            <form method="post" class="chilean-dp-eval-form">
                <?php wp_nonce_field( self::NONCE_ACTION, self::NONCE_FIELD ); ?>
                <input type="hidden" name="chilean_dp_record[control_id]" value="<?php echo esc_attr( $i['id'] ); ?>" />
                <select name="chilean_dp_record[status]">
                    <option value="IMPLEMENTED" <?php selected( 'implemented', $section ); ?>><?php esc_html_e( 'Cubierto', 'datarights-for-woocommerce' ); ?></option>
                    <option value="PARTIAL"><?php esc_html_e( 'Cubierto a medias', 'datarights-for-woocommerce' ); ?></option>
                    <option value="PENDING" <?php selected( 'pending', $section ); ?>><?php esc_html_e( 'Por hacer', 'datarights-for-woocommerce' ); ?></option>
                    <option value="UNKNOWN"><?php esc_html_e( 'No lo sé / sin confirmar', 'datarights-for-woocommerce' ); ?></option>
                </select>
                <input type="text" name="chilean_dp_record[observation]" placeholder="<?php esc_attr_e( 'Nota opcional', 'datarights-for-woocommerce' ); ?>" value="" />
                <button type="submit" class="button button-small"><?php esc_html_e( 'Guardar evaluación', 'datarights-for-woocommerce' ); ?></button>
            </form>

            <?php if ( null !== Chilean_DP_Assessment_Engine::instance()->get_evaluation( $i['id'] ) ) : ?>
                <form method="post" class="chilean-dp-retract-form">
                    <?php wp_nonce_field( self::NONCE_ACTION, self::NONCE_FIELD ); ?>
                    <input type="hidden" name="chilean_dp_retract" value="<?php echo esc_attr( $i['id'] ); ?>" />
                    <button type="submit" class="button-link delete"><?php esc_html_e( 'Retirar mi evaluación', 'datarights-for-woocommerce' ); ?></button>
                </form>
            <?php endif; ?>
        </div>
        <?php
    }

    private function render_evidence_panel() {
        $det = Chilean_DP_Environment_Detector::instance();
        $ev  = $det->get_evidence_view();
        if ( empty( $det->get_detections() ) ) { return; }

        $labels = [
            'customer_accounts' => __( 'Cuentas de cliente', 'datarights-for-woocommerce' ),
            'newsletter'        => __( 'Newsletter / email marketing', 'datarights-for-woocommerce' ),
            'analytics'         => __( 'Analítica web', 'datarights-for-woocommerce' ),
            'cookies'           => __( 'Cookies y consentimiento', 'datarights-for-woocommerce' ),
            'third_parties'     => __( 'Servicios de terceros', 'datarights-for-woocommerce' ),
        ];
        $chips = [
            'match'       => [ __( 'Coincide con tu respuesta', 'datarights-for-woocommerce' ), 'ok' ],
            'mismatch'    => [ __( 'No coincide con tu respuesta', 'datarights-for-woocommerce' ), 'warn' ],
            'unconfirmed' => [ __( 'Detectado — aún sin declarar', 'datarights-for-woocommerce' ), 'info' ],
            'undetected'  => [ __( 'Sin evidencia técnica', 'datarights-for-woocommerce' ), 'muted' ],
        ];
        $yesno = fn( $v ) => null === $v ? '—' : ( $v ? __( 'Sí', 'datarights-for-woocommerce' ) : __( 'No', 'datarights-for-woocommerce' ) );
        ?>
        <div class="chilean-dp-evidence">
            <h2 class="chilean-dp-section-title"><?php esc_html_e( 'Evidencia del entorno', 'datarights-for-woocommerce' ); ?></h2>
            <p class="chilean-dp-evidence-note"><?php esc_html_e( 'Observaciones técnicas de tu instalación. Son evidencia para ayudarte a responder, no conclusiones sobre cumplimiento.', 'datarights-for-woocommerce' ); ?></p>
            <table class="widefat striped chilean-dp-evidence-table">
                <thead><tr>
                    <th><?php esc_html_e( 'Aspecto', 'datarights-for-woocommerce' ); ?></th>
                    <th><?php esc_html_e( 'Detección', 'datarights-for-woocommerce' ); ?></th>
                    <th><?php esc_html_e( 'Tu respuesta', 'datarights-for-woocommerce' ); ?></th>
                    <th><?php esc_html_e( 'Estado', 'datarights-for-woocommerce' ); ?></th>
                    <th></th>
                </tr></thead>
                <tbody>
                <?php foreach ( $ev as $dim => $e ) :
                    [ $chip, $cls ] = $chips[ $e['relation'] ]; ?>
                    <tr>
                        <td><?php echo esc_html( $labels[ $dim ] ); ?></td>
                        <td><?php echo esc_html( $yesno( $e['observed'] ) ); ?><?php if ( ! empty( $e['details'] ) ) : ?> <span class="chilean-dp-evidence-detail">(<?php echo esc_html( implode( ', ', (array) $e['details'] ) ); ?>)</span><?php endif; ?></td>
                        <td><?php echo esc_html( $yesno( $e['declared'] ) ); ?></td>
                        <td><span class="badge badge-ev-<?php echo esc_attr( $cls ); ?>"><?php echo esc_html( $chip ); ?></span></td>
                        <td>
                            <?php if ( in_array( $e['relation'], [ 'mismatch', 'unconfirmed' ], true ) && null !== $e['observed'] ) : ?>
                                <form method="post">
                                    <?php wp_nonce_field( self::NONCE_ACTION, self::NONCE_FIELD ); ?>
                                    <input type="hidden" name="chilean_dp_adopt" value="<?php echo esc_attr( $dim ); ?>" />
                                    <input type="hidden" name="chilean_dp_adopt_value" value="<?php echo esc_attr( $e['observed'] ? '1' : '0' ); ?>" />
                                    <button type="submit" class="button button-small"><?php esc_html_e( 'Usar detección', 'datarights-for-woocommerce' ); ?></button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
    }
}
