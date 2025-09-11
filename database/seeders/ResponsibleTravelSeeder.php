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
                'image'       => '',
                'description' => 'We provide curated travel experiences, focusing on safety, comfort, and unforgettable memories.',
                'alt_tag'     => 'meta1',
            ],
            [
                'heading'     => 'Community Support',
                'image'       => '',
                'description' => 'We provide curated travel experiences, focusing on safety, comfort, and unforgettable memories.',
                'alt_tag'     => 'meta2',
            ],
            [
                'heading'     => 'Conservation Focus',
                'image'       => '',
                'description' => 'We provide curated travel experiences, focusing on safety, comfort, and unforgettable memories.',
                'alt_tag'     => 'meta3',
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
