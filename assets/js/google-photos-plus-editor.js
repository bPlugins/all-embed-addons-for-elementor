/**
 * All Embed Addons — Google Gallery Plus
 * Elementor Editor Picker Script
 *
 * Handles the in-editor Google Photos Picker flow for the
 * google_photos_plus widget and ensures photos and their data
 * are NEVER lost on any panel event, tab change, or setting update.
 *
 * @since 1.1.8
 */
(function ($) {
  'use strict';

  /* ─────────────────────── State ─────────────────────── */
  var currentSessionId = null;
  var activePollTimer  = null;
  var currentPickerWin = null;
  var panelObserver    = null;

  /* ─────────── Init hooks for Elementor editor ──────── */
  var restoreTimeout = null;

  function debouncedRestorePreview(delay) {
    if (restoreTimeout) {
      clearTimeout(restoreTimeout);
    }
    restoreTimeout = setTimeout(function () {
      restorePreview();
    }, delay || 50);
  }

  function initEditorIntegration() {
    if (window.elementor && elementor.hooks) {
      elementor.hooks.addAction('panel/open_editor/widget', function (panel, model) {
        if (!model || model.get('widgetType') !== 'google_photos_plus') return;
        debouncedRestorePreview(50);
      });
    }

    startPanelObserver();
  }

  if (window.elementor) {
    initEditorIntegration();
  } else {
    $(window).on('elementor:init', initEditorIntegration);
  }

  /* ──────────────── MutationObserver for Panel Load ──────────────── */
  function startPanelObserver() {
    if (panelObserver) return;

    var panel = document.getElementById('elementor-panel') || document.body;
    if (!panel) return;

    panelObserver = new MutationObserver(function () {
      var $c = $('#aeafe-plus-picker-container');
      // Only initialize if the container was newly inserted and hasn't been initialized yet
      if ($c.length && !$c.data('aeafe-rendered-state')) {
        debouncedRestorePreview(30);
      }
    });

    panelObserver.observe(panel, { childList: true, subtree: true });
  }

  /* ─────────────────── Global Delegated Click & Change Handlers ───────────────────── */
  $(document).on('click', '.aeafe-plus-launch-picker', function (e) {
    e.preventDefault();
    handleLaunchPicker($(this));
  });

  $(document).on('click', '.aeafe-plus-clear-photos', function (e) {
    e.preventDefault();
    handleClearPhotos();
  });

  // Restore preview on panel tab switch or section toggle
  $(document).on('click', '.elementor-tab-control-content, .elementor-tab-control-style, .elementor-control-section_google_photos_plus, .elementor-panel-navigation-tab', function () {
    debouncedRestorePreview(60);
  });

  /* ────── Helper: Get Config ────── */
  function getConfig() {
    var cfg = window.aeafePlusEditor || window.aeafeGphoto || {};
    return {
      ajaxurl: cfg.ajaxurl || (window.ajaxurl ? window.ajaxurl : '/wp-admin/admin-ajax.php'),
      nonce: cfg.nonce || '',
      connected: typeof cfg.connected !== 'undefined' ? cfg.connected : true,
      settings_url: cfg.settings_url || '/wp-admin/admin.php?page=aeafe-google-photos'
    };
  }

  /* ────── Helper: Get Current Active Elementor View & Container ────── */
  function getActiveElementorContext() {
    var context = { view: null, container: null, model: null };

    if (window.elementor) {
      if (elementor.panel && elementor.panel.currentView) {
        var pv = elementor.panel.currentView;
        context.view = pv.currentPageView || pv;
      }
      if (elementor.selection) {
        var selected = elementor.selection.getElements();
        if (selected && selected.length) {
          var first = selected[0];
          context.container = first.getContainer ? first.getContainer() : (first.container || null);
          context.model = first.model || null;
        }
      }
      if (!context.container && context.view) {
        context.container = context.view.container || (context.view.options && context.view.options.container) || null;
        context.model = context.view.model || null;
      }
      if (context.container && context.container.settings && context.container.settings.model) {
        context.model = context.container.settings.model;
      }
    }

    return context;
  }

  /* ────── Helper: Extract Photos Data Reliably ────── */
  function getPhotosData() {
    var ctx = getActiveElementorContext();

    // Source 1: Container Settings (Authoritative in Elementor)
    if (ctx.container && ctx.container.settings) {
      var cVal = typeof ctx.container.settings.get === 'function' ? ctx.container.settings.get('photos_json') : (ctx.container.settings.attributes ? ctx.container.settings.attributes.photos_json : '');
      if (cVal) {
        try {
          var cp = typeof cVal === 'string' ? JSON.parse(cVal) : cVal;
          if (Array.isArray(cp) && cp.length > 0) return cp;
        } catch(e){}
      }
    }

    // Source 2: Context Model
    if (ctx.model) {
      var mVal = typeof ctx.model.get === 'function' ? ctx.model.get('photos_json') : ctx.model.photos_json;
      if (mVal) {
        try {
          var mp = typeof mVal === 'string' ? JSON.parse(mVal) : mVal;
          if (Array.isArray(mp) && mp.length > 0) return mp;
        } catch(e){}
      }
    }

    // Source 3: DOM Input / Textarea
    var $input = $('[data-setting="photos_json"], input[name="photos_json"], textarea[name="photos_json"]');
    if ($input.length && $input.val() && $input.val().trim()) {
      try {
        var dp = JSON.parse($input.val());
        if (Array.isArray(dp) && dp.length > 0) return dp;
      } catch (e) {}
    }

    return [];
  }

  /* ────── Restore thumbnail preview & keep DOM input in sync ────── */
  function restorePreview() {
    var $c = $('#aeafe-plus-picker-container');
    if (!$c.length) return;

    var items = getPhotosData();
    var stateKey = (items && items.length > 0) ? JSON.stringify(items) : '__empty__';

    // If container is already rendered with this exact state, do nothing
    if ($c.data('aeafe-rendered-state') === stateKey) {
      return;
    }

    // Keep hidden DOM input in sync if needed without triggering loops
    if (items && items.length > 0) {
      var $input = $('[data-setting="photos_json"], input[name="photos_json"], textarea[name="photos_json"]');
      if ($input.length && $input.val() !== stateKey) {
        $input.val(stateKey);
      }
    }

    updatePanelPreview(items, stateKey);
  }

  /* ─────────────────── Launch Picker ─────────────────── */
  function handleLaunchPicker($btn) {
    var cfg = getConfig();
    var $c = $('#aeafe-plus-picker-container');
    if (!$c.length) {
      $c = $btn.closest('.aeafe-plus-picker-wrap');
    }

    var popupWidth = 920;
    var popupHeight = 720;
    var left = Math.max(0, (window.screen.width - popupWidth) / 2);
    var top = Math.max(0, (window.screen.height - popupHeight) / 2);
    var winFeatures = 'width=' + popupWidth + ',height=' + popupHeight + ',top=' + top + ',left=' + left + ',resizable=yes,scrollbars=yes,status=no';

    currentPickerWin = window.open('about:blank', 'aeafe_google_picker_win', winFeatures);

    if (currentPickerWin) {
      try {
        currentPickerWin.document.write(
          '<!DOCTYPE html><html><head><title>Google Photos Picker</title>' +
          '<style>' +
          'body{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif;margin:0;display:flex;align-items:center;justify-content:center;height:100vh;background:#1e1e2d;color:#fff;text-align:center;}' +
          '.box{padding:30px;background:#28293d;border-radius:12px;box-shadow:0 8px 30px rgba(0,0,0,0.4);max-width:380px;}' +
          '.spinner{width:36px;height:36px;border:3px solid rgba(255,255,255,0.15);border-top-color:#4285f4;border-radius:50%;animation:spin 0.8s linear infinite;margin:0 auto 18px;}' +
          '@keyframes spin{to{transform:rotate(360deg)}}' +
          'h3{margin:0 0 8px;font-size:16px;font-weight:600;color:#fff;}' +
          'p{margin:0;font-size:13px;color:#a6adb4;line-height:1.5;}' +
          '</style></head><body>' +
          '<div class="box"><div class="spinner"></div><h3>Connecting to Google Photos</h3><p>Please wait while your session is prepared…</p></div>' +
          '</body></html>'
        );
      } catch (err) {}
    }

    $btn.prop('disabled', true).addClass('aeafe-plus-loading');
    $c.find('.aeafe-plus-polling').show();
    $c.find('.aeafe-plus-polling-msg').text('Creating Google Photos session…');

    $.ajax({
      url: cfg.ajaxurl,
      type: 'POST',
      dataType: 'json',
      data: {
        action: 'aeafe_picker_create_session',
        nonce: cfg.nonce
      }
    })
    .done(function (res) {
      if (!res || !res.success) {
        var msg = res && res.data && res.data.message ? res.data.message : 'Could not create Picker session.';
        if (currentPickerWin && !currentPickerWin.closed) {
          try { currentPickerWin.close(); } catch(e){}
        }
        alert('Google Photos Picker: ' + msg);
        resetPickerState($c);
        return;
      }

      currentSessionId = res.data.session_id;
      var pickerUri = res.data.picker_uri;

      if (currentPickerWin && !currentPickerWin.closed) {
        try {
          currentPickerWin.location.href = pickerUri;
          currentPickerWin.focus();
        } catch (e) {
          window.open(pickerUri, '_blank', winFeatures);
        }
      } else {
        window.open(pickerUri, '_blank', winFeatures);
      }

      $c.find('.aeafe-plus-polling-msg').text('Waiting for you to select photos in the Google popup…');
      startPolling(currentSessionId, $c);
    })
    .fail(function (xhr) {
      if (currentPickerWin && !currentPickerWin.closed) {
        try { currentPickerWin.close(); } catch(e){}
      }
      var errMsg = 'Network error while connecting to Google Photos.';
      if (xhr && xhr.responseJSON && xhr.responseJSON.data && xhr.responseJSON.data.message) {
        errMsg = xhr.responseJSON.data.message;
      }
      alert('Error: ' + errMsg);
      resetPickerState($c);
    });
  }

  /* ─────────────────────── Polling ───────────────────── */
  function startPolling(sessionId, $c) {
    stopPolling();
    var cfg = getConfig();

    activePollTimer = setInterval(function () {
      $.ajax({
        url: cfg.ajaxurl,
        type: 'POST',
        dataType: 'json',
        data: {
          action: 'aeafe_picker_poll_session',
          nonce: cfg.nonce,
          session_id: sessionId
        }
      })
      .done(function (res) {
        if (!res || !res.success) {
          stopPolling();
          resetPickerState($c);
          return;
        }

        if (res.data && res.data.done) {
          stopPolling();
          if (currentPickerWin && !currentPickerWin.closed) {
            try { currentPickerWin.close(); } catch(e){}
          }
          var items = res.data.items || [];
          if (items.length > 0) {
            saveItemsToModel(items);
          }
          resetPickerState($c);
        }
      })
      .fail(function () {
        // Keep polling on transient hiccups
      });
    }, 2500);
  }

  function stopPolling() {
    if (activePollTimer) {
      clearInterval(activePollTimer);
      activePollTimer = null;
    }
  }

  function resetPickerState($c) {
    stopPolling();
    if (!$c || !$c.length) {
      $c = $('#aeafe-plus-picker-container');
    }
    $c.find('.aeafe-plus-launch-picker').prop('disabled', false).removeClass('aeafe-plus-loading');
    $c.find('.aeafe-plus-polling').hide();
  }

  /* ───────── Save items to Elementor model & re-render ───── */
  function saveItemsToModel(items) {
    var jsonStr = JSON.stringify(items);
    var ctx = getActiveElementorContext();

    /* 1. Update Hidden Control in Panel View */
    if (elementor.panel && elementor.panel.currentView && elementor.panel.currentView.currentPageView) {
      var pv = elementor.panel.currentView.currentPageView;
      if (typeof pv.getControlView === 'function') {
        var cv = pv.getControlView('photos_json');
        if (cv && typeof cv.setValue === 'function') {
          cv.setValue(jsonStr);
          if (typeof cv.applySavedValue === 'function') {
            cv.applySavedValue();
          }
        }
      }
    }

    /* 2. Update DOM hidden input */
    var $input = $('[data-setting="photos_json"], input[name="photos_json"], textarea[name="photos_json"]');
    if ($input.length) {
      $input.val(jsonStr);
      $input.trigger('input').trigger('change');
    }

    /* 3. Direct Container Settings Update */
    if (ctx.container && ctx.container.settings) {
      if (typeof ctx.container.settings.set === 'function') {
        ctx.container.settings.set('photos_json', jsonStr);
      }
      if (ctx.container.settings.attributes) {
        ctx.container.settings.attributes.photos_json = jsonStr;
      }
    }

    /* 4. Direct Model Update */
    if (ctx.model) {
      if (typeof ctx.model.set === 'function') {
        ctx.model.set('photos_json', jsonStr);
      }
      if (typeof ctx.model.setSetting === 'function') {
        ctx.model.setSetting('photos_json', jsonStr);
      }
    }

    /* 5. Elementor Command API ($e.run) */
    if (window.$e && $e.run && ctx.container) {
      try {
        $e.run('document/elements/settings', {
          container: ctx.container,
          settings: {
            photos_json: jsonStr
          },
          options: {
            external: true,
            render: true
          }
        });
      } catch (err) {}
    }

    /* 6. Force canvas render */
    if (ctx.container) {
      if (typeof ctx.container.renderRemote === 'function') {
        ctx.container.renderRemote();
      } else if (ctx.container.renderer && typeof ctx.container.renderer.render === 'function') {
        ctx.container.renderer.render();
      }
    }

    /* 7. Mark document changed so Update button activates */
    if (window.elementor && elementor.saver && typeof elementor.saver.setFlagEditorChange === 'function') {
      elementor.saver.setFlagEditorChange(true);
    }

    updatePanelPreview(items);
  }

  /* ─────────────────── Clear Photos ─────────────────── */
  function handleClearPhotos() {
    if (!confirm('Are you sure you want to clear the selected photos?')) return;
    var ctx = getActiveElementorContext();

    var $input = $('[data-setting="photos_json"], input[name="photos_json"], textarea[name="photos_json"]');
    if ($input.length) {
      $input.val('');
      $input.trigger('input').trigger('change');
    }

    if (elementor.panel && elementor.panel.currentView && elementor.panel.currentView.currentPageView) {
      var pv = elementor.panel.currentView.currentPageView;
      if (typeof pv.getControlView === 'function') {
        var cv = pv.getControlView('photos_json');
        if (cv && typeof cv.setValue === 'function') {
          cv.setValue('');
        }
      }
    }

    if (ctx.container && ctx.container.settings) {
      if (typeof ctx.container.settings.set === 'function') {
        ctx.container.settings.set('photos_json', '');
      }
      if (ctx.container.settings.attributes) {
        ctx.container.settings.attributes.photos_json = '';
      }
    }

    if (ctx.model) {
      if (typeof ctx.model.set === 'function') {
        ctx.model.set('photos_json', '');
      }
      if (typeof ctx.model.setSetting === 'function') {
        ctx.model.setSetting('photos_json', '');
      }
    }

    if (window.$e && $e.run && ctx.container) {
      try {
        $e.run('document/elements/settings', {
          container: ctx.container,
          settings: { photos_json: '' }
        });
      } catch (e) {}
    }

    if (ctx.container && typeof ctx.container.renderRemote === 'function') {
      ctx.container.renderRemote();
    }

    updatePanelPreview([], '__empty__');
  }

  /* ─────────────── Panel Thumbnail Preview ─────────── */
  function updatePanelPreview(items, stateKey) {
    var cfg = getConfig();
    var $c = $('#aeafe-plus-picker-container');
    if (!$c.length) return;

    var currentKey = stateKey || ((items && items.length > 0) ? JSON.stringify(items) : '__empty__');
    $c.data('aeafe-rendered-state', currentKey);

    var $summary  = $c.find('.aeafe-plus-summary');
    var $grid     = $c.find('.aeafe-plus-thumbs-grid');
    var $badge    = $c.find('.aeafe-plus-count-badge');
    var $clearBtn = $c.find('.aeafe-plus-clear-photos');
    var $btnText  = $c.find('.aeafe-plus-btn-text');

    if (items && Array.isArray(items) && items.length > 0) {
      $badge.text(items.length + (items.length === 1 ? ' photo' : ' photos'));
      $grid.empty();
      var max = Math.min(items.length, 12);
      for (var i = 0; i < max; i++) {
        var item  = items[i];
        var thumb = item.thumbnail || (item.base_url ? item.base_url + '=w100-h100-c' : '');
        if (thumb) {
          var proxy = cfg.ajaxurl + '?action=aeafe_picker_proxy_image&url=' + encodeURIComponent(thumb);
          $grid.append('<div class="aeafe-plus-thumb-item"><img src="' + proxy + '" alt="" loading="lazy"></div>');
        }
      }
      if (items.length > 12) {
        $grid.append('<div class="aeafe-plus-thumb-more">+' + (items.length - 12) + '</div>');
      }
      $summary.show();
      $clearBtn.show();
      $btnText.text('Change / Add Photos');
    } else {
      $summary.hide();
      $grid.empty();
      $clearBtn.hide();
      $btnText.text('Select Photos from Google');
    }
  }

})(jQuery);