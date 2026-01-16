<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FlashSale;
use App\Models\Product;
use App\Models\Game;
use Carbon\Carbon;

class FlashSaleSeeder extends Seeder
{
    public function run(): void
    {
        // Get some products for flash sales
        $mlGame = Game::where('slug', 'mobile-legends')->first();
        $ffGame = Game::where('slug', 'free-fire')->first();
        $pubgGame = Game::where('slug', 'pubg-mobile')->first();
        
        if ($mlGame) {
            $mlProducts = Product::where('game_id', $mlGame->id)->get();
            if ($mlProducts->count() >= 2) {
                // Flash Sale 1: Mobile Legends 100 Diamonds (30% off)
                FlashSale::create([
                    'product_id' => $mlProducts[1]->id, // 100 Diamonds
                    'discount_price' => 19600, // Original: 28000
                    'start_time' => Carbon::now()->subHours(2),
                    'end_time' => Carbon::now()->addHours(22),
                    'is_active' => true,
                ]);

                // Flash Sale 2: Mobile Legends 500 Diamonds (25% off)
                FlashSale::create([
                    'product_id' => $mlProducts[3]->id, // 500 Diamonds
                    'discount_price' => 105000, // Original: 140000
                    'start_time' => Carbon::now()->subHours(1),
                    'end_time' => Carbon::now()->addHours(47),
                    'is_active' => true,
                ]);
            }
        }

        if ($ffGame) {
            $ffProducts = Product::where('game_id', $ffGame->id)->get();
            if ($ffProducts->count() >= 3) {
                // Flash Sale 3: Free Fire 200 Diamonds (35% off)
                FlashSale::create([
                    'product_id' => $ffProducts[2]->id, // 200 Diamonds
                    'discount_price' => 18200, // Original: 28000
                    'start_time' => Carbon::now()->subHours(3),
                    'end_time' => Carbon::now()->addHours(21),
                    'is_active' => true,
                ]);
            }
        }

        if ($pubgGame) {
            $pubgProducts = Product::where('game_id', $pubgGame->id)->get();
            if ($pubgProducts->count() >= 2) {
                // Flash Sale 4: PUBG 120 UC (20% off)
                FlashSale::create([
                    'product_id' => $pubgProducts[1]->id, // 120 UC
                    'discount_price' => 22400, // Original: 28000
                    'start_time' => Carbon::now()->addHours(2),
                    'end_time' => Carbon::now()->addHours(50),
                    'is_active' => true,
                ]);
            }
        }
    }
}
