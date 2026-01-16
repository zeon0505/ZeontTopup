<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Achievement;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $achievements = [
            [
                'name' => 'Selamat Datang Member! 🎁',
                'slug' => 'welcome-member',
                'description' => 'Berhasil melakukan top up pertama kali.',
                'icon' => 'fas fa-gift',
                'type' => 'topup_count',
                'threshold' => 1,
                'reward_points' => 100,
            ],
            [
                'name' => 'Sultan Zeon 💎',
                'slug' => 'sultan-zeon',
                'description' => 'Total belanja mencapai Rp 1.000.000.',
                'icon' => 'fas fa-crown',
                'type' => 'spending_total',
                'threshold' => 1000000,
                'reward_points' => 1000,
            ],
            [
                'name' => 'Zeon Loyalist 🔥',
                'slug' => 'zeon-loyalist',
                'description' => 'Berhasil absen selama 7 hari berturut-turut.',
                'icon' => 'fas fa-fire',
                'type' => 'streak_days',
                'threshold' => 7,
                'reward_points' => 500,
            ],
            [
                'name' => 'Veteran Gamer 🎮',
                'slug' => 'veteran-gamer',
                'description' => 'Menyelesaikan 10 pesanan di ZeonGame.',
                'icon' => 'fas fa-gamepad',
                'type' => 'order_count',
                'threshold' => 10,
                'reward_points' => 500,
            ],
        ];

        foreach ($achievements as $data) {
            Achievement::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
