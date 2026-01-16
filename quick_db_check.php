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
     
     // Get user
     $stmt = $pdo->prepare("SELECT id, name, balance FROM users WHERE email = ?");
     $stmt->execute(['yogaodiy3334@gmail.com']);
     $u = $stmt->fetch();
     
     if ($u) {
         echo "USER_NAME: " . $u['name'] . "\n";
         echo "USER_BALANCE: " . $u['balance'] . "\n";
         
         // Get latest deposit
         $stmt = $pdo->prepare("SELECT id, deposit_number, status, amount, created_at FROM deposits WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
         $stmt->execute([$u['id']]);
         $d = $stmt->fetch();
         
         if ($d) {
             echo "LATEST_DEPOSIT_NUM: " . $d['deposit_number'] . "\n";
             echo "LATEST_DEPOSIT_STATUS: " . $d['status'] . "\n";
             echo "LATEST_DEPOSIT_AMOUNT: " . $d['amount'] . "\n";
             echo "LATEST_DEPOSIT_ID: " . $d['id'] . "\n";
         } else {
             echo "NO_DEPOSIT_FOUND\n";
         }
     } else {
         echo "USER_NOT_FOUND\n";
     }
} catch (\PDOException $e) {
     echo "DB_ERROR: " . $e->getMessage() . "\n";
}
