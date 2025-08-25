<?php
// Get post ID safely
$post_id = get_the_ID();

if (empty($post_id)) {
    return; 
}
?>

<div class="book-card" data-book-id="<?php echo esc_attr($post_id); ?>">
    
    <!-- Book Image -->
    <?php if (has_post_thumbnail()) : ?>
    <div class="book-image">
        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
            <?php 
            the_post_thumbnail('medium', [
                'alt'   => get_the_title(),
                'class' => 'book-thumbnail'
            ]); 
            ?>
        </a>
    </div>
    <?php else : ?>
    <div class="book-image no-image">
        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
            <div class="book-placeholder">
                <span class="dashicons dashicons-book-alt"></span>
            </div>
        </a>
    </div>
    <?php endif; ?>

    <!-- Book Content -->
    <div class="book-content">
        <h3 class="book-title">
            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                <?php the_title(); ?>
            </a>
        </h3>
        
        <div class="book-meta">
            <?php
            // Display ISBN if available
            $isbn = get_post_meta($post_id, 'isbn', true);
            if (!empty($isbn)) {
                echo '<div class="book-isbn">';
                echo '<span class="meta-label">ISBN:</span> ';
                echo '<span class="isbn-value">' . esc_html($isbn) . '</span>';
                echo '</div>';
            }
            
            // Display publication year if available
            $publication_year = get_post_meta($post_id, 'publication_year', true);
            if (!empty($publication_year)) {
                echo '<div class="book-year">';
                echo '<span class="meta-label">Year:</span> ';
                echo '<span class="year-value">' . esc_html($publication_year) . '</span>';
                echo '</div>';
            }
            
            // Display genres with links
            $genres = get_the_terms($post_id, 'genre');
            if ($genres && !is_wp_error($genres)) {
                echo '<div class="book-genres">';
                echo '<span class="meta-label">Genres:</span> ';
                $genre_links = [];
                foreach ($genres as $genre) {
                    $genre_links[] = '<a href="' . esc_url(get_term_link($genre)) . '" class="genre-tag">' . esc_html($genre->name) . '</a>';
                }
                echo '<span class="genres-list">' . implode(', ', $genre_links) . '</span>';
                echo '</div>';
            }
            
            // Display writers with links
            $writers = get_the_terms($post_id, 'writer');
            if ($writers && !is_wp_error($writers)) {
                echo '<div class="book-writers">';
                echo '<span class="meta-label">Author(s):</span> ';
                $writer_links = [];
                foreach ($writers as $writer) {
                    $writer_links[] = '<a href="' . esc_url(get_term_link($writer)) . '" class="writer-link">' . esc_html($writer->name) . '</a>';
                }
                echo '<span class="writers-list">' . implode(', ', $writer_links) . '</span>';
                echo '</div>';
            }
            ?>
        </div>
        
        <!-- Excerpt -->
        <?php if (has_excerpt()) : ?>
        <div class="book-excerpt">
            <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
        </div>
        <?php endif; ?>
        
        <!-- Read More Link -->
        <div class="book-actions">
            <a href="<?php the_permalink(); ?>" class="read-more-btn">
                View Details
                <span class="dashicons dashicons-arrow-right-alt"></span>
            </a>
        </div>
    </div>
</div>