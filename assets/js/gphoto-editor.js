(function ($) {
	'use strict';

	$(window).on('elementor:init', function () {

		function getWidgetModelFromView(controlView) {
			var container = controlView.options.container;
			if (container && container.settings && container.settings.model) {
				return container.settings.model;
			}
			if (controlView.container && controlView.container.settings) {
				return controlView.container.settings;
			}
			return null;
		}

		function getControlValue(controlView, name) {
			var model = getWidgetModelFromView(controlView);
			if (model) {
				return model.get(name);
			}
			var $control = controlView.$el.closest('.elementor-control').find('[data-setting="' + name + '"]');
			return $control.val();
		}

		function showToast(message, type) {
			type = type || 'success';
			var $toast = $('<div/>', {
				class: 'aeafe-toast aeafe-toast-' + type,
				text: message,
				css: {
					position: 'fixed',
					top: '30px',
					right: '30px',
					padding: '12px 20px',
					background: type === 'success' ? '#00a32a' : '#d63638',
					color: '#fff',
					borderRadius: '4px',
					boxShadow: '0 4px 12px rgba(0,0,0,0.15)',
					zIndex: 999999,
					fontSize: '13px',
					fontWeight: 500,
					animation: 'aeafeToastIn 0.3s ease'
				}
			}).appendTo('body');

			setTimeout(function () {
				$toast.fadeOut(300, function () {
					$(this).remove();
				});
			}, 3000);
		}

		$('head').append('<style>' +
			'@keyframes aeafeToastIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }' +
			'.aeafe-gphoto-status { display: flex; align-items: center; gap: 8px; padding: 10px 12px; border-radius: 4px; font-size: 12px; font-weight: 500; }' +
			'.aeafe-gphoto-status .status-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }' +
			'.aeafe-gphoto-status.connected { background: #eaf7ef; color: #005c12; }' +
			'.aeafe-gphoto-status.connected .status-dot { background: #00a32a; box-shadow: 0 0 0 3px rgba(0,163,42,0.15); }' +
			'.aeafe-gphoto-status.has-creds { background: #f0f6fc; color: #135e96; }' +
			'.aeafe-gphoto-status.has-creds .status-dot { background: #72aee6; }' +
			'.aeafe-gphoto-status.not-setup { background: #fef7f1; color: #8a5a1f; }' +
			'.aeafe-gphoto-status.not-setup .status-dot { background: #dba617; }' +
			'</style>');

		elementor.channels.editor.on('aeafe:saveGPcredentials', function (controlView) {
			var $btn = controlView.$el.find('button');
			var originalText = $btn.text();

			$btn.prop('disabled', true).text('Saving...');

			var clientId = getControlValue(controlView, 'client_id_input');
			var clientSecret = getControlValue(controlView, 'client_secret_input');

			$.ajax({
				url: aeafeGphoto.ajaxurl,
				type: 'POST',
				data: {
					action: 'aeafe_gphoto_save_settings',
					nonce: aeafeGphoto.nonce,
					client_id: clientId,
					client_secret: clientSecret
				},
				success: function (response) {
					if (response.success) {
						showToast(response.data.message || 'Credentials saved!', 'success');
						setTimeout(function () {
							location.reload();
						}, 800);
					} else {
						showToast(response.data || 'Save failed.', 'error');
						$btn.prop('disabled', false).text(originalText);
					}
				},
				error: function () {
					showToast('Network error saving credentials.', 'error');
					$btn.prop('disabled', false).text(originalText);
				}
			});
		});

		elementor.channels.editor.on('aeafe:connectGP', function (controlView) {
			$.ajax({
				url: aeafeGphoto.ajaxurl,
				type: 'POST',
				data: {
					action: 'aeafe_gphoto_get_status',
					nonce: aeafeGphoto.nonce
				},
				success: function (response) {
					if (response.success && response.data.oauth_url) {
						var oauthWindow = window.open(
							response.data.oauth_url,
							'gphoto-oauth',
							'width=600,height=700,scrollbars=yes,resizable=yes'
						);

						var checkClose = setInterval(function () {
							if (oauthWindow.closed) {
								clearInterval(checkClose);
								showToast('Checking connection status...', 'success');
								setTimeout(function () {
									location.reload();
								}, 500);
							}
						}, 500);
					} else {
						showToast(response.data || 'Please save your Client ID and Secret first.', 'error');
					}
				},
				error: function () {
					showToast('Network error.', 'error');
				}
			});
		});

		elementor.channels.editor.on('aeafe:disconnectGP', function (controlView) {
			if (!confirm('Disconnect Google Photos account?')) return;

			var $btn = controlView.$el.find('button');
			var originalText = $btn.text();
			$btn.prop('disabled', true).text('Disconnecting...');

			$.ajax({
				url: aeafeGphoto.ajaxurl,
				type: 'POST',
				data: {
					action: 'aeafe_gphoto_disconnect',
					nonce: aeafeGphoto.nonce
				},
				success: function (response) {
					if (response.success) {
						showToast('Disconnected from Google Photos.', 'success');
						setTimeout(function () {
							location.reload();
						}, 500);
					} else {
						showToast(response.data || 'Failed to disconnect.', 'error');
						$btn.prop('disabled', false).text(originalText);
					}
				},
				error: function () {
					showToast('Network error.', 'error');
					$btn.prop('disabled', false).text(originalText);
				}
			});
		});

		elementor.channels.editor.on('aeafe:refreshAlbums', function (controlView) {
			var $btn = controlView.$el.find('button');
			var originalText = $btn.text();

			$btn.prop('disabled', true).text('Refreshing...');

			$.ajax({
				url: aeafeGphoto.ajaxurl,
				type: 'POST',
				data: {
					action: 'aeafe_gphoto_reload_albums',
					nonce: aeafeGphoto.nonce
				},
				success: function (response) {
					if (response.success) {
						showToast('Albums refreshed! Reloading editor...', 'success');
						setTimeout(function () {
							location.reload();
						}, 800);
					} else {
						showToast(response.data || 'Failed to refresh albums.', 'error');
						$btn.prop('disabled', false).text(originalText);
					}
				},
				error: function () {
					showToast('Network error.', 'error');
					$btn.prop('disabled', false).text(originalText);
				}
			});
		});

	});

})(jQuery);
