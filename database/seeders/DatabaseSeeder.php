<?php

namespace Database\Seeders;

//use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            CategorySeeder::class,
            CourseSeeder::class,
            VideoSeeder::class,
            UserSeeder::class,
            CommentSeeder::class,
            LikeSeeder::class,
        ]);
    }
}
