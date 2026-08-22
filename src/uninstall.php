<?php
/**
 * Desinstalación WooPrivacy (FREE): elimina datos propios. No toca datos de WooCommerce.
 * FREE-012 — limpieza completa en desinstalar.
 */
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) { exit; }

delete_option( 'chilean_dp_settings' );      // scaffold histórico (si existiera)
delete_option( 'chilean_dp_profile' );
delete_option( 'chilean_dp_assessments' );
delete_option( 'chilean_dp_detections' );
wp_cache_flush();
