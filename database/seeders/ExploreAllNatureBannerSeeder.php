<?php
namespace Database\Seeders;

use App\Models\ExploreAllNatureBanner;
use Illuminate\Database\Seeder;

class ExploreAllNatureBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'header'     => 'Welcome to Our Travel World',
            'title'      => 'Explore the most beautiful destinations with comfort and joy',
            'image'      => 'backend/images/homeBanner.jpg',
            'alt_tag'    => 'meta',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Always keep only one record
        ExploreAllNatureBanner::updateOrCreate(
            ['id' => 1],
            $data
        );
    }
}
