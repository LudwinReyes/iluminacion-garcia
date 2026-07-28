<?php
/**
 * Inject Carousel V4 – proper shadow silhouette + bottom gap fix
 */
require_once( 'wp-load.php' );

$post_id   = 4179;
$widget_id = '4161a02';

$raw  = get_post_meta( $post_id, '_elementor_data', true );
$data = json_decode( $raw, true );
if ( ! $data ) { die( "ERROR: decode failed\n" ); }

$html = <<<'HTMLEND'
<style>
/* ============================================================
   TESTIMONIOS V4 — shadow silhouette fix + bottom gap
   ============================================================ */

/* ---- Full-bleed background wrapper ---- */
#ilg-wrap {
  position: relative;
  padding: 80px 0 96px;   /* 96px bottom = visible gap before next section */
}
#ilg-wrap::before {
  content: '';
  position: absolute;
  top: 0; bottom: 0;
  left: 50%; width: 100vw;
  transform: translateX(-50%);
  background: #212d4e;
  z-index: 0;
}
#ilg-inner {
  position: relative; z-index: 1;
  max-width: 1200px; margin: 0 auto;
  padding: 0 40px; box-sizing: border-box;
  font-family: 'Inter Tight','Inter',sans-serif;
}
@media(max-width:768px){ #ilg-inner{ padding: 0 20px; } }

/* ---- Header ---- */
.ilg-test-header { text-align: center; margin-bottom: 52px; }
.ilg-test-badge {
  display: inline-flex; align-items: center; gap: 8px;
  background: rgba(237,164,8,.12); border: 1px solid rgba(237,164,8,.35);
  border-radius: 100px; padding: 6px 20px;
  font-size: 12px; font-weight: 700; color: #eda408;
  letter-spacing: 1px; text-transform: uppercase; margin-bottom: 18px;
}
.ilg-test-title {
  font-size: clamp(24px,3vw,36px); font-weight: 800;
  color: #fff; margin: 0 0 12px; line-height: 1.2;
}
.ilg-test-subtitle { font-size: 15px; color: #8fa3c8; margin: 0; line-height: 1.6; }

/* ---- Carousel outer: overflow:hidden + padding for shadow+hover space ---- */
.ilg-carousel-outer {
  position: relative;
  overflow: hidden;
  /*
    padding-top: 12px    → room for card to rise 5px + top border
    padding-bottom: 28px → room for the drop-shadow below cards
    margin compensates so visual position stays the same
  */
  padding: 12px 2px 28px;
  margin: -12px 50px -28px;
}
@media(max-width:600px){ .ilg-carousel-outer { margin: -12px 16px -28px; } }

.ilg-carousel-track {
  display: flex;
  will-change: transform;
}

/* ---- Card wrapper — receives the shaped shadow filter ---- */
.ilg-card {
  flex-shrink: 0; box-sizing: border-box;
  padding: 0 10px;
  /* filter:drop-shadow here traces the card-inner's alpha shape
     (the transparent padding areas are ignored by drop-shadow) */
  transition: filter .3s ease;
}
.ilg-card:hover {
  /* drop-shadow follows the rounded border of .ilg-card-inner exactly */
  filter: drop-shadow(0 14px 28px rgba(0,0,0,.7));
}

/* ---- Card inner — lift + golden border on parent hover ---- */
.ilg-card-inner {
  background: linear-gradient(145deg, #1a2744, #0f1d35);
  border: 1px solid rgba(237,164,8,.15);
  border-radius: 16px;
  padding: 32px 28px;
  min-height: 265px;
  box-sizing: border-box;
  position: relative;
  display: flex; flex-direction: column; justify-content: space-between;
  overflow: hidden;
  transition: transform .3s ease, border-color .3s ease;
}
.ilg-card-inner::before {
  content: '\201C';
  position: absolute; top: -8px; right: 18px;
  font-size: 110px; line-height: 1;
  color: rgba(237,164,8,.07); font-family: Georgia,serif;
  pointer-events: none; user-select: none;
}
/* Hover handled from parent .ilg-card */
.ilg-card:hover .ilg-card-inner {
  transform: translateY(-5px);
  border-color: rgba(237,164,8,.5);
}

/* Stars */
.ilg-stars { color: #eda408; font-size: 17px; letter-spacing: 2px; margin-bottom: 14px; display: block; }
/* Quote */
.ilg-quote { font-size: 14px; line-height: 1.75; color: #bfcfe8; margin: 0 0 20px; font-style: italic; flex: 1; }
/* Divider */
.ilg-divider { width: 36px; height: 2px; background: linear-gradient(90deg,#eda408,transparent); border-radius: 2px; margin-bottom: 18px; }
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

/* ---- Nav arrows ---- */
.ilg-nav {
  position: absolute; top: 50%; transform: translateY(-50%);
  width: 40px; height: 40px; border-radius: 50%;
  background: rgba(237,164,8,.15); border: 1.5px solid rgba(237,164,8,.45);
  display: flex !important; align-items: center; justify-content: center;
  cursor: pointer; z-index: 20; outline: none; padding: 0;
  transition: background .25s, border-color .25s;
}
.ilg-nav svg {
  display: block; width: 18px; height: 18px;
  stroke: #eda408; fill: none;
  stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round;
  transition: stroke .25s;
}
.ilg-nav:hover { background: #eda408; border-color: #eda408; }
.ilg-nav:hover svg { stroke: #0a1628; }
.ilg-nav-prev { left: -52px; }
.ilg-nav-next { right: -52px; }
@media(max-width:600px){ .ilg-nav-prev{left:-44px;} .ilg-nav-next{right:-44px;} }

/* ---- Dots ---- */
.ilg-dots {
  display: flex; justify-content: center; align-items: center;
  gap: 8px; margin-top: 40px;
}
.ilg-dot {
  display: block; border-radius: 50%;
  background: rgba(143,163,200,.3);
  width: 8px; height: 8px; flex-shrink: 0;
  cursor: pointer; transition: all .3s ease;
}
.ilg-dot.active { background: #eda408; width: 24px; border-radius: 4px; }
</style>

<div id="ilg-wrap">
  <div id="ilg-inner">

    <div class="ilg-test-header">
      <div class="ilg-test-badge">&#9733; Clientes Satisfechos</div>
      <h2 class="ilg-test-title">Lo que dicen nuestros clientes</h2>
      <p class="ilg-test-subtitle">M&aacute;s de 10 a&ntilde;os respaldando industrias, comercios y hogares en todo el Per&uacute;</p>
    </div>

    <div class="ilg-carousel-outer" id="ilg-co">
      <button class="ilg-nav ilg-nav-prev" id="ilg-prev" aria-label="Anterior">
        <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
      </button>
      <button class="ilg-nav ilg-nav-next" id="ilg-next" aria-label="Siguiente">
        <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
      </button>

      <div class="ilg-carousel-track" id="ilg-track">

        <div class="ilg-card" data-real="1">
          <div class="ilg-card-inner">
            <div><span class="ilg-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
              <p class="ilg-quote">&ldquo;Excelente atenci&oacute;n y productos de alta calidad. Compramos luminarias LED para nuestro almac&eacute;n industrial y el ahorro en electricidad fue notable desde el primer mes. 100% recomendables.&rdquo;</p>
            </div>
            <div><div class="ilg-divider"></div>
              <div class="ilg-author-row"><div class="ilg-avatar">C</div>
                <div><p class="ilg-author-name">Carlos M.</p><p class="ilg-author-role">Gerente de Planta &mdash; Sector Industrial, Lima</p></div>
              </div>
            </div>
          </div>
        </div>

        <div class="ilg-card" data-real="1">
          <div class="ilg-card-inner">
            <div><span class="ilg-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
              <p class="ilg-quote">&ldquo;Pedimos tomacorrientes e interruptores Btic&iacute;no al por mayor para una obra en Miraflores. El despacho fue r&aacute;pido y los precios los mejores del mercado. Definitivamente nuestro proveedor fijo.&rdquo;</p>
            </div>
            <div><div class="ilg-divider"></div>
              <div class="ilg-author-row"><div class="ilg-avatar">R</div>
                <div><p class="ilg-author-name">Rosa T.</p><p class="ilg-author-role">Contratista El&eacute;ctrica &mdash; Construcci&oacute;n, Lima</p></div>
              </div>
            </div>
          </div>
        </div>

        <div class="ilg-card" data-real="1">
          <div class="ilg-card-inner">
            <div><span class="ilg-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
              <p class="ilg-quote">&ldquo;Compramos dicroicos LED Philips y paneles para la renovaci&oacute;n de nuestra tienda en San Isidro. El asesor nos gui&oacute; perfecto. La instalaci&oacute;n final qued&oacute; espectacular.&rdquo;</p>
            </div>
            <div><div class="ilg-divider"></div>
              <div class="ilg-author-row"><div class="ilg-avatar">M</div>
                <div><p class="ilg-author-name">Miriam L.</p><p class="ilg-author-role">Propietaria de Tienda &mdash; Retail, San Isidro</p></div>
              </div>
            </div>
          </div>
        </div>

        <div class="ilg-card" data-real="1">
          <div class="ilg-card-inner">
            <div><span class="ilg-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
              <p class="ilg-quote">&ldquo;Gran variedad de productos el&eacute;ctricos y excelente servicio. Los precios mayoristas son muy competitivos. Muy recomendados para proyectos de gran envergadura.&rdquo;</p>
            </div>
            <div><div class="ilg-divider"></div>
              <div class="ilg-author-row"><div class="ilg-avatar">J</div>
                <div><p class="ilg-author-name">Jorge P.</p><p class="ilg-author-role">Ingeniero El&eacute;ctrico &mdash; Proyectos, Lima Norte</p></div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

    <div class="ilg-dots" id="ilg-dots"></div>

  </div>
</div>

<script>
(function(){
  var outer=document.getElementById('ilg-co');
  var track=document.getElementById('ilg-track');
  var dots=document.getElementById('ilg-dots');
  var prev=document.getElementById('ilg-prev');
  var next=document.getElementById('ilg-next');
  if(!track)return;
  var REAL=track.querySelectorAll('.ilg-card[data-real]').length;
  var ANIM=520,AUTO=4500,busy=false,cur=0,timer=null;
  function vis(){var w=window.innerWidth;return w<=600?1:w<=900?2:3;}
  function cw(){var c=track.querySelector('.ilg-card');return c?c.offsetWidth:0;}
  function pre(){return track.querySelectorAll('.ilg-card-clone-pre').length;}
  function setW(){var v=vis(),w=outer.clientWidth/v;track.querySelectorAll('.ilg-card').forEach(function(c){c.style.width=w+'px';});}
  function build(){
    track.querySelectorAll('.ilg-card-clone').forEach(function(c){c.remove();});
    var real=Array.from(track.querySelectorAll('.ilg-card[data-real]'));
    var v=vis();
    real.forEach(function(c){var cl=c.cloneNode(true);cl.classList.add('ilg-card-clone');cl.removeAttribute('data-real');track.appendChild(cl);});
    real.slice(-v).forEach(function(c){var cl=c.cloneNode(true);cl.classList.add('ilg-card-clone','ilg-card-clone-pre');cl.removeAttribute('data-real');track.insertBefore(cl,track.firstChild);});
  }
  function abs(){return pre()+cur;}
  function pos(a,anim){track.style.transition=anim?'transform '+ANIM+'ms cubic-bezier(.4,0,.2,1)':'none';track.style.transform='translateX(-'+(a*cw())+'px)';}
  function mkDots(){dots.innerHTML='';for(var i=0;i<REAL;i++){var d=document.createElement('span');d.className='ilg-dot'+(i===cur?' active':'');d.setAttribute('role','button');(function(i){d.addEventListener('click',function(){jump(i);});})(i);dots.appendChild(d);}}
  function upDots(){dots.querySelectorAll('.ilg-dot').forEach(function(d,i){d.className='ilg-dot'+(i===cur?' active':'');});}
  function go(n){if(busy)return;busy=true;cur=n;pos(abs(),true);upDots();setTimeout(function(){if(cur<0){cur=REAL-1;pos(abs(),false);}if(cur>=REAL){cur=0;pos(abs(),false);}busy=false;},ANIM+30);}
  function jump(i){stop();if(busy)return;cur=i;pos(abs(),true);upDots();setTimeout(function(){busy=false;},ANIM+30);start();}
  function fwd(){go(cur+1);}function bk(){go(cur-1);}
  function start(){timer=setInterval(function(){if(!busy)fwd();},AUTO);}
  function stop(){clearInterval(timer);}
  var sx=0;
  outer.addEventListener('touchstart',function(e){sx=e.touches[0].clientX;stop();},{passive:true});
  outer.addEventListener('touchend',function(e){var dx=sx-e.changedTouches[0].clientX;if(Math.abs(dx)>50){dx>0?fwd():bk();}start();});
  prev.addEventListener('click',function(){stop();bk();start();});
  next.addEventListener('click',function(){stop();fwd();start();});
  function init(){build();setW();cur=0;pos(abs(),false);mkDots();}
  var rt;window.addEventListener('resize',function(){clearTimeout(rt);rt=setTimeout(function(){stop();init();start();},200);});
  init();start();
})();
</script>
HTMLEND;

function update_widget( &$elements, $id, $html ) {
    foreach ( $elements as &$el ) {
        if ( isset( $el['id'] ) && $el['id'] === $id ) {
            $el['settings']['html'] = $html;
            return true;
        }
        if ( ! empty( $el['elements'] ) && update_widget( $el['elements'], $id, $html ) ) return true;
    }
    return false;
}

$found = update_widget( $data, $widget_id, $html );
if ( ! $found ) { die( "ERROR: widget not found\n" ); }

update_post_meta( $post_id, '_elementor_data', wp_slash( wp_json_encode( $data ) ) );
delete_post_meta( $post_id, '_elementor_css_file' );
echo "SUCCESS: Carousel V4 injected (" . strlen( $html ) . " chars)\n";
