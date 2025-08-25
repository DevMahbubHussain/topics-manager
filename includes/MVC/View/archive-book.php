<?php
/**
 * Book Archive Template
 */

use TopicsManager\MVC\Services\BookService;
use TopicsManager\MVC\Models\BookModel;

// Initialize service
$book_model = new BookModel();
$book_service = new BookService($book_model);

// Get paged parameter
$paged = get_query_var('paged') ? get_query_var('paged') : 1;

// Get books (12 per page)
$books_query = $book_service->getBooksForListing([
    'posts_per_page' => 12,
    'paged' => $paged
]);

$books = $books_query->posts ?? [];

get_header(); ?>

<div class="books-archive">
    <h1><?php post_type_archive_title(); ?></h1>

    <?php if (!empty($books)) : ?>
        <div class="books-listing">
            <?php foreach ($books as $book) :
                $book_details = $book_service->getBookWithDetails($book->ID);
                $meta = $book_details['meta'];
                $taxonomies = $book_details['taxonomies'];
            ?>
                <div class="book-item">
                    <h2><a href="<?php echo get_permalink($book->ID); ?>">
                        <?php echo esc_html($book->post_title); ?>
                    </a></h2>
                    <p>ISBN: <?php echo esc_html($meta['isbn']); ?></p>
                    <p>Genres: <?php echo esc_html(implode(', ', wp_list_pluck($taxonomies['genres'], 'name'))); ?></p>
                    <p>Writers: <?php echo esc_html(implode(', ', wp_list_pluck($taxonomies['writers'], 'name'))); ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <div class="books-pagination">
            <?php
            echo paginate_links([
                'total' => $books_query->max_num_pages,
                'current' => $paged,
            ]);
            ?>
        </div>

    <?php else: ?>
        <p>No books found.</p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
