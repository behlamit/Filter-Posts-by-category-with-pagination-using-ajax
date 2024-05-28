<?php
function custom_filter_enqueue_scripts() {
    wp_enqueue_script('custom-filter', get_template_directory_uri() . '/js/custom-filter.js', array('jquery'), null, true);
    wp_localize_script('custom-filter', 'ajax_params', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'custom_filter_enqueue_scripts');
