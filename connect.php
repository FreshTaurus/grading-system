<?php
// Supabase PostgreSQL Connection 'connect.php'
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
    $conn = pg_connect($db_connection_string);
} else {
    // Build connection string
    $conn_string = "host=$db_host port=$db_port dbname=$db_name user=$db_user password=$db_password";
    $conn = pg_connect($conn_string);
}

// Check connection
if (!$conn) {
    die("Connection failed: " . pg_last_error());
}
?>

