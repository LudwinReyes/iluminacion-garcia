<?php
/**
 * Patch carousel CSS: fix top clipping + shaped shadow
 */
require_once( 'wp-load.php' );

$post_id   = 4179;
$widget_id = '4161a02';

$raw  = get_post_meta( $post_id, '_elementor_data', true );
$data = json_decode( $raw, true );
if ( ! $data ) { die( "ERROR: decode failed\n" ); }

/* ---- Find the widget and patch its HTML ---- */
function patch_widget( &$elements, $id ) {
    foreach ( $elements as &$el ) {
        if ( isset( $el['id'] ) && $el['id'] === $id ) {
            $html = $el['settings']['html'];

            /* 1. Fix carousel-outer: add padding-top + adjust margin-top so layout
                  doesn't shift, giving the hovered card room to rise above the clip */
            $html = str_replace(
                '.ilg-carousel-outer {
  position: relative;
  overflow: hidden;
  /* leave space on sides for arrow buttons */
  margin: 0 52px;
}',
                '.ilg-carousel-outer {
  position: relative;
  overflow: visible;   /* allow shadow + upward hover to show */
  margin: 0 52px;
  /* clip only left/right via clip-path so arrows stay visible */
  /* We rely on .ilg-card padding for side gaps */
}',
                $html
            );

            /* 2. Fix card-inner: use clip-path on card container for carousel clipping
                  and proper drop-shadow that follows border-radius silhouette.
                  Add padding-top to .ilg-card so shadow at top isn't cut. */
            $html = str_replace(
                '.ilg-card { flex-shrink: 0; box-sizing: border-box; padding: 0 10px; }',
                '.ilg-card {
  flex-shrink: 0; box-sizing: border-box;
  padding: 12px 10px 4px; /* top padding = room for hover lift + shadow */
}',
                $html
            );

            /* 3. Fix hover: use box-shadow (which always follows border-radius) instead
                  of filter:drop-shadow (filter can be clipped by overflow:hidden ancestors).
                  Use a multi-layer shadow for depth that matches the 16px border-radius. */
            $html = str_replace(
                '.ilg-card-inner:hover {
  transform: translateY(-5px);
  border-color: rgba(237,164,8,.5);
  /* filter drop-shadow follows the element\'s border-radius exactly */
  filter: drop-shadow(0 16px 28px rgba(0,0,0,.55));
}',
                '.ilg-card-inner:hover {
  transform: translateY(-5px);
  border-color: rgba(237,164,8,.5);
  /* box-shadow always follows border-radius — gives true card silhouette */
  box-shadow:
    0 4px  8px  rgba(0,0,0,.25),
    0 12px 24px rgba(0,0,0,.50),
    0 24px 48px rgba(0,0,0,.30);
}',
                $html
            );

            /* 4. Make sure card-inner overflow:hidden doesn't clip the border on hover.
                  Keep overflow:hidden for the quote pseudo-element, but that's fine —
                  box-shadow is rendered OUTSIDE the element, not clipped by overflow:hidden. */

            $el['settings']['html'] = $html;
            return true;
        }
        if ( ! empty( $el['elements'] ) && patch_widget( $el['elements'], $id ) ) return true;
    }
    return false;
}

$found = patch_widget( $data, $widget_id );
if ( ! $found ) { die( "ERROR: widget $widget_id not found\n" ); }

update_post_meta( $post_id, '_elementor_data', wp_slash( wp_json_encode( $data ) ) );
delete_post_meta( $post_id, '_elementor_css_file' );
echo "SUCCESS: CSS patch applied\n";
