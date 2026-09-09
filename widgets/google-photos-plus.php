<?php
namespace AllEmebdAddon\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Elementor Google Gallery Plus Widget
 *
 * Displays a Google Photos gallery selected via the Picker API directly in
 * the Elementor editor.
 *
 * @since 1.1.8
 */
class google_photos_plus_addon extends Widget_Base {

	public function get_name(): string {
		return 'google_photos_plus';
	}

	public function get_title(): string {
		return esc_html__( 'Google Gallery', 'allembed' );
	}

	public function get_icon(): string {
		return 'bl_icon eicon-gallery-grid';
	}

	public function get_categories(): array {
		return [ 'AllEmbed' ];
	}

	public function get_keywords(): array {
		return [ 'google', 'photos', 'gallery', 'plus', 'picker', 'grid', 'masonry', 'slider', 'lightbox', 'portfolio' ];
	}

	public function get_style_depends(): array {
		return [ 'aeafe-gphoto-plus-widget' ];
	}

	public function get_script_depends(): array {
		return [ 'aeafe-gphoto-plus-gallery' ];
	}

	protected function _register_controls(): void {

		// ═══════════════════════════════════════════════════
		// Google Photos Picker Section
		// ═══════════════════════════════════════════════════
		$this->start_controls_section(
			'section_google_photos_plus',
			[
				'label' => __( 'Google Photos Picker', 'allembed' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$api          = \AEAFE_Google_Photos_API::instance();
		$is_connected = $api->is_connected();
		$settings_url = admin_url( 'admin.php?page=aeafe-google-photos' );

		/* ── Picker UI HTML ── */
		$picker_html = '<div class="aeafe-plus-picker-wrap" id="aeafe-plus-picker-container">';

		if ( ! $is_connected ) {
			$picker_html .= '<div class="aeafe-plus-notice aeafe-plus-notice--warning">'
				. '<span class="aeafe-plus-notice__icon">&#9888;</span>'
				. '<div>'
				. '<strong>' . esc_html__( 'Google Account Not Connected', 'allembed' ) . '</strong>'
				. '<p>' . sprintf(
					wp_kses(
						/* translators: %s: settings URL */
						__( 'Please <a href="%s" target="_blank">connect your Google account</a> on the API Credentials page first, then re-authorize to grant the Picker scope.', 'allembed' ),
						[ 'a' => [ 'href' => [], 'target' => [] ] ]
					),
					esc_url( $settings_url )
				) . '</p>'
				. '</div>'
				. '</div>';
		} else {
			$picker_html .= '<div class="aeafe-plus-status-bar">'
				. '<span class="aeafe-plus-status-dot"></span>'
				. '<span class="aeafe-plus-status-text">' . esc_html__( 'Google Account Connected', 'allembed' ) . '</span>'
				. '</div>';
		}

		$picker_html .= '<div class="aeafe-plus-actions">'
			. '<button type="button" class="aeafe-plus-btn aeafe-plus-btn--primary aeafe-plus-launch-picker" data-connected="' . ( $is_connected ? '1' : '0' ) . '">'
			. '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">'
			. '<rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/>'
			. '<polyline points="21 15 16 10 5 21"/>'
			. '</svg>'
			. '<span class="aeafe-plus-btn-text">' . esc_html__( 'Select Photos from Google', 'allembed' ) . '</span>'
			. '</button>'
			. '<button type="button" class="aeafe-plus-btn aeafe-plus-btn--danger aeafe-plus-clear-photos"'
			. ' style="display:none;" title="' . esc_attr__( 'Clear selected photos', 'allembed' ) . '">'
			. '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">'
			. '<polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>'
			. '</svg>'
			. esc_html__( 'Clear', 'allembed' )
			. '</button>'
			. '</div>';

		/* Polling feedback */
		$picker_html .= '<div class="aeafe-plus-polling" style="display:none;">'
			. '<span class="aeafe-plus-spinner"></span>'
			. '<span class="aeafe-plus-polling-msg">' . esc_html__( 'Waiting for you to select photos in Google Photos…', 'allembed' ) . '</span>'
			. '</div>';

		/* Selected-photos summary */
		$picker_html .= '<div class="aeafe-plus-summary" style="display:none;">'
			. '<div class="aeafe-plus-summary-header">'
			. '<span class="aeafe-plus-count-badge">0 ' . esc_html__( 'photos', 'allembed' ) . '</span>'
			. '<span class="aeafe-plus-summary-tip">' . esc_html__( 'Selected for this widget', 'allembed' ) . '</span>'
			. '</div>'
			. '<div class="aeafe-plus-thumbs-grid"></div>'
			. '</div>';

		$picker_html .= '</div>';

		$this->add_control( 'picker_ui', [ 'type' => Controls_Manager::RAW_HTML, 'raw' => $picker_html ] );

		/* Hidden control – persists selected photos JSON */
		$this->add_control(
			'photos_json',
			[
				'label'       => __( 'Photos Data (JSON)', 'allembed' ),
				'type'        => Controls_Manager::HIDDEN,
				'default'     => '',
				'render_type' => 'template',
			]
		);

		$this->end_controls_section();

		// ═══════════════════════════════════════════════════
		// Gallery Layout Section
		// ═══════════════════════════════════════════════════
		$this->start_controls_section(
			'section_layout_plus',
			[
				'label' => __( 'Gallery Layout', 'allembed' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => __( 'Layout Mode', 'allembed' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'grid',
				'options' => [
					'grid'    => __( 'Grid Gallery', 'allembed' ),
					'masonry' => __( 'Masonry Showcase', 'allembed' ),
					'slider'  => __( 'Interactive Carousel', 'allembed' ),
				],
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'          => __( 'Columns', 'allembed' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => [ '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6' ],
				'selectors'      => [
					'{{WRAPPER}} .aeafe-plus-grid'    => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
					'{{WRAPPER}} .aeafe-plus-masonry' => 'column-count: {{VALUE}}; -webkit-column-count: {{VALUE}};',
				],
				'condition'      => [ 'layout!' => 'slider' ],
			]
		);

		$this->add_responsive_control(
			'gap',
			[
				'label'      => __( 'Space Between Photos', 'allembed' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 16 ],
				'selectors'  => [
					'{{WRAPPER}} .aeafe-plus-grid'                     => 'gap: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .aeafe-plus-masonry'                  => 'column-gap: {{SIZE}}{{UNIT}}; -webkit-column-gap: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .aeafe-plus-masonry .aeafe-plus-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'aspect_ratio',
			[
				'label'     => __( 'Photo Aspect Ratio', 'allembed' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '1/1',
				'options'   => [
					'auto' => __( 'Auto / Natural', 'allembed' ),
					'16/9' => __( '16:9 Landscape', 'allembed' ),
					'4/3'  => __( '4:3 Classic', 'allembed' ),
					'3/2'  => __( '3:2 Photography', 'allembed' ),
					'1/1'  => __( '1:1 Square (Modern)', 'allembed' ),
					'2/3'  => __( '2:3 Portrait', 'allembed' ),
					'9/16' => __( '9:16 Story / Mobile', 'allembed' ),
				],
				'condition' => [ 'layout' => 'grid' ],
			]
		);

		$this->add_control(
			'hover_effect',
			[
				'label'   => __( 'Hover Animation', 'allembed' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'zoom',
				'options' => [
					'zoom'      => __( 'Zoom & Lift (Recommended)', 'allembed' ),
					'lift'      => __( '3D Float Lift', 'allembed' ),
					'shine'     => __( 'Metallic Light Beam Shine', 'allembed' ),
					'overlay'   => __( 'Frosted Dark Glass Overlay', 'allembed' ),
					'slide'     => __( 'Slide-Up Glass Caption', 'allembed' ),
					'grayscale' => __( 'B&W to Vivid Color', 'allembed' ),
					'none'      => __( 'None', 'allembed' ),
				],
			]
		);

		$this->add_control(
			'enable_lightbox',
			[
				'label'        => __( 'Popup Lightbox', 'allembed' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'layout!' => 'slider' ],
			]
		);

		$this->add_control(
			'show_zoom_badge',
			[
				'label'        => __( 'Show Zoom Icon on Hover', 'allembed' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'enable_lightbox' => 'yes', 'layout!' => 'slider' ],
			]
		);

		$this->add_control(
			'show_caption',
			[
				'label'        => __( 'Show Photo Description', 'allembed' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'slider_autoplay',
			[
				'label'        => __( 'Autoplay Carousel', 'allembed' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'layout' => 'slider' ],
			]
		);

		$this->add_control(
			'slider_speed',
			[
				'label'     => __( 'Autoplay Interval (ms)', 'allembed' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 'px' => [ 'min' => 1500, 'max' => 10000, 'step' => 500 ] ],
				'default'   => [ 'unit' => 'px', 'size' => 4000 ],
				'condition' => [ 'layout' => 'slider' ],
			]
		);

		$this->add_control(
			'slider_show_nav',
			[
				'label'        => __( 'Navigation Arrows', 'allembed' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'layout' => 'slider' ],
			]
		);

		$this->add_control(
			'slider_show_dots',
			[
				'label'        => __( 'Pagination Dots', 'allembed' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'layout' => 'slider' ],
			]
		);

		$this->end_controls_section();

		// ═══════════════════════════════════════════════════
		// Style Tab – Card Styling
		// ═══════════════════════════════════════════════════
		$this->start_controls_section(
			'section_style_image_plus',
			[
				'label' => __( 'Photo Cards', 'allembed' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label'      => __( 'Border Radius', 'allembed' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => 12, 'right' => 12, 'bottom' => 12, 'left' => 12, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .aeafe-plus-item'        => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
					'{{WRAPPER}} .aeafe-plus-img-wrap'    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .aeafe-plus-item__image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .aeafe-plus-slider'      => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_card_style' );

		// Normal State
		$this->start_controls_tab(
			'tab_card_normal',
			[ 'label' => __( 'Normal', 'allembed' ) ]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_shadow',
				'selector' => '{{WRAPPER}} .aeafe-plus-item',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'card_border',
				'selector' => '{{WRAPPER}} .aeafe-plus-item',
			]
		);

		$this->end_controls_tab();

		// Hover State
		$this->start_controls_tab(
			'tab_card_hover',
			[ 'label' => __( 'Hover', 'allembed' ) ]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_shadow_hover',
				'selector' => '{{WRAPPER}} .aeafe-plus-item:hover',
			]
		);

		$this->add_control(
			'card_border_color_hover',
			[
				'label'     => __( 'Border Color', 'allembed' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ '{{WRAPPER}} .aeafe-plus-item:hover' => 'border-color: {{VALUE}};' ],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		// ═══════════════════════════════════════════════════
		// Style Tab – Caption Styling
		// ═══════════════════════════════════════════════════
		$this->start_controls_section(
			'section_style_caption_plus',
			[
				'label'     => __( 'Caption / Description', 'allembed' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_caption' => 'yes' ],
			]
		);

		$this->add_control(
			'caption_color',
			[
				'label'     => __( 'Text Color', 'allembed' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [ '{{WRAPPER}} .aeafe-plus-item__caption' => 'color: {{VALUE}};' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 'name' => 'caption_typography_plus', 'selector' => '{{WRAPPER}} .aeafe-plus-item__caption' ]
		);

		$this->add_control(
			'caption_bg',
			[
				'label'     => __( 'Background Tint', 'allembed' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ '{{WRAPPER}} .aeafe-plus-item__caption' => 'background: {{VALUE}};' ],
			]
		);

		$this->end_controls_section();
	}

	protected function render(): void {
		$settings    = $this->get_settings_for_display();
		$photos_json = $settings['photos_json'] ?? '';
		if ( empty( $photos_json ) ) {
			$photos_json = $this->get_settings( 'photos_json' );
		}
		$items       = [];

		if ( ! empty( $photos_json ) ) {
			$decoded = null;
			if ( is_string( $photos_json ) ) {
				$decoded = json_decode( $photos_json, true );
				if ( ! is_array( $decoded ) ) { $decoded = json_decode( wp_unslash( $photos_json ), true ); }
				if ( ! is_array( $decoded ) ) { $decoded = json_decode( stripslashes( $photos_json ), true ); }
			} elseif ( is_array( $photos_json ) ) {
				$decoded = $photos_json;
			}
			if ( ! empty( $decoded ) && is_array( $decoded ) ) {
				$items = $decoded;
			}
		}

		if ( empty( $items ) ) {
			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
				echo '<div class="aeafe-plus-placeholder">'
					. '<div class="aeafe-plus-placeholder__icon">'
					. '<svg viewBox="0 0 256 256" width="48" height="48" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" fill="#000000">'
					. '<g id="SVGRepo_bgCarrier" stroke-width="0"></g>'
					. '<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>'
					. '<g id="SVGRepo_iconCarrier">'
					. '<g>'
					. '<path d="M64,58.1485714 C99.328,58.1485714 128,86.8205714 128,122.148571 L128,122.148571 L128,128 L5.85142857,128 C2.63314286,128 0,125.366857 0,122.148571 C0,86.8205714 28.672,58.1485714 64,58.1485714 L64,58.1485714 Z" fill="#FBBB05"></path>'
					. '<path d="M197.851429,64 C197.851429,99.328 169.179429,128 133.851429,128 L128,128 L128,5.85142857 C128,2.63314286 130.633143,0 133.851429,0 L133.851429,0 C169.179429,0 197.851429,28.672 197.851429,64 Z" fill="#E94335"></path>'
					. '<path d="M192,197.851429 C156.672,197.851429 128,169.179429 128,133.851429 L128,133.851429 L128,128 L250.148571,128 C253.366857,128 256,130.633143 256,133.851429 L256,133.851429 C256,169.179429 227.328,197.851429 192,197.851429 L192,197.851429 Z" fill="#4285F4"></path>'
					. '<path d="M58.1485714,192 C58.1485714,156.672 86.8205714,128 122.148571,128 L128,128 L128,250.148571 C128,253.366857 125.366857,256 122.148571,256 L122.148571,256 C86.8205714,256 58.1485714,227.328 58.1485714,192 Z" fill="#0F9D58"></path>'
					. '</g>'
					. '</g>'
					. '</svg>'
					. '</div>'
					. '<h4>' . esc_html__( 'Google Gallery Plus', 'allembed' ) . '</h4>'
					. '<p>' . esc_html__( 'Click "Select Photos from Google" in the left panel to display your photos here.', 'allembed' ) . '</p>'
					. '</div>';
			}
			return;
		}

		$layout       = sanitize_key( $settings['layout'] ?? 'grid' );
		$enable_lb    = 'yes' === ( $settings['enable_lightbox'] ?? 'yes' );
		$show_badge   = 'yes' === ( $settings['show_zoom_badge'] ?? 'yes' );
		$show_caption = 'yes' === ( $settings['show_caption'] ?? 'no' );
		$hover_effect = sanitize_key( $settings['hover_effect'] ?? 'zoom' );
		$slider_auto  = 'yes' === ( $settings['slider_autoplay'] ?? 'yes' );
		$slider_speed = (int) ( $settings['slider_speed']['size'] ?? 4000 );
		$slider_nav   = 'yes' === ( $settings['slider_show_nav'] ?? 'yes' );
		$slider_dots  = 'yes' === ( $settings['slider_show_dots'] ?? 'yes' );

		$widget_id  = 'aeafe-plus-' . $this->get_id();
		$grid_class = match ( $layout ) {
			'masonry' => 'aeafe-plus-masonry',
			'slider'  => 'aeafe-plus-slider',
			default   => 'aeafe-plus-grid',
		};

		$aspect_ratio = sanitize_text_field( $settings['aspect_ratio'] ?? '1/1' );
		$aspect_class = ( 'grid' === $layout ) ? 'aeafe-plus-aspect-' . str_replace( '/', '-', $aspect_ratio ) : 'aeafe-plus-aspect-auto';

		printf(
			'<div id="%s" class="aeafe-plus-wrap aeafe-plus-hover-%s %s" data-layout="%s" data-aspect="%s" data-lightbox="%s" data-autoplay="%s" data-speed="%d" data-nav="%s" data-dots="%s">',
			esc_attr( $widget_id ),
			esc_attr( $hover_effect ),
			esc_attr( $aspect_class ),
			esc_attr( $layout ),
			esc_attr( $aspect_ratio ),
			$enable_lb ? '1' : '0',
			$slider_auto ? '1' : '0',
			$slider_speed,
			$slider_nav ? '1' : '0',
			$slider_dots ? '1' : '0'
		);

		echo '<div class="' . esc_attr( $grid_class ) . '">';

		foreach ( $items as $item ) {
			$base_url = $item['base_url'] ?? $item['baseUrl'] ?? ( isset( $item['mediaFile']['baseUrl'] ) ? $item['mediaFile']['baseUrl'] : '' );
			if ( empty( $base_url ) && ! empty( $item['thumbnail'] ) ) {
				$base_url = preg_replace( '/=.*$/', '', $item['thumbnail'] );
			}
			if ( empty( $base_url ) && ! empty( $item['full_url'] ) ) {
				$base_url = preg_replace( '/=.*$/', '', $item['full_url'] );
			}

			// Guarantee NO crop parameter (-c) is passed to Google Photos for clean aspect ratio cropping
			$raw_thumb = $base_url ? $base_url . '=w1400-h1400' : ( $item['thumbnail'] ?? '' );
			$raw_thumb = str_replace( [ '-c', '=w400-h400-c', '=w600-h600-c' ], [ '', '=w1400-h1400', '=w1400-h1400' ], $raw_thumb );
			$raw_full  = $item['full_url'] ?? ( $base_url ? $base_url . '=w2048-h2048' : '' );

			$thumb_url = esc_url( $this->get_proxy_url( $raw_thumb ) );
			$full_url  = esc_url( $this->get_proxy_url( $raw_full ) );
			$caption   = esc_html( $item['description'] ?? $item['filename'] ?? ( isset($item['mediaFile']['filename']) ? $item['mediaFile']['filename'] : '' ) );

			$link_open  = $enable_lb
				? '<a class="aeafe-plus-item__link" href="' . $full_url . '" data-caption="' . esc_attr( $caption ) . '" data-aeafe-plus-lightbox="' . esc_attr( $widget_id ) . '">'
				: '';
			$link_close = $enable_lb ? '</a>' : '';

			echo '<div class="aeafe-plus-item">';
			echo $link_open;
			echo '<div class="aeafe-plus-img-wrap aeafe-plus-loading">';
			echo '<div class="aeafe-plus-loader"><span class="aeafe-plus-loader-spin"></span></div>';
			echo '<img class="aeafe-plus-item__image" src="' . $thumb_url . '" alt="' . ( $caption ?: esc_attr__( 'Google Photo', 'allembed' ) ) . '" loading="lazy" onload="this.parentElement.classList.remove(\'aeafe-plus-loading\'); this.classList.add(\'aeafe-plus-loaded\');" onerror="this.parentElement.classList.remove(\'aeafe-plus-loading\');">';
			echo '<div class="aeafe-plus-item__overlay"></div>';

			if ( $enable_lb && $show_badge && 'slider' !== $layout ) {
				echo '<span class="aeafe-plus-item__badge" title="' . esc_attr__( 'View Full Photo', 'allembed' ) . '">'
					. '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="11" y1="8" x2="11" y2="14"></line><line x1="8" y1="11" x2="14" y2="11"></line></svg>'
					. '</span>';
			}

			if ( in_array( $hover_effect, [ 'overlay', 'blur' ], true ) && $enable_lb ) {
				echo '<span class="aeafe-plus-item__center-icon">'
					. '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 3 21 3 21 9"></polyline><polyline points="9 21 3 21 3 15"></polyline><line x1="21" y1="3" x2="14" y2="10"></line><line x1="3" y1="21" x2="10" y2="14"></line></svg>'
					. '</span>';
			}

			if ( $show_caption && $caption ) {
				echo '<p class="aeafe-plus-item__caption">' . $caption . '</p>';
			}
			echo '</div>';
			echo $link_close;
			echo '</div>';
		}

		echo '</div>';

		if ( 'slider' === $layout ) {
			if ( $slider_nav ) {
				echo '<button class="aeafe-plus-slider-nav aeafe-plus-slider-nav--prev" aria-label="' . esc_attr__( 'Previous', 'allembed' ) . '">'
					. '<svg viewBox="0 0 24 24"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>'
					. '</button>';
				echo '<button class="aeafe-plus-slider-nav aeafe-plus-slider-nav--next" aria-label="' . esc_attr__( 'Next', 'allembed' ) . '">'
					. '<svg viewBox="0 0 24 24"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>'
					. '</button>';
			}
			if ( $slider_dots ) {
				echo '<div class="aeafe-plus-slider-dots"></div>';
			}
		}

		echo '</div>';
	}

	/**
	 * Build an admin-ajax.php proxy URL for a raw Google Photos image URL.
	 *
	 * @param string $google_url Raw Google Photos URL (may contain sizing suffix).
	 * @return string WordPress AJAX proxy URL.
	 */
	private function get_proxy_url( string $google_url ): string {
		if ( empty( $google_url ) ) {
			return '';
		}
		return add_query_arg(
			[ 'action' => 'aeafe_picker_proxy_image', 'url' => $google_url ],
			admin_url( 'admin-ajax.php' )
		);
	}
}