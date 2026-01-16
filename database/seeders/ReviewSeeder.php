<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;
use App\Models\Game;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('is_admin', false)->get();
        $games = Game::all();

        if ($users->isEmpty() || $games->isEmpty()) {
            return;
        }

        $comments = [
            5 => [
                'Top up cepat banget! Recommended!',
                'Pelayanan sangat memuaskan, diamonds masuk dalam 1 menit',
                'Harga murah, proses cepat, mantap!',
                'Sudah langganan top up disini, gak pernah kecewa',
                'Best top up service! 5 stars!',
            ],
            4 => [
                'Bagus sih, cuma agak lama dikit prosesnya',
                'Overall good, harga kompetitif',
                'Recommended, walaupun kadang customer service slow respon',
                'Top up lancar, cuma antrian lama dikit',
            ],
            3 => [
                'Lumayan, tapi pernah delay 30 menit',
                'Oke lah untuk harga segini',
                'Biasa aja, standar',
            ],
            2 => [
                'Agak kecewa, prosesnya lama banget',
                'CS kurang responsif',
            ],
            1 => [
                'Kecewa, top up gak masuk-masuk',
                'Pelayanan buruk',
            ],
        ];

        // Create reviews for each game
        foreach ($games as $game) {
            $reviewCount = rand(5, 15); // Each game gets 5-15 reviews
            
            for ($i = 0; $i < $reviewCount; $i++) {
                // Random rating weighted towards higher ratings
                $rand = rand(1, 100);
                if ($rand <= 60) {
                    $rating = 5;
                } elseif ($rand <= 85) {
                    $rating = 4;
                } elseif ($rand <= 95) {
                    $rating = 3;
                } elseif ($rand <= 98) {
                    $rating = 2;
                } else {
                    $rating = 1;
                }

                $user = $users->random();
                
                // Check if user already reviewed this game
                $existingReview = Review::where('user_id', $user->id)
                    ->where('game_id', $game->id)
                    ->first();
                
                if ($existingReview) {
                    continue; // Skip if already reviewed
                }

                Review::create([
                    'user_id' => $user->id,
                    'game_id' => $game->id,
                    'rating' => $rating,
                    'comment' => $comments[$rating][array_rand($comments[$rating])],
                    'is_approved' => true,
                    'helpful_count' => rand(0, 20),
                    'created_at' => now()->subDays(rand(0, 60)),
                ]);
            }
        }
    }
}
