<?php
namespace AllEmebdAddon;
use AllEmebdAddon\Widgets\youtube_addon;
use AllEmebdAddon\Widgets\vimeo_addon;
use AllEmebdAddon\Widgets\soundcloud_addon;
use AllEmebdAddon\Widgets\invison_addon;
use AllEmebdAddon\Widgets\jotform_addon;
use AllEmebdAddon\Widgets\google_addon;
use AllEmebdAddon\Widgets\appointly_addon;
use AllEmebdAddon\Widgets\spotify_addon;
use AllEmebdAddon\Widgets\giphy_addon;
use AllEmebdAddon\Widgets\imgur_addon;
use AllEmebdAddon\Widgets\slideshare_addon;
use AllEmebdAddon\Widgets\codepen_addon;
use AllEmebdAddon\Widgets\twitch_addon;
use AllEmebdAddon\Widgets\twitframe_addon;
use AllEmebdAddon\Widgets\bandcamp_addon;
use AllEmebdAddon\Widgets\dailymotion_addon;
use AllEmebdAddon\Widgets\dartfish_addon;
use AllEmebdAddon\Widgets\creddle_addon;
use AllEmebdAddon\Widgets\genial_addon;
use AllEmebdAddon\Widgets\Sirv_addon;
use AllEmebdAddon\Widgets\mixcloud_addon;
use AllEmebdAddon\Widgets\kuula_addon;
use AllEmebdAddon\Widgets\facebook_addon;
use AllEmebdAddon\Widgets\pinterest_addon;
use AllEmebdAddon\Widgets\linkedin_addon;
use AllEmebdAddon\Widgets\reddit_addon;
/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.2.0
 */
class allembed_Addon {

	/**
	 * Instance
	 *
	 * @since 1.2.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}



	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since 1.2.0
	 * @access private
	 */
	private function include_widgets_files() {

		$active_widgets = (array) get_option( 'aeafeGetBlocks', [] );
		if(empty($active_widgets)) {
			$active_widgets = ['default_list'];
		}

		if ( !in_array( 'bae_youtube_addon', $active_widgets, true ) ) {
			require_once( __DIR__ . '/widgets/youtube_addon.php' );
		}
		if ( !in_array( 'bae_vimeo_addon', $active_widgets, true ) ) {
			require_once( __DIR__ . '/widgets/vimeo_addon.php' );
		}
		if ( !in_array( 'bae_soundcloud', $active_widgets, true ) ) {
			require_once( __DIR__ . '/widgets/soundcloud.php' );
		}
		if ( !in_array( 'bae_invison', $active_widgets, true ) ) {
			require_once( __DIR__ . '/widgets/invison.php' );
		}
		if ( !in_array( 'bae_jotform', $active_widgets, true ) ) {
			require_once( __DIR__ . '/widgets/jotform.php' );
		}
		if ( !in_array( 'bae_google_map', $active_widgets, true ) ) {
			require_once( __DIR__ . '/widgets/google-map.php' );
		}
		if ( !in_array( 'bae_appointly', $active_widgets, true ) ) {
			require_once( __DIR__ . '/widgets/appointly.php' );
		}
		if ( !in_array( 'bae_spotify', $active_widgets, true ) ) {
			require_once( __DIR__ . '/widgets/spotify.php' );
		}
		if ( !in_array( 'bae_giphy', $active_widgets, true ) ) {
			require_once( __DIR__ . '/widgets/giphy.php' );
		}
		if ( !in_array( 'bae_imgur', $active_widgets, true ) ) {
			require_once( __DIR__ . '/widgets/imgur.php' );
		}
		if ( !in_array( 'bae_slideshare', $active_widgets, true ) ) {
			require_once( __DIR__ . '/widgets/slideshare.php' );
		}
		if ( !in_array( 'bae_codepen', $active_widgets, true ) ) {
			require_once( __DIR__ . '/widgets/codepen.php' );
		}
		if ( !in_array( 'bae_twitch', $active_widgets, true ) ) {
			require_once( __DIR__ . '/widgets/twitch.php' );
		}
		if ( !in_array( 'bae_twitframe', $active_widgets, true ) ) {
			require_once( __DIR__ . '/widgets/twitframe.php' );
		}
		if ( !in_array( 'bae_bandcamp', $active_widgets, true ) ) {
			require_once( __DIR__ . '/widgets/bandcamp.php' );
		}
		if ( !in_array( 'bae_dailymotion', $active_widgets, true ) ) {
			require_once( __DIR__ . '/widgets/dailymotion.php' );
		}
		if ( !in_array( 'bae_dartfish', $active_widgets, true ) ) {
			require_once( __DIR__ . '/widgets/dartfish.php' );
		}
		if ( !in_array( 'bae_genial', $active_widgets, true ) ) {
			require_once( __DIR__ . '/widgets/genial.php' );
		}
		if ( !in_array( 'bae_sirv', $active_widgets, true ) ) {
			require_once( __DIR__ . '/widgets/Sirv.php' );
		}
		if ( !in_array( 'bae_mixcloud', $active_widgets, true ) ) {
			require_once( __DIR__ . '/widgets/mixcloud.php' );
		}
		if ( !in_array( 'bae_kuula', $active_widgets, true ) ) {
			require_once( __DIR__ . '/widgets/kuula.php' );
		}
		if ( !in_array( 'bae_facebook', $active_widgets, true ) ) {
			require_once( __DIR__ . '/widgets/facebook.php' );
		}
		if ( !in_array( 'bae_pinterest', $active_widgets, true ) ) {
			require_once( __DIR__ . '/widgets/pinterest.php' );
		}
		if ( !in_array( 'bae_linkedin', $active_widgets, true ) ) {
			require_once( __DIR__ . '/widgets/linkedin.php' );
		}
		if ( !in_array( 'bae_reddit', $active_widgets, true ) ) {
			require_once( __DIR__ . '/widgets/reddit.php' );
		}
	}

	public function widget_styles(){

		wp_register_style("main-css",plugins_url("/assets/css/styler.css",__FILE__));
		wp_enqueue_style( 'main-css' );
	}


	//editor scripts
	function editor_scripts() {
		wp_register_style("my-style",plugins_url("/assets/css/style.css",__FILE__));
		wp_enqueue_style( 'my-style' );
	}
	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function register_widgets() {
		// Its is now safe to include Widgets files
		$this->include_widgets_files();
		// Register Widgets
		$active_widgets = get_option( 'aeafeGetBlocks', [] );

		if(empty($active_widgets)) {
			$active_widgets = ['default_list'];
		}

		if ( !in_array( 'bae_youtube_addon', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\youtube_addon() );
		}
		if ( !in_array( 'bae_vimeo_addon', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\vimeo_addon() );
		}
		if ( !in_array( 'bae_soundcloud', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\soundcloud_addon() );
		}
		if ( !in_array( 'bae_invison', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\invison_addon() );
		}
		if ( !in_array( 'bae_jotform', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\jotform_addon() );
		}
		if ( !in_array( 'bae_google_map', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\google_addon() );
		}
		if ( !in_array( 'bae_appointly', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\appointly_addon() );
		}
		if ( !in_array( 'bae_spotify', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\spotify_addon() );
		}
		if ( !in_array( 'bae_giphy', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\giphy_addon() );
		}
		if ( !in_array( 'bae_imgur', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\imgur_addon() );
		}
		if ( !in_array( 'bae_slideshare', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\slideshare_addon() );
		}
		if ( !in_array( 'bae_codepen', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\codepen_addon() );
		}
		if ( !in_array( 'bae_twitch', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\twitch_addon() );
		}
		if ( !in_array( 'bae_twitframe', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\twitframe_addon() );
		}
		if ( !in_array( 'bae_bandcamp', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\bandcamp_addon() );
		}
		if ( !in_array( 'bae_dailymotion', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\dailymotion_addon() );
		}
		if ( !in_array( 'bae_dartfish', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\dartfish_addon() );
		}
		if ( !in_array( 'bae_genial', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\genial_addon() );
		}
		if ( !in_array( 'bae_sirv', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Sirv_addon() );
		}
		if ( !in_array( 'bae_mixcloud', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\mixcloud_addon() );
		}
		if ( !in_array( 'bae_kuula', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\kuula_addon() );
		}
		if ( !in_array( 'bae_facebook', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\facebook_addon() );
		}
		if ( !in_array( 'bae_pinterest', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\pinterest_addon() );
		}
		if ( !in_array( 'bae_linkedin', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\linkedin_addon() );
		}
		if ( !in_array( 'bae_reddit', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\reddit_addon() );
		}
	}
	//category registered
	public function add_elementor_widget_categories( $elements_manager ) {

		$elements_manager->add_category(
			'AllEmbed',
			[
				'title' => __('All Embed For Elementor', 'allembed' ),
				'icon' => 'fa fa-plug',
			]
		);
	}
	
	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function __construct() {

		// Enqueue widget styles
        add_action( 'elementor/frontend/after_register_styles', [ $this, 'widget_styles' ] , 100 );
        add_action( 'admin_enqueue_scripts', [ $this, 'widget_styles' ] , 100 );

		// Register widgets
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );

		//category registered
		add_action( 'elementor/elements/categories_registered',  [ $this,'add_elementor_widget_categories' ]);
		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'editor_scripts' ] );
	}
	
}
allembed_Addon::instance();


