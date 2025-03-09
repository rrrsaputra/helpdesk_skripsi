<?php

namespace Database\Seeders;

use App\Models\StudyProgram;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StudyProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $studyPrograms = [
            ['name' => 'Akuntansi'],
            ['name' => 'Ilmu Politik'],
            ['name' => 'Manajemen'],
            ['name' => 'Ilmu Komunikasi'],
            ['name' => 'Sistem Informasi'],
            ['name' => 'Informatika'],
            ['name' => 'Teknik Industri'],
            ['name' => 'Teknik Sipil'],
            ['name' => 'Teknik Lingkungan'],
            ['name' => 'Ilmu dan Teknologi Pangan'],
        ];

        foreach ($studyPrograms as $studyProgram) {
            StudyProgram::create($studyProgram);
        }
    }
}
