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
     
     // Get user ID
     $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
     $stmt->execute(['yogaodiy3334@gmail.com']);
     $u = $stmt->fetch();
     
     if ($u) {
         $stmt = $pdo->prepare("SELECT deposit_number, amount, status, created_at FROM deposits WHERE user_id = ? ORDER BY created_at DESC LIMIT 5");
         $stmt->execute([$u['id']]);
         $deps = $stmt->fetchAll();
         echo json_encode($deps, JSON_PRETTY_PRINT);
     } else {
         echo "User not found";
     }
} catch (\PDOException $e) {
     echo "DB_ERROR: " . $e->getMessage() . "\n";
}
