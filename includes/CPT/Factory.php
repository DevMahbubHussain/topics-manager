<?php

declare(strict_types=1);

namespace TopicsManager\CPT;

use TopicsManager\CPT\CustomPostType;

class Factory
{
    public static function create(array $config): CustomPostType
    {

        $taxonomies = [];
        foreach ($config['taxonomies'] ?? [] as $tax) {
            $taxonomies[] = new Taxonomy($tax['name'], [$config['name']], $tax['args'] ?? []);
        }
        return new CustomPostType(
            $config['name'],
            $config['args'] ?? [],
            $config['capabilities'] ?? [],
            $config['roles'] ?? [],
            $taxonomies,
            $config['meta_boxes'] ?? []
        );
    }
}
