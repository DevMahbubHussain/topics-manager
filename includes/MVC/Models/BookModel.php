<?php

namespace TopicsManager\MVC\Models;

use WP_Query;

class BookModel
{

    public function find(int $id)
    {
        return get_post($id);
    }


    public function findMany(array $args)
    {
        $defaults = [
            'post_type' => 'book',
            'posts_per_page' => 12,
            'post_status' => 'publish',
        ];

        return new WP_Query(wp_parse_args($args, $defaults));
    }

    public function findByMeta(string $meta_key, $meta_value, string $compare = '=')
    {
        return  $this->findMany([
            'meta_query' => [
                [
                    'key' => $meta_key,
                    'value' => $meta_value,
                    'compare' => $compare,
                ]
            ]
        ]);
    }


    public function findByTaxonomy(string $taxonomy, $term)
    {
        return $this->findMany([
            'tax_query' => [
                [
                    'taxonomy' => $taxonomy,
                    'fields' => 'fields',
                    'term' => $term,
                ]
            ]
        ]);
    }

    public function getMeta(int $post_id, string $meta_key, $single = true)
    {
        return get_post_meta($post_id, $meta_key, $single);
    }
}
