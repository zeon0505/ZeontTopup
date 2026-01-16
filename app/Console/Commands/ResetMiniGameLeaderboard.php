<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetMiniGameLeaderboard extends Command
{
    protected $signature = 'minigame:reset';
    protected $description = 'Find daily winner, give voucher reward, and reset leaderboard';

    public function handle()
    {
        $yesterday = now()->subDay()->toDateString();
        
        $winner = \App\Models\MiniGameScore::with('user')
            ->where('day', $yesterday)
            ->orderByDesc('score')
            ->first();

        if ($winner && $winner->user) {
            $voucherCode = 'FLAPPY-' . strtoupper(\Illuminate\Support\Str::random(10));
            
            // Create Voucher
            $voucher = \App\Models\Voucher::create([
                'code' => $voucherCode,
                'discount_type' => 'fixed',
                'amount' => 5000, // Rp 5,000 for winner
                'min_purchase' => 10000,
                'valid_from' => now(),
                'valid_until' => now()->addDays(7),
                'usage_limit' => 1,
                'is_active' => true,
            ]);

            // Notify User
            $winner->user->notify(new \App\Notifications\PlatformNotification(
                "JUARA FLAPPY BIRD! 🏆",
                "Selamat! Kamu Juara 1 kemarin dengan skor {$winner->score}. Gunakan kode voucher: {$voucherCode} (Diskon Rp 5.000)",
                "game_winner"
            ));

            $this->info("Winner processed: " . $winner->user->name . " with score " . $winner->score);
        } else {
            $this->info("No winner found for " . $yesterday);
        }

        return 0;
    }
}
