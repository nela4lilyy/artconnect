<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $galleries = [
            [
                'title'       => 'Pameran Lukisan Abstrak 2024',
                'description' => 'Koleksi lukisan abstrak karya seniman-seniman berbakat dari komunitas ArtConnect. Setiap karya mengekspresikan emosi dan gagasan melalui warna, bentuk, dan tekstur yang unik.',
            ],
            [
                'title'       => 'Fotografi Arsitektur Kota',
                'description' => 'Kumpulan foto arsitektur kota yang menampilkan keindahan dan keunikan bangunan-bangunan bersejarah serta modern di berbagai kota di Indonesia.',
            ],
            [
                'title'       => 'Karya Patung Komunitas',
                'description' => 'Dokumentasi karya patung tiga dimensi dari para anggota komunitas. Berbagai material digunakan mulai dari kayu, batu, logam, hingga material daur ulang.',
            ],
            [
                'title'       => 'Kerajinan Batik Nusantara',
                'description' => 'Koleksi foto karya batik tulis dan cap dari berbagai daerah di Indonesia yang memperlihatkan kekayaan motif dan corak batik sebagai warisan budaya bangsa.',
            ],
            [
                'title'       => 'Workshop Desain Grafis 2024',
                'description' => 'Dokumentasi kegiatan workshop desain grafis yang diadakan komunitas ArtConnect, menampilkan proses kreatif dan hasil karya para peserta.',
            ],
            [
                'title'       => 'Festival Seni Tari Nusantara',
                'description' => 'Dokumentasi pertunjukan tari tradisional dari berbagai daerah Indonesia dalam festival seni tari tahunan komunitas ArtConnect.',
            ],
        ];

        foreach ($galleries as $data) {
            Gallery::firstOrCreate(
                ['title' => $data['title']],
                [
                    'description' => $data['description'],
                    'cover_image' => null,
                ]
            );
        }
    }
}
