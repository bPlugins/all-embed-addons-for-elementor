<?php
/**
 * Google Photos Picker API Handler
 *
 * AJAX endpoints for the Google Gallery Plus widget:
 *   - Create a Picker session
 *   - Poll for selected photos
 *   - Proxy image requests through WordPress
 *
 * @package All_Embed_Addons_For_Elementor
 * @since   1.1.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'AEAFE_Picker_API' ) ) {

	/**
	 * Handles Google Photos Picker API v1 AJAX endpoints.
	 */
	class AEAFE_Picker_API {

		const PICKER_API_BASE = 'https://photospicker.googleapis.com/v1';

		private static $instance = null;

		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct() {
			add_action( 'wp_ajax_aeafe_picker_create_session',     [ $this, 'ajax_create_session' ] );
			add_action( 'wp_ajax_aeafe_picker_poll_session',       [ $this, 'ajax_poll_session' ] );
			add_action( 'wp_ajax_aeafe_picker_proxy_image',        [ $this, 'ajax_proxy_image' ] );
			add_action( 'wp_ajax_nopriv_aeafe_picker_proxy_image', [ $this, 'ajax_proxy_image' ] );
		}

		/**
		 * Get a valid access token from the existing Google Photos API instance.
		 *
		 * @return string Access token, or empty string on failure.
		 */
		private function get_access_token(): string {
			$api      = AEAFE_Google_Photos_API::instance();
			$settings = $api->get_settings();

			$access_token  = isset( $settings['access_token'] ) ? trim( $settings['access_token'] ) : '';
			$refresh_token = isset( $settings['refresh_token'] ) ? trim( $settings['refresh_token'] ) : '';
			$token_expires = isset( $settings['token_expires'] ) ? intval( $settings['token_expires'] ) : 0;

			if ( ! empty( $access_token ) && time() < ( $token_expires - 60 ) ) {
				return $access_token;
			}

			if ( ! empty( $refresh_token ) ) {
				$result = $api->refresh_access_token();
				if ( ! is_wp_error( $result ) ) {
					$settings     = $api->get_settings();
					$access_token = isset( $settings['access_token'] ) ? trim( $settings['access_token'] ) : '';
				}
			}

			return $access_token;
		}

		/**
		 * AJAX: Create a new Google Photos Picker session.
		 */
		public function ajax_create_session(): void {
			check_ajax_referer( 'aeafe_gphoto_nonce', 'nonce' );

			if ( ! current_user_can( 'edit_posts' ) ) {
				wp_send_json_error( [ 'message' => esc_html__( 'Unauthorized.', 'allembed' ) ], 403 );
			}

			$token = $this->get_access_token();
			if ( empty( $token ) ) {
				wp_send_json_error( [
					'message' => esc_html__( 'Not connected to Google. Please connect your account on the API Credentials page and re-authorize to grant the Picker scope.', 'allembed' ),
				] );
			}

			$response = wp_remote_post(
				self::PICKER_API_BASE . '/sessions',
				[
					'headers' => [
						'Authorization' => 'Bearer ' . $token,
						'Content-Type'  => 'application/json',
					],
					'body'    => '{}',
					'timeout' => 20,
				]
			);

			if ( is_wp_error( $response ) ) {
				wp_send_json_error( [ 'message' => $response->get_error_message() ] );
			}

			$code = (int) wp_remote_retrieve_response_code( $response );
			$body = json_decode( wp_remote_retrieve_body( $response ), true );

			if ( $code !== 200 ) {
				$message = isset( $body['error']['message'] )
					? $body['error']['message']
					: esc_html__( 'Could not create a Picker session. Make sure the "Photos Picker API" is enabled in Google Cloud Console and that you have re-authorized with the Picker scope.', 'allembed' );
				wp_send_json_error( [ 'message' => $message, 'http_code' => $code ] );
			}

			wp_send_json_success( [
				'session_id' => $body['id'] ?? '',
				'picker_uri' => $body['pickerUri'] ?? '',
			] );
		}

		/**
		 * AJAX: Poll a Picker session and retrieve selected media items when done.
		 */
		public function ajax_poll_session(): void {
			check_ajax_referer( 'aeafe_gphoto_nonce', 'nonce' );

			if ( ! current_user_can( 'edit_posts' ) ) {
				wp_send_json_error( [ 'message' => esc_html__( 'Unauthorized.', 'allembed' ) ], 403 );
			}

			$session_id = isset( $_POST['session_id'] ) ? sanitize_text_field( wp_unslash( $_POST['session_id'] ) ) : '';
			if ( empty( $session_id ) ) {
				wp_send_json_error( [ 'message' => esc_html__( 'Missing session ID.', 'allembed' ) ] );
			}

			$token = $this->get_access_token();
			if ( empty( $token ) ) {
				wp_send_json_error( [ 'message' => esc_html__( 'Not connected to Google.', 'allembed' ) ] );
			}

			// Poll the session status.
			$response = wp_remote_get(
				self::PICKER_API_BASE . '/sessions/' . rawurlencode( $session_id ),
				[
					'headers' => [ 'Authorization' => 'Bearer ' . $token ],
					'timeout' => 20,
				]
			);

			if ( is_wp_error( $response ) ) {
				wp_send_json_error( [ 'message' => $response->get_error_message() ] );
			}

			$code = (int) wp_remote_retrieve_response_code( $response );
			$body = json_decode( wp_remote_retrieve_body( $response ), true );

			if ( $code !== 200 ) {
				$message = isset( $body['error']['message'] ) ? $body['error']['message'] : esc_html__( 'Polling failed.', 'allembed' );
				wp_send_json_error( [ 'message' => $message ] );
			}

			// Not done yet — user is still picking.
			if ( empty( $body['mediaItemsSet'] ) ) {
				wp_send_json_success( [ 'done' => false ] );
			}

			// Fetch all selected media items (paginated).
			$items      = [];
			$page_token = null;

			do {
				$params = array_filter( [
					'sessionId' => $session_id,
					'pageToken' => $page_token,
					'pageSize'  => 100,
				] );

				$items_resp = wp_remote_get(
					self::PICKER_API_BASE . '/mediaItems?' . http_build_query( $params ),
					[
						'headers' => [ 'Authorization' => 'Bearer ' . $token ],
						'timeout' => 30,
					]
				);

				if ( ! is_wp_error( $items_resp ) ) {
					$items_body = json_decode( wp_remote_retrieve_body( $items_resp ), true );
					if ( ! empty( $items_body['mediaItems'] ) ) {
						foreach ( $items_body['mediaItems'] as $raw_item ) {
							$items[] = $this->normalize_media_item( $raw_item );
						}
					}
					$page_token = isset( $items_body['nextPageToken'] ) ? $items_body['nextPageToken'] : null;
				} else {
					$page_token = null;
				}
			} while ( ! empty( $page_token ) );

			// Clean up the session (best-effort).
			wp_remote_request(
				self::PICKER_API_BASE . '/sessions/' . rawurlencode( $session_id ),
				[
					'method'  => 'DELETE',
					'headers' => [ 'Authorization' => 'Bearer ' . $token ],
					'timeout' => 10,
				]
			);

			wp_send_json_success( [ 'done' => true, 'items' => $items ] );
		}

		/**
		 * Normalize a raw Picker API media item into a consistent storage format.
		 *
		 * @param array $item Raw media item from the Picker API.
		 * @return array Normalized item.
		 */
		private function normalize_media_item( array $item ): array {
			$base_url  = $item['baseUrl'] ?? $item['mediaFile']['baseUrl'] ?? '';
			$mime_type = $item['mimeType'] ?? $item['mediaFile']['mimeType'] ?? 'image/jpeg';
			$filename  = $item['filename'] ?? $item['mediaFile']['filename'] ?? '';

			$base_url_safe = esc_url_raw( $base_url );

			return [
				'id'          => sanitize_text_field( $item['id'] ?? '' ),
				'base_url'    => $base_url_safe,
				'thumbnail'   => $base_url_safe ? $base_url_safe . '=w1200-h1200' : '',
				'full_url'    => $base_url_safe ? $base_url_safe . '=w2048-h2048' : '',
				'mime_type'   => sanitize_mime_type( $mime_type ),
				'filename'    => sanitize_file_name( $filename ),
				'description' => sanitize_text_field( $item['description'] ?? '' ),
			];
		}

		/**
		 * AJAX: Proxy a Google Photos image through WordPress.
		 *
		 * Google Photos URLs require an Authorization: Bearer header, so they cannot
		 * be used as direct <img src> values on the frontend. This endpoint fetches
		 * the image server-side and streams it to the browser.
		 */
		public function ajax_proxy_image(): void {
			$raw = isset( $_GET['url'] ) ? urldecode( wp_unslash( $_GET['url'] ) ) : '';

			if ( empty( $raw ) ) {
				status_header( 400 );
				echo 'Missing URL parameter.';
				exit;
			}

			// Whitelist: only Google's image CDN domains are allowed.
			$allowed_hosts = [
				'lh3.googleusercontent.com',
				'lh4.googleusercontent.com',
				'lh5.googleusercontent.com',
				'lh6.googleusercontent.com',
				'photos.google.com',
				'photos.googleapis.com',
			];

			$parsed = wp_parse_url( $raw );
			$host   = $parsed['host'] ?? '';

			if ( ! in_array( $host, $allowed_hosts, true ) ) {
				status_header( 403 );
				echo 'Host not allowed: ' . esc_html( $host );
				exit;
			}

			$token = $this->get_access_token();

			// Try original URL then fallback sizing variants.
			$attempts = [ $raw ];
			$base     = preg_replace( '/=.*$/', '', $raw );
			if ( $base && $base !== $raw ) {
				$attempts[] = $base . '=s400';
				$attempts[] = $base . '=w400-h400-c';
				$attempts[] = $base . '=w400-h400';
				$attempts[] = $base;
			}
			$attempts = array_values( array_unique( $attempts ) );

			$ua          = 'Mozilla/5.0 (compatible; WordPress/AllEmbedAddons)';
			$found       = false;
			$final_body  = '';
			$final_ctype = '';

			foreach ( $attempts as $url_attempt ) {
				$args = [
					'headers'     => [ 'User-Agent' => $ua ],
					'timeout'     => 15,
					'redirection' => 5,
				];
				if ( $token ) {
					$args['headers']['Authorization'] = 'Bearer ' . $token;
				}

				$resp  = wp_remote_get( $url_attempt, $args );
				$code  = is_wp_error( $resp ) ? 0 : (int) wp_remote_retrieve_response_code( $resp );
				$ctype = is_wp_error( $resp ) ? '' : wp_remote_retrieve_header( $resp, 'content-type' );
				$body  = is_wp_error( $resp ) ? '' : wp_remote_retrieve_body( $resp );

				if ( $code === 200 && strpos( $ctype, 'image/' ) !== false ) {
					$found       = true;
					$final_body  = $body;
					$final_ctype = $ctype;
					break;
				}
			}

			if ( ! $found ) {
				status_header( 502 );
				echo 'Could not fetch image.';
				exit;
			}

			// Flush any output buffers to prevent HTML leaking into binary image data.
			while ( ob_get_level() > 0 ) {
				ob_end_clean();
			}

			header( 'Content-Type: ' . $final_ctype );
			header( 'Content-Length: ' . strlen( $final_body ) );
			header( 'Cache-Control: public, max-age=300' );
			header( 'Access-Control-Allow-Origin: *' );

			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $final_body;
			exit;
		}
	}

	AEAFE_Picker_API::instance();
}
