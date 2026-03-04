<?php

if (isset($_ENV['VERCEL_URL']) || isset($_SERVER['VERCEL_URL'])) {
    $storage = '/tmp/storage';
    $dirs = [
        "$storage/framework/cache/data",
        "$storage/framework/views",
        "$storage/framework/sessions",
        "$storage/logs",
        "$storage/app/public"
    ];
    foreach ($dirs as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
    }
}

require __DIR__ . '/../public/index.php';
