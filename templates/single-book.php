<?php get_header(); ?>

<div class="single-book">
    <?php while ( have_posts() ) : the_post(); ?>
        
        <article id="post-<?php the_ID(); ?>" <?php post_class('book-single'); ?>>
            
            <header class="book-header">
                <h1 class="book-title"><?php the_title(); ?></h1>
                
                <div class="book-meta">
                    <?php
                    // Display ISBN
                    $isbn = get_post_meta(get_the_ID(), 'isbn', true);
                    if ($isbn) {
                        echo '<span class="isbn">ISBN: ' . esc_html($isbn) . '</span>';
                    }
                    
                    // Display genres
                    $genres = get_the_terms(get_the_ID(), 'genre');
                    if ($genres && !is_wp_error($genres)) {
                        echo '<span class="genres"> | Genres: ';
                        $genre_names = [];
                        foreach ($genres as $genre) {
                            $genre_names[] = '<a href="' . get_term_link($genre) . '">' . esc_html($genre->name) . '</a>';
                        }
                        echo implode(', ', $genre_names);
                        echo '</span>';
                    }
                    
                    // Display writers
                    $writers = get_the_terms(get_the_ID(), 'writer');
                    if ($writers && !is_wp_error($writers)) {
                        echo '<span class="writers"> | Writer: ';
                        $writer_names = [];
                        foreach ($writers as $writer) {
                            $writer_names[] = '<a href="' . get_term_link($writer) . '">' . esc_html($writer->name) . '</a>';
                        }
                        echo implode(', ', $writer_names);
                        echo '</span>';
                    }
                    ?>
                </div>
            </header>

            <div class="book-content">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="book-featured-image">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>
                
                <div class="book-description">
                    <?php the_content(); ?>
                </div>
                
                <?php
                // Additional book metadata
                $publication_date = get_post_meta(get_the_ID(), 'publication_date', true);
                $publisher = get_post_meta(get_the_ID(), 'publisher', true);
                $pages = get_post_meta(get_the_ID(), 'pages', true);
                
                if ($publication_date || $publisher || $pages) : ?>
                    <div class="book-details">
                        <h3>Book Details</h3>
                        <ul>
                            <?php if ($publication_date) : ?>
                                <li><strong>Publication Date:</strong> <?php echo esc_html($publication_date); ?></li>
                            <?php endif; ?>
                            <?php if ($publisher) : ?>
                                <li><strong>Publisher:</strong> <?php echo esc_html($publisher); ?></li>
                            <?php endif; ?>
                            <?php if ($pages) : ?>
                                <li><strong>Pages:</strong> <?php echo esc_html($pages); ?></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>

            <footer class="book-footer">
                <div class="book-navigation">
                    <?php
                    previous_post_link('%link', '&larr; Previous Book');
                    next_post_link('%link', 'Next Book &rarr;');
                    ?>
                </div>
            </footer>

        </article>

    <?php endwhile; ?>
</div>

<?php get_footer(); ?>