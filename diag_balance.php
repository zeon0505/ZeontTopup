<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$d = App\Models\Deposit::latest()->first();
if ($d) {
    echo "DEPOSIT_STATUS: " . $d->status . "\n";
    echo "DEPOSIT_AMOUNT: " . $d->amount . "\n";
    echo "USER_BALANCE: " . $d->user->balance . "\n";
    echo "USER_ID: " . $d->user->id . "\n";
} else {
    echo "NO DEPOSIT FOUND\n";
}
