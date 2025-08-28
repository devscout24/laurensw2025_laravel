<?php
namespace Database\Seeders;

use App\Models\ResponsibleTravel;
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
                'heading'     => 'Carbon Nutral',
                'image'       => 'uploads/our_mission/mission1.jpg',
                'description' => 'We provide curated travel experiences, focusing on safety, comfort, and unforgettable memories.',
            ],
            [
                'heading'     => 'Community Support',
                'image'       => 'uploads/our_mission/mission2.jpg',
                'description' => 'We provide curated travel experiences, focusing on safety, comfort, and unforgettable memories.',
            ],
            [
                'heading'     => 'Conservation Focus',
                'image'       => 'uploads/our_mission/mission2.jpg',
                'description' => 'We provide curated travel experiences, focusing on safety, comfort, and unforgettable memories.',
            ],
        ];

        foreach ($data as $item) {

            $exists = ResponsibleTravel::where('heading', $item['heading'])->first();

            if (! $exists) {
                ResponsibleTravel::create([
                    'heading'     => $item['heading'],
                    'image'       => $item['image'],
                    'description' => $item['description'],
                ]);
            }
        }
    }
}
