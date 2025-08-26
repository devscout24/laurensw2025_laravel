<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomeBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('home_banners')->insert([
            'header'                => 'Welcome to Our Travel World',
            'title'                 => 'Explore the most beautiful destinations with comfort and joy',
            'image'                 => 'backend/images/homeBanner', // make sure this exists
            'experience'            => 10,
            'happy_travelers'       => 5000,
            'number_of_destination' => 150,
            'created_at'            => now(),
            'updated_at'            => now(),
        ]);
    }
}
