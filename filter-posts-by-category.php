<form id="filter">
    <?php
    $categories = get_categories();
    foreach ($categories as $category) {
        echo '<label>';
        echo '<input type="checkbox" name="category" value="' . $category->term_id . '"> ' . $category->name;
        echo '</label><br>';
    }
    ?>
</form>

<div id="posts-container">
    <?php
    // Initial query to display all posts with pagination
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 5,
        'paged' => $paged,
    );
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
            'total' => $query->max_num_pages
        ));
    else :
        echo 'No posts found';
    endif;

    wp_reset_postdata();
    ?>
</div>
