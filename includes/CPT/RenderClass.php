<?php

namespace TopicsManager\CPT;

use Exception;

use RuntimeException;
use TopicsManager\Contracts\Registrable;

class RenderClass
{

    public function __construct()
    {
        $this->render();
    }

    public function render()
    {
        static $hasRegistered = false;
        if ($hasRegistered) return;
        $hasRegistered = true;


        $configPath = dirname(__DIR__, 2) . '/config/post-types.php';
        if (!file_exists($configPath)) {
            throw new RuntimeException("Config file not found at: " . $configPath);
        }
        $configs = require_once $configPath;

        if (!is_array($configs)) {
            throw new RuntimeException("Post types config must return an array.");
        }
        add_action('init', function () use ($configs) {
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
        },0);
    }
}
