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

    'slugs' => [
        'module' => [
            'category'     => 'Web/Structure/Category',
            'content_type' => 'Web/Structure/ContentType',
        ]
    ],

];
