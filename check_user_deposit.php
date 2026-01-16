<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$u = App\Models\User::where('email', 'yogaodiy3334@gmail.com')->first();
if ($u) {
    echo "USER_NAME: " . $u->name . "\n";
    echo "USER_BALANCE: " . $u->balance . "\n";
    $d = App\Models\Deposit::where('user_id', $u->id)->latest()->first();
    if ($d) {
        echo "LATEST_DEPOSIT_ID: " . $d->id . "\n";
        echo "LATEST_DEPOSIT_NUMBER: " . $d->deposit_number . "\n";
        echo "LATEST_DEPOSIT_STATUS: " . $d->status . "\n";
        echo "LATEST_DEPOSIT_AMOUNT: " . $d->amount . "\n";
        echo "LATEST_DEPOSIT_CREATED_AT: " . $d->created_at . "\n";
    } else {
        echo "NO DEPOSIT FOUND FOR USER\n";
    }
} else {
    echo "USER NOT FOUND\n";
}
