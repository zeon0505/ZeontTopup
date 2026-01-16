<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\PaymentService;

try {
    $service = new PaymentService();
    $service->checkStatus('DEP-PLWVSHCIAF');
} catch (\Exception $e) {
    // Print only the last 100 chars of the message to fit in buffer
    $msg = $e->getMessage();
    echo "ERR: " . substr($msg, -200); 
}
