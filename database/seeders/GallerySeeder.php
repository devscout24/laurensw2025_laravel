<?php
namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'image'   => 'uploads/our_mission/mission1.jpg',
                'alt_tag' => 'meta1',
            ],
            [
                'image'   => 'uploads/our_mission/mission2.jpg',
                'alt_tag' => 'meta2',
            ],
            [
                'image'   => 'uploads/our_mission/mission3.jpg',
                'alt_tag' => 'meta3',
            ],
            [
                'image'   => 'uploads/our_mission/mission4.jpg',
                'alt_tag' => 'meta4',
            ],
            [
                'image'   => 'uploads/our_mission/mission5.jpg',
                'alt_tag' => 'meta5',
            ],
            [
                'image'   => 'uploads/our_mission/mission6.jpg',
                'alt_tag' => 'meta6',
            ],
        ];

        // foreach ($data as $item) {

        //     $exists = Gallery::where('image', $item['image'])->first();

        //     if (! $exists) {
        //         Gallery::create([
        //             'image' => $item['image'],
        //         ]);
        //     }
        // }

        if (Gallery::count() < 6) {
            foreach ($data as $item) {
                Gallery::updateOrCreate(
                    ['image' => $item['image']], // check by image
                    ['image' => $item['image']]
                );
            }
        }
    }
}
