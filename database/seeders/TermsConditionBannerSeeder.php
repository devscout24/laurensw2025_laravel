<?php
namespace Database\Seeders;

use App\Models\TermsConditionBanner;
use Illuminate\Database\Seeder;

class TermsConditionBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'header'     => 'Welcome to Our Travel World',
            'image'      => '',
            'alt_tag'    => 'meta',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Always keep only one record
        TermsConditionBanner::updateOrCreate(
            ['id' => 1],
            $data
        );
    }
}
