<?php
return [
    [
        'name' => 'book',
        'args' => [
            'label' => 'Books',
            'public' => true,
            'show_in_rest' => true,
            'rest_base' => 'books',
            'capability_type' => 'post',
            'supports' => ['title', 'editor', 'thumbnail'], // Ensure editor support
        ],
        // 'capabilities' => ['edit_posts', 'publish_posts'],
        // 'roles' => ['editor', 'administrator'],
        'taxonomies' => [
            ['name' => 'genre', 'args' => ['label' => 'Genres', 'hierarchical' => true, 'show_in_rest' => true]],
            ['name' => 'writer', 'args' => ['label' => 'Writers', 'hierarchical' => false, 'show_in_rest' => true]],
        ],
        'meta_boxes' => [
            [
                'id' => 'book_details',
                'title' => 'Book Details',
                'fields' => [
                    ['id' => 'isbn', 'label' => 'ISBN', 'type' => 'text'],
                    ['id' => 'pages', 'label' => 'Pages', 'type' => 'number', 'min' => 1],
                    ['id' => 'published', 'label' => 'Published', 'type' => 'date'],
                ],
            ],
        ],
    ],
];

// return [
//     [
//         'name' => 'book',
//         'args' => [
//             // Basic Identification
//             'label'                 => 'Books',
//             'singular_name'         => 'Book',
//             'menu_name'             => 'Book Library',
            
//             // Visibility & Accessibility
//             'public'               => true,
//             'publicly_queryable'    => true,
//             'show_ui'              => true,
//             'show_in_nav_menus'    => true,
//             'show_in_admin_bar'    => true,
//             'show_in_rest'         => true,
//             'rest_base'            => 'books',
//             'rest_controller_class' => 'WP_REST_Posts_Controller',
            
//             // Admin Interface
//             'menu_icon'            => 'dashicons-book-alt',
//             'capability_type'      => 'post',
//             'map_meta_cap'        => true,
//             'hierarchical'        => false,
//             'exclude_from_search'  => false,
            
//             // Frontend Display
//             'has_archive'          => 'books',
//             'rewrite'             => [
//                 'slug'       => 'book',
//                 'with_front' => false,
//                 'feeds'     => true,
//                 'pages'     => true
//             ],
//             'query_var'           => true,
            
//             // Features Support
//             'supports'            => [
//                 'title',
//                 'editor',
//                 'thumbnail',
//                 'excerpt',
//                 'comments',
//                 'revisions',
//                 'custom-fields',
//                 'page-attributes',
//                 'post-formats'
//             ],
            
//             // Labels (for better admin UI)
//             'labels'              => [
//                 'add_new_item'      => 'Add New Book',
//                 'edit_item'        => 'Edit Book',
//                 'view_item'        => 'View Book',
//                 'view_items'       => 'View Books',
//                 'search_items'     => 'Search Books',
//                 'not_found'        => 'No books found',
//                 'not_found_in_trash'=> 'No books found in Trash',
//                 'all_items'        => 'All Books',
//                 'archives'         => 'Book Archives',
//                 'attributes'       => 'Book Attributes',
//                 'insert_into_item' => 'Insert into book',
//                 'uploaded_to_this_item' => 'Uploaded to this book',
//             ]
//         ],
        
//         // Custom Capabilities (optional)
//         'capabilities' => [
//             'edit_post'          => 'edit_book',
//             'read_post'          => 'read_book',
//             'delete_post'        => 'delete_book',
//             'edit_posts'         => 'edit_books',
//             'edit_others_posts'  => 'edit_others_books',
//             'publish_posts'     => 'publish_books',
//             'read_private_posts' => 'read_private_books',
//         ],
        
//         // Role Restrictions (optional)
//         'roles' => ['editor', 'administrator', 'book_manager'],
        
//         // Taxonomies
//         'taxonomies' => [
//             [
//                 'name' => 'genre',
//                 'args' => [
//                     'label'         => 'Genres',
//                     'hierarchical'  => true,
//                     'show_in_rest'  => true,
//                     'rewrite'      => ['slug' => 'book-genre'],
//                     'capabilities' => [
//                         'manage_terms' => 'manage_book_genres',
//                         'edit_terms'   => 'edit_book_genres',
//                         'delete_terms' => 'delete_book_genres',
//                         'assign_terms' => 'assign_book_genres'
//                     ]
//                 ]
//             ],
//             [
//                 'name' => 'author',
//                 'args' => [
//                     'label'         => 'Authors',
//                     'hierarchical'  => false,
//                     'show_in_rest'  => true,
//                     'rewrite'      => ['slug' => 'book-author'],
//                     'meta_box_cb'   => 'post_tags_meta_box'
//                 ]
//             ]
//         ],
        
//         // Meta Boxes
//         'meta_boxes' => [
//             [
//                 'id'       => 'book_details',
//                 'title'    => 'Book Details',
//                 'context'  => 'normal',
//                 'priority' => 'high',
//                 'fields'   => [
//                     [
//                         'id'    => 'isbn',
//                         'label' => 'ISBN',
//                         'type'  => 'text',
//                         'sanitize_callback' => 'sanitize_text_field'
//                     ],
//                     [
//                         'id'    => 'pages',
//                         'label' => 'Pages',
//                         'type'  => 'number',
//                         'min'   => 1,
//                         'max'   => 5000,
//                         'step'  => 1
//                     ],
//                     [
//                         'id'    => 'publication_date',
//                         'label' => 'Publication Date',
//                         'type'  => 'date',
//                         'save_format' => 'Y-m-d'
//                     ],
//                     [
//                         'id'    => 'cover_image',
//                         'label' => 'Cover Image',
//                         'type'  => 'image',
//                         'options' => [
//                             'button_text' => 'Upload Cover',
//                             'image_size'  => 'medium'
//                         ]
//                     ],
//                     [
//                         'id'    => 'edition',
//                         'label' => 'Edition',
//                         'type'  => 'select',
//                         'options' => [
//                             'first'  => 'First Edition',
//                             'second' => 'Second Edition',
//                             'special' => 'Special Edition'
//                         ]
//                     ]
//                 ]
//             ],
//             [
//                 'id'       => 'book_pricing',
//                 'title'    => 'Pricing Information',
//                 'context'  => 'side',
//                 'fields'   => [
//                     [
//                         'id'    => 'price',
//                         'label' => 'Retail Price ($)',
//                         'type'  => 'number',
//                         'step'  => 0.01,
//                         'min'   => 0
//                     ],
//                     [
//                         'id'    => 'discount',
//                         'label' => 'Discount (%)',
//                         'type'  => 'range',
//                         'min'   => 0,
//                         'max'   => 100,
//                         'step'  => 5
//                     ]
//                 ]
//             ]
//         ],
        
//         // Additional Features
//         'features' => [
//             'exportable'          => true,
//             'block_editor'       => true,
//             'default_thumbnail'  => get_template_directory_uri() . '/images/default-book-cover.jpg',
//             'admin_columns'      => [
//                 'cover' => [
//                     'title'   => 'Cover',
//                     'render'  => 'the_post_thumbnail',
//                     'size'    => [80, 120]
//                 ],
//                 'isbn' => 'ISBN',
//                 'price' => [
//                     'title' => 'Price',
//                     'meta_key' => '_book_price'
//                 ]
//             ],
//             'quick_edit_fields' => ['genre', 'price'],
//             'bulk_actions'      => [
//                 'export_csv' => 'Export as CSV'
//             ]
//         ]
//     ]
// ];