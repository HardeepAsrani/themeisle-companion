<?php
/**
 * Orbit Fox Elementor Features Widget
 *
 * @link       https://themeisle.com
 * @since      1.0.0
 *
 * @package    Elementor_Widgets_OBFX_Module
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * Class OBFX_Elementor_Widget_Features
 *
 * @package Elementor_Widgets_OBFX_Module
 */
class OBFX_Elementor_Widget_Posts_Grid extends Widget_Base {

	/**
	 * Set the widget ID
	 *
	 * @return string
	 */
	public function get_id() {
		return 'obfx-widget-posts-grid';
	}

	/**
	 * Widget title.
	 *
	 * @return string
	 */
	public function get_title() {
		return __( 'Post Type Grid', 'themeisle-companion' );
	}

	/**
	 * Widget icon.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-posts-grid';
	}

	/**
	 * Widget name.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'obfx-posts-grid';
	}

	/**
	 * Widget Category
	 *
	 * @return array
	 */
	public function get_categories() {
		return [ 'obfx-elementor-widgets' ];
	}

	/**
	 * Get post types
	 */
	private function grid_get_all_post_types() {
		$options = array();
		$exclude = array( 'attachment', 'elementor_library' ); // excluded post types

		$args = array(
			'public' => true,
		);

		foreach ( get_post_types( $args, 'objects' ) as $post_type ) {
			// Check if post type name exists
			if ( ! isset( $post_type->name ) ) {
				continue;
			}

			// Check if post type label exists
			if ( ! isset( $post_type->label ) ) {
				continue;
			}

			// Check if post type is excluded
			if ( in_array( $post_type->name, $exclude ) === true ) {
				continue;
			}

			$options[$post_type->name] = $post_type->label;
		}

		return $options;
	}

	/**
	 * Register Elementor Controls
	 */
	protected function _register_controls() {
		$this->grid_options_section();
		$this->grid_image_section();
		$this->grid_title_section();
		$this->grid_content_section();

	}

	/**
	 * Content > Grid
	 */
	private function grid_options_section() {
		$this->start_controls_section(
			'section_grid',
			[
				'label' => __( 'Grid Options', 'themeisle-companion' ),
			]

		);

		// Post type
		$this->add_control(
			'grid_post_type',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => '<i class="fa fa-tag"></i> ' . __( 'Post Type', 'themeisle-companion' ),
				'default' => 'post',
				'options' => $this->grid_get_all_post_types(),
			]
		);

		// Items
		$this->add_control(
			'grid_items',
			[
				'type'        => Controls_Manager::NUMBER,
				'label'       => '<i class="fa fa-th-large"></i> ' . __( 'Items', 'themeisle-companion' ),
				'placeholder' => __( 'How many items?', 'themeisle-companion' ),
				'default'     => __( '3', 'themeisle-companion' ),
			]
		);

		// Columns
		$this->add_control(
			'grid_columns',
			[
				'type'        => Controls_Manager::SELECT,
				'label'       => '<i class="fa fa-columns"></i> ' . __( 'Columns', 'themeisle-companion' ),
				'default'     => 3,
				'options' => [
					1 => 1,
					2 => 2,
					3 => 3,
					4 => 4,
				],
			]
		);

		// Order by
		$this->add_control(
			'grid_order_by',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => '<i class="fa fa-sort"></i> ' . __( 'Order by', 'themeisle-companion' ),
				'default' => 'date',
				'options' => [
					'date'          => __( 'Date', 'themeisle-companion' ),
					'title'         => __( 'Title', 'themeisle-companion' ),
					'modified'      => __( 'Modified date', 'themeisle-companion' ),
					'comment_count' => __( 'Comment count', 'themeisle-companion' ),
					'rand'          => __( 'Random', 'themeisle-companion' ),
				],
			]
		);

		// Order
		$this->add_control(
			'grid_order',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => '<i class="fa fa-sort-numeric-desc"></i> ' . __( 'Order', 'themeisle-companion' ),
				'default' => 'DESC',
				'options' => [
					'ASC'  => __( 'Ascendent', 'themeisle-companion' ),
					'DESC' => __( 'Descendent', 'themeisle-companion' ),
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Content > Image Options.
	 */
	private function grid_image_section() {
		$this->start_controls_section(
			'section_grid_image',
			[
				'label'     => __( 'Image', 'themeisle-companion' ),
			]

		);

		// Hide image
		$this->add_control(
			'grid_image_hide',
			[
				'label' => '<i class="fa fa-minus-circle"></i> ' . __( 'Hide', 'themeisle-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
			]
		);

		// Image link
		$this->add_control(
			'grid_image_link',
			[
				'label' => '<i class="fa fa-link"></i> ' . __( 'Link', 'themeisle-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Content > Title Options.
	 */
	private function grid_title_section() {
		$this->start_controls_section(
			'section_grid_title',
			[
				'label'     => __( 'Title', 'themeisle-companion' ),
			]

		);

		// Hide title
		$this->add_control(
			'grid_title_hide',
			[
				'label' => '<i class="fa fa-minus-circle"></i> ' . __( 'Hide', 'themeisle-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
			]
		);

		// Title tag
		$this->add_control(
			'grid_title_tag',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => '<i class="fa fa-code"></i> ' . __( 'Tag', 'themeisle-companion' ),
				'default' => 'h2',
				'options' => [
					'h1' => 'h1',
					'h2' => 'h2',
					'h3' => 'h3',
					'h4' => 'h4',
					'h5' => 'h5',
					'h6' => 'h6',
					'p' => 'p',
				],
			]
		);

		// Title link
		$this->add_control(
			'grid_title_link',
			[
				'label' => '<i class="fa fa-link"></i> ' . __( 'Link', 'themeisle-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		// Title alignment
		$this->add_responsive_control(
			'grid_title_alignment',
			[
				'label'     => '<i class="fa fa-align-right"></i> ' . __( 'Alignment', 'themeisle-companion' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'    => [
						'title' => __( 'Left', 'themeisle-companion' ),
						'icon'  => 'fa fa-align-left',
					],
					'center'  => [
						'title' => __( 'Center', 'themeisle-companion' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'   => [
						'title' => __( 'Right', 'themeisle-companion' ),
						'icon'  => 'fa fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'themeisle-companion' ),
						'icon'  => 'fa fa-align-justify',
					],
				],
				'default'   => 'left',
				'selectors' => [
					'{{WRAPPER}} .obfx-grid-item-title' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Content > Content Options.
	 */
	private function grid_content_section() {
		$this->start_controls_section(
			'section_grid_content',
			[
				'label'     => __( 'Content', 'themeisle-companion' ),
			]

		);

		// Hide content
		$this->add_control(
			'grid_content_hide',
			[
				'label' => '<i class="fa fa-minus-circle"></i> ' . __( 'Hide', 'themeisle-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
			]
		);

		// Author
		$this->add_control(
			'grid_content_author',
			[
				'label' => '<i class="fa fa-user"></i> ' . __( 'Author', 'themeisle-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'condition' => [
					'section_grid.grid_post_type!' => 'product',
				],
			]
		);

		// Author before text
		$this->add_control(
			'grid_content_author_before_text',
			[
				'type'        => Controls_Manager::TEXT,
				'label'       => __( 'Text before', 'themeisle-companion' ),
				'placeholder' => __( 'Text before author', 'themeisle-companion'),
				'default'     => '',
				'condition' => [
					'grid_content_author' => 'yes',
				],
			]
		);

		// Author alignment
		$this->add_responsive_control(
			'grid_content_author_alignment',
			[
				'label'     => __( 'Author alignment', 'themeisle-companion' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'    => [
						'title' => __( 'Left', 'themeisle-companion' ),
						'icon'  => 'fa fa-align-left',
					],
					'center'  => [
						'title' => __( 'Center', 'themeisle-companion' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'   => [
						'title' => __( 'Right', 'themeisle-companion' ),
						'icon'  => 'fa fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'themeisle-companion' ),
						'icon'  => 'fa fa-align-justify',
					],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .obfx-grid-item-author' => 'text-align: {{VALUE}};',
				],
				'condition' => [
					'grid_content_author' => 'yes',
				],
			]
		);

		// Date
		$this->add_control(
			'grid_content_date',
			[
				'label' => '<i class="fa fa-calendar-o"></i> ' . __( 'Date', 'themeisle-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'condition' => [
					'section_grid.grid_post_type!' => 'product',
				],
			]
		);

		// Date before text
		$this->add_control(
			'grid_content_date_before_text',
			[
				'type'        => Controls_Manager::TEXT,
				'label'       => __( 'Text before', 'themeisle-companion' ),
				'placeholder' => __( 'Text before date', 'themeisle-companion'),
				'default'     => '',
				'condition' => [
					'grid_content_date' => 'yes',
				],
			]
		);

		// Date alignment
		$this->add_responsive_control(
			'grid_content_date_alignment',
			[
				'label'     => __( 'Date alignment', 'themeisle-companion' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'    => [
						'title' => __( 'Left', 'themeisle-companion' ),
						'icon'  => 'fa fa-align-left',
					],
					'center'  => [
						'title' => __( 'Center', 'themeisle-companion' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'   => [
						'title' => __( 'Right', 'themeisle-companion' ),
						'icon'  => 'fa fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'themeisle-companion' ),
						'icon'  => 'fa fa-align-justify',
					],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .obfx-grid-item-date' => 'text-align: {{VALUE}};',
				],
				'condition' => [
					'grid_content_date' => 'yes',
				],
			]
		);

		// Price
		$this->add_control(
			'grid_content_price',
			[
				'label' => '<i class="fa fa-usd"></i> ' . __( 'Price', 'themeisle-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'section_grid.grid_post_type' => 'product',
				],
			]
		);

		// Price alignment
		$this->add_responsive_control(
			'grid_content_price_alignment',
			[
				'label'     => __( 'Price alignment', 'themeisle-companion' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'    => [
						'title' => __( 'Left', 'themeisle-companion' ),
						'icon'  => 'fa fa-align-left',
					],
					'center'  => [
						'title' => __( 'Center', 'themeisle-companion' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'   => [
						'title' => __( 'Right', 'themeisle-companion' ),
						'icon'  => 'fa fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'themeisle-companion' ),
						'icon'  => 'fa fa-align-justify',
					],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .obfx-grid-item-price' => 'text-align: {{VALUE}};',
				],
				'condition' => [
					'grid_content_price!' => '',
                    'grid_section.grid_post_type' => 'product',
				],
			]
		);

		// Read more button hide
		$this->add_control(
			'grid_content_btn',
			[
				'label' => '<i class="fa fa-check-square"></i> ' . __( 'Button', 'themeisle-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
			]
		);

		// Default button text
		$this->add_control(
			'grid_content_default_btn_text',
			[
				'type'        => Controls_Manager::TEXT,
				'label'       => __( 'Button text', 'themeisle-companion' ),
				'placeholder' => __( 'Read more', 'themeisle-companion'),
				'default'     => __( 'Read more', 'themeisle-companion'),
				'condition' => [
                    'grid_content_btn!' => '',
					'section_grid.grid_post_type!' => 'product',
				],
			]
		);

		// Product button text
		$this->add_control(
			'grid_content_product_btn_text',
			[
				'type'        => Controls_Manager::TEXT,
				'label'       => __( 'Button text', 'themeisle-companion' ),
				'placeholder' => __( 'View product', 'themeisle-companion'),
				'default'     => __( 'View product', 'themeisle-companion'),
				'condition' => [
					'grid_content_btn!' => '',
					'section_grid.grid_post_type' => 'product',
				],
			]
		);

		// Button alignment
		$this->add_responsive_control(
			'grid_content_btn_alignment',
			[
				'label'     => __( 'Button alignment', 'themeisle-companion' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'    => [
						'title' => __( 'Left', 'themeisle-companion' ),
						'icon'  => 'fa fa-align-left',
					],
					'center'  => [
						'title' => __( 'Center', 'themeisle-companion' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'   => [
						'title' => __( 'Right', 'themeisle-companion' ),
						'icon'  => 'fa fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'themeisle-companion' ),
						'icon'  => 'fa fa-align-justify',
					],
				],
				'default'   => 'left',
				'selectors' => [
					'{{WRAPPER}} .obfx-grid-item-btn' => 'text-align: {{VALUE}};',
				],
				'condition' => [
					'grid_content_btn!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'grid_content_alignment',
			[
				'label'     => '<i class="fa fa-align-right"></i> ' . __( 'Alignment', 'themeisle-companion' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'    => [
						'title' => __( 'Left', 'themeisle-companion' ),
						'icon'  => 'fa fa-align-left',
					],
					'center'  => [
						'title' => __( 'Center', 'themeisle-companion' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'   => [
						'title' => __( 'Right', 'themeisle-companion' ),
						'icon'  => 'fa fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'themeisle-companion' ),
						'icon'  => 'fa fa-align-justify',
					],
				],
				'default'   => 'left',
				'selectors' => [
					'{{WRAPPER}} .obfx-grid-item-content' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render function to output the pricing table.
	 */
	protected function render() {
		$settings = $this->get_settings();

		$output = '';

		// Output
		$output .= '<div class="obfx-grid">';
		$output .= '<div class="container">';

		// Arguments for query
		$args = array();

		// Check if post type exists
		if ( ! empty( $settings['grid_post_type'] ) && post_type_exists( $settings['grid_post_type'] ) ) {
		    $args['post_type'] = $settings['grid_post_type'];
		}

		// Items to display
		if ( ! empty( $settings['grid_items'] ) &&  intval( $settings['grid_items'] ) == $settings['grid_items']  ) {
			$args['posts_per_page'] = $settings['grid_items'];
		}

		// Order by
		if ( ! empty( $settings['grid_order_by'] ) ) {
			$args['orderby'] = $settings['grid_order_by'];
		}

		// Order
		if ( ! empty( $settings['grid_order'] ) ) {
			$args['order'] = $settings['grid_order'];
		}

        // Query
        $query = new \WP_Query( $args );

        // Query results
        if ( $query->have_posts() ) {
            $item_id = 1;
        ?>
            <div class="row">
                <?php while ( $query->have_posts() ) {
	                $query->the_post();

	                // Add specific classes
                    $col_class = 'col-sm-4'; // default 3 cols
		            if ( ! empty( $settings['grid_columns'] ) ) {
		                switch ( $settings['grid_columns'] ) {
                            case 1:
	                            $col_class = '';
                            break;
			                case 2:
				                $col_class = 'col-sm-6';
                            break;
			                case 4:
				                $col_class = 'col-sm-6 col-md-3';
                            break;
                            default:
	                            $col_class = 'col-sm-4';
                        }
		            }
	                ?>
                    <div class="col-xs-12 <?php echo esc_attr($col_class); ?> obfx-grid-item">
		                <?php
		                // Image
		                if ( $settings['grid_image_hide'] !== 'yes' ) {
			                // Check if post type has featured image
			                if ( has_post_thumbnail() ) { ?>

				                <?php if ( $settings['grid_image_link'] == 'yes' ) { ?>
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="obfx-grid-item-image"><?php the_post_thumbnail(); ?></a>
                                <?php } else { ?>
                                    <div class="obfx-grid-item-image"><?php the_post_thumbnail(); ?></div>
			                <?php }
                            }
		                }

		                // Title
		                if ( $settings['grid_title_hide'] !== 'yes' ) { ?>
                            <<?php echo $settings['grid_title_tag']; ?> class="obfx-grid-item-title">
                                <?php if ( $settings['grid_title_link'] == 'yes' ) { ?>
                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title();
                                    ?></a>
                                <?php } else {
                                    the_title();
                                } ?>
                            </<?php echo $settings['grid_title_tag']; ?>>
                        <?php }

                        if ( $settings['grid_post_type'] !== 'product' ) { ?>
                            <div class="row obfx-grid-item-meta">
                                <?php if ( $settings['grid_content_author'] == 'yes' ) { ?>
                                    <div class="obfx-grid-item-author">
                                        <?php echo ( ! empty( $settings['grid_content_author_before_text']) ? esc_html( $settings['grid_content_author_before_text'] )
                                                : '' ) . get_the_author(); ?>
                                    </div>
                                <?php
                                }

                                if ( $settings['grid_content_date'] == 'yes' ) { ?>
                                    <div class="obfx-grid-item-date">
                                        <?php echo ( ! empty( $settings['grid_content_date_before_text']) ? esc_html( $settings['grid_content_date_before_text'] )
                                                : '' ) . get_the_date(); ?>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php }

                        // Price
		                if ( class_exists( 'WooCommerce' ) ) {
	                        if ( $settings['grid_post_type'] == 'product' && $settings['grid_content_price'] == 'yes' ) { ?>
                                <div class="obfx-grid-item-price">
			                        <?php echo wc_price(wc_get_product()->price); ?>
                                </div>
	                        <?php }
                        }

                        // Content
                        if ( $settings['grid_content_hide'] !== 'yes' ) { ?>
                        <div class="obfx-grid-item-content"><?php the_excerpt(); ?></div>
                        <?php }

                        // Button
		                if ( $settings['grid_content_btn'] == 'yes' && ( ! empty ( $settings['grid_content_default_btn_text']
			                ) || ! empty ( $settings['grid_content_product_btn_text'] ) ) ) { ?>
                            <div class="obfx-grid-item-btn">
                                <a href="<?php the_permalink(); ?>" title="<?php echo ( $settings['grid_post_type'] == 'product' ? $settings['grid_content_product_btn_text'] : $settings['grid_content_default_btn_text'] ); ?>"><?php echo ( $settings['grid_post_type'] == 'product' ? $settings['grid_content_product_btn_text'] : $settings['grid_content_default_btn_text'] ); ?></a>
                            </div>
		                <?php } ?>

                    </div>
	                <?php
	                // Add rows
                    if ( ! empty( $settings['grid_columns'] ) ) {
                        if ( $settings['grid_columns'] == $item_id ) { ?>
                            </div><!-- .row -->
                            <div class="row">
                        <?php
                            $item_id = 0;
                        }
                    }

		            $item_id++;
                }
                ?>
            </div><!-- .row -->
        <?php
        }

        // Restore original data
        wp_reset_postdata();

		$output .= '</div><!-- .container -->';
		$output .= '</div><!-- .obfx-grid -->';

		echo $output;
	}
}

