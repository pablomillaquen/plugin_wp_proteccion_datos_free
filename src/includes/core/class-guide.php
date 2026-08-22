<?php
/**
 * Guía & Acerca de — FREE-012 (reemplaza scaffold compliance-info; FKN-003/F11-01)
 * Contenido educativo mínimo + disclaimer. Sin tablas comparativas ni referencias a versiones pagadas.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Chilean_DP_Guide {

    private static $instance = null;

    public static function instance() {
        if ( null === self::$instance ) { self::$instance = new self(); }
        return self::$instance;
    }

    private function __construct() {}

    public function render_page() {
        if ( ! current_user_can( 'manage_woocommerce' ) ) {
            wp_die( esc_html__( 'No tienes permisos para acceder a esta página.', 'chilean-data-protection' ) );
        }
        ?>
        <div class="wrap">
            <h1><?php esc_html_e( 'WooPrivacy (FREE) — Guía y acerca de', 'chilean-data-protection' ); ?></h1>

            <div class="chilean-dp-card warning">
                <h2><?php esc_html_e( 'Qué es y qué no es WooPrivacy (FREE)', 'chilean-data-protection' ); ?></h2>
                <p><?php echo wp_kses_post( __( 'Es una herramienta de <strong>evaluación y orientación</strong>: te ayuda a entender qué aspectos de privacidad debes revisar en tu tienda WooCommerce según la Ley 21.719 y qué abordar primero.', 'chilean-data-protection' ) ); ?></p>
                <p><strong><?php esc_html_e( 'No es un certificado de cumplimiento legal ni una asesoría jurídica', 'chilean-data-protection' ); ?></strong> — <?php esc_html_e( 'los resultados expresan estado de preparación, no porcentajes de cumplimiento. Para decisiones legales, consulta a un profesional.', 'chilean-data-protection' ); ?></p>
            </div>

            <div class="chilean-dp-card">
                <h2><?php esc_html_e( 'La Ley 21.719 en breve', 'chilean-data-protection' ); ?></h2>
                <p><?php esc_html_e( 'Vigente desde el 01-diciembre-2026, regula el tratamiento de datos personales en Chile. Los titulares tienen seis derechos:', 'chilean-data-protection' ); ?></p>
                <ul>
                    <li><strong><?php esc_html_e( 'Acceso', 'chilean-data-protection' ); ?></strong> — <?php esc_html_e( 'conocer qué datos se tratan y con qué fin (Art. 5)', 'chilean-data-protection' ); ?></li>
                    <li><strong><?php esc_html_e( 'Rectificación', 'chilean-data-protection' ); ?></strong> — <?php esc_html_e( 'corregir datos inexactos o incompletos (Art. 6)', 'chilean-data-protection' ); ?></li>
                    <li><strong><?php esc_html_e( 'Supresión', 'chilean-data-protection' ); ?></strong> — <?php esc_html_e( 'eliminar datos cuando corresponda (Art. 7)', 'chilean-data-protection' ); ?></li>
                    <li><strong><?php esc_html_e( 'Oposición', 'chilean-data-protection' ); ?></strong> — <?php esc_html_e( 'detener tratamientos específicos (Art. 8)', 'chilean-data-protection' ); ?></li>
                    <li><strong><?php esc_html_e( 'Portabilidad', 'chilean-data-protection' ); ?></strong> — <?php esc_html_e( 'recibir los datos en formato estructurado (Art. 9)', 'chilean-data-protection' ); ?></li>
                    <li><strong><?php esc_html_e( 'Bloqueo', 'chilean-data-protection' ); ?></strong> — <?php esc_html_e( 'suspender el tratamiento durante una solicitud (Arts. 8 ter, 11)', 'chilean-data-protection' ); ?></li>
                </ul>
                <p><?php esc_html_e( 'Además: medios sencillos para ejercer derechos (Art. 10), respuestas en 30 días con acuse de recibo (Art. 11), consentimiento revocable y demostrable (Art. 12) e información de transparencia permanentemente accesible (Art. 14 ter).', 'chilean-data-protection' ); ?></p>
            </div>

            <div class="chilean-dp-card">
                <h2><?php esc_html_e( 'Cómo usar WooPrivacy (FREE)', 'chilean-data-protection' ); ?></h2>
                <ol>
                    <li><?php esc_html_e( 'Revisa tu Perfil de tienda (respuestas que definen qué aplica a ti).', 'chilean-data-protection' ); ?></li>
                    <li><?php esc_html_e( 'Abre el panel principal: verás un diagnóstico inicial aunque no respondas nada.', 'chilean-data-protection' ); ?></li>
                    <li><?php esc_html_e( 'Evalúa los puntos marcados como importantes primero.', 'chilean-data-protection' ); ?></li>
                    <li><?php esc_html_e( 'Descarga el reporte para conservarlo o compartirlo.', 'chilean-data-protection' ); ?></li>
                </ol>
                <p class="description"><?php esc_html_e( 'Las observaciones técnicas ("Evidencia del entorno") son insumos para ayudarte a responder: no concluyen cumplimiento.', 'chilean-data-protection' ); ?></p>
            </div>

            <div class="chilean-dp-card">
                <h2><?php esc_html_e( 'Recursos oficiales', 'chilean-data-protection' ); ?></h2>
                <ul>
                    <li><a href="https://www.bcn.cl/leychile/navegar?idNorma=1185493" target="_blank" rel="noopener"><?php esc_html_e( 'Ley 21.719 — Biblioteca del Congreso Nacional', 'chilean-data-protection' ); ?></a></li>
                    <li><a href="https://www.datosproteccion.cl" target="_blank" rel="noopener"><?php esc_html_e( 'Agencia de Protección de Datos Personales', 'chilean-data-protection' ); ?></a></li>
                </ul>
                <p class="description"><?php printf( esc_html__( 'Versión %s · Catálogo normativo %s', 'chilean-data-protection' ), esc_html( CHILEAN_DP_VERSION ), esc_html( Chilean_DP_Catalog_Loader::instance()->get_meta()['catalog_version'] ?? '' ) ); ?></p>
            </div>
        </div>
        <?php
    }
}
