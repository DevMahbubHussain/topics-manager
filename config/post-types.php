<?php
return [
    [
        'name' => 'book',
        'args' => [
            'label' => 'Books',
            'public' => true,
            'show_in_rest' => true,
            'rest_base' => 'books',
            'rest_controller_class' => 'WP_REST_Posts_Controller',
            'capability_type' => 'post',
            'supports' => ['title', 'editor', 'thumbnail'],
            'labels'              => [
                'add_new_item'      => 'Add New Book',
                'edit_item'        => 'Edit Book',
                'view_item'        => 'View Book',
                'view_items'       => 'View Books',
                'search_items'     => 'Search Books',
                'not_found'        => 'No books found',
                'not_found_in_trash' => 'No books found in Trash',
                'all_items'        => 'All Books',
                'archives'         => 'Book Archives',
                'attributes'       => 'Book Attributes',
                'insert_into_item' => 'Insert into book',
                'uploaded_to_this_item' => 'Uploaded to this book',
            ],
            // Admin Interface
            'menu_icon'            => 'dashicons-book-alt',
            'capability_type'      => 'post',
            'map_meta_cap'        => true,
            'hierarchical'        => false,
            'exclude_from_search'  => false,

            // Frontend Display
            'has_archive'          => 'books',
            'rewrite'             => [
                'slug'       => 'book',
                'with_front' => false,
                'feeds'     => true,
                'pages'     => true
            ],

        ],

        'capabilities' => ['edit_posts', 'publish_posts'],
        'roles' => ['editor', 'administrator'],
        'taxonomies' => [
            ['name' => 'genre', 'args' => ['label' => 'Genres', 'hierarchical' => true, 'show_in_rest' => true]],
            ['name' => 'writer', 'args' => ['label' => 'Writers', 'hierarchical' => false, 'show_in_rest' => true]],
        ],
        'meta_boxes' => [
            [
                'id' => 'book_details',
                'title' => 'Book Details',
                'fields' => [
                    ['id' => 'isbn', 'label' => 'ISBN', 'type' => 'text', 'required' => true],
                    ['id' => 'pages', 'label' => 'Pages', 'type' => 'number', 'min' => 1],
                    ['id' => 'published', 'label' => 'Published Date', 'type' => 'date'],
                    ['id' => 'genre_select', 'label' => 'Genre', 'type' => 'select', 'options' => ['Fiction', 'Non-fiction']],
                    ['id' => 'authors', 'label' => 'Authors', 'type' => 'checkbox_group', 'options' => ['Author A', 'Author B']],
                    ['id' => 'summary', 'label' => 'Summary', 'type' => 'wysiwyg'],
                    ['id' => 'cover', 'label' => 'Cover Image', 'type' => 'image'],
                    ['id' => 'cover_gallery', 'label' => 'Cover Images', 'type' => 'gallery'],
                ],
            ],
        ],
    ],

    // 2nd cpt without taxonomy and metabox 
    // [
    //     'name' => 'movies',
    //     'args' => [
    //         'label' => 'Movies',
    //         'public' => true,
    //         'show_in_rest' => true,
    //         'rest_base' => 'movies',
    //         'rest_controller_class' => 'WP_REST_Posts_Controller',
    //         'capability_type' => 'post',
    //         'supports' => ['title', 'editor', 'thumbnail'],
    //     ],

    // ],

    // 3rd cpt with taxonomy
    // [
    //     'name' => 'wordpress',
    //     'args' => [
    //         'label' => 'WordPress',
    //         'public' => true,
    //         'show_in_rest' => true,
    //         'rest_base' => 'WordPress',
    //         'rest_controller_class' => 'WP_REST_Posts_Controller',
    //         'capability_type' => 'post',
    //         'supports' => ['title', 'editor', 'thumbnail'],
    //     ],
    //     'taxonomies' => [
    //         ['name' => 'plugin', 'args' => ['label' => 'Plugins', 'hierarchical' => true, 'show_in_rest' => true]],
    //         ['name' => 'theme', 'args' => ['label' => 'Themes', 'hierarchical' => false, 'show_in_rest' => true]],
    //     ],

    // ],

];
