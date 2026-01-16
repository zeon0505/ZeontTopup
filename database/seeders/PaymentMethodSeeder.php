<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        $paymentMethods = [
            // E-Wallets
            [
                'code' => 'gopay',
                'name' => 'GoPay',
                'category' => 'E-Wallet',
                'icon' => 'gopay.png',
                'fee' => 0,
                'description' => 'Bayar dengan GoPay, mudah dan cepat!',
                'is_active' => true,
            ],
            [
                'code' => 'shopeepay',
                'name' => 'ShopeePay',
                'category' => 'E-Wallet',
                'icon' => 'shopeepay.png',
                'fee' => 0,
                'description' => 'Bayar dengan ShopeePay, dapatkan cashback!',
                'is_active' => true,
            ],
            [
                'code' => 'ovo',
                'name' => 'OVO',
                'category' => 'E-Wallet',
                'icon' => 'ovo.png',
                'fee' => 0,
                'description' => 'Bayar dengan OVO Points',
                'is_active' => true,
            ],
            [
                'code' => 'dana',
                'name' => 'DANA',
                'category' => 'E-Wallet',
                'icon' => 'dana.png',
                'fee' => 0,
                'description' => 'Bayar pakai DANA, aman terpercaya',
                'is_active' => true,
            ],

            // QRIS
            [
                'code' => 'qris',
                'name' => 'QRIS',
                'category' => 'QRIS',
                'icon' => 'qris.png',
                'fee' => 0,
                'description' => 'Scan QRIS untuk bayar cepat',
                'is_active' => true,
            ],

            // Bank Virtual Account
            [
                'code' => 'bca_va',
                'name' => 'BCA Virtual Account',
                'category' => 'Bank Transfer',
                'icon' => 'bca.png',
                'fee' => 4000,
                'description' => 'Transfer via BCA Virtual Account',
                'is_active' => true,
            ],
            [
                'code' => 'bni_va',
                'name' => 'BNI Virtual Account',
                'category' => 'Bank Transfer',
                'icon' => 'bni.png',
                'fee' => 4000,
                'description' => 'Transfer via BNI Virtual Account',
                'is_active' => true,
            ],
            [
                'code' => 'bri_va',
                'name' => 'BRI Virtual Account',
                'category' => 'Bank Transfer',
                'icon' => 'bri.png',
                'fee' => 4000,
                'description' => 'Transfer via BRI Virtual Account',
                'is_active' => true,
            ],
            [
                'code' => 'mandiri_va',
                'name' => 'Mandiri Virtual Account',
                'category' => 'Bank Transfer',
                'icon' => 'mandiri.png',
                'fee' => 4000,
                'description' => 'Transfer via Mandiri Bill Payment',
                'is_active' => true,
            ],
            [
                'code' => 'permata_va',
                'name' => 'Permata Virtual Account',
                'category' => 'Bank Transfer',
                'icon' => 'permata.png',
                'fee' => 4000,
                'description' => 'Transfer via Permata Virtual Account',
                'is_active' => true,
            ],

            // Retail
            [
                'code' => 'alfamart',
                'name' => 'Alfamart',
                'category' => 'Retail',
                'icon' => 'alfamart.png',
                'fee' => 2500,
                'description' => 'Bayar di Alfamart terdekat',
                'is_active' => true,
            ],
            [
                'code' => 'indomaret',
                'name' => 'Indomaret',
                'category' => 'Retail',
                'icon' => 'indomaret.png',
                'fee' => 2500,
                'description' => 'Bayar di Indomaret terdekat',
                'is_active' => true,
            ],
        ];

        foreach ($paymentMethods as $method) {
            PaymentMethod::create($method);
        }
    }
}
