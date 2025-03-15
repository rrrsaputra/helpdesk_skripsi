<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\FaqCategory;
use App\Models\ArticleCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Kartu Rencana Studi', 'slug' => 'kartu-rencana-studi'],
            ['name' => 'Perkuliahan & Jadwal', 'slug' => 'perkuliahan-jadwal'],
            ['name' => 'Ujian & Nilai', 'slug' => 'ujian-nilai'],
            ['name' => 'Seminar Proposal & Yudisium', 'slug' => 'seminar-proposal-yudisium'],
            ['name' => 'Sistem Informasi Akademuk (BIG 2.0)', 'slug' => 'sistem-informasi-akademuk-big-2-0'],
            ['name' => 'Lainnya', 'slug' => 'lainnya'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $articleCategories = [
            ['name' => 'Kartu Rencana Studi', 'slug' => 'kartu-rencana-studi'],
            ['name' => 'Perkuliahan & Jadwal', 'slug' => 'perkuliahan-jadwal'],
            ['name' => 'Ujian & Nilai', 'slug' => 'ujian-nilai'],
            ['name' => 'Seminar Proposal & Yudisium', 'slug' => 'seminar-proposal-yudisium'],
            ['name' => 'Sistem Informasi Akademuk (BIG 2.0)', 'slug' => 'sistem-informasi-akademuk-big-2-0'],
            ['name' => 'Lainnya', 'slug' => 'lainnya'],
        ];

        foreach ($articleCategories as $articleCategory) {
            ArticleCategory::create($articleCategory); 
        }

        $faqCategories = [
            ['name' => 'Kartu Rencana Studi', 'slug' => 'kartu-rencana-studi', 'description' => 'Temukan jawaban dari pertanyaan seputar kartu rencana studi disini.'],
            ['name' => 'Perkuliahan & Jadwal', 'slug' => 'perkuliahan-jadwal', 'description' => 'Temukan jawaban dari pertanyaan seputar perkuliahan, jadwal kelas, dan kegiatan akademik.'],
            ['name' => 'Ujian & Nilai', 'slug' => 'ujian-nilai', 'description' => 'Temukan jawaban dari pertanyaan seputar pelaksanaan ujian, sistem penilaian, dan hasil studi.'],
            ['name' => 'Seminar Proposal & Yudisium', 'slug' => 'seminar-proposal-yudisium', 'description' => 'Temukan jawaban dari pertanyaan tentang proses seminar proposal hingga tahapan yudisium.'],
            ['name' => 'Sistem Informasi Akademuk (BIG 2.0)', 'slug' => 'sistem-informasi-akademuk-big-2-0', 'description' => 'Temukan jawaban dari pertanyaan tentang penggunaan dan fitur di sistem BIG 2.0.'],
            ['name' => 'Lainnya', 'slug' => 'lainnya', 'description' => 'Temukan jawaban dari berbagai pertanyaan lain yang tidak termasuk dalam kategori utama.'],
        ];

        foreach ($faqCategories as $faqCategory) {
            FaqCategory::create($faqCategory); 
        }
    }
}
