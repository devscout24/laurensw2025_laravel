<?php

namespace Database\Seeders;

use App\Models\DynamicTripButton;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DynamicTripButtonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $buttons = [
            [
                'name'       => 'Book Now',
                'link'       => '/book-trip',
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'View Packages',
                'link'       => '/packages',
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Get Quote',
                'link'       => '/get-quote',
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Contact Us',
                'link'       => '/contact',
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Explore Destinations',
                'link'       => '/destinations',
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Special Offers',
                'link'       => '/offers',
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DynamicTripButton::insert($buttons);
    }
}
