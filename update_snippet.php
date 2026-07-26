<?php
require_once('wp-load.php');

$post_id = 17022;
$post = get_post($post_id);

if ($post) {
    $old_content = $post->post_content;
    
    // Define the target block to replace
    $target = "function personalizar_tabs_producto(\$tabs) {
    // Cambiar el título del tab \"description\"
    if (isset(\$tabs['detalles'])) {
        \$tabs['detalles']['title'] = 'Especificaciones técnicas';
    }

    // Quitar el tab \"Información adicional\"
    if (isset(\$tabs['additional_information'])) {
        unset(\$tabs['additional_information']);
    }

    return \$tabs;
}";

    // Define the replacement content
    $replacement = "function personalizar_tabs_producto(\$tabs) {
    // Cambiar el título del tab \"description\"
    if (isset(\$tabs['detalles'])) {
        \$tabs['detalles']['title'] = 'Especificaciones técnicas';
    }

    // Quitar el tab \"Información adicional\"
    if (isset(\$tabs['additional_information'])) {
        unset(\$tabs['additional_information']);
    }

    // Quitar el tab \"Ficha técnica\"
    if (isset(\$tabs['additional_tab_2'])) {
        unset(\$tabs['additional_tab_2']);
    }

    return \$tabs;
}";

    // Replace the string
    $new_content = str_replace($target, $replacement, $old_content);
    
    if ($new_content !== $old_content) {
        $updated_post = array(
            'ID'           => $post_id,
            'post_content' => $new_content,
        );
        wp_update_post($updated_post);
        echo "SUCCESS: Snippet ID {$post_id} updated successfully!\n";
    } else {
        echo "ERROR: Target string not found or content already updated.\n";
    }
} else {
    echo "ERROR: Post ID {$post_id} not found.\n";
}
