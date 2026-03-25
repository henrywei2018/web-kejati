<?php

/**
 * Deploy Hook
 *
 * Called automatically by GitHub Actions after FTP upload.
 * Runs artisan commands that cannot be done via FTP alone:
 *  - database migrations
 *  - cache clearing & warming
 *  - storage symlink creation
 *
 * Protected by a secret token set in DEPLOY_HOOK_TOKEN GitHub secret
 * and DEPLOY_HOOK_TOKEN in the server .env file.
 *
 * URL: https://yourdomain.com/deploy-hook?token=YOUR_SECRET_TOKEN
 *
 * IMPORTANT: Set DEPLOY_HOOK_TOKEN in your .env to a long random string.
 * Generate one with: php -r "echo bin2hex(random_bytes(32));"
 */

// ── Bootstrap Laravel ─────────────────────────────────────────────────
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// ── Token validation ──────────────────────────────────────────────────
$expectedToken = env('DEPLOY_HOOK_TOKEN');

if (empty($expectedToken)) {
    http_response_code(500);
    die(json_encode(['error' => 'DEPLOY_HOOK_TOKEN not set in .env']));
}

$providedToken = $_GET['token'] ?? $_SERVER['HTTP_X_DEPLOY_TOKEN'] ?? '';

if (!hash_equals($expectedToken, $providedToken)) {
    http_response_code(403);
    die(json_encode(['error' => 'Invalid token']));
}

// ── Run artisan commands ──────────────────────────────────────────────
header('Content-Type: application/json');

$results = [];
$hasError = false;

$commands = [
    'migrate'        => 'migrate --force',
    'cache:clear'    => 'cache:clear',
    'config:cache'   => 'config:cache',
    'route:cache'    => 'route:cache',
    'view:cache'     => 'view:cache',
    'storage:link'   => 'storage:link',
    'icons:cache'    => 'icons:cache',
];

$artisan = __DIR__ . '/../artisan';

foreach ($commands as $label => $command) {
    $output = [];
    $exitCode = 0;

    exec(
        PHP_BINARY . ' ' . escapeshellarg($artisan) . ' ' . $command . ' 2>&1',
        $output,
        $exitCode
    );

    $results[$label] = [
        'exit_code' => $exitCode,
        'output'    => implode("\n", $output),
        'status'    => $exitCode === 0 ? 'ok' : 'error',
    ];

    if ($exitCode !== 0) {
        $hasError = true;
    }
}

http_response_code($hasError ? 500 : 200);

echo json_encode([
    'deployed_at' => date('Y-m-d H:i:s T'),
    'status'      => $hasError ? 'completed_with_errors' : 'success',
    'commands'    => $results,
], JSON_PRETTY_PRINT);
