<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WhyTravelWithUs;

class WhyTravelWithUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'header'       => 'All Inclusive',
                'title'        => null,
                'description1' => 'All park entrance fees included',
                'description2' => 'Daily breakfast, lunch & dinner',
                'description3' => 'Airport transfers both ways',
                'description4' => 'Professional guide throughout trip',
            ],
            [
                'header'       => 'Premium Services',
                'title'        => 'Everything You need for the perfect trip',
                'description1' => 'Small group of max 12 travelers',
                'description2' => 'Professional photography assistance',
                'description3' => 'Personal species identification logs',
                'description4' => 'Expert nature guides with 10+ years of experiences',
            ],
        ];


        foreach ($data as $item) {

            $exists = WhyTravelWithUs::where('header', $item['header'])->first();

            if (!$exists) {
                WhyTravelWithUs::updateOrCreate([
                    'header'          => $item['header'],
                    'title'           => $item['title'],
                    'description1'    => $item['description1'],
                    'description2'    => $item['description2'],
                    'description3'    => $item['description3'],
                    'description4'    => $item['description4'],
                ]);
            }
        }
    }
}
