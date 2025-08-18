<?php

declare(strict_types=1);

namespace TopicsManager\Meta;

use TopicsManager\Contracts\Registrable;

class MetaBox implements Registrable
{

    private array $box = [];
    private string $post_type;

    public function __construct(string $post_type, array $box = [])
    {
        $this->post_type = $post_type;
        $this->box = $box;
    }
    public function register(): void
    {
        add_action('add_meta_boxes', function () {

            add_meta_box(
                $this->box['id'],
                $this->box['title'],
                [$this, 'render'],
                $this->post_type,
                $this->box['context'] ?? 'normal',
                $this->box['priority'] ?? 'default'
            );
        });

        add_action('save_post_' . $this->post_type, [$this, 'save_metabox']);
    }

    public function render($post): void
    {
        foreach ($this->box['fields'] as $field) {
            $value = get_post_meta($post->ID, $field['id'], true);
            switch ($field['type']) {
                case 'text':
                case 'number':
                case 'date':
                    echo "<label>{$field['label']}: <input type='{$field['type']}' name='{$field['id']}' value='" . esc_attr($value) . "'/></label><br/>";
                    break;
                case 'checkbox':
                    $checked = checked($value, 1, false);
                    echo "<label><input type='checkbox' name='{$field['id']}' value='1' $checked /> {$field['label']}</label><br/>";
                    break;
                case 'select':
                    echo "<label>{$field['label']}: <select name='{$field['id']}'>";
                    foreach ($field['options'] as $option) {
                        $selected = selected($value, $option, false);
                        echo "<option value='{$option}' $selected>{$option}</option>";
                    }
                    echo "</select></label><br/>";
                    break;
            }
        }
    }

    public function save_metabox($post_id):void{

        if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

        foreach($this->box['fields'] as $field){
            $value = $_POST[$field['id']] ?? null;

            if ($field['type'] === 'checkbox') $value = $value ? 1 : 0;
            if ($field['type'] !== 'checkbox') $value = sanitize_text_field($value);
            update_post_meta($post_id, $field['id'], $value);

        }


    }
}
