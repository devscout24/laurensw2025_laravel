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
                'heading'               => 'Explore the World',
                'description'           => 'Discover new destinations with our expert guides',
                'image'                 => 'backend/images/uniqueFeatures/world.jpg',
                'created_at'            => now(),
                'updated_at'            => now(),
            ],
            [
                'heading'               => 'Luxury Stays',
                'description'           => 'Enjoy comfort with handpicked hotels and resorts',
                'image'                 => 'backend/images/uniqueFeatures/luxury.jpg',
                'created_at'            => now(),
                'updated_at'            => now(),
            ],
            [
                'heading'               => 'Adventure Awaits',
                'description'           => 'Thrilling adventures tailored just for you',
                'image'                 => 'backend/images/uniqueFeatures/adventure.jpg',
                'created_at'            => now(),
                'updated_at'            => now(),
            ],
            [
                'heading'               => 'Cultural Tours',
                'description'           => 'Immerse yourself in rich history and traditions',
                'image'                 => 'backend/images/uniqueFeatures/culture.jpg',
                'created_at'            => now(),
                'updated_at'            => now(),
            ],
            [
                'heading'               => 'Family Friendly',
                'description'           => 'Trips designed for families and children',
                'image'                 => 'backend/images/uniqueFeatures/family.jpg',
                'created_at'            => now(),
                'updated_at'            => now(),
            ],
            [
                'heading'               => 'Eco Travel',
                'description'           => 'Sustainable travel that protects our planet',
                'image'                 => 'uploads/unique-features/eco.jpg',
                'created_at'            => now(),
                'updated_at'            => now(),
            ],
        ];

        UniqueFeatures::insert($features);
    }
}
