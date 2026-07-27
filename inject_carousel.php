<?php
/**
 * Update the Elementor HTML widget (4161a02) inside page 4179
 * with the full testimonials carousel HTML.
 */
require_once( 'wp-load.php' );

$post_id     = 4179;
$widget_id   = '4161a02';
$meta_key    = '_elementor_data';

$raw  = get_post_meta( $post_id, $meta_key, true );
$data = json_decode( $raw, true );

if ( ! $data ) {
    die( "ERROR: Could not decode Elementor data\n" );
}

$carousel_html = <<<'HTMLEND'
<style>
.ilg-testimonios-wrap{font-family:'Inter Tight','Inter',sans-serif;max-width:1100px;margin:0 auto;padding:0 16px}
.ilg-test-header{text-align:center;margin-bottom:48px}
.ilg-test-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(237,164,8,.12);border:1px solid rgba(237,164,8,.35);border-radius:100px;padding:6px 18px;font-size:13px;font-weight:600;color:#eda408;letter-spacing:.5px;text-transform:uppercase;margin-bottom:20px}
.ilg-test-title{font-size:36px;font-weight:800;color:#fff;margin:0 0 12px;line-height:1.2}
@media(max-width:768px){.ilg-test-title{font-size:24px}}
.ilg-test-subtitle{font-size:16px;color:#8fa3c8;margin:0;line-height:1.6}
.ilg-carousel-outer{position:relative;overflow:hidden;border-radius:0}
.ilg-carousel-track{display:flex;transition:transform .55s cubic-bezier(.4,0,.2,1);will-change:transform}
.ilg-card{box-sizing:border-box;padding:0 12px}
.ilg-card-inner{background:linear-gradient(145deg,#1a2744,#0f1d35);border:1px solid rgba(237,164,8,.15);border-radius:16px;padding:32px 28px;height:100%;box-sizing:border-box;position:relative;transition:transform .3s ease,border-color .3s ease,box-shadow .3s ease;overflow:hidden}
.ilg-card-inner::before{content:'\201C';position:absolute;top:-10px;right:20px;font-size:120px;line-height:1;color:rgba(237,164,8,.07);font-family:Georgia,serif;pointer-events:none;user-select:none}
.ilg-card-inner:hover{transform:translateY(-6px);border-color:rgba(237,164,8,.4);box-shadow:0 20px 60px rgba(0,0,0,.4)}
.ilg-stars{color:#eda408;font-size:18px;letter-spacing:2px;margin-bottom:16px;display:block}
.ilg-quote{font-size:15px;line-height:1.75;color:#bfcfe8;margin:0 0 24px;font-style:italic}
.ilg-divider{width:40px;height:2px;background:linear-gradient(90deg,#eda408,transparent);border-radius:2px;margin-bottom:20px}
.ilg-author-row{display:flex;align-items:center;gap:12px}
.ilg-avatar{width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,#eda408,#c07d00);display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:700;color:#0a1628;flex-shrink:0;font-style:normal}
.ilg-author-name{font-size:15px;font-weight:700;color:#fff;margin:0 0 2px}
.ilg-author-role{font-size:12px;color:#5e7aaa;margin:0}
.ilg-dots{display:flex;justify-content:center;gap:10px;margin-top:40px}
.ilg-dot{width:8px;height:8px;border-radius:50%;background:rgba(143,163,200,.3);border:none;cursor:pointer;padding:0;transition:all .3s ease}
.ilg-dot.active{background:#eda408;width:28px;border-radius:4px}
.ilg-nav{position:absolute;top:50%;transform:translateY(-50%);background:rgba(237,164,8,.1);border:1px solid rgba(237,164,8,.3);border-radius:50%;width:44px;height:44px;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .3s ease;z-index:10;color:#eda408;font-size:18px;line-height:1;user-select:none}
.ilg-nav:hover{background:#eda408;color:#0a1628;border-color:#eda408}
.ilg-nav-prev{left:0}.ilg-nav-next{right:0}
@media(max-width:600px){.ilg-nav{display:none}}
.ilg-stats-bar{display:flex;justify-content:center;align-items:center;gap:8px;margin-top:48px;padding:14px 28px;background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.07);border-radius:100px;width:fit-content;margin-left:auto;margin-right:auto;flex-wrap:wrap}
.ilg-stats-text{font-size:14px;color:#7a94bc;margin:0}
.ilg-stats-highlight{color:#eda408;font-weight:700}
.ilg-stats-sep{width:1px;height:16px;background:rgba(255,255,255,.15);margin:0 4px}
</style>
<div class="ilg-testimonios-wrap">
  <div class="ilg-test-header">
    <div class="ilg-test-badge">&#9733; Clientes Satisfechos</div>
    <h2 class="ilg-test-title">Lo que dicen nuestros clientes</h2>
    <p class="ilg-test-subtitle">M&aacute;s de 10 a&ntilde;os respaldando industrias, comercios y hogares en todo el Per&uacute;</p>
  </div>
  <div class="ilg-carousel-outer" id="ilg-carousel">
    <button class="ilg-nav ilg-nav-prev" id="ilg-prev" aria-label="Anterior">&#8592;</button>
    <button class="ilg-nav ilg-nav-next" id="ilg-next" aria-label="Siguiente">&#8594;</button>
    <div class="ilg-carousel-track" id="ilg-track">
      <div class="ilg-card">
        <div class="ilg-card-inner">
          <span class="ilg-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
          <p class="ilg-quote">&ldquo;Excelente atenci&oacute;n y productos de alta calidad. Compramos luminarias LED para nuestro almac&eacute;n industrial y el ahorro en electricidad fue notable desde el primer mes. 100% recomendables.&rdquo;</p>
          <div class="ilg-divider"></div>
          <div class="ilg-author-row">
            <div class="ilg-avatar">C</div>
            <div><p class="ilg-author-name">Carlos M.</p><p class="ilg-author-role">Gerente de Planta &mdash; Sector Industrial, Lima</p></div>
          </div>
        </div>
      </div>
      <div class="ilg-card">
        <div class="ilg-card-inner">
          <span class="ilg-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
          <p class="ilg-quote">&ldquo;Pedimos tomacorrientes e interruptores Btic&iacute;no al por mayor para una obra en Miraflores. El despacho fue r&aacute;pido y los precios, los mejores del mercado. Definitivamente nuestro proveedor fijo.&rdquo;</p>
          <div class="ilg-divider"></div>
          <div class="ilg-author-row">
            <div class="ilg-avatar">R</div>
            <div><p class="ilg-author-name">Rosa T.</p><p class="ilg-author-role">Contratista El&eacute;ctrica &mdash; Construcci&oacute;n, Lima</p></div>
          </div>
        </div>
      </div>
      <div class="ilg-card">
        <div class="ilg-card-inner">
          <span class="ilg-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
          <p class="ilg-quote">&ldquo;Compramos dicroicos LED Philips y paneles para la renovaci&oacute;n de nuestra tienda en San Isidro. El asesor nos gui&oacute; perfecto. La instalaci&oacute;n final qued&oacute; espectacular.&rdquo;</p>
          <div class="ilg-divider"></div>
          <div class="ilg-author-row">
            <div class="ilg-avatar">M</div>
            <div><p class="ilg-author-name">Miriam L.</p><p class="ilg-author-role">Propietaria de Tienda &mdash; Retail, San Isidro</p></div>
          </div>
        </div>
      </div>
      <div class="ilg-card">
        <div class="ilg-card-inner">
          <span class="ilg-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
          <p class="ilg-quote">&ldquo;Gran variedad de productos el&eacute;ctricos y excelente servicio. Los precios mayoristas son muy competitivos. Muy recomendados para proyectos de gran envergadura.&rdquo;</p>
          <div class="ilg-divider"></div>
          <div class="ilg-author-row">
            <div class="ilg-avatar">J</div>
            <div><p class="ilg-author-name">Jorge P.</p><p class="ilg-author-role">Ingeniero El&eacute;ctrico &mdash; Proyectos, Lima Norte</p></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="ilg-dots" id="ilg-dots"></div>
  <div class="ilg-stats-bar">
    <span class="ilg-stats-highlight">&#9733; 4.9/5</span>
    <div class="ilg-stats-sep"></div>
    <p class="ilg-stats-text">Basado en m&aacute;s de <strong class="ilg-stats-highlight">200+ pedidos</strong> de clientes satisfechos en Lima y provincias</p>
  </div>
</div>
<script>
(function(){
  var track=document.getElementById('ilg-track');
  var dotsWrap=document.getElementById('ilg-dots');
  var prevBtn=document.getElementById('ilg-prev');
  var nextBtn=document.getElementById('ilg-next');
  if(!track)return;
  var cards=track.querySelectorAll('.ilg-card');
  var total=cards.length;
  var cur=0;
  var timer=null;
  function vis(){return window.innerWidth<=600?1:window.innerWidth<=900?2:3;}
  function slides(){return Math.max(1,total-vis()+1);}
  function buildDots(){
    dotsWrap.innerHTML='';
    for(var i=0;i<slides();i++){
      var d=document.createElement('button');
      d.className='ilg-dot'+(i===cur?' active':'');
      d.setAttribute('aria-label','Testimonio '+(i+1));
      (function(i){d.addEventListener('click',function(){go(i);});})(i);
      dotsWrap.appendChild(d);
    }
  }
  function updateDots(){
    dotsWrap.querySelectorAll('.ilg-dot').forEach(function(d,i){d.className='ilg-dot'+(i===cur?' active':'');});
  }
  function go(idx){
    cur=Math.max(0,Math.min(idx,slides()-1));
    track.style.transform='translateX(-'+(100/total*cur)+'%)';
    updateDots();
  }
  function next(){go(cur<slides()-1?cur+1:0);}
  function prev(){go(cur>0?cur-1:slides()-1);}
  function start(){timer=setInterval(next,4500);}
  function stop(){clearInterval(timer);}
  cards.forEach(function(c){c.style.minWidth=(100/total)+'%';});
  if(prevBtn)prevBtn.addEventListener('click',function(){stop();prev();start();});
  if(nextBtn)nextBtn.addEventListener('click',function(){stop();next();start();});
  var sx=0;
  track.addEventListener('touchstart',function(e){sx=e.touches[0].clientX;stop();},{passive:true});
  track.addEventListener('touchend',function(e){var d=sx-e.changedTouches[0].clientX;if(Math.abs(d)>50){d>0?next():prev();}start();});
  window.addEventListener('resize',function(){buildDots();go(Math.min(cur,slides()-1));});
  buildDots();go(0);start();
})();
</script>
HTMLEND;

// Walk the data tree and find widget by ID, update its html setting
function update_widget_html( &$elements, $widget_id, $html ) {
    foreach ( $elements as &$el ) {
        if ( isset( $el['id'] ) && $el['id'] === $widget_id ) {
            $el['settings']['html'] = $html;
            return true;
        }
        if ( ! empty( $el['elements'] ) ) {
            if ( update_widget_html( $el['elements'], $widget_id, $html ) ) {
                return true;
            }
        }
    }
    return false;
}

$found = update_widget_html( $data, $widget_id, $carousel_html );

if ( ! $found ) {
    die( "ERROR: Widget $widget_id not found in Elementor data\n" );
}

$new_json = wp_json_encode( $data );
update_post_meta( $post_id, '_elementor_data', wp_slash( $new_json ) );
// Also update the CSS cache version
update_post_meta( $post_id, '_elementor_version', \Elementor\ELEMENTOR_VERSION );
\Elementor\Plugin::$instance->files_manager->clear_cache();

echo "SUCCESS: Widget $widget_id updated with carousel HTML (" . strlen( $carousel_html ) . " chars)\n";
