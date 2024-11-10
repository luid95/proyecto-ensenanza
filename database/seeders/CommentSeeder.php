<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Comment::create([
            'user_id' => 2,
            'video_id' => 1,
            'content' => 'Excelente video de introducción a las fracciones!',
            'approved' => true
        ]);
    }
}
