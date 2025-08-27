<?php
namespace Database\Seeders;

use App\Models\DynamicTripButton;
use Illuminate\Database\Seeder;

class DynamicTripButtonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'button_name' => 'Antarctic Tour',
                'trip_url'    => '/antarctic-trip',
                'trip_id'     => 1,
            ],
            [
                'button_name' => 'Arctic Tour',
                'trip_url'    => '/arctic-trip',
                'trip_id'     => 2,
            ],
            [
                'button_name' => 'Mountain Tour',
                'trip_url'    => '/mountain-trip',
                'trip_id'     => 3,
            ],
        ];

        if (DynamicTripButton::count() > 0) {

            DynamicTripButton::truncate();
            foreach ($data as $item) {
                DynamicTripButton::updateOrCreate(
                    ['trip_id' => $item['trip_id']],
                    [
                        'button_name' => $item['button_name'],
                        'trip_url'    => $item['trip_url'],
                    ]
                );
            }
        }

    }
}
