<?php
// Query books
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
// error_log('DEBUG: posts_per_page = ' . $posts_per_page);
// error_log('DEBUG: paged = ' . $paged);
// error_log('DEBUG: genre = ' . $genre);
// error_log('DEBUG: writer = ' . $writer);
// error_log('DEBUG: show_filters = ' . ($show_filters ? 'true' : 'false'));
$args = [
    'post_type' => 'book',
    'posts_per_page' => $posts_per_page, 
    'paged' => $paged,
    'post_status'    => 'publish', 
    'ignore_sticky_posts' => true,
];

// Add taxonomy filters

if (!empty($atts['genre'])) {
    $args['tax_query'][] = [
        'taxonomy' => 'genre',
        'field' => 'slug',
        'terms' => $genre,
    ];
}

if (!empty($atts['writer'])) {
    $args['tax_query'][] = [
        'taxonomy' => 'writer',
        'field' => 'slug',
         'terms' => $writer,
    ];
}


if (isset($args['tax_query']) && count($args['tax_query']) > 1) {
    $args['tax_query']['relation'] = 'AND';
}

$books = new WP_Query($args);


// error_log('DEBUG: Query found ' . $books->found_posts . ' posts');
// error_log('DEBUG: Query returning ' . $books->post_count . ' posts on this page')

?>

<!-- books filter -->
<?php if ($atts['show_filters']) : ?>
    <div class="tm-filters">
        <?php include TM_TEMPLATES_DIR . '/partials/filters.php'; ?>
    </div>
<?php endif; ?>

<!-- books grid  -->
<div class="books-grid">
    <?php if ($books->have_posts()) : ?>
        <?php while ($books->have_posts()) : $books->the_post(); ?>
            <?php include TM_TEMPLATES_DIR . '/partials/book-card.php'; ?>
        <?php endwhile; ?>
    <?php else : ?>
        <p>No Books Found</p>
    <?php endif; ?>
</div>


<!-- books pagination -->
<?php if ($books->max_num_pages > 1) : ?>
    <div class="tm-pagination">
        <?php
        echo paginate_links([
            'total' => $books->max_num_pages,
            'current' => $paged,
            'format' => '?paged=%#%'
        ]);
        ?>
    </div>
<?php endif; ?>


<?php wp_reset_postdata(); 
// Debug the query results
error_log('DEBUG: Found posts: ' . $books->found_posts);
error_log('DEBUG: Max num pages: ' . $books->max_num_pages);
error_log('DEBUG: Current page: ' . $books->query_vars['paged']);

?>