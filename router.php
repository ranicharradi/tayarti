<?php

declare(strict_types=1);

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';

if ($path === '/healthz') {
    header('Content-Type: text/plain; charset=utf-8');
    echo "ok\n";
    exit;
}

// Let the built-in server serve existing files directly (assets, PHP scripts, etc.).
$file = __DIR__ . $path;
if ($path !== '/' && is_file($file)) {
    return false;
}

// Default route.
require __DIR__ . '/view/index.php';

