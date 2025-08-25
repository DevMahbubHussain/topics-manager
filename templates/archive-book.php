<?php get_header(); ?>

<div class="books-archive">
    <?php if ( have_posts() ) : ?>
        <div class="books-grid">
            <?php while ( have_posts() ) : the_post(); ?>
                <?php include TM_TEMPLATES_DIR . 'partials/book-card.php'; ?>
            <?php endwhile; ?>
        </div>

        <div class="tm-pagination">
            <?php
            echo paginate_links([
                'total'   => $wp_query->max_num_pages,
                'current' => max(1, get_query_var('paged')),
            ]);
            ?>
        </div>

    <?php else : ?>
        <p>No books found.</p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>