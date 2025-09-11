<?php
namespace Database\Seeders;

use App\Models\DestinationWeCover;
use Illuminate\Database\Seeder;

class DestinationWeCoverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'title'   => 'Polar Regions',
                'image'   => '',
                'url'     => 'https://www.figma.com/design/jRViK8eQdJJA02sF6A3f77/laurensw2025-%7C%7C-Wix_Buddy-%7C%7C-FO52159940A05?node-id=17-3796&p=f&t=2bWYCnRBlJJFUDhc-0',
                'alt_tag' => 'meta1',
            ],
            [
                'title'   => 'Forests',
                'image'   => '',
                'url'     => 'https://www.figma.com/design/jRViK8eQdJJA02sF6A3f77/laurensw2025-%7C%7C-Wix_Buddy-%7C%7C-FO52159940A05?node-id=17-3796&p=f&t=2bWYCnRBlJJFUDhc-0',
                'alt_tag' => 'meta2',
            ],
            [
                'title'   => 'Mountains & Deserts',
                'image'   => '',
                'url'     => 'https://www.figma.com/design/jRViK8eQdJJA02sF6A3f77/laurensw2025-%7C%7C-Wix_Buddy-%7C%7C-FO52159940A05?node-id=17-3796&p=f&t=2bWYCnRBlJJFUDhc-0',
                'alt_tag' => 'meta3',
            ],
        ];

        foreach ($data as $item) {
            DestinationWeCover::updateOrCreate(
                ['title' => $item['title']], // search condition
                $item                        // fields to update/insert
            );
        }

    }
}
