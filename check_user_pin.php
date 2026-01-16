<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$u = App\Models\User::where('email', 'yogaodiy3334@gmail.com')->first();
if ($u) {
    echo "USER_FOUND=YES\n";
    echo "EMAIL=" . $u->email . "\n";
    echo "IS_ADMIN=" . ($u->is_admin ? 'YES' : 'NO') . "\n";
    echo "HAS_PIN=" . (empty($u->security_pin) ? 'NO' : 'YES') . "\n";
    echo "PIN_VALUE=" . $u->security_pin . "\n";
} else {
    echo "USER_FOUND=NO\n";
}
