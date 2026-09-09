<?php
/**
 * API Credentials Admin View
 *
 * @package All_Embed_Addons_For_Elementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wrap aeafe-admin-wrap">
	<div class="aeafe-header">
		<div class="aeafe-header-left">
			<h1><?php esc_html_e( 'API Credentials', 'allembed' ); ?></h1>
			<p class="aeafe-header-desc"><?php esc_html_e( 'Manage external API connections and credentials for All Embed Addons widgets.', 'allembed' ); ?></p>
		</div>
	</div>

	<?php if ( isset( $_GET['error'] ) ) : ?>
		<div class="notice notice-error is-dismissible">
			<p><?php echo esc_html( sanitize_text_field( wp_unslash( $_GET['error'] ) ) ); ?></p>
		</div>
	<?php endif; ?>

	<?php if ( isset( $_GET['saved'] ) ) : ?>
		<div class="notice notice-success is-dismissible">
			<p><?php esc_html_e( 'API Credentials saved successfully.', 'allembed' ); ?></p>
		</div>
	<?php endif; ?>

	<?php if ( isset( $_GET['connected'] ) ) : ?>
		<div class="notice notice-success is-dismissible">
			<p><?php esc_html_e( 'Successfully connected to Google Photos!', 'allembed' ); ?></p>
		</div>
	<?php endif; ?>

	<div class="aeafe-cards-grid">
		<!-- Main Settings Card -->
		<div class="aeafe-card">
			<div class="aeafe-card-header">
				<div class="aeafe-card-title-wrap">
					<span class="aeafe-service-icon google-photos-icon">
						<svg viewBox="0 0 256 256" width="24" height="24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" fill="#000000">
							<g id="SVGRepo_bgCarrier" stroke-width="0"></g>
							<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
							<g id="SVGRepo_iconCarrier">
								<g>
									<path d="M64,58.1485714 C99.328,58.1485714 128,86.8205714 128,122.148571 L128,122.148571 L128,128 L5.85142857,128 C2.63314286,128 0,125.366857 0,122.148571 C0,86.8205714 28.672,58.1485714 64,58.1485714 L64,58.1485714 Z" fill="#FBBB05"></path>
									<path d="M197.851429,64 C197.851429,99.328 169.179429,128 133.851429,128 L128,128 L128,5.85142857 C128,2.63314286 130.633143,0 133.851429,0 L133.851429,0 C169.179429,0 197.851429,28.672 197.851429,64 Z" fill="#E94335"></path>
									<path d="M192,197.851429 C156.672,197.851429 128,169.179429 128,133.851429 L128,133.851429 L128,128 L250.148571,128 C253.366857,128 256,130.633143 256,133.851429 L256,133.851429 C256,169.179429 227.328,197.851429 192,197.851429 L192,197.851429 Z" fill="#4285F4"></path>
									<path d="M58.1485714,192 C58.1485714,156.672 86.8205714,128 122.148571,128 L128,128 L128,250.148571 C128,253.366857 125.366857,256 122.148571,256 L122.148571,256 C86.8205714,256 58.1485714,227.328 58.1485714,192 Z" fill="#0F9D58"></path>
								</g>
							</g>
						</svg>
					</span>
					<div>
						<h2><?php esc_html_e( 'Google Photos API', 'allembed' ); ?></h2>
						<span class="aeafe-card-subtitle"><?php esc_html_e( 'Used by the "Google Gallery" Elementor widget', 'allembed' ); ?></span>
					</div>
				</div>
				<div class="aeafe-status-badge <?php echo $is_connected ? 'status-connected' : ( $has_creds ? 'status-ready' : 'status-unconfigured' ); ?>">
					<span class="status-dot"></span>
					<span class="status-label">
						<?php
						if ( $is_connected ) {
							esc_html_e( 'Connected', 'allembed' );
						} elseif ( $has_creds ) {
							esc_html_e( 'Ready to Connect', 'allembed' );
						} else {
							esc_html_e( 'Not Configured', 'allembed' );
						}
						?>
					</span>
				</div>
			</div>

			<div class="aeafe-card-body">
				<form method="post" action="">
					<?php wp_nonce_field( 'aeafe_gphoto_save_settings', 'aeafe_gphoto_nonce' ); ?>

					<div class="aeafe-form-group">
						<label class="aeafe-label"><?php esc_html_e( 'Authorized Redirect URI', 'allembed' ); ?></label>
						<p class="aeafe-field-help">
							<?php esc_html_e( 'Add this exact URI to your Google Cloud Console OAuth 2.0 Client credentials under "Authorized redirect URIs" for 1-click connection:', 'allembed' ); ?>
						</p>
						<div class="aeafe-copy-box">
							<input type="text" id="aeafe-redirect-uri-input" readonly value="<?php echo esc_url( $redirect_uri ); ?>" class="aeafe-readonly-input" />
							<button type="button" id="aeafe-copy-uri-btn" class="button button-secondary">
								<span class="dashicons dashicons-admin-page"></span> <?php esc_html_e( 'Copy URI', 'allembed' ); ?>
							</button>
						</div>
					</div>

					<div class="aeafe-form-group">
						<label for="client_id" class="aeafe-label"><?php esc_html_e( 'OAuth Client ID', 'allembed' ); ?> <span class="required">*</span></label>
						<input type="text" id="client_id" name="client_id" value="<?php echo esc_attr( $client_id ); ?>" class="regular-text aeafe-input-full" placeholder="<?php esc_attr_e( 'xxxxxxxxxxxx.apps.googleusercontent.com', 'allembed' ); ?>" required />
					</div>

					<div class="aeafe-form-group">
						<label for="client_secret" class="aeafe-label"><?php esc_html_e( 'OAuth Client Secret', 'allembed' ); ?> <span class="required">*</span></label>
						<div class="aeafe-password-wrap">
							<input type="password" id="client_secret" name="client_secret" value="<?php echo esc_attr( $client_secret ); ?>" class="regular-text aeafe-input-full" placeholder="<?php esc_attr_e( 'Your OAuth Client Secret', 'allembed' ); ?>" required />
							<button type="button" class="aeafe-toggle-secret" title="<?php esc_attr_e( 'Show/Hide Secret', 'allembed' ); ?>">
								<span class="dashicons dashicons-visibility"></span>
							</button>
						</div>
					</div>

					<div class="aeafe-form-group">
						<label for="refresh_token" class="aeafe-label">
							<?php esc_html_e( 'OAuth Refresh Token (Optional / OAuth Playground)', 'allembed' ); ?>
						</label>
						<div class="aeafe-password-wrap">
							<input type="password" id="refresh_token" name="refresh_token" value="<?php echo esc_attr( $refresh_token ); ?>" class="regular-text aeafe-input-full" placeholder="<?php esc_attr_e( '1//04... (paste here if using Google OAuth Playground)', 'allembed' ); ?>" />
							<button type="button" class="aeafe-toggle-secret" title="<?php esc_attr_e( 'Show/Hide Token', 'allembed' ); ?>">
								<span class="dashicons dashicons-visibility"></span>
							</button>
						</div>
						<p class="aeafe-field-help">
							<?php esc_html_e( 'If you authorized via Google OAuth Playground (https://developers.google.com/oauthplayground), paste the generated Refresh token here and click Save Credentials.', 'allembed' ); ?>
						</p>
					</div>

					<div class="aeafe-form-actions">
						<button type="submit" name="aeafe_gphoto_save" class="button button-primary button-large">
							<?php esc_html_e( 'Save Credentials', 'allembed' ); ?>
						</button>

						<?php if ( $is_connected ) : ?>
							<button type="button" id="aeafe-gphoto-disconnect" class="button button-secondary button-large aeafe-btn-danger">
								<?php esc_html_e( 'Disconnect Account', 'allembed' ); ?>
							</button>
							<button type="button" id="aeafe-gphoto-clear-cache" class="button button-secondary button-large">
								<span class="dashicons dashicons-update"></span> <?php esc_html_e( 'Clear Cache', 'allembed' ); ?>
							</button>
						<?php elseif ( $oauth_url ) : ?>
							<a href="<?php echo esc_url( $oauth_url ); ?>" class="button button-primary button-large aeafe-btn-connect">
								<span class="dashicons dashicons-admin-links"></span> <?php esc_html_e( 'Connect with Google Photos', 'allembed' ); ?>
							</a>
						<?php endif; ?>
					</div>
				</form>
			</div>
		</div>

		<!-- Instructions Card -->
		<div class="aeafe-card aeafe-guide-card">
			<div class="aeafe-card-header">
				<h2><?php esc_html_e( 'How to Connect to Google Photos', 'allembed' ); ?></h2>
			</div>
			<div class="aeafe-card-body">
				<h3 style="margin-top:0;font-size:14px;color:#1d2327;"><?php esc_html_e( 'Option A: 1-Click Connect (Recommended)', 'allembed' ); ?></h3>
				<ol class="aeafe-steps-list">
					<li>
						<strong><?php esc_html_e( 'Google Cloud Console:', 'allembed' ); ?></strong>
						<span>
							<?php
							printf(
								esc_html__( 'Open %1$sGoogle Cloud Console%2$s → Enable both %3$sPhotos Library API%4$s and %5$sPhotos Picker API%6$s in your project.', 'allembed' ),
								'<a href="https://console.cloud.google.com/" target="_blank" rel="noopener noreferrer">',
								'</a>',
								'<strong>',
								'</strong>',
								'<strong>',
								'</strong>'
							);
							?>
						</span>
					</li>
					<li>
						<strong><?php esc_html_e( 'Add Authorized Redirect URI:', 'allembed' ); ?></strong>
						<span><?php esc_html_e( 'Under Credentials → OAuth Client ID → add the Redirect URI shown on the left.', 'allembed' ); ?></span>
					</li>
					<li>
						<strong><?php esc_html_e( 'Save & Connect:', 'allembed' ); ?></strong>
						<span><?php esc_html_e( 'Paste Client ID & Secret, click "Save Credentials", then click "Connect with Google Photos".', 'allembed' ); ?></span>
					</li>
				</ol>

				<hr style="margin:20px 0;border:0;border-top:1px solid #f0f0f1;" />

				<h3 style="font-size:14px;color:#1d2327;"><?php esc_html_e( 'Option B: Using Google OAuth Playground', 'allembed' ); ?></h3>
				<p style="font-size:12px;color:#646970;margin-bottom:10px;">
					<?php esc_html_e( 'If you set "https://developers.google.com/oauthplayground" as your redirect URI in Google Cloud Console:', 'allembed' ); ?>
				</p>
				<ol class="aeafe-steps-list">
					<li>
						<strong><?php esc_html_e( 'Open OAuth Playground:', 'allembed' ); ?></strong>
						<span>
							<?php
							printf(
								esc_html__( 'Go to %1$sGoogle OAuth 2.0 Playground%2$s.', 'allembed' ),
								'<a href="https://developers.google.com/oauthplayground" target="_blank" rel="noopener noreferrer">',
								'</a>'
							);
							?>
						</span>
					</li>
					<li>
						<strong><?php esc_html_e( 'Configure Credentials:', 'allembed' ); ?></strong>
						<span><?php esc_html_e( 'Click the gear icon (top right) → check "Use your own OAuth credentials" → enter your Client ID and Client Secret.', 'allembed' ); ?></span>
					</li>
					<li>
						<strong><?php esc_html_e( 'Authorize Photos Scope:', 'allembed' ); ?></strong>
						<span><?php esc_html_e( 'In Step 1, select or enter "https://www.googleapis.com/auth/photospicker.mediaitems.readonly" → click "Authorize APIs" and sign in.', 'allembed' ); ?></span>
					</li>
					<li>
						<strong><?php esc_html_e( 'Exchange Tokens & Copy Refresh Token:', 'allembed' ); ?></strong>
						<span><?php esc_html_e( 'In Step 2, click "Exchange authorization code for tokens" → copy the "Refresh token".', 'allembed' ); ?></span>
					</li>
					<li>
						<strong><?php esc_html_e( 'Paste & Save:', 'allembed' ); ?></strong>
						<span><?php esc_html_e( 'Paste your Client ID, Secret, and Refresh Token on the left, then click "Save Credentials".', 'allembed' ); ?></span>
					</li>
				</ol>

				<div class="aeafe-help-footer">
					<p>
						<span class="dashicons dashicons-info"></span>
						<?php esc_html_e( 'Once connected, you can pick photos from Google Photos directly inside the Google Gallery Elementor widget.', 'allembed' ); ?>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
