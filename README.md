# Topics Manager Plugin

A SOLID, factory-based WordPress plugin for managing custom post types, taxonomies, and meta boxes with full REST API support.

## Features

### Architecture
✅ **SOLID Principles** - Each class has a single responsibility  
✅ **Factory Pattern** - Easy creation of new CPTs, taxonomies, and meta boxes  
✅ **Extensible Design** - Add new fields or functionality without modifying core classes  
✅ **MVC Pattern** - Clean separation of concerns for frontend components 
✅ **Singleton Pattern** - Efficient plugin initialization and resource management 

### Supported Field Types
| Field Type        | Features                                  |
|-------------------|-------------------------------------------|
| Text              | Basic text input                          |
| Number            | Min/max validation                        |
| Date              | Date picker                               |
| Select            | Dropdown selection                        |
| Checkbox          | Single toggle                             |
| Checkbox Group    | Multiple select checkboxes                |
| Radio             | Exclusive option selection                |
| Image Upload      | Media library integration                 |
| WYSIWYG Editor    | TinyMCE rich text editing                 |
| Multiple Images   | Bulk upload with drag & drop reordering   |


### Security Features
- Automatic input sanitization
- Required field validation
- Min/max value enforcement
- Nonce verification for all form submissions
- Role-based capability management


### ✅ Frontend Features
- **Book Listing** – Display books anywhere using shortcode  
- **Single Book Page** – Detailed view with meta and taxonomies  
- **Book Archive** – Automatically generates archive pages for books  
- **Pagination** – Supports paginated listings  

### ✅ Shortcode
Display books anywhere in your posts or pages:

```text
[books_listing]
```

## Installation
1. Upload the plugin to `/wp-content/plugins/`
2. Activate through WordPress admin
3. Configure post types in `/config/post-types.php`

## Configuration
Example CPT configuration:
```php
return [
    [
        'name' => 'book',
        'args' => [
            'label' => 'Books',
            'show_in_rest' => true,
            // ... additional args
        ],
        'meta_boxes' => [
            [
                'id' => 'book_details',
                'fields' => [
                    ['id' => 'price', 'type' => 'number', 'min' => 0],
                    ['id' => 'cover', 'type' => 'image']
                ]
            ]
        ]
    ]
];

## Requirements
=============
WordPress 6.1+
PHP 8.0+
Composer (for development)