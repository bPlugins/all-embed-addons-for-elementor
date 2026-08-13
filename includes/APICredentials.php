<?php
/**
 * API Credentials Controller Class
 *
 * @package All_Embed_Addons_For_Elementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'AEAFE_API_Credentials' ) ) {

	/**
	 * Handles API Credentials settings, rendering, and AJAX endpoints.
	 */
	class AEAFE_API_Credentials {

		/**
		 * Singleton instance.
		 *
		 * @var AEAFE_API_Credentials|null
		 */
		private static $instance = null;

		/**
		 * Get singleton instance.
		 *
		 * @return AEAFE_API_Credentials
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Constructor.
		 */
		public function __construct() {
			add_action( 'admin_init', [ $this, 'save_settings' ] );
			add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts' ] );

			// AJAX Endpoints
			add_action( 'wp_ajax_aeafe_gphoto_clear_cache', [ $this, 'ajax_clear_cache' ] );
			add_action( 'wp_ajax_aeafe_gphoto_save_settings', [ $this, 'ajax_save_settings' ] );
			add_action( 'wp_ajax_aeafe_gphoto_get_status', [ $this, 'ajax_get_status' ] );
			add_action( 'wp_ajax_aeafe_gphoto_reload_albums', [ $this, 'ajax_reload_albums' ] );
		}

		/**
		 * Enqueue styles and scripts for the API Credentials page.
		 *
		 * @param string $hook The current admin page hook.
		 */
		public function enqueue_admin_scripts( $hook ) {
			if ( false === strpos( $hook, 'aeafe-google-photos' ) ) {
				return;
			}

			wp_enqueue_style(
				'aeafe-api-credentials',
				AEAFE_DIR_URL . 'assets/css/api-credentials.css',
				[],
				AEAFE_VERSION
			);

			wp_enqueue_script(
				'aeafe-api-credentials',
				AEAFE_DIR_URL . 'assets/js/api-credentials.js',
				[ 'jquery' ],
				AEAFE_VERSION,
				true
			);

			wp_localize_script(
				'aeafe-api-credentials',
				'aeafeCredentials',
				[
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
					'nonce'   => wp_create_nonce( 'aeafe_gphoto_nonce' ),
					'i18n'    => [
						'copied'            => __( 'Copied!', 'allembed' ),
						'disconnectConfirm' => __( 'Are you sure you want to disconnect from Google Photos?', 'allembed' ),
						'disconnecting'     => __( 'Disconnecting...', 'allembed' ),
						'disconnectBtn'     => __( 'Disconnect Account', 'allembed' ),
						'clearing'          => __( 'Clearing...', 'allembed' ),
					],
				]
			);
		}

		/**
		 * Save settings submitted via standard POST request.
		 */
		public function save_settings() {
			if ( ! isset( $_POST['aeafe_gphoto_save'] ) ) {
				return;
			}

			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( esc_html__( 'Permission denied.', 'allembed' ) );
			}

			if ( ! isset( $_POST['aeafe_gphoto_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['aeafe_gphoto_nonce'] ) ), 'aeafe_gphoto_save_settings' ) ) {
				wp_die( esc_html__( 'Nonce verification failed.', 'allembed' ) );
			}

			$client_id     = isset( $_POST['client_id'] ) ? sanitize_text_field( wp_unslash( $_POST['client_id'] ) ) : '';
			$client_secret = isset( $_POST['client_secret'] ) ? sanitize_text_field( wp_unslash( $_POST['client_secret'] ) ) : '';
			$refresh_token = isset( $_POST['refresh_token'] ) ? sanitize_text_field( wp_unslash( $_POST['refresh_token'] ) ) : '';

			$settings = [
				'client_id'     => $client_id,
				'client_secret' => $client_secret,
			];

			if ( ! empty( $refresh_token ) ) {
				$settings['refresh_token'] = $refresh_token;
			}

			$api = AEAFE_Google_Photos_API::instance();
			$api->save_settings( $settings );

			if ( ! empty( $refresh_token ) ) {
				$result = $api->refresh_access_token();
				if ( is_wp_error( $result ) ) {
					wp_safe_redirect( admin_url( 'admin.php?page=aeafe-google-photos&error=' . rawurlencode( $result->get_error_message() ) ) );
					exit;
				}
				delete_transient( 'aeafe_gphoto_widget_albums' );
				wp_safe_redirect( admin_url( 'admin.php?page=aeafe-google-photos&connected=1' ) );
				exit;
			}

			wp_safe_redirect( admin_url( 'admin.php?page=aeafe-google-photos&saved=1' ) );
			exit;
		}

		/**
		 * Render the API Credentials settings page.
		 */
		public function render_page() {
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'allembed' ) );
			}

			$api      = AEAFE_Google_Photos_API::instance();
			$settings = $api->get_settings();

			$client_id     = isset( $settings['client_id'] ) ? $settings['client_id'] : '';
			$client_secret = isset( $settings['client_secret'] ) ? $settings['client_secret'] : '';
			$refresh_token = isset( $settings['refresh_token'] ) ? $settings['refresh_token'] : '';
			$is_connected  = $api->is_connected();
			$has_creds     = $api->has_credentials();
			$oauth_url     = $api->get_oauth_url();
			$redirect_uri  = $api->get_redirect_uri();

			include dirname( __FILE__ ) . '/views/api-credentials.php';
		}

		/**
		 * AJAX: Clear Google Photos cache.
		 */
		public function ajax_clear_cache() {
			check_ajax_referer( 'aeafe_gphoto_nonce', 'nonce' );
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_send_json_error( esc_html__( 'Permission denied.', 'allembed' ) );
			}

			$api = AEAFE_Google_Photos_API::instance();
			$api->clear_cache();
			delete_transient( 'aeafe_gphoto_widget_albums' );
			wp_send_json_success( esc_html__( 'Google Photos cache cleared.', 'allembed' ) );
		}

		/**
		 * AJAX: Save Google Photos settings from Elementor panel or admin.
		 */
		public function ajax_save_settings() {
			check_ajax_referer( 'aeafe_gphoto_nonce', 'nonce' );
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_send_json_error( esc_html__( 'Permission denied.', 'allembed' ) );
			}

			$client_id     = isset( $_POST['client_id'] ) ? sanitize_text_field( wp_unslash( $_POST['client_id'] ) ) : '';
			$client_secret = isset( $_POST['client_secret'] ) ? sanitize_text_field( wp_unslash( $_POST['client_secret'] ) ) : '';
			$refresh_token = isset( $_POST['refresh_token'] ) ? sanitize_text_field( wp_unslash( $_POST['refresh_token'] ) ) : '';

			$api       = AEAFE_Google_Photos_API::instance();
			$save_data = [
				'client_id'     => $client_id,
				'client_secret' => $client_secret,
			];
			if ( ! empty( $refresh_token ) ) {
				$save_data['refresh_token'] = $refresh_token;
			}

			$api->save_settings( $save_data );

			if ( ! empty( $refresh_token ) ) {
				$api->refresh_access_token();
			}

			wp_send_json_success( [
				'message'   => esc_html__( 'Settings saved.', 'allembed' ),
				'oauth_url' => $api->get_oauth_url(),
				'connected' => $api->is_connected(),
			] );
		}

		/**
		 * AJAX: Get status of Google Photos connection.
		 */
		public function ajax_get_status() {
			check_ajax_referer( 'aeafe_gphoto_nonce', 'nonce' );
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_send_json_error( esc_html__( 'Permission denied.', 'allembed' ) );
			}

			$api      = AEAFE_Google_Photos_API::instance();
			$settings = $api->get_settings();
			wp_send_json_success( [
				'connected'     => $api->is_connected(),
				'has_creds'     => $api->has_credentials(),
				'client_id'     => isset( $settings['client_id'] ) ? $settings['client_id'] : '',
				'client_secret' => isset( $settings['client_secret'] ) ? $settings['client_secret'] : '',
				'oauth_url'     => $api->get_oauth_url(),
				'redirect_uri'  => $api->get_redirect_uri(),
			] );
		}

		/**
		 * AJAX: Reload album options and clear cached albums.
		 */
		public function ajax_reload_albums() {
			check_ajax_referer( 'aeafe_gphoto_nonce', 'nonce' );
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_send_json_error( esc_html__( 'Permission denied.', 'allembed' ) );
			}

			delete_transient( 'aeafe_gphoto_widget_albums' );
			$api    = AEAFE_Google_Photos_API::instance();
			$albums = $api->get_all_albums();
			if ( is_wp_error( $albums ) ) {
				wp_send_json_error( $albums->get_error_message() );
			}

			$options = [ '' => esc_html__( '— Select Album —', 'allembed' ) ];
			foreach ( $albums as $album ) {
				$title              = isset( $album['title'] ) ? $album['title'] : esc_html__( 'Untitled', 'allembed' );
				$count              = isset( $album['mediaItemsCount'] ) ? ' (' . $album['mediaItemsCount'] . ')' : '';
				$options[ $album['id'] ] = $title . $count;
			}

			wp_send_json_success( $options );
		}
	}

	AEAFE_API_Credentials::instance();
}
