<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Deposit;
use App\Models\User;

$deposits = Deposit::latest()->take(5)->get();
echo "--- LATEST DEPOSITS ---\n";
foreach ($deposits as $d) {
    echo "ID: {$d->id}, Number: {$d->deposit_number}, Status: {$d->status}, Amount: {$d->amount}, User: {$d->user_id}\n";
}

$user = User::latest()->first();
if ($user) {
    echo "\n--- LATEST USER ---\n";
    echo "ID: {$user->id}, Name: {$user->name}, Balance: {$user->balance}\n";
}
