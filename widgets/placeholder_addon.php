<?php
namespace AllEmebdAddon\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit;

class Locked_Heading_Widget extends \Elementor\Widget_Base {
    public function get_name() { return 'locked-menu'; } // Changed to match your "Locked Menu"
    public function get_title() { return 'Locked Menu (Placeholder)'; }
    public function get_icon() { return 'eicon-lock'; }
    public function get_categories() { return ['general']; }
    public function get_keywords() { return ['menu', 'locked', 'placeholder']; }
    public function has_widget_inner_wrapper(): bool {
		return false;
	}
    protected function get_upsale_data() {
		return [
			'condition' => ! \Elementor\Utils::has_pro(),
			'image' => esc_url( ELEMENTOR_ASSETS_URL . 'images/go-pro.svg' ),
			'image_alt' => esc_attr__( 'Upgrade', 'allembed' ),
			'title' => esc_html__( 'Promotion heading', 'allembed' ),
			'description' => esc_html__( 'Get the premium version of the widget and grow your website capabilities.', 'allembed' ),
			'upgrade_url' => esc_url( 'https://example.com/upgrade-to-pro/' ),
			'upgrade_text' => esc_html__( 'Upgrade Now', 'allembed' ),
		];
	}

    private function is_pro_active() {
        // Simulate license check
        return false; // Locked by default
    }

    protected function register_controls() {
        $this->start_controls_section('placeholder_section', ['label' => 'Placeholder Info']);
        $this->add_control('info', [
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw' => '<p>This is a placeholder for the Pro Menu widget. Upgrade to unlock.</p>',
            'condition' => ['pro_active' => 'no'],
        ]);
        $this->end_controls_section();
    }

    protected function render() {
        // Render logic for the canvas (optional, can reuse _content_template logic)
        $this->add_render_attribute( 'wrapper', 'class', 'my-custom-class' );

        ?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            <p>My Custom Widget Content</p>
        </div>
        <?php
    }

    public function render_plain_content() {
        echo 'Locked Menu Widget (Upgrade to Pro)';
    }
}