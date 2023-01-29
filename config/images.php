<?php
return [
    'original'   => env('UPLOAD_FULL_SIZE', public_path('files/articles/original/')),
    'medium'     => env('UPLOAD_MEDIUM_SIZE', public_path('files/articles/medium/')),
    'small'      => env('UPLOAD_ICON_SIZE', public_path('files/articles/small/')),
];