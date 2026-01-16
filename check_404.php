<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\PaymentService;

try {
    $service = new PaymentService();
    $service->checkStatus('DEP-PLWVSHCIAF');
    echo "STATUS: FOUND\n";
} catch (\Exception $e) {
    if (strpos($e->getMessage(), '404') !== false) {
        echo "STATUS: 404_NOT_FOUND\n";
    } else {
        echo "STATUS: OTHER_ERROR\n";
    }
}
