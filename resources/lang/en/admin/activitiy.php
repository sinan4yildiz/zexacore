<?php

return [

    /*
    |
    | Activity translations
    |
    */

    'upload' => [
        'create' => [
            'file'   => 'Uploaded a new file named :name',
            'folder' => 'Created a new folder named :name',
        ],
        'remove' => [
            'file' => 'Removed a file named :name',
            'dir'  => 'Removed a folder named :name',
        ],
    ],

    'category' => [
        'create'     => 'Created a new category named :title',
        'update'     => 'Updated a category named :title',
        'activate'   => 'Activated a category named :title',
        'deactivate' => 'Deactivated a category named :title',
        'remove'     => 'Removed a category named :title',
    ],

    'content_type' => [
        'create'     => 'Created a new content type named :title',
        'update'     => 'Updated a content type named :title',
        'activate'   => 'Activated a content type named :title',
        'deactivate' => 'Deactivated a content type named :title',
        'remove'     => 'Removed a content type named :title',
    ],

    'user' => [
        'create'     => 'Created a new user named :firstname :lastname',
        'update'     => 'Updated a user named :firstname :lastname',
        'update_own' => 'Updated its own profile',
        'activate'   => 'Activated a user named :firstname :lastname',
        'deactivate' => 'Deactivated a user named :firstname :lastname',
        'remove'     => 'Removed a user named :firstname :lastname',
    ],

    'language' => [
        'create'     => 'Created a new language named :name',
        'update'     => 'Updated a language named :name',
        'activate'   => 'Activated a language named :name',
        'deactivate' => 'Deactivated a language named :name',
        'remove'     => 'Removed a language named :name',
    ],

    'slug' => [
        'update' => "Updated the URL alias ':keyword'",
    ],

    'setting' => [
        'update' => 'Updated settings',
    ],

    'auth' => [
        'login'  => 'Accessed the admin panel',
        'logout' => 'Logged out',
    ],
];
