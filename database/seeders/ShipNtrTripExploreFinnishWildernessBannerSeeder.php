<?php
namespace Database\Seeders;

use App\Models\ShipNtrTripExploreFinnishWildernessBanner;
use Illuminate\Database\Seeder;

class ShipNtrTripExploreFinnishWildernessBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'header'     => 'Welcome to Our Travel World',
            'image'      => 'backend/images/Banner.jpg',
            'alt_tag'    => 'meta',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Always keep only one record
        ShipNtrTripExploreFinnishWildernessBanner::updateOrCreate(
            ['id' => 1],
            $data
        );
    }
}
