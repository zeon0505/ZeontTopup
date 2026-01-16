<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Game;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $games = Game::all();

        foreach ($games as $game) {
            $products = $this->getProductsForGame($game->name);
            
            foreach ($products as $productData) {
                Product::create([
                    'game_id' => $game->id,
                    'name' => $productData['name'],
                    'description' => $productData['description'],
                    'price' => $productData['price'],
                    'quantity' => 999,
                    'is_active' => true,
                    'sort_order' => 0,
                ]);
            }
        }
    }

    private function getProductsForGame($gameName)
    {
        $products = [
            'Mobile Legends' => [
                ['name' => '50 Diamonds', 'description' => '50 Diamonds Mobile Legends', 'price' => 15000],
                ['name' => '100 Diamonds', 'description' => '100 Diamonds Mobile Legends', 'price' => 28000],
                ['name' => '250 Diamonds', 'description' => '250 Diamonds Mobile Legends', 'price' => 70000],
                ['name' => '500 Diamonds', 'description' => '500 Diamonds Mobile Legends', 'price' => 140000],
                ['name' => '1000 Diamonds', 'description' => '1000 Diamonds Mobile Legends', 'price' => 270000],
                ['name' => '2000 Diamonds', 'description' => '2000 Diamonds Mobile Legends', 'price' => 540000],
            ],
            'Free Fire' => [
                ['name' => '50 Diamonds', 'description' => '50 Diamonds Free Fire', 'price' => 8000],
                ['name' => '100 Diamonds', 'description' => '100 Diamonds Free Fire', 'price' => 15000],
                ['name' => '200 Diamonds', 'description' => '200 Diamonds Free Fire', 'price' => 28000],
                ['name' => '500 Diamonds', 'description' => '500 Diamonds Free Fire', 'price' => 70000],
                ['name' => '1000 Diamonds', 'description' => '1000 Diamonds Free Fire', 'price' => 140000],
            ],
            'PUBG Mobile' => [
                ['name' => '60 UC', 'description' => '60 UC PUBG Mobile', 'price' => 15000],
                ['name' => '120 UC', 'description' => '120 UC PUBG Mobile', 'price' => 28000],
                ['name' => '300 UC', 'description' => '300 UC PUBG Mobile', 'price' => 68000],
                ['name' => '600 UC', 'description' => '600 UC PUBG Mobile', 'price' => 135000],
                ['name' => '1200 UC', 'description' => '1200 UC PUBG Mobile', 'price' => 270000],
            ],
            'Genshin Impact' => [
                ['name' => '60 Genesis Crystal', 'description' => '60 Genesis Crystal', 'price' => 16000],
                ['name' => '120 Genesis Crystal', 'description' => '120 Genesis Crystal + 60 Bonus', 'price' => 31000],
                ['name' => '300 Genesis Crystal', 'description' => '300 Genesis Crystal + 30 Bonus', 'price' => 80000],
                ['name' => '600 Genesis Crystal', 'description' => '600 Genesis Crystal + 180 Bonus', 'price' => 160000],
                ['name' => '1200 Genesis Crystal', 'description' => '1200 Genesis Crystal + 600 Bonus', 'price' => 315000],
            ],
            'Valorant' => [
                ['name' => '125 VP', 'description' => '125 Valorant Points', 'price' => 15000],
                ['name' => '420 VP', 'description' => '420 Valorant Points', 'price' => 50000],
                ['name' => '700 VP', 'description' => '700 Valorant Points', 'price' => 85000],
                ['name' => '1375 VP', 'description' => '1375 Valorant Points', 'price' => 160000],
                ['name' => '2150 VP', 'description' => '2150 Valorant Points', 'price' => 250000],
            ],
        ];

        // Default products for games not listed above
        $defaultProducts = [
            ['name' => 'Small Package', 'description' => 'Small in-game currency package', 'price' => 15000],
            ['name' => 'Medium Package', 'description' => 'Medium in-game currency package', 'price' => 50000],
            ['name' => 'Large Package', 'description' => 'Large in-game currency package', 'price' => 100000],
            ['name' => 'Mega Package', 'description' => 'Mega in-game currency package', 'price' => 250000],
        ];

        return $products[$gameName] ?? $defaultProducts;
    }
}
