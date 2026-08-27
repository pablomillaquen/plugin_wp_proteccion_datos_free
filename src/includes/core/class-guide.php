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
            wp_die( esc_html__( 'No tienes permisos para acceder a esta página.', 'datarights-for-woocommerce' ) );
        }
        ?>
        <div class="wrap">
            <h1><?php esc_html_e( 'DataRights for WooCommerce — Guía y acerca de', 'datarights-for-woocommerce' ); ?></h1>

            <div class="chilean-dp-card warning">
                <h2><?php esc_html_e( 'Qué es y qué no es DataRights', 'datarights-for-woocommerce' ); ?></h2>
                <p><?php echo wp_kses_post( __( 'Es una herramienta de <strong>evaluación y orientación</strong>: te ayuda a entender qué aspectos de privacidad debes revisar en tu tienda WooCommerce según la Ley 21.719 y qué abordar primero.', 'datarights-for-woocommerce' ) ); ?></p>
                <p><strong><?php esc_html_e( 'No es un certificado de cumplimiento legal ni una asesoría jurídica', 'datarights-for-woocommerce' ); ?></strong> — <?php esc_html_e( 'los resultados expresan estado de preparación, no porcentajes de cumplimiento. Para decisiones legales, consulta a un profesional.', 'datarights-for-woocommerce' ); ?></p>
            </div>

            <div class="chilean-dp-card" id="confirmaciones">
                <h2><?php esc_html_e( '¿Por qué algunos puntos aparecen como “Necesitan confirmación”?','datarights-for-woocommerce' ); ?></h2>
                <p><?php echo wp_kses_post( __( 'Algunos puntos del diagnóstico dependen de <strong>definiciones que la propia Ley 21.719 delega en la Agencia de Protección de Datos Personales</strong>, y esa institución aún no ha publicado sus instrucciones (la ley entra en vigencia el 01-diciembre-2026 y la Agencia se encuentra en proceso de implementación).', 'datarights-for-woocommerce' ) ); ?></p>
                <p><strong><?php esc_html_e( 'Ejemplo concreto:', 'datarights-for-woocommerce' ); ?></strong> <?php esc_html_e( 'para ejercer derechos, la tienda debe verificar razonablemente la identidad de quien solicita (Art. 11). Pero ¿cuánta verificación es suficiente? Demasiado poca abre la puerta a suplantación; demasiada convierte el ejercicio del derecho en un trámite imposible. La respuesta oficial corresponde a la Agencia, y todavía no existe.', 'datarights-for-woocommerce' ); ?></p>
                <p><?php esc_html_e( 'Ante esta situación, WooPrivacy FREE prefiere ser honesto: no te dará una marca de “resuelto” basada en un estándar que nadie ha publicado todavía. Es preferible una incertidumbre visible que una seguridad inventada.', 'datarights-for-woocommerce' ); ?></p>
                <p><strong><?php esc_html_e( 'Qué hacer mientras tanto:', 'datarights-for-woocommerce' ); ?></strong></p>
                <ol>
                    <li><?php esc_html_e( 'Adopta una práctica proporcional razonable (por ejemplo, confirmación por el correo registrado).', 'datarights-for-woocommerce' ); ?></li>
                    <li><?php esc_html_e( 'Documenta qué mecanismo usas: tu evaluación queda registrada como declaración propia.', 'datarights-for-woocommerce' ); ?></li>
                    <li><?php esc_html_e( 'Revisa periódicamente las publicaciones de la Agencia.', 'datarights-for-woocommerce' ); ?></li>
                </ol>
                <p class="description"><?php esc_html_e( 'Cuando existan definiciones oficiales, estos puntos se actualizarán automáticamente en futuras versiones del catálogo normativo.', 'datarights-for-woocommerce' ); ?></p>
            </div>

            <div class="chilean-dp-card">
                <h2><?php esc_html_e( 'La Ley 21.719 en breve', 'datarights-for-woocommerce' ); ?></h2>
                <p><?php esc_html_e( 'Vigente desde el 01-diciembre-2026, regula el tratamiento de datos personales en Chile. Los titulares tienen seis derechos:', 'datarights-for-woocommerce' ); ?></p>
                <ul>
                    <li><strong><?php esc_html_e( 'Acceso', 'datarights-for-woocommerce' ); ?></strong> — <?php esc_html_e( 'conocer qué datos se tratan y con qué fin (Art. 5)', 'datarights-for-woocommerce' ); ?></li>
                    <li><strong><?php esc_html_e( 'Rectificación', 'datarights-for-woocommerce' ); ?></strong> — <?php esc_html_e( 'corregir datos inexactos o incompletos (Art. 6)', 'datarights-for-woocommerce' ); ?></li>
                    <li><strong><?php esc_html_e( 'Supresión', 'datarights-for-woocommerce' ); ?></strong> — <?php esc_html_e( 'eliminar datos cuando corresponda (Art. 7)', 'datarights-for-woocommerce' ); ?></li>
                    <li><strong><?php esc_html_e( 'Oposición', 'datarights-for-woocommerce' ); ?></strong> — <?php esc_html_e( 'detener tratamientos específicos (Art. 8)', 'datarights-for-woocommerce' ); ?></li>
                    <li><strong><?php esc_html_e( 'Portabilidad', 'datarights-for-woocommerce' ); ?></strong> — <?php esc_html_e( 'recibir los datos en formato estructurado (Art. 9)', 'datarights-for-woocommerce' ); ?></li>
                    <li><strong><?php esc_html_e( 'Bloqueo', 'datarights-for-woocommerce' ); ?></strong> — <?php esc_html_e( 'suspender el tratamiento durante una solicitud (Arts. 8 ter, 11)', 'datarights-for-woocommerce' ); ?></li>
                </ul>
                <p><?php esc_html_e( 'Además: medios sencillos para ejercer derechos (Art. 10), respuestas en 30 días con acuse de recibo (Art. 11), consentimiento revocable y demostrable (Art. 12) e información de transparencia permanentemente accesible (Art. 14 ter).', 'datarights-for-woocommerce' ); ?></p>
            </div>

            <div class="chilean-dp-card">
                <h2><?php esc_html_e( 'Cómo usar DataRights', 'datarights-for-woocommerce' ); ?></h2>
                <ol>
                    <li><?php esc_html_e( 'Revisa tu Perfil de tienda (respuestas que definen qué aplica a ti).', 'datarights-for-woocommerce' ); ?></li>
                    <li><?php esc_html_e( 'Abre el panel principal: verás un diagnóstico inicial aunque no respondas nada.', 'datarights-for-woocommerce' ); ?></li>
                    <li><?php esc_html_e( 'Evalúa los puntos marcados como importantes primero.', 'datarights-for-woocommerce' ); ?></li>
                    <li><?php esc_html_e( 'Descarga el reporte para conservarlo o compartirlo.', 'datarights-for-woocommerce' ); ?></li>
                </ol>
                <p class="description"><?php esc_html_e( 'Las observaciones técnicas ("Evidencia del entorno") son insumos para ayudarte a responder: no concluyen cumplimiento.', 'datarights-for-woocommerce' ); ?></p>
            </div>

            <div class="chilean-dp-card">
                <h2><?php esc_html_e( 'Recursos oficiales', 'datarights-for-woocommerce' ); ?></h2>
                <ul>
                    <li><a href="https://www.bcn.cl/leychile/navegar?idNorma=1209272" target="_blank" rel="noopener"><?php esc_html_e( 'Ley 21.719 — Biblioteca del Congreso Nacional', 'datarights-for-woocommerce' ); ?></a></li>
                    <li><a href="https://www.agenciadatos.cl" target="_blank" rel="noopener"><?php esc_html_e( 'Agencia de Protección de Datos Personales', 'datarights-for-woocommerce' ); ?></a></li>
                </ul>
                <?php
                /* translators: 1: versión del plugin, 2: versión del catálogo normativo. */
                $ver_line = sprintf( esc_html__( 'Versión %1$s · Catálogo normativo %2$s', 'datarights-for-woocommerce' ), esc_html( CHILEAN_DP_VERSION ), esc_html( Chilean_DP_Catalog_Loader::instance()->get_meta()['catalog_version'] ?? '' ) );
                ?>
                <p class="description"><?php echo esc_html( $ver_line ); ?></p>
            </div>
        </div>
        <?php
    }
}
