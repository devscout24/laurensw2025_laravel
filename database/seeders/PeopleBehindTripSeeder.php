<?php

namespace Database\Seeders;

use App\Models\PeopleBehindTrip;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeopleBehindTripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $people = [
            [
                'name'        => 'John Doe',
                'designation' => 'Founder & CEO',
                'image'       => 'uploads/people/john_doe.jpg',
                'description' => 'Visionary leader with a passion for creating unforgettable travel experiences.',
                'alt_tag'     => 'meta1',
            ],
            [
                'name'        => 'Jane Smith',
                'designation' => 'Operations Manager',
                'image'       => 'uploads/people/jane_smith.jpg',
                'description' => 'Ensures smooth operations and seamless coordination for every trip.',
                'alt_tag'     => 'meta2',
            ],
            [
                'name'        => 'Michael Johnson',
                'designation' => 'Travel Guide',
                'image'       => 'uploads/people/michael_johnson.jpg',
                'description' => 'Expert travel guide with years of experience in delivering enriching journeys.',
                'alt_tag'     => 'meta3',
            ],
        ];

        foreach ($people as $person) {
            PeopleBehindTrip::updateOrCreate(
                ['name' => $person['name']],
                $person // update or create
            );
        }
    }
}
