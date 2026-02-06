<?php

return [
    'middleware_group' => 'web',
    'guard' => 'web',
    'temporary_file_upload' => [
        'enabled' => true,
        'middleware' => 'web',
        'rules' => 'required|mimes:png,jpg,jpeg,webp,pdf|max:10240', // 10MB
        'directory' => storage_path('app/livewire-tmp'),
        'cleanup' => true,
        'auto_name' => true,
    ],
];
