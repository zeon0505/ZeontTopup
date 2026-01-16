<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\PaymentService;

$service = new PaymentService();

// We will replace this with the actual Order ID from the previous step
$orderId = $argv[1] ?? 'DEP-XXXXX'; 

if ($orderId === 'DEP-XXXXX') {
    echo "Please provide an Order ID/Deposit Number as argument.\n";
    exit;
}

echo "Checking status for: $orderId\n";

try {
    $status = $service->checkStatus($orderId);
    print_r($status);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
