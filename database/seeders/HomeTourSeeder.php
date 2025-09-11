<?php
namespace Database\Seeders;

use App\Models\HomeTour;
use Illuminate\Database\Seeder;

class HomeTourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            [
                'label'      => 'Label',
                'header'     => 'Exotic Bali Escape',
                'title'      => 'Experience the serene beaches, vibrant culture, and lush rice terraces of Bali.',
                'image'      => '',
                'duration'   => '7 Days / 6 Nights',
                'ship'       => 'Luxury Cruise',
                'price'      => 1299.99,
                'alt_tag'    => 'meta1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'label'      => 'Label',
                'header'     => 'Mediterranean Cruise',
                'title'      => 'Sail across Italy, Greece, and Spain with comfort and elegance.',
                'image'      => '',
                'duration'   => '10 Days / 9 Nights',
                'ship'       => 'Royal Voyager',
                'price'      => 2599.50,
                'alt_tag'    => 'meta2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'label'      => 'Label',
                'header'     => 'Alaskan Adventure',
                'title'      => 'Discover glaciers, wildlife, and breathtaking landscapes in Alaska.',
                'image'      => '',
                'duration'   => '8 Days / 7 Nights',
                'ship'       => 'Glacier Explorer',
                'price'      => 1899.00,
                'alt_tag'    => 'meta3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'label'      => 'Label',
                'header'     => 'Turkish Adventure',
                'title'      => 'Discover glaciers, wildlife, and breathtaking landscapes in Alaska.',
                'image'      => '',
                'duration'   => '8 Days / 7 Nights',
                'ship'       => 'Glacier Explorer',
                'price'      => 1899.00,
                'alt_tag'    => 'meta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        HomeTour::insert($features);
    }
}
