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
            ],
            [
                'header'      => 'Empowering Traveler',
                'image'       => 'uploads/our_mission/mission2.jpg',
                'description' => 'We provide curated travel experiences, focusing on safety, comfort, and unforgettable memories.',
            ],
        ];

        foreach ($data as $item) {

            $exists = ResponsibleTravel::where('header', $item['header'])->first();

            if (!$exists) {
                ResponsibleTravel::create([
                    'header'      => $item['header'],
                    'image'       => $item['image'],
                    'description' => $item['description'],
                ]);
            }
        }
    }
}
