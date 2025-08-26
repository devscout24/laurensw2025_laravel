<?php

namespace Database\Seeders;

use App\Models\OurMission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OurMissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $missions = [
            [
                'header'      => 'Empowering Travelers',
                'title'       => 'Our Commitment to Safe and Memorable Journeys',
                'description' => 'We provide curated travel experiences, focusing on safety, comfort, and unforgettable memories.',
                'image_1'     => 'uploads/our_mission/mission1.jpg',
                'image_2'     => 'uploads/our_mission/mission2.jpg',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ];

        OurMission::insert($missions);
    }
}
