<?php
namespace Database\Seeders;

use App\Models\ShipView;
use Illuminate\Database\Seeder;

class ShipViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ships = [
            [
                'name'          => 'Luxury Explorer',
                'description'   => 'A luxury yacht for the ultimate experience.',
                'build_year'    => 2020,
                'crew_number'   => 10,
                'max_guests'    => 20,
                'length'        => 35,
                'zodiac_boats'  => 'Dolorum optio odio voluptas.',
                'capacity'      => 50,
                'comfort_level' => 'standard',
                'price'         => 5000,
                'image'         => 'ships/luxury_explorer.jpg',
            ],
            [
                'name'          => 'Ocean Voyager',
                'description'   => 'Perfect for ocean adventures and sightseeing.',
                'build_year'    => 2018,
                'crew_number'   => 8,
                'max_guests'    => 18,
                'length'        => 30,
                'zodiac_boats'  => 'Dolorum optio odio voluptas.',
                'capacity'      => 40,
                'comfort_level' => 'standard',
                'price'         => 4000,
                'image'         => 'ships/ocean_voyager.jpg',
            ],
            [
                'name'          => 'Sea Breeze',
                'description'   => 'Comfortable yacht ideal for family trips.',
                'build_year'    => 2019,
                'crew_number'   => 7,
                'max_guests'    => 16,
                'length'        => 28,
                'zodiac_boats'  => 'Dolorum optio odio voluptas.',
                'capacity'      => 35,
                'comfort_level' => 'luxary',
                'price'         => 3500,
                'image'         => 'ships/sea_breeze.jpg',
            ],
        ];

        foreach ($ships as $ship) {
            ShipView::firstOrCreate(['name' => $ship['name']], $ship);
        }
    }
}
