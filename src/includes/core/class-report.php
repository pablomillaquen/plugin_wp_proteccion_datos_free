<?php
/**
 * Report & Export — SPEC-FREE-010
 * Representación fiel del assessment existente (perfil, evidencia, diagnóstico, guidance).
 * REGLAS: NO es un certificado de cumplimiento; NO introduce interpretación nueva; conserva procedencia e incertidumbre.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
class Chilean_DP_Report {

    private static $instance = null;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {}

    public function generate(): array {
        $guidance = Chilean_DP_Guidance_Engine::instance()->generate();
        $profile  = Chilean_DP_Compliance_Profile::instance()->get_profile();
        $evidence = Chilean_DP_Environment_Detector::instance()->get_evidence_view();
        $catalog  = Chilean_DP_Catalog_Loader::instance()->load();

        return [
            'meta' => [
                'site_name'       => get_bloginfo( 'name' ),
                'site_url'        => home_url(),
                'generated_at'    => time(),
                'wp_version'      => get_bloginfo( 'version' ),
                'wc_version'      => defined( 'WC_VERSION' ) ? WC_VERSION : '—',
                'plugin_version'  => CHILEAN_DP_VERSION,
                'catalog_version' => $catalog['meta']['catalog_version'] ?? '',
                'profile_version' => $profile['meta']['profile_version'] ?? '',
                'law'             => $catalog['meta']['law'] ?? 'Ley 21.719',
            ],
            'profile'  => $profile,
            'evidence' => $evidence,
            'summary'  => $guidance['summary'],
            'roadmap'  => $guidance['roadmap'],
        ];
    }

    public function render_html(): string {
        $d = $this->generate();
        ob_start();
        $this->html_document( $d );
        return (string) ob_get_clean();
    }

    public function to_csv(): string {
        $d  = $this->generate();
        $gc = Chilean_DP_Guide_Content::instance();

        $rows = [ [ 'control_id', 'nombre', 'seccion_roadmap', 'estado_diagnostico', 'prioridad_brecha',
                    'estado_aplicabilidad', 'estado_evaluacion', 'fuente_evaluacion', 'fecha_evaluacion',
                    'observacion', 'referencias_legales' ] ];

        foreach ( $d['roadmap'] as $section => $items ) {
            foreach ( $items as $i ) {
                $ev  = Chilean_DP_Assessment_Engine::instance()->get_evaluation( $i['id'] );
                $app = Chilean_DP_Applicability_Engine::instance()->evaluate_all()['results'][ $i['id'] ] ?? [];
                $rows[] = [
                    $i['id'],
                    ( $gc->get( $i['id'] )['title'] ?? $i['title'] ),
                    $section,
                    $i['status_internal'] ?? '', $i['priority'] ?? '',
                    $app['status'] ?? '',
                    $ev['status'] ?? '', $ev['source'] ?? '',
                    isset( $ev['assessed_at'] ) ? gmdate( 'c', $ev['assessed_at'] ) : '',
                    $i['observation'] ?? '',
                    implode( ' | ', (array) $i['legal_refs'] ),
                ];
            }
        }

        return implode( "\r\n", array_map( function ( $row ) {
            return implode( ',', array_map( function ( $f ) {
                $f = (string) $f;
                if ( preg_match( '/[",\r\n]/', $f ) ) { $f = '"' . str_replace( '"', '""', $f ) . '"'; }
                return $f;
            }, $row ) );
        }, $rows ) );
    }

    /* ================= HTML ================= */

    private function html_document( array $d ): void {
        $m = $d['meta'];
        ?><!DOCTYPE html>
<html lang="es"><head><meta charset="utf-8">
<title><?php echo esc_html( 'Reporte DataRights for WooCommerce — ' . $m['site_name'] ); ?></title>
<style>
 body{font-family:-apple-system,'Segoe UI',Roboto,sans-serif;color:#1d2327;margin:40px auto;max-width:860px;line-height:1.5;font-size:14px}
 h1{font-size:22px;border-bottom:2px solid #1d2327;padding-bottom:8px}
 h2{font-size:16px;margin-top:28px;border-bottom:1px solid #dcdcde;padding-bottom:4px}
 table{width:100%;border-collapse:collapse;margin:10px 0}
 th,td{border:1px solid #dcdcde;padding:6px 9px;text-align:left;vertical-align:top}
 th{background:#f0f0f1;font-size:12px;text-transform:uppercase;letter-spacing:.3px}
 .meta{color:#50575e;font-size:12px}
 .notice{background:#fcf9e8;border-left:4px solid #dba617;padding:12px 16px;margin:16px 0}
 .phrase{background:#f0f6fc;border-left:4px solid #135e96;padding:10px 14px;font-weight:600;margin:14px 0}
 .item{border:1px solid #dcdcde;border-left-width:4px;border-radius:4px;padding:10px 14px;margin:10px 0;break-inside:avoid}
 .hacer_ahora{border-color:#d63638}.confirmar{border-color:#dba617}.evaluar{border-color:#72aee6}.hecho{border-color:#00a32a}
 .badge{display:inline-block;background:#f0f0f1;border-radius:10px;padding:1px 8px;font-size:11px;margin-right:6px}
 .prov{color:#646970;font-size:11.5px;margin:6px 0 0}
 ul.notes{margin:6px 0;padding-left:20px}
 @media print{body{margin:12mm}h2{break-after:avoid}}
</style></head><body>
<h1>DataRights for WooCommerce — Reporte de Assessment &amp; Guidance</h1>
<p class="meta">
 <?php echo esc_html( $m['site_name'] . ' · ' . $m['site_url'] ); ?><br>
 <?php echo esc_html( 'Generado: ' . wp_date( 'd/m/Y H:i', $m['generated_at'] ) ); ?>
 · WordPress <?php echo esc_html( $m['wp_version'] ); ?> · WooCommerce <?php echo esc_html( $m['wc_version'] ); ?><br>
 <?php echo esc_html( 'DataRights for WooCommerce v' . $m['plugin_version'] . ' · Catálogo ' . $m['catalog_version'] . ' · Perfil v' . $m['profile_version'] ); ?><br>
 <?php echo esc_html( $m['law'] . ' — vigente desde el 01-diciembre-2026' ); ?>
</p>

<div class="notice">
 <strong>Qué es y qué no es este documento.</strong>
 Es el resultado de una evaluación informativa sobre prácticas de privacidad de esta tienda WooCommerce:
 qué evaluó DataRights, qué encontró, qué fue declarado por su administrador, qué fue detectado técnicamente
 y qué se recomienda revisar. <strong>No es un certificado de cumplimiento legal</strong> ni una asesoría jurídica;
 no sustituye la asesoría de un profesional. Los resultados expresan estado de preparación, no porcentajes de cumplimiento.
</div>

<h2>Resumen del estado</h2>
<div class="phrase"><?php echo esc_html( $d['summary']['phrase'] ); ?></div>
<?php if ( ! empty( $d['summary']['attention']['message'] ) ) : ?>
 <p><em><?php echo esc_html( $d['summary']['attention']['message'] ); ?></em></p>
<?php endif; ?>
<table>
 <tr><th>Atención prioritaria</th><td><?php echo intval( $d['summary']['counts']['prioridad_alta'] ); ?></td>
     <th>Pendientes de mejora</th><td><?php echo intval( $d['summary']['counts']['prioridad_media'] ); ?></td></tr>
 <tr><th>Necesitan confirmación</th><td><?php echo intval( $d['summary']['counts']['requiere_revision'] ); ?></td>
     <th>Sin confirmar</th><td><?php echo intval( $d['summary']['counts']['incertidumbres_evaluacion'] ); ?></td></tr>
 <tr><th>Aún sin evaluar</th><td><?php echo intval( $d['summary']['counts']['sin_evaluar'] ); ?></td>
     <th>Cubiertos</th><td><?php echo intval( $d['summary']['counts']['implementados'] ); ?></td></tr>
 <tr><th>No aplican a la tienda</th><td><?php echo intval( $d['summary']['counts']['no_aplicables'] ); ?></td>
     <th>Total evaluado</th><td><?php echo intval( $d['summary']['counts']['total'] ); ?></td></tr>
</table>

<h2>Perfil declarado de la tienda</h2>
<p class="prov">Fuente: declaraciones del administrador<?php echo isset( $d['profile']['meta']['answered_at'] ) ? ' · actualizado ' . esc_html( wp_date( 'd/m/Y H:i', $d['profile']['meta']['answered_at'] ) ) : ''; ?>.</p>
<table>
 <?php foreach ( $this->profile_rows( $d['profile'] ) as [ $label, $value ] ) : ?>
  <tr><th><?php echo esc_html( $label ); ?></th><td><?php echo esc_html( $value ); ?></td></tr>
 <?php endforeach; ?>
</table>

<h2>Evidencia técnica del entorno</h2>
<p class="prov">Observaciones automáticas de la instalación. Son insumos para revisar tus respuestas; no concluyen cumplimiento.</p>
<table>
 <tr><th>Aspecto</th><th>Detección</th><th>Tu respuesta</th><th>Relación</th></tr>
 <?php foreach ( $d['evidence'] as $dim => $e ) : ?>
  <tr><td><?php echo esc_html( $this->dim_label( $dim ) ); ?></td>
      <td><?php echo esc_html( $this->yes_no( $e['observed'], true ) ); ?></td>
      <td><?php echo esc_html( $this->yes_no( $e['declared'] ) ); ?></td>
      <td><?php echo esc_html( $this->relation_label( $e['relation'] ) ); ?></td></tr>
 <?php endforeach; ?>
</table>

<h2>Roadmap — qué hacer y en qué orden</h2>
<?php
$titles = [
 'hacer_ahora' => 'Acciones prioritarias',
 'confirmar'   => 'Necesitan confirmación',
 'evaluar'     => 'Aún sin evaluar (ordenados por importancia)',
 'hecho'       => 'Cubierto',
];
foreach ( $titles as $key => $t ) :
 if ( empty( $d['roadmap'][ $key ] ) ) { continue; } ?>
 <h3 style="font-size:14px;margin-bottom:6px"><?php echo esc_html( $t ); ?></h3>
 <?php foreach ( $d['roadmap'][ $key ] as $i ) : ?>
  <?php $gc = Chilean_DP_Guide_Content::instance()->get( $i['id'] );
        $caps = [ 'auto' => '🔎 DataRights lo puede detectar', 'manual' => '👤 Debes comprobarlo tú', 'mixed' => '🔎👤 Detecta una parte — el resto lo compruebas tú' ]; ?>
  <div class="item <?php echo esc_attr( $key ); ?>">
   <strong><?php echo esc_html( $gc['title'] ?? $i['title'] ); ?></strong>
   <?php if ( 'alta' === $i['priority'] ) : ?><span class="badge">Prioridad alta</span><?php endif; ?>
   <?php if ( 'media' === $i['priority'] ) : ?><span class="badge">Prioridad media</span><?php endif; ?>
   <span class="badge"><?php echo esc_html( $i['status_label'] ); ?></span>
   <?php if ( $gc ) : ?>
    <p style="margin:6px 0 2px"><em><?php echo esc_html( $gc['what_it_means'] ); ?></em></p>
    <p style="margin:6px 0 0"><strong>Por qué importa:</strong></p>
    <p style="margin:2px 0"><?php echo esc_html( $gc['why_it_matters'] ); ?></p>
    <p style="margin:6px 0 0"><strong>Qué debes revisar:</strong></p>
    <p style="margin:2px 0"><?php echo esc_html( $gc['what_to_check'] ); ?></p>
    <p style="margin:6px 0 0"><strong>Dónde lo revisas:</strong></p>
    <p style="margin:2px 0"><?php echo esc_html( $gc['where_to_check'] ); ?></p>
    <p style="margin:6px 0 0"><strong><?php echo esc_html( $caps[ $gc['detection_capability'] ] ?? '' ); ?></strong></p>
    <p style="margin:2px 0;color:#50575e"><?php echo esc_html( $gc['detection_note'] ); ?></p>
    <p style="margin:6px 0 0"><strong>Puedes marcarlo Cubierto cuando…</strong></p>
    <p style="margin:2px 0"><?php echo esc_html( $gc['how_to_know_covered'] ); ?></p>
    <p style="margin:6px 0 0"><strong>Qué dice la ley:</strong></p>
    <p style="margin:2px 0"><?php echo esc_html( $gc['legal_explanation'] ); ?></p>
   <?php else : ?>
    <p style="margin:6px 0 2px"><em><?php echo esc_html( $i['why'] ); ?></em></p>
    <p style="margin:2px 0"><?php echo esc_html( $i['what_to_do'] ); ?></p>
   <?php endif; ?>
   <?php if ( ! empty( $i['review_detail'] ) ) : ?>
    <ul class="notes"><?php foreach ( (array) $i['review_detail'] as $note ) : ?><li><?php echo esc_html( $note ); ?></li><?php endforeach; ?></ul>
   <?php endif; ?>
   <p class="prov">Procedencia: <?php echo esc_html( $this->provenance_label( $i, $key ) ); ?>
   <?php if ( ! empty( $i['legal_refs'] ) ) : ?> · Ref.: <?php echo esc_html( implode( ' · ', (array) $i['legal_refs'] ) ); ?><?php endif; ?></p>
  </div>
 <?php endforeach;
endforeach; ?>

<p class="meta" style="margin-top:30px">Generado por DataRights for WooCommerce. Catálogo normativo <?php echo esc_html( $m['catalog_version'] ); ?>. Este reporte conserva incertidumbres y procedencia por diseño: los puntos marcados como "necesitan confirmación" dependen de definiciones oficiales aún pendientes.</p>
</body></html><?php
    }

    private function profile_rows( array $p ): array {
        $labels = [
            'customer_accounts' => 'Permite cuentas de cliente', 'checkout_data' => 'Recopila datos en checkout',
            'direct_marketing' => 'Marketing directo', 'newsletter' => 'Newsletter',
            'analytics' => 'Analítica web', 'cookies' => 'Cookies más allá de las esenciales',
            'special_categories' => 'Datos especialmente protegidos', 'third_parties' => 'Servicios de terceros',
            'international_transfers' => 'Transferencias fuera de Chile',
        ];
        $rows = [];
        foreach ( array_merge( $p['characteristics'], $p['processing_context'], $p['integrations'] ) as $dim => $v ) {
            $rows[] = [ $labels[ $dim ] ?? $dim, null === $v ? 'Sin responder' : ( $v ? 'Sí' : 'No' ) ];
        }
        return $rows;
    }

    private function dim_label( string $dim ): string {
        $map = [ 'customer_accounts' => 'Cuentas de cliente', 'newsletter' => 'Newsletter/email marketing',
                 'analytics' => 'Analítica web', 'cookies' => 'Cookies y consentimiento',
                 'third_parties' => 'Servicios de terceros' ];
        return $map[ $dim ] ?? $dim;
    }

    private function yes_no( $v, bool $allow_dash = false ): string {
        if ( null === $v && $allow_dash ) { return 'Sin evidencia técnica'; }
        if ( null === $v ) { return 'Sin responder'; }
        return $v ? 'Sí' : 'No';
    }

    private function relation_label( string $r ): string {
        return [
            'match' => 'Coincide', 'mismatch' => 'No coincide con tu respuesta',
            'unconfirmed' => 'Detectado, sin declarar', 'undetected' => 'Sin evidencia técnica',
        ][ $r ] ?? $r;
    }

    private function provenance_label( array $i, string $section ): string {
        if ( 'confirmar' === $section ) { return 'Estado del conocimiento del catálogo (incertidumbre documentada).'; }
        if ( 'evaluar' === $section ) { return 'Pendiente de evaluación por el administrador.'; }
        $ev = Chilean_DP_Assessment_Engine::instance()->get_evaluation( $i['id'] );
        if ( ! $ev ) { return 'Sin evaluación registrada.'; }
        $src = [ 'user-declared' => 'Declarado por el administrador', 'auto-detected' => 'Detectado técnicamente', 'not-verifiable' => 'No verificable automáticamente' ][ $ev['source'] ] ?? $ev['source'];
        return $src . ' · ' . wp_date( 'd/m/Y H:i', $ev['assessed_at'] );
    }
}
