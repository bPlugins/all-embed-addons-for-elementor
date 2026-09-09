/**
 * All Embed Addons - Google Gallery Plus
 * Frontend Gallery Script (Lightbox + Slider + Preloader Sync)
 *
 * @since 1.1.8
 */
(function ($) {
  'use strict';

  function el(tag, cls) {
    var e = document.createElement(tag);
    if (cls) e.className = cls;
    return e;
  }

  function initImages(wrap) {
    var images = wrap.querySelectorAll('.aeafe-plus-item__image');
    images.forEach(function (img) {
      if (img.complete && img.naturalWidth > 0) {
        if (img.parentElement) {
          img.parentElement.classList.remove('aeafe-plus-loading');
        }
        img.classList.add('aeafe-plus-loaded');
      } else {
        img.addEventListener('load', function () {
          if (img.parentElement) {
            img.parentElement.classList.remove('aeafe-plus-loading');
          }
          img.classList.add('aeafe-plus-loaded');
        });
        img.addEventListener('error', function () {
          if (img.parentElement) {
            img.parentElement.classList.remove('aeafe-plus-loading');
          }
        });
      }
    });
  }

  function initAll() {
    var wraps = document.querySelectorAll('.aeafe-plus-wrap');
    wraps.forEach(function (wrap) {
      initImages(wrap);
      if (wrap.dataset.layout === 'slider') {
        initSlider(wrap);
      } else if (wrap.dataset.lightbox === '1') {
        initLightbox(wrap);
      }
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAll);
  } else {
    initAll();
  }

  // Hook for Elementor Frontend preview
  if (window.elementorFrontend && elementorFrontend.hooks) {
    elementorFrontend.hooks.addAction('frontend/element_ready/google_photos_plus.default', function ($scope) {
      var wrap = $scope.find('.aeafe-plus-wrap')[0];
      if (!wrap) return;
      initImages(wrap);
      if (wrap.dataset.layout === 'slider') {
        initSlider(wrap);
      } else if (wrap.dataset.lightbox === '1') {
        initLightbox(wrap);
      }
    });
  }

  /* ═══════════════════════════════════════════
     LIGHTBOX
  ═══════════════════════════════════════════ */
  var lb = {};

  function buildLightbox() {
    if (lb.el) return;

    lb.el    = el('div', 'aeafe-plus-lightbox');
    lb.inner = el('div', 'aeafe-plus-lightbox__inner');

    // Lightbox spinner loader
    lb.loader = el('div', 'aeafe-plus-lightbox-loader');
    lb.loader.innerHTML = '<span class="aeafe-plus-loader-spin"></span>';
    lb.inner.appendChild(lb.loader);

    lb.img = el('img', 'aeafe-plus-lightbox__img');
    lb.img.setAttribute('alt', '');
    lb.inner.appendChild(lb.img);
    lb.el.appendChild(lb.inner);

    // Close button
    var btnClose = el('button', 'aeafe-plus-lightbox__close');
    btnClose.innerHTML = '&times;';
    btnClose.setAttribute('aria-label', 'Close');
    lb.el.appendChild(btnClose);

    // Prev button with SVG
    lb.btnPrev = el('button', 'aeafe-plus-lightbox__nav aeafe-plus-lightbox__nav--prev');
    lb.btnPrev.innerHTML = '<svg viewBox="0 0 24 24"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>';
    lb.btnPrev.setAttribute('aria-label', 'Previous');
    lb.el.appendChild(lb.btnPrev);

    // Next button with SVG
    lb.btnNext = el('button', 'aeafe-plus-lightbox__nav aeafe-plus-lightbox__nav--next');
    lb.btnNext.innerHTML = '<svg viewBox="0 0 24 24"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>';
    lb.btnNext.setAttribute('aria-label', 'Next');
    lb.el.appendChild(lb.btnNext);

    // Floating footer (counter + caption)
    lb.footer = el('div', 'aeafe-plus-lightbox__footer');
    lb.counter = el('span', 'aeafe-plus-lightbox__counter');
    lb.caption = el('span', 'aeafe-plus-lightbox__caption');
    lb.footer.appendChild(lb.counter);
    lb.footer.appendChild(lb.caption);
    lb.el.appendChild(lb.footer);

    document.body.appendChild(lb.el);

    btnClose.addEventListener('click', closeLightbox);
    lb.btnPrev.addEventListener('click', lbPrev);
    lb.btnNext.addEventListener('click', lbNext);
    lb.el.addEventListener('click', function (e) {
      if (e.target === lb.el || e.target === lb.inner) {
        closeLightbox();
      }
    });

    // Touch swipe
    lb.el.addEventListener('touchstart', function (e) {
      lb.tx = e.touches[0].clientX;
    }, { passive: true });

    lb.el.addEventListener('touchend', function (e) {
      var dx = e.changedTouches[0].clientX - lb.tx;
      if (Math.abs(dx) > 50) {
        if (dx < 0) { lbNext(); } else { lbPrev(); }
      }
    }, { passive: true });

    // Keyboard navigation
    document.addEventListener('keydown', function (e) {
      if (!lb.el || !lb.el.classList.contains('aeafe-plus-lightbox--open')) return;
      if (e.key === 'Escape') {
        closeLightbox();
      } else if (e.key === 'ArrowLeft') {
        lbPrev();
      } else if (e.key === 'ArrowRight') {
        lbNext();
      }
    });
  }

  function initLightbox(wrap) {
    buildLightbox();
    var links = Array.from(wrap.querySelectorAll('[data-aeafe-plus-lightbox]'));
    links.forEach(function (link, i) {
      link.onclick = function (e) {
        e.preventDefault();
        openLightbox(links, i);
      };
    });
  }

  function openLightbox(links, index) {
    lb.links   = links;
    lb.current = index;
    var multi  = links.length > 1;

    if (lb.btnPrev) lb.btnPrev.style.display = multi ? 'flex' : 'none';
    if (lb.btnNext) lb.btnNext.style.display = multi ? 'flex' : 'none';

    lb.el.classList.add('aeafe-plus-lightbox--open');
    document.body.style.overflow = 'hidden';
    lbShow(index);
  }

  function closeLightbox() {
    lb.el.classList.remove('aeafe-plus-lightbox--open');
    document.body.style.overflow = '';
    lb.img.src = '';
    lb.img.style.opacity = '0';
  }

  function lbShow(i) {
    var link = lb.links[i];
    if (!link) return;
    lb.current = i;

    lb.loader.style.display = 'block';
    lb.img.style.opacity = '0';
    lb.img.classList.add('aeafe-plus-img-loading');

    var src = link.href;
    var cap = link.getAttribute('data-caption') || '';
    var t = new Image();

    t.onload = function () {
      lb.img.src = src;
      lb.img.classList.remove('aeafe-plus-img-loading');
      lb.loader.style.display = 'none';
      lb.img.style.opacity = '1';
    };
    t.onerror = function () {
      lb.loader.style.display = 'none';
    };

    t.src = src;

    lb.counter.textContent = (i + 1) + ' / ' + lb.links.length;
    if (cap) {
      lb.caption.textContent = cap;
      lb.caption.style.display = 'inline-block';
    } else {
      lb.caption.textContent = '';
      lb.caption.style.display = 'none';
    }
  }

  function lbPrev() {
    lbShow((lb.current - 1 + lb.links.length) % lb.links.length);
  }

  function lbNext() {
    lbShow((lb.current + 1) % lb.links.length);
  }

  /* ═══════════════════════════════════════════
     SLIDER / CAROUSEL
  ═══════════════════════════════════════════ */
  function initSlider(wrap) {
    var slider   = wrap.querySelector('.aeafe-plus-slider');
    if (!slider) return;
    var items    = Array.from(slider.querySelectorAll('.aeafe-plus-item'));
    if (!items.length) return;
    var dotsWrap = wrap.querySelector('.aeafe-plus-slider-dots');
    var btnPrev  = wrap.querySelector('.aeafe-plus-slider-nav--prev');
    var btnNext  = wrap.querySelector('.aeafe-plus-slider-nav--next');
    var current  = 0;
    var autoplay = wrap.dataset.autoplay === '1';
    var speed    = parseInt(wrap.dataset.speed, 10) || 4000;
    var timer    = null;

    slider.style.position = 'relative';
    items.forEach(function (item, i) {
      item.style.transition = 'opacity 0.6s cubic-bezier(0.2, 0.8, 0.2, 1), transform 0.6s cubic-bezier(0.2, 0.8, 0.2, 1)';
      if (i !== 0) {
        item.style.position = 'absolute';
        item.style.inset = '0';
        item.style.opacity = '0';
        item.style.pointerEvents = 'none';
        item.style.transform = 'scale(0.96)';
      } else {
        item.style.position = 'relative';
        item.style.opacity = '1';
        item.style.pointerEvents = 'auto';
        item.style.transform = 'scale(1)';
      }
    });

    if (dotsWrap) {
      dotsWrap.innerHTML = '';
      var dots = [];
      items.forEach(function (_, i) {
        var dot = el('button', 'aeafe-plus-slider-dot' + (i === 0 ? ' aeafe-plus-dot-active' : ''));
        dot.setAttribute('aria-label', 'Slide ' + (i + 1));
        dot.onclick = function () {
          goTo(i);
          resetAutoplay();
        };
        dotsWrap.appendChild(dot);
        dots.push(dot);
      });
    }

    function goTo(index) {
      items[current].style.position = 'absolute';
      items[current].style.opacity = '0';
      items[current].style.pointerEvents = 'none';
      items[current].style.transform = 'scale(0.96)';

      if (dots && dots[current]) {
        dots[current].classList.remove('aeafe-plus-dot-active');
      }

      current = (index + items.length) % items.length;

      items[current].style.position = 'relative';
      items[current].style.opacity = '1';
      items[current].style.pointerEvents = 'auto';
      items[current].style.transform = 'scale(1)';

      if (dots && dots[current]) {
        dots[current].classList.add('aeafe-plus-dot-active');
      }
    }

    if (btnPrev) {
      btnPrev.onclick = function () {
        goTo(current - 1);
        resetAutoplay();
      };
    }
    if (btnNext) {
      btnNext.onclick = function () {
        goTo(current + 1);
        resetAutoplay();
      };
    }

    var tx = 0;
    slider.addEventListener('touchstart', function (e) {
      tx = e.touches[0].clientX;
    }, { passive: true });

    slider.addEventListener('touchend', function (e) {
      var dx = e.changedTouches[0].clientX - tx;
      if (Math.abs(dx) > 50) {
        if (dx < 0) { goTo(current + 1); } else { goTo(current - 1); }
        resetAutoplay();
      }
    }, { passive: true });

    function startAutoplay() {
      if (autoplay && items.length > 1) {
        timer = setInterval(function () {
          goTo(current + 1);
        }, speed);
      }
    }

    function resetAutoplay() {
      if (timer) clearInterval(timer);
      startAutoplay();
    }

    wrap.addEventListener('mouseenter', function () {
      if (timer) clearInterval(timer);
    });
    wrap.addEventListener('mouseleave', startAutoplay);

    startAutoplay();
  }

})(jQuery);