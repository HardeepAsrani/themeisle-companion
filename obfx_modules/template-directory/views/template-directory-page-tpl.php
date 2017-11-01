<?php
/**
 * The View for Rendering the Template Directory Main Dashboard Page.
 *
 * @link       https://themeisle.com
 * @since      2.0.0
 *
 * @package    Orbit_Fox_Modules
 * @subpackage Orbit_Fox_Modules/template-directory
 * @codeCoverageIgnore
 */

$preview_url = add_query_arg( 'obfx_templates', '', home_url() ); // Define query arg for custom endpoint.

$html = '';

if ( is_array( $templates_array ) ) {
	$html .= '<div class="obfx-template-dir wrap">';
	$html .= '<h1 class="wp-heading-inline">' . __( 'Orbit Fox Template Directory', 'themeisle-companion' ) . '</h1>';
	$html .= '<div class="obfx-template-browser">';

	foreach ( $templates_array as $template => $properties ) {
		$admin_url = admin_url() . 'customize.php';
		$customizer_url = add_query_arg( array(
			'url' => urlencode( $preview_url ),
			'return' => admin_url() . 'tools.php?page=obfx_template_dir',
			'obfx_template_id' => esc_html( $template )
		),  $admin_url );

		$html .= '<div class="obfx-template">';
		$html .= '<h2 class="template-name template-header">' . esc_html( $properties['title'] ) . '</h2>';
		$html .= '<div class="obfx-template-screenshot">';
		$html .= '<img src="' . esc_url( $properties['screenshot'] ) . '" alt="' . esc_html( $properties['title'] ) . '" >';
		$html .= '</div>'; // .obfx-template-screenshot

		$html .= '<div class="obfx-template-actions">';
		if ( ! empty( $properties['demo_url'] ) ) {
			$html .= '<a class="button obfx-preview-template" href="' . esc_url( $customizer_url ) . '" >' . __( 'Preview', 'themeisle-companion' ) . '</a>';
		}

		if( ! empty( $properties['import_file'] ) ) {
			$html .= obfx_render_hidden_elementor_import( $properties['import_file'] );
		}
		$html .= '</div>'; //.obfx-template-actions
		$html .= '</div>'; //.obfx-template
	}
	$html .= '</div>'; //.obfx-template-browser
	$html .= '</div>'; //.obfx-template-dir
}

echo $html;

function obfx_render_hidden_elementor_import( $url ) {
	$html = '';
	if( ! empty( $url ) ) {
		$html .= '<form class="obfx-import-elementor-hidden-form" method="post" action="' . admin_url( 'admin-ajax.php' ) . '" enctype="multipart/form-data" action="">';
			$html .= '<input name="action" value="elementor_import_template" class="obfx-hide">';
			$html .= '<fieldset id="obfx-import-elementor">';
					$html .= '<input class="" type="file" name="file" accept=".json" value="'. esc_url( $url ) .'" class="obfx-hidden-input obfx-elementor-file-value" readonly>';
					$html .= '<input type="submit" class="button button-primary obfx-import-template" value="' . __( 'Import', 'themeisle-companion' ) .'">';
			$html .= '</fieldset>';
		$html .= '</form>';
	}
	return $html;
}
?>

