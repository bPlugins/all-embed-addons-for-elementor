<?php
if ( !defined( 'ABSPATH' ) ) { exit; }

if(!class_exists("AEAFEAdminMenu")) {
	class AEAFEAdminMenu {
		public function __construct() {
			add_action( 'admin_menu', [ $this, 'aeafeAdminMenu' ] );
			add_action( 'admin_enqueue_scripts', [$this, 'aeafeAdminEnqueueScripts'] );
			add_action('wp_ajax_bptbGetBlocks', [ $this, 'aeafeGetBlocks' ]);
		}
	
		public function aeafeAdminMenu() {
			$menuIcon = '<svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" stroke-width="3" stroke="#fff" fill="none"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><line x1="36.62" y1="13.05" x2="27.08" y2="50.95" stroke-linecap="round"></line><polyline points="22.26 21.98 12.81 32.01 22.26 42.02" stroke-linecap="round" stroke-linejoin="round"></polyline><polyline points="41.74 21.98 51.19 32.01 41.74 42.02" stroke-linecap="round" stroke-linejoin="round"></polyline></g></svg>';
	
			add_menu_page(
				__( 'All Embed Addons by bPlugins', 'allembed' ),
				__( 'All Embed Addons', 'allembed' ),
				'manage_options',
				'all-embed-addons-for-elementor',
				'',
				'data:image/svg+xml;base64,' . base64_encode( $menuIcon ),
				22
			);
	
			add_submenu_page(
				'all-embed-addons-for-elementor',
				__('Dashboard - All Embed Addons by bPlugins', 'allembed'),
				__('Dashboard', 'allembed'),
				'manage_options',
				'all-embed-addons-for-elementor',
				[$this, 'aeafeRenderDashboardPage'],
				0
			);
		}

		public function aeafeGetBlocks(){
			$nonce = sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ) ?? null;

			if( !wp_verify_nonce( $nonce, 'bptb_admin_nonce' )){
				wp_send_json_error( 'Invalid Request' );
			}

			$data = json_decode( stripslashes( $_POST['data'] ), true );
			$db_data = get_option( 'aeafeGetBlocks', [] );

			if( !isset( $data ) && $db_data ){
				wp_send_json_success( $db_data );
			}

			update_option( 'aeafeGetBlocks', $data );
			wp_send_json_success( $data );

		}
	
		public function aeafeRenderDashboardPage(){ ?>
			<div
				id='mpafebDashboard'
				data-info='<?php echo esc_attr( wp_json_encode( [
					'version' => AEAFE_VERSION,
					'nonce' => wp_create_nonce( 'bptb_admin_nonce' ),
					'isPremium' => aeafeIsPremium(),
				] ) ); ?>'
			></div>
		<?php }
	
		function aeafeAdminEnqueueScripts( $hook ) {
			if( strpos( $hook, 'all-embed-addons-for-elementor' ) ){
				wp_enqueue_style( 'aeafe-admin-dashboard', AEAFE_DIR_URL . 'build/admin/dashboard.css', [], AEAFE_VERSION );
				wp_enqueue_script( 'aeafe-admin-dashboard', AEAFE_DIR_URL . 'build/admin/dashboard.js', [ 'react', 'react-dom','wp-util' ], AEAFE_VERSION, true );
				wp_set_script_translations( 'aeafe-admin-dashboard', 'media-player-addons-for-elementor', AEAFE_DIR_PATH . 'languages' );
			}
		}
	}
	new AEAFEAdminMenu();
}
