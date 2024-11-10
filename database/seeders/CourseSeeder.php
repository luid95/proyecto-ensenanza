<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Course::create([
            'title' => 'Curso de Matemáticas Básicas',
            'description' => 'Aprende los fundamentos de matemáticas.',
            'category_id' => 1,
            'age_group' => 5
        ]);
    }
}
