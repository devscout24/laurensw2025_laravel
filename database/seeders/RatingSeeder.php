<?php

namespace Database\Seeders;

use App\Models\Rating;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name'        => 'John Doe',
                'designation' => 'Traveler',
                'image'       => '',
                'description' => 'Amazing experience! The trip was well organized, safe, and enjoyable. Highly recommended!',
                'rating'      => 4.8,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Alice Smith',
                'designation' => 'Businesswoman',
                'image'       => '',
                'description' => 'Great service and very professional staff. My journey was smooth and hassle-free.',
                'rating'      => 5.0,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Michael Brown',
                'designation' => 'Photographer',
                'image'       => '',
                'description' => 'Loved every part of the trip. Perfect balance of relaxation and adventure.',
                'rating'      => 4.5,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Sophia Johnson',
                'designation' => 'Student',
                'image'       => '',
                'description' => 'Affordable and convenient. I will definitely book again!',
                'rating'      => 4.2,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ];

        Rating::insert($data);
    }
}
