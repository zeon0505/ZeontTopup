<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;
use Illuminate\Support\Str;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        $games = [
            [
                'name' => 'Mobile Legends',
                'publisher' => 'Moonton',
                'slug' => 'mobile-legends',
                'description' => 'Top up Diamond Mobile Legends murah, cepat, dan terpercaya!',
                'category' => 'Specialist MLBB',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Free Fire',
                'publisher' => 'Garena',
                'slug' => 'free-fire',
                'description' => 'Top up Diamond Free Fire dengan harga terbaik!',
                'category' => 'Top Up Games',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'PUBG Mobile',
                'publisher' => 'Tencent',
                'slug' => 'pubg-mobile',
                'description' => 'Top up UC PUBG Mobile tercepat di Indonesia!',
                'category' => 'Specialist PUBGM',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Genshin Impact',
                'publisher' => 'miHoYo',
                'slug' => 'genshin-impact',
                'description' => 'Top up Genesis Crystal Genshin Impact resmi dan aman!',
                'category' => 'Top Up Games',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Valorant',
                'publisher' => 'Riot Games',
                'slug' => 'valorant',
                'description' => 'Top up Valorant Points (VP) murah dan cepat!',
                'category' => 'Top Up Games',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Arena of Valor',
                'publisher' => 'Garena',
                'slug' => 'arena-of-valor',
                'description' => 'Top up Voucher Arena of Valor terpercaya!',
                'category' => 'Top Up Games',
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'Honkai: Star Rail',
                'publisher' => 'miHoYo',
                'slug' => 'honkai-star-rail',
                'description' => 'Top up Oneiric Shard Honkai Star Rail official!',
                'category' => 'Top Up Games',
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'Call of Duty Mobile',
                'publisher' => 'Activision',
                'slug' => 'call-of-duty-mobile',
                'description' => 'Top up CP Call of Duty Mobile dengan harga murah!',
                'category' => 'Top Up Games',
                'is_active' => true,
                'sort_order' => 8,
            ],
            [
                'name' => 'Clash of Clans',
                'publisher' => 'Supercell',
                'slug' => 'clash-of-clans',
                'description' => 'Top up Gems Clash of Clans cepat dan aman!',
                'category' => 'Top Up Games',
                'is_active' => true,
                'sort_order' => 9,
            ],
            [
                'name' => 'League of Legends: Wild Rift',
                'publisher' => 'Riot Games',
                'slug' => 'wild-rift',
                'description' => 'Top up Wild Cores Wild Rift murah meriah!',
                'category' => 'Top Up Games',
                'is_active' => true,
                'sort_order' => 10,
            ],
            [
                'name' => 'Ragnarok M: Eternal Love',
                'publisher' => 'Gravity',
                'slug' => 'ragnarok-m',
                'description' => 'Top up Big Cat Coin Ragnarok M terpercaya!',
                'category' => 'Top Up Games',
                'is_active' => true,
                'sort_order' => 11,
            ],
            [
                'name' => 'Steam Wallet',
                'publisher' => 'Valve',
                'slug' => 'steam-wallet',
                'description' => 'Top up Steam Wallet Code untuk pembelian game PC!',
                'category' => 'Voucher',
                'is_active' => true,
                'sort_order' => 12,
            ],
        ];

        foreach ($games as $gameData) {
            Game::create($gameData);
        }
    }
}
