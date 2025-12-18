<?php
declare(strict_types=1);

function tayarti_db_config(): array
{
    $databaseUrl = getenv('DATABASE_URL') ?: getenv('MYSQL_URL') ?: getenv('JAWSDB_URL') ?: '';
    if (is_string($databaseUrl) && $databaseUrl !== '') {
        $parsed = parse_url($databaseUrl);
        if (is_array($parsed) && isset($parsed['scheme']) && in_array($parsed['scheme'], ['mysql', 'mariadb'], true)) {
            $dbName = isset($parsed['path']) ? ltrim($parsed['path'], '/') : '';
            return [
                'host' => $parsed['host'] ?? '127.0.0.1',
                'port' => isset($parsed['port']) ? (int) $parsed['port'] : 3306,
                'user' => $parsed['user'] ?? 'root',
                'pass' => $parsed['pass'] ?? '',
                'name' => $dbName !== '' ? $dbName : 'tayarti',
            ];
        }
    }

    return [
        'host' => getenv('DB_HOST') ?: getenv('MYSQL_HOST') ?: '127.0.0.1',
        'port' => (int) (getenv('DB_PORT') ?: getenv('MYSQL_PORT') ?: '3306'),
        'user' => getenv('DB_USER') ?: getenv('MYSQL_USER') ?: 'root',
        'pass' => getenv('DB_PASS') ?: getenv('MYSQL_PASSWORD') ?: '',
        'name' => getenv('DB_NAME') ?: getenv('MYSQL_DATABASE') ?: 'tayarti',
    ];
}

function tayarti_db(): mysqli
{
    static $conn = null;
    if ($conn instanceof mysqli) {
        return $conn;
    }

    $cfg = tayarti_db_config();

    $conn = new mysqli(
        $cfg['host'],
        $cfg['user'],
        $cfg['pass'],
        $cfg['name'],
        (int) $cfg['port'],
    );

    if ($conn->connect_error) {
        $hostPort = $cfg['host'] . ':' . $cfg['port'];
        die("Database connection failed to {$hostPort} (db={$cfg['name']}).");
    }

    $conn->set_charset('utf8mb4');
    return $conn;
}

// Backwards compatibility for any code that expects `$conn` after include().
$conn = tayarti_db();
