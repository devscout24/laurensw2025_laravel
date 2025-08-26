<?php

namespace Database\Seeders;

use App\Models\UniqueFeatures;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UniqueFeaturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            [
                'header'                => 'Explore the World',
                'title'                 => 'Discover new destinations with our expert guides',
                'image'                 => 'backend/images/uniqueFeatures/world.jpg',
                'experience'            => 10,
                'happy_travelers'       => 5000,
                'number_of_destination' => 150,
                'created_at'            => now(),
                'updated_at'            => now(),
            ],
            [
                'header'                => 'Luxury Stays',
                'title'                 => 'Enjoy comfort with handpicked hotels and resorts',
                'image'                 => 'backend/images/uniqueFeatures/luxury.jpg',
                'experience'            => 8,
                'happy_travelers'       => 3000,
                'number_of_destination' => 80,
                'created_at'            => now(),
                'updated_at'            => now(),
            ],
            [
                'header'                => 'Adventure Awaits',
                'title'                 => 'Thrilling adventures tailored just for you',
                'image'                 => 'backend/images/uniqueFeatures/adventure.jpg',
                'experience'            => 12,
                'happy_travelers'       => 4000,
                'number_of_destination' => 120,
                'created_at'            => now(),
                'updated_at'            => now(),
            ],
            [
                'header'                => 'Cultural Tours',
                'title'                 => 'Immerse yourself in rich history and traditions',
                'image'                 => 'backend/images/uniqueFeatures/culture.jpg',
                'experience'            => 15,
                'happy_travelers'       => 6000,
                'number_of_destination' => 90,
                'created_at'            => now(),
                'updated_at'            => now(),
            ],
            [
                'header'                => 'Family Friendly',
                'title'                 => 'Trips designed for families and children',
                'image'                 => 'backend/images/uniqueFeatures/family.jpg',
                'experience'            => 9,
                'happy_travelers'       => 2500,
                'number_of_destination' => 60,
                'created_at'            => now(),
                'updated_at'            => now(),
            ],
            [
                'header'                => 'Eco Travel',
                'title'                 => 'Sustainable travel that protects our planet',
                'image'                 => 'uploads/unique-features/eco.jpg',
                'experience'            => 7,
                'happy_travelers'       => 2000,
                'number_of_destination' => 50,
                'created_at'            => now(),
                'updated_at'            => now(),
            ],
        ];

        UniqueFeatures::insert($features);
    }
}
