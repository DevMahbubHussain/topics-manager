<?php

$genres = get_terms([
    'taxonomy' => 'genre',
    'hide_empty' => true,
    'orderby' => 'name',
    'order' => 'ASC'
]);

$writers = get_terms([
    'taxonomy' => 'writer', 
    'hide_empty' => true,
    'orderby' => 'name',
    'order' => 'ASC'
]);


$current_filters = [
    'search' => sanitize_text_field($_GET['search'] ?? ''),
    'genre' => sanitize_text_field($_GET['genre'] ?? ''),
    'writer' => sanitize_text_field($_GET['writer'] ?? ''),
    'pages_min' => intval($_GET['pages_min'] ?? ''),
    'pages_max' => intval($_GET['pages_max'] ?? ''),
    'published_after' => sanitize_text_field($_GET['published_after'] ?? '')
];
?>

<div class="tm-filter-section">
    <form class="tm-filter-form" id="tm-book-filters" method="GET">
        
        <!-- Search Filter -->
        <div class="tm-filter-group">
            <label for="tm-search" class="tm-filter-label">Search Books:</label>
            <input type="text" id="tm-search" name="search" 
                   class="tm-filter-input"
                   value="<?php echo esc_attr($current_filters['search']); ?>" 
                   placeholder="Search by title or description...">
        </div>

        <!-- Genre Filter -->
        <div class="tm-filter-group">
            <label for="tm-genre" class="tm-filter-label">Genre:</label>
            <select id="tm-genre" name="genre" class="tm-filter-select">
                <option value="">All Genres</option>
                <?php foreach ($genres as $genre) : ?>
                    <option value="<?php echo esc_attr($genre->slug); ?>" 
                        <?php selected($current_filters['genre'], $genre->slug); ?>>
                        <?php echo esc_html($genre->name); ?> (<?php echo $genre->count; ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Writer Filter -->
        <div class="tm-filter-group">
            <label for="tm-writer" class="tm-filter-label">Writer:</label>
            <select id="tm-writer" name="writer" class="tm-filter-select">
                <option value="">All Writers</option>
                <?php foreach ($writers as $writer) : ?>
                    <option value="<?php echo esc_attr($writer->slug); ?>"
                        <?php selected($current_filters['writer'], $writer->slug); ?>>
                        <?php echo esc_html($writer->name); ?> (<?php echo $writer->count; ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Pages Range Filter -->
        <div class="tm-filter-group">
            <label class="tm-filter-label">Pages:</label>
            <div class="tm-range-inputs">
                <input type="number" name="pages_min" 
                       class="tm-filter-input tm-range-input"
                       value="<?php echo esc_attr($current_filters['pages_min']); ?>" 
                       placeholder="Min" min="1" step="1">
                <span class="tm-range-separator">to</span>
                <input type="number" name="pages_max" 
                       class="tm-filter-input tm-range-input"
                       value="<?php echo esc_attr($current_filters['pages_max']); ?>" 
                       placeholder="Max" min="1" step="1">
            </div>
        </div>

        <!-- Published Date Filter -->
        <div class="tm-filter-group">
            <label for="tm-published-after" class="tm-filter-label">Published After:</label>
            <input type="date" id="tm-published-after" name="published_after" 
                   class="tm-filter-input"
                   value="<?php echo esc_attr($current_filters['published_after']); ?>">
        </div>

        <!-- Action Buttons -->
        <div class="tm-filter-actions">
            <button type="submit" class="tm-filter-btn tm-apply-btn">
                <span class="tm-btn-text">Apply Filters</span>
                <span class="tm-loading-spinner" style="display: none;">Loading...</span>
            </button>
            <button type="button" class="tm-filter-btn tm-reset-btn" id="tm-reset-filters">
                Reset Filters
            </button>
        </div>

    </form>
    
    <!-- Active Filters Display -->
    <div class="tm-active-filters" id="tm-active-filters" style="display: none;">
        <h4>Active Filters:</h4>
        <div class="tm-active-filters-list"></div>
    </div>
</div>