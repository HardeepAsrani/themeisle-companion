<?php
/**
 * Clients bar section for the homepage.
 *
 * @package Hestia
 * @since Hestia 1.1.47
 */

if ( ! function_exists( 'hestia_clients_bar' ) ) :

	/**
	 * Clients bar section content.
	 * This function can be called from a shortcode too.
	 * When it's called as shortcode, the title and the subtitle shouldn't appear and it should be visible all the time,
	 * it shouldn't matter if is disable on front page.
	 *
	 * @since Hestia 1.1.47
	 * @modified 1.1.51
	 */
	function hestia_clients_bar( $is_shortcode = false ) {

		// When this function is called from selective refresh, $is_shortcode gets the value of WP_Customize_Selective_Refresh object. We don't need that.
		if ( ! is_bool( $is_shortcode ) ) {
			$is_shortcode = false;
		}

		$hide_section = get_theme_mod( 'hestia_clients_bar_hide', true );
		$hestia_clients_bar_content = get_theme_mod( 'hestia_clients_bar_content' );
		$hestia_clients_bar_content_decoded = json_decode( $hestia_clients_bar_content );

		/* Don't show section if Disable section is checked or it doesn't have any content. Show it if it's called as a shortcode */
		if ( $is_shortcode === false && ( empty( $hestia_clients_bar_content ) || (bool) $hide_section === true ) || empty( $hestia_clients_bar_content_decoded ) ) {
			if ( is_customize_preview() ) {
				echo '<section class="hestia-clients-bar text-center" data-sorder="hestia_clients_bar" style="display: none"></section>';
			}
			return;
		}

		$wrapper_class = $is_shortcode === true ? 'is-shortcode' : '';

		?>
        <section class="hestia-clients-bar text-center <?php echo esc_attr( $wrapper_class ); ?>" data-sorder="hestia_clients_bar">
            <div class="container">
                <div class="row">
					<?php
					$i = 1;
					$array_length = sizeof( $hestia_clients_bar_content_decoded );
					foreach ( $hestia_clients_bar_content_decoded as $client ) {
						$image = ! empty( $client->image_url ) ? apply_filters( 'hestia_translate_single_string', $client->image_url, 'Clients bar section' ) : '';
						$link = ! empty( $client->link ) ? apply_filters( 'hestia_translate_single_string', $client->link, 'Clients bar section' ) : '';

						$image_id = function_exists( 'attachment_url_to_postid' ) ? attachment_url_to_postid( preg_replace( '/-\d{1,4}x\d{1,4}/i', '', $image ) ) : '';
						$alt_text = '';
						if ( ! empty( $image_id ) ) {
							$alt_text  = 'alt="' . get_post_meta( $image_id, '_wp_attachment_image_alt', true ) . '"';
						}

						if ( ! empty( $image ) ) {
							echo '<div class="col-md-3">';
							if ( ! empty( $link ) ) {
								$link_html = '<a href="' . esc_url( $link ) . '"';
								if ( function_exists( 'hestia_is_external_url' ) ) {
									$link_html .= hestia_is_external_url( $link );
								}
								$link_html .= '>';
								echo wp_kses_post( $link_html );
							}
							echo '<img src="' . esc_url( $image ) . '" ' . wp_kses_post( $alt_text ) . '>';
							if ( ! empty( $link ) ) {
								echo '</a>';
							}
							echo '</div>';
						}

						if ( $i % 4 == 0 && $i !== $array_length ) {
							echo '</div><!-- /.row -->';
							echo '<div class="row">';
						}
						$i++;
					}
					?>
                </div>
            </div>
        </section>
		<?php
	}

endif;
if ( function_exists( 'hestia_clients_bar' ) ) {
	$section_priority = apply_filters( 'hestia_section_priority', 50, 'hestia_clients_bar' );
	add_action( 'hestia_sections', 'hestia_clients_bar', absint( $section_priority ) );
	if ( function_exists( 'hestia_features_register_strings' ) ) {
		add_action( 'after_setup_theme', 'hestia_features_register_strings', 11 );
	}
}
