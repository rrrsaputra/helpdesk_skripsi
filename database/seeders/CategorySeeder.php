<?php

namespace Database\Seeders;

use App\Models\ArticleCategory;
use App\Models\Category;
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
    }
}
