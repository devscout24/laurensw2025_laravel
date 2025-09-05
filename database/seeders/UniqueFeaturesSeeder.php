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
                'heading'               => 'Authentic Adventures',
                'description'           => 'Discover new destinations with our expert guides',
                'image'                 => 'backend/images/uniqueFeatures/world.jpg',
                'alt_tag'               => 'meta1',
                'created_at'            => now(),
                'updated_at'            => now(),
            ],
            [
                'heading'               => 'Nature First',
                'description'           => 'Enjoy comfort with handpicked hotels and resorts',
                'image'                 => 'backend/images/uniqueFeatures/luxury.jpg',
                'alt_tag'               => 'meta2',
                'created_at'            => now(),
                'updated_at'            => now(),
            ],
            [
                'heading'               => 'Expert Guides',
                'description'           => 'Thrilling adventures tailored just for you',
                'image'                 => 'backend/images/uniqueFeatures/adventure.jpg',
                'alt_tag'               => 'meta3',
                'created_at'            => now(),
                'updated_at'            => now(),
            ],
        ];

        UniqueFeatures::insert($features);
    }
}
