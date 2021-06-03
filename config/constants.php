<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Constant configurations
    |--------------------------------------------------------------------------
    |
    */

    'uploads' => [
        'mimes' => ['jpg', 'jpeg', 'png', 'svg', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'rtf', 'csv', 'txt', 'rar', 'zip', 'ppt', 'pptx', 'xml'],
        'kinds' => [
            'images'      => ['jpg', 'jpeg', 'png', 'svg'],
            'files'       => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'rtf', 'csv', 'txt', 'rar', 'zip', 'ppt', 'pptx', 'xml'],
            'previewable' => ['pdf', 'txt', 'svg', 'jpg', 'jpeg', 'png'],
        ]
    ],

    'relationships' => [
        'category'    => [
            'article' => 'article_category',
        ],
        'translation' => [
            'article' => 'article_translation',
            'page'    => 'page_translation',
        ],
    ],

    'slugs' => [
        'module' => [
            'article'      => 'Web/Content/Article',
            'page'         => 'Web/Content/Page',
            'category'     => 'Web/Structure/Category',
            'content_type' => 'Web/Structure/ContentType',
        ]
    ],

];
