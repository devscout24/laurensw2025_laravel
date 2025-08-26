<?php

namespace Database\Seeders;

use App\Models\OurStory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OurStorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $story = [
            [
                'header'      => 'Empowering Travelers',
                'title'       => 'Our Commitment to Safe and Memorable Journeys',
                'description' => 'We provide curated travel experiences, focusing on safety, comfort, and unforgettable memories.',
                'image'       => 'uploads/our_mission/mission1.jpg',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ];

        OurStory::insert($story);
    }
}
