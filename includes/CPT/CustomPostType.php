<?php

declare(strict_types=1);

namespace TopicsManager\CPT;

use TopicsManager\Meta\MetaBox;
use TopicsManager\Contracts\Registrable;


class CustomPostType implements Registrable
{

    private string $name;
    private array|string $args;
    private array $taxonomies;
    private array $meta_boxes;
    private bool $isRegistered = false;

    public function __construct(
        string $name,
         array $args = [],
          array $taxonomies = [], array $meta_boxes = [])
    {
        $this->name = $name;
        $this->args = $args;
        $this->taxonomies = $taxonomies;
        $this->meta_boxes = $meta_boxes;

          if (!empty($capabilities)) $this->args['capabilities'] = $capabilities;
        
    }

    public function register(): void
    {
        if ($this->isRegistered) return;
        $this->isRegistered = true;

        // Register the post type
        $result = register_post_type($this->name, $this->args);
        if (is_wp_error($result)) {
            error_log("Failed to register post type: " . $result->get_error_message());
        }

        // Register taxonomies (if any)
        foreach ($this->taxonomies as $taxonomy) {
            $taxonomy->register();
        }

        // Register meta boxes (if any) 
        foreach ($this->meta_boxes as  $box) {
            $meta = new MetaBox($this->name, $box);
            $meta->register();
        }

     
    }

   
}
