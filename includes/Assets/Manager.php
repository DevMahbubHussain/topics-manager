<?php

declare(strict_types=1);

namespace TopicsManager\Assets;

class Manager
{

    public function __construct()
    {
        add_action('admin_enqueue_scripts', array($this, 'tm_admin_register_assets'));
    }

    public function tm_admin_register_assets()
    {
        wp_enqueue_media();
         wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script('meta-box-upload', TM_ASSETS_URL .  'js/meta-box-upload.js', ['jquery'], null, true);
    }
}
