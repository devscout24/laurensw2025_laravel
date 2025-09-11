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
                'image'   => '',
                'alt_tag' => 'meta1',
            ],
            [
                'image'   => '',
                'alt_tag' => 'meta2',
            ],
            [
                'image'   => '',
                'alt_tag' => 'meta3',
            ],
            [
                'image'   => '',
                'alt_tag' => 'meta4',
            ],
            [
                'image'   => '',
                'alt_tag' => 'meta5',
            ],
            [
                'image'   => '',
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
