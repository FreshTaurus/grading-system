<?php
// Supabase PostgreSQL Connection using PDO 'connect.php'
// Get database credentials from environment variables (for Render) or use defaults for local

$db_host = getenv('DB_HOST') ?: 'localhost';
$db_port = getenv('DB_PORT') ?: '5432';
$db_name = getenv('DB_NAME') ?: 'postgres';
$db_user = getenv('DB_USER') ?: 'postgres';
$db_password = getenv('DB_PASSWORD') ?: '';

// For Supabase, parse DATABASE_URL if provided
$db_connection_string = getenv('DATABASE_URL');
if ($db_connection_string) {
    // Parse connection string (format: postgresql://user:password@host:port/dbname)
    // Handle both postgresql:// and pgsql:// formats
    $db_connection_string = str_replace('postgresql://', 'pgsql://', $db_connection_string);
    
    // Parse the connection string
    $parsed = parse_url($db_connection_string);
    
    if ($parsed) {
        $db_host = $parsed['host'] ?? 'localhost';
        $db_port = $parsed['port'] ?? '5432';
        $db_name = ltrim($parsed['path'] ?? '/postgres', '/');
        $db_user = $parsed['user'] ?? 'postgres';
        $db_password = $parsed['pass'] ?? '';
    }
}

// Build PDO connection string
$dsn = "pgsql:host=$db_host;port=$db_port;dbname=$db_name";

try {
    $conn = new PDO($dsn, $db_user, $db_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

