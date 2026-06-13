<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@artconnect.com')->first();
        $categories = Category::all();

        $newsData = [
            [
                'title'   => 'Festival Seni Lukis Nasional 2024 Resmi Dibuka',
                'content' => 'Festival Seni Lukis Nasional 2024 telah resmi dibuka di Taman Ismail Marzuki, Jakarta. Acara ini dihadiri oleh ratusan seniman dari seluruh penjuru Indonesia. Pameran ini menampilkan lebih dari 200 karya seni lukis kontemporer yang memukau. Para pengunjung dapat menikmati keindahan setiap karya sambil berinteraksi langsung dengan para seniman. Festival ini bertujuan untuk mempromosikan seni lukis sebagai warisan budaya bangsa dan mendorong generasi muda untuk mencintai dunia seni.',
                'category' => 'Seni Lukis',
            ],
            [
                'title'   => 'Workshop Fotografi Jalanan untuk Pemula',
                'content' => 'Komunitas ArtConnect mengadakan workshop fotografi jalanan yang terbuka untuk semua kalangan, terutama pemula yang ingin belajar teknik dasar fotografi. Workshop ini akan dipandu oleh fotografer profesional berpengalaman. Peserta akan diajarkan tentang komposisi, pencahayaan, dan cara mengabadikan momen kehidupan sehari-hari menjadi karya fotografi yang bercerita. Pendaftaran dibuka mulai hari ini hingga akhir bulan.',
                'category' => 'Seni Fotografi',
            ],
            [
                'title'   => 'Pameran Patung Kontemporer di Galeri Nasional',
                'content' => 'Galeri Nasional Indonesia menyelenggarakan pameran patung kontemporer bertajuk "Dimensi Baru" yang menampilkan karya-karya terbaik seniman patung Indonesia. Pameran ini menghadirkan karya tiga dimensi yang memadukan material tradisional dengan teknik modern. Setiap karya patung mencerminkan eksplorasi mendalam tentang identitas budaya dan perspektif kehidupan modern. Pameran berlangsung selama satu bulan penuh.',
                'category' => 'Seni Patung',
            ],
            [
                'title'   => 'Konser Musik Etnik Nusantara Malam Ini',
                'content' => 'Malam ini akan digelar konser musik etnik Nusantara yang menampilkan kolaborasi indah antara musisi dari berbagai daerah di Indonesia. Konser ini menggabungkan instrumen tradisional seperti gamelan, angklung, kolintang, dan sasando dalam satu harmoni yang memukau. Acara ini merupakan bagian dari program pelestarian budaya musik tradisional Indonesia yang diadakan setiap bulan oleh komunitas ArtConnect.',
                'category' => 'Seni Musik',
            ],
            [
                'title'   => 'Kelas Desain Grafis Digital Batch Baru Dibuka',
                'content' => 'ArtConnect membuka kelas desain grafis digital untuk batch baru. Program ini dirancang untuk mengajarkan teknik-teknik desain grafis modern menggunakan perangkat lunak terkini. Peserta akan belajar dari dasar hingga mahir dalam menciptakan desain yang profesional dan kreatif. Pengajar berpengalaman di industri akan membimbing setiap peserta. Kelas terbatas hanya 20 orang per batch untuk memastikan kualitas pembelajaran.',
                'category' => 'Desain Grafis',
            ],
            [
                'title'   => 'Pertunjukan Tari Tradisional Meriahkan HUT Kemerdekaan',
                'content' => 'Dalam rangka memperingati Hari Ulang Tahun Kemerdekaan Republik Indonesia, komunitas seni tari ArtConnect menampilkan pertunjukan tari tradisional yang megah. Berbagai tarian daerah dari Sabang sampai Merauke ditampilkan dengan kostum dan musik yang autentik. Pertunjukan ini melibatkan lebih dari 100 penari dari berbagai usia, menunjukkan bahwa seni tari tradisional tetap hidup dan dicintai oleh generasi muda.',
                'category' => 'Seni Tari',
            ],
            [
                'title'   => 'Teknik Dasar Membuat Kerajinan Batik Tulis',
                'content' => 'Tutorial pembuatan batik tulis tradisional kini hadir dalam format workshop intensif dua hari. Peserta akan belajar langsung dari pengrajin batik berusia ratusan tahun asal Yogyakarta. Mulai dari pemilihan kain, pembuatan pola, proses pencantingan, hingga pewarnaan dengan bahan alami, semua akan diajarkan secara mendetail. Batik sebagai warisan budaya UNESCO menjadi kebanggaan yang harus terus dilestarikan.',
                'category' => 'Kerajinan Tangan',
            ],
            [
                'title'   => 'Teater Kolosal "Bumi Pertiwi" Sukses Digelar',
                'content' => 'Pertunjukan teater kolosal berjudul "Bumi Pertiwi" yang dipentaskan oleh Komunitas Teater ArtConnect menuai pujian dari para penonton dan kritikus seni. Drama yang mengangkat tema perjuangan dan cinta tanah air ini dimainkan oleh 50 aktor berbakat. Sutradara menggabungkan elemen teater modern dengan tradisi pertunjukan wayang dalam sebuah harmoni yang memukau. Pertunjukan akan diulang pada akhir pekan mendatang.',
                'category' => 'Seni Teater',
            ],
        ];

        foreach ($newsData as $index => $data) {
            $category = $categories->where('name', $data['category'])->first()
                ?? $categories->first();

            $slug = Str::slug($data['title']);

            News::firstOrCreate(
                ['slug' => $slug],
                [
                    'user_id'      => $admin->id,
                    'category_id'  => $category->id,
                    'title'        => $data['title'],
                    'slug'         => $slug,
                    'content'      => $data['content'],
                    'image'        => null,
                    'publish_date' => now()->subDays($index * 3)->format('Y-m-d'),
                ]
            );
        }
    }
}
