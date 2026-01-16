<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$u = App\Models\User::where('email', 'yogaodiy3334@gmail.com')->first();
if ($u) {
    $pending = App\Models\Deposit::where('user_id', $u->id)->where('status', 'pending')->get();
    echo "COUNT: " . $pending->count() . "\n";
    foreach ($pending as $d) {
        echo "DEP_NUM: " . $d->deposit_number . " AMT: " . $d->amount . "\n";
    }
} else {
    echo "USER NOT FOUND\n";
}
