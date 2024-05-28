jQuery(document).ready(function($) {
    function fetch_posts(paged = 1) {
        var category_ids = [];
        $('#filter input[type="checkbox"]:checked').each(function() {
            category_ids.push($(this).val());
        });

        $.ajax({
            url: ajax_params.ajax_url,
            type: 'POST',
            data: {
                action: 'filter_posts',
                category_ids: category_ids,
                paged: paged
            },
            success: function(response) {
                $('#posts-container').html(response);
            }
        });
    }

    // On checkbox change
    $('#filter input[type="checkbox"]').on('change', function() {
        fetch_posts();
    });

    // On pagination click
    $(document).on('click', '#posts-container .page-numbers', function(e) {
        e.preventDefault();
        var paged = $(this).attr('href').split('paged=')[1];
        fetch_posts(paged);
    });
});
