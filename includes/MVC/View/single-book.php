<?php
/**
 * Single Book Template
 */

use TopicsManager\MVC\Services\BookService;
use TopicsManager\MVC\Models\BookModel;

// Initialize service
$book_model = new BookModel();
$book_service = new BookService($book_model);

// Get current post ID
$book_id = get_the_ID();
$book_details = $book_service->getBookWithDetails($book_id);
$post = $book_details['post'];
$meta = $book_details['meta'];
$taxonomies = $book_details['taxonomies'];

get_header(); ?>

<div class="single-book">
    <h1><?php echo esc_html($post->post_title); ?></h1>
    <div class="book-content">
        <?php echo apply_filters('the_content', $post->post_content); ?>
    </div>

    <div class="book-meta">
        <p>ISBN: <?php echo esc_html($meta['isbn']); ?></p>
        <p>Pages: <?php echo esc_html($meta['pages']); ?></p>
        <p>Published: <?php echo esc_html($meta['published']); ?></p>

        <p>Genres: <?php
            echo !empty($taxonomies['genres'])
                ? esc_html(implode(', ', wp_list_pluck($taxonomies['genres'], 'name')))
                : 'None';
        ?></p>

        <p>Writers: <?php
            echo !empty($taxonomies['writers'])
                ? esc_html(implode(', ', wp_list_pluck($taxonomies['writers'], 'name')))
                : 'None';
        ?></p>
    </div>
</div>

<?php get_footer(); ?>
