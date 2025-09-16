<?php
namespace Database\Seeders;

use App\Models\TranslateApi;
use Illuminate\Database\Seeder;

class TranslateApiSeeder extends Seeder
{
    public function run(): void
    {
        TranslateApi::updateOrCreate(
            ['key' => 'google_translate_key'],
            ['value' => env('GOOGLE_TRANSLATE_KEY')]
        );
    }
}
