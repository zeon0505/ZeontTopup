<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$u = App\Models\User::where('email', 'yogaodiy3334@gmail.com')->first();
if ($u) {
    echo "Clearing deposits for " . $u->email . "...\n";
    $count = App\Models\Deposit::where('user_id', $u->id)
        ->where('status', 'pending')
        ->update(['status' => 'failed']);
    echo "Marked $count deposits as failed.\n";
} else {
    echo "User not found.\n";
}
