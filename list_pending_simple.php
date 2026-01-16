<?php
$host = '127.0.0.1';
$db   = 'web_top_up';
$user = 'root';
$pass = 'root';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
     $stmt = $pdo->query("SELECT deposit_number FROM deposits WHERE status = 'pending'");
     $deps = $stmt->fetchAll();
     foreach ($deps as $d) {
         echo $d['deposit_number'] . "\n";
     }
} catch (\PDOException $e) {
     echo "DB_ERROR: " . $e->getMessage() . "\n";
}
