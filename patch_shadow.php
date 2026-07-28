<?php
/**
 * Patch: replace filter:drop-shadow with simple box-shadow on .ilg-card-inner
 */
require_once( 'wp-load.php' );

$post_id   = 4179;
$widget_id = '4161a02';

$raw  = get_post_meta( $post_id, '_elementor_data', true );
$data = json_decode( $raw, true );
if ( ! $data ) { die( "ERROR: decode\n" ); }

function patch_shadow( &$elements, $id ) {
    foreach ( $elements as &$el ) {
        if ( isset( $el['id'] ) && $el['id'] === $id ) {
            $h = $el['settings']['html'];

            /* 1. Remove filter:drop-shadow from .ilg-card:hover */
            $h = str_replace(
                '.ilg-card:hover {
  /* drop-shadow follows the rounded border of .ilg-card-inner exactly */
  filter: drop-shadow(0 14px 28px rgba(0,0,0,.7));
}',
                '.ilg-card:hover {
  /* shadow handled on .ilg-card-inner via box-shadow */
}',
                $h
            );

            /* 2. Add box-shadow to .ilg-card:hover .ilg-card-inner
               box-shadow ALWAYS follows border-radius (same as user example).
               Values: x=1 y=3 blur=8 spread=4 + a deeper layer */
            $h = str_replace(
                '.ilg-card:hover .ilg-card-inner {
  transform: translateY(-5px);
  border-color: rgba(237,164,8,.5);
}',
                '.ilg-card:hover .ilg-card-inner {
  transform: translateY(-5px);
  border-color: rgba(237,164,8,.5);
  /* box-shadow sigue border-radius:16px exactamente */
  box-shadow: 1px 3px 8px 4px rgba(0,0,0,0.40);
}',
                $h
            );

            $el['settings']['html'] = $h;
            return true;
        }
        if ( !empty($el['elements']) && patch_shadow($el['elements'], $id) ) return true;
    }
    return false;
}

$found = patch_shadow( $data, $widget_id );
if ( !$found ) die("ERROR: widget not found\n");

update_post_meta( $post_id, '_elementor_data', wp_slash( wp_json_encode($data) ) );
delete_post_meta( $post_id, '_elementor_css_file' );
echo "SUCCESS: box-shadow patch applied\n";
