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
                'image' => 'uploads/our_mission/mission1.jpg',
            ],
            [
                'image' => 'uploads/our_mission/mission2.jpg',
            ],
            [
                'image' => 'uploads/our_mission/mission3.jpg',
            ],
            [
                'image' => 'uploads/our_mission/mission4.jpg',
            ],
            [
                'image' => 'uploads/our_mission/mission5.jpg',
            ],
            [
                'image' => 'uploads/our_mission/mission6.jpg',
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
