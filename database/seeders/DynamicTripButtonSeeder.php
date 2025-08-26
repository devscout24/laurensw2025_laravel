<?php

namespace Database\Seeders;

use App\Models\DynamicTripButton;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DynamicTripButtonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $buttons = [
            [
                'name'       => 'Antarctic Tour',
                'link'       => '/antarctic-trip',
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Arctic Tour',
                'link'       => '/arctic-trip',
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Mountain Tour',
                'link'       => '/mountain-trip',
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DynamicTripButton::insert($buttons);
    }
}
