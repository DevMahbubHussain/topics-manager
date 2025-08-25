<?php if (!empty($books)) : ?>
    <div class="books-listing">
        <?php foreach ($books as $book) : ?>
            <?php 
                $book_id = $book->ID;
                $book_details = $this->book_service->getBookWithDetails($book_id);
                $meta = $book_details['meta'];
                $taxonomies = $book_details['taxonomies'];
            ?>
            <div class="book-item">
                <a href="<?php echo get_permalink($book_id);?>"><?php echo esc_html($book->post_title); ?></a>
                <p>ISBN: <?php echo esc_html($meta['isbn']); ?></p>
                <p>Pages: <?php echo esc_html($meta['pages']); ?></p>
                <p>Published: <?php echo esc_html($meta['published']); ?></p>

                <!-- Genres -->
                <p>Genres: 
                    <?php
                        if (!empty($taxonomies['genres'])) {
                            $genre_names = wp_list_pluck($taxonomies['genres'], 'name');
                            echo esc_html(implode(', ', $genre_names));
                        } else {
                            echo 'None';
                        }
                    ?>
                </p>

                <!-- Writers -->
                <p>Writers: 
                    <?php
                        if (!empty($taxonomies['writers'])) {
                            $writer_names = wp_list_pluck($taxonomies['writers'], 'name');
                            echo esc_html(implode(', ', $writer_names));
                        } else {
                            echo 'None';
                        }
                    ?>
                </p>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>No books found.</p>
<?php endif; ?>
