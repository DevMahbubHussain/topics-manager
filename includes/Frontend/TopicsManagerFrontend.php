<?php

namespace TopicsManager\Frontend;

class TopicsManagerFrontend
{
    public function __construct()
    {
        // Shortcodes 
        add_shortcode('books_listing', [$this, 'books_listing_shortcode']);

        // Templates 
        add_filter('template_include', [$this, 'custom_templates']);

        // Assets
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
    }

    public function books_listing_shortcode($atts)
    {
        $atts = shortcode_atts([
            'posts_per_page' => 12,
            'genre' => '',
            'writer' => '',
            'show_filters' => true
        ], $atts);

        ob_start();

        $posts_per_page = $atts['posts_per_page'];
        $genre = $atts['genre'];
        $writer = $atts['writer'];
        $show_filters = $atts['show_filters'];

        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        require_once TM_TEMPLATES_DIR . 'books-listing.php';

        return ob_get_clean();
    }


    public function custom_templates($template)
    {
        if (is_singular('book')) {
            return  TM_TEMPLATES_DIR . 'single-book.php';
        }

        if (is_post_type_archive('book')) {
            return  TM_TEMPLATES_DIR . 'archive-book.php';
        }

        return $template;
    }

    public function enqueue_assets()
    {
        if (is_singular('book') || is_post_type_archive('book') || is_tax(['genre', 'writer'])) {
            wp_enqueue_style(
                'tm-frontend',
                TM_ASSETS_URL . 'css/frontend.css',
                [],
                filemtime(TM_PLUGIN_DIR . 'assets/css/frontend.css')
            );

            wp_enqueue_script(
                'tm-frontend',
                TM_ASSETS_URL . 'js/frontend.js',
                ['jquery'],
                filemtime(TM_PLUGIN_DIR . 'assets/js/frontend.js'),
                true
            );
        }
    }
}
