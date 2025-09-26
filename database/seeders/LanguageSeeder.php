<?php
namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'English',
                'code' => 'EN',
            ],
            [
                'name' => 'Dutch',
                'code' => 'NL',
            ],
        ];

        foreach ($data as $item) {
            Language::updateOrInsert(
                ['code' => $item['code']], // match by code (unique)
                [
                    'name'       => $item['name'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
