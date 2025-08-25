<?php

namespace TopicsManager\MVC\Controller;

use TopicsManager\MVC\Services\BookService;

class BookController
{
    private $book_service;

    public function __construct(BookService $book_service)
    {
        $this->book_service = $book_service;
        $this->registerHooks();
    }

    public function registerHooks()
    {
        // ShortCode
        add_shortcode('books_listing', [$this, 'handleShortcode']);

        // Templates 
        add_filter('template_include', [$this, 'mt_plugin_custom_templates']);
    }

    public function handleShortcode($atts)
    {
        $filters = shortcode_atts([
            'posts_per_page' => 12,
            'genre' => '',
            'writer' => '',
        ], $atts);

        $query = $this->book_service->getBooksForListing($filters);

        $books = $query->posts ?? [];
        $total = $query->found_posts ?? 0;
        $book_service = $this->book_service;

        // print_r($books);
        // var_dump($book_service);

        ob_start();

        include __DIR__ . '/../View/listing.php';

        return ob_get_clean();
    }



    public function mt_plugin_custom_templates($template)
    {
        // Path to plugin views
        $plugin_templates = __DIR__ . '/../View/';
        if (is_singular('book')) {
              return $plugin_templates . 'single-book.php';
        }

        if (is_post_type_archive('book')) {
            return $plugin_templates . 'archive-book.php';
        }

        return $template;
    }
}
