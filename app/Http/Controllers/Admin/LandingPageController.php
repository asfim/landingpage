<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingPage;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{

    /**
     * Show a full preview of the landing page (clean, no editor).
     */
    public function view()
    {
        return view('admin.landing-page.view');
    }

    /**
     * Show the landing page editor (admin iframe page).
     */
    public function edit()
    {
        return view('admin.landing-page.edit');
    }

    /**
     * Save the updated landing page HTML to the database.
     */
    public function update(Request $request)
    {
        $request->validate([
            'html' => ['required', 'string'],
        ]);

        LandingPage::saveDefault($request->input('html'));

        return response()->json([
            'success' => true,
            'message' => '✅ Landing page database এ সেভ হয়েছে!',
        ]);
    }

    /**
     * Serve the raw clean landing page HTML (for view/preview).
     */
    public function serve()
    {
        $html = $this->getHtml();
        return response($html, 200)->header('Content-Type', 'text/html; charset=UTF-8');
    }

    /**
     * Serve the landing page HTML WITH the editor widget injected (for edit mode).
     */
    public function serveEditable()
    {
        $html = $this->getHtml();

        // Inject editor styles before </head>
        $editorStyles = $this->getEditorStyles();
        $html = str_replace('</head>', $editorStyles . "\n</head>", $html);

        // Inject editor widget + scripts before </body>
        $editorWidget = $this->getEditorWidget();
        $html = str_replace('</body>', $editorWidget . "\n</body>", $html);

        return response($html, 200)->header('Content-Type', 'text/html; charset=UTF-8');
    }

    /**
     * Read HTML from the database (auto-seeds from mystery-box.html on first load).
     */
    protected function getHtml(): string
    {
        $html = LandingPage::getDefault()->content;

        $assetUrl = asset('uploads/');
        $assetUrl = rtrim($assetUrl, '/') . '/';

        return preg_replace('/https?:\/\/[^\/]+\/uploads\//i', $assetUrl, $html);
    }

    /**
     * Upload an image to public/uploads directory.
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Ensure uploads directory exists
            if (!file_exists(public_path('uploads'))) {
                mkdir(public_path('uploads'), 0755, true);
            }

            $file->move(public_path('uploads'), $filename);
            $url = asset('uploads/' . $filename);

            return response()->json([
                'success' => true,
                'url' => $url,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Image upload failed.',
        ], 400);
    }

    /**
     * Editor CSS to inject into <head>.
     * Uses nowdoc so CSS content is never interpolated by PHP.
     */
    protected function getEditorStyles(): string
    {
        return <<<'ENDSTYLE'
<style id="admin-editor-styles">
#admin-editor-panel {
  position: fixed;
  bottom: 20px;
  right: 20px;
  width: 300px;
  background: rgba(15, 23, 42, 0.92);
  backdrop-filter: blur(20px) saturate(180%);
  -webkit-backdrop-filter: blur(20px) saturate(180%);
  border: 1px solid rgba(255,255,255,0.12);
  border-radius: 18px;
  box-shadow: 0 20px 60px rgba(0,0,0,0.4), 0 0 0 1px rgba(255,255,255,0.04);
  color: #f3f4f6;
  font-family: system-ui, -apple-system, sans-serif;
  z-index: 999999;
  transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
  overflow: hidden;
}
#admin-editor-panel.minimized {
  height: 52px;
  border-radius: 26px;
}
.aep-header {
  display: flex; align-items: center; justify-content: space-between;
  padding: 14px 16px;
  cursor: pointer;
  user-select: none;
  border-bottom: 1px solid rgba(255,255,255,0.08);
}
#admin-editor-panel.minimized .aep-header { border-bottom: none; }
.aep-title {
  font-size: 13px; font-weight: 700; letter-spacing: 0.3px;
  display: flex; align-items: center; gap: 6px;
}
.aep-title-dot {
  width: 7px; height: 7px; border-radius: 50%;
  background: #f2621f; animation: aepPulse 2s infinite;
}
@keyframes aepPulse {
  0%,100% { opacity:1; transform:scale(1); }
  50% { opacity:0.5; transform:scale(0.8); }
}
.aep-minimize-btn {
  width: 22px; height: 22px; border-radius: 50%;
  background: rgba(255,255,255,0.1); border: none;
  color: #fff; cursor: pointer; font-size: 10px;
  display: flex; align-items: center; justify-content: center;
  transition: background 0.2s;
}
.aep-minimize-btn:hover { background: rgba(255,255,255,0.2); }
.aep-body {
  padding: 14px 16px;
  display: flex; flex-direction: column; gap: 12px;
}
#admin-editor-panel.minimized .aep-body {
  opacity: 0; pointer-events: none; height: 0; padding: 0; overflow: hidden;
}
.aep-row {
  display: flex; align-items: center; justify-content: space-between;
}
.aep-label {
  font-size: 11px; font-weight: 700; letter-spacing: 0.8px;
  text-transform: uppercase; color: #94a3b8;
}
.aep-switch { position:relative; display:inline-block; width:38px; height:20px; }
.aep-switch input { opacity:0; width:0; height:0; }
.aep-slider {
  position:absolute; cursor:pointer; top:0; left:0; right:0; bottom:0;
  background:#374151; border-radius:20px; transition:.2s;
}
.aep-slider:before {
  position:absolute; content:""; height:14px; width:14px;
  left:3px; bottom:3px; background:#fff; border-radius:50%; transition:.2s;
}
.aep-switch input:checked + .aep-slider { background:#f2621f; }
.aep-switch input:checked + .aep-slider:before { transform:translateX(18px); }
.aep-colors { display:flex; gap:8px; flex-wrap:wrap; }
.aep-color-item {
  display:flex; align-items:center; gap:5px;
  background: rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.08);
  padding:4px 10px; border-radius:20px; cursor:pointer;
}
.aep-color-item input[type="color"] {
  -webkit-appearance:none; border:none; width:16px; height:16px;
  border-radius:50%; cursor:pointer; background:none; padding:0; margin:0;
}
.aep-color-item input[type="color"]::-webkit-color-swatch-wrapper { padding:0; }
.aep-color-item input[type="color"]::-webkit-color-swatch {
  border:1px solid rgba(255,255,255,0.25); border-radius:50%;
}
.aep-color-name { font-size:10px; color:#d1d5db; }
.aep-divider { height:1px; background:rgba(255,255,255,0.07); }
.aep-btn {
  width:100%; padding:9px; border-radius:8px; font-size:12px; font-weight:700;
  cursor:pointer; border:none; font-family:inherit; transition:all 0.2s;
  display:flex; align-items:center; justify-content:center; gap:6px;
}
.aep-btn-save {
  background: linear-gradient(135deg, #f2621f, #e2530f); color:#fff;
  box-shadow: 0 4px 15px rgba(242,98,31,0.3);
}
.aep-btn-save:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(242,98,31,0.4); }
.aep-btn-secondary {
  background:rgba(255,255,255,0.07); border:1px solid rgba(255,255,255,0.08); color:#f3f4f6;
}
.aep-btn-secondary:hover { background:rgba(255,255,255,0.14); transform:translateY(-1px); }
body.aep-edit-active [data-editable] {
  cursor: pointer; transition: outline 0.15s;
}
body.aep-edit-active [data-editable]:hover {
  outline: 2px dashed #f2621f !important;
  outline-offset: 2px;
  background-color: rgba(242,98,31,0.06);
}
body.aep-edit-active [data-editable].aep-editing {
  outline: 2px solid #f2621f !important;
  outline-offset: 2px;
  background-color: rgba(242,98,31,0.1);
  cursor: text;
}
#aep-toast {
  position:fixed; bottom:20px; left:50%;
  transform:translateX(-50%) translateY(120px);
  background:#1e293b; border:1px solid rgba(242,98,31,0.4); color:#f1f5f9;
  padding:10px 20px; border-radius:10px; font-size:13px; font-weight:600;
  display:flex; align-items:center; gap:8px;
  box-shadow:0 10px 30px rgba(0,0,0,0.3);
  transition:transform 0.35s cubic-bezier(0.34,1.56,0.64,1);
  z-index:999998;
}
#aep-toast.show { transform:translateX(-50%) translateY(0); }
</style>
ENDSTYLE;
    }

    /**
     * Editor widget HTML + JS to inject before </body>.
     *
     * Uses nowdoc (<<<'ENDWIDGET') so PHP does NOT interpolate any $ signs
     * inside the JavaScript. The two PHP values are injected via str_replace
     * after the nowdoc string is built.
     */
    protected function getEditorWidget(): string
    {
        $saveUrl   = route('admin.landing-page.update');
        $csrfToken = csrf_token();

        $widget = <<<'ENDWIDGET'
<!-- Admin Editor Panel injected by LandingPageController -->
<div id="admin-editor-panel">
  <div class="aep-header" onclick="aepToggleMinimize()">
    <div class="aep-title">
      <span class="aep-title-dot"></span>
      Landing Page Editor
    </div>
    <button class="aep-minimize-btn" id="aep-min-btn">➖</button>
  </div>
  <div class="aep-body">

    <div class="aep-divider"></div>


    <div class="aep-row">
      <span class="aep-label">রঙ পরিবর্তন</span>
    </div>
    <div class="aep-colors">
      <div class="aep-color-item">
        <input type="color" id="aep-color-primary" value="#f2621f">
        <span class="aep-color-name">Primary</span>
      </div>
      <div class="aep-color-item">
        <input type="color" id="aep-color-bg" value="#f2621f">
        <span class="aep-color-name">Background</span>
      </div>
    </div>

    <div class="aep-divider"></div>

    <div style="display:flex;flex-direction:column;gap:8px;">
      <button class="aep-btn aep-btn-save" onclick="aepSaveToServer()">
        💾 সার্ভারে সেভ করুন
      </button>
      <button class="aep-btn aep-btn-secondary" onclick="aepExportClean()">
        🚀 Export Clean Page
      </button>
    </div>
  </div>
</div>

<div id="aep-toast">✅ <span id="aep-toast-msg">সফলভাবে সেভ হয়েছে!</span></div>

<script id="admin-editor-script">
(function() {
  /* PHP values injected via str_replace — not heredoc interpolation */
  var SAVE_URL   = 'AEP_SAVE_URL';
  var CSRF_TOKEN = 'AEP_CSRF_TOKEN';

  var EDITABLE_SELECTORS = [
    '.header-text .eyebrow','.header-text .brand',
    '.offer-eyebrow','.offer-title',
    '.timer-label','.pack-name','.pack-price','.form-title','.form-sub',
    'label:not(.aep-switch)','.btn-primary','.section-title',
    '.policy-item h4','.policy-item p','.policy-item li','.fbrand','.fcopy',
    '.pack-img'
  ];

  function darkenColor(hex, pct) {
    var n = parseInt(hex.replace('#',''), 16),
        a = Math.round(2.55 * pct),
        r = (n >> 16) - a,
        g = ((n >> 8) & 0xFF) - a,
        b = (n & 0xFF) - a;
    function clamp(v) { return Math.max(0, Math.min(255, v)); }
    return '#' + (0x1000000 + clamp(r)*0x10000 + clamp(g)*0x100 + clamp(b)).toString(16).slice(1);
  }

  /* ── Restore saved theme colors ──────────────────── */
  var savedPrimary = localStorage.getItem('aep_color_primary');
  if (savedPrimary) {
    document.documentElement.style.setProperty('--orange', savedPrimary);
    document.documentElement.style.setProperty('--orange-dark', darkenColor(savedPrimary, 10));
    document.getElementById('aep-color-primary').value = savedPrimary;
  }
  var savedBg = localStorage.getItem('aep_color_bg');
  if (savedBg) {
    document.documentElement.style.setProperty('--page-bg', savedBg);
    document.getElementById('aep-color-bg').value = savedBg;
  }

  /* ── Mark editable elements ───────────────────────── */
  var editIdx = 0;
  EDITABLE_SELECTORS.forEach(function(sel) {
    document.querySelectorAll(sel).forEach(function(el) {
      el.setAttribute('data-editable', 'true');
      el.setAttribute('data-edit-key', 'k' + editIdx);
      var savedVal = localStorage.getItem('aep_edit_k' + editIdx);
      if (savedVal !== null) {
        if (el.tagName.toLowerCase() === 'img') {
          el.src = savedVal;
        } else {
          el.innerHTML = savedVal;
        }
      }
      editIdx++;
    });
  });

  /* ── Delivery charge ──────────────────────────────── */
  document.querySelectorAll('.summary-row').forEach(function(row) {
    if (row.textContent.indexOf('ডেলিভারি চার্জ') !== -1) {
      var chargeSpan = row.querySelector('span:last-child');
      if (chargeSpan) {
        chargeSpan.setAttribute('data-editable', 'true');
        chargeSpan.setAttribute('data-edit-key', 'delivery_charge');
        chargeSpan.classList.add('aep-delivery-span');
        var savedCharge = localStorage.getItem('aep_edit_delivery_charge');
        if (savedCharge !== null) chargeSpan.innerHTML = savedCharge;
      }
    }
  });

  /* ── Sync pack buttons ────────────────────────────── */
  document.querySelectorAll('.pack').forEach(function(packEl) {
    var nameEl  = packEl.querySelector('.pack-name');
    var priceEl = packEl.querySelector('.pack-price');
    if (nameEl)  packEl.setAttribute('data-name', nameEl.textContent.trim());
    if (priceEl) {
      var pv = parseFloat(priceEl.textContent.replace(/[^\d.]/g, ''));
      if (!isNaN(pv)) packEl.setAttribute('data-price', pv);
    }
  });
  var activePack = document.querySelector('.pack.active');
  if (activePack) activePack.click();

  /* ── Edit mode always ON ──────────────────────────── */
  document.body.classList.add('aep-edit-active');

  /* ── Double-click to start editing ───────────────── */
  document.addEventListener('dblclick', function(e) {
    /* edit mode is always active */
    var target = e.target.closest('[data-editable]');
    if (!target || target.closest('#admin-editor-panel')) return;
    
    if (target.tagName.toLowerCase() === 'img') {
      e.preventDefault();
      e.stopPropagation();
      return; // Handled by single-click
    }

    e.preventDefault();
    target.setAttribute('contenteditable', 'true');
    target.classList.add('aep-editing');
    target.focus();
    var range = document.createRange();
    range.selectNodeContents(target);
    var sel = window.getSelection();
    sel.removeAllRanges();
    sel.addRange(range);
  });

  /* ── Single-click to trigger Image Upload ─────────── */
  document.addEventListener('click', function(e) {
    var target = e.target.closest('[data-editable]');
    if (!target || target.closest('#admin-editor-panel')) return;

    if (target.tagName.toLowerCase() === 'img') {
      e.preventDefault();
      e.stopPropagation(); // Stop parent click events (like package active class toggles)
      triggerImageUpload(target);
    }
  });

  /* ── Trigger Image Upload via AJAX ────────────────── */
  function triggerImageUpload(imgElement) {
    var fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.accept = 'image/*';
    fileInput.onchange = async function() {
      if (fileInput.files.length === 0) return;
      var file = fileInput.files[0];
      var formData = new FormData();
      formData.append('image', file);

      showToast('⏳ ইমেজ আপলোড হচ্ছে...');

      try {
        var response = await fetch('/admin/landing-page/upload-image', {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN
          },
          body: formData
        });
        var data = await response.json();
        if (data.success) {
          imgElement.src = data.url;
          
          // Save path to localStorage
          var key = imgElement.getAttribute('data-edit-key');
          if (key) {
            localStorage.setItem('aep_edit_' + key, data.url);
          }

          showToast('✅ ইমেজ সফলভাবে আপলোড হয়েছে!');
        } else {
          showToast('❌ আপলোড ব্যর্থ হয়েছে!', false);
        }
      } catch (err) {
        showToast('❌ আপলোড করতে সমস্যা হয়েছে!', false);
      }
    };
    fileInput.click();
  }

  /* ── Finish editing ───────────────────────────────── */
  function finishEdit(el) {
    el.removeAttribute('contenteditable');
    el.classList.remove('aep-editing');
    var key = el.getAttribute('data-edit-key');
    if (key) localStorage.setItem('aep_edit_' + key, el.innerHTML);
    var packParent = el.closest('.pack');
    if (packParent) {
      if (el.classList.contains('pack-name'))
        packParent.setAttribute('data-name', el.textContent.trim());
      if (el.classList.contains('pack-price')) {
        var pv2 = parseFloat(el.textContent.replace(/[^\d.]/g, ''));
        if (!isNaN(pv2)) packParent.setAttribute('data-price', pv2);
      }
      packParent.click();
    }
    if (el.classList.contains('aep-delivery-span')) {
      var cv = parseFloat(el.textContent.replace(/[^\d.]/g, ''));
      if (!isNaN(cv)) window.codCharge = cv;
      var currentActive = document.querySelector('.pack.active');
      if (currentActive) currentActive.click();
    }
  }
  document.addEventListener('focusout', function(e) {
    var t = e.target.closest('[data-editable]');
    if (t) finishEdit(t);
  });
  document.addEventListener('keydown', function(e) {
    var t = e.target.closest('[data-editable]');
    if (!t) return;
    if (e.key === 'Enter' && !t.matches('textarea,p,li')) { e.preventDefault(); t.blur(); }
    if (e.key === 'Escape') { e.preventDefault(); document.execCommand('undo'); t.blur(); }
  });

  /* ── Color pickers ────────────────────────────────── */
  document.getElementById('aep-color-primary').addEventListener('input', function(e) {
    var color = e.target.value;
    document.documentElement.style.setProperty('--orange', color);
    document.documentElement.style.setProperty('--orange-dark', darkenColor(color, 10));
    localStorage.setItem('aep_color_primary', color);
  });
  document.getElementById('aep-color-bg').addEventListener('input', function(e) {
    var color = e.target.value;
    document.documentElement.style.setProperty('--page-bg', color);
    localStorage.setItem('aep_color_bg', color);
  });

  /* ── Minimize / expand panel ──────────────────────── */
  window.aepToggleMinimize = function() {
    var panel = document.getElementById('admin-editor-panel');
    var btn   = document.getElementById('aep-min-btn');
    panel.classList.toggle('minimized');
    btn.textContent = panel.classList.contains('minimized') ? '➕' : '➖';
  };

  /* ── Toast helper ─────────────────────────────────── */
  function showToast(msg, ok) {
    if (ok === undefined) ok = true;
    var toast   = document.getElementById('aep-toast');
    var toastMsg = document.getElementById('aep-toast-msg');
    toastMsg.textContent = msg;
    toast.style.borderColor = ok
      ? 'rgba(242,98,31,0.4)'
      : 'rgba(248,113,113,0.4)';
    toast.classList.add('show');
    setTimeout(function() { toast.classList.remove('show'); }, 3000);
  }

  /* ── Save to Laravel server (saves CLEAN HTML — editor widget removed) ── */
  window.aepSaveToServer = async function() {
    var saveBtn = document.querySelector('.aep-btn-save');
    if (saveBtn) { saveBtn.textContent = '⏳ সেভ হচ্ছে...'; saveBtn.disabled = true; }

    /* 1. Clone the full document so we never mutate the live DOM */
    var clone = document.documentElement.cloneNode(true);

    /* 2. Remove all editor-injected elements from the clone */
    ['#admin-editor-panel','#aep-toast','#admin-editor-styles','#admin-editor-script'].forEach(function(sel) {
      var el = clone.querySelector(sel); if (el) el.remove();
    });

    /* 3. Strip editor-specific attributes & classes */
    clone.querySelector('body').classList.remove('aep-edit-active');
    clone.querySelectorAll('[data-editable]').forEach(function(el) {
      el.removeAttribute('data-editable');
      el.removeAttribute('data-edit-key');
      el.removeAttribute('contenteditable');
      el.classList.remove('aep-editing');
    });
    clone.querySelectorAll('.aep-delivery-span').forEach(function(el) {
      el.classList.remove('aep-delivery-span');
    });
    clone.querySelectorAll('img').forEach(function(el) {
      var src = el.getAttribute('src');
      if (src && src.startsWith(window.location.origin)) {
        el.setAttribute('src', src.substring(window.location.origin.length));
      }
    });

    /* 4. Embed current CSS variable values so colors persist in the saved file */
    var colorPrimary = document.documentElement.style.getPropertyValue('--orange');
    var colorBg      = document.documentElement.style.getPropertyValue('--page-bg');
    var inlineStyle  = '';
    if (colorPrimary) inlineStyle += ' --orange:' + colorPrimary + '; --orange-dark:' + darkenColor(colorPrimary, 10) + ';';
    if (colorBg)      inlineStyle += ' --page-bg:' + colorBg + ';';
    if (inlineStyle)  clone.setAttribute('style', inlineStyle);

    /* 5. Build clean HTML string and POST to server */
    var htmlStr = '<!DOCTYPE html>\n' + clone.outerHTML;

    try {
      var res = await fetch(SAVE_URL, {
        method: 'POST',
        headers: {
          'Content-Type':  'application/json',
          'X-CSRF-TOKEN':  CSRF_TOKEN,
          'Accept':        'application/json'
        },
        body: JSON.stringify({ html: htmlStr })
      });
      var data = await res.json();
      showToast(data.message || '✅ সফলভাবে সেভ হয়েছে!', true);
    } catch(err) {
      showToast('❌ সেভ করতে সমস্যা হয়েছে!', false);
    } finally {
      if (saveBtn) { saveBtn.textContent = '💾 সার্ভারে সেভ করুন'; saveBtn.disabled = false; }
    }
  };

  /* ── Export clean HTML (no editor widget) ─────────── */
  window.aepExportClean = function() {
    var clone = document.documentElement.cloneNode(true);
    ['#admin-editor-panel', '#aep-toast', '#admin-editor-styles', '#admin-editor-script'].forEach(function(sel) {
      var el = clone.querySelector(sel);
      if (el) el.remove();
    });
    clone.querySelector('body').classList.remove('aep-edit-active');
    clone.querySelectorAll('[data-editable]').forEach(function(el) {
      el.removeAttribute('data-editable');
      el.removeAttribute('data-edit-key');
    });
    clone.querySelectorAll('.aep-delivery-span').forEach(function(el) {
      el.classList.remove('aep-delivery-span');
    });
    clone.querySelectorAll('img').forEach(function(el) {
      var src = el.getAttribute('src');
      if (src && src.startsWith(window.location.origin)) {
        el.setAttribute('src', src.substring(window.location.origin.length));
      }
    });
    var colorP2  = document.documentElement.style.getPropertyValue('--orange');
    var colorBg2 = document.documentElement.style.getPropertyValue('--page-bg');
    var inlineStyle2 = '';
    if (colorP2)  inlineStyle2 += ' --orange:' + colorP2 + ';';
    if (colorBg2) inlineStyle2 += ' --page-bg:' + colorBg2 + ';';
    if (inlineStyle2) clone.setAttribute('style', inlineStyle2);

    var blob = new Blob(['<!DOCTYPE html>\n' + clone.outerHTML], { type: 'text/html;charset=utf-8' });
    var url  = URL.createObjectURL(blob);
    var a    = document.createElement('a');
    a.href   = url;
    a.download = 'mystery-box-clean.html';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
  };

})();
</script>
ENDWIDGET;

        // Inject the two PHP-side values via str_replace (safe — no heredoc interpolation)
        $widget = str_replace('AEP_SAVE_URL',   $saveUrl,   $widget);
        $widget = str_replace('AEP_CSRF_TOKEN', $csrfToken, $widget);

        return $widget;
    }
}
