<?php
// Supabase PostgreSQL Connection using PDO 'connect.php'
// Get database credentials from environment variables (for Render) or use defaults for local
//
// NOTE: If you get "Network is unreachable" errors, try using Supabase Connection Pooler:
// - In Supabase: Project Settings > Database > Connection Pooling
// - Use the "Transaction" mode connection string (port 6543)
// - This provides better connectivity from serverless/container environments

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

// Build PDO connection string with connection options
$dsn = "pgsql:host=$db_host;port=$db_port;dbname=$db_name;connect_timeout=10";

// Connection options
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_TIMEOUT => 10,
    PDO::ATTR_PERSISTENT => false
);

try {
    // Try to resolve hostname to IP (might help with IPv6 issues)
    $ip = gethostbyname($db_host);
    if ($ip !== $db_host) {
        // Use IP address instead of hostname
        $dsn = "pgsql:host=$ip;port=$db_port;dbname=$db_name;connect_timeout=10";
    }
    
    $conn = new PDO($dsn, $db_user, $db_password, $options);
} catch(PDOException $e) {
    // More detailed error message
    $error_msg = "Connection failed: " . $e->getMessage();
    $error_msg .= "\n\nTroubleshooting:";
    $error_msg .= "\n- Check if DATABASE_URL is set correctly";
    $error_msg .= "\n- Verify Supabase project is active";
    $error_msg .= "\n- Check network connectivity from Render to Supabase";
    $error_msg .= "\n- Ensure Supabase allows connections from Render's IP addresses";
    die($error_msg);
}
?>

