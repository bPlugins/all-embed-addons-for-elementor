<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'AEAFEAdminMenu' ) ) {

	/**
	 * Admin Menu handler for All Embed Addons.
	 */
	class AEAFEAdminMenu {

		/**
		 * Constructor.
		 */
		public function __construct() {
			add_action( 'admin_menu', [ $this, 'aeafeAdminMenu' ] );
			add_action( 'admin_enqueue_scripts', [ $this, 'aeafeAdminEnqueueScripts' ] );
			add_action( 'wp_ajax_bptbGetBlocks', [ $this, 'aeafeGetBlocks' ] );
			add_action( 'admin_head', [ $this, 'aeafeIconImgSizeStyle' ] );
		}

		/**
		 * Style admin menu icon.
		 */
		public function aeafeIconImgSizeStyle() {
			echo '
			<style>
				#toplevel_page_all-embed-addons-for-elementor .wp-menu-image img {
					width: 20px !important;
					height: 20px !important;
					object-fit: contain;
				}
			</style>';
		}

		/**
		 * Register admin menus and submenus.
		 */
		public function aeafeAdminMenu() {
			$menu_icon = plugins_url( 'assets/img/dashicon.png', __FILE__ );

			add_menu_page(
				__( 'All Embed Addons by bPlugins', 'allembed' ),
				__( 'All Embed Addons', 'allembed' ),
				'manage_options',
				'all-embed-addons-for-elementor',
				'',
				$menu_icon,
				22
			);

			add_submenu_page(
				'all-embed-addons-for-elementor',
				__( 'Dashboard - All Embed Addons by bPlugins', 'allembed' ),
				__( 'Dashboard', 'allembed' ),
				'manage_options',
				'all-embed-addons-for-elementor',
				[ $this, 'aeafeRenderDashboardPage' ],
				0
			);

			add_submenu_page(
				'all-embed-addons-for-elementor',
				__( 'API Credentials - All Embed Addons', 'allembed' ),
				__( 'API Credentials', 'allembed' ),
				'manage_options',
				'aeafe-google-photos',
				[ $this, 'render_api_credentials_page' ],
				10
			);
		}

		/**
		 * Render the API Credentials settings page.
		 */
		public function render_api_credentials_page() {
			if ( class_exists( 'AEAFE_API_Credentials' ) ) {
				AEAFE_API_Credentials::instance()->render_page();
			}
		}

		/**
		 * Backward-compatibility wrapper for legacy method name.
		 */
		public function render_google_photos_settings_page() {
			$this->render_api_credentials_page();
		}

		/**
		 * AJAX handler for block list toggle data.
		 */
		public function aeafeGetBlocks() {
			$nonce = sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ?? '' ) );

			if ( ! wp_verify_nonce( $nonce, 'bptb_admin_nonce' ) ) {
				wp_send_json_error( 'Invalid Request' );
			}

			$data    = isset( $_POST['data'] ) ? json_decode( stripslashes( sanitize_text_field( wp_unslash( $_POST['data'] ) ) ), true ) : null;
			$db_data = get_option( 'aeafeGetBlocks', [] );

			if ( ! isset( $data ) && $db_data ) {
				wp_send_json_success( $db_data );
			}

			update_option( 'aeafeGetBlocks', $data );
			wp_send_json_success( $data );
		}

		/**
		 * Render React Dashboard container page.
		 */
		public function aeafeRenderDashboardPage() { ?>
			<div
				id='mpafebDashboard'
				data-info='<?php echo esc_attr( wp_json_encode( [
					'version'   => AEAFE_VERSION,
					'nonce'     => wp_create_nonce( 'bptb_admin_nonce' ),
					'isPremium' => false,
					'hasPro'    => false,
					'action'    => 'bptbGetBlocks',
					'adminUrl'  => admin_url(),
				] ) ); ?>'
			></div>
		<?php }

		/**
		 * Enqueue admin scripts and styles for Dashboard.
		 *
		 * @param string $hook The current admin page hook.
		 */
		public function aeafeAdminEnqueueScripts( $hook ) {
			if ( false !== strpos( $hook, 'all-embed-addons-for-elementor' ) ) {
				wp_enqueue_style( 'aeafe-admin-dashboard', AEAFE_DIR_URL . 'build/admin/dashboard.css', [], AEAFE_VERSION );
				wp_enqueue_script( 'aeafe-admin-dashboard', AEAFE_DIR_URL . 'build/admin/dashboard.js', [ 'react', 'react-dom', 'wp-util' ], AEAFE_VERSION, true );
				wp_set_script_translations( 'aeafe-admin-dashboard', 'media-player-addons-for-elementor', AEAFE_DIR_PATH . 'languages' );
			}
		}
	}

	new AEAFEAdminMenu();
}
