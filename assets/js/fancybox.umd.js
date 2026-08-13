(function ($) {
	'use strict';

	var AEAFE_Lightbox = {
		overlay: null,
		imageWrap: null,
		captionEl: null,
		counterEl: null,
		currentGallery: [],
		currentIndex: 0,

		init: function () {
			this.createOverlay();
			this.bindEvents();
		},

		createOverlay: function () {
			this.overlay = $('<div/>', {
				'class': 'aeafe-lightbox-overlay',
				html: [
					'<button class="aeafe-lightbox-close" aria-label="Close">&times;</button>',
					'<button class="aeafe-lightbox-nav aeafe-lightbox-prev" aria-label="Previous">&#10094;</button>',
					'<button class="aeafe-lightbox-nav aeafe-lightbox-next" aria-label="Next">&#10095;</button>',
					'<div class="aeafe-lightbox-image-wrap"></div>',
					'<div class="aeafe-lightbox-caption"></div>',
					'<div class="aeafe-lightbox-counter"></div>'
				].join('')
			}).appendTo('body');

			this.imageWrap = this.overlay.find('.aeafe-lightbox-image-wrap');
			this.captionEl = this.overlay.find('.aeafe-lightbox-caption');
			this.counterEl = this.overlay.find('.aeafe-lightbox-counter');
		},

		bindEvents: function () {
			var self = this;

			$(document).on('click', '.aeafe-gphoto-lightbox', function (e) {
				e.preventDefault();
				self.openGallery($(this));
			});

			this.overlay.find('.aeafe-lightbox-close').on('click', function () {
				self.close();
			});

			this.overlay.find('.aeafe-lightbox-prev').on('click', function () {
				self.prev();
			});

			this.overlay.find('.aeafe-lightbox-next').on('click', function () {
				self.next();
			});

			this.overlay.on('click', function (e) {
				if ($(e.target).is(self.overlay)) {
					self.close();
				}
			});

			$(document).on('keydown', function (e) {
				if (!self.overlay.hasClass('active')) return;
				if (e.key === 'Escape') self.close();
				if (e.key === 'ArrowLeft') self.prev();
				if (e.key === 'ArrowRight') self.next();
			});
		},

		openGallery: function ($trigger) {
			var gallerySelector = $trigger.attr('data-fancybox') || 'gallery';
			var $items = $('[data-fancybox="' + gallerySelector + '"]');
			var self = this;

			this.currentGallery = [];
			$items.each(function () {
				var $a = $(this);
				var $img = $a.find('img').first();
				var isVideo = $a.closest('.aeafe-gphoto-item').hasClass('is-video');
				self.currentGallery.push({
					src: $a.attr('href'),
					caption: $a.attr('data-caption') || $img.attr('alt') || '',
					isVideo: isVideo
				});
			});

			this.currentIndex = $items.index($trigger);
			if (this.currentIndex < 0) this.currentIndex = 0;

			this.show();
			this.overlay.addClass('active');
		},

		show: function () {
			var item = this.currentGallery[this.currentIndex];
			if (!item) return;

			this.imageWrap.empty();

			if (item.isVideo) {
				var $video = $('<video/>', {
					src: item.src,
					controls: true,
					autoplay: true
				});
				this.imageWrap.append($video);
			} else {
				var $img = $('<img/>', {
					src: item.src,
					alt: item.caption
				});
				this.imageWrap.append($img);
			}

			this.captionEl.text(item.caption || '');
			var total = this.currentGallery.length;
			this.counterEl.text((this.currentIndex + 1) + ' / ' + total);

			this.overlay.find('.aeafe-lightbox-nav').toggle(total > 1);
		},

		next: function () {
			if (this.currentGallery.length <= 1) return;
			this.currentIndex = (this.currentIndex + 1) % this.currentGallery.length;
			this.show();
		},

		prev: function () {
			if (this.currentGallery.length <= 1) return;
			this.currentIndex = (this.currentIndex - 1 + this.currentGallery.length) % this.currentGallery.length;
			this.show();
		},

		close: function () {
			this.overlay.removeClass('active');
			this.imageWrap.find('video').each(function () {
				this.pause();
			});
			setTimeout($.proxy(function () {
				this.imageWrap.empty();
			}, this), 300);
		}
	};

	$(document).ready(function () {
		AEAFE_Lightbox.init();
	});

})(jQuery);
