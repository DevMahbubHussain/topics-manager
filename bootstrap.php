<?php

use TopicsManager\Factory;

class RenderClass{

public function render() {
    static $hasRegistered = false;
    if ($hasRegistered) return;
    $hasRegistered = true;

    $configs = require_once __DIR__ . '/config/post-types.php';
    if (!is_array($configs)) {
        throw new RuntimeException("Post types config must return an array.");
    }

    add_action('init', function() use ($configs) {
        foreach ($configs as $config) {
            try {
                $cpt = Factory::create($config);
                if ($cpt instanceof Registrable) {
                    $cpt->register();
                }
            } catch (Exception $e) {
                error_log("Post type registration failed: " . $e->getMessage());
            }
        }
    });
}
}


