<?php
function custom_filter_enqueue_scripts() {
    wp_enqueue_script('custom-filter', get_template_directory_uri() . '/js/custom-filter.js', array('jquery'), null, true);
    wp_localize_script('custom-filter', 'ajax_params', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'custom_filter_enqueue_scripts');

function filter_posts_by_category() {
    $category_ids = isset($_POST['category_ids']) ? $_POST['category_ids'] : array();
    $paged = isset($_POST['paged']) ? $_POST['paged'] : 1;
    
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 5,
        'paged' => $paged,
    );

    if (!empty($category_ids)) {
        $args['category__in'] = $category_ids;
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            echo '<div class="post-item">';
            the_title('<h2>', '</h2>');
            the_excerpt();
            echo '</div>';
        endwhile;

        // Pagination
        echo paginate_links(array(
            'total' => $query->max_num_pages,
            'current' => $paged,
            'format' => '?paged=%#%',
        ));
    else :
        echo 'No posts found';
    endif;

    wp_reset_postdata();
    die();
}
add_action('wp_ajax_filter_posts', 'filter_posts_by_category');
add_action('wp_ajax_nopriv_filter_posts', 'filter_posts_by_category');
