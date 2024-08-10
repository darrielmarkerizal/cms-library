<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Science Fiction',
            'Fantasy',
            'Mystery',
            'Thriller',
            'Romance',
            'Historical Fiction',
            'Biography',
            'Self-Help',
            'Health & Wellness',
            'Cookbooks',
            'Travel',
            'Young Adult',
            'Children\'s Books',
            'Horror',
            'Classics',
            'Poetry',
            'Non-Fiction',
            'Philosophy',
            'Science',
            'Religion & Spirituality'
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category,
            ]);
        }
    }
}
