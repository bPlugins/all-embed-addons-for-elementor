<?php
/**
 * Plugin Name: All Embed Addons for elementor
 * Description: Collection of All types of Embed  files such as  YouTube, Vimeo and more....
 * Version:     1.1.4
 * Author:      bPlugins
 * Author URI:  https://bPlugins.com
 * Text Domain: allembed
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( function_exists( 'aeafe_fs' ) ) {
        aeafe_fs()->set_basename( true, __FILE__ );
} else {
	define('AEAFE_VERSION', isset($_SERVER['HTTP_HOST']) && 'localhost' === $_SERVER['HTTP_HOST'] ? time() : '1.1.4');
	define('AEAFE_DIR_URL', plugin_dir_url(__FILE__));
	define('AEAFE_DIR_PATH', plugin_dir_path(__FILE__));
	define('AEAFE_HAS_PRO', plugin_basename( __FILE__ ) === "all-embed-addons-for-elementor-pro/all-embed.php");

	if ( ! function_exists( 'aeafe_fs' ) ) {
		// Create a helper function for easy SDK access.
		function aeafe_fs() {
			global $aeafe_fs;

			if ( ! isset( $aeafe_fs ) ) {
				// Include Freemius SDK.
				require_once dirname( __FILE__ ) . '/freemius/start.php';
				$aeafe_fs = fs_dynamic_init( array(
					'id'                  => '21017',
					'slug'                => 'all-embed-addons-for-elementor',
					'premium_slug'        => 'all-embed-addons-for-elementor-pro',
					'type'                => 'plugin',
					'public_key'          => 'pk_403fb9d96b1dd70da1ebcfb4851c2',
					'is_premium'          => true,
					'premium_suffix'      => 'Pro',
					// If your plugin is a serviceware, set this option to false.
					'has_premium_version' => true,
					'has_addons'          => false,
					'has_paid_plans'      => true,
					// Automatically removed in the free version. If you're not using the
					// auto-generated free version, delete this line before uploading to wp.org.
					'wp_org_gatekeeper'   => 'OA7#BoRiBNqdf52FvzEf!!074aRLPs8fspif$7K1#4u4Csys1fQlCecVcUTOs2mcpeVHi#C2j9d09fOTvbC0HloPT7fFee5WdS3G',
					'menu'                => array(
						'slug'           => 'all-embed-addons-for-elementor',
						'first-path'     => 'admin.php?page=all-embed-addons-for-elementor',
					),
				) );
			}

			return $aeafe_fs;
		}

		// Init Freemius.
		aeafe_fs();
		// Signal that SDK was initiated.
		do_action( 'aeafe_fs_loaded' );

	}

	function aeafeIsPremium() {
		return AEAFE_HAS_PRO ? aeafe_fs()->can_use_premium_code() : false;
	}

	/**
	 * Main allembed wp Class
	 *
	 * The init class that runs the Hello World plugin.
	 * Intended To make sure that the plugin's minimum requirements are met.
	 *
	 * You should only modify the constants to match your plugin's needs.
	 *
	 * Any custom code should go inside Plugin Class in the plugin.php file.
	 */

	final class allembed_main_element {

		/**
		 * Plugin Version
		 *
		 * @since 1.2.0
		 * @var string The plugin version.
		 */
		const VERSION = '1.1.4';

		/**
		 * Minimum Elementor Version
		 *
		 * @since 1.2.0
		 * @var string Minimum Elementor version required to run the plugin.
		 */
		const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

		/**
		 * Minimum PHP Version
		 *
		 * @since 1.2.0
		 * @var string Minimum PHP version required to run the plugin.
		 */
		const MINIMUM_PHP_VERSION = '7.0';

		/**
		 * Constructor
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function __construct() {

			// Load translation
			add_action( 'init', array( $this, 'i18n' ) );

			// Init Plugin
			add_action( 'plugins_loaded', array( $this, 'init' ) );
			add_action( 'admin_enqueue_scripts', [ $this, 'b_enqueue_admin_style_scripts' ] );
			add_action( 'wp_ajax_allembed_install_plugin', [ $this, 'b_allembed_install_plugin' ] );
			add_action( 'wp_ajax_allembed_activate_plugin', [ $this, 'b_allembed_activate_plugin' ] );
		}

		/**
		 * Load Textdomain
		 *
		 * Load plugin localization files.
		 * Fired by `init` action hook.
		 *
		 * @since 1.2.0
		 * @access public
		 */
		public function i18n() {
			load_plugin_textdomain( 'allembed', false, dirname( __FILE__ ) . "/languages" );
		}

		/**
		 * Initialize the plugin
		 *
		 * Validates that Elementor is already loaded.
		 * Checks for basic plugin requirements, if one check fail don't continue,
		 * if all check have passed include the plugin class.
		 *
		 * Fired by `plugins_loaded` action hook.
		 *
		 * @since 1.2.0
		 * @access public
		 */
		public function init() {

			// Check if Elementor installed and activated
			if ( ! did_action( 'elementor/loaded' ) ) {
				add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
				return;
			}

			// Check for required Elementor version
			if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
				add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
				return;
			}

			// Check for required PHP version
			if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
				add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
				return;
			}
			// Once we get here, We have passed all validation checks so we can safely include our plugin
			require_once( 'plugin.php' );
		}

		/**
		 * Admin notice
		 *
		 * Warning when the site doesn't have Elementor installed or activated.
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function admin_notice_missing_main_plugin() {
			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}

			$plugin_file = 'elementor/elementor.php';

			// Elementor installed?
			$installed = file_exists( WP_PLUGIN_DIR . '/' . $plugin_file );

			// Elementor active?
			$active = is_plugin_active( $plugin_file );

			echo '<div class="notice notice-warning is-dismissible">';
			echo '<p>' . esc_html__( '"Media Player Addon" requires "Elementor" to be installed and activated.', 'allembed' ) . '</p>';

			if ( ! $installed ) {
				echo '<p><button class="button button-primary" id="allembed-install-elementor">' . esc_html__( 'Install Elementor', 'allembed' ) . '</button></p>';
			} elseif ( ! $active ) {
				echo '<p><button class="button button-primary" id="allembed-activate-elementor">' . esc_html__( 'Activate Elementor', 'allembed' ) . '</button></p>';
			}
			echo '</div>';
		}

		public function b_enqueue_admin_style_scripts() {
			wp_enqueue_script(
				'allembed-plugin-install',
				plugin_dir_url( __FILE__ ) . 'assets/js/plugin-install.js',
				[ 'jquery' ],
				'1.0',
				true
			);
			wp_localize_script( 'allembed-plugin-install', 'allembedInstall', [
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'allembed_install_plugin' ),
			]);
		}

		/**
		 * Admin notice
		 *
		 * Warning when the site doesn't have a minimum required Elementor version.
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function admin_notice_minimum_elementor_version() {
			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}

			$message = sprintf(
				/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
				esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'allembed' ),
				'<strong>' . esc_html__( 'unlimited addon', 'allembed' ) . '</strong>',
				'<strong>' . esc_html__( 'Elementor', 'allembed' ) . '</strong>',
				self::MINIMUM_ELEMENTOR_VERSION
			);

			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
		}

		/**
		 * Admin notice
		 *
		 * Warning when the site doesn't have a minimum required PHP version.
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function admin_notice_minimum_php_version() {
			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}

			$message = sprintf(
				/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
				esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'allembed' ),
				'<strong>' . esc_html__( 'venus wp', 'allembed' ) . '</strong>',
				'<strong>' . esc_html__( 'PHP', 'allembed' ) . '</strong>',
				self::MINIMUM_PHP_VERSION
			);

			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
		}

		public function b_allembed_install_plugin() {
			if ( ! current_user_can( 'install_plugins' ) || ! check_ajax_referer( 'allembed_install_plugin', 'nonce', false ) ) {
				wp_send_json_error( 'Unauthorized' );
			}

			include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
			include_once ABSPATH . 'wp-admin/includes/plugin-install.php';
			include_once ABSPATH . 'wp-admin/includes/file.php';
			include_once ABSPATH . 'wp-admin/includes/misc.php';

			$plugin_slug = 'elementor';
			$api = plugins_api( 'plugin_information', [ 'slug' => $plugin_slug, 'fields' => [ 'sections' => false ] ] );
			if ( is_wp_error( $api ) ) {
				wp_send_json_error( $api->get_error_message() );
			}

			$upgrader = new Plugin_Upgrader( new Automatic_Upgrader_Skin() );
			$result = $upgrader->install( $api->download_link );

			if ( is_wp_error( $result ) ) {
				wp_send_json_error( $result->get_error_message() );
			}

			wp_send_json_success( 'Elementor installed successfully! Please activate it.' );
		}

		public function b_allembed_activate_plugin() {
			if ( ! current_user_can( 'activate_plugins' ) || ! check_ajax_referer( 'allembed_install_plugin', 'nonce', false ) ) {
				wp_send_json_error( 'Unauthorized' );
			}

			include_once ABSPATH . 'wp-admin/includes/plugin.php';

			$plugin = 'elementor/elementor.php';
			$result = activate_plugin( $plugin );

			if ( is_wp_error( $result ) ) {
				wp_send_json_error( $result->get_error_message() );
			}

			wp_send_json_success( 'Elementor activated successfully!' );
		}

	}

	require_once('AEAFEAdminMenu.php');
	// Instantiate allembed_main_element.
	new allembed_main_element();
}

