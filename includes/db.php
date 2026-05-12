<?php
$host = 'localhost';
$db   = 'dulceria_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     // For development, we'll keep it simple. In production, log error and show friendly message.
     error_log($e->getMessage());
     // We continue without DB to show the UI even if DB is not set up
     $pdo = null;
}
?>
