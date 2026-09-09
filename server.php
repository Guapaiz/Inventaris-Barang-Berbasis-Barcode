<?php

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// Cek jika file statis ada di folder public, langsung akses file tersebut
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

// Jalankan aplikasi Laravel dari public/index.php
require_once __DIR__.'/public/index.php';
