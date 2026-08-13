/**
 * API Credentials Admin Script
 * All Embed Addons for Elementor
 */

(function ($) {
	'use strict';

	$(document).ready(function () {
		var config = window.aeafeCredentials || {
			ajaxurl: window.ajaxurl || '',
			nonce: '',
			i18n: {
				copied: 'Copied!',
				disconnectConfirm: 'Are you sure you want to disconnect from Google Photos?',
				disconnecting: 'Disconnecting...',
				disconnectBtn: 'Disconnect Account',
				clearing: 'Clearing...'
			}
		};

		// Copy URI Button
		$('#aeafe-copy-uri-btn').on('click', function (e) {
			e.preventDefault();
			var copyText = document.getElementById('aeafe-redirect-uri-input');
			if (!copyText) return;

			copyText.select();
			copyText.setSelectionRange(0, 99999);

			var $btn = $(this);
			var originalHtml = $btn.html();

			var afterCopied = function () {
				$btn.html('<span class="dashicons dashicons-yes"></span> ' + config.i18n.copied);
				setTimeout(function () {
					$btn.html(originalHtml);
				}, 2000);
			};

			if (navigator.clipboard && window.isSecureContext) {
				navigator.clipboard.writeText(copyText.value).then(afterCopied).catch(function () {
					document.execCommand('copy');
					afterCopied();
				});
			} else {
				document.execCommand('copy');
				afterCopied();
			}
		});

		// Toggle Password / Secret Visibility
		$('.aeafe-toggle-secret').on('click', function (e) {
			e.preventDefault();
			var $wrap = $(this).closest('.aeafe-password-wrap');
			var $input = $wrap.find('input');
			var $icon = $(this).find('.dashicons');

			if ($input.attr('type') === 'password') {
				$input.attr('type', 'text');
				$icon.removeClass('dashicons-visibility').addClass('dashicons-hidden');
			} else {
				$input.attr('type', 'password');
				$icon.removeClass('dashicons-hidden').addClass('dashicons-visibility');
			}
		});

		// Disconnect Action
		$('#aeafe-gphoto-disconnect').on('click', function (e) {
			e.preventDefault();
			if (!confirm(config.i18n.disconnectConfirm)) {
				return;
			}

			var $btn = $(this);
			$btn.prop('disabled', true).text(config.i18n.disconnecting);

			$.post(config.ajaxurl, {
				action: 'aeafe_gphoto_disconnect',
				nonce: config.nonce
			}, function (response) {
				if (response && response.success) {
					location.reload();
				} else {
					var message = (response && response.data) ? response.data : 'Disconnect failed.';
					alert(message);
					$btn.prop('disabled', false).text(config.i18n.disconnectBtn);
				}
			}).fail(function () {
				alert('Network error while disconnecting.');
				$btn.prop('disabled', false).text(config.i18n.disconnectBtn);
			});
		});

		// Clear Cache Action
		$('#aeafe-gphoto-clear-cache').on('click', function (e) {
			e.preventDefault();
			var $btn = $(this);
			var originalText = $btn.html();
			$btn.prop('disabled', true).text(config.i18n.clearing);

			$.post(config.ajaxurl, {
				action: 'aeafe_gphoto_clear_cache',
				nonce: config.nonce
			}, function (response) {
				var message = (response && response.data) ? response.data : (response.success ? 'Cache cleared!' : 'Failed to clear cache.');
				alert(message);
				$btn.prop('disabled', false).html(originalText);
			}).fail(function () {
				alert('Network error while clearing cache.');
				$btn.prop('disabled', false).html(originalText);
			});
		});
	});
})(jQuery);
