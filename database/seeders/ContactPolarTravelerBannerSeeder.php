<?php
namespace Database\Seeders;

use App\Models\ContactPolarTravelerBanner;
use Illuminate\Database\Seeder;

class ContactPolarTravelerBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'header'     => 'Welcome to Our Travel World',
            'title'      => 'Explore the most beautiful destinations with comfort and joy',
            'image'      => 'backend/images/homeBanner.jpg',
            'alt_tag'    => 'meta',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Always keep only one record
        ContactPolarTravelerBanner::updateOrCreate(
            ['id' => 1],
            $data
        );
    }
}
