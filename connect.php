<?php
// Supabase PostgreSQL Connection using PDO 'connect.php'
// Get database credentials from environment variables (for Render) or use defaults for local

$db_host = getenv('DB_HOST') ?: 'localhost';
$db_port = getenv('DB_PORT') ?: '5432';
$db_name = getenv('DB_NAME') ?: 'postgres';
$db_user = getenv('DB_USER') ?: 'postgres';
$db_password = getenv('DB_PASSWORD') ?: '';

// For Supabase, you can also use the connection string directly
$db_connection_string = getenv('DATABASE_URL');
if ($db_connection_string) {
    // Parse connection string (format: postgresql://user:password@host:port/dbname)
    // Convert postgresql:// to pgsql:// for PDO
    $db_connection_string = str_replace('postgresql://', 'pgsql://', $db_connection_string);
    try {
        $conn = new PDO($db_connection_string);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
} else {
    // Build connection string
    $dsn = "pgsql:host=$db_host;port=$db_port;dbname=$db_name";
    try {
        $conn = new PDO($dsn, $db_user, $db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}
?>

