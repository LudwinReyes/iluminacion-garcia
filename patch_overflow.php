<?php
/**
 * Patch carousel: restore overflow:hidden (clip to 3 cards)
 * + add padding-top so hover border isn't cut at the top
 */
require_once( 'wp-load.php' );

$post_id   = 4179;
$widget_id = '4161a02';

$raw  = get_post_meta( $post_id, '_elementor_data', true );
$data = json_decode( $raw, true );
if ( ! $data ) { die( "ERROR: decode failed\n" ); }

function patch_overflow( &$elements, $id ) {
    foreach ( $elements as &$el ) {
        if ( isset( $el['id'] ) && $el['id'] === $id ) {
            $html = $el['settings']['html'];

            /* Restore overflow:hidden + add padding-top so yellow top border
               stays visible when card does translateY(-5px).
               margin-top:-10px compensates so layout doesn't shift down. */
            $html = str_replace(
                '.ilg-carousel-outer {
  position: relative;
  overflow: visible;   /* allow shadow + upward hover to show */
  margin: 0 52px;
  /* clip only left/right via clip-path so arrows stay visible */
  /* We rely on .ilg-card padding for side gaps */
}',
                '.ilg-carousel-outer {
  position: relative;
  overflow: hidden;           /* clip carousel to show only 3 cards */
  margin: -10px 52px 0;       /* compensate padding-top below */
  padding-top: 10px;          /* room for hover lift + top border */
}',
                $html
            );

            $el['settings']['html'] = $html;
            return true;
        }
        if ( ! empty( $el['elements'] ) && patch_overflow( $el['elements'], $id ) ) return true;
    }
    return false;
}

$found = patch_overflow( $data, $widget_id );
if ( ! $found ) { die( "ERROR: widget not found\n" ); }

update_post_meta( $post_id, '_elementor_data', wp_slash( wp_json_encode( $data ) ) );
delete_post_meta( $post_id, '_elementor_css_file' );
echo "SUCCESS: overflow restored, padding-top added\n";
