<?php

namespace Database\Seeders;

use App\Models\SeoTitle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            ],
            [
                'title'        => 'Empowering Travelers 2',
                'description'  => 'Description 2',
            ],
            [
                'title'        => 'Empowering Travelers 3',
                'description'  => 'Description 3',
            ],
        ];

        foreach ($data as $item) {

            $exists = SeoTitle::where('title', $item['title'])->first();

            if (!$exists) {
                SeoTitle::create([
                    'title'          => $item['title'],
                    'description'    => $item['description'],
                ]);
            }
        }
    }
}
