<?php

/**
 * Plugin Name: Topics Manager
 * Plugin URI: https://test.com
 * Description: Topics Manager.
 * Version: 1.0.0
 * Requires at least: 6.1
 * Requires PHP: 8
 * Author: Mahbub Hussain
 * Author URI: https://mahbub.com
 * Licence: GPL v2 or later
 * Licence URL: https://li.com
 * Text Domain: mahbub
 * Domain Path: /public/lang
 */

use App\Frontend\TopicsManagerFrontend;

if (!defined('ABSPATH')) exit;

final class TopicsManager
{
    const VERSION = '1.0';
    const SLUG = 'topics-manager';

    private function __construct()
    {
        require_once __DIR__ . '/vendor/autoload.php';
        $this->includes();
        $this->tm_define_constants();
    }


    public static function init()
    {
        static $instance = false;

        if (!$instance) {
            $instance = new self();
        }

        return $instance;
    }

    public function tm_define_constants()
    {
        // Base paths
        define('TM_ROOT_DIR', plugin_dir_path(__FILE__));
        define('TM_PLUGIN_FILE', __FILE__);
        define('TM_PLUGIN_DIR', plugin_dir_path(TM_PLUGIN_FILE));
        define('TM_PLUGIN_URL', plugin_dir_url(TM_PLUGIN_FILE));

        // Useful subdirectories
        define('TM_INCLUDES_DIR', TM_PLUGIN_DIR . 'includes/');
        define('TM_TEMPLATES_DIR', TM_PLUGIN_DIR . 'templates/');

        // Public-facing URLs
        define('TM_ASSETS_URL', TM_PLUGIN_URL . 'src/assets/');
        define('TM_BUILD_URL', TM_PLUGIN_URL . 'build/');
    }

    private function is_request($type)
    {
        switch ($type) {
            case 'admin':
                return is_admin();

            case 'ajax':
                return defined('DOING_AJAX');

            case 'rest':
                return defined('REST_REQUEST');

            case 'cron':
                return defined('DOING_CRON');

            case 'frontend':
                return (!is_admin() || defined('DOING_AJAX')) && !defined('DOING_CRON');
        }
    }

    private function includes()
    {
        if ($this->is_request('admin')) {
            $this->init_admin();
        } elseif ($this->is_request('frontend')) {
            $this->init_frontend();
        }
        // Initialize common classes
        $this->init_common();
    }

    private function init_admin()
    {
        new \TopicsManager\Assets\Manager();
    }

    private function init_frontend() {
        // new \TopicsManager\Frontend\TopicsManagerFrontend();  //Simplified Frontend Approach
        TopicsManager\MVC\Bootstrap::init();  //MVC Frontend Approach
    }

    private function init_common()
    {
        new TopicsManager\CPT\RenderClass();
    }
}


// kick the plugin
function tm_init()
{
    return TopicsManager::init();
}

tm_init();
