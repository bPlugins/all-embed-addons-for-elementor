<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class AEAFE_Google_Photos_API {

    private static $instance = null;
    private $client_id = '';
    private $client_secret = '';
    private $access_token = '';
    private $refresh_token = '';
    private $token_expires = 0;

    const OPTION_NAME = 'aeafe_google_photos_settings';
    const TRANSIENT_PREFIX = 'aeafe_gphoto_';

    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct() {
        $this->load_settings();
        add_action( 'wp_ajax_aeafe_gphoto_oauth_callback', [ $this, 'handle_oauth_callback' ] );
        add_action( 'wp_ajax_aeafe_gphoto_disconnect', [ $this, 'ajax_disconnect' ] );
        add_action( 'wp_ajax_aeafe_gphoto_fetch_albums', [ $this, 'ajax_fetch_albums' ] );
        add_action( 'wp_ajax_aeafe_gphoto_fetch_photos', [ $this, 'ajax_fetch_photos' ] );
    }

    private function load_settings() {
        $settings = get_option( self::OPTION_NAME, [] );
        $this->client_id = isset( $settings['client_id'] ) ? trim( $settings['client_id'] ) : '';
        $this->client_secret = isset( $settings['client_secret'] ) ? trim( $settings['client_secret'] ) : '';
        $this->access_token = isset( $settings['access_token'] ) ? trim( $settings['access_token'] ) : '';
        $this->refresh_token = isset( $settings['refresh_token'] ) ? trim( $settings['refresh_token'] ) : '';
        $this->token_expires = isset( $settings['token_expires'] ) ? intval( $settings['token_expires'] ) : 0;
    }

    public function save_settings( $settings ) {
        $existing = get_option( self::OPTION_NAME, [] );
        $merged = wp_parse_args( $settings, $existing );
        update_option( self::OPTION_NAME, $merged );
        $this->load_settings();
    }

    public function get_settings() {
        return get_option( self::OPTION_NAME, [] );
    }

    public function is_connected() {
        return ! empty( $this->refresh_token ) || ! empty( $this->access_token );
    }

    public function has_credentials() {
        return ! empty( $this->client_id ) && ! empty( $this->client_secret );
    }

    public function get_redirect_uri() {
        return admin_url( 'admin-ajax.php?action=aeafe_gphoto_oauth_callback' );
    }

    public function get_oauth_url() {
        if ( ! $this->has_credentials() ) {
            return false;
        }

        $params = [
            'client_id'     => $this->client_id,
            'redirect_uri'  => $this->get_redirect_uri(),
            'response_type' => 'code',
            'scope'         => 'https://www.googleapis.com/auth/photoslibrary.readonly https://www.googleapis.com/auth/photospicker.mediaitems.readonly',
            'access_type'   => 'offline',
            'prompt'        => 'consent',
            'state'         => wp_create_nonce( 'aeafe_gphoto_oauth' ),
        ];

        return 'https://accounts.google.com/o/oauth2/v2/auth?' . build_query( $params );
    }

    public function handle_oauth_callback() {
        if ( ! isset( $_GET['code'] ) ) {
            wp_die( esc_html__( 'No authorization code received.', 'allembed' ) );
        }

        if ( ! isset( $_GET['state'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['state'] ) ), 'aeafe_gphoto_oauth' ) ) {
            wp_die( esc_html__( 'OAuth state verification failed.', 'allembed' ) );
        }

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'Permission denied.', 'allembed' ) );
        }

        $code = sanitize_text_field( wp_unslash( $_GET['code'] ) );
        $result = $this->exchange_code_for_token( $code );

        if ( is_wp_error( $result ) ) {
            wp_die( esc_html( $result->get_error_message() ) );
        }

        delete_transient( 'aeafe_gphoto_widget_albums' );

        $settings_url = admin_url( 'admin.php?page=aeafe-google-photos&connected=1' );

        echo '<!DOCTYPE html><html><head><title>' . esc_html__( 'Google Photos Connected', 'allembed' ) . '</title></head><body style="background:#f0f0f1;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0;font-family:-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,sans-serif;">';
        echo '<div style="background:#fff;padding:40px;border-radius:12px;box-shadow:0 4px 20px rgba(0,0,0,0.08);text-align:center;max-width:460px;width:90%;">';
        echo '<div style="font-size:48px;margin-bottom:16px;color:#12b76a;">&#10004;</div>';
        echo '<h2 style="color:#1d2327;margin:0 0 12px;font-size:22px;">' . esc_html__( 'Successfully Connected!', 'allembed' ) . '</h2>';
        echo '<p style="color:#646970;margin:0 0 24px;font-size:14px;line-height:1.5;">' . esc_html__( 'Your Google Photos account has been successfully connected to All Embed Addons.', 'allembed' ) . '</p>';
        echo '<div style="display:flex;gap:12px;justify-content:center;">';
        echo '<a id="return-btn" href="' . esc_url( $settings_url ) . '" style="background:#2271b1;color:#fff;text-decoration:none;padding:10px 20px;border-radius:6px;font-size:14px;font-weight:600;display:inline-block;">' . esc_html__( 'Return to Settings', 'allembed' ) . '</a>';
        echo '</div>';
        echo '</div>';
        echo '<script type="text/javascript">
            if (window.opener && !window.opener.closed) {
                try {
                    window.opener.location.reload();
                } catch(e) {}
                setTimeout(function() {
                    window.close();
                }, 1000);
            } else {
                setTimeout(function() {
                    window.location.href = "' . esc_url( $settings_url ) . '";
                }, 2000);
            }
        </script>';
        echo '</body></html>';
        exit;
    }

    private function exchange_code_for_token( $code ) {
        $body = [
            'code'          => $code,
            'client_id'     => $this->client_id,
            'client_secret' => $this->client_secret,
            'redirect_uri'  => $this->get_redirect_uri(),
            'grant_type'    => 'authorization_code',
        ];

        $response = wp_remote_post( 'https://oauth2.googleapis.com/token', [
            'body'    => $body,
            'timeout' => 30,
        ]);

        if ( is_wp_error( $response ) ) {
            return $response;
        }

        $data = json_decode( wp_remote_retrieve_body( $response ), true );

        if ( isset( $data['error'] ) ) {
            return new \WP_Error( 'oauth_error', $data['error_description'] ?? $data['error'] );
        }

        $this->save_settings( [
            'access_token'  => $data['access_token'],
            'refresh_token' => isset( $data['refresh_token'] ) ? $data['refresh_token'] : $this->refresh_token,
            'token_expires' => time() + intval( $data['expires_in'] ),
        ]);

        return true;
    }

    public function refresh_access_token() {
        if ( empty( $this->refresh_token ) ) {
            return new \WP_Error( 'no_refresh_token', esc_html__( 'No refresh token available.', 'allembed' ) );
        }

        $body = [
            'client_id'     => $this->client_id,
            'client_secret' => $this->client_secret,
            'refresh_token' => $this->refresh_token,
            'grant_type'    => 'refresh_token',
        ];

        $response = wp_remote_post( 'https://oauth2.googleapis.com/token', [
            'body'    => $body,
            'timeout' => 30,
        ]);

        if ( is_wp_error( $response ) ) {
            return $response;
        }

        $data = json_decode( wp_remote_retrieve_body( $response ), true );

        if ( isset( $data['error'] ) ) {
            return new \WP_Error( 'refresh_error', $data['error_description'] ?? $data['error'] );
        }

        $this->save_settings( [
            'access_token'  => $data['access_token'],
            'token_expires' => time() + intval( $data['expires_in'] ),
        ]);

        return true;
    }

    private function get_valid_access_token() {
        if ( empty( $this->access_token ) || time() >= ( $this->token_expires - 60 ) ) {
            if ( empty( $this->refresh_token ) ) {
                return new \WP_Error( 'no_token', esc_html__( 'Not connected to Google Photos. Please configure API credentials.', 'allembed' ) );
            }
            $result = $this->refresh_access_token();
            if ( is_wp_error( $result ) ) {
                return $result;
            }
        }

        if ( empty( $this->access_token ) ) {
            return new \WP_Error( 'no_token', esc_html__( 'Not connected to Google Photos.', 'allembed' ) );
        }

        return $this->access_token;
    }

    private function api_request( $endpoint, $method = 'GET', $body = null, $headers = [] ) {
        $token = $this->get_valid_access_token();
        if ( is_wp_error( $token ) ) {
            return $token;
        }

        $default_headers = [
            'Authorization' => 'Bearer ' . $token,
            'Content-Type'  => 'application/json',
        ];

        $args = [
            'method'  => $method,
            'headers' => array_merge( $default_headers, $headers ),
            'timeout' => 30,
        ];

        if ( $body && ( 'POST' === $method || 'PATCH' === $method ) ) {
            $args['body'] = is_array( $body ) ? wp_json_encode( $body ) : $body;
        }

        $url = 'https://photoslibrary.googleapis.com/v1/' . ltrim( $endpoint, '/' );

        $response = wp_remote_request( $url, $args );

        if ( is_wp_error( $response ) ) {
            return $response;
        }

        $response_code = wp_remote_retrieve_response_code( $response );
        $response_body = json_decode( wp_remote_retrieve_body( $response ), true );

        if ( $response_code < 200 || $response_code >= 300 ) {
            $error_msg = isset( $response_body['error']['message'] ) ? $response_body['error']['message'] : esc_html__( 'API request failed.', 'allembed' );
            return new \WP_Error( 'api_error', $error_msg );
        }

        return $response_body;
    }

    public function get_albums( $page_size = 50, $page_token = '' ) {
        $transient_key = self::TRANSIENT_PREFIX . 'albums_' . md5( $page_size . '_' . $page_token );
        $cached = get_transient( $transient_key );
        if ( false !== $cached ) {
            return $cached;
        }

        $params = [ 'pageSize' => $page_size ];
        if ( ! empty( $page_token ) ) {
            $params['pageToken'] = $page_token;
        }

        $result = $this->api_request( 'albums?' . build_query( $params ) );

        if ( is_wp_error( $result ) ) {
            return $result;
        }

        set_transient( $transient_key, $result, HOUR_IN_SECONDS );
        return $result;
    }

    public function get_all_albums() {
        $albums = [];
        $page_token = '';

        do {
            $result = $this->get_albums( 50, $page_token );
            if ( is_wp_error( $result ) ) {
                return $result;
            }
            if ( isset( $result['albums'] ) ) {
                $albums = array_merge( $albums, $result['albums'] );
            }
            $page_token = isset( $result['nextPageToken'] ) ? $result['nextPageToken'] : '';
        } while ( ! empty( $page_token ) && count( $albums ) < 500 );

        return $albums;
    }

    public function search_media_items( $args = [] ) {
        $defaults = [
            'pageSize'    => 100,
            'pageToken'   => '',
            'albumId'     => '',
            'mediaType'   => '',
        ];
        $args = wp_parse_args( $args, $defaults );

        $body = [
            'pageSize' => intval( $args['pageSize'] ),
        ];

        if ( ! empty( $args['pageToken'] ) ) {
            $body['pageToken'] = $args['pageToken'];
        }

        if ( ! empty( $args['albumId'] ) ) {
            $body['albumId'] = $args['albumId'];
        } elseif ( ! empty( $args['mediaType'] ) ) {
            $body['filters'] = [
                'mediaTypeFilter' => [
                    'mediaTypes' => [ strtoupper( $args['mediaType'] ) ],
                ],
            ];
        }

        $transient_key = self::TRANSIENT_PREFIX . 'media_' . md5( wp_json_encode( $body ) );
        $cached = get_transient( $transient_key );
        if ( false !== $cached ) {
            return $cached;
        }

        $result = $this->api_request( 'mediaItems:search', 'POST', $body );

        if ( is_wp_error( $result ) ) {
            return $result;
        }

        set_transient( $transient_key, $result, 30 * MINUTE_IN_SECONDS );
        return $result;
    }

    public function get_album_photos( $album_id, $max_photos = 200 ) {
        $photos = [];
        $page_token = '';

        do {
            $result = $this->search_media_items( [
                'pageSize'  => 100,
                'pageToken' => $page_token,
                'albumId'   => $album_id,
            ]);

            if ( is_wp_error( $result ) ) {
                return $result;
            }

            if ( isset( $result['mediaItems'] ) ) {
                $photos = array_merge( $photos, $result['mediaItems'] );
            }

            $page_token = isset( $result['nextPageToken'] ) ? $result['nextPageToken'] : '';
        } while ( ! empty( $page_token ) && count( $photos ) < $max_photos );

        return $photos;
    }

    public function get_recent_photos( $max_photos = 200 ) {
        $photos = [];
        $page_token = '';

        do {
            $result = $this->search_media_items( [
                'pageSize'  => 100,
                'pageToken' => $page_token,
            ]);

            if ( is_wp_error( $result ) ) {
                return $result;
            }

            if ( isset( $result['mediaItems'] ) ) {
                $photos = array_merge( $photos, $result['mediaItems'] );
            }

            $page_token = isset( $result['nextPageToken'] ) ? $result['nextPageToken'] : '';
        } while ( ! empty( $page_token ) && count( $photos ) < $max_photos );

        return $photos;
    }

    public function disconnect() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return false;
        }

        $settings = $this->get_settings();
        $settings['access_token'] = '';
        $settings['refresh_token'] = '';
        $settings['token_expires'] = 0;
        update_option( self::OPTION_NAME, $settings );
        $this->load_settings();

        $this->clear_cache();
        return true;
    }

    public function clear_cache() {
        global $wpdb;
        $wpdb->query(
            $wpdb->prepare(
                "DELETE FROM $wpdb->options WHERE option_name LIKE %s",
                $wpdb->esc_like( '_transient_' . self::TRANSIENT_PREFIX ) . '%'
            )
        );
        $wpdb->query(
            $wpdb->prepare(
                "DELETE FROM $wpdb->options WHERE option_name LIKE %s",
                $wpdb->esc_like( '_transient_timeout_' . self::TRANSIENT_PREFIX ) . '%'
            )
        );
    }

    public function ajax_disconnect() {
        check_ajax_referer( 'aeafe_gphoto_nonce', 'nonce' );

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( esc_html__( 'Permission denied.', 'allembed' ) );
        }

        $this->disconnect();
        wp_send_json_success( esc_html__( 'Disconnected from Google Photos.', 'allembed' ) );
    }

    public function ajax_fetch_albums() {
        check_ajax_referer( 'aeafe_gphoto_nonce', 'nonce' );

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( esc_html__( 'Permission denied.', 'allembed' ) );
        }

        if ( ! $this->is_connected() ) {
            wp_send_json_error( esc_html__( 'Not connected to Google Photos.', 'allembed' ) );
        }

        $albums = $this->get_all_albums();

        if ( is_wp_error( $albums ) ) {
            wp_send_json_error( $albums->get_error_message() );
        }

        wp_send_json_success( $albums );
    }

    public function ajax_fetch_photos() {
        check_ajax_referer( 'aeafe_gphoto_nonce', 'nonce' );

        if ( ! $this->is_connected() ) {
            wp_send_json_error( esc_html__( 'Not connected to Google Photos.', 'allembed' ) );
        }

        $album_id = isset( $_POST['album_id'] ) ? sanitize_text_field( wp_unslash( $_POST['album_id'] ) ) : '';
        $source = isset( $_POST['source'] ) ? sanitize_text_field( wp_unslash( $_POST['source'] ) ) : 'album';
        $limit = isset( $_POST['limit'] ) ? intval( $_POST['limit'] ) : 100;

        if ( 'recent' === $source ) {
            $photos = $this->get_recent_photos( $limit );
        } else {
            if ( empty( $album_id ) ) {
                wp_send_json_error( esc_html__( 'Album ID is required.', 'allembed' ) );
            }
            $photos = $this->get_album_photos( $album_id, $limit );
        }

        if ( is_wp_error( $photos ) ) {
            wp_send_json_error( $photos->get_error_message() );
        }

        wp_send_json_success( $photos );
    }
}

AEAFE_Google_Photos_API::instance();
