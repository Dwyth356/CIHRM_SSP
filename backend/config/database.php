<?php
declare(strict_types=1);

$envPath = dirname(__DIR__).'/.env';
if (!is_file($envPath)) {
    throw new RuntimeException('Missing backend/.env. Copy backend/.env.example and configure the database settings.');
}
$settings = parse_ini_file($envPath, false, INI_SCANNER_RAW);
if ($settings === false) {
    throw new RuntimeException('Could not read backend/.env.');
}

$environment = strtolower((string)($settings['APP_ENV'] ?? 'development'));
if (!in_array($environment, ['development', 'production'], true)) {
    throw new RuntimeException('APP_ENV must be either development or production.');
}
$host = $settings['DB_HOST'] ?? '127.0.0.1';
$port = $settings['DB_PORT'] ?? '3306';
$name = $settings['DB_NAME'] ?? 'cihrm_db';
$user = $settings['DB_USER'] ?? 'root';
$password = $settings['DB_PASSWORD'] ?? '';

if ($environment === 'production' &&
    ($host === '' || $name === '' || $user === '' || $password === '' || strtolower($user) === 'root')) {
    throw new RuntimeException(
        'Production database settings must use a dedicated database user and a non-empty password.'
    );
}

return new PDO(
    "mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4",
    $user,
    $password,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]
);
