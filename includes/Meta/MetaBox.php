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
        wp_nonce_field($this->box['id'] . '_nonce', $this->box['id'] . '_nonce_field');
        foreach ($this->box['fields'] as $field) {
            $value = get_post_meta($post->ID, $field['id'], true);
            $this->renderField($field, $value);
        }
    }

    private function renderField(array $field, $value): void
    {
        $label = $field['label'] ?? '';
        $type  = $field['type'] ?? 'text';

        switch ($type) {
            case 'text':
            case 'number':
            case 'date':
                $min = $field['min'] ?? '';
                $max = $field['max'] ?? '';
                echo "<label>{$label}: <input type='{$type}' name='{$field['id']}' value='" . esc_attr($value) . "' min='{$min}' max='{$max}'/></label><br/>";
                break;

            case 'select':
                echo "<label>{$label}: <select name='{$field['id']}'>";
                foreach ($field['options'] ?? [] as $option) {
                    $selected = selected($value, $option, false);
                    echo "<option value='{$option}' $selected>{$option}</option>";
                }
                echo "</select></label><br/>";
                break;

            case 'checkbox':
                $checked = checked($value, 1, false);
                echo "<label><input type='checkbox' name='{$field['id']}' value='1' $checked/> {$label}</label><br/>";
                break;

            case 'checkbox_group':
                foreach ($field['options'] ?? [] as $option) {
                    $checked = in_array($option, (array)$value) ? 'checked' : '';
                    echo "<label><input type='checkbox' name='{$field['id']}[]' value='{$option}' {$checked}/> {$option}</label><br/>";
                }
                break;

            case 'radio':
                foreach ($field['options'] ?? [] as $option) {
                    $checked = checked($value, $option, false);
                    echo "<label><input type='radio' name='{$field['id']}' value='{$option}' {$checked}/> {$option}</label><br/>";
                }
                break;

            case 'image':
                $image_url = esc_url($value);
                $preview   = $image_url ? "<img src='{$image_url}' alt='' style='max-width:150px; display:block; margin-top:5px;' />" : '';
                echo "<label>{$label}: 
            <input type='text' class='widefat image-url' name='{$field['id']}' value='{$image_url}' />
            <button class='upload_image_button button'>Upload</button>
            <div class='image-preview'>{$preview}</div>
          </label><br/>";
                break;

            case 'gallery':
                $images = is_array($value) ? $value : [];
                echo "<label>{$label}: 
            <button class='upload_gallery_button button'>Add Images</button>
          </label>";

                echo "<ul class='gallery-preview' style='margin-top:10px; display:flex; gap:10px; flex-wrap:wrap;'>";
                foreach ($images as $img) {
                    echo "<li style='list-style:none; position:relative;'>
                    <img src='{$img}' style='max-width:100px; height:auto;' />
                    <input type='hidden' name='{$field['id']}[]' value='{$img}' />
                    <span class='remove-image' style='cursor:pointer; color:red; position:absolute; top:0; right:5px;'>&times;</span>
                </li>";
                }
                echo "</ul>";
                break;

            case 'wysiwyg':
                wp_editor($value, $field['id'], ['textarea_name' => $field['id']]);
                break;
        }
    }

    public function save_metabox($post_id): void
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!isset($_POST[$this->box['id'] . '_nonce_field'])) return;
        if (!wp_verify_nonce($_POST[$this->box['id'] . '_nonce_field'], $this->box['id'] . '_nonce')) return;

        foreach ($this->box['fields'] as $field) {
            $id = $field['id'];
            $value = $_POST[$id] ?? null;

            if (!empty($field['required']) && (empty($value) && $value !== '0')) continue;

            if ($field['type'] === 'number') {
                $value = intval($value);
                if (isset($field['min']) && $value < $field['min']) $value = $field['min'];
                if (isset($field['max']) && $value > $field['max']) $value = $field['max'];
            }

            if ($field['type'] === 'checkbox') {
                $value = $value ? 1 : 0;
            }

            if ($field['type'] === 'checkbox_group') {
                $value = is_array($value) ? array_map('sanitize_text_field', $value) : [];
            }

            if ($field['type'] === 'text' || $field['type'] === 'wysiwyg' || $field['type'] === 'date') {
                $value = sanitize_text_field($value);
            }

            if ($field['type'] === 'gallery') {
                $value = isset($_POST[$field['id']]) ? array_map('esc_url_raw', $_POST[$field['id']]) : [];
                update_post_meta($post_id, $field['id'], $value);
                continue;
            }

            update_post_meta($post_id, $id, $value);
        }
    }
}
