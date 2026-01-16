<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $news = [
            [
                'title' => 'Rayakan Akhir Tahun dengan Bonus Top-up 20%!',
                'content' => 'Sambut tahun baru dengan semangat baru! Dapatkan bonus saldo 20% untuk setiap top-up kelipatan Rp 100.000 selama periode 25 - 31 Desember 2025. Jangan sampai ketinggalan!',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'title' => 'Tournament Mobile Legends Season 30 Segera Dimulai',
                'content' => 'Siapkan tim terbaikmu! Pendaftaran Tournament MLBB ZeonGame Season 30 resmi dibuka hari ini. Total hadiah jutaan rupiah dan diamond menantimu. Cek syarat dan ketentuannya di halaman event.',
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'title' => 'Update Sistem: Fitur Level & Hadiah Saldo XP',
                'content' => 'Kabar gembira! Sekarang setiap aktivitasmu di ZeonGame akan mendapatkan XP. Kumpulkan XP untuk naik level dan dapatkan hadiah saldo Rp 1.000 untuk setiap kenaikan level. Makin sering top-up, makin tinggi levelmu!',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'title' => 'Tips Aman Top-up Game Online di ZeonGame',
                'content' => 'Keamanan akun adalah prioritas kami. Pastikan bapak selalu menggunakan link resmi ZeonGame dan tidak memberikan password atau PIN kepada siapapun. Gunakan fitur Security PIN untuk proteksi ekstra.',
                'is_featured' => false,
                'is_active' => true,
            ],
        ];

        foreach ($news as $item) {
            News::create([
                'title' => $item['title'],
                'slug' => Str::slug($item['title']),
                'content' => $item['content'],
                'is_featured' => $item['is_featured'],
                'is_active' => $item['is_active'],
            ]);
        }
    }
}
