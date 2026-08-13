<?php
namespace AllEmebdAddon\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Elementor Gallery for Google Photos
 *
 * Elementor widget for displaying Google Photos via API.
 *
 * @since 1.0.0
 */
class google_photos_addon extends Widget_Base {

	public function get_name() {
		return 'google_photos';
	}

	public function get_title() {
		return esc_html__( 'Gallery for Google Photos', 'allembed' );
	}

	public function get_icon() {
		return 'bl_icon eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'AllEmbed' ];
	}

	private function get_album_options() {
		$options = [ '' => esc_html__( '— Select Album —', 'allembed' ) ];
		$api = \AEAFE_Google_Photos_API::instance();

		if ( ! $api->is_connected() ) {
			return $options;
		}

		$albums = get_transient( 'aeafe_gphoto_widget_albums' );
		if ( false === $albums ) {
			$albums = $api->get_all_albums();
			if ( ! is_wp_error( $albums ) ) {
				set_transient( 'aeafe_gphoto_widget_albums', $albums, HOUR_IN_SECONDS );
			}
		}

		if ( is_array( $albums ) && ! empty( $albums ) ) {
			foreach ( $albums as $album ) {
				$title = isset( $album['title'] ) ? $album['title'] : esc_html__( 'Untitled', 'allembed' );
				$count = isset( $album['mediaItemsCount'] ) ? ' (' . $album['mediaItemsCount'] . ')' : '';
				$options[ $album['id'] ] = $title . $count;
			}
		}

		return $options;
	}

	protected function _register_controls() {

		$api = \AEAFE_Google_Photos_API::instance();
		$is_connected = $api->is_connected();
		$settings_page_url = admin_url( 'admin.php?page=aeafe-google-photos' );

		// ========================
		// Source Settings
		// ========================
		$this->start_controls_section(
			'_section_google_photos_source',
			[
				'label' => __( 'Photo Source', 'allembed' ),
			]
		);

		if ( ! $is_connected ) {
			$this->add_control(
				'not_connected_notice',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw' => '<div style="padding:16px;background:#fff8f0;border:1px solid #fbd38d;border-radius:6px;color:#7b341e;font-size:12px;line-height:1.5;">' .
						'<div style="display:flex;align-items:center;gap:6px;font-weight:700;font-size:13px;margin-bottom:6px;color:#c05621;">' .
						'<span class="dashicons dashicons-warning" style="font-size:18px;width:18px;height:18px;"></span>' .
						esc_html__( 'Google Photos Not Connected', 'allembed' ) .
						'</div>' .
						'<p style="margin:0 0 12px 0;">' .
						esc_html__( 'Please configure your API credentials and connect your Google account in WordPress Admin settings.', 'allembed' ) .
						'</p>' .
						'<a href="' . esc_url( $settings_page_url ) . '" target="_blank" class="elementor-button elementor-button-default" style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;background:#93003f;color:#ffffff;border-radius:4px;text-decoration:none;font-weight:600;font-size:12px;">' .
						'<span class="dashicons dashicons-admin-generic" style="font-size:14px;width:14px;height:14px;"></span> ' .
						esc_html__( 'Configure API Credentials', 'allembed' ) . ' &rarr;' .
						'</a>' .
						'</div>',
				]
			);
		}

		$this->add_control(
			'source_type',
			[
				'label' => esc_html__( 'Photo Source', 'allembed' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'album',
				'options' => [
					'album'  => esc_html__( 'Specific Album', 'allembed' ),
					'recent' => esc_html__( 'Recent Photos', 'allembed' ),
				],
			]
		);

		$this->add_control(
			'album_id',
			[
				'label' => esc_html__( 'Select Album', 'allembed' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => $this->get_album_options(),
				'condition' => [
					'source_type' => 'album',
				],
			]
		);

		$this->add_control(
			'refresh_albums',
			[
				'type' => Controls_Manager::BUTTON,
				'label_block' => true,
				'text' => esc_html__( 'Refresh Albums List', 'allembed' ),
				'separator' => 'before',
				'event' => 'aeafe:refreshAlbums',
				'condition' => [
					'source_type' => 'album',
				],
			]
		);

		$this->add_control(
			'media_type',
			[
				'label' => esc_html__( 'Media Type', 'allembed' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'all',
				'options' => [
					'all'    => esc_html__( 'All Media', 'allembed' ),
					'PHOTO'  => esc_html__( 'Photos Only', 'allembed' ),
					'VIDEO'  => esc_html__( 'Videos Only', 'allembed' ),
				],
			]
		);

		$this->add_control(
			'photo_limit',
			[
				'label' => esc_html__( 'Max Photos', 'allembed' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 500,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
			]
		);

		$this->add_control(
			'thumbnail_size',
			[
				'label' => esc_html__( 'Thumbnail Size', 'allembed' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'w500-h500',
				'options' => [
					'w200-h200'   => esc_html__( 'Small (200x200)', 'allembed' ),
					'w300-h300'   => esc_html__( 'Medium (300x300)', 'allembed' ),
					'w500-h500'   => esc_html__( 'Large (500x500)', 'allembed' ),
					'w800-h800'   => esc_html__( 'XL (800x800)', 'allembed' ),
					'w1024-h768'  => esc_html__( 'HD Landscape (1024x768)', 'allembed' ),
					'w1280-h1280' => esc_html__( '2K Square (1280x1280)', 'allembed' ),
					'd'           => esc_html__( 'Full Original Quality', 'allembed' ),
				],
			]
		);

		$this->end_controls_section();

		// ========================
		// Layout Settings
		// ========================
		$this->start_controls_section(
			'_section_google_photos_layout',
			[
				'label' => __( 'Gallery Layout', 'allembed' ),
			]
		);

		$this->add_control(
			'layout',
			[
				'label' => esc_html__( 'Layout', 'allembed' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'grid',
				'options' => [
					'grid'      => esc_html__( 'Grid', 'allembed' ),
					'masonry'   => esc_html__( 'Masonry', 'allembed' ),
					'justified' => esc_html__( 'Justified', 'allembed' ),
				],
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label' => esc_html__( 'Columns', 'allembed' ),
				'type' => Controls_Manager::SELECT,
				'default' => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options' => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
					'7' => '7',
					'8' => '8',
				],
				'selectors' => [
					'{{WRAPPER}} .aeafe-gphoto-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
				],
				'condition' => [
					'layout!' => 'justified',
				],
			]
		);

		$this->add_control(
			'gap',
			[
				'label' => esc_html__( 'Gap Between Items', 'allembed' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .aeafe-gphoto-grid' => 'gap: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .aeafe-gphoto-masonry' => 'column-gap: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .aeafe-gphoto-masonry .aeafe-gphoto-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'aspect_ratio',
			[
				'label' => esc_html__( 'Aspect Ratio', 'allembed' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1/1',
				'options' => [
					'auto'     => esc_html__( 'Auto (Original)', 'allembed' ),
					'16/9'     => esc_html__( '16:9 Landscape', 'allembed' ),
					'4/3'      => esc_html__( '4:3 Horizontal', 'allembed' ),
					'3/2'      => esc_html__( '3:2 Photo', 'allembed' ),
					'1/1'      => esc_html__( '1:1 Square', 'allembed' ),
					'2/3'      => esc_html__( '2:3 Portrait', 'allembed' ),
					'3/4'      => esc_html__( '3:4 Vertical', 'allembed' ),
					'9/16'     => esc_html__( '9:16 Mobile', 'allembed' ),
				],
				'selectors' => [
					'{{WRAPPER}} .aeafe-gphoto-grid .aeafe-gphoto-item .aeafe-gphoto-img-wrap' => 'aspect-ratio: {{VALUE}};',
				],
				'condition' => [
					'layout' => 'grid',
				],
			]
		);

		$this->add_control(
			'object_fit',
			[
				'label' => esc_html__( 'Image Fit', 'allembed' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'cover',
				'options' => [
					'cover'   => esc_html__( 'Cover (Crop)', 'allembed' ),
					'contain' => esc_html__( 'Contain (Fit)', 'allembed' ),
				],
				'selectors' => [
					'{{WRAPPER}} .aeafe-gphoto-item img' => 'object-fit: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'row_height',
			[
				'label' => esc_html__( 'Max Row Height (px)', 'allembed' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 500,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 200,
				],
				'condition' => [
					'layout' => 'justified',
				],
			]
		);

		$this->end_controls_section();

		// ========================
		// Display Settings
		// ========================
		$this->start_controls_section(
			'_section_google_photos_display',
			[
				'label' => __( 'Display Options', 'allembed' ),
			]
		);

		$this->add_control(
			'show_captions',
			[
				'label' => esc_html__( 'Show Captions', 'allembed' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'allembed' ),
				'label_off' => esc_html__( 'No', 'allembed' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'caption_position',
			[
				'label' => esc_html__( 'Caption Position', 'allembed' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'hover',
				'options' => [
					'hover'  => esc_html__( 'Overlay on Hover', 'allembed' ),
					'always' => esc_html__( 'Overlay at Bottom (Always)', 'allembed' ),
					'below'  => esc_html__( 'Below Image', 'allembed' ),
				],
				'condition' => [
					'show_captions' => 'yes',
				],
			]
		);

		$this->add_control(
			'enable_lightbox',
			[
				'label' => esc_html__( 'Lightbox on Click', 'allembed' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'allembed' ),
				'label_off' => esc_html__( 'No', 'allembed' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'lazy_load',
			[
				'label' => esc_html__( 'Lazy Loading', 'allembed' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'allembed' ),
				'label_off' => esc_html__( 'No', 'allembed' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_video_icon',
			[
				'label' => esc_html__( 'Show Video Play Icon', 'allembed' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'allembed' ),
				'label_off' => esc_html__( 'No', 'allembed' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		// ========================
		// Style Tab - Image Style
		// ========================
		$this->start_controls_section(
			'_section_style_image',
			[
				'label' => __( 'Image', 'allembed' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'allembed' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .aeafe-gphoto-img-wrap, {{WRAPPER}} .aeafe-gphoto-item img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'selector' => '{{WRAPPER}} .aeafe-gphoto-img-wrap, {{WRAPPER}} .aeafe-gphoto-item img',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'image_shadow',
				'selector' => '{{WRAPPER}} .aeafe-gphoto-img-wrap',
			]
		);

		$this->start_controls_tabs( 'image_effects' );

		$this->start_controls_tab(
			'normal',
			[
				'label' => esc_html__( 'Normal', 'allembed' ),
			]
		);

		$this->add_control(
			'opacity_normal',
			[
				'label' => esc_html__( 'Opacity', 'allembed' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0.1,
						'max' => 1,
						'step' => 0.01,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .aeafe-gphoto-item img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_control(
			'grayscale_normal',
			[
				'label' => esc_html__( 'Grayscale (%)', 'allembed' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .aeafe-gphoto-item img' => 'filter: grayscale({{SIZE}}%);',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'hover',
			[
				'label' => esc_html__( 'Hover', 'allembed' ),
			]
		);

		$this->add_control(
			'opacity_hover',
			[
				'label' => esc_html__( 'Opacity', 'allembed' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0.1,
						'max' => 1,
						'step' => 0.01,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .aeafe-gphoto-item:hover img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_control(
			'grayscale_hover',
			[
				'label' => esc_html__( 'Grayscale (%)', 'allembed' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .aeafe-gphoto-item:hover img' => 'filter: grayscale({{SIZE}}%);',
				],
			]
		);

		$this->add_control(
			'zoom_hover',
			[
				'label' => esc_html__( 'Zoom (%)', 'allembed' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .aeafe-gphoto-item:hover img' => 'transform: scale(calc(1 + {{SIZE}}/100));',
				],
			]
		);

		$this->add_control(
			'transition_duration',
			[
				'label' => esc_html__( 'Transition (ms)', 'allembed' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 2000,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 300,
				],
				'selectors' => [
					'{{WRAPPER}} .aeafe-gphoto-item img' => 'transition: all {{SIZE}}ms ease;',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		// ========================
		// Style Tab - Overlay/Caption
		// ========================
		$this->start_controls_section(
			'_section_style_overlay',
			[
				'label' => __( 'Caption Overlay', 'allembed' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_captions' => 'yes',
				],
			]
		);

		$this->add_control(
			'overlay_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'allembed' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(0,0,0,0.7)',
				'selectors' => [
					'{{WRAPPER}} .aeafe-gphoto-caption' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'caption_color',
			[
				'label' => esc_html__( 'Text Color', 'allembed' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .aeafe-gphoto-caption' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'caption_typography',
				'selector' => '{{WRAPPER}} .aeafe-gphoto-caption',
			]
		);

		$this->add_control(
			'caption_padding',
			[
				'label' => esc_html__( 'Padding', 'allembed' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 8,
					'right' => 12,
					'bottom' => 8,
					'left' => 12,
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .aeafe-gphoto-caption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'caption_align',
			[
				'label' => esc_html__( 'Alignment', 'allembed' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'allembed' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'allembed' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'allembed' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .aeafe-gphoto-caption' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}

	private function get_photo_url( $media_item, $size = 'w500-h500' ) {
		$base_url = isset( $media_item['baseUrl'] ) ? $media_item['baseUrl'] : '';
		if ( empty( $base_url ) ) {
			return '';
		}
		if ( 'd' === $size ) {
			return $base_url . '=d';
		}
		return $base_url . '=' . $size;
	}

	private function is_video( $media_item ) {
		return isset( $media_item['mediaMetadata']['video'] );
	}

	private function fetch_photos( $settings ) {
		$api = \AEAFE_Google_Photos_API::instance();

		if ( ! $api->is_connected() ) {
			return [];
		}

		$source = $settings['source_type'];
		$limit = isset( $settings['photo_limit']['size'] ) ? intval( $settings['photo_limit']['size'] ) : 50;

		if ( 'recent' === $source ) {
			$photos = $api->get_recent_photos( $limit );
		} else {
			$album_id = isset( $settings['album_id'] ) ? $settings['album_id'] : '';
			if ( empty( $album_id ) ) {
				return [];
			}
			$photos = $api->get_album_photos( $album_id, $limit );
		}

		if ( is_wp_error( $photos ) ) {
			return [];
		}

		$media_type = isset( $settings['media_type'] ) ? $settings['media_type'] : 'all';
		if ( 'all' !== $media_type ) {
			$photos = array_filter( $photos, function( $item ) use ( $media_type ) {
				$is_video = isset( $item['mediaMetadata']['video'] );
				if ( 'VIDEO' === $media_type ) {
					return $is_video;
				}
				return ! $is_video;
			} );
		}

		return $photos;
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$api = \AEAFE_Google_Photos_API::instance();

		if ( ! $api->is_connected() ) {
			$settings_page_url = admin_url( 'admin.php?page=aeafe-google-photos' );
			?>
			<div class="aeafe-gphoto-not-connected-wrap" style="padding:28px 24px;background:#fff8f0;border:1px solid #fbd38d;border-radius:8px;text-align:center;max-width:520px;margin:20px auto;box-shadow:0 1px 3px rgba(0,0,0,0.05);">
				<div style="font-size:32px;margin-bottom:10px;">📷</div>
				<h3 style="margin:0 0 8px;font-size:17px;color:#7b341e;font-weight:600;">
					<?php esc_html_e( 'Google Photos Not Connected', 'allembed' ); ?>
				</h3>
				<p style="margin:0 0 16px;color:#7b341e;font-size:13px;line-height:1.5;">
					<?php esc_html_e( 'Please configure your Google Photos API credentials and connect your account in the WordPress Admin dashboard.', 'allembed' ); ?>
				</p>
				<a href="<?php echo esc_url( $settings_page_url ); ?>" target="_blank" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#93003f;color:#ffffff;border-radius:4px;text-decoration:none;font-weight:600;font-size:13px;">
					<span class="dashicons dashicons-admin-generic" style="font-size:15px;width:15px;height:15px;"></span>
					<?php esc_html_e( 'Configure API Credentials', 'allembed' ); ?> &rarr;
				</a>
			</div>
			<?php
			return;
		}

		$photos = $this->fetch_photos( $settings );

		if ( empty( $photos ) ) {
			$source = $settings['source_type'];
			if ( 'album' === $source && empty( $settings['album_id'] ) ) {
				echo '<div style="text-align:center;color:#646970;padding:30px;background:#f6f7f7;border-radius:6px;border:1px dashed #dcdcde;">' .
					esc_html__( 'Please select a Google Photos album in the widget setting panel.', 'allembed' ) .
					'</div>';
			} else {
				echo '<div style="text-align:center;color:#646970;padding:30px;background:#f6f7f7;border-radius:6px;border:1px dashed #dcdcde;">' .
					esc_html__( 'No photos found in the selected album or source.', 'allembed' ) .
					'</div>';
			}
			return;
		}

		$layout = $settings['layout'];
		$show_captions = 'yes' === $settings['show_captions'];
		$caption_position = isset( $settings['caption_position'] ) ? $settings['caption_position'] : 'hover';
		$enable_lightbox = 'yes' === $settings['enable_lightbox'];
		$lazy_load = 'yes' === $settings['lazy_load'];
		$show_video_icon = 'yes' === ( $settings['show_video_icon'] ?? 'yes' );
		$thumbnail_size = isset( $settings['thumbnail_size'] ) ? $settings['thumbnail_size'] : 'w500-h500';

		$gap = isset( $settings['gap']['size'] ) ? intval( $settings['gap']['size'] ) : 10;
		$row_height = isset( $settings['row_height']['size'] ) ? intval( $settings['row_height']['size'] ) : 200;

		$widget_id = 'aeafe-gphoto-' . $this->get_id();

		$wrapper_class = 'aeafe-gphoto-gallery aeafe-gphoto-' . esc_attr( $layout );
		if ( 'grid' === $layout ) {
			$wrapper_class .= ' aeafe-gphoto-grid';
		} elseif ( 'masonry' === $layout ) {
			$wrapper_class .= ' aeafe-gphoto-masonry';
		} elseif ( 'justified' === $layout ) {
			$wrapper_class .= ' aeafe-gphoto-justified';
		}

		if ( $show_captions ) {
			$wrapper_class .= ' aeafe-caption-' . esc_attr( $caption_position );
		}

		$lazy_attr = $lazy_load ? ' loading="lazy"' : '';

		?>
		<div id="<?php echo esc_attr( $widget_id ); ?>" class="<?php echo esc_attr( $wrapper_class ); ?>">
			<?php foreach ( $photos as $photo ) :
				$thumb_url = $this->get_photo_url( $photo, $thumbnail_size );
				$full_url = $this->get_photo_url( $photo, 'w1920-h1080' );
				$filename = isset( $photo['filename'] ) ? $photo['filename'] : '';
				$is_video = $this->is_video( $photo );

				if ( 'justified' === $layout ) {
					$meta = isset( $photo['mediaMetadata'] ) ? $photo['mediaMetadata'] : [];
					$w = isset( $meta['width'] ) ? intval( $meta['width'] ) : 400;
					$h = isset( $meta['height'] ) ? intval( $meta['height'] ) : 400;
					$aspect = ( $w > 0 && $h > 0 ) ? ( $w / $h ) : 1;
				}
				?>
				<div class="aeafe-gphoto-item<?php echo $is_video ? ' is-video' : ''; ?>"
					<?php if ( 'justified' === $layout && isset( $aspect ) ) : ?>
					style="flex: <?php echo esc_attr( $aspect ); ?> 1 <?php echo esc_attr( $row_height * $aspect ); ?>px;"
					<?php endif; ?>>
					<div class="aeafe-gphoto-img-wrap">
						<?php if ( $enable_lightbox ) : ?>
							<a href="<?php echo esc_url( $full_url ); ?>"
							   class="aeafe-gphoto-lightbox"
							   data-caption="<?php echo esc_attr( $filename ); ?>"
							   data-fancybox="gallery-<?php echo esc_attr( $widget_id ); ?>"
							   target="_blank" rel="noopener noreferrer">
								<img src="<?php echo esc_url( $thumb_url ); ?>"
									 alt="<?php echo esc_attr( $filename ); ?>"
									 <?php echo wp_kses_post( $lazy_attr ); ?> />
								<?php if ( $is_video && $show_video_icon ) : ?>
									<span class="aeafe-gphoto-video-icon">
										<svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
									</span>
								<?php endif; ?>
							</a>
						<?php else : ?>
							<img src="<?php echo esc_url( $thumb_url ); ?>"
								 alt="<?php echo esc_attr( $filename ); ?>"
								 <?php echo wp_kses_post( $lazy_attr ); ?> />
							<?php if ( $is_video && $show_video_icon ) : ?>
								<span class="aeafe-gphoto-video-icon">
									<svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
								</span>
							<?php endif; ?>
						<?php endif; ?>

						<?php if ( $show_captions && ! empty( $filename ) && 'below' !== $caption_position ) : ?>
							<div class="aeafe-gphoto-caption"><?php echo esc_html( $filename ); ?></div>
						<?php endif; ?>
					</div>

					<?php if ( $show_captions && ! empty( $filename ) && 'below' === $caption_position ) : ?>
						<div class="aeafe-gphoto-caption aeafe-caption-below"><?php echo esc_html( $filename ); ?></div>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>

		<style type="text/css">
			#<?php echo esc_html( $widget_id ); ?>.aeafe-gphoto-grid {
				display: grid;
			}
			#<?php echo esc_html( $widget_id ); ?>.aeafe-gphoto-masonry {
				column-count: <?php echo esc_html( $settings['columns'] ?? 3 ); ?>;
			}
			@media (max-width: 1024px) {
				#<?php echo esc_html( $widget_id ); ?>.aeafe-gphoto-masonry {
					column-count: <?php echo esc_html( $settings['columns_tablet'] ?? 2 ); ?>;
				}
			}
			@media (max-width: 767px) {
				#<?php echo esc_html( $widget_id ); ?>.aeafe-gphoto-masonry {
					column-count: <?php echo esc_html( $settings['columns_mobile'] ?? 1 ); ?>;
				}
			}
			#<?php echo esc_html( $widget_id ); ?>.aeafe-gphoto-masonry .aeafe-gphoto-item {
				break-inside: avoid;
				page-break-inside: avoid;
			}
			#<?php echo esc_html( $widget_id ); ?>.aeafe-gphoto-justified {
				display: flex;
				flex-wrap: wrap;
				gap: <?php echo esc_html( $gap ); ?>px;
			}
			#<?php echo esc_html( $widget_id ); ?>.aeafe-gphoto-justified .aeafe-gphoto-item {
				height: <?php echo esc_html( $row_height ); ?>px;
				flex-grow: 1;
			}
			#<?php echo esc_html( $widget_id ); ?>.aeafe-gphoto-justified .aeafe-gphoto-img-wrap,
			#<?php echo esc_html( $widget_id ); ?>.aeafe-gphoto-justified img {
				height: 100%;
				min-width: 100%;
				object-fit: cover;
			}
		</style>
		<?php

		$this->render_gallery_css();
		$this->maybe_enqueue_lightbox( $enable_lightbox );
	}

	private function render_gallery_css() {
		?>
		<style type="text/css">
			.aeafe-gphoto-gallery .aeafe-gphoto-img-wrap {
				position: relative;
				overflow: hidden;
				width: 100%;
			}
			.aeafe-gphoto-gallery .aeafe-gphoto-img-wrap img {
				width: 100%;
				height: 100%;
				display: block;
			}
			.aeafe-gphoto-gallery .aeafe-gphoto-video-icon {
				position: absolute;
				top: 50%;
				left: 50%;
				transform: translate(-50%, -50%);
				width: 48px;
				height: 48px;
				background: rgba(0,0,0,0.6);
				border-radius: 50%;
				color: #fff;
				display: flex;
				align-items: center;
				justify-content: center;
				pointer-events: none;
				transition: transform 0.2s ease, background 0.2s ease;
			}
			.aeafe-gphoto-item:hover .aeafe-gphoto-video-icon {
				background: rgba(0,0,0,0.8);
				transform: translate(-50%, -50%) scale(1.1);
			}
			.aeafe-gphoto-gallery .aeafe-gphoto-video-icon svg {
				width: 24px;
				height: 24px;
				margin-left: 3px;
			}
			.aeafe-gphoto-gallery .aeafe-gphoto-caption {
				font-size: 13px;
				line-height: 1.4;
				word-wrap: break-word;
			}
			.aeafe-caption-hover .aeafe-gphoto-caption {
				position: absolute;
				bottom: 0;
				left: 0;
				right: 0;
				opacity: 0;
				transform: translateY(100%);
				transition: all 0.3s ease;
			}
			.aeafe-caption-hover .aeafe-gphoto-item:hover .aeafe-gphoto-caption {
				opacity: 1;
				transform: translateY(0);
			}
			.aeafe-caption-always .aeafe-gphoto-caption {
				position: absolute;
				bottom: 0;
				left: 0;
				right: 0;
			}
			.aeafe-caption-below .aeafe-caption-below {
				margin-top: 6px;
				color: #2c3338;
			}
			.aeafe-gphoto-gallery .aeafe-gphoto-lightbox {
				display: block;
				width: 100%;
				height: 100%;
			}
		</style>
		<?php
	}

	private function maybe_enqueue_lightbox( $enabled ) {
		if ( ! $enabled ) {
			return;
		}
		wp_enqueue_style( 'aeafe-fancybox', AEAFE_DIR_URL . 'assets/css/fancybox.css', [], '5.0.0' );
		wp_enqueue_script( 'aeafe-fancybox', AEAFE_DIR_URL . 'assets/js/fancybox.umd.js', [ 'jquery' ], '5.0.0', true );
	}
}
