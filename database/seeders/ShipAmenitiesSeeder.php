<?php
namespace Database\Seeders;

use App\Models\ShipAmenities;
use Illuminate\Database\Seeder;

class ShipAmenitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $amenities = [
            [
                'shipview_id' => 1,
                'amenities'   => 'WiFi Pool',
                'image'       => 'amenities/wifi_pool.jpg',
            ],
            [
                'shipview_id' => 1,
                'amenities'   => 'Bar & Lounge',
                'image'       => 'amenities/bar_lounge.jpg',
            ],
            [
                'shipview_id' => 2,
                'amenities'   => 'WiFi Spa',
                'image'       => 'amenities/wifi_spa.jpg',
            ],
        ];

        foreach ($amenities as $amenity) {
            ShipAmenities::firstOrCreate([
                'shipview_id' => $amenity['shipview_id'],
                'amenities'   => $amenity['amenities'],
            ], $amenity);
        }
    }
}
