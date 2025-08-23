<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SinglePageBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = [];

        for ($i = 1; $i <= 12; $i++) {
            $banners[] = [
                'title'      => "Banner $i",
                'image'      => "backend/images/singlePageBanner/banner.jpg", // adjust path as per your storage setup
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('single_page_banners')->insert($banners);
    }
}
