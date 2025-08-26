<?php

namespace Database\Seeders;

use App\Models\ResponsibleTravel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResponsibleTravelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'header'      => 'Empowering Travelers',
                'image'       => 'uploads/our_mission/mission1.jpg',
                'description' => 'We provide curated travel experiences, focusing on safety, comfort, and unforgettable memories.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'header'      => 'Empowering Traveler',
                'image'       => 'uploads/our_mission/mission2.jpg',
                'description' => 'We provide curated travel experiences, focusing on safety, comfort, and unforgettable memories.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ];

        ResponsibleTravel::insert($data);
    }
}
