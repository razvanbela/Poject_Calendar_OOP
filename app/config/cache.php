<?php
return [
    'views'=>[
        'enable'=>$enable=env('CACHE_VIEWS',false),
        'path'=>$enable?base_path('storage/cache/views'): false
    ]
];