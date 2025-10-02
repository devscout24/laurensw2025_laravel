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
                'title'       => 'Empowering Travelers 1',
                'description' => 'Description 1',
                'lang_id'     => '1',
            ],
            [
                'title'       => 'Empowering Travelers 2',
                'description' => 'Description 2',
                'lang_id'     => '1',
            ],
            [
                'title'       => 'Empowering Travelers 3',
                'description' => 'Description 3',
                'lang_id'     => '1',
            ],
            [
                'title'       => 'Empowering Travelers 4',
                'description' => 'Description 1',
                'lang_id'     => '2',
            ],
            [
                'title'       => 'Empowering Travelers 5',
                'description' => 'Description 2',
                'lang_id'     => '2',
            ],
            [
                'title'       => 'Empowering Travelers 6',
                'description' => 'Description 3',
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
