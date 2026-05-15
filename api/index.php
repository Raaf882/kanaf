<?php

/**
 * Vercel entry point for Laravel.
 *
 * Vercel's filesystem is read-only except for /tmp.
 * We copy the seeded SQLite database to /tmp on cold start
 * so demo data is available without a real database server.
 */

$tmpDb = '/tmp/database.sqlite';
$srcDb = __DIR__ . '/../database/database.sqlite';

// Copy pre-seeded DB to writable /tmp on cold start
if (! file_exists($tmpDb) && file_exists($srcDb)) {
    copy($srcDb, $tmpDb);
}

// Override environment for Vercel serverless
$overrides = [
    'APP_ENV'        => 'production',
    'APP_DEBUG'      => 'false',
    'DB_CONNECTION'  => 'sqlite',
    'DB_DATABASE'    => $tmpDb,
    'SESSION_DRIVER' => 'cookie',
    'SESSION_ENCRYPT'=> 'true',
    'CACHE_STORE'    => 'array',
    'QUEUE_CONNECTION'=> 'sync',
    'LOG_CHANNEL'    => 'stderr',
];

foreach ($overrides as $key => $value) {
    putenv("{$key}={$value}");
    $_ENV[$key]    = $value;
    $_SERVER[$key] = $value;
}

require __DIR__ . '/../public/index.php';
