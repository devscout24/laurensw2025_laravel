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
            ['value' => 'AIzaSyDVo8a3VnaSBE7OxRUe0pRQZdzRwESfQBQ']
            // ['value' => env('GOOGLE_TRANSLATE_KEY')]
        );
    }
}
