<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SystemSetting;
use App\Models\Topic;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\OurStorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(WhyTravelWithUsSeeder::class);
        $this->call(SinglePageBannerSeeder::class);
        $this->call(HomeBannerSeeder::class);
        $this->call(OurStorySeeder::class);
        $this->call(HomeTourSeeder::class);
        $this->call(TravelAdvisorSeeder::class);
        $this->call(SeoTitleSeeder::class);
        $this->call(DestinationWeCoverSeeder::class);
        $this->call(HomeExperienceSectionImagesSeeder::class);
        $this->call(UniqueFeaturesSeeder::class);
        $this->call(DynamicTripButtonSeeder::class);
        $this->call(OurMissionSeeder::class);
        $this->call(ResponsibleTravelSeeder::class);
        $this->call(RatingSeeder::class);
        $this->call(PeopleBehindTripSeeder::class);
        $this->call(GallerySeeder::class);

        Category::insert([
            [
                'name'     => 'Uncategorized',
                'slug'     => 'uncategorized',
                'priority' => 0,
                'image'    => 'default.jpg',
            ]
        ]);

        SystemSetting::create([
            'system_title'         => 'My System',
            'system_short_title'   => 'MS',
            'company_name'         => 'My Company',
            'tag_line'             => 'Your tagline here',
            'phone_code'           => '+1',
            'phone_number'         => '1234567890',
            'whatsapp'             => '1234567890',
            'email'                => 'info@example.com',
            'time_zone'            => 'UTC',
            'language'             => 'en',
            'admin_title'          => 'Admin Panel',
            'admin_short_title'    => 'AP',
            'copyright_text'       => '© 2025 My Company. All rights reserved.',
            'admin_copyright_text' => '© 2025 My Company. All rights reserved.',
        ]);
    }
}
