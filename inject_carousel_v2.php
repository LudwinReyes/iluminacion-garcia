<?php
/**
 * Reinject improved testimonials carousel into Elementor widget 4161a02
 */
require_once( 'wp-load.php' );

$post_id   = 4179;
$widget_id = '4161a02';
$meta_key  = '_elementor_data';

$raw  = get_post_meta( $post_id, $meta_key, true );
$data = json_decode( $raw, true );
if ( ! $data ) { die( "ERROR: Could not decode Elementor data\n" ); }

/* ------------------------------------------------------------------ */
$html = <<<'HTMLEND'
<style>
/* ============ TESTIMONIOS CAROUSEL V2 ============ */
#ilg-section {
  width: 100%;
  box-sizing: border-box;
  font-family: 'Inter Tight', 'Inter', sans-serif;
  padding: 0 5vw;
}

/* --- Header --- */
.ilg-test-header { text-align: center; margin-bottom: 52px; }
.ilg-test-badge {
  display: inline-flex; align-items: center; gap: 8px;
  background: rgba(237,164,8,.12); border: 1px solid rgba(237,164,8,.35);
  border-radius: 100px; padding: 6px 20px; font-size: 12px; font-weight: 700;
  color: #eda408; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 18px;
}
.ilg-test-title {
  font-size: clamp(24px, 3vw, 38px); font-weight: 800; color: #fff;
  margin: 0 0 12px; line-height: 1.2;
}
.ilg-test-subtitle { font-size: 15px; color: #8fa3c8; margin: 0; line-height: 1.6; }

/* --- Carousel --- */
.ilg-carousel-outer {
  position: relative;
  overflow: hidden;
  margin: 0 40px; /* room for arrows */
}
@media(max-width:600px){ .ilg-carousel-outer { margin: 0 12px; } }

.ilg-carousel-track {
  display: flex;
  will-change: transform;
  /* transition set via JS after init */
}

/* --- Cards --- */
.ilg-card {
  flex-shrink: 0;
  box-sizing: border-box;
  padding: 0 10px;
}
.ilg-card-inner {
  background: linear-gradient(145deg, #1a2744, #0f1d35);
  border: 1px solid rgba(237,164,8,.15);
  border-radius: 16px;
  padding: 32px 28px;
  min-height: 260px;
  box-sizing: border-box;
  position: relative;
  transition: transform .3s ease, border-color .3s ease, box-shadow .3s ease;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
.ilg-card-inner::before {
  content: '\201C';
  position: absolute; top: -8px; right: 18px;
  font-size: 110px; line-height: 1; color: rgba(237,164,8,.07);
  font-family: Georgia, serif; pointer-events: none; user-select: none;
}
.ilg-card-inner:hover {
  transform: translateY(-5px);
  border-color: rgba(237,164,8,.5);
  box-shadow: 0 24px 60px rgba(0,0,0,.45);
}

/* Stars */
.ilg-stars { color: #eda408; font-size: 17px; letter-spacing: 2px; margin-bottom: 14px; display: block; }
/* Quote */
.ilg-quote { font-size: 14px; line-height: 1.75; color: #bfcfe8; margin: 0 0 20px; font-style: italic; flex: 1; }
/* Divider */
.ilg-divider { width: 36px; height: 2px; background: linear-gradient(90deg, #eda408, transparent); border-radius: 2px; margin-bottom: 18px; }
/* Author */
.ilg-author-row { display: flex; align-items: center; gap: 10px; }
.ilg-avatar {
  width: 40px; height: 40px; border-radius: 50%;
  background: linear-gradient(135deg,#eda408,#c07d00);
  display: flex; align-items: center; justify-content: center;
  font-size: 16px; font-weight: 700; color: #0a1628; flex-shrink: 0;
}
.ilg-author-name { font-size: 14px; font-weight: 700; color: #fff; margin: 0 0 2px; }
.ilg-author-role { font-size: 11px; color: #5e7aaa; margin: 0; }

/* --- Navigation arrows --- */
.ilg-nav {
  position: absolute; top: 50%; transform: translateY(-50%);
  width: 40px; height: 40px; border-radius: 50%;
  background: rgba(237,164,8,.15); border: 1.5px solid rgba(237,164,8,.4);
  display: flex !important; align-items: center; justify-content: center;
  cursor: pointer; z-index: 20;
  color: #eda408;
  transition: background .25s ease, color .25s ease, border-color .25s ease;
  box-sizing: border-box; outline: none;
  padding: 0; line-height: 1;
}
.ilg-nav svg { display: block; width: 18px; height: 18px; }
.ilg-nav:hover { background: #eda408; color: #0a1628; border-color: #eda408; }
.ilg-nav:hover svg { stroke: #0a1628; }
.ilg-nav svg { stroke: #eda408; fill: none; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round; }
.ilg-nav:hover svg { stroke: #0a1628; }
.ilg-nav-prev { left: -52px; }
.ilg-nav-next { right: -52px; }
@media(max-width:600px){ .ilg-nav-prev{ left:-44px; } .ilg-nav-next{ right:-44px; } }

/* --- Dots --- */
.ilg-dots {
  display: flex; justify-content: center; align-items: center;
  gap: 8px; margin-top: 36px;
}
.ilg-dot {
  display: block; border-radius: 50%;
  background: rgba(143,163,200,.3);
  transition: all .3s ease;
  cursor: pointer;
  width: 8px; height: 8px;
  flex-shrink: 0;
}
.ilg-dot.active {
  background: #eda408;
  width: 24px; border-radius: 4px;
}
</style>

<div id="ilg-section">

  <!-- Header -->
  <div class="ilg-test-header">
    <div class="ilg-test-badge">&#9733; Clientes Satisfechos</div>
    <h2 class="ilg-test-title">Lo que dicen nuestros clientes</h2>
    <p class="ilg-test-subtitle">M&aacute;s de 10 a&ntilde;os respaldando industrias, comercios y hogares en todo el Per&uacute;</p>
  </div>

  <!-- Carousel -->
  <div class="ilg-carousel-outer" id="ilg-co">

    <button class="ilg-nav ilg-nav-prev" id="ilg-prev" aria-label="Anterior">
      <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    </button>
    <button class="ilg-nav ilg-nav-next" id="ilg-next" aria-label="Siguiente">
      <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
    </button>

    <div class="ilg-carousel-track" id="ilg-track">
      <!-- NOTE: JS will clone cards for infinite loop -->

      <div class="ilg-card" data-real="1">
        <div class="ilg-card-inner">
          <div>
            <span class="ilg-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
            <p class="ilg-quote">&ldquo;Excelente atenci&oacute;n y productos de alta calidad. Compramos luminarias LED para nuestro almac&eacute;n industrial y el ahorro en electricidad fue notable desde el primer mes. 100% recomendables.&rdquo;</p>
          </div>
          <div>
            <div class="ilg-divider"></div>
            <div class="ilg-author-row">
              <div class="ilg-avatar">C</div>
              <div><p class="ilg-author-name">Carlos M.</p><p class="ilg-author-role">Gerente de Planta &mdash; Sector Industrial, Lima</p></div>
            </div>
          </div>
        </div>
      </div>

      <div class="ilg-card" data-real="1">
        <div class="ilg-card-inner">
          <div>
            <span class="ilg-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
            <p class="ilg-quote">&ldquo;Pedimos tomacorrientes e interruptores Btic&iacute;no al por mayor para una obra en Miraflores. El despacho fue r&aacute;pido y los precios los mejores del mercado. Definitivamente nuestro proveedor fijo.&rdquo;</p>
          </div>
          <div>
            <div class="ilg-divider"></div>
            <div class="ilg-author-row">
              <div class="ilg-avatar">R</div>
              <div><p class="ilg-author-name">Rosa T.</p><p class="ilg-author-role">Contratista El&eacute;ctrica &mdash; Construcci&oacute;n, Lima</p></div>
            </div>
          </div>
        </div>
      </div>

      <div class="ilg-card" data-real="1">
        <div class="ilg-card-inner">
          <div>
            <span class="ilg-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
            <p class="ilg-quote">&ldquo;Compramos dicroicos LED Philips y paneles para la renovaci&oacute;n de nuestra tienda en San Isidro. El asesor nos gui&oacute; perfecto. La instalaci&oacute;n final qued&oacute; espectacular.&rdquo;</p>
          </div>
          <div>
            <div class="ilg-divider"></div>
            <div class="ilg-author-row">
              <div class="ilg-avatar">M</div>
              <div><p class="ilg-author-name">Miriam L.</p><p class="ilg-author-role">Propietaria de Tienda &mdash; Retail, San Isidro</p></div>
            </div>
          </div>
        </div>
      </div>

      <div class="ilg-card" data-real="1">
        <div class="ilg-card-inner">
          <div>
            <span class="ilg-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
            <p class="ilg-quote">&ldquo;Gran variedad de productos el&eacute;ctricos y excelente servicio. Los precios mayoristas son muy competitivos. Muy recomendados para proyectos de gran envergadura.&rdquo;</p>
          </div>
          <div>
            <div class="ilg-divider"></div>
            <div class="ilg-author-row">
              <div class="ilg-avatar">J</div>
              <div><p class="ilg-author-name">Jorge P.</p><p class="ilg-author-role">Ingeniero El&eacute;ctrico &mdash; Proyectos, Lima Norte</p></div>
            </div>
          </div>
        </div>
      </div>

    </div><!-- /track -->
  </div><!-- /carousel-outer -->

  <!-- Dots -->
  <div class="ilg-dots" id="ilg-dots"></div>

</div>

<script>
(function () {
  var outer   = document.getElementById('ilg-co');
  var track   = document.getElementById('ilg-track');
  var dotsWrap= document.getElementById('ilg-dots');
  var prevBtn = document.getElementById('ilg-prev');
  var nextBtn = document.getElementById('ilg-next');
  if (!track) return;

  var REAL_COUNT = track.querySelectorAll('.ilg-card[data-real]').length;
  var ANIM_MS    = 520;
  var AUTO_MS    = 4500;
  var isAnimating = false;
  var autoTimer   = null;
  var cur = 0; // index among real cards (0-based)

  /* ---- How many visible at once ---- */
  function vis() {
    var w = window.innerWidth;
    if (w <= 600) return 1;
    if (w <= 900) return 2;
    return 3;
  }

  /* ---- Set card widths ---- */
  function setWidths() {
    var v     = vis();
    var cw    = outer.clientWidth / v;
    var cards = track.querySelectorAll('.ilg-card');
    cards.forEach(function (c) { c.style.width = cw + 'px'; });
  }

  /* ---- Clone cards for infinite loop (prepend + append) ---- */
  function buildTrack() {
    // Remove any previously added clones
    track.querySelectorAll('.ilg-card-clone').forEach(function(c){ c.remove(); });

    var realCards = Array.from(track.querySelectorAll('.ilg-card[data-real]'));
    var v = vis();

    // Append clones at end (for right overflow)
    realCards.forEach(function (c) {
      var cl = c.cloneNode(true);
      cl.classList.add('ilg-card-clone');
      cl.removeAttribute('data-real');
      track.appendChild(cl);
    });

    // Prepend clones at start (for left overflow)
    realCards.slice(-v).forEach(function (c) {
      var cl = c.cloneNode(true);
      cl.classList.add('ilg-card-clone', 'ilg-card-clone-pre');
      cl.removeAttribute('data-real');
      track.insertBefore(cl, track.firstChild);
    });
  }

  /* ---- Compute X offset (px) for a given absolute index ---- */
  function cardWidth() {
    var c = track.querySelector('.ilg-card');
    return c ? c.offsetWidth : 0;
  }

  function clonePreCount() {
    return track.querySelectorAll('.ilg-card-clone-pre').length;
  }

  /* index = absolute slot in the track, 0-based */
  function absoluteIndex() {
    return clonePreCount() + cur;
  }

  function setPosition(absIdx, animated) {
    var cw = cardWidth();
    if (!animated) {
      track.style.transition = 'none';
    } else {
      track.style.transition = 'transform ' + ANIM_MS + 'ms cubic-bezier(.4,0,.2,1)';
    }
    track.style.transform = 'translateX(-' + (absIdx * cw) + 'px)';
  }

  /* ---- Build dot indicators ---- */
  function buildDots() {
    dotsWrap.innerHTML = '';
    for (var i = 0; i < REAL_COUNT; i++) {
      var d = document.createElement('span');
      d.className = 'ilg-dot' + (i === cur ? ' active' : '');
      d.setAttribute('role', 'button');
      d.setAttribute('aria-label', 'Testimonio ' + (i + 1));
      (function (i) {
        d.addEventListener('click', function () { jumpTo(i); });
      })(i);
      dotsWrap.appendChild(d);
    }
  }

  function updateDots() {
    dotsWrap.querySelectorAll('.ilg-dot').forEach(function (d, i) {
      d.className = 'ilg-dot' + (i === cur ? ' active' : '');
    });
  }

  /* ---- Navigation ---- */
  function goTo(newCur) {
    if (isAnimating) return;
    isAnimating = true;
    cur = newCur;

    var absIdx = absoluteIndex();
    setPosition(absIdx, true);
    updateDots();

    setTimeout(function () {
      /* Infinite loop snap: if we went past real cards on either end, snap silently */
      if (cur < 0) {
        cur = REAL_COUNT - 1;
        setPosition(absoluteIndex(), false);
      } else if (cur >= REAL_COUNT) {
        cur = 0;
        setPosition(absoluteIndex(), false);
      }
      isAnimating = false;
    }, ANIM_MS + 30);
  }

  function jumpTo(idx) {
    stopAuto();
    if (isAnimating) return;
    cur = idx;
    setPosition(absoluteIndex(), true);
    updateDots();
    setTimeout(function () { isAnimating = false; }, ANIM_MS + 30);
    startAuto();
  }

  function next() { goTo(cur + 1); }
  function prev() { goTo(cur - 1); }

  /* ---- Auto-play ---- */
  function startAuto() { autoTimer = setInterval(function () { if (!isAnimating) next(); }, AUTO_MS); }
  function stopAuto()  { clearInterval(autoTimer); }

  /* ---- Touch/swipe ---- */
  var touchSX = 0;
  outer.addEventListener('touchstart', function (e) { touchSX = e.touches[0].clientX; stopAuto(); }, { passive: true });
  outer.addEventListener('touchend', function (e) {
    var dx = touchSX - e.changedTouches[0].clientX;
    if (Math.abs(dx) > 50) { dx > 0 ? next() : prev(); }
    startAuto();
  });

  /* ---- Arrow buttons ---- */
  prevBtn.addEventListener('click', function () { stopAuto(); prev(); startAuto(); });
  nextBtn.addEventListener('click', function () { stopAuto(); next(); startAuto(); });

  /* ---- Init & resize ---- */
  function init() {
    buildTrack();
    setWidths();
    cur = 0;
    setPosition(absoluteIndex(), false);
    buildDots();
  }

  var resizeTimer;
  window.addEventListener('resize', function () {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function () {
      stopAuto();
      init();
      startAuto();
    }, 200);
  });

  init();
  startAuto();
})();
</script>
HTMLEND;
/* ------------------------------------------------------------------ */

function update_widget_html( &$elements, $widget_id, $html ) {
    foreach ( $elements as &$el ) {
        if ( isset( $el['id'] ) && $el['id'] === $widget_id ) {
            $el['settings']['html'] = $html;
            return true;
        }
        if ( ! empty( $el['elements'] ) && update_widget_html( $el['elements'], $widget_id, $html ) ) {
            return true;
        }
    }
    return false;
}

$found = update_widget_html( $data, $widget_id, $html );
if ( ! $found ) { die( "ERROR: Widget $widget_id not found\n" ); }

update_post_meta( $post_id, '_elementor_data', wp_slash( wp_json_encode( $data ) ) );
delete_post_meta( $post_id, '_elementor_css_file' );

echo "SUCCESS: Carousel V2 injected (" . strlen( $html ) . " chars)\n";
