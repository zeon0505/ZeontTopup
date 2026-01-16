<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\PaymentService;

echo "Checking Midtrans Config...\n";
echo "Server Key: " . substr(config('services.midtrans.server_key'), 0, 5) . "...\n";
echo "Production: " . (config('services.midtrans.is_production') ? 'YES' : 'NO') . "\n";

$service = new PaymentService();
$orderId = 'DEP-PLWVSHCIAF'; 

echo "Checking status for: $orderId\n";

try {
    $status = $service->checkStatus($orderId);
    echo "MIDTRANS_STATUS_CODE: " . $status->status_code . "\n";
    echo "MIDTRANS_TX_STATUS: " . $status->transaction_status . "\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
