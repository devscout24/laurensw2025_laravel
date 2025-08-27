<?php

namespace Database\Seeders;

use App\Models\TravelAdvisor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TravelAdvisorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name'                => 'John Doe',
                'designation'         => 'Doctor',
                'experience'          => '15',
                'trip_success'        => '50',
                'whatsapp'            => '01612151665',
                'image'               => 'backend/images/travelAdvisor/1755819336.jpg',
                'created_at'          => now(),
                'updated_at'          => now(),
            ],
            [
                'name'                => 'Alice ',
                'designation'         => 'Engineer',
                'experience'          => '15',
                'trip_success'        => '55',
                'whatsapp'            => '01612151615',
                'image'               => 'backend/images/travelAdvisor/1755819336.jpg',
                'created_at'          => now(),
                'updated_at'          => now(),
            ],
        ];

        TravelAdvisor::insert($data);
    }
}
