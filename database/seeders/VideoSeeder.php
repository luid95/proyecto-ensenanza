<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Video;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Video::create([
            'title' => 'Introducción a las Fracciones',
            'url' => 'https://www.youtube.com/watch?v=example',
            'course_id' => 1,
            //'category_id' => 1,
        ]);
    }
}
