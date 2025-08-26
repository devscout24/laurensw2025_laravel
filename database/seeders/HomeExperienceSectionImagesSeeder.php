<?php

namespace Database\Seeders;

use App\Models\HomeExperienceSectionImages;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HomeExperienceSectionImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name'       => 'Beach',
                'image'      => 'backend/images/homeExperienceSection/beach.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Mountain',
                'image'      => 'backend/images/homeExperienceSection/mountain.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'City',
                'image'      => 'backend/images/homeExperienceSection/city.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Safari',
                'image'      => 'backend/images/homeExperienceSection/safari.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Cruise',
                'image'      => 'backend/images/homeExperienceSection/cruise.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Adventure',
                'image'      => 'backend/images/homeExperienceSection/adventure.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($data as $row) {
            HomeExperienceSectionImages::updateOrCreate(
                ['name' => $row['name']], // unique field to check
                $row
            );
        }
    }
}
