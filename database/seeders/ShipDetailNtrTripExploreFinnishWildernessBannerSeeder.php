<?php
namespace Database\Seeders;

use App\Models\ShipDetailNtrTripExploreFinnishWildernessBanner;
use Illuminate\Database\Seeder;

class ShipDetailNtrTripExploreFinnishWildernessBannerSeeder extends Seeder
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
        ShipDetailNtrTripExploreFinnishWildernessBanner::updateOrCreate(
            ['id' => 1],
            $data
        );
    }
}
