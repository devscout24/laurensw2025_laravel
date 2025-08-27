<?php

namespace Database\Seeders;

use App\Models\BookingTrip;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingTripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'trip_date'              => '2025-09-15',
                'trip_id'                => 'TRIP-00001',
                'name'                   => 'John',
                'surname'                => 'Doe',
                'date_of_birth'          => '1990-05-20',
                'mobile'                 => '+1234567890',
                'email'                  => 'john.doe@example.com',
                'street_house_number'    => '123 Main St',
                'country'                => 'USA',
                'post_code'              => '10001',
                'city_place_name'        => 'New York',
                'stay_at_home_contact'   => 'Jane Doe',
                'contact_no_home_caller' => '+1098765432',
                'room_category_id'       => 1,
                'policy_number'          => 'POL123456',
                'insured_at'             => 'ABC Insurance',
                'additional_note'        => 'First trip booking',
                'created_at'             => now(),
                'updated_at'             => now(),
            ],
            [
                'trip_date'              => '2025-10-05',
                'trip_id'                => 'TRIP-00002',
                'name'                   => 'Alice',
                'surname'                => 'Smith',
                'date_of_birth'          => '1985-11-12',
                'mobile'                 => '+1987654321',
                'email'                  => 'alice.smith@example.com',
                'street_house_number'    => '45 Park Ave',
                'country'                => 'UK',
                'post_code'              => 'SW1A 1AA',
                'city_place_name'        => 'London',
                'stay_at_home_contact'   => 'Bob Smith',
                'contact_no_home_caller' => '+44123456789',
                'room_category_id'       => 2,
                'policy_number'          => 'POL789012',
                'insured_at'             => 'XYZ Insurance',
                'additional_note'        => 'Special request for window seat',
                'created_at'             => now(),
                'updated_at'             => now(),
            ],
        ];

        BookingTrip::insert($data);
    }
}
