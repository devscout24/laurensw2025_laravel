<?php
namespace Database\Seeders;

use App\Models\SeoTitle;
use Illuminate\Database\Seeder;

class SeoTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'title'       => 'Arctic Cruise',
                'description' => 'Description 1',
                'lang_id'     => '1',
            ],
            [
                'title'       => 'Expedition Antarctica',
                'description' => 'Description 2',
                'lang_id'     => '1',
            ],
            [
                'title'       => 'Cruise Svalbard',
                'description' => 'Description 3',
                'lang_id'     => '1',
            ],
            [
                'title'       => 'Cruise Greenland',
                'description' => 'Description 4',
                'lang_id'     => '1',
            ],
            [
                'title'       => 'Arctic Cruise Dutch',
                'description' => 'Beschrijving 1',
                'lang_id'     => '2',
            ],
            [
                'title'       => 'Expedition Antarctica Dutch',
                'description' => 'Beschrijving 2',
                'lang_id'     => '2',
            ],
            [
                'title'       => 'Cruise Svalbard Dutch',
                'description' => 'Beschrijving 3',
                'lang_id'     => '2',
            ],
            [
                'title'       => 'Cruise Greenland Dutch',
                'description' => 'Beschrijving 4',
                'lang_id'     => '2',
            ],
        ];

        foreach ($data as $item) {
            $exists = SeoTitle::where('title', $item['title'])->first();

            if (! $exists) {
                SeoTitle::create([
                    'title'       => $item['title'],
                    'description' => $item['description'],
                    'lang_id'     => $item['lang_id'],
                ]);
            }
        }
    }
}
