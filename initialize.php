<?php
session_start();

$envFile = __DIR__ . '/.env';

if (file_exists($envFile)) {
    $env = parse_ini_file($envFile);
} else {
    $env = [];
}

$host = getenv("DB_HOST") ?: ($env["DB_HOST"] ?? "");
$port = getenv("DB_PORT") ?: ($env["DB_PORT"] ?? "");
$user = getenv("DB_USER") ?: ($env["DB_USER"] ?? "");
$password = getenv("DB_PASSWORD") ?: ($env["DB_PASSWORD"] ?? "");
$database = getenv("DB_NAME") ?: ($env["DB_NAME"] ?? "");

$connectionString = "host=$host port=$port dbname=$database user=$user password=$password sslmode=require";

$connection = pg_connect($connectionString);

if (!$connection) {
    die("Database connection failed.");
}
?>

