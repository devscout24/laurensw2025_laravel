<?php

namespace Database\Seeders;

use App\Models\HomeTour;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HomeTourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            [
                'header'       => 'Exotic Bali Escape',
                'title'        => 'Experience the serene beaches, vibrant culture, and lush rice terraces of Bali.',
                'image'        => 'uploads/home_tours/bali.jpg',
                'duration'     => '7 Days / 6 Nights',
                'ship'         => 'Luxury Cruise',
                'price'        => 1299.99,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'header'       => 'Mediterranean Cruise',
                'title'        => 'Sail across Italy, Greece, and Spain with comfort and elegance.',
                'image'        => 'uploads/home_tours/mediterranean.jpg',
                'duration'     => '10 Days / 9 Nights',
                'ship'         => 'Royal Voyager',
                'price'        => 2599.50,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'header'       => 'Alaskan Adventure',
                'title'        => 'Discover glaciers, wildlife, and breathtaking landscapes in Alaska.',
                'image'        => 'uploads/home_tours/alaska.jpg',
                'duration'     => '8 Days / 7 Nights',
                'ship'         => 'Glacier Explorer',
                'price'        => 1899.00,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ];

        HomeTour::insert($features);
    }
}
