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
                'title'         => 'Empowering Travelers 1',
                'description'   => 'Description 1',
                'language_code' => 'EN',
            ],
            [
                'title'         => 'Empowering Travelers 2',
                'description'   => 'Description 2',
                'language_code' => 'EN',
            ],
            [
                'title'         => 'Empowering Travelers 3',
                'description'   => 'Description 3',
                'language_code' => 'EN',
            ],
            [
                'title'         => 'Empowering Travelers 4',
                'description'   => 'Description 1',
                'language_code' => 'NL',
            ],
            [
                'title'         => 'Empowering Travelers 5',
                'description'   => 'Description 2',
                'language_code' => 'NL',
            ],
            [
                'title'         => 'Empowering Travelers 6',
                'description'   => 'Description 3',
                'language_code' => 'NL',
            ],
        ];

        foreach ($data as $item) {
            $exists = SeoTitle::where('title', $item['title'])->first();

            if (! $exists) {
                SeoTitle::create([
                    'title'         => $item['title'],
                    'description'   => $item['description'],
                    'language_code' => $item['language_code'],
                ]);
            }
        }
    }
}
