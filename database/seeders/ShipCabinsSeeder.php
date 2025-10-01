<?php
namespace Database\Seeders;

use App\Models\ShipCabins;
use Illuminate\Database\Seeder;

class ShipCabinsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cabins = [
            [
                'shipview_id' => 1,
                'cabin_type'  => 'oceanview',
                'description' => 'Spacious ocean view cabin',
                'image'       => null,
            ],
            [
                'shipview_id' => 1,
                'cabin_type'  => 'balcony',
                'description' => 'Balcony cabin with sea view',
                'image'       => null,
            ],
            [
                'shipview_id' => 2,
                'cabin_type'  => 'interior',
                'description' => 'Cozy interior cabin',
                'image'       => null,
            ],
        ];

        foreach ($cabins as $cabin) {
            ShipCabins::firstOrCreate([
                'shipview_id' => $cabin['shipview_id'],
                'cabin_type'  => $cabin['cabin_type'],
            ], $cabin);
        }
    }
}
