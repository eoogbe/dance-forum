<?php

return [
    'content' => [
        'default' => 'global',
        'profiles' => [
            'global' => [
                'base-uri' => "'self'",
                'img-src' => "'self'",
                'script-src' => ["'self'", "'unsafe-inline'", 'cdn.tinymce.com', 'ajax.googleapis.com'],
                'style-src' => ["'self'", "'unsafe-inline'", 'cdn.tinymce.com'],
            ],
        ],
    ],
];
