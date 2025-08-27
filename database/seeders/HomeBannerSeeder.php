<?php
namespace Database\Seeders;

use App\Models\HomeBanner;
use Illuminate\Database\Seeder;

class HomeBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'header'                => 'Welcome to Our Travel World',
            'title'                 => 'Explore the most beautiful destinations with comfort and joy',
            'image'                 => 'backend/images/homeBanner.jpg', // make sure this exists
            'experience'            => 10,
            'happy_travelers'       => 5000,
            'number_of_destination' => 150,
            'created_at'            => now(),
            'updated_at'            => now(),
        ];

        // Always keep only one record
        HomeBanner::updateOrCreate(
            ['id' => 1], // condition → force to always update/create only 1 row
            $data
        );

    }
}
