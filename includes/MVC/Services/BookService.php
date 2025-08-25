<?php

namespace TopicsManager\MVC\Services;

use TopicsManager\MVC\Models\BookModel;

class BookService
{

    private $model;

    public function __construct(BookModel $model)
    {
        $this->model = $model;
    }

    public function getBooksForListing(array $filters = [])
    {
        $args = ['posts_per_page' => 12];

        // Apply business logic to filters

        if (!empty($filters['genre'])) {
            $args = $this->applyGenreFilter($args, $filters['genre']);
        }

        if (!empty($filters['writer'])) {
            $args = $this->applyWriterFilter($args, $filters['writer']);
        }

        return $this->model->findMany($args);
    }

    public function applyGenreFilter(array $args, string $genre): array
    {
        if (!empty($genre)) {
            $args['tax_query'][] = [
                'taxonomy' => 'genre',
                'field' => 'slug',
                'terms' => $genre
            ];
        }

        return $args;
    }


    public function applyWriterFilter(array $args, string $writer): array
    {
        if (!empty($writer)) {
            $args['tax_query'][] = [
                'taxonomy' => 'writer',
                'field' => 'slug',
                'terms' => $writer
            ];
        }

        return $args;
    }

    public function getBookWithDetails(int $book_id)
    {
        $book = $this->model->find($book_id);
        if (!$book) {
            return null;
        }
        // Add business logic to enrich data

        return [
            'post' => $book,
            'meta'  => $this->getBookMeta($book_id),
            'taxonomies'  => $this->getBookTaxonomies($book_id),
        ];
    }

    private function getBookMeta(int $book_id):array
    {
        return [
            'isbn' => $this->model->getMeta($book_id, 'isbn'),
            'pages' => $this->model->getMeta($book_id, 'pages'),
            'published' => $this->model->getMeta($book_id, 'published'),
        ];
    }

    private function  getBookTaxonomies(int $book_id):array{
        return [
            'genres' => wp_get_post_terms($book_id,'genre'),
            'writers' => wp_get_post_terms($book_id,'writer'),
        ];
    }
}
